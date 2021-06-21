@extends('admin.layouts.index')
@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Vai trò
                    <small>Danh sách</small>
                    <a href="{{ route('role.add') }}" class="btn btn-primary pull-right">Thêm</a>
                </h1>
            </div>
            <!-- /.col-lg-12 -->

            <div class="col-lg-7">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session()->has('success'))
                    <div class="alert alert-success">{{ session()->get('success') }}</div>
                @endif
            </div>

            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Tên không dấu</th>
                        <th>Phân quyền</th>
                        <th>Mô tả</th>
                        <th>Xóa</th>
                        <th>Sửa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr class="odd gradeX">
                        <td>{{$role->id}}</td>
                        <td>{{$role->display_name}}</td>
                        <td>{{$role->name}}</td>
                        <td>
                            @if ($role->permissions())
                                <ul>
                                    @foreach ($role->permissions()->get() as $permission)
                                        <li>{{$permission->display_name}}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td>{{$role->description}}</td>
                        <td class="center">
                            <i class="fa fa-trash-o fa-fw"></i>
                            <a onclick="return confirm('Bạn đã chắc chắn muốn xóa?')" href="{{ route('role.delete', [$role->id]) }}">Xóa</a>
                        </td>
                        <td class="center">
                            <i class="fa fa-pencil fa-fw"></i>
                            <a href="{{ route('role.edit', [$role->id]) }}">Sửa</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection
