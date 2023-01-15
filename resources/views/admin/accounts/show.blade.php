@extends('layouts.admin')
@section('title')
ضبط الاصناف
@endsection

@section('contentheader')
الاصناف
@endsection

@section('contentheaderlink')
<a href="{{ route('admin.itemcard.index') }}">  الاصناف </a>
@endsection

@section('contentheaderactive')
عرض التفاصيل
@endsection


@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">بيانات  الصنف</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        @if(@isset($data)&&!@empty($data))
          <table id="example2" class="table table-bordered table-hover">

            <tr>
              <td>
                <label for="">اسم الصنف</label> <br>
                {{ $data['name'] }}
              </td>
              <td>
                <label for="">باركود الصنف</label> <br>
                {{ $data['barcode'] }}
              </td>

              <td>
                <label for="">باركود الصنف</label><br>
                @if($data['item_type']==1) مخزني  @elseif($data['item_type']==2) استهلاكي بصلاحية   @elseif($data['item_type']==3) عهدة @else غير محدد @endif
              </td>

            </tr>

            <tr>
              <td>
                <label for="">فئة الصنف</label> <br>
                {{                 $data['inv_itemcard_categories_name']              }}
              </td>
              <td>
                <label for="">اسم الصنف الاب</label> <br>
                @if (!empty($data['inv_itemcard_parent_name']))
                
                {{ $data['inv_itemcard_parent_name'] }}
                @else
                  لا يوجد 
                @endif
              </td>

              <td>
                <label for="">وحدة الكبرى للصنف</label><br>
                {{ $data['Uom_name']  }}
                     </td>

            </tr>
            

            <tr>
          <td @if ( $data['does_has_retailunit'] ==0) colspan="3" @endif>
                <label for=""> هل للصنف وحدة تجزئة</label> <br>
                @if ( $data['does_has_retailunit'] ==1)
                  نعم
                @else
                  لا
                @endif
              </td>
              @if ($data['does_has_retailunit'] ==1)
              <td>
                <label for=""> وحدة التجزئة </label> <br>
{{ $data['retail_uom_name'] }}
              </td>
              <td>
                <label for="">  عدد وحدات التجزئة ({{ $data['retail_uom_name'] }})  في وحدة الاب ({{ $data['Uom_name'] }}) </label><br>
                {{ $data['retail_uom_quntToParent']*1  }}
                </td>
              @endif
            </tr>
            
            <tr>
              <td>
                <label>سعر القطاعي بوحدة الاب ({{ $data['Uom_name'] }})</label> <br>
                {{ $data['price'] *1}}
              </td>
              <td>
                <label>سعر النص جملة بوحدة الاب ({{ $data['Uom_name'] }})</label> <br>
                {{ $data['nos_gomla_price'] *1}}
              </td>

              <td>
                <label>سعر  الجملة بوحدة الاب ({{ $data['Uom_name'] }})</label> <br>
                {{ $data['gomla_price'] }}

              </td>

            </tr>
            <tr>
              <td @if ( $data['does_has_retailunit'] ==0) colspan="3" @endif>
                <label>سعر تكلفة الشراء بوحدة الاب ({{ $data['Uom_name'] }})</label> <br>
                {{ $data['cost_price'] }}
              </td>
              @if ($data['does_has_retailunit'] ==1)
              <td>
                <label>سعرالقطاعي  بوحدة التجزئة ({{ $data['retail_uom_name'] }})</label> <br>
                {{ $data['price_retail'] }}
              </td>

              <td>
                <label>سعر النص جملة  بوحدة التجزئة ({{ $data['retail_uom_name'] }})</label> <br>
                {{ $data['nos_gomla_price_retail'] }}
              </td>

              @endif
            
            </tr>

            @if ($data['does_has_retailunit']==1)
              <tr>
                <td colspan="3">
                  <label>سعر تكلفة الشراء  بوحدة التجزئة ({{ $data['retail_uom_name'] }})</label> <br>
                  {{ $data['cost_price_retail'] }}
                </td>
              </tr>
            @endif
                  

            <tr>
              <td>
                <label for="">هل للصنف سعر ثابت</label><br>
                @if($data['has_fixced_price']==1)  نعم ,سعره ثابت @else لا , قابا للتغير  @endif
              </td>
              <td colspan="2">
                <label for="">حالة الصنف  </label><br>
                @if($data['active']==1) مفعل @else معطل@endif
              </td>

            </tr>



             <tr>
               <td class="width30">لوقو الشركة</td>
              <td colspan="2">
                <div class="image">
                  <img class="custom_img" src="{{ asset('assets/admin/uploads').'/'.$data['photo'] }}" alt="logo">
                </div>
              </td>
             </tr>

             <tr>
              <td class="width30"> تاريخ اخر تحديث</td>
             <td colspan="2">
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
        <a href="{{ route('admin.itemcard.edit',$data['id']) }}" class="btn btn-sm btn-success">edit</a>
      </div>
    </div>
  </div>
</div>
@endsection