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
            .ultree{
                width:100%;
            }
        }
    </style>
    @endsection
    @section('content')
        @livewire('partials.content-header', [
            'pageTitle' => 'Roles and Permissions',
            'breadcrumb' => [
                ['name' => 'Dashboard', 'route' => 'dashboard/admin'],
                ['name' => 'Data Guard', 'route' => '#'],
                ['name' => 'Roles and Permissions', 'route' => '#'],
            ]
            
        ])
        {{-- <div class="card-header" style="padding: 20px;border-bottom: 0;">
            <a href="#createRoleModal" data-toggle="modal" type="button" class="btn btn-primary float-right">
            <i class="fas fa-plus"></i>&nbsp;
                Add New Role</a>
        </div> --}}
        <div class="row">
        <div id="unsavedAlert" class="col-12 hidden">
        <div class="d-flex align-items-center justify-content-between  flex-row alert alert-warning" role="alert">
            <p>
                Careful -- you have unsaved changes
            </p>
            <div class="d-flex flex-row align-items-center">
            <p onclick="location.reload()" class="btn mr-3">
               Reset
            </p>
                <button onclick="saveChanges()" type="button" class="btn bg-success btn-success">Save changes</button>
            </div>
        </div>
  
        </div>
        <div class="col-8">
            @livewire('roles-and-permissions.roles')
        </div>
        @php
        $superadmins = App\Models\User::role('Super Administrator')->take(6)->get();
        $admins = App\Models\User::role('Administrator')->take(6)->get();
        $twgs = App\Models\User::role('Technical Working Group')->take(6)->get();
        $pfs = App\Models\User::role('Planning Focal/Officer')->take(6)->get();
        @endphp
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                <h3 class="card-title">Super Administrator</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
                </div>
                
                <div class="card-body p-0 pb-3 ">
                <ul class="users-list clearfix mb-2 border">
                    @foreach($superadmins as $user)
                    <li>
                        @if(isset($user->profilePhoto))
                        <img src="{{asset('public/images/'.$user->profilePhoto->url)}}" alt="User Image">

                        @else
                        <img src="https://ui-avatars.com/api/?name={{$user->firstname}}&background=0D8ABC&color=fff" alt="User Image">
                        @endif
                        <a class="users-list-name" href="#">{{$user->firstname}} {{$user->lastname}}</a>
                        <span class="users-list-date">{{date_format($user->created_at,"M d Y")}}</span>
                    </li>
                    @endforeach
                </ul>
                <a href="/user/all" class="text-primary  ml-2 card-link">See more</a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                <h3 class="card-title">Administrator</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
                </div>
                
                <div class="card-body p-0 pb-3 ">
                    <ul class="users-list clearfix mb-2 border">
                        @foreach($admins as $user)
                        <li>
                            @if(isset($user->profilePhoto))
                            <img src="{{asset('public/images/'.$user->profilePhoto->url)}}" alt="User Image">

                        @else
                        <img src="https://ui-avatars.com/api/?name={{$user->firstname}}&background=0D8ABC&color=fff" alt="User Image">
                        @endif
                            <a class="users-list-name" href="#">{{$user->firstname}} {{$user->lastname}}</a>
                            <span class="users-list-date">{{date_format($user->created_at,"M d Y")}}</span>
                        </li>
                        @endforeach
                    </ul>
                    <a href="/user/all" class="text-primary  ml-2 card-link">See more</a>
                    </div>
            </div>
           
            <div class="card">
                <div class="card-header">
                <h3 class="card-title">Technical Working Group</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
                </div>
                
                <div class="card-body p-0 pb-3 ">
                    <ul class="users-list clearfix mb-2 border">
                        @foreach($twgs as $user)
                        <li>
                        @if(isset($user->profilePhoto))
                        <img src="{{asset('public/images/'.$user->profilePhoto->url)}}" alt="User Image">

                        @else
                        <img src="https://ui-avatars.com/api/?name={{$user->firstname}}&background=0D8ABC&color=fff" alt="User Image">
                        @endif
                            <a class="users-list-name" href="#">{{$user->firstname}} {{$user->lastname}}</a>
                            <span class="users-list-date">{{date_format($user->created_at,"M d Y")}}</span>
                        </li>
                        @endforeach
                    </ul>
                    <a href="/user/all" class="text-primary  ml-2 card-link">See more</a>
                    </div>
            </div>

            <div class="card">
                <div class="card-header">
                <h3 class="card-title">Planning Focal/Officer</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
                </div>
                
                <div class="card-body p-0 pb-3 ">
                    <ul class="users-list clearfix mb-2 border">
                        @foreach($pfs as $user)
                        <li>
                            @if(isset($user->profilePhoto))
                            <img src="{{asset('public/images/'.$user->profilePhoto->url)}}" alt="User Image">
                            @else
                            <img src="https://ui-avatars.com/api/?name={{$user->firstname}}&background=0D8ABC&color=fff" alt="User Image">
                            @endif
                            <a class="users-list-name" href="#">{{$user->firstname}} {{$user->lastname}}</a>
                            <span class="users-list-date">{{date_format($user->created_at,"M d Y")}}</span>
                        </li>
                        @endforeach
                    </ul>
                    <a href="/user/all" class="text-primary  ml-2 card-link">See more</a>
                    </div>
            </div>
        </div>
        </div>

    <!-- create role -->
    {{-- <div class="modal fade" id="createRoleModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="/data-guard/roles-permissions/roles" method="POST" id="">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">Name</label>
                        <input type="text" name="rolename" id="rolename" class="form-control form-input">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </div>
            </form>
        </div>
    </div> --}}
 
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

        $("#li_dataguard").addClass('menu-open');
        $("#li_dataguard>a.li_parent").addClass('active');
        $("#li_roles").addClass('active');









        let showAlertUnsavedChanges = false;
