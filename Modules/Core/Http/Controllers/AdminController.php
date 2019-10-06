<?php

namespace Modules\Core\Http\Controllers;

use App\Mail\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Modules\Core\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Mail;
use Modules\Core\Models\User;
use Modules\News\Models\NewsCategory;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('core::index');
    }

    /**
     * Login page for admin
     */
    public function login()
    {
        return view('core::user.login');
    }

    /**
     * Process login
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function loginPost(LoginRequest $request)
    {
        //dd($request->all());
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'admin' => 1],$request->remember_me)) {
            return redirect(route('admin_home'));
        } else {
            return redirect()->back()->withInput()->with('login_error','Tài khoản hoặc mật khẩu không hợp lệ!' );
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }


    public function forgotPassword(){
        return view('core::user.passwords.email');
    }

    public function sendResetLinkEmail(Request $request){
        $data = $request->all();
        $user = User::where('email',$data['email'])->first();
        if($user != null){
            $user = User::find($user->id);
            $user->resetpassword_token = bin2hex(openssl_random_pseudo_bytes(32));
            $user->save();

            //Mail::to($data['email'])->send(new ResetPassword($user->resetpassword_token,$user->email));
            $email = $data['email'];
            Mail::send('mail.user_reset_password', array('user' => $user->email, 'token' => $user->resetpassword_token),
                function($message) use ($email) {
                $message->to($email, 'Visitor')
                        ->subject('Xác nhận lấy lại mật khẩu tài khoản Nhựa Tiền Phong');
            });
            return redirect()->back()->with('messages','Hệ thống đã gửi thông tin lấy lại mật khẩu đến email của bạn.');

        }
        else
        {
            return redirect()->back()->with('errors','Email chưa được đăng ký!')->withInput();
        }
    }

    /**
     * @param $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function resetPassword($token){
        $check = User::where('resetpassword_token',$token)->first();

        if($check!=null){
            return view('core::user.passwords.reset',compact('token'));
        }
        else {
            return redirect(route('login'));
        }
    }


    public function saveNewPassword(Request $request){
        try{

            $this->validate($request,[
                'password'=>'required|confirmed|min:6',
                'password_confirmation' => 'required|min:6'
            ],[
                'password.required'=>'Mật khẩu không được để trống',
                'password_confirmation.required'=>'Mật khẩu xác nhận không được để trống',
            ]);

            $data = $request->all();

            $user = User::where('resetpassword_token',$data['token'])->first();
            if($user!=null){
                $user = User::find($user->id);
                $user->password = $data['password'];
                $user->save();
                Auth::login($user,true);
                return redirect(route('admin_home'));

        }
            else{
                return redirect()->back()->withErrors(['Reset password failed, look like something went wrong!']);
            }
        }
        catch(Exception $ex){
            return redirect()->back()->withInput();
        }

    }
}
