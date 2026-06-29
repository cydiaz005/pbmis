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


    <div class="onboarding-body">
        <h1 class="h1-tag">Upload your profile</h1>
        <p class="p-tag">Sed ut perspiciatis unde omnis iste natus error</p>
        @livewire('upload-pic')
    </div>

    @endsection
    
    @section('script')
    <script>
        // Preview uploaded image
        function previewFile(input){
            var file = $("#file-input").get(0).files[0];

            if(file){
                var reader = new FileReader();

                reader.onload = function(){
                    $("#previewImg").attr("src", reader.result);
                }

                reader.readAsDataURL(file);
            }
        }
    </script>
    <script>
        $("#li_onboarding").addClass('active');
    </script>
    @endsection
</x-app-layout>
