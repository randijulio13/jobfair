<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    function index()
    {
        $data = DB::table('applicant_datas')->where('user_id', '=', session('userdata_applicant')['id'])->first();
        $user = DB::table('users')->where('id', '=', session('userdata_applicant')['id'])->first();
        if ($user->status != 1)
            return view('profile_inactive', compact('data', 'user'));
        $isComplete = 0;

        $career_fields = DB::table('career_fields')->get();
        $applicant_id = DB::table('applicant_datas')->where('user_id', '=', session('userdata_applicant')['id'])->value('id');
        $applicant_fields = DB::table('applicant_fields')->where('applicant_id', '=', $applicant_id)->get();
        foreach ($data as $d) {
            if ($d == NULL)
                $isComplete++;
        }
        return view('profile', compact('data', 'isComplete', 'career_fields', 'applicant_fields'));
    }

    private function update_fields($fields, $applicant_id)
    {
        DB::beginTransaction();
        try {
            $data = [];
            foreach ($fields as $f) {
                $data[] = [
                    'field_id'  => $f,
                    'applicant_id'  => $applicant_id
                ];
            }
            DB::table('applicant_fields')->where('applicant_id', '=', $applicant_id)->delete();
            DB::table('applicant_fields')->insert($data);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    function update(Request $request)
    {
        $request->validate([
            'name'  => ['required'],
            'gender'    => ['required'],
            'dob'  => ['required'],
            'pob'  => ['required'],
            'last_edu'  => ['required'],
            'grad_year'  => ['required'],
            'major'  => ['required'],
            'file' => ['mimes:pdf', 'max:5000']
        ], [
            'file.max' => 'Ukuran file tidak boleh lebih dari :max kilobytes',
            'required'  => ':attribute harus diisi'
        ], [
            'name'  => 'Nama',
            'gender' => 'Jenis kelamin',
            'dob' => 'Tanggal lahir',
            'pob' => 'Tempat lahir',
            'last_edu' => 'Pendidikan terakhir',
            'grad_year' => 'Tahun lulus',
            'major' => 'Jurusan'
        ]);
        try {
            DB::beginTransaction();
            if (request()->has('file')) {
                $oldfile = DB::table('applicant_datas')->where('user_id', '=', session('userdata_applicant')['id'])->value('file');
                $image = $request->file;
                $namaFileBaru = date('Ymd') . rand(0, 9999) . Str::slug(request('name'), '-') . '.' . request('file')->getClientOriginalExtension();
                $data = [
                    'name'        => request('name'),
                    'gender'      => request('gender'),
                    'pob'         => request('pob'),
                    'dob'         => request('dob'),
                    'last_edu'    => request('last_edu'),
                    'major'       => request('major'),
                    'grad_year'   => request('grad_year'),
                    'file'        => $namaFileBaru,
                ];
                $image->move('assets/cv/', $namaFileBaru);
            } else {
                $data = [
                    'name'        => request('name'),
                    'gender'      => request('gender'),
                    'pob'         => request('pob'),
                    'dob'         => request('dob'),
                    'last_edu'    => request('last_edu'),
                    'major'       => request('major'),
                    'grad_year'   => request('grad_year'),
                ];
            }
            DB::table('applicant_datas')->where('user_id', '=', session('userdata_applicant')['id'])->update($data);
            $applicant_id = DB::table('applicant_datas')->where('user_id', '=', session('userdata_applicant')['id'])->value('id');
            if (!$this->update_fields(request('fields'), $applicant_id))
                throw new Exception('Terjadi kesalahan', 400);
            if (request()->has('file')) {
                if ($oldfile) {
                    if (file_exists('assets/cv/' . $oldfile)) {
                        unlink('assets/cv/' . $oldfile);
                    };
                }
            }
            DB::commit();
            $res = [
                'status'  => 200,
                'message'   => 'Data berhasil disimpan'
            ];
        } catch (Exception $e) {
            DB::rollBack();
            $res = [
                'status'  => $e->getCode() ?? 400,
                'message'   => $e->getMessage() ?? 'Terjadi kesalahan',
            ];
        }
        return response()->json($res, $res['status']);
    }

    function check_login()
    {
        if (!session('userdata_applicant')) {
            return false;
        }

        return true;
    }

    function vacancy_history()
    {
        $id = get_applicant_id(session('userdata_applicant')['id']);
        $vacancies = DB::table('vacancy_applicants as va')
            ->select('va.*', 'v.*', 's.name as sponsor_name', 's.logo', 'cf.name as career_field')
            ->join('vacancies as v', 'v.id', '=', 'va.vacancy_id')
            ->join('career_fields as cf', 'cf.id', '=', 'v.career_field')
            ->join('sponsors as s', 's.id', '=', 'v.sponsor_id')
            ->where('applicant_id', '=', $id)->paginate(6);
        // return $vacancies;
        return view('vacancy_history', compact('vacancies'));
    }

    function notification()
    {
        $notifications = DB::table('messages')->where('receiver_id', '=', session('userdata_applicant')['id'])->orderBy('created_at','desc')->paginate(6);
        return view('notification', compact('notifications'));
    }

    function delete_notif($id)
    {
        DB::table('messages')->where('id','=',$id)->delete();
        DB::table('new_messages')->where('message_id','=',$id)->delete();
        return true;
    }

    function payment(Request $request)
    {
        $request->validate([
            'attachment'  => ['required','mimes:jpg,bmp,png,jpeg'],
        ]);
        try {
            DB::beginTransaction();
            $image = $request->attachment;
            $namaFileBaru = date('Ymd') . rand(0, 9999) . Str::slug(session('userdata_applicant')['username'], '-') . '.' . request('attachment')->getClientOriginalExtension();
            $user = get_userdata_applicant();
            $message = '
            <h4>Data User</h4>
            <ul class="mb-4">
            <li><strong>Username :</strong> ' . $user->username . '</li>
            <li><strong>Name :</strong> ' . $user->name . '</li>
            <li><strong>Email :</strong> ' . $user->email . '</li>
            <li><strong>Nomor HP :</strong> ' . $user->phone . '</li>
            <li><strong>Bergabung tanggal :</strong> ' . $user->created_at . '</li>
            </ul>
            
            <a href="#" class="btn btn-primary btnActive" data-id="' . $user->id . '">Aktifkan user</a>
            <a href="#" class="btn btn-danger btnReject">Tolak</a>
            
            ';
            $data = [
                'sender_id' => $user->id,
                'sender_name'   => $user->name,
                'sender_email'  => $user->email,
                'sender_phone'  => $user->phone,
                'receiver_id'   => 1,
                'subject'       => 'Submit Pembayaran',
                'message'       => $message,
                'attachment'    => $namaFileBaru
            ];
            $notif = [
                'sender_id' => 1,
                'sender_name'   => 'Admin',
                'receiver_id'   => session('userdata_applicant')['id'],
                'subject'   => 'Bukti Pembayaran berhasil disubmit',
                'message'   => 'Bukti pembayaran anda berhasil disubmit dan sedang ditinjau'
            ];

            $notif_id = DB::table('messages')->insertGetId($notif);
            $message_id = DB::table('messages')->insertGetId($data);
            DB::table('new_messages')->insert([
                'message_id'    => $message_id,
                'user_id'   => 1
            ]);
            DB::table('new_messages')->insert([
                'message_id'    => $notif_id,
                'user_id'   => session('userdata_applicant')['id']
            ]);
            DB::table('users')->where('id', '=', $user->id)->update(['status'=>2]);
            $image->move('assets/img/payment/', $namaFileBaru);
            DB::commit();
            $res = [
                'status'    => 201,
                'message'   => 'Berhasil submit bukti transfer'
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
