@extends('layouts.admin') @section('title')
<title>Quản lý người dùng</title>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Danh sách người dùng </b></h2>
</div>
<form
    class="d-none d-sm-inline-block form-inline ml-md-3 my-2 my-md-0 mw-100 navbar-search"
>
    <div class="input-group">
        <input
            type="text"
            class="form-control bg-light border-0 small"
            placeholder="Search for..."
            aria-label="Search"
            aria-describedby="basic-addon2"
        />
        <div class="input-group-append">
            <button class="btn btn-primary" type="button">
                <i class="fas fa-search fa-sm"></i>
            </button>
        </div>
    </div>
</form>
@endsection @section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <a
                        href="{{ route('nguoidung.create') }}"
                        class="btn btn-success float-right m-2"
                    > 
                    Thêm người dùng 
                    </a>
                </div>
                <div class="tbl-fixed">
                    @if(Session::has('mgs'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fa fa-check"></i>
                            {{Session::get('mgs')}}
                        </div>                    
                    @endif
                    @if(Session::has('mgs-update'))
                    <div class="alert alert-warning alert-dismissible fade show">
                        <i class="fa fa-check" style="color: #d1a400;"></i>
                        {{Session::get('mgs-update')}}
                        
                    </div>
                    @endif
                    
                    <div class="col-md-12">
                        <table class="table">
                            <tr>
                                <th>STT</th>
                                <th>Người dùng</th>
                                <th>Email</th>
                                <th>Quyền</th>
                                <th>Ngày cập nhật</th>
                                <th>Trạng thái</th>
                                <th>Khóa</th>
                                <th>Cập nhật quyền</th>
                                <th>Xóa</th>
                            </tr>
                            @foreach($users as $u)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $u->ho_ten }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td>{{ $u->quyen }}</td>
                                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $u->updated_at)->format('H:i:s d/m/Y') }}</td>
                                    @if($u->trang_thai==1)
                                        <td> Kích hoạt </td>
                                    @else
                                        <td> Khóa </td>                                            
                                    @endif
                                    @if($u->quyen!="Quản trị")
                                        @if($u->trang_thai==1)
                                            <td> 
                                                <form action="{{ route('nguoidung.trangthai', ['id' => $u->id]) }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name = "khoa" value="0">
                                                    <button type="submit" class="btn btn-danger">Khóa</button>
                                                </form>
                                            </td>
                                        @else
                                            <td>
                                                <form action="{{ route('nguoidung.trangthai', ['id' => $u->id]) }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name = "khoa" value="1">
                                                    <button type="submit" class="btn btn-primary">Kích hoạt</button>
                                                </form>
                                            </td>                                            
                                        @endif
                                    @else
                                    <td></td>
                                    @endif
                                    
                                    <td >
                                        <a style="
                                            min-width: max-content;
                                            padding: 3px 12px;
                                            margin: 3px;
                                        " 
                                        href="#" 
                                        onclick="capnhatquyen(this)"
                                        class="btn btn-warning"
                                        data-target="#capnhatquyenModal"
                                        data-toggle="modal"
                                        data-id="{{$u->id}}"
                                        data-quyen="{{ $u->quyen }}" 
                                        
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                            Cập nhật 
                                        </a>
                                    </td>   
                                    <td ><a class="btn btn-danger action_del" 
                                    style="
                                            min-width: max-content;
                                            padding: 3px 12px;
                                            margin: 3px;
                                        "
                                    href="" 
                                    data-url="{{ route('nguoidung.destroy', ['id' => $u->id]) }}" 
                                    >
                                        <i class="bi bi-trash"></i> Xóa
                                    </a>
                                    </td>
                                    
                                </tr>
                            @endforeach
                        <table>
                    </div>
                </div>
                <div class="col-md-12">{!! $users->links()!!}</div>
                
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- coi lai  -->
<div class="modal fade" id="capnhatquyenModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close d-flex align-items-center justify-content-center" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="ion-ios-close"></span>
          </button>
        </div>
        <div class="modal-body p-4 p-md-5">
            <div class="icon d-flex align-items-center justify-content-center">
                <span class="ion-ios-person"></span>
            </div>
            <h3 class="text-center mb-4">Cập nhật quyền</h3>
            <form action="" class="login-form">
                <input type="hidden" name="id" >
                <div class="form-group">
                   <select name="opt_quyen" id="opt_quyen">
                    <option selected value="">-Chọn quyền-</option>
                        <option  value="Quản trị">Quản trị</option>
                        <option value="Nhân viên">Nhân viên</option>
                        <option value="Khách hàng">Khách hàng</option>
                   </select>
                </div>
          <div class="form-group">
              <button type="submit" class="form-control btn btn-primary rounded submit px-3">Cập nhật</button>
          </div>
        </form>
        </div>
        <div class="modal-footer justify-content-center">
            <p>Not a member? <a href="#">Create an account</a></p>
        </div>
      </div>
    </div>
  </div>

@endsection
@section('js')
<script type="text/javascript">
function capnhatquyen(el) {
  var link = $(el) 
  var modal = $("#capnhatquyenModal") 
  alert(link);
  var quyen = link.data('quyen')
  var id = link.data('id')
  modal.find('#quyen').val(quyen);
  modal.find('#id').val(id);
}

</script>
@endsection