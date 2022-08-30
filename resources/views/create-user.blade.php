<x-app-layout>
    @section('style')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <style>
        .plus, .minus {
            display: inline-block;
            background-repeat: no-repeat;
            width: 18px;
            height: 16px;
            cursor: pointer;
            background-position: center;
        }
        .plus {
            background-image: url(images/arrowright.png);
            background-size: 7px 11px !important;
        }
        .minus {
            background-image: url(images/arrowdown.png);
            background-size: 11px 7px !important;
        }
        ul {
            list-style: none;
            padding: 0px 0px 0px 20px;
        }
        ul.inner_ul li:before {
            content: "├";
            font-size: 18px;
            margin-left: -5px;
            margin-top: -5px;
            vertical-align: middle;
            float: left;
            width: 8px;
            color: #aeaeb1;
        }
        ul.inner_ul li:last-child:before {
            content: "└";
        }
        .inner_ul {
            padding: 0px 0px 0px 35px;
        }
        input[type='checkbox'] {
            border-radius: .25rem;
            margin-right: 10px;
            margin-bottom: 5px;
            margin-left: 10px;
            margin-top: 0px;
        }
        span{
            font-size: 15px;
            color: #374151;
        }
        .mainlevel {
            margin-top: 15px;
        }
        .for_left{
            padding-left:20px;
        }
        .custom-control{
            display: inline;
            margin-left: 15px;
        }
        .ultree{
            width:50%;
        }
        .custom-control-label {
            cursor: pointer;
            font-size: 15px;
            color: #374151;
        }
        .nav-pills .nav-link:not(.active):hover {
            color: #374151;
        }
        @media(max-width:767px){
            .for_left{
                padding-left:7.5px;
            }
            .ultree{
                width:100%;
            }
        }
    </style>
    
    @endsection

    @section('content')

    @livewire('partials.content-header', [
      'pageTitle' => 'User Approval and Suspension',
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
            ['name' => 'Users', 'route' => '#'],
            ['name' => 'Approval & Suspension', 'route' => '#'],
            ['name' => 'Create User', 'route' => '#'],
        ],  
    ])


    @livewire('create-user')

    @endsection
    
    @section('script')
    <script>
        $(".plus").toggleClass("minus").siblings("ul").toggle();

        $(document).ready(function () {

                $(".plus").click(function () {
                    $(this).toggleClass("minus").siblings("ul").toggle();
                })

                $("input[type=checkbox]").click(function () {
                    $(this).siblings("ul").find("input[type=checkbox]").prop('checked', $(this).prop('checked'));
                })

            $("input[type=checkbox]").change(function () {
                var sp = $(this).attr("id");
                if (sp.substring(0, 4) === "c_io") {
                    var ff = $(this).parents("ul[id^=bf_l]").attr("id");
                    if ($('#' + ff + ' > li input[type=checkbox]:checked').length == $('#' + ff + ' > li input[type=checkbox]').length) {
                        $('#' + ff).siblings("input[type=checkbox]").prop('checked', true);
                        check_fst_lvl(ff);
                    }
                    else {
                        $('#' + ff).siblings("input[type=checkbox]").prop('checked', false);
                        check_fst_lvl(ff);
                    }
                }

                if (sp.substring(0, 4) === "c_bf") {
                    var ss = $(this).parents("ul[id^=bs_l]").attr("id");
                    if ($('#' + ss + ' > li input[type=checkbox]:checked').length == $('#' + ss + ' > li input[type=checkbox]').length) {
                        $('#' + ss).siblings("input[type=checkbox]").prop('checked', true);
                        check_fst_lvl(ss);
                    }
                    else {
                        $('#' + ss).siblings("input[type=checkbox]").prop('checked', false);
                        check_fst_lvl(ss);
                    }
                }
            });
        })

        function check_fst_lvl(dd) {
            var ss = $('#' + dd).parent().closest("ul").attr("id");
            if ($('#' + ss + ' > li input[type=checkbox]:checked').length == $('#' + ss + ' > li input[type=checkbox]').length) {
                $('#' + ss).siblings("input[type=checkbox]").prop('checked', true);
            }
            else {
                $('#' + ss).siblings("input[type=checkbox]").prop('checked', false);
            }
        }

        function pageLoad() {
            $(".plus").click(function () {
                $(this).toggleClass("minus").siblings("ul").toggle();
            })
        }

        $('#selpermission').change(function(){
            if($(this).val() == 'All'){ 
                $('#pertreeview').css('height','0').slideToggle("fast");
            }
            else if($(this).val() == 'Custom'){
                $('#pertreeview').css('height','100%').slideToggle("fast");
            }
        });
    </script>
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
        $("#li_users").addClass('menu-open');
        $("#li_users>a.li_parent").addClass('active');
        $("#li_approval").addClass('active');
    </script>
    @endsection
</x-app-layout>
