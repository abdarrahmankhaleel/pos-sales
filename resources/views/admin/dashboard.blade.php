@extends('layouts.admin')
@section('title')
  الرئيسية
@endsection
@section('')
  الرئيسية
@endsection

@section('contentheaderlink')
  <a href="{{ route('admin.dashboard') }}">link</a>
@endsection
@section('contentheaderlinkactive')
 <div class="row" style="background-image: url({{ asset('assets/admin/dash.jpg') }});background:cover;">
  
 </div>
@endsection