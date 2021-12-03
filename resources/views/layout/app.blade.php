<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="token" content="{{ csrf_token() }}">
  <title>@yield('title') | JobFair Tribun</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link href="/assets/anyar/img/favicon.png" rel="icon">
  <link href="/assets/anyar/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="/assets/anyar/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="/assets/anyar/vendor/aos/aos.css" rel="stylesheet">
  <link href="/assets/anyar/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/anyar/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/assets/anyar/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="/assets/anyar/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="/assets/anyar/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="/assets/anyar/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="/assets/anyar/css/style.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

</head>

<body>
  @include('layout.topbar')
  @include('layout.navbar')
  <main id="main">
    <!-- @include('layout.content.boxes') -->
    @if(!Request::routeIs('home'))
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <h2>@yield('title')</h2>
      </div>
    </section>
    @endif
    @yield('content')
    <!-- @include('layout.content.why_us') -->
    <!-- @include('layout.content.services') -->
    <!-- @include('layout.content.cta') -->
    <!-- @include('layout.content.portofolio') -->
    <!-- @include('layout.content.team') -->
    <!-- @include('layout.content.pricing') -->
    <!-- @include('layout.content.faq') -->
  </main>
  @yield('modal')
  @include('layout.footer')
  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <script src="/assets/js/jquery.min.js"></script>
  <script src="/assets/anyar/vendor/aos/aos.js"></script>
  <script src="/assets/anyar/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/anyar/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="/assets/anyar/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="/assets/anyar/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="/assets/anyar/vendor/php-email-form/validate.js"></script>
  <script src="/assets/anyar/js/main.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="/assets/js/my.js"></script>
  @yield('script')
</body>

</html>