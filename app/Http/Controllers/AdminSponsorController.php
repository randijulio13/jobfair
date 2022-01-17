<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSponsorController extends Controller
{
    function index()
    {
        $types = DB::table('sponsor_types')->get();
        return view('admin/sponsor', compact('types'));
    }

    function datatables()
    {
        $sponsor = DB::table('sponsors as s')->select('s.*', 'st.type as type')->join('sponsor_types as st', 'st.id', '=', 's.type')->get();
        return datatables($sponsor)
            ->addIndexColumn()
            ->setRowId(function ($data) {
                return $data->id;
            })
            ->addColumn('logo', function ($data) {
                return '<img src="/assets/img/' . $data->logo . '" width="150px">';
            })
            ->addColumn('aksi', function () {
                return '<a class="btn btn-primary btn-sm btn-edit">Edit</a>';
            })
            ->addColumn('type', function ($data) {
                $color = $data->type == 'Platinum' ? 'primary' : ($data->type == 'Gold' ? 'warning' : 'secondary');
                return '<span class="badge badge-pill badge-' . $color . '">' . $data->type . '</span>';
            })
            ->addColumn('status', function ($data) {
                $checked = $data->status ? 'checked'  : '';
                return '<div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input status-sponsor" ' . $checked . ' id="status' . $data->id . '">
                <label class="custom-control-label" for="status' . $data->id . '"></label>
              </div>';
            })
            ->rawColumns(['aksi', 'type', 'logo', 'status'])
            ->toJson();
    }

    function store(Request $request)
    {
        $request->validate([
            'name'  => ['required'],
            'type'  => ['required'],
            'description'   => ['required'],
            'logo'  => ['required'],
            'username'  => ['required'],
        ]);
        try {
            DB::beginTransaction();
            $image = $request->logo;
            $namaFileBaru = date('Ymd') . rand(0, 9999) . Str::slug(request('name'), '-') . '.' . request('logo')->getClientOriginalExtension();
            $dataUser = [
                'name'  => request('name'),
                'username'  => request('username'),
                'password'  => Hash::make('1234'),
                'type'  => 2
            ];
            $user_id = DB::table('users')->insertGetId($dataUser);
            $data = [
                'name'  => request('name'),
                'description'    => request('description'),
                'logo'  => $namaFileBaru,
                'type'  => request('type'),
                'user_id'   => $user_id
            ];
            DB::table('sponsors')->insert($data);
            $image->move('assets/img/', $namaFileBaru);
            DB::commit();
            $res = [
                'status'    => 201,
                'message'   => 'Berhasil buat data sponsor'
            ];
        } catch (Exception $e) {
            DB::rollBack();
            $res = [
                'status'    => $e->getCode() ?? 400,
                'message'   => $e->getMessage() ?? 'Terjadi kesalahan'
            ];
        }

        return response()->json($res, $res['status']);
    }

    function update(Request $request, $id)
    {
        $request->validate([
            'name'  => ['required'],
            'type'  => ['required'],
            'description'   => ['required'],
        ]);
        try {
            DB::beginTransaction();
            $sponsor = DB::table('sponsors')->where('id', '=', $id)->first();
            $data = [
                'name'  => request('name'),
                'description'    => request('description'),
                'type'  => request('type'),
            ];
            if (request()->has('logo')) {
                $image = $request->logo;
                $namaFileBaru = date('Ymd') . rand(0, 9999) . Str::slug(request('name'), '-') . '.' . request('logo')->getClientOriginalExtension();
                $data['logo']  = $namaFileBaru;
            }
            DB::table('sponsors')->where('id', '=', $id)->update($data);
            if (request()->has('logo')) {
                $image->move('assets/img/', $namaFileBaru);
                if ($sponsor->logo) {
                    if (file_exists('assets/img/' . $sponsor->logo)) {
                        unlink('assets/img/' . $sponsor->logo);
                    };
                }
            }
            DB::commit();
            $res = [
                'status'    => 200,
                'message'   => 'Berhasil update data sponsor'
            ];
        } catch (Exception $e) {
            DB::rollBack();
            $res = [
                'status'    => $e->getCode() ?? 400,
                'message'   => $e->getMessage() ?? 'Terjadi kesalahan'
            ];
        }

        return response()->json($res, $res['status']);
    }

    function update_status($id)
    {
        $status = request('status') == 'true' ? 1 : 0;
        DB::table('sponsors')->where('id', '=', $id)->update(['status' => $status]);
        return response()->json([
            'status'    => 200,
            'message'   => 'Berhasil update status'
        ], 200);
    }

    function get($id)
    {
        try {
            $sponsor = DB::table('sponsors')->where('id', '=', $id)->first();
            if (!$sponsor)
                throw new Exception('Data sponsor tidak ditemukan', 404);
            $res = [
                'status'    => 200,
                'message'   => 'OK',
                'data'      => $sponsor
            ];
        } catch (Exception $e) {
            $res = [
                'status'    => $e->getCode() ?? 400,
                'message'   => $e->getMessage() ?? 'Terjadi kesalahan'
            ];
        }
        return response()->json($res, $res['status']);
    }

    function select2()
    {
        $sponsor = DB::table('sponsors')->where('name', 'like', '%' . request('q') . '%')->get();
        return response()->json($sponsor);
    }   
}
