@extends('admin.layout.app')
@section('title','Data Loker')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a href="#" class="btn btn-primary" id="btnAdd">Buat Loker</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table width="100%" class="table table-bordered" id="tableLoker">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Perusahaan</th>
                                <th>Poster</th>
                                <th>Loker</th>
                                <th>Bidang</th>
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
<div class="modal fade" id="modalVacancy" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Lowongan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formVacancy">
                    <div class="container-fluid">
                        @if(session('userdata')['type'] == 1)
                        <div class="form-group">
                            <label for="sponsor_id">Sponsor</label>
                            <select type="select" class="form-control" name="sponsor_id" id="sponsor_id"><select>
                                    <div class="invalid-feedback"></div>
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input type="text" class="form-control" name="title" id="title">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description" cols="30" rows="3 " class="form-control"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                                <label for="career_fields" class="mb-1">Bidang Pekerjaan</label>
                                <select class="js-example-basic-multiple form-control" style="width:100%" name="career_fields[]" multiple="multiple">
                                    @foreach($career_fields as $cf)
                                    <option value="{{ $cf->id }}">{{ $cf->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        <div class="form-group">
                            <label for="image">Poster</label>
                            <input type="file" class="form-control" name="image" id="image">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="formVacancy" id="btnSubmit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="/assets/summernote/summernote-bs4.min.js"></script>
<script src="/assets/js/admin/vacancy.js"></script>
@endsection

@section('style')
<link rel="stylesheet" href="/assets/summernote/summernote-bs4.min.css">
@endsection