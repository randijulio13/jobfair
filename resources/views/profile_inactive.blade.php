@extends('layout.app')
@section('title','Profil')
@section('content')
<section id="blog" class="blog">
    <div class="container" data-aos="fade-up">
        <div class="row">
            <div class="col-lg-8 entries">
                <div class="row">
                    <div class="col-lg-12">
                        @if($user->status == 3)
                        <div class="alert alert-info alert-dismissible show pt-4" role="alert">
                            <b><i class="bi bi-exclamation-circle-fill"></i> Akun anda belum aktif! </b>
                            <p class="mt-3"> Silahkan lakukan pembayaran dan upload bukti pembayaran/transfer. <br></p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @elseif($user->status == 2)
                        <div class="alert alert-info alert-dismissible show pt-4" role="alert">
                            <b><i class="bi bi-exclamation-circle-fill"></i> Bukti pembayaran anda sedang ditinjau </b>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                    </div>
                    <div class="col-lg-12">
                        <article class="entry">
                            <div class="entry-title">Upload Bukti Pembayaran</div>
                            <div class="entry-content">
                                <form id="formPembayaran">
                                    <div class="form-group mb-4">
                                        <input type="file" class="form-control" name="attachment" accept="image/*">
                                    </div>
                                    <a href="#" class="btnPayment btn btn-secondary">Cara pembayaran</a>
                                    <button type="submit" class="btn btn-primary"> Submit</button>
                                </form>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
            @include('layout.profile_sidebar')
        </div>
    </div>
</section>
@endsection

@section('modal')
@include('layout.modal_pembayaran')
@endsection

@section('script')
<script src="/assets/js/profile.js"></script>
@endsection