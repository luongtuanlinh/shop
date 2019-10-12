<?php

namespace Modules\Saleoff\Http\Controllers;

use App\Models\Shop\Product;
use App\Models\Shop\Sale;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;


class SaleoffController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $sales = Sale::all();
        return view('saleoff::index',compact('sales'));
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
        return view('saleoff::create',compact('products'));
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
        $sale['start_time'] = substr($request['period'],0,10);
        $sale['end_time'] = substr($request['period'],13,10);
        $sale->save();
        for ($i =0;$i<count($request['saleProductIds']); $i++){
            $sale->products()->attach($request['saleProductIds'][$i],['discount' => $request['percentageDiscounts'][$i]]);
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
        return view('saleoff::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
