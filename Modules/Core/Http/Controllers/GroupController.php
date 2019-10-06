<?php

namespace Modules\Core\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Session;
use Validator;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Models\Group;
use Modules\Core\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $groups = Group::withTrashed()->paginate();
        $current_user = Auth::user();
        $actions = request()->route()->getAction();
        $controller = (explode("@",$actions['controller']));
        $controller = $controller[0];

        return view('core::group/index', [
            "params" => $params,
            "groups" => $groups,
            "current_user" => $current_user,
            "controller" => $controller
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('core::group/create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $params = $request->all();

        $validatorArray = [
            'type' => 'required',
            'name' => 'required|unique:groups',
        ];

        $validator = Validator::make($request->all(), $validatorArray);
        if ($validator->fails()) {
            $message = $validator->errors();
            return Redirect::back()->withInput()->withErrors([$message->first()])->with(['modal_error' => $message->first()]);
        }

        $params['category'] = isset($params['category'])? $params['category']:[];
        DB::beginTransaction();
        try {
//            if ($params["type"] == Group::TYPE_COMPAPNY)
//                $objectIds = isset($params["companies"]) ?$params["companies"] : [];
//            else
//                $objectIds = isset($params["agencies"]) ?$params["agencies"] : [];
            $result = Group::create([
                "type" => $params["type"],
                "name" => $params["name"],
//                "object_ids" => implode(",", $objectIds),
            ]);

            DB::commit();
            return Redirect::route('core.group.index')->with('messages','Create new group user successfully');
        } catch (\Exception $e) {
            DB::rollback();
            Log::alert($e);
            return Redirect::back()->withInput()->withErrors([trans('core::group.error_save')]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {

        $obj = Group::withTrashed()->where("id", $id)->first();
//        $role = \GuzzleHttp\json_decode($obj['role_id']);
//        $role_id = Role::whereIn('id', $role)->get()->toArray();
        return view('core::group/edit', [
            'group' => $obj,
            //'role_id'=> $role_id
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
        $validatorArray = [
            'type' => 'required',
            'name' => 'required|unique:groups,name,'.$id,
        ];

        $validator = Validator::make($request->all(), $validatorArray);
        if ($validator->fails()) {
            $message = $validator->errors();
            return Redirect::route('core.group.edit', $id)->withErrors([$message->first()]);
        }
        $obj = Group::withTrashed()->where("id", $id)->first();
        if ($obj) {
            $obj->name = $params["name"];
            $obj->type = $params["type"];
            $obj->save();

            return Redirect::route('core.group.index')->with('messages','Edit group user successfully');
        } else {
            return Redirect::route('core.group.index')->withErrors([trans('core::group.error_exist')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $obj = Group::where("id", $id)->first();
        if ($obj) {
            $obj->delete();

            return Redirect::route('core.group.index')->with('messages','Delete group user successfully');
        } else {
            return Redirect::route('core.group.index')->withErrors([trans('core::group.error_exist')]);
        }
    }

    /**
     * Restore the specified resource from storage.
     * @return Response
     */
    public function restore($id)
    {
        $obj = Group::withTrashed()->where("id", $id)->first();
        if ($obj) {
            $obj->restore();

            return Redirect::route('core.group.index')->with('messages','Restore group user successfully');
        } else {
            return Redirect::route('core.group.index')->withErrors([trans('core::group.error_exist')]);
        }
    }
}
