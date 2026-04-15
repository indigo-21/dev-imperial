
<nav class="main-header navbar navbar-expand navbar-white navbar-dark bg-dark fixed-top">
<!-- Left navbar links -->
   
    <a href="/dashboard" class="brand-link p-0">
        <img src="{{ asset('assets/images/imperial-light.png') }}" alt="Logo" class="img-fluid d-flex m-auto" style="padding:10px; width:180px;">
    </a>
    <ul class="navbar-nav">
        
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('suppliers.index') }}" class="nav-link {{ request()->routeIs('suppliers.index') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Sub Contractor / Suppliers
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('clients.index') }}" class="nav-link {{ request()->routeIs('clients.index') ? 'active' : '' }}">
                <i class="fas fa-user"></i> Clients
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('projects.index') }}" class="nav-link {{ request()->routeIs('projects.index') ? 'active' : '' }}">
                <i class="fas fa-layer-group"></i> Projects
            </a>
        </li>

        <!-- Dropdown for Configurations -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="configDropdown" role="button" data-toggle="dropdown">
                <i class="fas fa-cogs"></i> Configurations
            </a>
            <div class="dropdown-menu">
                <a href="{{ route('supplier-types.index') }}" class="dropdown-item">
                    Supplier Types
                </a>
            </div>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                Hi, {{ Auth::user()->firstname }}
            </a>

            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <li class="user-header">
                    <div class="circle-icon">
                        {{ strtoupper(substr(Auth::user()->firstname, 0, 1). substr(Auth::user()->lastname, 0, 1))}}
                    </div>
                    <p>
                         {{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}
                    </p>
                </li>
                <li class="user-footer">
                    <a href="{{ route('profile.edit') }}" class="btn btn-default btn-flat">Profile</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="btn btn-default btn-flat" href="route('logout')" onclick="event.preventDefault();
                        this.closest('form').submit();">
                        <p>Logout</p>
                        </a>

                    </form>
                </li>
            </ul>
        </li>
 


    </ul>
</nav>
<!-- /.navbar -->