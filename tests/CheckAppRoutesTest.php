<?php

use App\Models\User;

class CheckAppRoutesTest  extends TestCase
{
    protected $admin;

    public function setUp()
    {
        parent::setUp();
        $this->admin      = User::find(8); // alban


    }

    public function testMacroPage() 
    {
        $this->withoutEvents();
        $this->be($this->admin);


        $blacklist = [
            'work/order/{id}',
            'work/teamorder/{id}',
            'work/privateteams/{id}',
            'macro/buildings/{id}',
            'admin/edit_order_draft_1/{id}',
            'admin/edit_order_draft_1/{id}',
            'admin/edit_order_draft_2/{id}',
            'geo/location/{id}',
            'geo/build_route/{id}',
            'geo/travel/order/{travel_id}',
            'delete/geo/travel/{id}',
            'delete/work/order/{id}',
            'delete/work/teamorder/{id}',
            'geo/shipshop/{id}',
            '/',
            'test',
            'logout',
            '_debugbar/open',
            '_debugbar/clockwork/{id}',


            'work/create_privateteam', // middlew
        ];

        $routeCollection = Route::getRoutes();
        $routes = $routeCollection->getRoutes();//['GET'];
        foreach ($routes as $route) {

            /** @var $route \Illuminate\Routing\Route */
            $uri = $route->getUri();
            if (in_array('GET', $route->getMethods()) && !in_array($route->getUri(), $blacklist)) {

                $response = $this->call('GET', $uri);
                $this->assertPageLoaded($uri);
            }
        }
    }


        
    public function testAllRoutes()
    {
/*        $routeCollection = Route::getRoutes();
        $this->withoutEvents();
        $blacklist = [
            'url/that/not/tested',
        ];
        $dynamicReg = "/{\\S*}/"; //used for omitting dynamic urls that have {} in uri (http://laravel-tricks.com/tricks/adding-a-sitemap-to-your-laravel-application#comment-1830836789)
        $this->be($this->admin);
        foreach ($routeCollection as $route) {
            if (
//                !preg_match($dynamicReg, $route->getUri()) &&
                in_array('GET', $route->getMethods()) &&
                !in_array($route->getUri(), $blacklist)
            ) {
//                $start = $this->microtimeFloat();
//                fwrite(STDERR, print_r('test ' . $route->getUri() . "\n", true));
                $this->assertPageLoaded($route->getUri());

//                $response = $this->call('GET', $route->getUri());
//                $end   = $this->microtimeFloat();
//                $temps = round($end - $start, 3);
//                fwrite(STDERR, print_r('time: ' . $temps . "\n", true));
//                $this->assertLessThan(15, $temps, "too long time for " . $route->getUri());
//                $this->assertEquals(200, $response->getStatusCode(), $route->getUri() . "failed to load");
//
            }*/
        }

}
