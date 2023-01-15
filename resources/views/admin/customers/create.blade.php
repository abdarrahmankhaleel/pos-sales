@extends('layouts.admin')
@section('title')
العملاء
@endsection

@section('contentheader')
ضبط المخازن

@endsection

@section('contentheaderlink')
<a href="{{ route('admin.customers.index') }}"> العملاء</a>
@endsection

@section('contentheaderactive')
اضافة
@endsection
@section('content')

      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center"> اضافة حساب عميل جديد</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
       
      
      <form action="{{ route('admin.customers.store') }}" method="post" enctype="multipart/form-data" >
        <div class="row">
        @csrf

    <div class="col-md-6">   
    <div class="form-group">
      <label>اسم العميل  </label>
      <input name="name" id="name" class="form-control" value="{{ old('name') }}"   >
      @error('name')
      <span class="text-danger">{{ $message }}</span>
      @enderror
    </div>



        <div class="col-md-6">   
          <div class="form-group">
            <label>رصيد الحساب اول المدة  </label>
            <input  oninput="this.value=this.value.replace(/[^0-9.]/g,'');"  name="start_balance" id="start_balance" class="form-control" value="{{ old('start_balance') }}"   >
            @error('start_balance')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          </div>

    <div class="col-md-6">
      <div class="form-group"> 
        <label>  حالة الرصيد اول المدة</label>
        <select name="start_balance_status" id="start_balance_status" class="form-control">
         <option value="">اختر الحالة</option>
        <option   @if(old('start_balance_status')==1) selected="selected"  @endif value="1"> دائن</option>
         <option @if(old('start_balance_status')==2 ) selected="selected"   @endif value="2"> مدين</option>
         <option @if(old('start_balance_status')==3 ) selected="selected"   @endif value="3"> متزن</option>
        </select>
        @error('start_balance_status')
        <span class="text-danger">{{ $message }}</span>
        @enderror
        </div>
      </div>

    

      <div class="col-md-6">   
        <div class="form-group">
          <label>ملاحظات   </label>
          <input name="notes" id="notes" class="form-control" value="{{ old('notes') }}"   >
          @error('notes')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        </div>
        
        <div class="col-md-6">   
          <div class="form-group">
            <label>العنوان   </label>
            <input name="address" id="address" class="form-control" value="{{ old('address') }}"   >
            @error('address')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group"> 
            <label> حالة التفعيل</label>
            <select name="active" id="active" class="form-control">
             <option value="">اختر الحالة</option>
            <option   @if(old('active')==1 or old('active')==null ) selected="selected"  @endif  value="1"> مفعل</option>
             <option @if(old('active')==0 and old('active')!="" ) selected="selected"   @endif value="0"> معطل</option>
            </select>
            @error('active')
            <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
          </div>

    

  </div>  
          
  <button type="submit" class="btn btn-primary btn-sm"> اضافة</button>
  <a href="{{ route('admin.customers.index') }}" class="btn btn-sm btn-danger">الغاء</a>  
            </form>  


            </div>  

      


        </div>
      </div>
   





@endsection


@section('script')
<script src="{{ asset('assets/admin/js/customers.js') }}"></script>


@endsection





