<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item sidebar_icon">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-inline-flex">
            <img class="logoimage" src="{{ asset('images/logo.png') }}">
            <a class="nav-link d-inline" style="color:#000;font-weight:600;">
                {{strtoupper("Planning and Budgeting Management Information System (PBMIS)")}}
            </a>
        </li>
        {{-- <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
        </li> --}}
        {{-- <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
        </li> --}}
    </ul>
   
    
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        {{-- @include('partials.navbar-tools.search') --}}
        {{-- @include('partials.navbar-tools.messages') --}}
        {{-- @include('partials.navbar-tools.notifications') --}}
       <li class="nav-item dropdown">
            <a class="nav-link hover" data-toggle="dropdown"  aria-expanded="false">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge " id="show_notifslide"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">Notifications</span>
            <div class="dropdown-divider"></div>
            <div class="d-flex justify-content-start px-4 col-md-12" id="notif_classification">
            </div>
             <!-- list of notifications -->
             <div class="py-10px" id="notif_contents" style="max-height: 456px; overflow-y: scroll">
                <!-- notifcation content -->
                <!-- <div class="text-center"><small class="text-muted">Loading...</small></div> -->
            </div>    
           
        </li> 
        <form method="POST" action="{{ route('logout') }}" >
            <li class="nav-item">
                <a title="Sign out" href="{{ route('logout') }}" class="nav-link" role="button" onclick="event.preventDefault();this.closest('form').submit();">
                    @csrf
                    <i class="fas fa-power-off"></i>
                </a>
            </li>
        </form>
        
        <!-- <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li> -->
        
    </ul>
</nav>
<!-- /.navbar -->