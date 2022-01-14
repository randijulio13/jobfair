<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminMessageController extends Controller
{
    function index()
    {
        return view('admin/message');
    }

    function datatables()
    {
        $id = session('userdata')['id'];
        if ($id != 1) {
            $data = DB::table('messages')
                ->where('sender_id', '=', $id)
                ->orWhere('receiver_id', '=', $id)
                ->get();
        } else {
            $data = DB::table('messages')
                ->where('receiver_id', '=', 1)
                ->get();
        }
        return datatables($data)
            ->addIndexColumn()
            ->setRowId(function ($data) {
                return $data->id;
            })
            ->addColumn('from', function ($data) {
                $verified = 'secondary';
                $icon = '';
                if ($data->sender_id) {
                    $user = get_userdata_applicant($data->sender_id);
                    $verified = $user->status == 1 ? 'success' : 'warning';
                    $check = $user->status == 1 ? 'fa-check-circle' : 'fa-exclamation-triangle';
                    $icon = '<i class="fa ' . $check . '"></i>';
                }
                return $data->sender_name . ' <span class="text-' . $verified . '">' . $icon . '</span>';
            })
            ->addColumn('subject', function ($data) {
                return '<b>' . $data->subject . '</b>';
            })
            ->addColumn('aksi', function ($data) {
                return '<a href="/admin/message/' . $data->id . '" class="btn btn-primary btn-sm btnDetail"> Detail</a>&nbsp;<a class="btn btn-danger btn-sm btn-hapus"> Delete</a>';
            })
            ->addColumn('seen', function ($data) {
                $seen = DB::table('new_messages')->where('message_id', '=', $data->id)->where('user_id', '=', session('userdata')['id'])->count();
                if ($seen)
                    return '<span class="badge badge-danger badge-pill">New!</span>';
            })
            ->rawColumns(['aksi', 'seen', 'subject', 'from'])
            ->toJson();
    }

    function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'sender_phone' => ['required'],
            'subject' => ['required'],
            'message' => ['required']
        ]);

        try {
            DB::beginTransaction();
            $data = [
                'sender_id' => request('sender_id') ?? null,
                'sender_name'   => request('name'),
                'sender_phone' => request('sender_phone'),
                'subject'   => request('subject'),
                'message'   => request('message'),
                'receiver_id'   => request('receiver_id') ?? 1,
            ];
            $message_id = DB::table('messages')->insertGetId($data);
            DB::table('new_messages')->insert([
                'message_id' => $message_id,
                'user_id'   => request('receiver_id') ?? 1
            ]);
            DB::commit();
            return response()->json([
                'status'    => 200,
                'message'   => 'OK'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'    => $e->getCode() ?? 400,
                'message'   => $e->getMessage() ?? 'Error'
            ]);
        }
    }

    function detail($id)
    {
        $message = DB::table('messages')->where('id', '=', $id)->first();
        $is_allowed = $this->is_allowed($message);
        if (!$is_allowed) {
            return redirect('/admin/message');
        }
        if ($message->receiver_id == session('userdata')['id']) {
            DB::table('new_messages')->where('message_id', '=', $id)->where('user_id', '=', session('userdata')['id'])->delete();
        }
        return view('admin/message_detail', compact('message'));
    }

    function is_allowed($message)
    {
        $id = session('userdata')['id'];
        if (session('userdata')['id'] == 1)
            return true;
        if ($message->sender_id == $id)
            return true;
        if ($message->receiver_id == $id)
            return true;
        return false;
    }

    function delete($id)
    {
        try {
            DB::beginTransaction();
            $attachment = DB::table('messages')->where('id', '=', $id)->value('attachment');
            DB::table('messages')->where('id', '=', $id)->delete();
            DB::table('new_messages')->where('message_id', '=', $id)->delete();
            if ($attachment) {
                if (file_exists('assets/img/payment/' . $attachment)) {
                    unlink('assets/img/payment/' . $attachment);
                };
            }
            DB::commit();
            return response()->json([
                'status'    => 200,
                'message'   => 'OK'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'    => $e->getCode() ?? 400,
                'message'   => $e->getMessage() ?? 'Error'
            ]);
        }
    }
}
