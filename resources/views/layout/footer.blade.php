<footer id="footer">


    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-4 col-md-6  footer-links">
            <h4>Menu</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="/">Beranda</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="/loker">Loker</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="{{ session('userdata_applicant') ? '/profile' : '/login' }}">{{ session('userdata_applicant')  ? 'Profil' : 'Login' }}</a></li>
              @if(session('userdata_applicant'))
              <li><i class="bx bx-chevron-right"></i> <a class="userLogout" href="#">Logout</a></li>
              @endif
            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-contact">
            <h4>Contact Us</h4>
            <p>
              <strong>Alamat:</strong><br>
              {{ $config->address }}<br><br>
              <strong>Telepon:</strong> {{ $config->phone }}<br>
              <strong>Email:</strong> {{ $config->email }}<br>
            </p>

          </div>

          <div class="col-lg-4 col-md-6 footer-info">
            <h3>About Us</h3>
            <p>{{ $config->about_us }}</p>
            <div class="social-links mt-3">
              <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
              <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
              <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
              <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
              <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Anyar</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/anyar-free-multipurpose-one-page-bootstrap-theme/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer>