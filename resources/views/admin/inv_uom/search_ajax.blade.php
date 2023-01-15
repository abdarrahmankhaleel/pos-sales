
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
 <div class="col-md-12" id="ajax_pagination_in_search">
    {{ $data->links() }}
 </div>

         
       
           @else
           <div class="alert alert-danger">
             عفوا لاتوجد بيانات لعرضها !!
           </div>
                 @endif