<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

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
     *
     * @throws \Exception
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
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        //如果路由中含有“api/”，则说明是一个 api 的接口请求
        if($request->is("api/*")){
            //如果错误是 ValidationException的一个实例，说明是一个验证的错误
            if($exception instanceof ValidationException){
                $result = [
                    "code"=>400,
                    //这里使用 $exception->errors() 得到验证的所有错误信息，是一个关联二维数组，所以使用了array_values()取得了数组中的值，而值也是一个数组，所以用的两个 [0][0]
                    "msg"=>array_values($exception->errors())[0][0],
                    "result"=>""
                ];
                return response()->json($result);
            }
        }

        return parent::render($request, $exception);
    }
}
