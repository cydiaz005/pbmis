<x-app-layout>
    @section('style')
    <style>
        .onboarding-body1 {
            text-align: center;
            padding: 120px 15px;
        }
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
        <h1 class="h1-tag">Your Account is still Pending Approval!</h1>
        <p class="p-tag">Sed ut perspiciatis unde omnis iste natus error</p>
    </div>

    @endsection
    
    @section('script')
    <script>
        $("#li_onboarding").addClass('active');
    </script>
    @endsection
</x-app-layout>
