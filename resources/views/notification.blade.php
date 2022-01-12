@extends('layout.app')
@section('title','Notifikasi')
@section('content')


<section id="blog" class="blog">
    <div class="container" data-aos="fade-up">
        <div class="row">
            <div class="col-8 entries">
                <div class="row">
                    @if(count($notifications) == 0)
                    <div class="col-lg-12">
                        <div class="alert alert-info">
                            Tidak ada notifikasi
                        </div>
                    </div>
                    @else
                    @foreach($notifications as $notif)
                    <div class="col-lg-12">
                        <div class="alert alert-success alert-dismissible show">
                            <h4><strong>{{ $notif->subject }}</strong></h4>
                            <p>{{ $notif->message }}</p>
                            <button type="button" class="btn-close" data-id="{{ $notif->id }}" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-lg-12">
                        {{ $notifications->links() }}
                    </div>
                    @endif
                </div>
            </div>
            @include('layout.profile_sidebar')
        </div>
    </div>
</section>
@endsection

@section('script')
<script src="/assets/js/notification.js"></script>
@endsection