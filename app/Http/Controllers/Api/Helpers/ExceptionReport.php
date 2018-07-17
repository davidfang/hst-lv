<?php

namespace App\Http\Controllers\Api\Helpers;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ExceptionReport
{
    use ApiResponse;

    /**
     * @var Exception
     */
    public $exception;
    /**
     * @var Request
     */
    public $request;

    /**
     * @var
     */
    protected $report;

    /**
     * ExceptionReport constructor.
     * @param Request $request
     * @param Exception $exception
     */
    function __construct(Request $request, Exception $exception)
    {
        $this->request = $request;
        $this->exception = $exception;
    }

    /**
     * @var array
     */
    public $doReport = [
        AuthenticationException::class => ['未授权',401],
        ModelNotFoundException::class => ['改模型未找到',404]
    ];

    /**
     * @return bool
     */
    public function shouldReturn(){

        $action = $this->request->route()->action;
//        var_dump($action['middleware']);
//        var_dump(get_class($this->exception));
////          var_dump($this->request->wantsJson());
//          var_dump($this->request->ajax());
////        die('a');
//        var_dump(in_array('api',$action['middleware']));

        if ($action['middleware'] != 'api' && !in_array('api',$action['middleware']) ||  $this->request->ajax()){
            return false;
        }

        foreach (array_keys($this->doReport) as $report){

            if ($this->exception instanceof $report){

                $this->report = $report;
                return true;
            }
        }

        return false;

    }

    /**
     * @param Exception $e
     * @return static
     */
    public static function make(Exception $e){

        return new static(\request(),$e);
    }

    /**
     * @return mixed
     */
    public function report(){

        $message = $this->doReport[$this->report];

        return $this->failed($message[0],$message[1]);

    }

}
