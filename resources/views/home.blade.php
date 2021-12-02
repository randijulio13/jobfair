@extends('layout.app')

@section('content')
@include('layout.hero')
@include('layout.content.about_us')
@include('layout.content.clients')
<section id="register" class="cta">
    <div class="container">
        <div class="row" data-aos="zoom-in">
            <div class="col-lg-12 text-center text-lg-start">
                <h3>Kirimkan CV anda sekarang</h3>
                <p>Masukkan nomor TOKEN unik disini</p>
            </div>
            <div class="col-lg-9">
                <form id="formToken">
                    <input type="text" class="mb-2 form-control" name="token">
                </form>
            </div>
            <div class="col-lg-3 text-center">
                <button class="btn-block form-control btn btn-warning" form="formToken" type="submit">Submit</butotn>
            </div>
            <div class="col-lg-12">
                <a href="#" class="text-white">Belum mempunyai nomor token?</a>
            </div>
        </div>
    </div>
</section>
@include('layout.content.contact_us')
@endsection

@section('modal')
<div class="modal fade" id="modalRegister" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container-fluid">
                    <h4 class="my-4">REGISTRASI</h4>
                    <form id="formDaftarUser">
                        <div class="form-group mb-3">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name">
                        </div>
                        <div class="form-group mb-3">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username">
                        </div>
                        <!-- <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email">
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone">Nomor HP</label>
                            <input type="number" class="form-control" id="phone">
                        </div> -->
                        <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password">
                        </div>
                        <div class="form-group mb-3">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation">
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="/assets/js/home.js"></script>
@endsection