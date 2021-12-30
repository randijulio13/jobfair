<section id="contact" class="contact">
  <div class="container" data-aos="fade-up">

    <div class="section-title">
      <h2>Contact Us</h2>
    </div>

    <div class="row mt-1 d-flex justify-content-center" data-aos="fade-right" data-aos-delay="100">

      <div class="col-lg-6 px-5">
        <img src="/assets/svg/mail.svg" class="img-fluid" alt="">
      </div>

      <div class="col-lg-6 mt-5 mt-lg-0" data-aos="fade-left" data-aos-delay="100">

        <form id="formMessage" class="php-email-form">
          <div class="row">
            <div class="col-md-6 form-group">
            @if(session('userdata_applicant'))
              <input type="hidden" name="sender_id" value="{{ session('userdata_applicant')['id'] ?? '' }}">
              <input type="text" name="name" class="form-control" placeholder="Your Name" value="{{ session('userdata_applicant')['name'] ?? '' }}" readonly>
              @else
              <input type="text" name="name" class="form-control" placeholder="Your Name" required>
              @endif
            </div>
            <div class="col-md-6 form-group mt-3 mt-md-0">
              @if(session('userdata_applicant'))
              <input type="text" class="form-control" name="sender_phone" placeholder="Whatsapp" value="{{ get_userdata_applicant()->phone ?? '' }}" readonly>
              @else
              <input type="text" class="form-control" name="sender_phone" placeholder="Whatsapp"  required>
              @endif
            </div>
          </div>
          <div class="form-group mt-3">
            <input type="text" class="form-control" name="subject" placeholder="Subject" required>
          </div>
          <div class="form-group mt-3">
            <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
          </div>
          <div class="my-3">
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your message has been sent. Thank you!</div>
          </div>
          <div class="text-center">
            <button type="submit">Send Message</button>
          </div>
        </form>

      </div>

    </div>

  </div>
</section>