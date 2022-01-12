<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    
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
}
