<?php

namespace App\Exceptions;

use Exception;
use App\Traits\TraitApiResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use TraitApiResponser;
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];
    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // handling validation exceptions
        if ($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }

        // handling model not found exceptions
        if ($exception instanceof ModelNotFoundException) {
            $modelName = class_basename($exception->getModel());
            //return response()->json(['error' => $message, 'code' => $code], $code);
            return $this->errorResponse("Does not exist any {$modelName} with specified identyficator", 404);
        }

        // handling authentication exceptions
        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }

        // handling authorisation exceptions
        if ($exception instanceof AuthorizationException) {
            return $this->errorResponse($exception->getMessage(), 403);
        }

        // handling not found http exception when url does not exist
        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse("The specify url can't be found", 404);
        }

        // handling not found http exception when url does not exist
        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse("The specify http method not allowed", 405);
        }

        // Handling General HttpException
        if ($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }

        // handling QueryException when you have foreighn keys to other table and trying to eg. delete seller or buyer
        if ($exception instanceof QueryException) {
            // see all info about that exception
            //dd($exception)
            $errorCode = $exception->errorInfo[1];
            if ($errorCode == 1451) {
                return $this->errorResponse("Cannot remove this (row) resource permanently. It is related to (other table) resource. You need to remove first relation", 409);
            }
        }

        // Handling Unexpected Exceptions
        // If all exeptions above are not triggerd that means db is down or server is down or anything of that matter
        // so you need to handle this also by directly returning Unexpected Exceptions message as json for production
        // If yo

        // from .env
        if(config('app.debug')) {
            // display normal full info for development mode debug mode
            return parent::render($request, $exception);
        } else {
            // this is for production
            return $this->errorResponse("Unexpected Exceptions. Try later", 500);
        }

    }
    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->errorResponse('Unauthenticated', 401);
    }
    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();

        return $this->errorResponse($errors, 422);
    }
}