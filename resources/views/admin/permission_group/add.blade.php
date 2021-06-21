@extends('admin.layouts.index')
@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Nhóm quyền
                    <small>Thêm</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">

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

                <form action="{{ route('group.permission.store') }}" method="POST">
                @csrf
                    <div class="form-group">
                        <label for="name">Tên nhóm quyền</label>
                        <input class="form-control" name="name" id="name" placeholder="Tên nhóm quyền" value="{{ old('name') }}"/>

                        <br>

                        <label for="description">Mô tả</label>
                        <textarea class="form-control" name="description" id="description" rows="5" placeholder="Nhập mô tả cho nhóm quyền">{{ old('description') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-default">Thêm</button>
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
