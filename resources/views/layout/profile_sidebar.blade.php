<?php

use Illuminate\Support\Facades\DB;

$categories = DB::table('career_fields')->select(
    'career_fields.*',
    DB::raw('(SELECT COUNT(*) FROM vacancy_fields as vf INNER JOIN vacancies as v on v.id = vf.vacancy_id WHERE vf.field_id = career_fields.id and v.status = 1) as total')
)->get();
?>

<div class="col-lg-4">
    <div class="row">
        @if(Request::routeIs('vacancy') || Request::routeIs('detail_vacancy'))
        <div class="col-lg-12">
            <div class="sidebar">
                <h3 class="sidebar-title">Search</h3>
                <div class="sidebar-item search-form">
                    <form action="/loker">
                        <input type="text" value="{{ request('q') }}" name="q">
                        <button type="submit"><i class="bi bi-search"></i></button>
                    </form>
                </div><!-- End sidebar search formn-->
                <h3 class="sidebar-title mt-4">Bidang Pekerjaan</h3>
                <div class="sidebar-item tags">
                    <ul>
                        @foreach($categories as $c)
                        <li><a href="/loker?field={{$c->name}}">{{$c->name}} ({{ $c->total }})</a></li>
                        @endforeach
                    </ul>
                </div><!-- End sidebar categories-->
            </div>
        </div>
        @endif
        <div class="col-lg-12">
            <div class="sidebar">
                <h3 class="sidebar-title">Menu</h3>
                <div class="sidebar-item categories">
                    <ul>
                        <li><a href="/loker">{!! Request::routeIs('vacancy') || Request::routeIs('detail_vacancy') ? '<i class="bi bi-caret-right-fill"></i>' : '' !!} Lowongan Pekerjaan</a></li>
                        @if(session('userdata_applicant'))
                        <?php
                        $new  = Illuminate\Support\Facades\DB::table('new_messages')->where('user_id', '=', session('userdata_applicant')['id'])->count();
                        ?>
                        <li><a href="/profile/history">{!! Request::routeIs('vacancy_history') ? '<i class="bi bi-caret-right-fill"></i>' : '' !!} Riwayat Lamaran</a></li>
                        <li><a href="/profile/notification">{!! Request::routeIs('notification') ? '<i class="bi bi-caret-right-fill"></i>' : '' !!} Notifikasi
                                @if($new > 0)
                                ( {{ $new }} )
                                @endif
                            </a></li>
                        <hr>
                        <li><a href="/profile">{!! Request::routeIs('profile') ? '<i class="bi bi-caret-right-fill"></i>' : '' !!} Data Diri</a></li>
                        <li><a href="/profile/account">{!! Request::routeIs('account') ? '<i class="bi bi-caret-right-fill"></i>' : '' !!} Data Akun</a></li>
                        @else
                        <hr>
                        <li><a href="/login">{!! Request::routeIs('login') ? '<i class="bi bi-caret-right-fill"></i>' : '' !!} Login</a></li>
                        @endif
                        @if(session('userdata_applicant'))
                        <hr>
                        <li>
                            <a href="/logout" class="userLogout"><i class="bi bi-door-open-fill"></i> Logout</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>