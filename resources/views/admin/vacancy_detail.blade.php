@extends('admin.layout.app')
@section('title','Detail Lowongan')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card my-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 d-flex align-self-center justify-content-center">
                        <img src="/assets/img/{{ $vacancy->image }}" alt="{{ $vacancy->image }}" class="img-fluid">
                    </div>
                    <div class="col-lg-8">
                        <form id="formVacancy">
                            <input type="hidden" name="id" id="id" value="{{ $vacancy->id }}">
                            <div class="form-group">
                                <label for="title">Judul</label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ $vacancy->title }}">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="description">Deskripsi</label>
                                <textarea name="description" id="description" cols="30" rows="3 " class="form-control">{{ $vacancy->description }}</textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="career_fields" class="mb-1">Bidang Pekerjaan</label>
                                <select class="js-example-basic-multiple form-control" style="width:100%" name="career_fields[]" multiple="multiple">
                                    @foreach($career_fields as $cf)
                                    <?php
                                    $isActive = 0;
                                    foreach ($vacancy_fields as $vf) {
                                        if ($vf->field_id == $cf->id ? 'selected' : '') {
                                            $isActive++;
                                        }
                                    }
                                    $selected = $isActive > 0 ? 'selected' : '';
                                    ?>
                                    <option value="{{ $cf->id }}" {{ $selected }}>{{ $cf->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="image">Poster</label>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" form="formVacancy" id="btnSubmit">Simpan</button>
            </div>
        </div>
    </div>

    @if(!is_silver())
    <div class="col-lg-12">
        <div class="card my-2">
            <div class="card-header">
                Data Pelamar
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" id="tableApplicant">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Pendidikan Terakhir</th>
                                <th>Bidang</th>
                                <th>Dikirim</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection


@section('script')
<script src="/assets/summernote/summernote-bs4.min.js"></script>
<script src="/assets/js/admin/vacancy_detail.js"></script>
@endsection


@section('style')
<link rel="stylesheet" href="/assets/summernote/summernote-bs4.min.css">
@endsection