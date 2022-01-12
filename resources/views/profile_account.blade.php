@extends('layout.app')
@section('title','Profil')
@section('content')
<section id="blog" class="blog">
    <div class="container" data-aos="fade-up">
        <div class="row">
            <div class="col-lg-8 entries">
                <div class="row">
                    <div class="col-lg-12">
                        <article class="entry">
                            <div class="entry-title">Data Akun</div>
                            <div class="entry-content">
                                <form id="formAccount">
                                    <div class="form-group mb-2">
                                        <label for="username">Username</label>
                                        <input type="text" id="username" value="{{ $userdata->username }}" class="form-control" readonly>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" id="email" value="{{ $userdata->email }}" class="form-control">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="phone">Nomor HP</label>
                                        <input type="text" name="phone" id="phone" value="{{ $userdata->phone }}" class="form-control">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <a href="#" class="btn btn-secondary me-2" id="gantiPassword">Ganti Password</a>
                                    <button type="submit" class="btn btn-primary"> Save</button>
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
<div class="modal fade" id="modalPassword" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ganti Password</h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form id="formPassword">
                        <div class="form-group">
                            <label for="old_password">Password Lama</label>
                            <input type="password" name="old_password" id="old_password" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="new_password">Password Baru</label>
                            <input type="password" name="new_password" id="new_password" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="new_password_confirmation">Ulangi Password</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="formPassword" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="/assets/js/profile.js"></script>
@endsection