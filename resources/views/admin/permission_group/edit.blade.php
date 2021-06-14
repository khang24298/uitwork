@extends('admin.layouts.index')
@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Nhóm Quyền
                    <small>Sửa</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session()->has('success'))
                    <div class="alert alert-success">{{ session()->get('success') }}</div>
                @endif

                <form action="{{ route('group.permission.update', [$permissionGroup->id]) }}" method="POST">
                @csrf
                @method('PUT')
                    <div class="form-group">
                        <label for="name">Tên nhóm quyền</label>
                        <input class="form-control" name="name" id="name" value="{{$permissionGroup->name}}"/>

                        <br>

                        <label for="description">Mô tả</label>
                        <textarea class="form-control" name="description" rows="5" id="description">{{$permissionGroup->description}}</textarea>
                    </div>

                    <button type="submit" class="btn btn-default">Cập nhật</button>
                    <a href="{{ route('group.permission.index') }}"><button type="button" class="btn btn-default">Hủy</button></a>
                <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection
