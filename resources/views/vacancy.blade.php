@extends('layout.app')
@section('title','Lowongan Kerja')
@section('content')


<section id="blog" class="blog">
    <div class="container" data-aos="fade-up">
        <div class="row">
            <div class="col-lg-8 entries">
                <div class="row">
                    @foreach($vacancies as $vacan)
                    <div class="col-lg-12">
                        <article class="entry">
                            <h2 class="entry-title"><a href="/loker/detail/{{ $vacan->id }}">{{ $vacan->title }}</a></h2>
                            <div class="entry-content">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <img src="/assets/img/{{ $vacan->logo }}" alt="" class="img-fluid">
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="entry-meta">
                                            <ul>
                                                <li class="d-flex align-items-center"> <i class="bi bi-person"></i> <a href="/loker?sponsor={{$vacan->nama_sponsor}}">{{ $vacan->nama_sponsor }}</a></li>
                                                <li class="d-flex align-items-center"><i class="bi bi-briefcase"></i> <a href="/loker?field={{$vacan->career_field}}">{{ $vacan->career_field }}</a></li>
                                            </ul>
                                        </div>
                                        <div class="read-more">
                                            <a href="/loker/detail/{{ $vacan->id }}"><i class="bi bi-filter-square-fill"></i> Detail</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article><!-- End blog entry -->
                    </div>
                    @endforeach
                    <div class="col-lg-12">
                        {{ $vacancies->links() }}
                    </div>
                </div>
            </div>
            @include('layout.profile_sidebar')

        </div>
    </div>
</section><!-- End Blog Single Section -->

@endsection

@section('script')
<script src="/assets/js/login.js"></script>
@endsection