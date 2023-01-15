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
تعديل
@endsection
@section('content')

      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center"> تعديل حساب عميل </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
       
          <form action="{{ route('admin.customers.update',$data['id']) }}" method="post" enctype="multipart/form-data" >
            <div class="row">
            @csrf
    
    <div class="col-md-6">   
    <div class="form-group">
      <label>اسم العميل  </label>
      <input name="name" id="name" class="form-control" value="{{ old('name',$data['name']) }}"   >
      @error('name')
      <span class="text-danger">{{ $message }}</span>
      @enderror
    </div>
    </div>
    
    
    
          <div class="col-md-6">   
            <div class="form-group">
              <label>ملاحظات   </label>
              <input name="notes" id="notes" class="form-control" value="{{ old('notes',$data['notes']) }}"   >
              @error('notes')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            </div>
            
            <div class="col-md-6">   
              <div class="form-group">
                <label>العنوان   </label>
                <input name="address" id="address" class="form-control" value="{{ old('address',$data['address']) }}"   >
                @error('address')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
    
            <div class="col-md-6">
              <div class="form-group"> 
                <label>  هل هو مفعل </label>
                <select name="active" id="active" class="form-control">
                 <option value="">اختر الحالة</option>
                <option  {{  old('active',$data['active'])==0 ? 'selected' : ''}}  value="1"> نعم</option>
                 <option  {{  old('active',$data['active'])==0 ? 'selected' : ''}}  value="0"> لا</option>
                </select>
                @error('active')
                <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>
              </div>
    
      </div>  
              
      <button type="submit" class="btn btn-primary btn-sm"> حفظ التعديلات</button>
      <a href="{{ route('admin.customers.index') }}" class="btn btn-sm btn-danger">الغاء</a>  
                </form>  




            </div>  

      


        </div>
      </div>
   





@endsection


@section('script')


@endsection





