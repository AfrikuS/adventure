<?php
// web/index.php
use Domain\GarageUpgrade;
use Domain\Laboratory\ConverterResources;
use Business\ResourceLocation;
use Ctrl\ApiCtrl;
use Ctrl\AuctionCtrl;
use Ctrl\GameCtrl;
use Ctrl\GarageCtrl;
use Ctrl\NormalBossCtrl;
use Ctrl\UserCtrl;
use Ctrl\VillageCtrl;
use Entity\AuctionLot;
use Entity\BossAttack;
use Entity\BossTimer;
use Entity\Database;
use Entity\MassTimer;
use Entity\MassWork;
use Entity\Podzemka;
use Entity\Quest;
use Entity\Resources;
use Entity\SewStudio;
use Entity\Thing;
use Entity\Timer;
use Entity\User;
use Entity\Vehicle;
use MessageQueue\JobCreator;
use Middleware\Auth;
use Middleware\RedirectOnActiveActionPage;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use State\StateBoss;
use State\StateOilMass;
use State\StatePodzemka;
use State\StateQuest;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Entity\Action;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use User\Authorize;
use User\SymfonySecurity;

require_once __DIR__.'/../vendor/autoload.php';




// set the error handling
ini_set('display_errors', 1);
error_reporting(-1);
ErrorHandler::register();
if ('cli' !== php_sapi_name()) {
    ExceptionHandler::register();
}

$app = new Silex\Application();
$app['debug'] = true;
$app->register(new TwigServiceProvider(), [
    'twig.path' => __DIR__.'/views/twig/',
]);
$app->register(new UrlGeneratorServiceProvider()); // for url aliases
$app->register(new SessionServiceProvider());


//if (null !== $app['user'] = $app['session']->get('user')) {
//
//}



$app->get('/', function () use ($app) {

    return $app['twig']->render('index.twig', []);
});


$app->get('/timers', function () use ($app) {
    $timers = Timer::getAllActiveTimers();

    return $app['twig']->render('timers.twig', [
        'timers'     => $timers,
    ]);
});

$app->get('/dozor', function () use ($app) {
    $userId = Authorize::getSessionUserId($app);

    $timer = Timer::getTimer('dozor', $userId);

    if ($timer) {
        if ($timer->get('status_int') <= 0) {
            Timer::delete($timer->get('id'));
            ResourceLocation::dozorGold($userId);
            $timer = false;
        }
    }

    $resources = Resources::getResourcesByUserId($userId);
    return $app['twig']->render('dozor.twig', [
        'resources' => $resources,
        'timer' => $timer,
    ]);
})->bind('dozor');
$app->post('/dozor', function () use ($app) {
    $userId = Authorize::getSessionUserId($app);

    Timer::addTimer('dozor', $userId);

    return $app->redirect('/dozor');
});






$app->get('/bodalka', function () use ($app) {
    $userId = Authorize::getSessionUserId($app);

    $timer = Timer::getTimer('bodalka', $userId);

    if ($timer) {
        if ($timer->get('status_int') <= 0) {
            Timer::delete($timer->get('id'));
            $timer = false; // чтобы на сттанице условие работало верно
            ResourceLocation::bodalkaEnd($userId);
        }
    }

    $resources = Resources::getResourcesByUserId($userId);
    return $app['twig']->render('bodalka.twig', [
        'resources' => $resources,
        'timer'  => $timer,
    ]);
});
$app->post('/bodalka', function () use ($app) {
    $userId = Authorize::getSessionUserId($app);
    Timer::addTimer('bodalka', $userId);
    return $app->redirect('/bodalka');
});


$app->get('/oil_hole', function () use ($app) {
    $userId = Authorize::getSessionUserId($app);

    $timer = Timer::getTimer('oil_hole', $userId);

    if ($timer) {
        if ($timer->get('status_int') <= 0) {
            Timer::delete($timer->get('id'));
            ResourceLocation::oilHolePump($userId);
        }
    }

    $resources = Resources::getResourcesByUserId($userId);
    return $app['twig']->render('oil_hole.twig', [
        'resources' => $resources,
        'timer' => $timer,
    ]);
});
$app->post('/oil_hole', function () use ($app) {
    $userId = Authorize::getSessionUserId($app);

    Timer::addTimer('oil_hole', $userId);
    return $app->redirect('/oil_hole');
});

