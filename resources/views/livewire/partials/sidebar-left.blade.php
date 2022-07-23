<!-- Main Sidebar Container -->
<!-- On page css style -->
<style>
    .brand-link img {
        max-width: none;
        width: 235px !important;
    }
    button.btn-search {
       border-bottom-right-radius: 0.375rem !important;
       border-top-right-radius: 0.375rem !important;
    }
</style>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        
        <!-- <img src="{{ asset('images/logo.png') }}"  alt="{{env('APP_NAME', 'Project Logo')}}" class="brand-image float-none"> -->
        <img src="{{ asset('images/new-logo.png') }}"  alt="{{env('APP_NAME', 'Project Logo')}}" class="brand-image float-none">
        <!-- src="{{$applictionLogo}}" -->
        <!-- <span class="brand-text font-weight-light">
            {{$applictionName}}
        </span> -->
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 mb-3 d-flex">
            <div class="image">
                <img src="{{$profileImage}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><strong>{{$username}}</strong></a>
                <div class="user_tags d-block">
                    @foreach (Auth::user()->getRoleNames() as $r)
                    <span class="usertag badge badge-primary">{{$r}}</span>
                    @endforeach
                </div>
            </div>


        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline" style="margin-bottom: 15px;">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-input form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append" style="padding-top: 4px;">
                    <button class="btn btn-sm btn-sidebar btn-search">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2" style="margin-bottom:100px;">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">           
            @foreach ($menus as $menu)
                {{--@if ($menu['li_id'] != 'li_users')--}}
                    @if(array_key_exists("sub-menus",$menu))
                        @can($menu['permission'])
                        <li class="nav-item" id="{{ $menu['li_id'] }}">
                            <a href="#" class="nav-link li_parents">
                                
                                    <i class="{{ $menu['icon'] }}"></i>
                             
                                    <p>
                                        {{ $menu['label'] }}
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                           
                               
                            </a>
                            <ul class="nav nav-treeview">

                                @foreach ($menu['sub-menus'] as $sm )

                                @if(array_key_exists("nav-header",$sm))

                                <li class="nav-header" style="letter-spacing: 3px;">{{$sm['nav-header']}}</li>

                                @else

                                @can((array_key_exists("permission", $sm))? $sm['permission']:$menu['permission'])
                                <li class="nav-item">
                                    <a href="{{ $sm['route'] }}" id="{{ $sm['li_id'] }}" class="nav-link d-flex">
                                        <div>
                                            <i class="{{ $sm['icon'] }}"></i>
                                        </div>
                                        <div>
                                            <p>{{ $sm['label'] }}</p>
                                        </div>
                                    </a>
                                </li>
                                @endcan

                                @endif
                                
                                @endforeach
                            </ul>
                        </li>
                        @endcan
                    @else
                    @can($menu['permission'])
                    <li class="nav-item">
                        <a href="{{$menu['route']}}" class="nav-link d-flex" id="{{$menu['li_id']}}">
                            <div>
                                <i class="{{$menu['icon']}}"></i>
                            </div>
                            <div>
                                <p>{{$menu['label']}}</p>
                            </div>
                        </a>
                    </li>
                    @endcan
                {{--@endif--}}
            @endif

            @endforeach
            <li class="nav-item">
                <form class="nav-link" method="POST" action="{{ route('logout') }}" >
                    <a href="{{ route('logout') }}"  onclick="event.preventDefault();this.closest('form').submit();">
                        @csrf
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Sign out</p>
                    </a>
                </form>
            </li>

        </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
