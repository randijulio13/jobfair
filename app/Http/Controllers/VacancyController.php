<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
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
            ->paginate(6);
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

    function store(Request $request)
    {
        try {
            if (!session('userdata_applicant')) {
                throw new Exception('Anda belum login', 401);
            }
            $password = DB::table('users')->where('id', '=', session('userdata_applicant')['id'])->value('password');
            $pass = Hash::check(request('password'), $password);
            if (!$pass) {
                throw new Exception('Password anda salah', 401);
            }

            $applicant = DB::table('applicant_datas')->where('user_id', '=', session('userdata_applicant')['id'])->first();

            $check = DB::table('vacancy_applicants')->where('applicant_id', '=', $applicant->id)
                ->where('vacancy_id', '=', request('vacancy_id'))->count();
            if ($check) {
                throw new Exception('Anda sudah mengirim CV ke lowongan ini', 400);
            }
            $isComplete = 0;
            foreach ($applicant as $d) {
                if ($d == NULL)
                    $isComplete++;
            }
            if ($isComplete) {
                throw new Exception('Data diri belum lengkap', 401);
            }

            $data = [
                'vacancy_id'    => request('vacancy_id'),
                'applicant_id'  => $applicant->id,
            ];
            DB::table('vacancy_applicants')->insert($data);

            $res = [
                'status'    => 200,
                'message'   => 'CV Berhasil dikirim'
            ];
        } catch (Exception $e) {
            $res = [
                'status'    => $e->getCode(),
                'message'   => $e->getMessage()
            ];
        }
        return response()->json($res, $res['status']);
    }
}
