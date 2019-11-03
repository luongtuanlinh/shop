<?php

namespace Modules\Saleoff\Http\Controllers;

use App\Models\Shop\Product;
use App\Models\Shop\Sale;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Yajra\DataTables\DataTables;

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
        $sale = new Sale();
        $sale['event_name'] = $request['event_name'];
        $sale['introduction'] = $request['introduction'];
        $sale['start_time'] = substr($request['period'], 0, 10);
        $sale['end_time'] = substr($request['period'], 13, 10);
        $sale->save();
        for ($i = 0; $i < count($request['saleProductIds']); $i++) {
            $sale->products()->attach($request['saleProductIds'][$i], ['discount' => $request['percentageDiscounts'][$i]]);
        }
        return response()->json(['message' => 'ok']);
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
        $sale = Sale::findOrFail($id);
        $products = Product::select('id', 'name', 'price', 'code')->get();
        $discounts = [];
        $saleProductIds = [];
        foreach ($sale->products as $product) {
            array_push($saleProductIds, $product->id);
            $discounts[$product->id] = $product->pivot->discount;
        }
        return view('saleoff::edit', compact('sale', 'products', 'discounts', 'saleProductIds'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);
        $sale['event_name'] = $request['event_name'];
        $sale['introduction'] = $request['introduction'];
        $sale['start_time'] = substr($request['period'], 0, 10);
        $sale['end_time'] = substr($request['period'], 13, 10);
        $sale->save();
        for ($i = 0; $i < count($request['saleProductIds']); $i++) {
            $sale->products()->detach();
            $sale->products()->attach($request['saleProductIds'][$i], ['discount' => $request['percentageDiscounts'][$i]]);
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
