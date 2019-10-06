<?php
/**
 * Created by PhpStorm.
 * User: paditech
 * Date: 6/16/19
 * Time: 1:16 AM
 */

namespace Modules\Core\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Modules\Agency\Entities\Agency;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Core\Models\User;

class UserController extends ApiController
{
    public $successStatus = 200;

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        //dd(1);
        $params = $request->all();
        $validatorArray = [
            'phone' => 'required|string|',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ];

        $validator = Validator::make($params, $validatorArray);
        if ($validator->fails()) {
            return $this->errorResponse([], $validator->messages());
        }
        //$credentials = request(['username', 'password']);
        try{
            $user = User::where('phone','=',$request->phone)->first();
            if(!empty($user)){
                if(!Auth::attempt(['phone' => $request->phone, 'password' => $request->password, 'admin' => 0],$request->remember_me))
                    return $this->errorResponse([],'Số điện thoại hoặc mật khẩu không đúng');
                $user->token = $params['token'];
                $user->save();
                $user = $request->user();

                $tokenResult = $user->createToken('Personal Access Token');
                $token = $tokenResult->token;
                if ($request->remember_me)
                    $token->expires_at = Carbon::now()->addWeeks(1);
                $token->save();
                $agency = Agency::where('user_id', $user->id)->first();
                $result = [
                    'user_id' => $user->id,
                    'agency_name' => $agency->name,
                    'agency_child_count' => Agency::where('parent', $agency->id)->count(),
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse(
                        $tokenResult->token->expires_at
                    )->toDateTimeString()
                ];
                return $this->successResponse(["user" => $result],'Response Successfully');
            }
            else{
                return $this->errorResponse([],'Số điện thoại không đúng ');
            }

        }catch (\Exception $ex){
            return $this->errorResponse([],$ex->getMessage());
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

}
