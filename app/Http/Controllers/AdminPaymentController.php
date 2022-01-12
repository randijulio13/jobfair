<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminPaymentController extends Controller
{
    function index()
    {
        return view('admin/payment');
    }

    function get($id)
    {
        try {
            $payment = DB::table('payment_methods')->where('id', '=', $id)->first();
            if (!$payment)
                throw new Exception('Metode pembayaran tidak ditemukan', 404);
            return response()->json([
                'status'    => 200,
                'message'   => 'OK',
                'data'      => $payment
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'    => $e->getCode() ?? 400,
                'message'   => $e->getMessage() ?? 'Error'
            ], 400);
        }
    }

    function delete($id)
    {
        try {
            $payment = DB::table('payment_methods')->where('id', '=', $id)->first();
            if (!$payment)
                throw new Exception('Metode pembayaran tidak ditemukan', 404);
            DB::table('payment_methods')->where('id', '=', $id)->delete();
            if ($payment->logo) {
                if (file_exists('assets/img/payment_method/' . $payment->logo)) {
                    unlink('assets/img/payment_method/' . $payment->logo);
                };
            }
            return response()->json([
                'status'    => 200,
                'message'   => 'Data berhasil dihapus',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'    => $e->getCode() ?? 400,
                'message'   => $e->getMessage() ?? 'Error'
            ], 400);
        }
    }

    function datatables()
    {
        $data = DB::table('payment_methods')->get();
        return datatables($data)
            ->setRowId(function ($data) {
                return $data->id;
            })
            ->addIndexColumn()
            ->addColumn('aksi', function ($data) {
                return '
                <div class="btn-group">
                <a class="btn btn-primary btn-sm btn-edit">Edit</a>
                <a class="btn btn-danger btn-sm btn-delete">Hapus</a>
                </div>
                ';
            })
            ->addColumn('status', function ($data) {
                $checked = $data->status ? 'checked'  : '';
                return '<div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input status-payment" ' . $checked . ' id="status' . $data->id . '">
                <label class="custom-control-label" for="status' . $data->id . '"></label>
              </div>';
            })
            ->addColumn('logo', function ($data) {
                return '<img src="/assets/img/payment_method/' . $data->logo . '" width="100px">';
            })
            ->rawColumns(['aksi', 'description', 'logo', 'status'])
            ->toJson();
    }

    function update_status($id)
    {
        $status = request('status') == 'true' ? 1 : 0;
        DB::table('payment_methods')->where('id', '=', $id)->update(['status' => $status]);
        return response()->json([
            'status'    => 200,
            'message'   => 'Berhasil update status'
        ], 200);
    }

    function store(Request $request)
    {
        $request->validate([
            'name'  => ['required'],
            'description'   => ['required'],
            'logo'  => ['required']
        ]);

        try {
            DB::beginTransaction();
            $image = $request->logo;
            $namaFileBaru = date('Ymd') . rand(0, 9999) . Str::slug(request('name'), '-') . '.' . request('logo')->getClientOriginalExtension();
            $data = [
                'name'  => request('name'),
                'description'   => request('description'),
                'logo'      => $namaFileBaru,
                'status'    => 1,
            ];
            DB::table('payment_methods')->insert($data);
            $image->move('assets/img/payment_method/', $namaFileBaru);
            DB::commit();
            $res = [
                'status'    => 201,
                'message'   => 'Data berhasil dibuat'
            ];
        } catch (Exception $e) {
            DB::rollBack();
            $res = [
                'status'    => $e->getCode() ?? 400,
                'message'   => $e->getMessage() ?? 'Terjadi kesalahan'
            ];
        }

        return response()->json($res);
    }

    function update(Request $request, $id)
    {
        $request->validate([
            'name'  => ['required'],
            'description'   => ['required'],
        ]);

        try {
            $payment = DB::table('payment_methods')->where('id', '=', $id)->first();
            DB::beginTransaction();
            if (request()->has('logo')) {
                $image = $request->logo;
                $namaFileBaru = date('Ymd') . rand(0, 9999) . Str::slug(request('name'), '-') . '.' . request('logo')->getClientOriginalExtension();
            }
            $data = [
                'name'  => request('name'),
                'description'   => request('description'),
            ];
            if (request()->has('logo')) {
                $data['logo'] = $namaFileBaru;
                $image->move('assets/img/payment_method/', $namaFileBaru);
                if ($payment->logo) {
                    if (file_exists('assets/img/payment_method/' . $payment->logo)) {
                        unlink('assets/img/payment_method/' . $payment->logo);
                    };
                }
            }
            DB::table('payment_methods')->where('id', '=', $id)->update($data);
            DB::commit();
            $res = [
                'status'    => 201,
                'message'   => 'Data berhasil diperbarui'
            ];
        } catch (Exception $e) {
            DB::rollBack();
            $res = [
                'status'    => $e->getCode() ?? 400,
                'message'   => $e->getMessage() ?? 'Terjadi kesalahan'
            ];
        }
        return response()->json($res);
    }
}
