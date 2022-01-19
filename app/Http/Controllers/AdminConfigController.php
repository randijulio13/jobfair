<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AdminConfigController extends Controller
{
    function index()
    {
        $config = DB::table('web_config')->where('id', '=', 1)->first();
        return view('admin/config', compact('config'));
    }

    function update(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'title_description' => ['required'],
            'about_us' => ['required'],
            'phone' => ['required'],
            'email' => ['required'],
            'address' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            DB::table('web_config')->where('id', '=', 1)->update(request()->all());
            DB::commit();
            return response()->json([
                'status'    => 200,
                'message'   => 'OK'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'    => $e->getCode(),
                'message'   => $e->getMessage()
            ], 400);
        }
    }

    function datatables_banner()
    {
        $banner = DB::table('banners')->get();
        return datatables($banner)
            ->addIndexColumn()
            ->setRowId(function ($data) {
                return $data->id;
            })
            ->addColumn('file', function ($data) {
                return '<img class="img-fluid" src="/assets/img/banners/' . $data->file . '" width="150px">';
            })
            ->addColumn('aksi', function ($data) {
                return '<a class="btn btn-danger btn-sm btn-hapus">Hapus</a>';
            })
            ->addColumn('status', function ($data) {
                $checked = $data->status ? 'checked'  : '';
                return '<div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input status-banner" ' . $checked . ' id="status' . $data->id . '">
                <label class="custom-control-label" for="status' . $data->id . '"></label>
              </div>';
            })
            ->rawColumns(['file', 'aksi', 'status'])
            ->toJson();
    }

    function store_banner(Request $request)
    {
        if (!$request->has('file') && !$request->description && !$request->title)
            $request->validate([
                'file'  => ['required'],
                'title' => ['required'],
                'description'   => ['required']
            ], [
                'required'  => 'Minimal isi 1 form'
            ]);


        try {
            DB::beginTransaction();
            if ($request->has('file')) {
                $image = $request->file;
                $namaFileBaru = date('Ymd') . rand(0, 9999) . 'Banner' . '.' . request('file')->getClientOriginalExtension();
            }
            $data = [
                'title'     => request('title'),
                'description'   => request('description'),
                'status'    => 1,
            ];
            if ($request->has('file')) {
                $data['file'] = $namaFileBaru;
                $image->move('assets/img/banners/', $namaFileBaru);
            }
            DB::table('banners')->insert($data);
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

    function update_status_banner($id)
    {
        $status = request('status') == 'true' ? 1 : 0;
        DB::table('banners')->where('id', '=', $id)->update(['status' => $status]);
        return response()->json([
            'status'    => 200,
            'message'   => 'Berhasil update status'
        ], 200);
    }

    function delete_banner($id)
    {
        try {
            DB::beginTransaction();
            $banner = DB::table("banners")->where('id', '=', $id)->value('file');
            if ($banner) {
                if (file_exists('assets/img/banners/' . $banner)) {
                    unlink('assets/img/banners/' . $banner);
                };
            }
            DB::table('banners')->where('id', '=', $id)->delete();
            DB::commit();
            $res = [
                'status'    => 201,
                'message'   => 'Data berhasil dihapus'
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
