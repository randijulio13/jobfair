<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VacancyController extends Controller
{
    function index()
    {
        $vacancies = DB::table('vacancies')
            ->select('vacancies.*', 'cf.name as career_field', 's.name as nama_sponsor', 's.logo');
        if (request()->has('field'))
            $vacancies = $vacancies->where('cf.name', 'like', '%' . request('field') . '%');
        if (request()->has('sponsor'))
            $vacancies = $vacancies->where('s.name', 'like', '%' . request('sponsor') . '%');
        if (request()->has('q'))
            $vacancies = $vacancies->where(function ($q) {
                $q->where('vacancies.title', 'like', '%' . request('q') . '%')
                    ->orWhere('vacancies.description', 'like', '%' . request('q') . '%')
                    ->orWhere('s.name', 'like', '%' . request('q') . '%')
                    ->orWhere('cf.name', 'like', '%' . request('q') . '%');
            });
        $vacancies = $vacancies->where('vacancies.status', '=', 1)
            ->where('s.status', '=', 1)
            ->join('career_fields as cf', 'cf.id', '=', 'vacancies.career_field')
            ->join('sponsors as s', 's.id', '=', 'vacancies.sponsor_id')
            ->paginate(9);
        // return $vacancies;
        return view('vacancy', compact('vacancies'));
    }

    function detail($id)
    {
        if (session('userdata_applicant')) {
            $applicant_id = DB::table('applicant_datas')->where('user_id', '=', session('userdata_applicant')['id'])->value('id');
            $isSent = DB::table('vacancy_applicants')->where('vacancy_id', '=', $id)->where('applicant_id', '=', $applicant_id)->first();
        } else {
            $isSent = 0;
        }
        $vacancy = DB::table('vacancies')->where('vacancies.id', '=', $id)
            ->select('vacancies.*', 'cf.name as career_field', 's.name as nama_sponsor', 's.logo')
            ->join('career_fields as cf', 'cf.id', '=', 'vacancies.career_field')
            ->join('sponsors as s', 's.id', '=', 'vacancies.sponsor_id')
            ->first();
        return view('vacancy_detail', compact('vacancy', 'isSent'));
    }

    function store()
    {
        try {
            DB::beginTransaction();
            if (!session('userdata_applicant'))
                throw new Exception('Anda belum login', 401);

            $password = DB::table('users')
                ->where('id', '=', session('userdata_applicant')['id'])
                ->value('password');

            $pass = Hash::check(request('password'), $password);

            if (!$pass)
                throw new Exception('Password anda salah', 401);


            $applicant = DB::table('applicant_datas')
                ->where('user_id', '=', session('userdata_applicant')['id'])
                ->first();

            $applicant_user = DB::table('users')
                ->where('id', '=', $applicant->user_id)
                ->first();

            $vacancy = DB::table('vacancies')
                ->where('id', '=', request('vacancy_id'))
                ->first();

            $check = DB::table('vacancy_applicants')
                ->where('applicant_id', '=', $applicant->id)
                ->where('vacancy_id', '=', request('vacancy_id'))
                ->count();

            if ($check)
                throw new Exception('Anda sudah mengirim CV ke lowongan ini', 400);

            $isComplete = 0;
            foreach ($applicant as $d) {
                if ($d == NULL)
                    $isComplete++;
            }

            if ($isComplete)
                throw new Exception('Data diri belum lengkap', 401);

            $sponsor_user_id = DB::table('vacancies as v')
                ->join('sponsors as s', 's.id', '=', 'v.sponsor_id')
                ->join('users as u', 'u.id', '=', 's.user_id')
                ->where('v.id', '=', request('vacancy_id'))
                ->value('u.id');

            DB::table('vacancy_applicants')->insert([
                'vacancy_id'    => request('vacancy_id'),
                'applicant_id'  => $applicant->id,
            ]);

            $isMatch = DB::table('applicant_fields')->where('field_id', '=', $vacancy->career_field)->where('applicant_id', '=', $applicant->id)->count();
            if ($isMatch) {
                $gender = $applicant->gender == 'L' ? 'Laki-laki' : 'Perempuan';
                $message = '<h4>Data Pelamar</h4>
                    <ul class="mb-4">
                    <li><strong>Name :</strong> ' . $applicant->name . '</li>
                    <li><strong>Gender :</strong> ' . $gender . '</li>
                    <li><strong>Pendidikan :</strong> ' . $applicant->last_edu . ' - ' . $applicant->major . '</li>
                    <li><strong>Tahun Lulus :</strong> ' . $applicant->grad_year . '</li>
                    <li><strong>No. HP :</strong> ' . $applicant_user->phone . '</li>
                    <li><strong>Email :</strong> ' . $applicant_user->email . '</li>
                    </ul>

                    <p>Mendaftar diloker <a href="/admin/vacancy/' . $vacancy->id . '">' . $vacancy->title . '</a></p>
                    
                    <a href="/assets/cv/' . $applicant->file . '" target="_blank" class="btn btn-primary" data-id="3">Lihat CV</a>
                    <a href="mailto:' . $applicant_user->email . '" class="btn btn-danger">Whatsapp</a>
                    <a href="https://wa.me/' . hp($applicant_user->phone) . '" class="btn btn-success">WA</a>';

                $message_id = DB::table('messages')->insertGetId([
                    'sender_id'     => 1,
                    'sender_name'   => 'System',
                    'receiver_id'   => $sponsor_user_id,
                    'subject'       => 'Pelamar Baru',
                    'message'       => $message
                ]);
                DB::table('new_messages')->insert([
                    'message_id'    => $message_id,
                    'user_id'       => $sponsor_user_id
                ]);
            }

            $res = [
                'status'    => 200,
                'message'   => 'CV Berhasil dikirim'
            ];
            DB::commit();
        } catch (Exception $e) {
            $res = [
                'status'    => $e->getCode(),
                'message'   => $e->getMessage()
            ];
            DB::rollBack();
        }

        return response()->json($res, $res['status']);
    }
}
