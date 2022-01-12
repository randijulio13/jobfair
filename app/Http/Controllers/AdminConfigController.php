<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminConfigController extends Controller
{
    function index()
    {
        $config = DB::table('web_config')->where('id','=',1)->first();
        return view('admin/config',compact('config'));
    }
}
