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
        return datatables($data)->addIndexColumn()->toJson();
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
}
