@extends('layout.app')
@section('title','Riwayat Lamaran')
@section('content')


<section id="blog" class="blog">
    <div class="container" data-aos="fade-up">
        <div class="row">
            <div class="col-lg-8 entries">
                <div class="row">
                    @if(count($vacancies) == 0)
                    <div class="alert alert-info text-center">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        Belum ada riwayat lamaran.
                    </div>
                    @endif
                    @foreach($vacancies as $i => $vacan)
                    <div class="col-lg-6">
                        <article class="entry">
                            <div class="entry-content">
                                <div class="row">
                                    <h2 class="entry-title">
                                        <a href="#">{{ $vacan->title }}</a>
                                    </h2>
                                    <p>
                                        <small>
                                            <i class="bi bi-person-fill"></i> <a href="#">{{ $vacan->sponsor_name }}</a>
                                            <br>
                                            <i class="bi bi-briefcase-fill"></i> <a href="#">{{ $vacan->career_field }}</a>
                                            <br>
                                            <i class="bi bi-send-check-fill"></i> Dikirim pada {{ $vacan->created_at }}
                                            <br>
                                            <i class="bi bi-download"></i> File CV / Resume di-unduh {{ $vacan->seen }}x
                                        </small>
                                    </p>
                                    <div class="read-more">
                                        <a href="/loker/detail/{{ $vacan->id }}"><i class="bi bi-filter-square-fill"></i> Detail</a>
                                    </div>
                                </div>

                            </div>
                        </article>
                    </div>
                    @endforeach
                    {{ $vacancies->links() }}
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