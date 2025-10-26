  <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Htoo Blog</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <?php
            $activePage = isset($_GET['page']) ? $_GET['page'] : '';
            ?>

            <li class="nav-item <?php echo ($activePage == '' ? 'active' : ''); ?>">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item <?php echo ($activePage == 'categories' || $activePage == 'categories-create' || $activePage == 'categories-edit' ? 'active' : ''); ?>">
                <a class="nav-link" href="index.php?page=categories">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Category</span>
                </a>
            </li>

            <li class="nav-item <?php echo ($activePage == 'users' || $activePage == 'users-create' || $activePage == 'users-edit' ? 'active' : ''); ?>">
                <a class="nav-link" href="index.php?page=users">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Users</span>
                </a>
            </li>
            <li class="nav-item <?php echo ($activePage == 'blogs' || $activePage == 'blogs-create' || $activePage == 'blogs-edit' ? 'active' : ''); ?>">
                <a class="nav-link" href="index.php?page=blogs">
                    <i class="fas fa-fw fa-blog"></i>
                    <span>Blogs</span>
                </a>
            </li>
            <li class="nav-item <?php echo ($activePage == 'blogs-comments' || $activePage == 'blogs-create' || $activePage == 'blogs-edit' ? 'active' : ''); ?>">
                <a class="nav-link" href="index.php?page=blogs-comments">
                    <i class="fas fa-fw fa-comments"></i>
                    <span>Comments</span>
                </a>
            </li>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>