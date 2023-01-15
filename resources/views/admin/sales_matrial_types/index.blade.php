@extends('layouts.admin')
@section('title')
الضبط العام
@endsection

@section('contentheader')
فئات الفواتير
@endsection

@section('contentheaderlink')
<a href="{{ route('admin.sales_matrial_types.index') }}"> فئلت الفواتير </a>
@endsection

@section('contentheaderactive')
عرض
@endsection



@section('content')

<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">بيانات  فئلت الفواتير</h3>        
          <a href="{{ route('admin.sales_matrial_types.create') }}" class="btn btn-sm btn-success" >اضافة فئة جديدة</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
        <div id="">
          
           @if (@isset($Sales_matrial_types) && !@empty($Sales_matrial_types) && count($Sales_matrial_types) >0 ) 
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
         @foreach ($Sales_matrial_types as $info )
            <tr>
             <td>{{ $i }}</td>  
             <td>{{ $info->name }}</td>  
             <td>@if($info->active==1) مفعل @else معطل @endif</td>  
         <td>
        <a href="{{ route('admin.sales_matrial_types.edit',$info->id) }}" class="btn btn-sm  btn-primary">تعديل</a>      
        <a href="{{ route('admin.sales_matrial_types.delete',$info->id) }}" class="btn btn-sm  btn-danger">حذف</a>      
         </td>
           
   
           </tr> 
      @php
         $i++; 
      @endphp
         @endforeach
   
   
   
            </tbody>
             </table>
      <br>
           {{ $Sales_matrial_types->links() }}
       
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

