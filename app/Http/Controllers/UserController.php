<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function store(Request $request, $token)
    {
        $rules = [
            'name'  => ['required'],
            'username'  => ['required','unique:users'],
            'password'  => ['required', 'confirmed']
        ];
        $messages = [
            'name.required' => 'Nama harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique'   => 'Username sudah digunakan',
            'password.required' => 'Password harus diisi',
            'password.confirmed'    => 'Konfirmasi password salah'
        ];
        $request->validate($rules, $messages);
        DB::beginTransaction();
        try {
            $isToken = DB::table('applicant_tokens')->where('token', '=', $token)->first();
            if (!$isToken)
                throw new Exception('Token salah!', 401);

            $user = [
                'name'  => request('name'),
                'username'  => request('username'),
                'password'  => Hash::make(request('password')),
                'type'  => 3
            ];
            $id = DB::table('users')->insertGetId($user);
            $applicant_datas = [
                'user_id'       => $id,
                'name'          => request('name')
            ];
            DB::table('applicant_datas')->insert($applicant_datas);
            DB::table('applicant_tokens')->where('token', '=', $token)->delete();
            DB::commit();
            $res = [
                'status'    => 200,
                'message'   => 'Registrasi berhasil'
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
