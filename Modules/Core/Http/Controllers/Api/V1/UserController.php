<?php
/**
 * Created by PhpStorm.
 * User: paditech
 * Date: 6/16/19
 * Time: 1:16 AM
 */

namespace Modules\Core\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Agency\Entities\Agency;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Core\Models\User;
use DB;

class UserController extends ApiController
{
    public $successStatus = 200;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Login access Token
     */
    public function Login(Request $request){
        try{
            $params = $request->all();
            $validatorArray = [
                'username' => 'required',
                'password'   => 'required',
            ];
            $validator = Validator::make($params, $validatorArray);
            if ($validator->fails()) {
                return $this->successResponse(["errors" => "Some thing was wrong"],'Response Successfully');
            }
            //Check User
            $user = User::where('username','=',$params['username'])->select(['id','username','email','password','access_token'])->first();
            if(!empty($user)){
                if(Hash::check($params['password'],$user['password'])){
                    do {
                        $user->access_token = bin2hex(openssl_random_pseudo_bytes(64));
                    }
                    while(count(User::where('access_token',$user['access_token'])->get())!=0);
                    $usersave = User::find($user['id']);
                    $usersave->update(['access_token'=>$user['access_token']]);
                    unset($user['password'],$user['updated_at']);
                    return $this->successResponse($user,'Response Successfully');
                }
                else {
                    return $this->successResponse(['errors' => "Password is maybe wrong"],'Response Successfully');
                }
            }
            else{
                return $this->successResponse(['errors' => "Username is maybe wrong"],'Response Successfully');
            }
        }
        catch(\Exception $ex){
            Log::info($ex->getMessage());
            return $this->successResponse([],$ex->getMessage());
        }
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request)
    {
        $user = $request->user('api');
        //dd(1);
        //dd(Auth::user());
        return response()->json(['success' => $user], $this-> successStatus);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function store(Request $request)
    {
        $params = $request->all();
        $validatorArray = [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ];


        $validator = Validator::make($request->all(), $validatorArray);
        if ($validator->fails()) {
            return $this->successResponse(["errors" => $validator->messages()],'Response Successfully');
        }

        DB::beginTransaction();
        try {
            $result = User::create([
                "username" => $params["username"],
                "email" => $params["email"],
                "password" => $params["password"],
                "phone" => $params["phone"],
                // "avatar" => $params["avatar"],
                'admin' => 0,
            ]);

            DB::commit();
            return $this->successResponse(["success" => 1],'Response Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->successResponse(["errors" => $e->getMessage()],'Response Successfully');
        }
    }

    public function update(Request $request)
    {
        $params = $request->all();

        $validatorArray = [
            'access_token'=>'required',
            'file' => 'required'
        ];
        // dd($params);
        $validator = Validator::make($params, $validatorArray);
        if ($validator->fails()) {
            return $this->successResponse(["errors" => "Xảy ra lỗi trong quá trình up file"],'Response Successfully');
        }
        $obj = User::withTrashed()->where("access_token", $params['access_token'])->first();
        if ($obj) {
            if($request->hasFile('file')){
                $img = $request->file('file')->getClientOriginalName();
                $request->file->move('img/user',$img);
                $obj->avatar = $img;
            }
            if(!empty($params['password'])){
                $obj->password = $params['password'];
            }
            $obj->save();

            $item = new \stdClass();
            $item->avatar = $obj->avatar;

           return $this->successResponse($item,'Response Successfully');
        } else {
            return $this->successResponse(["errors" => "User may be wrong"],'Response Successfully');
        }
    }

    public function getInfo(Request $request)
    {
        $params = $request->all();

        $validatorArray = [
            'access_token'=>'required',
        ];
        $validator = Validator::make($request->all(), $validatorArray);
        if ($validator->fails()) {
            return $this->successResponse(["errors" => "User may be wrong"],'Response Successfully');
        }
        $obj = User::select('username', 'email', 'phone', 'avatar')->withTrashed()->where("access_token", $params['access_token'])->first();
        if ($obj) {
            return $this->successResponse($obj,'Response Successfully');
        } else {
            return $this->successResponse(["errors" => "User may be wrong"],'Response Successfully');
        }
    }
}
