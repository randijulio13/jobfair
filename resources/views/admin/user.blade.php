@extends('admin.layout.app')
@section('title','User '.ucfirst($type))

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Data User {{ ucfirst($type) }}</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table width="100%" class="table table-bordered" id="tableUser">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Tanggal Bergabung</th>
                                <th>Status</th>
                                <!-- <th>Aksi</th> -->
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
<script>
    let type = '{{ $type }}';
    console.log(type)
</script>
<script src="/assets/js/admin/user.js"></script>
@endsection