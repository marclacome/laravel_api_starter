<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
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
    public function render($request, Exception $e)
    {
        //echo $e;exit;
        $details = $this->details($request, $e);

        if ($request->expectsJson()) {
            return response()->json(['errors' => $details['message']], $details['statusCode']);
        } else {
            return parent::render($request, $e);
        }
    }

    protected function details(Request $request, Exception $e): array
    {
        $statusCode = 500;
        $message = $e->getMessage();

        // Not all Exceptions have a http status code
        if (method_exists($e, 'getStatusCode')) {
            $statusCode = $e->getStatusCode();
        }

        if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            $statusCode = 422;
        } elseif ($e instanceof \Illuminate\Database\QueryException) {
            $statusCode = 400;
            if ($e->errorInfo[1] == 1451) {
                $message = "Cannot proceed with query, it is referenced by other records in the database.";
                \Log::info($e->errorInfo[2]);
            } else {
                $message = 'Could not execute query: ' . $e->errorInfo[2];
                \Log::error($message);
            }
        } elseif ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            $message = "Path " . $request->path() . " does not exist.";
        } elseif ($e instanceof \Symfony\Component\Debug\Exception\FatalThrowableError) {
            $statusCode = 400;
            $message = "Unrecoverable error";
        } elseif ($e instanceof \PDOException) {
            $statusCode = 400;
            $error = ['error' => $message];
        } elseif ($e instanceof \Illuminate\Auth\AuthenticationException) {
            $statusCode = 401;
        } elseif ($e instanceof \Illuminate\Http\Exceptions\HttpResponseException) {
            $statusCode = 500;
        } elseif ($e instanceof \Illuminate\Validation\ValidationException) {
            $statusCode = 422;
            $arrError = $e->errors();
            $message = [];
            foreach ($arrError as $err) {
                $err = $err;
                array_push($message, $err[0]);
            }
            //    $message = substr($message, 0, strlen($message));
        }

        return compact('statusCode', 'message');
    }
}
