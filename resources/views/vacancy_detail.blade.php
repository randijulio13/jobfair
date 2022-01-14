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
                        <h2 class="entry-title">
                            <a href="#">{{ $vacancy->title }}</a>
                        </h2>
                        <div class="entry-meta">
                            <ul>
                                <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="/loker?sponsor={{$vacancy->nama_sponsor}}">{{ $vacancy->nama_sponsor }}</a></li>
                                <li class="d-flex align-items-center"><i class="bi bi-briefcase"></i> <a href="/loker?field={{$vacancy->career_field}}">{{ $vacancy->career_field }}</a></li>
                                <li class="d-flex align-items-center"><i class="bi bi-calendar"></i> <a href="#">{{ \Carbon\Carbon::parse($vacancy->created_at)->format('d M Y') }}</a></li>
                            </ul>
                        </div>
                        <div class="entry-content">
                                    <img src="/assets/img/{{ $vacancy->image }}" alt="" class="img-fluid">
                                    <p>{!! $vacancy->description !!}</p>
                                    @if($isSent)
                                    <a href="#" class="btn btn-primary text-white disabled" id="btnDaftar"><i class="bi bi-send-check-fill"></i> CV Terkirim</a>
                                    @else
                                    <a href="#" class="btn btn-primary text-white" id="btnDaftar"><i class="bi bi-send-fill"></i> Kirim CV</a>
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