@extends('layouts.admin')
@section('title')
  الضبط العام
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
        <h3 class="card-title">بيانات الضبط العام</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        @if(@isset($data)&&!@empty($data))
          <table id="example2" class="table table-bordered table-hover">

            <tr>
              <td class="width30">اسم الشركة</td>
              <td>{{ $data['system_name'] }}</td>
            </tr>

            <tr>
              <td class="width30">كود الشركة</td>
              <td>{{ $data['com_code'] }}</td>
            </tr>

            <tr>
              <td class="width30">حالة الشركة</td>
              <td>@if ( $data['active']==1)
                مفعل
              @else
                معطل
              @endif</td>
            </tr>

            <tr> 
              <td class="width30">عنوان الشركة</td>
              <td>{{ $data['address'] }}</td>
            </tr>
            <tr> 
              <td class="width30">هاتف الشركة</td>
              <td>{{ $data['phone'] }}</td>
            </tr>
            
            <tr> 
              <td class="width30">حساب المالي الاب للعملاء   </td>
              <td>{{ $data['customer_parent_account_number_name'] }}  رقم حساب مالي ({{  $data['customer_parent_account_number'] }})</td>
            </tr>
             <tr>
               <td class="width30"> رسالة التنبيه اعلى الشاشة للشركة</td>
              <td>{{ $data['general_alert'] }}</td>
             </tr>
             
             <tr>
               <td class="width30">لوقو الشركة</td>
              <td>
                <div class="image">
                  <img class="custom_img" src="{{ asset('assets/admin/uploads').'/'.$data['photo'] }}" alt="logo">
                </div>
              </td>
             </tr>

             <tr>
              <td class="width30"> تاريخ اخر تحديث</td>
             <td>
              @if ($data['updated_by']>0 and $data['updated_by']!=null)
@php
  $dt=new DateTime($data['updated_at']);
  $date=$dt->format("Y-m-d");
  $time=$dt->format("h:i");
  $newDateTime=date('A',strToTime($time));
  $newDateTimeType=(($newDateTime=="Am"))?"صباحا":"مساءا"
@endphp
{{ $date }}
{{ $time }}
{{ $newDateTimeType}}
بواسطة 
{{ $data['updated_by_admin']}}

              @else
                لا يوجد تحديث
              @endif
             </td>
            </tr>
            
          </table>
        
          
        @else
        <div class="text-danger">لا يوجد بيانات لعرضها</div>
        @endif
        <a href="{{ route('admin.panalsettings.edit') }}" class="btn btn-sm btn-success">edit</a>
      </div>
    </div>
  </div>
</div>
@endsection