<?php

namespace Modules\News\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Mockery\Exception;
use Modules\News\Models\Block;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Core\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends ApiController
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Login access Token
     */
    public function Login(Request $request){
        try{
            $params = $request->all();
            $username = $params['user_name'];
            $password = $params['password'];
            //Check User
            $user = User::where('username','=',$username)->select(['id','username','email','password','access_token','avatar'])->first();
            if(!empty($user)){

                if(Hash::check($password,$user['password'])){
                    do {
                        $user->access_token = bin2hex(openssl_random_pseudo_bytes(64));
                    }
                    while(count(User::where('access_token',$user['access_token'])->get())!=0);

                    $base_usl = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http"). "://". @$_SERVER['HTTP_HOST']."/img/user/";
                    $user['avatar'] = isset($user['avatar'])? $base_usl.$user['avatar']:"";
                    $usersave = User::find($user['id']);
                    $usersave->update(['access_token'=>$user['access_token']]);
                    unset($user['password'],$user['updated_at']);
                    return $this->successResponse($user,'Response Successfully');
                }
                else {
                    return $this->errorResponse([],'Password is maybe wrong');
                }
            }
            else{
                return $this->errorResponse([],'Username is maybe wrong');
            }
        }
        catch(Exception $ex){
            return $this->errorResponse([],$ex->getMessage());
        }
    }

}