let permissionsToToggle = {


}
let unsavedAlertContainer = document.querySelector("#unsavedAlert")


$(document).ready(function() {

let specPermissions = document.querySelectorAll('.specific-permission')
specPermissions.forEach(specPermission=>{
    let role = specPermission.getAttribute("role")
    specPermission.onclick = function(){
       unsavedAlertContainer.classList.remove("hidden")
        if(!permissionsToToggle[role]){
            permissionsToToggle = {...permissionsToToggle, [role]:[]}
        }
        const isbatchchecked = specPermission.getAttribute("isbatchchecked")
        if(isbatchchecked){
                console.log("touched")
                toggle(permissionsToToggle[role],specPermission.value)
        }
        else if(!isbatchchecked){
            if(specPermission.hasAttribute("def_value")){
                console.log("touched !isbatchecked")
                addToToggle(permissionsToToggle[role],specPermission.value)
            }
        }
        console.log(specPermission.value,specPermission.checked)

    }
})

let batchPermissions = document.querySelectorAll('.batch-permission')
batchPermissions.forEach(batchPermission=>{
    batchPermission.onclick = function() {
       
        let role = batchPermission.getAttribute("role")
        if(!permissionsToToggle[role]){
            permissionsToToggle = {...permissionsToToggle, [role]:[]}
        }
       
       toggle(permissionsToToggle[role],batchPermission.value)
       unsavedAlertContainer.classList.remove("hidden")
       let specificPermissions = document.querySelectorAll('.'+batchPermission.name)
       for (var specificPermission of specificPermissions) {
            specificPermission.setAttribute("isbatchchecked",!specificPermission.getAttribute("isbatchchecked"))
            if(!batchPermission.checked){
                console.log('batch not checked')
                specificPermission.checked = false;
                specificPermission.disabled = true
                if(specificPermission.hasAttribute("def_value")){
                    if(!permissionsToToggle[role].includes(specificPermission.value)){
                        addToToggle(permissionsToToggle[role],specificPermission.value)
                    }
                }
                else{
                    if(permissionsToToggle[role].includes(specificPermission.value)){
                        removeFromToggle(permissionsToToggle[role],specificPermission.value)
                    }

                }
            }else{
                console.log('batch checked')

                specificPermission.disabled = !specificPermission.disabled
                specificPermission.checked = true
                if(specificPermission.hasAttribute("def_value")){
                    removeFromToggle(permissionsToToggle[role],specificPermission.value)
                }else{
                    addToToggle(permissionsToToggle[role],specificPermission.value)
                }
            }
        }
    }
})

let selectAllPermissions = document.querySelectorAll('.select-all-permission')

selectAllPermissions.forEach(selectAllPermission=>{
    selectAllPermission.onclick = function() {
        if(selectAllPermission.checked){
            permissionsToToggle = {}

        }
        let role = selectAllPermission.getAttribute("role")
        unsavedAlertContainer.classList.remove("hidden")
        if(!permissionsToToggle[role]){
            permissionsToToggle = {...permissionsToToggle, [role]:[]}
        }
        const permissions = document.querySelectorAll(`input[withKey="true"][role="${role}"]`);
        permissions.forEach(permission=>{ 
            permission.setAttribute('isbatchchecked',true)
            permission.disabled = false
            if(permission.hasAttribute("def_value")){
                if(!selectAllPermission.checked){
                    permission.removeAttribute("def_value")
                    toggle(permissionsToToggle[role],permission.value)
                }
            }
            else{
                toggle(permissionsToToggle[role],permission.value)
            }
        })
    }
})

});


function toggle(array, value) {
    var index = array.indexOf(value);
    if (index === -1) {
        array.push(value);
        console.log("toggle push",array)
    } else {
        array.splice(index, 1);
        console.log("toggle remove",array)

    }
    
}
function addToToggle(array,value){
    array.push(value);
    console.log("addToToggle push",array)

}
function removeFromToggle(array,value){
    var index = array.indexOf(value);
    array.splice(index, 1);
    console.log("removeFromToggle remove",array)


}
async function saveChanges(){
    console.log(permissionsToToggle)
   for (const key in permissionsToToggle) {
        if (permissionsToToggle.hasOwnProperty(key)) {

            if(permissionsToToggle[key].length>0){
                await $.ajax({
                    type:'PUT',
                    url: window.location.origin+"/data-guard/roles-permissions/"+key,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        permissionsToToggle:permissionsToToggle[key]
                    },
                    success:function(response){
                        console.log({response});
                    }
                });
            }
            
        }
    }
    unsavedAlertContainer.classList.add("hidden")
    permissionsToToggle = []
    location.reload()
}
    </script>
    @endsection
</x-app-layout>
