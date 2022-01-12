@extends('admin.layout.app')
@section('title','Pesan')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tableMessage" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Dari</th>
                            <th>Subjek</th>
                            <th>Diterima</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="/assets/js/admin/message.js"></script>
@endsection