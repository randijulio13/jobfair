<section id="hero" class="d-flex justify-content-center align-items-center">
  <div id="heroCarousel" data-bs-interval="5000" class="container carousel carousel-fade" data-bs-ride="carousel">

    <div class="carousel-item active">
      <div class="carousel-container">
        <h2 class="animate__animated animate__fadeInDown">Welcome to <span>{{ $config->title }}</span></h2>
        <p class="animate__animated animate__fadeInUp">{{$config->title_description}}</p>
      </div>
    </div>

    @if(count($banner) != 0)
    @foreach($banner as $i => $b)
    <div class="carousel-item">
      <div class="carousel-container">
        @if($b->title)
        <h2 class="animate__animated animate__fadeInDown">Title</h2>
        @endif
        <p class="animate__animated animate__fadeInUp">
          @if($b->file)
          <img src="/assets/img/banners/{{ $b->file }}" class="d-block w-100" alt="{{ $b->file }}">
          @endif
          @if($b->description)
          {{ $b->description }}
          @endif
        </p>
      </div>
    </div>
    @endforeach
    <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
      <span class="carousel-control-prev-icon bx bx-chevron-left" aria-hidden="true"></span>
    </a>

    <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
      <span class="carousel-control-next-icon bx bx-chevron-right" aria-hidden="true"></span>
    </a>
    @endif

  </div>
</section>