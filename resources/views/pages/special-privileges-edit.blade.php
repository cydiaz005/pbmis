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
            'pageTitle' => 'Special Privileges',
            'breadcrumb' => [
                ['name' => 'Dashboard', 'route' => 'dashboard/admin'],
                ['name' => 'Data Guard', 'route' => '#'],
                ['name' => 'Special Privileges', 'route' => '#'],
            ]
            
        ])
        <div class="row">
        <div id="unsavedAlert" class="col-12 hidden">
        <div class="d-flex align-items-center justify-content-between  flex-row alert alert-warning" userid="alert">
            <p>
                Careful -- you have unsaved changes
            </p>
            <div class="d-flex flex-row align-items-center">
            <p onclick="location.reload()" class="btn mr-3">
               Reset
            </p>
                <button onclick="saveChanges(<?php echo $id; ?>)" type="button" class="btn bg-success btn-success">Save changes</button>
            </div>
        </div>
  
        </div>
        <div class="col-12">
        @livewire('user-permissions',['user_id'=>$id])
        </div>
        </div> 
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
        $("#li_userids").addClass('active');







let showAlertUnsavedChanges = false;
let permissionsToToggle = []
let unsavedAlertContainer = document.querySelector("#unsavedAlert")


$(document).ready(function() {

let specPermissions = document.querySelectorAll('.specific-permission')
specPermissions.forEach(specPermission=>{
    specPermission.onclick = function(){
       unsavedAlertContainer.classList.remove("hidden")
        const isbatchchecked = specPermission.getAttribute("isbatchchecked")
        if(isbatchchecked){
                console.log("touched")
                toggle(permissionsToToggle,specPermission.value)
        }
        else if(!isbatchchecked){
            if(specPermission.hasAttribute("def_value")){
                console.log("touched !isbatchecked")
                addToToggle(permissionsToToggle,specPermission.value)
            }
        }
        console.log(specPermission.value,specPermission.checked)

    }
})

let batchPermissions = document.querySelectorAll('.batch-permission')
batchPermissions.forEach(batchPermission=>{
    batchPermission.onclick = function() {
        let userid = batchPermission.getAttribute("userid")
       toggle(permissionsToToggle,batchPermission.value)
       unsavedAlertContainer.classList.remove("hidden")
       let specificPermissions = document.querySelectorAll('.'+batchPermission.name)
       for (var specificPermission of specificPermissions) {
            specificPermission.setAttribute("isbatchchecked",!specificPermission.getAttribute("isbatchchecked"))
            if(!batchPermission.checked){
                console.log('batch not checked')
                specificPermission.checked = false;
                specificPermission.disabled = true
                if(specificPermission.hasAttribute("def_value")){
                    if(!permissionsToToggle.includes(specificPermission.value)){
                        addToToggle(permissionsToToggle,specificPermission.value)
                    }
                }
                else{
                    if(permissionsToToggle.includes(specificPermission.value)){
                        removeFromToggle(permissionsToToggle,specificPermission.value)
                    }

                }
            }else{
                console.log('batch checked')
                specificPermission.disabled = !specificPermission.disabled
                specificPermission.checked = true
                if(specificPermission.hasAttribute("def_value")){
                    removeFromToggle(permissionsToToggle,specificPermission.value)
                }else{
                    addToToggle(permissionsToToggle,specificPermission.value)
                }
            }
        }
    }
})

let selectAllPermissions = document.querySelectorAll('.select-all-permission')

selectAllPermissions.forEach(selectAllPermission=>{
    selectAllPermission.onclick = function() {
        if(selectAllPermission.checked){
            permissionsToToggle = []
        }
        let userid = selectAllPermission.getAttribute("userid")
        unsavedAlertContainer.classList.remove("hidden")
        const permissions = document.querySelectorAll(`input[withKey="true"][userid="${userid}"]`);
        permissions.forEach(permission=>{ 
            permission.setAttribute('isbatchchecked',true)
            permission.disabled = false
            if(permission.hasAttribute("def_value")){
                if(!selectAllPermission.checked){
                    permission.removeAttribute("def_value")
                    toggle(permissionsToToggle,permission.value)
                }
            }
            else{
                toggle(permissionsToToggle,permission.value)
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
async function saveChanges(id){
   console.log(permissionsToToggle)
   if(permissionsToToggle.length>0){
       $(".spinner_modal").modal({
           backdrop: "static",
           keyboard: false,
           show: true
       })
        await $.ajax({
            type:'PUT',
            url: window.location.origin+"/data-guard/special-privileges/user/"+id,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                permissionsToToggle:permissionsToToggle
            },
            success:function(response){
                $(".spinner_modal").modal("hide");
                toastr.success("Successfully Updated")
                console.log({response});
            },
            error: function (res){
                $(".spinner_modal").modal("hide");
                toastr.error("Failed to Update")
            }
        });
    }
    unsavedAlertContainer.classList.add("hidden")
    permissionsToToggle = []
    location.reload()
}

$("#li_privileges").addClass('active');

    </script>
    @endsection
</x-app-layout>
