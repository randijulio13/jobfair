<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminCareerFieldController extends Controller
{
    function index()
    {
        return view('admin/career_field');
    }

    function get($id)
    {
        return DB::table('career_fields')->where('id', '=', $id)->first();
    }

    function delete($id)
    {
        DB::beginTransaction();
        try {
            DB::table('career_fields')->where('id', '=', $id)->delete();
            DB::commit();
            $res = [
                'status'    => 200,
                'message'   => 'Data berhasil dihapus'
            ];
        } catch (Exception $e) {
            DB::rollBack();
            $res = [
                'status' => $e->getCode() ?? 400,
                'message' => $e->getMessage() ?? 'Terjadi kesalahan'
            ];
        }
        return response()->json($res, $res['status']);
    }

    function datatable()
    {
        $data = DB::table('career_fields')->get();
        return datatables($data)
            ->setRowId(function ($data) {
                return $data->id;
            })
            ->addIndexColumn()
            ->addColumn('aksi', function ($data) {
                return '<div class="btn-group"><a class="btn btn-success btn-sm btn-edit">Edit</a><a class="btn btn-danger btn-sm btn-hapus">Hapus</a></div>';
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    function store(Request $request)
    {
        $request->validate([
            'name'  => ['required']
        ], [
            'name.required' => 'Nama bidang harus diisi'
        ]);
        try {
            DB::table('career_fields')->insert(['name' => request('name')]);
            DB::commit();
            $res = [
                'status'    => 200,
                'message'   => 'Berhasil tambah data bidang'
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
            'name'  => ['required']
        ], [
            'name.required' => 'Nama bidang harus diisi'
        ]);
        try {
            DB::table('career_fields')->where('id', '=', $id)->update(['name' => request('name')]);
            DB::commit();
            $res = [
                'status'    => 200,
                'message'   => 'Berhasil update data bidang'
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
}
