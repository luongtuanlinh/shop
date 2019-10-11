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

    public function news()
    {
        return view('guest::pages.news');
    }

    public function transportPolicy()
    {
        return view('guest::pages.transport-policy');
    }

    public function paymentPolicy()
    {
        return view('guest::pages.payment-policy');
    }

    public function securityPolicy()
    {
        return view('guest::pages.security-policy');
    }

    public function login()
    {
        return view('guest::pages.login');
    }
}