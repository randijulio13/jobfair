@extends('admin.layout.app')
@section('title','Metode Pembayaran')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <a href="#" class="btn btn-primary" id="btnAdd">Tambah</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="tablePayment" width="100%">
                        <thead>
                            <th>#</th>
                            <th>Logo</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Aksi</th>
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
<div class="modal fade" id="modalPayment" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Metode Pembayaran
            </div>
            <div class="modal-body">
                <form id="formPayment">
                    <div class="container-fluid">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" id="name" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description" cols="30" rows="5" class="form-control"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" name="logo" id="logo" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formPayment">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="/assets/js/admin/payment.js"></script>
@endsection