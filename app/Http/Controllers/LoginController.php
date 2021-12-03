<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    function index()
    {
        return view('login');
    }

    function logout()
    {
        session()->forget('userdata_applicant');
        return redirect('/');
    }

    function login(Request $request)
    {
        $rules = [
            'username'  => ['required'],
            'password'  => ['required']
        ];
        $messages = [
            'username.required' => 'Username harus diisi',
            'password.required' => 'Password harus diisi'
        ];
        $request->validate($rules, $messages);
        try {
            $user = DB::table('users')->where('type', '=', 3)->where('username', '=', request('username'))->first();
            if (!$user)
                throw new Exception('User tidak ditemukan!', 404);
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
            Session::put('userdata_applicant', $data);
            $res = [
                'status'    => 200,
                'message'   => 'Login berhasil'
            ];
        } catch (Exception $e) {
            $res = [
                'status'    => $e->getCode() ?? 400,
                'message'   => $e->getMessage() ?? 'Terjadi kesalahan'
            ];
        }

        return response()->json($res, $res['status']);
    }
}
