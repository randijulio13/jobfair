<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    function index()
    {
        $data = DB::table('applicant_datas')->where('user_id', '=', session('userdata_applicant')['id'])->first();
        $isComplete = 0;
        $career_fields = DB::table('career_fields')->get();
        $applicant_fields = DB::table('applicant_fields')->get();
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
        return response()->json($res);
    }
}
