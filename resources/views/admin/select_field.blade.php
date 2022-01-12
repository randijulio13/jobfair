@extends('admin.layout.app')
@section('title','Data Pelamar')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form id="formField">
                    <label for="field_id">Pilih {{ $field_total }} Bidang Pekerjaan</label>
                    <select class="js-example-basic-multiple form-control" style="width:100%" name="fields[]" multiple="multiple">
                        @foreach($career_fields as $cf)
                        <?php
                        $isActive = 0;
                        foreach ($sponsor_fields as $af) {
                            if ($af->field_id == $cf->id ? 'selected' : '') {
                                $isActive++;
                            }
                        }
                        $selected = $isActive > 0 ? 'selected' : '';
                        ?>
                        <option value="{{ $cf->id }}" {{ $selected }}>{{ $cf->name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" form="formField" type="submit">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="/assets/js/admin/applicant.js"></script>
@endsection