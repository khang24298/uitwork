@extends('admin.layouts.index')
@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Vai trò
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

                <form action="{{ route('role.store') }}" method="POST">
                @csrf
                    <div class="form-group">
                        <label>Tên vai trò</label>
                        <input class="form-control" name="display_name" id="display_name" placeholder="Nhập tên vai trò" value="{{ old('display_name') }}"/>
                    </div>

                    <br>

                    <div class="form-group">
                        <label for="description">Mô tả</label>
                        <textarea class="form-control" name="description" id="description" rows="5" placeholder="Nhập mô tả cho vai trò">{{ old('description') }}</textarea>
                    </div>

                    <br>

                    <div class="form-group text-left">
                        <label for="permission[]">Phân quyền</label>
                        <br>
                        @foreach ($permissions as $per)
                            <input style="zoom: 1.5;" type="checkbox" name="permission[]" value="{{$per->id}}">{{$per->display_name}}
                            <br>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-default">Thêm</button>
                    <a href="{{ route('role.index') }}"><button type="button" class="btn btn-default">Hủy</button></a>
                </form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection
