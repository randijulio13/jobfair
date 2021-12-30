<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminApplicantController extends Controller
{
    function index()
    {
        return view('admin/applicant');
    }

    function datatables()
    {
        $data = DB::table('applicant_datas as ad')->join('users as u', 'u.id', '=', 'ad.user_id')->select('ad.*', 'u.status')->where('u.status','=',1)->get();
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
                if (!$data->last_edu)
                    return '<span class="badge badge-pill badge-danger">Data belum dilengkapi</span>';
                return $data->last_edu . ' ' . $data->major . ' (' . $data->grad_year . ')';
            })
            ->addColumn('aksi', function ($data) {
                $disabled = $data->file == null ? 'disabled' : '';
                return '<a href="/assets/cv/' . $data->file . '" target="_blank" class="btn btn-primary btn-sm ' . $disabled . '"><i class="fas fa-file"></i> Lihat PDF</a>';
            })
            ->addColumn('fields', function ($data) {
                $fields = DB::table('applicant_fields')->where('applicant_id', '=', $data->id)->get();
                if (count($fields) == 0)
                    return '<span class="badge badge-pill badge-danger">Data belum dilengkapi</span>';
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
}
