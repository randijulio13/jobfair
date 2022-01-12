<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminUserController extends Controller
{
    function index($type)
    {
        return view('admin/user', compact('type'));
    }

    function datatables($type)
    {
        $type = $type == 'sponsor' ? 2 : 3;
        $user = DB::table('users')->where('users.type', '=', $type)->select('users.*', 'type.type')->join('user_types as type', 'type.id', '=', 'users.type')->get();
        return datatables($user)
            ->addIndexColumn()
            ->setRowId(function ($data) {
                return $data->id;
            })
            ->addColumn('aksi', function ($data) {
                return '<a class="btn btn-primary btn-sm">Edit</a>';
            })
            ->addColumn('status', function ($data) use ($type) {
                if ($type == 2) {
                    $options = [
                        'Nonaktif', 'Aktif',
                    ];
                } else {
                    $options = [
                        'Nonaktif', 'Aktif', 'Pending', 'Menunggu Pembayaran'
                    ];
                }
                $str = '';
                foreach ($options as $i => $opt) {
                    $selected = $data->status == $i ? 'selected' : '';
                    $str .= '<option value="' . $i . '" ' . $selected . '>' . $opt . '</option>';
                }
                return '<select class="form-control status-user" id="status' . $data->id . '">' . $str . '</select>';
            })
            ->rawColumns(['name', 'aksi', 'type', 'status'])
            ->toJson();
    }

    function update_status($id)
    {
        $status = request('status');
        DB::table('users')->where('id', '=', $id)->update(['status' => $status]);
        return response()->json([
            'status'    => 200,
            'message'   => 'Berhasil update status'
        ], 200);
    }

    function send_notif(Request $request)
    {
        $data = request()->all();
        $message_id = DB::table('messages')->insertGetId($data);
        DB::table('new_messages')->insert(['message_id' => $message_id, 'user_id' => request('receiver_id')]);
        return true;
    }
}
