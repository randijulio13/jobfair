<?php

use Illuminate\Support\Facades\DB;

function get_logo($user_id)
{
    $img = DB::table('sponsors')->where('user_id', '=', $user_id)->value('logo');
    if (!$img) {
        $img = 'no-image.png';
    }
    return $img;
}

function get_applicant_id($user_id)
{
    return DB::table('applicant_datas')->where('user_id', '=', $user_id)->value('id');
}

function get_config()
{
    return DB::table('web_config')->where('id', '=', 1)->first();
}

function hp($nohp)
{
    // kadang ada penulisan no hp 0811 239 345
    $nohp = str_replace(" ", "", $nohp);
    // kadang ada penulisan no hp (0274) 778787
    $nohp = str_replace("(", "", $nohp);
    // kadang ada penulisan no hp (0274) 778787
    $nohp = str_replace(")", "", $nohp);
    // kadang ada penulisan no hp 0811.239.345
    $nohp = str_replace(".", "", $nohp);

    // cek apakah no hp mengandung karakter + dan 0-9
    if (!preg_match('/[^+0-9]/', trim($nohp))) {
        // cek apakah no hp karakter 1-3 adalah +62
        if (substr(trim($nohp), 0, 1) == '0') {
            $nohp = '+62' . substr(trim($nohp), 1);
        }
    }
    return $nohp;
}

function get_sponsor_type($user_id)
{
    return DB::table('sponsors')->where('user_id', '=', $user_id)->value('type');
}

function get_user_name($user_id = null)
{
    if ($user_id == null)
        return 'Admin';
    return DB::table('applicant_datas')->where('user_id', '=', $user_id)->value('name');
}

function get_userdata_applicant($id = null)
{
    if ($id == null)
        $id = session('userdata_applicant')['id'];
    return DB::table('users')->where('id', '=', $id)->first();
}

function get_userdata($id = null)
{
    if ($id == null)
        $id = session('userdata')['id'];
    return DB::table('users')->where('id', '=', $id)->first();
}
