<x-app-layout>
    @section('style')
    <style>
        .layout-fixed .main-sidebar {
            display: none;
        }
        body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .content-wrapper, 
        body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-footer, 
        body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-header {
            margin-left: 0;
        }
        .content-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logoimage{
            display:block !important;
        }
        .sidebar_icon{
            display: none;
        }
    </style>
    @endsection

    @section('content')

    


    <div class="onboarding-body1">
        <h1 class="h1-tag">Welcome to OCD Dashboard!</h1>
        <p class="p-tag">Sed ut perspiciatis unde omnis iste natus error</p>
        <a style="margin-top: 25px;" type="button" href="/onboarding3" class="btn btn-primary">Let's get started</a>
    </div>

    @endsection
    
    @section('script')
    <script>
        $("#li_onboarding").addClass('active');
    </script>
    @endsection
</x-app-layout>
