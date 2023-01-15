@extends('layouts.admin')
@section('title')
الضبط العام
@endsection

@section('contentheader')
فئات الاصناف
@endsection

@section('contentheaderlink')
<a href="{{ route('inv_itemcard_categories.index') }}"> فئات الاصناف</a>
@endsection

@section('contentheaderactive')
عرض
@endsection



@section('content')

<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">بيانات  فئات الاصناف</h3>        
          <a href="{{ route('inv_itemcard_categories.create') }}" class="btn btn-sm btn-success" >اضافة فئة جديدة</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
        <div id="">
          
           @if (@isset($data) && !@empty($data) && count($data) >0 ) 
          @php
           $i=1;   
          @endphp
          <table id="example2" class="table table-bordered table-hover">
            <thead class="custom_thead">
           <th>مسلسل</th>
           <th>اسم الفئة</th>
           <th>حالة التفعيل</th>
           <th></th>
          
            </thead>
            <tbody>
         @foreach ($data as $info )
            <tr>
             <td>{{ $i }}</td>  
             <td>{{ $info->name }}</td>  
             <td>@if($info->active==1) مفعل @else معطل @endif</td>  
         <td>
        <a href="{{ route('inv_itemcard_categories.edit',$info->id) }}" class="btn btn-sm  btn-primary">تعديل</a>      
        <a href="{{ route('admin.inv_itemcard_categories.delete',$info->id) }}" class="btn btn-sm  btn-danger">حذف</a>      
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

@endsection

