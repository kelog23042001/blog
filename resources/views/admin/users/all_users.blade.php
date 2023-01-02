@extends('admin_layout')
@section('admin_contend')
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Danh Mục Sản Phẩm</h3>
            <!-- <p class="text-subtitle text-muted">For user to check they list</p> -->
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <a href="{{URL::to('/add-category-product')}}" class="btn btn-success">Thêm Danh Mục</a>
                <ol class="breadcrumb">
                    <!-- <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li> -->
                    <!-- <li class="breadcrumb-item active" aria-current="page">DataTable</li> -->
                </ol>
            </nav>
        </div>
    </div>
    <?php

    use Illuminate\Support\Facades\Session;

    $message = Session::get('message');
    if ($message) {
        echo $message;
        Session::put('message', null);
    }
    ?>
</div>
<div class="page-heading">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped" id="table-category">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên người dùng</th>
                            <th>Email</th>
                            <th>Chức vụ</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <form>
                        
                       @foreach($users as $key => $user)
                       
                       
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <input type="hidden" name="user_id_hidden" id="user_id_hidden" value="{{$user->id}}">

                              <select class="dataTable form-select" name="role" id="role_{{$user->id}}"  onchange="update_role({{$user->id}});">
                                    
                                    @foreach($role as $rol)
                                      @if($rol->id == $user->role_id)
                                       <option selected value="{{$user->role_id}}">{{$rol->name}}</option>
                                      @else 
                                       <option value="{{$rol->id}}">{{$rol->name}}</option>                                    
                                      @endif
                                  @endforeach  
                          
                              </select>
                            </td>
                            <td>
                                <a href="" style="font-size: 20px;"><i class="bi bi-eyedropper"></i></a>
                                <a onclick="return confirm('Bạn có chắc chắn muốn xoá?')" href="" style="font-size: 20px;" class="active styling-edit" ui-toggle-class=""><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        </form>
                      @endforeach
                    </tbody>
                    <script>
       
                          function update_role(id){
                              var role_id = $('#role_' + id).val();
                               var user_id = id;
                               //alert(user_id);
                              //  console.log(role_id);
                            //alert(_token);
                               //alert(role_id);
                              $.ajaxSetup({
                                headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                  url :'{{url('/update-role-user')}}',
                                  method: 'POST',
                                  data: {
                                      user_id : user_id,
                                      role_id : role_id,
                                
                                  },
                                  success: function(data){
                                        
                                  }
                              })
                          }
                        
                    </script>
                </table>
            </div>
        </div>
    </section>
</div>


@endsection