@extends('admin.layout.app')
@section('title','Data Pelamar')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" id="tableApplicant">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Pendidikan Terakhir</th>
                                <th>Bidang Pekerjaan</th>
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
<script src="/assets/js/admin/applicant.js"></script>
@endsection