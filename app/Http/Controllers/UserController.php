<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function register(Request $request, $token = null)
    {
        $rules = [
            'name'  => ['required'],
            'username'  => ['required', 'unique:users'],
            'password'  => ['required', 'confirmed'],
            'phone' => ['required'],
            'email' => ['required','email']
        ];
        $messages = [
            'name.required' => 'Nama harus diisi',
            'username.required' => 'Username harus diisi',
            'phone.required' => 'Nomor HP harus diisi',
            'email.required' => 'Email harus diisi',
            'username.unique'   => 'Username sudah digunakan',
            'password.required' => 'Password harus diisi',
            'password.confirmed'    => 'Konfirmasi password salah'
        ];
        $request->validate($rules, $messages);
        DB::beginTransaction();
        try {
            if ($token) {
                $isToken = DB::table('applicant_tokens')->where('token', '=', $token)->first();
                if (!$isToken)
                    throw new Exception('Token salah!', 401);
                $this->store(true, $token);
            } else {
                $this->store(false);
            }
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

    function store($active, $token = null)
    {
        $user = [
            'name'  => request('name'),
            'username'  => request('username'),
            'password'  => Hash::make(request('password')),
            'phone' => request('phone'),
            'email' => request('email'),
            'type'  => 3,
            'status'    => $active ? 1 : 3
        ];
        $id = DB::table('users')->insertGetId($user);
        $message = [
            'sender_id' => 1,
            'sender_name'   => 'Admin',
            'subject'       => 'Akun berhasil dibuat',
            'receiver_id'   => $id,
            'message'   => 'Akun anda berhasil dibuat, silahkan melakukan pembayaran untuk aktivasi akun anda'
        ];
        $message_id = DB::table('messages')->insertGetId($message);
        DB::table('new_messages')->insert(['message_id' => $message_id, 'user_id' => $id]);
        $applicant_datas = [
            'user_id'       => $id,
            'name'          => request('name')
        ];
        DB::table('applicant_datas')->insert($applicant_datas);
        DB::table('applicant_tokens')->where('token', '=', $token)->delete();
    }
}
