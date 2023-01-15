
               @if (@isset($data) && !@empty($data)&& @count($data)>0)
               @php
                $i=1;   var_dump(count($data));
               @endphp
            <table id="example2" class="table table-bordered table-hover">
              <thead class="custom_thead">
             <th>الاسم </th>
             <th> الكود </th>
             <th> رقم الحساب </th>
             <th> الرصيد </th>
             <th>حالة التفعيل</th>
           
             <th></th>
  
              </thead>
              <tbody>
           @foreach ($data as $info )
              <tr>
               <td>{{ $info->name }}</td>  
               <td>{{ $info->customer_code }}</td>  
               <td>{{ $info->account_number }}</td>    
               <td></td>    
               <td>@if($info->active==1) مفعل @else معطل @endif</td> 
        
           <td>
  
          <a href="{{ route('admin.customers.edit',$info->id) }}" class="btn btn-sm  btn-primary">تعديل</a>   
          <a href="{{ route('admin.customers.show',$info->id) }}" class="btn btn-sm   btn-info">عرض</a>   
          <a href="{{ route('admin.customers.delete',$info->id) }}" class="btn btn-sm   btn-danger">حذف</a>   
  
           </td>
             
     
             </tr> 
  
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