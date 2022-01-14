@extends('admin.layout.app')
@section('title','Profil')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="d-flex col-lg-4 align-self-center justify-content-center">
                        <img src="/assets/img/{{ $sponsor->logo }}" alt="{{ $sponsor->name }}" class="img-fluid">
                    </div>
                    <div class="col-lg-8">
                        <form action="/admin/profile" id="formProfil" method="post">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $sponsor->name }}">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="description">Deskripsi</label>
                                <textarea name="description" id="description" cols="30" rows="5" class="form-control">{{ $sponsor->description }}</textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="logo">Logo</label>
                                <input type="file" name="logo" id="logo" class="form-control">
                                <div class="invalid-feedback"></div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="/assets/js/admin/profil.js"></script>
@endsection