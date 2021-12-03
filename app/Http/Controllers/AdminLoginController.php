<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminLoginController extends Controller
{
    function debug()
    {
        return session('userdata');
    }

    function logout()
    {
        session()->forget('userdata');
        return redirect('/admin/login');
    }

    function index()
    {
        return view('admin/login');
    }

    function login(Request $request)
    {
        $request->validate([
            'username'  => ['required'],
            'password'  => ['required']
        ], [
            'username.required' => 'Username harus diisi',
            'password.required' => 'Password harus diisi'
        ]);
        try {
            $user = DB::table('users')->where('username', '=', request('username'))->where('type', '=', 1)->first();
            if (!$user)
                throw new Exception('Username tidak ditemukan!', 404);

            if (!Hash::check(request('password'), $user->password))
                throw new Exception('Password salah!', 401);

            $data = [
                'id'    => $user->id,
                'username'   => $user->username,
                'name'       => $user->name,
                'type'       => $user->type,
                'login_ip'   => request()->ip(),
                'login_time' => date('H:i:s'),
            ];
            Session::put('userdata', $data);
            $res = [
                'status'    => 200,
                'message'   => 'Berhasil login'
            ];
        } catch (Exception $e) {
            $res = [
                'status'    => $e->getCode(),
                'message'   => $e->getMessage()
            ];
        }
        return response()->json($res, $res['status']);
    }
}
