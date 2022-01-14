<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminProfilSponsorController extends Controller
{
    function index()
    {
        $user_id = DB::table('users')->where('id', '=', session('userdata')['id'])->value('id');
        $sponsor = DB::table('sponsors')->where('user_id', '=', $user_id)->first();
        return view('admin/profile', compact('sponsor'));
    }

    function update(Request $request)
    {
        $id = DB::table('sponsors as s')
            ->join('users as u', 'u.id', '=', 's.user_id')
            ->where('u.id', '=', session('userdata')['id'])
            ->value('s.id');

        $request->validate(
            [
                'name' => ['required'],
                'description'   => ['required'],
            ],
            ['required' => ':attribute harus diisi'],
            [
                'name' => 'Nama',
                'description'   => 'Deskripsi',
            ]
        );
        try {
            DB::beginTransaction();
            $sponsors = DB::table('sponsors')->where('id', '=', $id)->first();
            $data = [
                'name' => request('name'),
                'description'   => request('description'),
            ];
            if (request()->has('logo')) {
                $image = $request->logo;
                $namaFileBaru = date('Ymd') . rand(0, 9999) . Str::slug(request('name'), '-') . '.' . request('logo')->getClientOriginalExtension();
                $data['logo']  = $namaFileBaru;
            }
            DB::table('sponsors')->where('id', '=', $id)->update($data);
            if (request()->has('logo')) {
                $image->move('assets/img/', $namaFileBaru);
                if ($sponsors->logo) {
                    if (file_exists('assets/img/' . $sponsors->logo)) {
                        unlink('assets/img/' . $sponsors->logo);
                    };
                }
            }
            $res = [
                'status'    => 201,
                'message'   => 'Profil berhasil diupdate'
            ];
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $res = [
                'status'    => $e->getCode() ?? 400,
                'message'   => $e->getMessage() ?? 'Terjadi kesalahan'
            ];
        }
        return response()->json($res, $res['status']);
    }
}
