<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Auth\ResetPasswordController;
use App\Mail\UserMail;
use DB;
use Illuminate\Support\Facades\Session;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserResetPassword;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Models\User;
use Modules\Core\Models\Role;
use Modules\Core\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $users = User::select(['*','users.id'])->with("user_groups")
                ->where("admin", 1)
                ->orderBy('users.id','desc')->paginate(10);
        //dd($users);
        $current_user = Auth::user();
        $actions = request()->route()->getAction();
        $controller = explode("@",$actions['controller']);
        $controller = $controller[0];

        return view('core::user/index', [
            "params" => $params,
            "users" => $users,
            "current_user" => $current_user,
            "controller" => $controller,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('core::user/create', [
            "roles" => Role::all()->pluck("name", "id"),
            "groups" => Group::all()->pluck("name", "id")
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $params = $request->all();
        $currentUser = Auth::user();

        $validatorArray = [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ];


        $validator = Validator::make($request->all(), $validatorArray);
        if ($validator->fails()) {
            $message = $validator->errors();
            return Redirect::back()->withInput()->withErrors([$message->first()])->with(['modal_error' => $message->first()]);
        }

        DB::beginTransaction();
        try {
            $avatar ="";
            if($request->hasFile('avatar')){
                $img = $request->file('avatar')->getClientOriginalName();
                $request->avatar->move('img/user',$img);
                $avatar = $img;
            }
            $result = User::create([
                "username" => $params["username"],
                "email" => $params["email"],
                "password" => $params["password"],
                "avatar" => $avatar,
                'admin' => 1,
            ]);

            $groups = isset($params["groups"]) ? [$params["groups"]] : [];
            $result->saveListGroups($groups);

            DB::commit();
            return Redirect::route('core.user.index')->with('messages','Tạo mới người dùng thành công');
        } catch (\Exception $e) {
            DB::rollback();
            Log::alert($e);
            return Redirect::back()->withInput()->withErrors([trans('core::user.error_save')]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $obj = User::withTrashed()->where(["id"=> $id])->first();
        if(empty($obj)){
            return redirect()->back()->withErrors([trans('core::user.error_save')]);
        }
        $user_groups = $obj->user_groups()->get();
        $user_roles = $obj->user_roles()->get();
        return view('core::user.edit', [
            'user' => $obj,
            'user_roles' => $user_roles->pluck("role_id"),
            'user_groups' => $user_groups->pluck("group_id"),
            "roles" => Role::all()->pluck("name", "id"),
            "groups" => Group::all()->pluck("name", "id")
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $params = $request->all();
        $currentUser = Auth::user();

        $validatorArray = [
//            'username' => 'required|unique:users,username,'.$id,
//            'email' => 'required|email|unique:users,email,'.$id,
            'username'=>'required',
            'email'=>['required','email',Rule::unique('users')->ignore($request->email)->whereNot('id',$id)],
            'password' => 'nullable|min:6|confirmed',
            'password_confirmation' => 'nullable|min:6'

        ];
        $validator = Validator::make($request->all(), $validatorArray);
        if ($validator->fails()) {
            $message = $validator->errors();
            return Redirect::route('core.user.edit', $id)->withErrors([$message->first()]);
        }
        $obj = User::withTrashed()->where("id", $id)->first();
        if ($obj) {
            if($request->hasFile('avatar')){
                $img = $request->file('avatar')->getClientOriginalName();
                $request->avatar->move('img/user',$img);
                $obj->avatar = $img;
            }
            $obj->username = $params["username"];
            $obj->email = $params["email"];
            if($params['password']!=""){
                $obj->password = $params['password'];
            }
            $obj->save();

            $roles = isset($params["roles"]) ? $params["roles"] : [];
            $obj->saveListRoles($roles);

            $groups = isset($params["groups"]) ? [$params["groups"]] : [];
            $obj->saveListGroups($groups);

            return Redirect::route('core.user.index')->with('messages','Cập nhật người dùng thành công');
        } else {
            return Redirect::route('core.user.index')->withErrors([trans('core::user.error_exist')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $obj = User::where("id", $id)->first();
        if ($obj) {
            $obj->delete();

            return Redirect::route('core.user.index')->with('messages','Xoá người dùng thành công');
        } else {
            return Redirect::route('core.user.index')->withErrors([trans('core::user.error_exist')]);
        }
    }

    /**
     * Restore the specified resource from storage.
     * @return Response
     */
    public function restore($id)
    {
        $obj = User::withTrashed()->where("id", $id)->first();
        if ($obj) {
            $obj->restore();

            return Redirect::route('core.user.index')->with('messages','Khôi phục người dùng thành công');
        } else {
            return Redirect::route('core.user.index')->withErrors([trans('core::user.error_exist')]);
        }
    }

    /**
     * ResetPassword
     * @return Response
     */
    public function resetPassword($id)
    {
        $obj = User::withTrashed()->where("id", $id)->first();
        if ($obj) {
            $password = "123456789";

            $obj->password=$password;
            $obj->save();


            Session::flash('header_message', trans('core::user.restore_password_success'));

            return Redirect::route('core.user.index');
        } else {
            return Redirect::route('core.user.index')->withErrors([trans('core::user.error_exist')]);
        }
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * change information of own user
     */
    public function changeInformation($id){
        $user_id = Auth::id();
        if($id == $user_id){
            $obj = User::where('id',$user_id)->first();
            if(!empty($obj)){
                return view('core::user.changeInformation',[
                    'user' => $obj,
                    'user_roles' => $obj->user_roles()->pluck("role_id")->toArray(),
                    'user_groups' => $obj->user_groups()->pluck("group_id")->toArray(),
                    "roles" => Role::all()->pluck("name", "id"),
                    "groups" => Group::all()->pluck("name", "id")
                ]);
            }
            else{
                return \redirect()-back()->withErrors(['Cập nhật thông tin cá nhân thất bại']);
            }
        }
        else {
            return \redirect()->back()->withInput()->withErrors(['Cập nhật thông tin cá nhân thất bại']);
        }

    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * update user information
     * just only yourself
     */
    public function updateUserInformation(Request $request,$id) {
        $params = $request->all();
        $currentUser = Auth::id();
        if($currentUser == $id){
            $validatorArray = [
                'username'=>'required',
                'email'=>'required',
                'password' => 'nullable|min:6|confirmed',
                'password_confirmation' => 'nullable|min:6'
            ];

            $validator = Validator::make($request->all(), $validatorArray);
            if ($validator->fails()) {
                $message = $validator->errors();
                return Redirect::back()->withErrors([$message->first()]);
            }
            $obj = User::withTrashed()->where("id", $currentUser)->first();
            if ($obj) {
                if($request->hasFile('avatar')){
                    $img = $request->file('avatar')->getClientOriginalName();
                    $request->avatar->move('img/user',$img);
                    $obj->avatar = $img;
                }
                $obj->username = $params["username"];
                $obj->email = $params["email"];
                if($params['password']!=""){
                    $obj->password = $params['password'];
                }

                $obj->save();

                $roles = isset($params["roles"]) ? $params["roles"] : [];
                $obj->saveListRoles($roles);

                $groups = isset($params["groups"]) ? $params["groups"] : [];
                $obj->saveListGroups($groups);

                return Redirect::back()->with('messages','Cập nhật thông tin cá nhân thành công');
            } else {
                return Redirect::back()->withErrors([trans('core::user.error_exist')]);
            }
        }
        else{
            return \redirect()->back()->withInput()->withErrors(['Cập nhật thông tin cá nhân thất bại']);
        }


    }

}
