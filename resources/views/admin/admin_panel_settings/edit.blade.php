@extends('layouts.admin')
@section('title')
تعديل الضبط العام 
@endsection
@section('')
  الضبط
@endsection

@section('contentheaderlink')
  <a href="{{ route('admin.panalsettings.index') }}">link</a>
@endsection
@section('contentheaderlinkactive')
@endsection
@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title card_title_center">تعديل بيانات الضبط العام  </h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        @if(@isset($data)&&!@empty($data))

        <form action="{{ route('admin.panalsettings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf 
        <div class="form-group">
          <label for="">اسم الشركة</label>
          <input type="text" name="system_name" value="{{ $data['system_name'] }}"
          oninvalid="setCustomValidity('من فضلك ادخل اسم الحقل')" onchange="try{setCustomValidity('')}catch(e){}" >
          @error('system_name')
          <span class="text-danger">{{ $message }}</span>
        @enderror
        </div>
        
        <div class="form-group">
          <label for="">عنوان الشركة</label>
          <input type="text" name="address" value="{{ $data['address'] }}"
          oninvalid="setCustomValidity('من فضلك ادخل اسم الحقل')" onchange="try{setCustomValidity('')}catch(e){}" >
          @error('address')
          <span class="text-danger">{{ $message }}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="">هاتف الشركة</label>
          <input type="text" name="phone" value="{{ $data['phone'] }}"
          oninvalid="setCustomValidity('من فضلك ادخل اسم الحقل')" onchange="try{setCustomValidity('')}catch(e){}" required>
          @error('phone')
          <span class="text-danger">{{ $message }}</span>
        @enderror
        
        </div>


          <div class="form-group"> 
            <label> حساب الاب للعملاء بالشجرة المحسابية </label>
            <select name="customer_parent_account_number" id="customer_parent_account_number" class="form-control">
             <option value="">اختر حساب الاب</option>
             @if (@isset($accounts_parent) && !@empty($accounts_parent))
             @foreach ($accounts_parent as $info )
               <option @if(old('customer_parent_account_number',$data['customer_parent_account_number'])==$info->account_number) selected="selected" @endif value="{{ $info->account_number }}"> {{ $info->name }} </option>
             @endforeach
              @endif
            </select>
            @error('customer_parent_account_number')
            <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
    
    
    


        <div class="form-group">
          <label for=""> رسالة تنبيه اعلى الشاشة</label>
          <input type="text" name="general_alert" value="{{ $data['general_alert'] }}">
        </div>
        
        <div class="form-group">
          <label for="">شعار الشركة</label>
          <div class="image">
            <img class="custom_img" src="{{ asset('assets/admin/uploads').'/'.$data['photo'] }}" alt="logo">
            <button id="btn_update_img" class="btn btn-sm btn-danger">تغdير الصورة</button>
            <button id="btn_cancle_update_img" style="display: none" class="btn btn-sm btn-danger">الغاء</button>
          </div>
        </div>
<div class="form-group" id="div_img">

</div>
        <div class="form-group">
          <button type="submit"  class="btn btn-sm btn-primary">حفظ التعديلات</button>

        </div>
    </form>
          
        @else
        <div class="text-danger">لا يوجد بيانات لعرضها</div>
        @endif
        <a href="{{ route('admin.panalsettings.index') }}" class="btn btn-sm btn-success">رجوع </a>
      </div>
    </div>
  </div>
</div>
@endsection