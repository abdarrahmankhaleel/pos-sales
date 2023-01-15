<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">name</th>
      <th scope="col">active</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
   
   @if (!@empty($data))
      
   @php $i=1; @endphp
      @foreach ($data as $obj)
          <tr>
              <td>{{ $obj->id }}</th>
              <td>{{ $obj->name }}</td>
              <td>@if ($obj->active==1) مفعل @else معطل  @endif
              </td>
              <td style="color: white"><a href="{{ route('editjob',$obj->id) }}" class="btn btn-sm btn-info">edit</a></td>
              <td style="color: white"><a href="{{ route('deletejob',$obj->id) }}" class="btn btn-sm btn-danger">delete </a></td>

          </tr>
          @php $i++ @endphp
      @endforeach
   @else
       
   @endif
  </tbody>
  <br>
  <div class="col-md-12" id="ajax_pagination">
    {{ $data->links() }}

  </div>
</table>