<?php

namespace Modules\Saleoff\Http\Controllers;

use App\Models\Shop\Product;
use App\Models\Shop\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Saleoff\Entities\ProductSale;
use Yajra\DataTables\DataTables;
use Validator;

class SaleoffController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $sales = Sale::all();
        return view('saleoff::index', compact('sales'));
    }

    public function get() {
        $query = Sale::query();

        return DataTables::of($query)
        ->escapeColumns([])
        // ->editColumn('cover_img', function($query) {
        //     return "<img src='".$query->cover_img."' style='width: 180px; height: 140px;'/>";
        // })
        ->editColumn('start_time', function($query) {
            return "<button type='button' class='btn btn-success btn-xs'><i class='fa fa-clock-o'>$query->start_time</i></button>";
        })
        ->editColumn('end_time', function($query) {
            return "<button type='button' class='btn btn-success btn-xs'><i class='fa fa-clock-o'>$query->end_time</i></button>";
        })
        ->editColumn('created_at', function($query) {
            return "<button type='button' class='btn btn-success btn-xs'><i class='fa fa-clock-o'>$query->created_at</i></button>";
        })
        ->addColumn('actions', function($query) {
            $html = '<a href="'. route('admin.saleoff.edit', $query->id).'" type="button" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i>&nbsp;  View </a>';
            return $html;
        })
        ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $products = Product::all();

        $products = $products->map(function ($product) {
            return collect([
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'code' => $product->code,
            ]);
        }); //
        return view('saleoff::create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $params = $request->all();
        // dd($params);
        $validatorArray = [
            'event_name' => 'required',
            'period' => 'required',
            'introduction' => 'required'
        ];

        $validator = Validator::make($params, $validatorArray);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->messages());
        }
        DB::beginTransaction();
        try {
            $sale = [];
            $sale['event_name'] = $params['event_name'];
            $sale['introduction'] = $params['introduction'];
            $sale['start_time'] = date("Y-m-d H:i:s", strtotime(substr($params['period'], 0, 10)));
            $sale['end_time'] = date("Y-m-d H:i:s", strtotime(substr($params['period'], 13, 10)));
            $id = Sale::insertGetId($sale);
            if(count($params['productId'])){
                ProductSale::insertList($params['productId'], $params['discount'], $id, false);
            }
            DB::commit();
            return redirect(route('admin.saleoff.index'))->with('messages','Tạo sale off thành công');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('[Sale off store] ' . $e->getMessage() . " line " . $e->getLine());
            return redirect()->back()->withInput()->withErrors(["Không thể lưu được bản ghi nào"]);
        }


    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('saleoff::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $sale = Sale::where('id', $id)->first();
        if(empty($sale)){
            return redirect()->back()->withInput()->withErrors(["Không tìm thấy bản ghi"]);
        }
        $sale->start_time = date("d-m-Y", strtotime($sale->start_time));
        $sale->end_time = date("d-m-Y", strtotime($sale->end_time));
        $products = Product::select('id', 'name', 'price', 'code')->get();
        $discounts = [];
        $saleProductIds = [];
        foreach ($sale->products as $product) {
            array_push($saleProductIds, $product->id);
            $discounts[$product->id] = $product->pivot->discount;
        }
        return view('saleoff::edit', compact('sale', 'products', 'discounts', 'saleProductIds', 'id'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $params = $request->all();
        // dd($params);
        $validatorArray = [
            'event_name' => 'required',
            'period' => 'required',
            'introduction' => 'required'
        ];

        $validator = Validator::make($params, $validatorArray);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->messages());
        }
        DB::beginTransaction();
        try {
            $sale = Sale::where('id', $id)->first();
            if(empty($sale)){
                return redirect()->back()->withInput()->withErrors(["Không tồn tại bản ghi"]);
            }
            $sale->event_name = $params['event_name'];
            $sale->introduction = $params['introduction'];
            $sale->start_time = date("Y-m-d H:i:s", strtotime(substr($params['period'], 0, 10)));
            $sale->end_time = date("Y-m-d H:i:s", strtotime(substr($params['period'], 13, 10)));
            $sale->save();
            if(count($params['productId']) > 0){
                ProductSale::insertList($params['productId'], $params['discount'], $id, true);
            }
            DB::commit();
            return redirect(route('admin.saleoff.index'))->with('messages','Sửa sale off thành công');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('[Sale off update] ' . $e->getMessage() . " line " . $e->getLine());
            return redirect()->back()->withInput()->withErrors(["Không thể lưu được bản ghi nào"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        $sale = Sale::findOrFail($request->id);
        $sale->products()->detach();
        $sale->delete();
        return redirect()->back();
    }

    public function client(Request $request)
    {
        $filter = $request->all();
        $conditions = [];
        if (isset($filter)) {
            if (isset($filter['min'])) {
                array_push($conditions, ['price', '>=', $filter['min']]);
            }
            if (isset($filter['max'])) {
                array_push($conditions, ['price', '<=', $filter['max']]);
            }
        }
        $query = Product::where($conditions);
        if (isset($filter['size'])) {
            $size = $filter['size'];
            $query = $query->whereHas('sizes', function ($query) use ($size) {
                $query->where('size_name', '=', $size);
            });
        }
        if (isset($filter['color'])) {
            $color = $filter['color'];
            $query = $query->whereHas('colors', function ($query) use ($color) {
                $query->where('code', '=', $color)->where('color_product.amount', '>', 0);
            });
        }
        if (isset($filter['event'])) {
            $eventId = $filter['event'];
            $query = $query->whereHas('sales', function ($query) use ($eventId) {
                $query->where('id', '=', $eventId);
            });
        }
        if (isset($filter['price'])) {
            if ($filter['price'] == 'DESC' || $filter['price'] == 'ESC') {
                $query = $query->orderBy('price', $filter['price']);
            }
        }
        if (isset($filter['time'])){
            if ($filter['time'] == 'DESC' || $filter['price'] == 'ESC') {
                $query = $query->orderBy('updated_at', $filter['time']);
            }
        }
        $products = $query->paginate(15);
//        return response()->json([
//            'product' => $products,
//        ]);
        return view('saleoff::api.index',compact('products'));
    }

}
