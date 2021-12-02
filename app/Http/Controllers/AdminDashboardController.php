<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    function index()
    {
        return view('admin/dashboard');
    }
}