$app->get('/quest', function () use ($app) {
//    $userId = Authorize::getSessionUserId($app);
    $userId = $app['user_id'];

    $resources = Resources::getResourcesByUserId($userId);
    $quest = Quest::getByUserId($userId);

    $stateDefiner = new StateQuest($userId);

    switch ($stateDefiner->getCurrentState())
    {
        case 'NO_QUEST':
        {
            return $app['twig']->render('quest/quest.twig', ['resources' => $resources,]);
        }
        case 'AFTER_SEARCH':
        {
            $timer = Timer::getTimer('quest_step', $userId);
            Timer::delete($timer->get('id'));
//            Quest::addGoldToQuest($userId, 1);
            ResourceLocation::questStepGold($userId);

            $quest = Quest::getByUserId($userId);

            return $app['twig']->render('quest/quest_choice.twig', [
                'resources'   => $resources,
                'quest_prize' => $quest->get('gold'),
                'step_result' => 20,
            ]);
        }
        case 'SEARCH_PROCESS':
        {
            $timer = Timer::getTimer('quest_step', $userId);
            return $app['twig']->render('quest/quest_process.twig', [
                'resources'   => $resources,
                'timer'       => $timer,
                'quest_prize' => $quest->get('gold')
            ]);
        }
        case 'CHOICE_WITHOUT_TIMERS':
        {
            return $app['twig']->render('quest/quest_choice.twig', [
                'resources'   => $resources,
                'quest_prize' => $quest->get('gold'),
                'step_result' => 20,
            ]);
        }
        default:
        {
            // ERROR_UNKNOWN_STATE
            break;
        }
    };
});

$app->post('/quest_step', function () use ($app) {
//    $userId = Authorize::getSessionUserId($app);
    $userId = $app['user_id'];


    \MessageQueue\RabbitTest::createJobOnCreatingSingleTimer('quest_step', $userId);
//    JobCreator::createJobOnCreatingSingleTimer('quest_step', $userId);
//    Timer::addTimer('quest_step', $userId);

    return $app->redirect('/quest');
});
$app->post('/quest_start', function () use ($app) {
    $userId = Authorize::getSessionUserId($app);

    Timer::addTimer('quest_step', $userId);
    Quest::create($userId);

    return $app->redirect('/quest');
});
$app->post('/quest_end', function () use ($app) {
    $userId = Authorize::getSessionUserId($app);

    Timer::deleteByActionCode('quest_step', $userId);
    $quest = Quest::getByUserId($userId);
    ResourceLocation::questSummaryGold($userId, $quest->get('gold'));
    Quest::delete($userId);

    return $app->redirect('/quest');
});
$app->get('/oil_mass_process', function () use ($app) {
});


$app->get('/oil_mass', function () use ($app) {
    $userId = Authorize::getSessionUserId($app);

    $massWork = MassWork::getMassworkByUserId($userId);

    $stateDefiner = new StateOilMass($userId);
    $state = $stateDefiner->getCurrentState();

    switch ($state)
    {
        case 'USER_WORK_END':
        {
            $workers = MassWork::getUsers($massWork->get('id'));

            MassTimer::delete($massWork->get('id'));
            MassWork::deleteUsers($massWork->get('id'));
            MassWork::delete($massWork->get('id'));

            return $app['twig']->render('mass/oil_mass_result.twig', [
                'mass_work' => $massWork,
                'workers' => $workers,
            ]);
        }
        case 'USER_WORK_PROCESS':
        {
            $timer = MassTimer::getTimerMassWork($massWork->get('id'));
            $workers = MassWork::getUsers($massWork->get('id'));
            return $app['twig']->render('mass/oil_mass_process.twig', [
                'timer' => $timer,
                'workers' => $workers,
            ]);
        }
        case 'USER_JOINED_BUT_NOT_WORK_YET':
        {
//            $workUsers = MassWork::getUsers($massWork->get('id'));
//            return $app['twig']->render('mass/oil_mass_wait.twig', [
//                'mass_work' => $massWork,
//            ]);
//            break;
        }
        case 'USER_FREE':
        {
            $massworks = MassWork::getAllNotBusy();

            return $app['twig']->render('mass/oil_mass_normal.twig', [
                'mass_works' => $massworks,
            ]);
        }
        default:
        {
            // ERROR_UNKNOWN_STATE
            break;
        }
    }

});
$app->post('/oil_mass_create', function () use ($app) {
    $userId = Authorize::getSessionUserId($app);

    $masswork = MassWork::create($userId);
    MassWork::joinUserToMasswork($userId, $masswork->get('id'));

//    $masswork = MassWork::joinUserToMasswork($massId);
//    $masswork = MassWork::

    return $app->redirect('/oil_mass');
});

$app->post('/oil_mass_join', function (Request $request) use ($app) {
    $userId = Authorize::getSessionUserId($app);

    $massId = $request->request->get('mass_id');
    MassWork::joinUserToMasswork($userId, $massId);

    if (MassWork::isFull($massId)) {
        MassTimer::createTimer('oil_mass', $massId);
    }

    return $app->redirect('/oil_mass');
});















$app->get('/admin', function () use ($app) {

    return $app['twig']->render('admin/admin.twig', [
    ]);
});

$app->mount('/', new GarageCtrl());
$app->mount('/', new GameCtrl());
$app->mount('/', new VillageCtrl());
$app->mount('/', new NormalBossCtrl());
$app->mount('/', new AuctionCtrl());
$app->mount('/', new ApiCtrl());
$app->mount('/', new UserCtrl());

$app->before(new Auth());
//SymfonySecurity::securityApp($app);
//echo $app['security.encoder.digest']->encodePassword('password', '');


$app->run();



