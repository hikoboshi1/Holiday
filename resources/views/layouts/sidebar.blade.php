<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/home') }}" class="brand-link">
        <span class="brand-text font-weight-light">Portal</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
            </div>
            <div class="info">
                <a href="{{ url('/home') }}" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p> MENU </p>
                        <i class="right fas fa-angle-left"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/home') }}" class="nav-link ml-1">
                                <i class="fas fa-home fa-lg"></i>
                                <p> トップ </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview menu-open">
                            <a href="#" class="nav-link ml-2">
                                <i class="far fa-calendar-alt fa-lg"></i>
                                <p> 休暇届 <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/index') }}" class="nav-link ml-4">
                                        <i class="far fa-list-alt fa-lg"></i>
                                        <p> 一覧 </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/new') }}" class="nav-link ml-4">
                                        <i class="fas fa-folder-plus fa-lg"></i>
                                        <p> 申請 </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview menu-open">
                            <a href="#" class="nav-link ml-2">
                                <i class="fas fa-file-invoice-dollar fa-lg"></i>
                                <p> 経費精算 <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link ml-4">
                                        <i class="far fa-list-alt fa-lg"></i>
                                        <p> 一覧 </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link ml-4">
                                        <i class="fas fa-folder-plus fa-lg"></i>
                                        <p> 申請 </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>