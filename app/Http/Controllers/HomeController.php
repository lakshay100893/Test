<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;




class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function headerFix(Request $request)
    {
        $data = [];
        if ($request->session()->has('header')) {
            $type = $request->session()->get('header');
            if ($type) {
                $request->session()->put('header', 0);
                $data[] = 'Show';
            }else{
                $request->session()->put('header', 1);
                $data[] = 'Hide';
            }
        }else{
            $request->session()->put('header', 1);
            $data[] = 'Hide';
        }

        return $data;
    }
}
