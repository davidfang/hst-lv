<?php
/**
 * 自定义api异常处理
 * Created by PhpStorm.
 */

namespace App\Exceptions;
use Exception;
use App\Http\Controllers\Api\Helpers\ExceptionReport;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class ApiHandler extends ExceptionHandler
{

    public function handler(Exception $exception)
    {
        //可以处理成需要的格式
        $return = [
            'status' => "fail",
            'message' => $exception->getMessage(),
            'data' => []
        ];
        return $return;
    }

    public function render($request, Exception $exception)
    {
        #当.env中的APP_DEBUG配置为True时调用原有的错误处理方式,false使用自定义的错误处理方式
        if (config('app.debug')) {
            return parent::render($request, $exception);
        }
        // 将方法拦截到自己的ExceptionReport
        $reporter = ExceptionReport::make($exception);

        if ($reporter->shouldReturn()){
            return $reporter->report();
        }
        return parent::render($request, $exception);
        //return $this->handler($exception);
    }
}

