@extends('main')  
    @section('title')
        jobs
    @endsection

    @section('content')
  @if( Session::has('succ'))
  <div class="alert alert-success" role="alert">
    {{ Session::get('succ') }}
  </div>
  @endif
    <a href="{{ route('createjob') }}" class="btn btn-info">ADD New</a>
    <div class="col-md-4">

    <input type="text" id="searchbyjobname" class="form-control">
    </div>
    <div id="ajax_search_result">
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
        {{ $data->links() }}
      </table>
    </div>
    
    @endsection

    @section('script')
      <script>
        $(document).ready(function(){
          $(document).on('input',"#searchbyjobname",function(){
          var searchbyjobname=$(this).val();
            jQuery.ajax({
              url:"{{ route('ajax_search_job') }}",
              type:'post',
              datatype:'html',
              cache:false,
              data:{searchbyjobname:searchbyjobname,'_token':"{{ csrf_token() }}"},
              success:function(data){
                $("#ajax_search_result").html(data);
              },
              error:function(){

              }
            })
          })

        })

        $(document).on('click',"#ajax_pagination a",function(e){
          e.preventDefault()
          var searchbyjobname=$(this).val();
            jQuery.ajax({
              url:$(this).attr("href"),
              type:'post',
              datatype:'html',
              cache:false,
              data:{searchbyjobname:searchbyjobname,'_token':"{{ csrf_token() }}"},
              success:function(data){
                $("#ajax_search_result").html(data);
              },
              error:function(){

              }
            })
        })
      </script>

    @endsection
