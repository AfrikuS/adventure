<?php

namespace App\Exceptions;

use App\Exceptions\Persistence\EntityNotFound_Exception;
use Exception;
use Finite\Exception\StateException;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

// extends \GrahamCampbell\Exceptions\ExceptionHandler
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
//        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof NotFoundHttpException) {
            Session::flash('message', '404 not found');
//            return redirect()->back();
            return response()->view('errors.404', [], 404);
        }
        elseif ($e instanceof NotFoundResourceException) {
            Session::flash('message', 'Nedostatochno денег');
            return redirect()->back();
        }
//        elseif ($e instanceof FatalThrowableError) {
//            Session::flash('message', $e->getMessage());
//            return redirect()->back();
//        }
//        elseif ($e instanceof StateException) {
//            Session::flash('message', 'Недопустимое действие');
//            return redirect()->back();
//        }
        elseif ($e instanceof EntityNotFound_Exception) {
            Session::flash('message', 'Запись не найдена. '. $e->getMessage());
            return \Redirect::route('profile_page');
        }

        return parent::render($request, $e);
    }
}
