@extends('layouts.admin')
@section('title')
الحسابات
@endsection

@section('contentheader')
انواع الحسابات المالية
@endsection

@section('contentheaderlink')
<a href="{{ route('admin.accountTypes.index') }}">انواع الحسابات المالية</a>
@endsection

@section('contentheaderactive')
عرض
@endsection



@section('content')

<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">انواع الحسابات المالية          </h3>        
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
           <th>اسم النوع</th>
           <th>حالة التفعيل</th>
           <th> هل يضاف من شاشة داخلية    </th>
           <th></th>
          
            </thead>
            <tbody>
         @foreach ($data as $info )
            <tr>
             <td>{{ $i }}</td>  
             <td>{{ $info->name }}</td>   
             <td>@if($info->active==1) مفعل @else معطل @endif</td>  
             <td>@if($info->relatediternalaccounts==1) نعم ويضاف من شاشته @else لا و يضاف من شاشة الحسابات @endif</td>  

   
           </tr> 
      @php
         $i++; 
      @endphp
         @endforeach
   
   
   
            </tbody>
             </table>
      <br>
       
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

