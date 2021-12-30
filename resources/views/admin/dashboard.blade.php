@extends('admin.layout.app')
@section('title','Dashboard Admin')

@section('content')
@foreach(session('userdata') as $i => $data)
{{ $i }} - {{ $data }} <br>
@endforeach
@endsection