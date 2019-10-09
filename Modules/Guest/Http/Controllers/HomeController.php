<?php


namespace Modules\Guest\Http\Controllers;


use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('guest::index');
    }

    public function introduction()
    {
        return view('guest::pages.introduction');
    }

    public function contact()
    {
        return view('guest::pages.contact');
    }

    public function product()
    {
        return view('guest::pages.product');
    }

    public function saleoff()
    {
        return view('guest::pages.saleoff');
    }
}