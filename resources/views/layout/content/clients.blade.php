<section id="clients" class="clients">
  <div class="container" data-aos="zoom-in">

    <div class="clients-slider swiper">
      <div class="swiper-wrapper align-items-center">
        @foreach($sponsors as $sponsor)
        <div class="swiper-slide">
          <a href="/loker?sponsor={{$sponsor->name}}">
            <img src="/assets/img/{{ $sponsor->logo }}" class="img-fluid" alt="">
          </a>
        </div>
        @endforeach
      </div>
      <!-- <div class="swiper-pagination"></div> -->
    </div>

  </div>
</section>