@extends('admin.layout.app')
@section('title','Pesan')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="mb-2">
            <a href="/admin/message" class="btn btn-primary"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a>
        </div>
        <div class="card card-body">
            <div class="d-flex justify-content-between my-4">
                <div>
                    <span class="h5 font-weight-bold"><i class="fa fa-envelope"></i> {{ $message->subject }}</span>
                </div>
                <div class="d-flex align-items-center">
                    <span class="mx-2">{{ $message->created_at }}</span>
                    <a href="#" class="px-4 btnReply"><i class="fa fa-reply"></i></a>
                </div>
            </div>
            <span><b>{{ $message->sender_name }}</b>
                <{{ $message->sender_phone }}>
            </span>
            <span>kepada {{ get_user_name($message->receiver_id) ?? 'Admin' }}</span>
            <hr>
            <div class="alert">
                <p>{!! $message->message !!}</p>
                @if($message->attachment)
                <hr>

                <h4>Lampiran</h4>
                <a href="/assets/img/payment/{{$message->attachment}}" target="_blank"><img src="/assets/img/payment/{{$message->attachment}}" width="50%" alt=""></a>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" id="modalReject" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4>Buat Notifikasi</h4>
                <span class="text-secondary">Ke: <strong>{{ $message->sender_name }}</strong></span>
                <hr>
                <form id="formReject">
                    <input type="hidden" name="sender_id" value="1">
                    <input type="hidden" name="name" value="Admin">
                    <input type="hidden" name="sender_phone" value="{{ get_config()->phone }}">
                    <input type="hidden" name="receiver_id" id="user_id" value="{{ $message->sender_id }}">
                    <div class="form-group">
                        <label for="subject">Subjek</label>
                        <input type="text" name="subject" id="subject" class="form-control" readonly value="Bukti pembayaran anda ditolak">
                    </div>
                    <div class="form-group">
                        <label for="message">Pesan</label>
                        <textarea name="message" id="message" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="/assets/js/admin/message.js"></script>
@endsection