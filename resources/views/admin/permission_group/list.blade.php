@extends('admin.layouts.index')
@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Nhóm quyền
                    <small>Danh sách</small>
                    <a href="{{ route('group.permission.add') }}" class="btn btn-primary pull-right">Thêm</a>
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
                        <th>Mô tả</th>
                        <th>Xóa</th>
                        <th>Sửa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissionGroups as $pg)
                    <tr class="odd gradeX">
                        <td>{{$pg->id}}</td>
                        <td>{{$pg->name}}</td>
                        <td>{{$pg->description}}</td>
                        <td class="center">
                            <i class="fa fa-trash-o fa-fw"></i>
                            <a onclick="return confirm('Bạn đã chắc chắn muốn xóa?')" href="{{ route('group.permission.delete', [$pg->id]) }}">Xóa</a>
                        </td>
                        <td class="center">
                            <i class="fa fa-pencil fa-fw"></i>
                            <a href="{{ route('group.permission.edit', [$pg->id]) }}">Sửa</a>
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
