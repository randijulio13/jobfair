<section id="clients" class="clients">
  <div class="container" data-aos="zoom-in">

    <div class="clients-slider swiper">
      <div class="swiper-wrapper align-items-center">
        @foreach($sponsors as $sponsor)
        <div class="swiper-slide">
          <img src="/assets/img/{{ $sponsor->logo }}" class="img-fluid" alt="">
        </div>
        @endforeach
      </div>
      <!-- <div class="swiper-pagination"></div> -->
    </div>

  </div>
</section>