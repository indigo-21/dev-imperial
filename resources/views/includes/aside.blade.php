<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
        <img src="{{ asset('assets/images/imperial-light.png') }}" alt="Logo" class="img-fluid d-flex m-auto" style="padding:10px; width:180px;">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('projects.index') }}" class="nav-link {{ request()->routeIs('projects.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-layer-group"></i>
                        <p>
                            Projects
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('project-scope-templates.index') }}" class="nav-link {{ request()->routeIs('project-scope-templates.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Project Scope Template
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('costPlans.index') }}" class="nav-link {{ request()->routeIs('costPlans.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>
                            Cost Plans
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('variation-orders.index') }}" class="nav-link {{ request()->routeIs('variation-orders.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>
                            Variation Orders
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>