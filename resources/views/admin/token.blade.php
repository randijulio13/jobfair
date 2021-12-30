@extends('admin.layout.app')

@section('title','Daftar Token')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="col-lg-4">
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" id="quantity" value="1" min="1">
                        <div class="input-group-append">
                            <a href="#" class="btn btn-primary" id="btnTambah">Generate Token</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="tableToken" width="100%">
                        <thead>
                            <tr>
                                <th width="10%">#</th>
                                <th>Token</th>
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

@section('script')
<script src="/assets/js/admin/token.js"></script>
@endsection