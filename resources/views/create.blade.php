@extends('main')
@section('title')
    اضافة وظيفة جديدة
@endsection

@section('content')
<form method="POST" action="{{ route('storejob',$data->id) }}">
  @csrf 
    <div class="form-group">
      <label for="job_name"> job_name</label>
      <input type="text" class="form-control" id="job_name" name="job_name" value="{{ old('job_name') }}">
      @error('job_name')
        <span class="text-danger">{{ $message }}</span>
      @enderror
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">active status</label>
      <select name="job_active" id="job_active">
        <option value="">select</option>

        <option value="1" @if ( old('job_active')==1 )
          selected
        @endif>yes</option>
        <option @if ( old('job_active')==0 and old('job_active')!="" )
        selected
      @endif value="0">no</option>

      </select>
      @error('job_active')
      <span class="text-danger">{{ $message }}</span>
    @enderror
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
@endsection