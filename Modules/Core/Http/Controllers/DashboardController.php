<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Agency\Entities\Agency;
use Modules\News\Models\NewsPost;
use Modules\News\Models\NewsPostView;
use Modules\Orders\Entities\Customer;
use Modules\Orders\Entities\Orders;
use Modules\Product\Entities\Product;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {

//        $newsPostView = new NewsPostView();
//
//        $report = $newsPostView->reportMonth();
//        $news = NewsPost::getMyNews(Auth::id())->limit(10)->orderby('id', 'DESC')->get();
//        return view('core::index')->withReport($report)
//            ->withLabels(implode(',', array_keys($report)))
//            ->withNews($news);
//        $order_count = Orders::count();
//        $product_count = Product::count();
//        $customer_count = Customer::count();
//        $agency_count = Agency::count();
        return view('core::index');
    }

}
