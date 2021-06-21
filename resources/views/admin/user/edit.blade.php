@extends('admin.layouts.index')
@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Người dùng
                    <small>Sửa</small>
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

                <form action="{{ route('user.update', [$user->id]) }}" method="POST">
                @csrf
                @method('PUT')
                    <div class="form-group">
                        <label for="name">Tên người dùng</label>
                        <input class="form-control" name="name" id="name" value="{{$user->name}}" />
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" value="{{$user->email}}" />
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input type="tel" class="form-control" name="phone" id="phone" value="{{$user->phone}}" />
                    </div>

                    <div class="form-group">
                        <label for="department_id">Phòng ban</label>
                        <select class="form-control" name="department_id" id="department_id">
                            @foreach ($departments as $dp)
                                <option
                                    @if ($user->department_id === $dp->id)
                                        {{ "selected" }}
                                    @endif
                                    value="{{$dp->id}}">{{ $dp->department_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="role">Vai trò</label>
                        <select class="form-control" name="role_id" id="role_id">
                            @foreach ($user_roles as $userRole)
                                @foreach ($roles as $role)
                                    <option
                                        @if ($userRole->user_id === $user->id && $userRole->role_id === $role->id)
                                            {{ "selected" }}
                                        @endif
                                        value="{{$role->id}}">{{ $role->display_name }}
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-default">Cập nhật</button>
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
