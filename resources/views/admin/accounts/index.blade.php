@extends('layouts.admin')
@section('title')
الحسابات
@endsection

@section('contentheader')
الحسابات المالية

@endsection

@section('contentheaderlink')
<a href="{{ route('admin.accounts.index') }}">  الحسابات المالية </a>
@endsection

@section('contentheaderactive')
عرض
@endsection



@section('content')


  
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">بيانات   الحسابات المالية</h3>
          <input type="hidden" id="token_search" value="{{csrf_token() }}">
          <input type="hidden" id="ajax_search_url" value="{{ route('admin.accounts.ajax_search') }}">
        
          <a href="{{ route('admin.accounts.create') }}" class="btn btn-sm btn-success" >اضافة جديد</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
          <div class="col-md-4">
            <input  type="radio" checked name="searchbyradio" id="searchbyradio" value="item_code"> برقم الحساب
            <input  type="radio" name="searchbyradio" id="searchbyradio" value="name"> بالاسم
{{-- في الريديو بتوم لازم نفس النيم ونفس الايدي --}}
            <input style="margin-top: 6px !important;" type="text" id="search_by_text" placeholder=" اسم  - رقم الحساب " class="form-control"> <br>
            
                      </div>
                      <div class="col-md-4"> 
                        <div class="form-group"> 
                          <label>  بحث بنوع الحساب  </label>
                          <select name="account_type_search" id="account_type_search" class="form-control ">
                            <option value="all">بحث بالكل </option>
                            @if (@isset($account_types) && !@empty($account_types))
                           @foreach ($account_types as $info )
                             <option value="{{ $info->id }}"> {{ $info->name }} </option>
                           @endforeach
                            @endif
                          </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group"> 
                            <label>  بحث بلااباء</label>
                            <select name="is_parent_search" id="is_parent_search" class="form-control">
                             <option value="all">بحث بالكل </option>
                            <option   @if(old('is_parent')==1) selected="selected"  @endif value="1"> نعم</option>
                             <option @if(old('is_parent')==0 and old('is_parent')!="" ) selected="selected"   @endif value="0"> لا</option>
                            </select>
                            </div>
                          </div>
         
              
               <div class="clearfix"></div>

        <div id="ajax_responce_serarchDiv" class="col-md-12">
          
          @if (@isset($data) && !@empty($data) && count($data)>0)

          <table id="example2" class="table table-bordered table-hover">
            <thead class="custom_thead">
           <th>الاسم </th>
           <th> رقم الحساب </th>
           <th> النوع </th>
           <th> هل هو اب</th>
           <th> حساب الاب</th>
           <th> الرصيد </th>
           <th>حالة التفعيل</th>
         
           <th></th>

            </thead>
            <tbody>
         @foreach ($data as $info )
            <tr>
             <td>{{ $info->name }}</td>  
             <td>{{ $info->account_number }}</td>  
             <td>{{ $info->account_type_name }}</td>  
             <td>@if($info->is_parent==1) نعم@else لا@endif</td>  
             <td>{{ $info->account_parent_name }}</td>  

             <td>@if($info->active==1) مفعل @else معطل @endif</td> 
      
         <td>

        <a href="{{ route('admin.accounts.edit',$info->id) }}" class="btn btn-sm  btn-primary">تعديل</a>   
        <a href="{{ route('admin.accounts.show',$info->id) }}" class="btn btn-sm   btn-info">عرض</a>   
        <a href="{{ route('admin.accounts.delete',$info->id) }}" class="btn btn-sm   btn-danger">حذف</a>   

         </td>
           
   
           </tr> 

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





@endsection

@section('script')
<script src="{{ asset('assets/admin/js/accounts.js') }}"></script>

@endsection

