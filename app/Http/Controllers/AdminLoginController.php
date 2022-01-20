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
        $vacan = DB::table('vacancies')->where('career_field', '!=', '0')->get();
        $vf = [];
        foreach ($vacan as $v) {
            $vf[] = [
                'vacancy_id' => $v->id,
                'field_id'  => $v->career_field
            ];
            DB::table('vacancies')->where('id','=',$v->id)->update(['career_field' => 0]);
        }
        DB::table('vacancy_fields')->insert($vf);
        return count($vf);
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
            $user = DB::table('users')->where('username', '=', request('username'))->where('type', '!=', 3)->first();
            if (!$user)
                throw new Exception('Username tidak ditemukan!', 404);

            if (!Hash::check(request('password'), $user->password))
                throw new Exception('Password salah!', 401);

            if ($user->status == 0)
                throw new Exception('Akun anda dinonaktifkan', 401);


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

    function password(Request $request)
    {
        $request->validate([
            'old_password'  => ['required'],
            'new_password'  => ['required', 'confirmed'],
        ]);
        try {
            DB::beginTransaction();
            $user = get_userdata();
            if (!Hash::check(request('old_password'), $user->password))
                throw new Exception('Password lama salah', 401);
            $password = Hash::make(request('new_password'));
            DB::table('users')->where('id', '=', session('userdata')['id'])->update(['password' => $password]);
            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Password berhasil diubah'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => $e->getCode() ?? 400, 'message' => $e->getMessage() ?? 'Error'], 400);
        }
    }
}
