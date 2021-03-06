<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
                <!-- /input-group -->
            </li>
            <!-- Dashboard -->
            <li>
                <a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard fa-fw"></i>Bảng điều khiển</a>
            </li>
            <!-- End Dashboard -->

            <!-- PermissionGroup -->
            <li>
                <a href="{{ route('group.permission.index') }}"><i class="fa fa-users fa-fw" aria-hidden="true"></i>Nhóm Quyền<span class="fa arrow"></span></a>
            </li>
            <!-- End PermissionGroup -->

            <!-- Permission -->
            <li>
                <a href="{{ route('permission.index') }}"><i class="fa fa-unlock-alt fa-fw" aria-hidden="true"></i>Quyền<span class="fa arrow"></span></a>
            </li>
            <!-- End Permission -->

            <!-- Role -->
            <li>
                <a href="{{ route('role.index') }}"><i class="fa fa-cubes fa-fw" aria-hidden="true"></i>Vai trò<span class="fa arrow"></span></a>
            </li>
            <!-- End Role -->

            <!-- Member -->
            <!-- <li>
                <a href="#"><i class="fa fa-users fa-fw"></i>Thành viên<span class="fa arrow"></span></a>
            </li> -->
            <!-- End Member -->

            <!-- Member -->
            <li>
                <a href="{{ route('user.index') }}"><i class="fa fa-user fa-fw" aria-hidden="true"></i>Người dùng<span class="fa arrow"></span></a>
            </li>
            <!-- End User -->
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
