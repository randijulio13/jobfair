<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminApplicantController extends Controller
{
    function index()
    {
        $sponsor = DB::table('sponsors')->where('user_id', '=', session('userdata')['id'])->first();
        if (session('userdata')['type'] == 2) {
            $sponsor_fields = DB::table('sponsor_fields')->where('sponsor_id', '=', $sponsor->id)->get();
            if ($sponsor->type == 3)
                return view('admin/applicant');

            $selected = DB::table('sponsor_fields')->where('sponsor_id', '=', $sponsor->id)->get();

            $field_total = $sponsor->type == 2 ? 2 : 0;

            if (count($selected) == $field_total)
                return view('admin/applicant');

            $career_fields = DB::table('career_fields')->get();
            return view('admin/select_field', compact('career_fields', 'sponsor_fields', 'field_total'));
        }
        return view('admin/applicant');
    }

    function datatables()
    {
        $data = DB::table('applicant_fields as af')
            ->select('ad.*', 'u.phone', 'u.email')
            ->join('applicant_datas as ad', 'ad.id', '=', 'af.applicant_id')
            ->join('users as u', 'u.id', '=', 'ad.user_id')
            ->where('u.status', '=', 1);
        if (session('userdata')['type'] != 1) {
            $sponsor = DB::table('users as u')->select('u.*', 's.id as sponsor_id', 's.type as sponsor_type')->join('sponsors as s', 's.user_id', '=', 'u.id')->where('u.id', '=', session('userdata')['id'])->first();
            $sponsor_id = $sponsor->sponsor_id;
            $data = $data->where('ad.file', '!=', null);
            $fields = DB::table('sponsor_fields as sf')
                ->where('sf.sponsor_id', '=', $sponsor_id)
                ->get();

            if ($sponsor->sponsor_type == 2) {
                $data = $data->where(function ($q) use ($fields) {
                    foreach ($fields as $f) {
                        $q->orWhere('field_id', '=', $f->field_id);
                    }
                });
            }
        }
        $data = $data->groupBy('ad.*','u.phone','u.email');

        return datatables($data->get())
            ->setRowId(function ($data) {
                return $data->id;
            })
            ->addIndexColumn()
            ->addColumn('name', function ($data) {
                $gender = $data->gender == 'L' ? 'Laki-laki' : ($data->gender == 'P' ? 'Perempuan' : '-');
                $age = $data->dob ? Carbon::parse($data->dob)->diff(Carbon::now())->y . ' tahun' : '-';
                return $data->name . '<br><small><ul>
                <li>Umur: ' . $age . '</li>
                <li>Jenis Kelamin: ' . $gender . '</li>
                <li>Nomor HP: ' . hp($data->phone) . '</li>
                <li>Email: ' . $data->email . '</li>
                </ul></small>';
            })
            ->addColumn('last_edu', function ($data) {
                if (!$data->last_edu)
                    return '<span class="badge badge-pill badge-danger">Data belum dilengkapi</span>';
                return $data->last_edu . ' ' . $data->major . ' (' . $data->grad_year . ')';
            })
            ->addColumn('aksi', function ($data) {
                $disabled = $data->file == null ? 'disabled' : '';
                return '<div class="btn-group"><a href="/assets/cv/' . $data->file . '" target="_blank" class="btn btn-primary btn-sm ' . $disabled . '"><i class="fas fa-file"></i> CV</a><a class="btn btn-success btn-sm" target="_blank" href="https://wa.me/' . hp($data->phone) . '"><i class="fas fa-phone"></i> WA</a><a class="btn btn-danger btn-sm"  href="mailto:' . $data->email . '" target="_blank"><i class="fas fa-envelope"></i> Email</a></div>';
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



    function sponsor(Request $request)
    {
        DB::beginTransaction();
        $fields = $request->fields;
        $sponsor = DB::table('sponsors')->where('user_id', '=', session('userdata')['id'])->first();

        $sponsor_id = $sponsor->id;
        try {
            $data = [];
            foreach ($fields as $f) {
                $data[] = [
                    'field_id'  => $f,
                    'sponsor_id'  => $sponsor_id
                ];
            }
            DB::table('sponsor_fields')->where('sponsor_id', '=', $sponsor_id)->delete();
            DB::table('sponsor_fields')->insert($data);
            DB::commit();
            return response()->json(['status' => 200, 'message' => 'OK']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Error']);
        }
    }
}
