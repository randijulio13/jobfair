<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminConfigController extends Controller
{
    function index()
    {
        $config = DB::table('web_config')->where('id', '=', 1)->first();
        return view('admin/config', compact('config'));
    }

    function update(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'title_description' => ['required'],
            'about_us' => ['required'],
            'phone' => ['required'],
            'email' => ['required'],
            'address' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            DB::table('web_config')->where('id', '=', 1)->update(request()->all());
            DB::commit();
            return response()->json([
                'status'    => 200,
                'message'   => 'OK'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'    => $e->getCode(),
                'message'   => $e->getMessage()
            ], 400);
        }
    }
}
