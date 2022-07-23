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
        .custrow{
            width: 520px;
            margin: 0 auto;
        }
        @media(max-width:767px){
            .custrow{
                width: 100%;
            }
        }
    </style>
    @endsection

    @section('content')


    <div class="card card-default onboarding-body" style="padding-top: 10px;margin-top: 15px;">
        <div class="card-body">
            <h1 class="h1-tag">Complete Information</h1>
            <p class="p-tag">Sed ut perspiciatis unde omnis iste natus error</p><br>
            @livewire('complete-info')
        </div>
    </div>

    @endsection
    
    @section('script')
    <script>
        $("#li_onboarding").addClass('active');
    </script>
    @endsection
</x-app-layout>
