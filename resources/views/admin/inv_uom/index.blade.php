@extends('layouts.admin')
@section('title')
الضبط العام
@endsection

@section('contentheader')
الوحدات
@endsection

@section('contentheaderlink')
<a href="{{ route('admin.uoms.index') }}"> الوحدات </a>
@endsection

@section('contentheaderactive')
عرض
@endsection



@section('content')

<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">بيانات  الوحدات</h3>
          <input type="hidden" id="token_search" value="{{csrf_token() }}">
          <input type="hidden" id="ajax_search_url" value="{{ route('admin.uoms.ajax_search') }}">
        
          <a href="{{ route('admin.uoms.create') }}" class="btn btn-sm btn-success" > جديد</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="col-md-6">
            <div class="row">
            <div class="col-md-6">
              <label for="">بحث بالاسم</label>
              <input type="text" id="search_by_text" name="search_by_text" class="form-control"> 
            </div>
            <div class="col-md-6">
              <label for="">بحث بالنوع</label>
              <select name="is_master_search" id="is_master_search" class="form-control">
                <option value="all">كل الوحدات</option>
                <option value="1"> وحدة اب</option>
                <option  value="0"> وحدة فرعية</option>
             
               </select>
            </div>

          </div>
          </div>
       <br>
        <div id="ajax_responce_serarchDiv">
          
           @if (@isset($data) && !@empty($data) && count($data) >0 ) 
          @php
           $i=1;   
          @endphp
          <table id="example2" class="table table-bordered table-hover">
            <thead class="custom_thead">
           <th>مسلسل</th>
           <th>اسم الوحدة</th>
           <th>نوع الوحدة</th>
           <th>حالة التفعيل</th>
           <th></th>
          
            </thead>
            <tbody>
         @foreach ($data as $info )
            <tr>
             <td>{{ $i }}</td>  
             <td>{{ $info->name }}</td>  
             <td>@if($info->is_master==1) وحدة اب @else وحدة فرعية @endif</td>  
             <td>@if($info->active==1) مفعل @else معطل @endif</td>  
         <td>
        <a href="{{ route('admin.uoms.edit',$info->id) }}" class="btn btn-sm  btn-primary">تعديل</a>   
        {{-- <a href="{{ route('admin.uoms.delete',$info->id) }}" class="btn btn-sm  btn-danger">حذف</a>    --}}
       
   
         </td>
           
   
           </tr> 
      @php
         $i++; 
      @endphp
         @endforeach
   
   
   
            </tbody>
             </table>
      <br>
           {{ $data->links() }}
       
           @else
           <div class="alert alert-danger">
             عفوا لاتوجد بيانات لعرضها !!
           </div>
                 @endif

        </div>
      
      
      


        </div>
      </div>
    </div>
</div>





@endsection

@section('script')
<script src="{{ asset('assets/admin/js/inv_uoms.js') }}"></script>

@endsection

