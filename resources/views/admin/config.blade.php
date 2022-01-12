@extends('admin.layout.app')
@section('title','Konfigurasi Web')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="title">Nama Web</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ $config->title }}">
                </div>
                <div class="form-group">
                    <label for="title_description">Deskripsi Web</label>
                    <textarea name="title_description" id="title_description" cols="30" rows="8" class="form-control">{{ $config->title_description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="about_us">Tentang Kami</label>
                    <textarea name="about_us" id="about_us" cols="30" rows="8" class="form-control">{{ $config->about_us }}</textarea>
                </div>
                <div class="form-group">
                    <label for="phone">Nomor HP</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ $config->phone }}">
                </div>
                <div class="form-group">
                    <label for="email">Nomor HP</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $config->email }}">
                </div>
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea name="address" id="address" cols="30" rows="4" class="form-control">{{ $config->address }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection