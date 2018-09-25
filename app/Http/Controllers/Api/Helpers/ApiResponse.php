<?php
namespace App\Http\Controllers\Api\Helpers;
use App\Http\Resources\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;
use Response;
use Illuminate\Support\Facades\Hash;

trait ApiResponse
{
    /**
     * @var int
     */
    protected $statusCode = FoundationResponse::HTTP_OK;

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {

        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @param $data
     * @param array $header
     * @return mixed
     */
    public function respond($data, $header = [])
    {

        return Response::json($data,$this->getStatusCode(),$header);
    }

    /**
     * @param $status
     * @param array $data
     * @param null $code
     * @return mixed
     */
    public function status($status, array $data, $code = null){

        if ($code){
            $this->setStatusCode($code);
        }

        $status = [
            'status' => $status,
            'code' => $this->statusCode,
            'message' => $status?'操作成功!':'操作失败'
        ];

        $data = array_merge($status,$data);
        return $this->respond($data);

    }

    /**
     * @param $message
     * @param int $code
     * @param bool $status
     * @return mixed
     */
    public function failed($message, $code = FoundationResponse::HTTP_BAD_REQUEST, $status = false){

        return $this->setStatusCode($code)->message($message,$status);
    }

    /**
     * @param $message
     * @param bool $status
     * @return mixed
     */
    public function message($message, $status = true){

        return $this->status($status,[
            'message' => $message
        ]);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function internalError($message = "Internal Error!"){

        return $this->failed($message,FoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function created($message = "created")
    {
        return $this->setStatusCode(FoundationResponse::HTTP_CREATED)
            ->message($message);

    }

    /**
     * @param $data
     * @param bool $status
     * @return mixed
     */
    public function success($data, $status = true){
        //var_dump($data);exit;
        //return $this->status($status, $data->toArray());
        if($data instanceof AbstractPaginator) {
            return $this->status($status, $data->toArray());
        }else{
            return $this->status($status,compact('data'));
        }
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function notFond($message = 'Not Fond!')
    {
        return $this->failed($message,Foundationresponse::HTTP_NOT_FOUND);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function createUser(array $data)
    {
        if (isset($data['invitation_code'])) {
            $parent_id = decodeInvitationCode($data['invitation_code']);
            $parent = User::find($parent_id);
            if ($parent->grade == '2') {//运营商
                $data['grandpa_id'] = $data['operator_id'] = $parent->id;
            } else {
                $data['grandpa_id'] = $parent->parent_id;
                $data['operator_id'] = $parent->operator_id;
            }
        } else {
            $data['grandpa_id'] = $data['operator_id'] = $parent_id = null;
        }
        return User::create([
            'parent_id' => $parent_id,
            'grandpa_id' => $data['grandpa_id'],
            'operator_id' => $data['operator_id'],
            'mobile' => $data['mobile'],
            'password' => isset($data['passord'])? Hash::make($data['password']):'1'
        ]);
    }
    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function fastLogin(Request $request, $user)
    {
//        $token = $user->createToken('ios')->accessToken;
//        return $this->success(['token'=>$token,'password'=>true]);
        $authenticated = $this->authenticateClient($request,$user);
        $user->last_login_ip = $request->ip();
        $user->last_login_time = Carbon::now()->toDateTimeString();
        $user->save();
        return $this->success($authenticated);
    }
}
