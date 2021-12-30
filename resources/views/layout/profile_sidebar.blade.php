<div class="col-lg-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="sidebar">
                <h3 class="sidebar-title">Menu</h3>
                <div class="sidebar-item categories">
                    <ul>
                        @if(session('userdata_applicant'))
                        <?php
                        $new  = Illuminate\Support\Facades\DB::table('new_messages')->where('user_id', '=', session('userdata_applicant')['id'])->count();
                        ?>
                        <li><a href="/profile/notification">{!! Request::routeIs('notification') ? '<i class="bi bi-caret-right-fill"></i>' : '' !!} Notifikasi
                                @if($new > 0)
                                ( {{ $new }} )
                                @endif
                            </a></li>
                        <li><a href="/profile">{!! Request::routeIs('profile') ? '<i class="bi bi-caret-right-fill"></i>' : '' !!} Data Diri</a></li>
                        @else
                        <li><a href="/login">{!! Request::routeIs('login') ? '<i class="bi bi-caret-right-fill"></i>' : '' !!} Login</a></li>
                        @endif
                        <li><a href="/loker">{!! Request::routeIs('vacancy') || Request::routeIs('detail_vacancy') ? '<i class="bi bi-caret-right-fill"></i>' : '' !!} Lowongan Pekerjaan</a></li>
                        @if(session('userdata_applicant'))
                        <li><a href="/profile/history">{!! Request::routeIs('vacancy_history') ? '<i class="bi bi-caret-right-fill"></i>' : '' !!} Riwayat Lamaran</a></li>
                        @endif
                    </ul>
                    @if(session('userdata_applicant'))
                    <ul class="mt-4">
                        <li>
                            <a href="/logout" class="userLogout"><i class="bi bi-door-open-fill"></i> Logout</a>
                        </li>
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>