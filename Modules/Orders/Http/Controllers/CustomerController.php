<?php

namespace Modules\Orders\Http\Controllers;

use App\Exports\CustomersExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Excel;
use Modules\Agency\Entities\Province;
use Modules\Orders\Entities\Customer;
use Yajra\Datatables\Datatables;
use Session;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $provinces = Province::all();
        return view('orders::customer.index', compact('provinces'));
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function get(Request $request)
    {
        return Datatables::of(Customer::select('*'))
            ->filter(function ($query) use ($request) {
                foreach ($request->all() as $key => $value) {
                    if (($value == "") || ($value == -1) || ($value == null)) {

                    } else {
                        if ($key == 'status') {
                            $query->where('status', $value);
                        }elseif ($key == "name"){
                            $query->where('name', 'LIKE', '%' . $value . '%');
                        }elseif ($key == 'province') {
                            Session::put('province', $value);
                            $query->where('province_id', $value);
                        }
                        elseif ($key == 'created_at') {
                            $date = explode(' - ', $value);
                            if($date[0] != $date[1]){
                                $start_date = Carbon::parse($date[0])->format('Y-m-d H:i:s');
                                $end_date = Carbon::parse($date[1])->format('Y-m-d H:i:s');
                                $query->whereBetween('created_at', array($start_date, $end_date));
                            }

                        }
                    }
                }
            })
            ->escapeColumns([])
            ->editColumn('created_at', function ($customer) {
                return Carbon::parse($customer->created_at)->format('d-m-Y');
            })
            ->editColumn('id', function ($customer) {
                return "#".$customer->id;
            })
            ->editColumn('type', function ($customer) {
                if($customer->type == Customer::COMPANY_STATUS){
                    return "Công ty";
                }else{
                    return "Cá nhân";
                }
            })
            ->make(true);
    }

    /**
     * @return mixed
     */
    public function excel(){
        return Excel::download(new CustomersExport, 'customers.xlsx');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request){
        $query = Customer::query();
        $value = $request['query'];
        $query->whereRaw('LOWER(mobile) LIKE ? ', ['%'.trim(mb_strtolower($value)).'%']);
        $data = $query->get();
        return \response()->json(json_encode($data));
    }
}
