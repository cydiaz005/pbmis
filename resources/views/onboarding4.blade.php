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
        .form-group {
            width: 320px;
            margin: 0 auto;
        }
        .custom-control-label {
            width: 100%;
            cursor: pointer;
        }
        .custom-control.custom-radio {
            --tw-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --tw-shadow-colored: 0 1px 2px 0 var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
            --tw-border-opacity: 1;
            border-color: rgb(209 213 219 / var(--tw-border-opacity));
            border-radius: 0.375rem;
            display: block;
            margin-top: 0.6rem !important;
            font-size: 1rem;
            height: calc(2.25rem + 2px);
            padding: .375rem .75rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            box-shadow: inset 0 0 0 transparent;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            margin: 0 auto;
            text-align: left;
            padding-left: 45px;
        }
        .custom-forminpt{
            font-size: 1rem !important;
            border-color: var(--ocd-secondary);
            margin-top: 25px;
        }
        @media(max-width:767px){
            .form-group {
                width: 100%;
            }
        }
    </style>
    @endsection

    @section('content')


    <div class="card card-default onboarding-body">
        <div class="card-body">
            <h1 class="h1-tag">Select a Role</h1>
            <p class="p-tag">Sed ut perspiciatis unde omnis iste natus error</p><br>
            @livewire('select-role')
        </div>
    </div>

    @endsection
    
    @section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>
        $('#selregion').css('display','none');
        $('.custom-control-input').on('change', function() {
        var inptvalue = $('input[name=selrole]:checked').val();
        if(inptvalue == "Super Admin" ){
            $('#selregion').css('display','none');
            $("option:selected").prop("selected", false)
        }
        else if(inptvalue == "Regional Admin" || inptvalue == "User" ){
            $('#selregion').css('display','block');
        }
        });
    </script>
    <script>
        $("#li_onboarding").addClass('active');
    </script>
    @endsection
</x-app-layout>
