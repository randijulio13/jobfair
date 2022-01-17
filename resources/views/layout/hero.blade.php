@include('layout.banner')
<section id="hero" class="d-flex justify-content-center align-items-center">
  <div id="heroCarousel" data-bs-interval="5000" class="container carousel carousel-fade" data-bs-ride="carousel">
    <div class="carousel-item active">
      <div class="carousel-container">
        <h2 class="animate__animated animate__fadeInDown">Welcome to <span>{{ $config->title }}</span></h2>
        <p class="animate__animated animate__fadeInUp">{{$config->title_description}}</p>
      </div>
    </div>
  </div>
</section>