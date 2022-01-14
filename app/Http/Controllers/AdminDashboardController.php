<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    function index()
    {
        $total_applicant = DB::table('applicant_datas')->where('file', '!=', null)->count();
        $total_vacancy = DB::table('vacancies')->count();
        $total_sponsor = DB::table('sponsors')->count();
        $total_pending = DB::table('users')->where('status', '=', 2)->count();
        $new_message  = DB::table('new_messages')->where('user_id', '=', session('userdata')['id'])->count();


        if (session('userdata')['type'] == 1) {
            return view('admin/dashboard', compact('total_applicant', 'total_vacancy', 'total_sponsor', 'total_pending'));
        } else {
            return view('admin/dashboard_sponsor', compact('total_applicant', 'total_vacancy', 'total_sponsor', 'total_pending', 'new_message'));
        }
    }
}
