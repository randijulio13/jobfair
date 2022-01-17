<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    function index()
    {
        // return session('userdata_applicant');
        $sponsors = DB::table('sponsors')->where('status', '=', 1)->get();
        $config = DB::table('web_config')->where('id','=',1)->first();
        $banner = DB::table('banners')->where('status','=',1)->get();
        return view('home', compact('sponsors','config','banner'));
    }
}
