@extends('layout.app')
@section('title','Profil')
@section('content')
<section id="blog" class="blog">
    <div class="container" data-aos="fade-up">
        <div class="row">
            @include('layout.profile_sidebar')
            <div class="col-lg-8 entries">
                <article class="entry entry-single">
                    <h2 class="entry-title">
                        <a href="#">DATA DIRI</a>
                    </h2>
                    <div class="entry-content">
                        @if($isComplete)
                        <div class="alert alert-warning"><span class="text-danger">*</span> Segera Lengkapi Profil Anda</div>
                        @endif
                        <form id="formProfile">
                            <div class="form-group mb-3">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" class="mt-1 form-control" name="name" id="name" value="{{ $data->name }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="name">Jenis Kelamin {!! $data->gender == NULL ? '<span class="text-danger">*</span>' : '' !!}</label>
                                <select name="gender" id="gender" class="mt-1 form-control">
                                    <?php $gender = ['L' => 'Laki-laki', 'P' => 'Perempuan']; ?>
                                    @foreach($gender as $i => $g)
                                    <option value="{{ $i }}" {{ $data->gender == $i ? 'selected' : ''}}>{{ $g }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="pob" class="mb-1">Tempat / Tanggal Lahir {!! $data->dob == NULL || $data->pob == NULL ? '<span class="text-danger">*</span>' : '' !!}</label>
                                <div class="row">
                                    <div class="col-4"><input type="text" name="pob" id="pob" class="form-control" value="{{ $data->pob }}"></div>
                                    <div class="col-8"><input type="date" name="dob" id="dob" class="form-control" value="{{ $data->dob }}"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group mb-3">
                                        <label for="last_edu">Pendidikan Terakhir {!! $data->last_edu == NULL ? '<span class="text-danger">*</span>' : '' !!}</label>
                                        <select name="last_edu" id="last_edu" class="form-control mt-1">
                                            <?php $edu = ['SD', 'SMP', 'SMA', 'DIII', 'DIV', 'S1', 'S2'] ?>
                                            @foreach($edu as $e)
                                            <option value="{{ $e }}" {{ $data->last_edu == $e ? 'selected' : '' }}>{{ $e }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <label for="major">Jurusan {!! $data->major == NULL ? '<span class="text-danger">*</span>' : '' !!}</label>
                                    <input type="text" class="form-control mt-1" name="major" id="major" value="{{ $data->major }}">
                                </div>
                                <div class="col-3">
                                    <label for="grad_year">Tahun Lulus {!! $data->grad_year == NULL ? '<span class="text-danger">*</span>' : '' !!}</label>
                                    <input type="number" name="grad_year" id="grad_year" class="form-control mt-1" value="{{ $data->grad_year }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="file">File CV / Resume {!! $data->file == NULL ? '<span class="text-danger">*</span>' : '' !!}</label>
                                    <div class="row">
                                        <div class="col-8">
                                            <input type="file" class="form-control mt-1" name="file" id="file">
                                        </div>
                                        <div class="col-4">
                                            <a href="/assets/cv/{{ $data->file }}" target="_blank" class="mt-1 btn btn-success form-control {{ $data->file ? '' : 'disabled' }}">Lihat PDF</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="career_fields" class="mb-1">Bidang Pekerjaan</label>
                                    <select class="js-example-basic-multiple form-control" style="width:100%" name="fields[]" multiple="multiple">
                                        @foreach($career_fields as $cf)
                                        @foreach($applicant_fields as $af)
                                        <option value="{{ $cf->id }}" {{ $af->field_id == $cf->id ? 'selected' : '' }}>{{ $cf->name }}</option>
                                        @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="mt-4 btn btn-primary py-2 px-4">Simpan</button>
                        </form>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script src="/assets/js/profile.js"></script>
@endsection