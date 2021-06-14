@extends('admin.layouts.index')
@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Người dùng
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

                <form action="{{ route('user.store') }}" method="POST">
                @csrf
                    <div class="form-group">
                        <label for="name">Tên người dùng</label>
                        <input class="form-control" name="name" id="name" placeholder="Nhập tên người dùng" value="{{ old('name') }}"/>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Nhập Email" value="{{ old('email') }}" />
                    </div>

                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu" value="{{ old('password') }}"/>
                    </div>

                    <div class="form-group">
                        <label for="dob">Ngày sinh</label>
                        <input type="date" class="form-control" name="dob" id="dob" value="{{ old('dob') }}"/>
                    </div>

                    <div class="form-group">
                        <label for="gender">Giới tính</label><br>
                        <input type="radio" id="male" name="gender" value="Nam">
                        <label for="male">Nam</label><br>
                        <input type="radio" id="female" name="gender" value="Nữ">
                        <label for="female">Nữ</label><br>
                        <input type="radio" id="other" name="gender" value="Khác">
                        <label for="other">Khác</label>
                    </div>

                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="tel" class="form-control" name="phone" id="phone" placeholder="Nhập số điện thoại" value="{{ old('phone') }}"/>
                    </div>

                    <div class="form-group">
                        <label for="department_id">Phòng ban</label>
                        <select class="form-control" name="department_id" id="department_id">
                            @foreach ($departments as $dp)
                                <option value="{{$dp->id}}">{{ $dp->department_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="role">Vai trò</label>
                        <select class="form-control" name="role_id" id="role_id">
                            @foreach ($roles as $role)
                                <option value="{{$role->id}}">{{ $role->display_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-default">Thêm</button>
                    <a href="{{ route('user.index') }}"><button type="button" class="btn btn-default">Hủy</button></a>
                <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection
