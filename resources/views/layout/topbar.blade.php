<div id="topbar" class="fixed-top d-flex align-items-center topbar-inner-pages">
  <div class="container d-flex align-items-center justify-content-center justify-content-md-between">
    <div class="contact-info d-flex align-items-center">
      <i class="bi bi-envelope-fill"></i><a href="mailto:{{ $config->email }}">{{ $config->email }}</a>
      <i class="bi bi-phone-fill phone-icon"></i> {{ $config->phone }}
    </div>
    <div class="cta d-none d-md-block">
      @if(!session('userdata_applicant'))
      <a href="/#register" class="scrollto">Daftar</a>
      @endif
    </div>
  </div>
</div>