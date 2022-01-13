@extends('layout.app')
@section('title','Detail Lowongan')
@section('content')


<section id="blog" class="blog">
    <div class="container" data-aos="fade-up">
        <div class="row">
            <div class="col-lg-8 entries">
                <div class="row">
                    <input type="hidden" id="vacancy_id" value="{{ $vacancy->id }}">
                    <article class="entry entry-single">
                        <div class="entry-img">
                            <img src="/assets/img/{{ $vacancy->logo }}" alt="" class="p-5 img-fluid">
                        </div>
                        <h2 class="entry-title">
                            <a href="#">{{ $vacancy->title }}</a>
                        </h2>
                        <div class="entry-meta">
                            <ul>
                                <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="/loker?sponsor={{$vacancy->nama_sponsor}}">{{ $vacancy->nama_sponsor }}</a></li>
                                <li class="d-flex align-items-center"><i class="bi bi-briefcase"></i> <a href="/loker?field={{$vacancy->career_field}}">{{ $vacancy->career_field }}</a></li>
                            </ul>
                        </div>
                        <div class="entry-content">
                            <p>{!! $vacancy->description !!}</p>
                                @if($isSent)
                                <a href="#" class="btn btn-success text-white disabled" id="btnDaftar"><i class="bi bi-send-check-fill"></i> CV Berhasil Dikirim</a>
                                @else
                                <a href="#" class="btn btn-warning text-white" id="btnDaftar"><i class="bi bi-send-fill"></i> Kirim CV</a>
                                @endif
                        </div>
                    </article>
                </div>
            </div>
            @include('layout.profile_sidebar')
        </div>
    </div>
</section><!-- End Blog Single Section -->
@endsection

@section('script')
<script src="/assets/js/vacancy_detail.js"></script>
@endsection