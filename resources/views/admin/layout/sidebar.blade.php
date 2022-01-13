<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/admin">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-briefcase"></i>
        </div>
        <div class="sidebar-brand-text mx-3">TRIBUNCAREER</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ Request::routeIs('dashboard_admin') ? 'active' : '' }}">
        <a class="nav-link" href="/admin">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <li class="nav-item {{ Request::routeIs('applicant') ? 'active' : '' }}">
        <a class="nav-link" href="/admin/applicant">
            <i class="fa fa-fw fa-users" aria-hidden="true"></i>
            <span>Data Pelamar</span></a>
    </li>
    <li class="nav-item {{ Request::routeIs('admin.vacancy') || Request::routeIs('admin.detail.vacancy')  ? 'active' : '' }}">
        <a class="nav-link" href="/admin/vacancy">
            <i class="fa fa-suitcase fa-fw" aria-hidden="true"></i>
            <span>Data Loker</span></a>
    </li>
    @if(session('userdata')['type'] == 1)
    <li class="nav-item {{ Request::routeIs('sponsor') ? 'active' : '' }}">
        <a class="nav-link" href="/admin/sponsor">
            <i class="fas fa-fw fa-dollar-sign    "></i>
            <span>Data Sponsor</span></a>
    </li>
    <li class="nav-item {{ Request::routeIs('token') || Request::routeIs('career_field') || Request::routeIs('admin.payment') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#dataMaster" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Data Master</span>
        </a>
        <div id="dataMaster" class="collapse {{ Request::routeIs('token') || Request::routeIs('career_field') || Request::routeIs('admin.payment') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::routeIs('token') ? 'active' : '' }}" href="/admin/token">Token</a>
                <a class="collapse-item {{ Request::routeIs('career_field') ? 'active' : '' }}" href="/admin/field">Bidang Pekerjaan</a>
                <a class="collapse-item {{ Request::routeIs('admin.payment') ? 'active' : '' }}" href="/admin/payment">Metode Pembayaran</a>
            </div>
        </div>
    </li>
    <li class="nav-item {{ Request::routeIs('user') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#dataUser" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-user-cog"></i>
            <span>Data User</span>
        </a>
        <div id="dataUser" class="collapse {{ Request::routeIs('user') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::routeIs('user') && last(request()->segments()) == 'pelamar' ? 'active' : '' }}" href="/admin/user/pelamar">Pelamar</a>
                <a class="collapse-item {{ Request::routeIs('user') && last(request()->segments()) == 'sponsor' ? 'active' : '' }}" href="/admin/user/sponsor">Sponsor</a>
            </div>
        </div>
    </li>
    @endif
    <?php
    $new  = Illuminate\Support\Facades\DB::table('new_messages')->where('user_id', '=', session('userdata')['id'])->count();
    ?>
    <li class="nav-item {{ Request::routeIs('admin.message') || Request::routeIs('admin.message_detail')  ? 'active' : '' }}">
        <a class="nav-link" href="/admin/message">
            <i class="fa fa-envelope fa-fw" aria-hidden="true"></i>
            <span>Pesan </span>
            @if($new > 0)
            <p class="badge badge-danger badge-pill badge-sm">{{ $new }}</p>
            @endif
        </a>
    </li>
    @if(session('userdata')['type'] == 1)
    <li class="nav-item {{ Request::routeIs('admin.config')   ? 'active' : '' }}">
        <a class="nav-link" href="/admin/config">
            <i class="fa fa-globe fa-fw" aria-hidden="true"></i>
            <span>Konfigurasi</span>
        </a>
    </li>
    @endif
    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>