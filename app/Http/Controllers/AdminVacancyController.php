<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminVacancyController extends Controller
{
    function index()
    {
        $career_fields = DB::table('career_fields')->get();
        return view('admin/vacancy', compact('career_fields'));
    }

    function set_seen(Request $request)
    {
        $last_seen = (int)DB::table('vacancy_applicants')->where('applicant_id', '=', request('applicant_id'))->where('vacancy_id', '=', request('vacancy_id'))->value('seen');
        $seen = $last_seen + 1;
        DB::table('vacancy_applicants')->where('applicant_id', '=', request('applicant_id'))->where('vacancy_id', '=', request('vacancy_id'))->update(['seen' => $seen]);
        return response()->json(['status' => 200, 'message' => 'OK']);
    }

    function datatables_detail($id)
    {
        $data = DB::table('vacancy_applicants as va')
            ->select('ad.*', 'va.created_at as sent_at', 'u.phone', 'u.email')
            ->join('applicant_datas as ad', 'ad.id', '=', 'va.applicant_id')
            ->join('users as u', 'u.id', '=', 'ad.user_id')
            ->where('va.vacancy_id', '=', $id)
            ->get();
        // $data = DB::table('applicant_datas')->get();
        return datatables($data)
            ->setRowId(function ($data) {
                return $data->id;
            })
            ->addIndexColumn()
            ->addColumn('name', function ($data) {
                $gender = $data->gender == 'L' ? 'Laki-laki' : 'Perempuan';
                $age = Carbon::parse($data->dob)->diff(Carbon::now())->y;
                return $data->name . '<br><small><ul>
                <li>Umur: ' . $age . ' tahun</li>
                <li>Jenis Kelamin: ' . $gender . '</li>
                </ul></small>';
            })
            ->addColumn('last_edu', function ($data) {
                return $data->last_edu . ' ' . $data->major . ' (' . $data->grad_year . ')';
            })
            ->addColumn('aksi', function ($data) {
                $disabled = $data->file == null ? 'disabled' : '';
                return '<div class="btn-group"><a href="/assets/cv/' . $data->file . '" target="_blank" class="btn btn-primary btn-sm ' . $disabled . '"><i class="fas fa-file"></i> CV</a><a class="btn btn-success btn-sm" target="_blank" href="https://wa.me/' . hp($data->phone) . '"><i class="fas fa-phone"></i> WA</a><a class="btn btn-danger btn-sm"  href="mailto:' . $data->email . '" target="_blank"><i class="fas fa-envelope"></i> Email</a></div>';
            })
            ->addColumn('fields', function ($data) {
                $fields = DB::table('applicant_fields')->where('applicant_id', '=', $data->id)->get();
                $str = '<ul>';
                foreach ($fields as $f) {
                    $field_name = DB::table('career_fields')->where('id', '=', $f->field_id)->value('name');
                    $str .= '<li>' . $field_name . '</li>';
                }
                $str .= '</ul>';
                return $str;
            })
            ->rawColumns(['name', 'last_edu', 'aksi', 'fields'])
            ->toJson();
    }

    function datatables()
    {
        $vacancies = DB::table('vacancies')
            ->select('vacancies.*', 'cf.name as career_field')
            ->join('career_fields as cf', 'cf.id', '=', 'vacancies.career_field');
        $sponsor_id = DB::table('sponsors')->where('user_id', '=', session('userdata')['id'])->value('id');
        if (session('userdata')['type'] == 2) {
            $vacancies = $vacancies->where('sponsor_id', '=', $sponsor_id);
        }
        return datatables($vacancies->get())
            ->addIndexColumn()
            ->addColumn('sponsor_image', function ($data) {
                $sponsor = DB::table('sponsors')->where('id', '=', $data->sponsor_id)->first();
                return '<img src="/assets/img/' . $sponsor->logo . '" width="150px">';
            })
            ->addColumn('image', function ($data) {
                return '<img src="/assets/img/' . $data->image . '" width="150px">';
            })
            ->addColumn('aksi', function ($data) {
                return '<div class="btn-group">
                <a href="/admin/vacancy/' . $data->id . '" class="btn btn-primary btn-sm btn-detail"><i class="fas fa-eye"></i> Detail</a>
                </div>';
            })
            ->addColumn('title', function ($data) {
                $total = DB::table('vacancy_applicants')->where('vacancy_id', '=', $data->id)->count();
                return $data->title . '<br><small>
                <ul>
                <li>Bidang: ' . $data->career_field . '</li>
                <li>Pelamar: ' . $total . '</li>
                </ul>
                </small>';
            })
            ->addColumn('status', function ($data) {
                $checked = $data->status ? 'checked'  : '';
                return '<div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input status-vacancy" ' . $checked . ' id="status' . $data->id . '">
                <label class="custom-control-label" for="status' . $data->id . '"></label>
              </div>';
            })
            ->setRowId(function ($data) {
                return $data->id;
            })
            ->rawColumns(['sponsor_image', 'aksi', 'status', 'title', 'image'])
            ->toJson();
    }

    function detail($id)
    {
        $career_fields = DB::table('career_fields')->get();
        $vacancy = DB::table('vacancies as v')
            ->where('v.id', '=', $id)
            ->select('v.*', 's.name as sponsor_name')
            ->join('sponsors as s', 's.id', '=', 'v.sponsor_id')
            ->join('career_fields as cf', 'cf.id', '=', 'v.career_field')
            ->first();

        return view('admin/vacancy_detail', compact('career_fields', 'vacancy'));
        return $vacancy;
    }

    function update(Request $request, $id)
    {
        $request->validate(
            [
                'title' => ['required'],
                'description'   => ['required'],
                'career_field'  => ['required']
            ],
            ['required' => ':attribute harus diisi'],
            [
                'title' => 'Judul',
                'description'   => 'Deskripsi',
                'career_field'  => 'Bidang pekerjaan'
            ]
        );
        try {
            DB::beginTransaction();
            $vacancies = DB::table('vacancies')->where('id', '=', $id)->first();
            $data = [
                'title' => request('title'),
                'description'   => request('description'),
                'career_field'  => request('career_field'),
            ];
            if (request()->has('image')) {
                $image = $request->image;
                $namaFileBaru = date('Ymd') . rand(0, 9999) . Str::slug(request('title'), '-') . '.' . request('image')->getClientOriginalExtension();
                $data['image']  = $namaFileBaru;
            }
            DB::table('vacancies')->where('id', '=', $id)->update($data);
            if (request()->has('image')) {
                $image->move('assets/img/', $namaFileBaru);
                if ($vacancies->image) {
                    if (file_exists('assets/img/' . $vacancies->image)) {
                        unlink('assets/img/' . $vacancies->image);
                    };
                }
            }
            $res = [
                'status'    => 201,
                'message'   => 'Lowongan berhasil diupdate'
            ];
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $res = [
                'status'    => $e->getCode() ?? 400,
                'message'   => $e->getMessage() ?? 'Terjadi kesalahan'
            ];
        }
        return response()->json($res, $res['status']);
    }

    function store(Request $request)
    {
        $rules = [
            'title' => ['required'],
            'description'   => ['required'],
            'career_field'  => ['required'],
            'image'         => ['required']
        ];
        if (session('userdata')['type'] == 1) {
            $rules['sponsor_id'] = ['required'];
        }

        $request->validate(
            $rules,
            ['required' => ':attribute harus diisi'],
            [
                'title' => 'Judul',
                'description'   => 'Deskripsi',
                'career_field'  => 'Bidang pekerjaan',
                'image'         => 'Poster',
                'sponsor_id'    => 'Sponsor'
            ]
        );

        try {
            DB::beginTransaction();
            $image = $request->image;
            $namaFileBaru = date('Ymd') . rand(0, 9999) . Str::slug(request('title'), '-') . '.' . request('image')->getClientOriginalExtension();
            if (session('userdata')['type'] == 1) {
                $sponsor_id = request('sponsor_id');
            } else {
                $sponsor_id = DB::table('sponsors')->where('user_id', '=', session('userdata')['id'])->value('id');
            }
            $data = [
                'title' => request('title'),
                'description'   => request('description'),
                'career_field'  => request('career_field'),
                'sponsor_id'    => $sponsor_id
            ];
            if ($image)
                $data['image']  = $namaFileBaru;
            DB::table('vacancies')->insert($data);
            $image->move('assets/img/', $namaFileBaru);
            DB::commit();
            $res = [
                'status'    => 201,
                'message'   => 'Lowongan berhasil dibuat'
            ];
        } catch (Exception $e) {
            DB::rollBack();
            $res = [
                'status'    => $e->getCode() ?? 400,
                'message'   => $e->getMessage() ?? 'Terjadi kesalahan'
            ];
        }
        return response()->json($res, $res['status']);
    }

    function update_status($id)
    {
        $status = request('status') == 'true' ? 1 : 0;
        DB::table('vacancies')->where('id', '=', $id)->update(['status' => $status]);
        return response()->json([
            'status'    => 200,
            'message'   => 'Berhasil update status'
        ], 200);
    }
}
