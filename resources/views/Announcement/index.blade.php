<x-app-layout>
    @section('style')
        <link rel="stylesheet" href="{{ asset('theme-alte3/plugins/summernote/summernote-bs4.min.css') }}" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('theme-alte3/plugins/fontawesome-free/css/all.min.css') }}">

        <style>
            .note-table {
                display: none;
            }

            .note-insert button:nth-child(2) {
                display: none;
            }

            .note-insert button:nth-child(3) {
                display: none;
            }
            .relative select,
            .pointer-events-none {
                display: none
            }
            /* .note-color{
              display: none;
            }
            .note-fontname{
              display: none;
            } */

        </style>
    @endsection

    @section('content')

        @livewire('partials.content-header', [
        'pageTitle' => 'Manage Posts',
        'breadcrumb' => [
        ['name' => 'Dashboard', 'route' => 'dashboard/admin'],
        ['name' => 'Bulletin', 'route' => '#'],
        ['name' => 'Manage Posts', 'route' => '#'],
        ]
        ])
          <!-- Main content -->
          <section class="content">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Boards</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create-announcement"><i
                            class="fas fa-plus"></i>&nbsp;
                        New Announcement</button>
                </div>
            </div>
            <div class="card-body p-1">
                @livewire("tables.announcement-table")
            </div>

        </div>
        <!-- create annoucement -->
        <div class="modal fade" id="create-announcement" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Announcement</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{-- <form action="/bulletin/manage" method="POST">
                        @csrf --}}
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Subject</label>
                                <input class="form-control " id="subject" name="subject"  required>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="date" class="form-control date-input" id="start_date" name="start_date" data-min-date="{{now()->format('Y-m-d')}}" data-max-date="{{now()->addYears(2)->format('Y-m-d')}}">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="date"  class="form-control " id="end_date" name="end_date"  data-min-date="{{now()->format('Y-m-d')}}" data-max-date="{{now()->addYears(2)->format('Y-m-d')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Content</label>
                                <textarea class="form-control summernote" id="compose-textarea" style="height: 400px" name="content"
                                    required></textarea>
                            </div>
                          
                            <div class="row w-100 mt-1">
                                <div class="col-lg-4">
                                    <div class="form-check form-check-inline  ">
                                        <input class="form-check-input " type="checkbox" id="all-check" name="all"
                                            value="all">
                                        <label class="form-check-label" for="inlineCheckbox2">All</label>
                                    </div>
                                </div>
                                @foreach (@$roles as $key => $value)
                                    <div class="col-lg-4">
                                        <div class="form-check form-check-inline  ">
                                            <input class="form-check-input roles" type="checkbox" id="{{ $value->id }}"
                                                name="{{ $value->name }}" value="{{ $value->id }}">
                                            <label class="form-check-label"
                                                for="inlineCheckbox2">{{ $value->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-primary" id="save-announcement">Save</button>
                        </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
        <!-- Update -->
        <div class="modal fade" id="updateAnnouncement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog  modal-lg" role="document">
                <div class="modal-content" id="update-announcement-modal">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Announcement</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Subject</label>
                            <input 
                                class="form-control "
                                id="subjectU" 
                                name="subject"  required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input  type="date"
                                            class="form-control " 
                                            id="start_dateU" 
                                            name="start_date" 
                                            data-min-date="{{now()->format('Y-m-d')}}" 
                                            data-max-date="{{now()->addYears(2)->format('Y-m-d')}}"
                                            >
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input type="date" 
                                            class="form-control " 
                                            id="end_dateU" 
                                            name="end_date"  
                                            data-min-date="{{now()->format('Y-m-d')}}" 
                                            data-max-date="{{now()->addYears(2)->format('Y-m-d')}}"
                                            >
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Update Announcement</label>
                            <textarea class="form-control summernote" id="update-textarea" name="content">

                            </textarea>
                        </div>
                        <div id="content-info">

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Delete -->
        <div class="modal fade" id="DeleteAnnouncement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" id="delete-announcement-modal">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Announcement</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <h3>Are you sure you want to delete?</h3>
                        <h5 class="mt-2">You wont revert this action</h5>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal" id="loader-modals" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered d-flex justify-content-center" role="document">
                <div class="text-center">
                    <div class="spinner-border" style="width: 5rem; height: 5rem;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection
    <script src="{{asset("js/notification.js")}}"></script>
    @section('script')
        <script defer src="{{ asset('theme-alte3/plugins/summernote/summernote-bs4.min.js') }}"></script>


        <script>
            const token = `{{ csrf_token() }}`;
            const header = 'X-CSRF-TOKEN';

            const dateFormat = (dateNow) => {
            // Use Javascript
                    var today = new Date(dateNow);
                        var dd = today.getDate();
                        var mm = today.getMonth()+1; //January is 0 so need to add 1 to make it 1!
                        var yyyy = today.getFullYear();
                        if(dd<10){
                         dd='0'+dd
                        } 
                        if(mm<10){
                        mm='0'+mm
                        } 

                        today = yyyy+'-'+mm+'-'+dd;
            return today;
            }
            // Use Javascript
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0 so need to add 1 to make it 1!
            var yyyy = today.getFullYear();
            if(dd<10){
            dd='0'+dd
            } 
            if(mm<10){
            mm='0'+mm
            } 

            today = yyyy+'-'+mm+'-'+dd;
            console.log(start_date)
            document.getElementById("start_date").setAttribute("min",today);
            document.getElementById("end_date").setAttribute("min",today);
            document.getElementById("start_dateU").setAttribute("min", today);
            document.getElementById("end_dateU").setAttribute("min", today);
            const roles = @json(@$roles);
            $(".button-edit , .fa-trash").on("click", (e) => {
                $('#loader-modals').modal({
                    backdrop: "static",
                    keyboard: false,
                    show: true
                })
            })
            $(function() {

                $('#compose-textarea').summernote({
                    height: 250
                })

            })

            $("#li_bulletin").addClass('menu-open');
            $("#li_bulletin>a.li_parent").addClass('active');
            $("#li_manageposts").addClass('active');
            const getRolesData = (rolesData) => {
                let checkBox = '';
                if(Array.isArray(roles)){
                    roles.forEach(role => {
                        checkBox += `                    
                        <div class="col-lg-4">
                            <div class="form-check form-check-inline  ">
                                <input class="form-check-input rolesU" type="checkbox" id="${role.id}"
                                 name="${role.name}" value="${role.id}" ${rolesData.filter(data => data.role_id == role.id).length > 0 ? 'checked' : ''}>
                            <label class="form-check-label"
                                for="inlineCheckbox2">${role.name}</label>
                            </div>
                        </div>
                        `
                    })
                }
                return checkBox
            }
            window.addEventListener('activeEventEdit', event => {
                $('#loader-modals').modal("hide")
                $("#modal-footer-update").remove();
                if (event.detail.announcement) {
                    const endDate = event.detail.announcement.end_date
                    $('#subjectU:text').val(event.detail.announcement.subject)
                    $('#start_dateU').val(  dateFormat(event.detail.announcement.start_date))
                    $('#end_dateU').val(endDate ?  dateFormat(endDate) : "")
                    console.log("endDate",endDate)
                    $('#update-textarea').val('')
                    $('#update-textarea').summernote('reset');
                    $('#update-textarea').summernote('code', event.detail.announcement.content);
                    console.log(event.detail.announcement)
                    $('#updateAnnouncement').modal({
                        backdrop: "static",
                        keyboard: true,
                        show: true
                    })
                    let div = document.createElement("div");
                    div.className = "modal-footer";
                    div.setAttribute('id', "modal-footer-update");
                    div.innerHTML =
                                    `
                                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-outline-info" id="update-announcement-info">Update</button> 
                                    `;
                    document.querySelector("#update-announcement-modal").appendChild(div);
                    $("#content-info").empty();
                    const contentInfo = document.getElementById("content-info");

                    contentInfo.innerHTML = `
                      <div class="d-flex justify-content-start align-items-center">
                        <div class="spinner-border spinner-border-sm" role="status">
                          <span class="sr-only">Loading...</span>
                        </div>
                        <span class="ml-1">Loading...</span>
                      </div>
                    `
                      let divNew = document.createElement("div");
                      divNew.className = "w-100";
                    $.ajax({
                            url: `/bulletin/roles/${event.detail.announcement.id}`,
                          
                            type: "GET",
                            beforeSend: function(xhr) {
                                xhr.setRequestHeader('X-CSRF-TOKEN', token)
                                xhr.setRequestHeader('X-Requested-With', "XMLHttpRequest");
                            },
                            success: function(result) {
                                console.log(result)
                                divNew.innerHTML = `
                                 <div class="row w-100 mt-1">
                                    <div class="col-lg-4">
                                        <div class="form-check form-check-inline  ">
                                            <input class="form-check-input " type="checkbox" id="all-checkU" name="all"
                                                value="all">
                                            <label class="form-check-label" for="inlineCheckbox2">All</label>
                                        </div>
                                    </div>
                                    ${getRolesData(result)}
                                </div>
                                 `
                                 $("#content-info").empty();
                                            contentInfo.appendChild(divNew);
                                            divNew.querySelector("#all-checkU").onclick = (e) => {
                                        if(e.target.checked){
                                         //   $(".rolesU").prop('disabled', true);
                                            $(".rolesU").prop('checked', true);
                                        }else{
                                           // $(".rolesU").prop('disabled', false);
                                            $(".rolesU").prop('checked', false);
                                        
                                        }
                                    } 
                                    div.querySelector("#update-announcement-info").onclick = () => {

                                        const updatedTextArea = 
                                        document.getElementById("update-textarea").value;
                                        const subject = $("#subjectU").val();
                                        const end_date = $("#end_dateU").val();
                                        const start_date = $("#start_dateU").val();

                                        if(!subject){
                                            console.log("update");
                                            toastr.error("Subject Required")
                                            return
                                        }
                                        if(!start_date){
                                            toastr.error("Start Date Required")
                                            return
                                        }
                                        if(!end_date){
                                            toastr.error("End Date Required")
                                            return
                                        }
                                        if(!updatedTextArea){
                                            toastr.error("Content Required")
                                            return
                                        }
                                        if (updatedTextArea === "<p><br></p>") {
                                        toastr.error("Content Required")
                                        return;
                                        }
                                        const  rolesX = $('.rolesU:checkbox:checked').map(function() {
                                            return this.value;
                                        }).get();
                                        
                                        console.log(rolesX);
                                        if(rolesX.length < 1){
                                            toastr.error("Announcement Filter Required ")
                                             return;  
                                        }
                                        $('#loader-modals').modal({
                                            backdrop: "static",
                                            keyboard: false,
                                            show: true
                                        });
                                        $('#updateAnnouncement').modal("hide");
                                        $.ajax({
                                            url: "/bulletin/announcement.edit",
                                            data: {
                                                id: event.detail.announcement.id,
                                                content: updatedTextArea,
                                                roles: rolesX,
                                                subject,
                                                end_date,
                                                start_date

                                            },
                                            type: "POST",
                                            beforeSend: function(xhr) {
                                                xhr.setRequestHeader('X-CSRF-TOKEN', token)
                                                xhr.setRequestHeader('X-Requested-With', "XMLHttpRequest");
                                            },
                                            success: function(result) {
                                                $('#loader-modals').modal("hide")
                                                window.location.reload()
                                            },
                                            error: function(res){
                                                $('#loader-modals').modal("Failed to Updated")
                                            }
                                        });
                                    }
                            }
                        });
                          
                   
                } else {
                    toastr.error("Sorry to View Announcement")
                }
            })
            window.addEventListener('activeEvenDelete', event => {
                $('#loader-modals').modal("hide")
                $("#modal-footer-delete").remove();
                if (event.detail.announcement) {
                    let div = document.createElement("div");
                    div.className = "modal-footer";
                    div.setAttribute('id', "modal-footer-delete");
                    div.innerHTML =
                        `
                          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                          <button type="button" class="btn btn-outline-danger" id="delete-announcement-info">Delete</button> 
                        `;
                    document.querySelector("#delete-announcement-modal").appendChild(div);
                    div.querySelector("#delete-announcement-info").onclick = () => {
                        $('#loader-modals').modal({
                    backdrop: "static",
                    keyboard: false,
                    show: true
                })
                $('#DeleteAnnouncement').modal("hide")
                        $.ajax({
                            url: "/bulletin/announcement.destroy",
                            data: {
                                id: event.detail.announcement.id
                            },
                            type: "POST",
                            beforeSend: function(xhr) {
                                xhr.setRequestHeader('X-CSRF-TOKEN', token)
                                xhr.setRequestHeader('X-Requested-With', "XMLHttpRequest");
                            },
                            success: function(result) {
                                $('#loader-modals').modal("hide")
                                window.location.href = "/bulletin/manage";
                            }
                        });
                    }
                    $('#DeleteAnnouncement').modal({
                        backdrop: "static",
                        keyboard: true,
                        show: true
                    })
                } else {
                    new swal("Warning", "Sorry failed to delete", "Warning")
                }

            })
            $("#all-check").on("change", (e) => {
                console.log(e.target.checked);
                if(e.target.checked){
                   // $(".roles").prop('disabled', true);
                    $(".roles").prop('checked', true);
                }else{
                  //  $(".roles").prop('disabled', false);
                    $(".roles").prop('checked', false);
                   
                }
            } )
            $("#save-announcement").on("click", (e) => {
                  const  rolesX = $('.roles:checkbox:checked').map(function() {
                        return this.value;
                    }).get();
                    const content = $("#create-announcement #compose-textarea").val();
                    const subject = $("#create-announcement #subject").val();
                    const end_date = $("#create-announcement #end_date").val();
                    const start_date = $("#create-announcement #start_date").val();
                    if(!subject){
                        console.log("create");
                        toastr.error("Subject Required")
                        return
                    }
                    if(!start_date){
                        toastr.error("Start Date Required")
                        return
                    }
                    if(!end_date){
                        toastr.error("End Date Required")
                        return
                    }
                    if(!content){
                        toastr.error("Content Required")
                        return
                    }
                    if (content === "<p><br></p>") {
                        toastr.error("Content Required")
                        return;
                     }
                     if(rolesX.length < 1){
                                            toastr.error("Announcement Filter Required ")
                                             return;  
                                        }
                     $('#loader-modals').modal({
                            backdrop: "static",
                            keyboard: false,
                            show: true
                        });
                        
                    $.ajax({
                            url: "/bulletin/manage",
                            data: {
                                roles : rolesX,
                                content,
                                subject,
                                end_date,
                                start_date
                            },
                            type: "POST",
                            beforeSend: function(xhr) {
                                xhr.setRequestHeader('X-CSRF-TOKEN', token)
                                xhr.setRequestHeader('X-Requested-With', "XMLHttpRequest");
                            },
                            success: function(result) {
                                $('#loader-modals').modal("hide");
                                console.log(result);
                              window.location.href = "/bulletin/manage";
                            }
                        });
                   
            })

            // let date_inputs = document.querySelectorAll('.date-input');

            // for (let i = 0; i < date_inputs.length; i++) {
            //     const element = date_inputs[i];
            //     element.onfocusout=function(){
            //         let min_date = "{{now()->addYears(2)->format('Y-m-d')}}";
            //         let max_date = "{{now()->addYears(2)->format('Y-m-d')}}";
            //         if(this.value < min_date){
            //             toastr.error('Date must be current day onwards');
            //             this.value="";
            //         }
            //         console.log('onfocusout');
            //     }
            // }
        </script>
    @endsection
</x-app-layout>
