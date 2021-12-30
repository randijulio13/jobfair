
<header id="header" class="fixed-top d-flex align-items-center header-inner-pages">
    <div class="container d-flex align-items-center justify-content-between">
      <h1 class="logo"><a href="/">{{ $config->title }}</a></h1>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto" href="/#hero">Beranda</a></li>
          <li><a class="nav-link scrollto" href="/#about">Tentang</a></li>
          <li><a class="nav-link scrollto" href="/#register">Daftar</a></li>
          <li><a class="nav-link scrollto" href="/#contact">Kontak</a></li>
          <li><a class="nav-link scrollto {{ Request::routeIs('vacancy') || Request::routeIs('detail_vacancy') || Request::routeIs('vacancy_history') ? 'active' : '' }}" href="/loker">Loker</a></li>
          <li><a class="nav-link scrollto {{ Request::routeIs('login') || Request::routeIs('profile') ? 'active' : '' }}" href="{{ session('userdata_applicant') ? '/profile' : '/login' }}">{{ session('userdata_applicant')  ? 'Profil' : 'Login' }}</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>
    </div>
  </header>