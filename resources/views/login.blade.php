@extends('layout.app')
@section('title','Login')
@section('content')


<section id="blog" class="blog">
    <div class="container" data-aos="fade-up">
        <div class="row">
            <div class="col-lg-8 entries">
                <article class="entry entry-single">
                    <form id="formLogin">
                        <div class="form-group mb-3">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                    </form>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" form="formLogin">Login</button>
                    </div>
                    <div class="form-group mt-2">
                        <span>Belum punya akun? Registrasi <a href="#" id="btnSignUp">disini</a></span=>
                    </div>
                </article><!-- End blog entry -->
            </div>
            @include('layout.profile_sidebar')
        </div>
    </div>
</section><!-- End Blog Single Section -->

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
                            <input type="text" class="form-control" name="name" >
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" >
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone">Nomor HP</label>
                            <input type="number" class="form-control" name="phone">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" >
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" class="form-control" name="password_confirmation" >
                            <div class="invalid-feedback"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" form="formDaftarUser" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="/assets/js/login.js"></script>
@endsection