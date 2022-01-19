@extends('admin.layout.app')
@section('title','Konfigurasi Web')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form id="formConfig">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="title">Nama Web</label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ $config->title }}">
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
                            <div class="form-group">
                                <label for="user_register">Pendaftaran User</label>
                                <select name="user_register" id="user_register" class="form-control">
                                    <option value="0" {{ $config->user_register == 0 ? 'selected' : '' }}>Nonaktif</option>
                                    <option value="1" {{ $config->user_register == 1 ? 'selected' : '' }}>Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="title_description">Deskripsi Web</label>
                                <textarea name="title_description" id="title_description" cols="30" rows="8" class="form-control">{{ $config->title_description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="about_us">Tentang Kami</label>
                                <textarea name="about_us" id="about_us" cols="30" rows="8" class="form-control">{{ $config->about_us }}</textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" form="formConfig">Submit</button>
            </div>
        </div>
    </div>

    <div class="col-lg-12 mt-3">
        <div class="card">
            <div class="card-header">Banner Halaman Depan</div>
            <div class="card-body">
                <a href="#" class="btn btn-primary mb-4" id="addBanner">Tambah Banner</a>
                <div class="table-responsive">
                    <table class="table table-bordered" id="tableBanner" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>File</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" id="modalBanner" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Tambah Banner
            </div>
            <div class="modal-body">
                <form id="formBanner">
                    <div class="container-fluid">
                        <label for="file">Pilih Gambar</label>
                        <input type="file" name="file" id="file" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="formBanner" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="/assets/js/admin/config.js"></script>
@endsection