<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminTokenController extends Controller
{
    function index()
    {
        return view('admin/token');
    }

    function generate()
    {
        $quantity = request('quantity') ?? 1;
        for ($i = 0; $i < $quantity; $i++) {
            $token[$i] = ['token' => bin2hex(random_bytes(5))];
        }
        DB::beginTransaction();
        try {
            DB::table('applicant_tokens')->insert($token);
            DB::commit();
            $res = [
                'status'    => 200,
                'message'   => 'Berhasil generate ' . $quantity . ' token'
            ];
        } catch (Exception $e) {
            DB::rollBack();
            $res = [
                'status'    => $e->getCode(),
                'message'   => $e->getMessage()
            ];
        }
        return response()->json($res);
    }

    function datatable()
    {
        $data = DB::table('applicant_tokens')->get();
        return datatables($data)
            ->addIndexColumn()
            ->setRowId(function ($data) {
                return $data->id;
            })
            ->addColumn('aksi', function () {
                return '<a class="btn btn-sm btn-danger btn-hapus"><i class="fa fa-trash-alt"></i> Hapus</a>';
            })
            ->addColumn('status', function ($data) {
                $checked = $data->status ? 'checked'  : '';
                return '<div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input status-sponsor" ' . $checked . ' id="status' . $data->id . '">
                <label class="custom-control-label" for="status' . $data->id . '"></label>
              </div>';
            })
            ->rawColumns(['aksi','status'])
            ->toJson();
    }

    function get($token)
    {
        try {
            $check = DB::table('applicant_tokens')->where('token', '=', $token)->count();
            if (!$check) {
                throw new Exception('Token tidak ditemukan', 404);
            }
            $res = [
                'status'    => 200,
                'message'   => 'Token ditemukan'
            ];
        } catch (Exception $e) {
            $res = [
                'status'    => $e->getCode() ?? 400,
                'message'   => $e->getMessage() ?? 'Terjadi kesalahan'
            ];
        }
        return response()->json($res, $res['status']);
    }

    function delete($id)
    {
        DB::table('applicant_tokens')->where('id','=',$id)->delete();
        return true;
    }
}
