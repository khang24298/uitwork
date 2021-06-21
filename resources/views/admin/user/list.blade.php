@extends('admin.layouts.index')
@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Người dùng
                    <small>Danh sách</small>
                    <a href="{{ route('user.add') }}" class="btn btn-primary pull-right">Thêm</a>
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

                @if(session()->has('success'))
                    <div class="alert alert-success">{{ session()->get('success') }}</div>
                @endif
            </div>

            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên người dùng</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Phòng ban</th>
                        <th>Vai trò</th>
                        <th>Xóa</th>
                        <th>Sửa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="odd gradeX">
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->phone}}</td>
                        <td>{{$user->department->department_name}}</td>
                        <td>{{$user->userRole->display_name}}</td>

                        <td class="center">
                            <i class="fa fa-trash-o fa-fw"></i>
                            <a onclick="return confirm('Bạn đã chắc chắn muốn xóa?')" href="{{ route('user.delete', [$user->id]) }}">Xóa</a>
                        </td>
                        <td class="center">
                            <i class="fa fa-pencil fa-fw"></i>
                            <a href="{{ route('user.edit', [$user->id]) }}">Sửa</a>
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
