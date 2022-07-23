<x-app-layout>
    @section('style')
    <style>
        .main-footer {
            margin-left: 0 !important;
        }

        .hover {
            cursor: pointer;
        }

        input,
        textarea {
            background-color: #ffffff !important;
        }
    </style>
    @endsection

    @section('content')

    @livewire('partials.content-header', [
    'pageTitle' => 'Resource Info Videos',
    'breadcrumb' => [
    ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
    ['name' => 'Videos', 'route' => '#'],

    ],
    ])

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">All Resource Videos Link</h3>
            <?php 
          $user = Auth::user();
          $isTrue = false;

          foreach ( @$user->roles as  $value) {
              if($value->id == 1){
                  $isTrue = true;
              }
          }
          if($isTrue) { ?>
            <div class="card-tools">
                <a href="#createResouceUserModal" data-toggle="modal" type="button" class="btn btn-primary"><i
                        class="fas fa-plus"></i>&nbsp;
                    Create Resource Vidoes</a>
            </div>
            <?php  
          }
       ?>

        </div>
        <div class="card-body">
            @livewire('vid-resource-table')
        </div>
    </div>



    <!-- create user -->
    <div class="modal fade" id="createResouceUserModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">


            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Resource Info Video</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input placeholder="title" type="text" class="form-control" id="title" />
                    </div>
                    <div class="form-group">
                        <label>Link</label>
                        <input placeholder="link" type="text" class="form-control" id="link" />
                    </div>

                    <div class="form-group mt-2">
                        <label>Description</label>
                        <textarea rows="5" placeholder="desciption" class="form-control" id="description"></textarea>
                    </div>
                    <div class="form-group mt-2">
                        <label>Resource Account</label>
                        <input placeholder="search username" class="form-control" id="username">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" id="create-user">Create</button>
                </div>
            </div>

        </div>
    </div>
    <!-- update user -->
    <div class="modal fade" id="UpdateResouceUserModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">


            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Resource Info Video</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input placeholder="title" type="text" class="form-control" id="titleU" />
                    </div>
                    <div class="form-group">
                        <label>Link</label>
                        <input placeholder="link" type="text" class="form-control" id="linkU" />
                    </div>

                    <div class="form-group mt-2">
                        <label>Description</label>
                        <textarea rows="10" placeholder="desciption" class="form-control" id="descriptionU"></textarea>
                    </div>
                    <div class="form-group mt-2" id="usernameList">
                        <label>Resource Account</label>
                        <input placeholder="search username" class="form-control" id="usernameU">
                    </div>
                    <div class="w-100 mt-2 p-1" >
                           
                            <div class="w-100" id="details">
                               
                            </div>
                    </div>

                </div>
                <div class="modal-footer" id="edit-modal">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" id="update-user">Update</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Delete Resource</h5>
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
    @endsection

    @section('script')
    <script>
        let user_id = null;
      let resourceId = null;
      let resource_accountId = null;
      const pap = new Searchable('#username', {
          url: window.location.origin+'/resource/resource-account/search',

          props: {
              id: 'id',
              text: 'username',
          },
          onClick: 'appendChip',
          
      });
      const update = new Searchable('#usernameU', {
          url: window.location.origin+'/resource/resource-account/search',
          disableNoDataFound: true,
          searchingPropmt: false,
          props: {
              id: 'id',
              text: 'username',
          },
          onClick: 'appendChip',
      });
      const token = `{{ csrf_token() }}`;
      const header = 'X-CSRF-TOKEN';
   
 
    function userClip(data) {
        navigator.clipboard.writeText(data);
      toastr.success("copied text")
    }
    function passwordClip(data) {
        navigator.clipboard.writeText(data);
        toastr.success("copied text")
    }
  
    $(".button-edit , .fa-trash").on("click", (e) => {
                $('.spinner_modal').modal({
                    backdrop: "static",
                    keyboard: false,
                    show: true
                })
            })
  
    $("#create-user").on("click", () => {
        
        const title = $("#title").val();
       const link = $("#link").val();
       const description = $("#description").val();
        if(!title){
            toastr.error("Title Required")
            return;
        }
        if(!link){
                toastr.error("Title Required")
                return; 
            }
        console.log(pap.getIds())
       if(pap.getIds().length < 1){
          toastr.error("Resource Account required")
            return;
       }
        console.log(user_id)
        $(".spinner_modal").modal({
            show: true,
            keyboard: false,
            backdrop: "static"
        })
        $("#createResouceUserModal").modal("hide");
            $.ajax({
                url: "/resource/resource-doc",
                data: {
                    resource_id: user_id,
                    status: "vid",
                    title,
                    link,
                    description,
                    resource_account : pap.getIds()
                },
                type: "PUT",
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', token)
                    xhr.setRequestHeader('X-Requested-With', "XMLHttpRequest");
                },
                success: function(result) {
                    $(".spinner_modal").modal("hide");
                    location.reload()
                    
                },
                error: function(result){
                    $(".spinner_modal").modal("hide");
                    console.log(result)
                    toastr.error("error")
                }
            });         
        })
    window.addEventListener('ActionEventEdit', event => {
            const {resource} = event.detail;
            $(".spinner_modal").modal("hide")
            if(resource){
                $(".spinner_modal").modal("hide")
                resourceId = resource.id;
                console.log(resource)
                update.removeData();
                resource.resource_holder.forEach(data => {        
                        update.addData(data)
                      
                })
                console.log(update.activeIds())
                resource_accountId =resource.resource_account.id;
                $("#titleU").prop('disabled', false);
                $("#descriptionU").prop('disabled', false);
                $("#linkU").prop('disabled', false);
                $("#usernameU").prop('disabled', false);
                $("#usernameList").addClass("d-block");
                $("#usernameList").removeClass("d-none"); 
                $("#details").removeClass("d-block");
                $("#details").addClass("d-none");
                $("#edit-modal").removeClass("d-none");
                $("#edit-modal").addClass("d-flex justify-content-end align-items-end");

                $("#titleU").val(resource.title);
                $("#linkU").val(resource.link);
                $("#descriptionU").val(resource.description);
                // $("#usernameU").val(resource.resource_account.username);
                $("#UpdateResouceUserModal").modal({
                    backdrop: "static",
                    keyboard: true,
                        show: true
                })
            }
            $("#update-user").on("click", () => {
                const title = $("#titleU").val();
                const link = $("#linkU").val();
                const description = $("#descriptionU").val();

                    if(!title){
                        toastr.error("Title Required")
                        return;
                    }
                    if(!link){
                        toastr.error("Title Required")
                        return; 
                    }
                    console.log("get",update.getIds())
                    console.log("activeIds",update.activeIds())
                    if(update.activeIds().length < 1){
                        toastr.error("Resource Account required")
                            return;
                    }
                
                    $(".spinner_modal").modal({
                        backdrop: "static",
                        keyboard: true,
                        show: true
                    })
                   
                    $("#UpdateResouceUserModal").modal("hide");
                    $.ajax({
                        url: "/resource/resource-doc",
                        data: {
                            id: resourceId,
                            resource_ids: update.activeIds(),
                            status: "vid",
                            title,
                            link,
                            oldLink: resource.link,
                            description
                        },
                        type: "POST",
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('X-CSRF-TOKEN', token)
                            xhr.setRequestHeader('X-Requested-With', "XMLHttpRequest");
                        },
                        success: function(result) {
                            $(".spinner_modal").modal("hide");
                             location.reload()
                            
                        },
                        error: function(result){
                            $(".spinner_modal").modal("hide");
                            console.log(result)
                            toastr.error("error")
                        }
                    });     
            })
    })
    window.addEventListener('ActionEventDelete', event => {
        $(".spinner_modal").modal("hide")
        const {resource} = event.detail;
        if(resource){
            $(".spinner_modal").modal("hide");
          
          $("#modal-footer-delete").remove();
          $('#DeleteAnnouncement').modal({
                  backdrop: "static",
                  keyboard: true,
                  show: true
              })
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
                $(".spinner_modal").modal({
                  show: true,
                  keyboard: false,
                  backdrop: "static"
              })
              $('#DeleteAnnouncement').modal("hide");
                $.ajax({
                    url: "/resource/resource-doc",
                    data: {id: resource.id},
                      type: "DELETE",
                      beforeSend: function(xhr) {
                          xhr.setRequestHeader('X-CSRF-TOKEN', token)
                          xhr.setRequestHeader('X-Requested-With', "XMLHttpRequest");
                      },
                      success: function(result) {
                          $(".spinner_modal").modal("hide");
                          location.reload()
                          
                      },
                      error: function(result){
                          $(".spinner_modal").modal("hide");
                          console.log(result)
                          toastr.error("error")
                      }
                  })
              }
        }
    })
    window.addEventListener('ActionView', event => {
        $(".spinner_modal").modal("hide");
        const {resource} = event.detail;
       if(resource){
            resourceId = resource.id;
                resource_accountId =resource.resource_account.id;
                update.removeData();
                $("#details").addClass("d-block");
                $("#details").removeClass("d-none");
                $("#titleU").prop('disabled', true);
                $("#descriptionU").prop('disabled', true);
                $("#linkU").prop('disabled', true);
                $("#usernameU").prop('disabled', true);
                $("#edit-modal").removeClass("d-flex");
                $("#edit-modal").addClass("d-none");

                $("#titleU").val(resource.title);
                $("#linkU").val(resource.link);
                $("#descriptionU").val(resource.description);
                $("#usernameList").removeClass("d-block");
                $("#usernameList").addClass("d-none");
                    $("#details").empty();
                let detailsContainer = document.getElementById("details");
                let rowCon = document.createElement("div")
                rowCon.className = "row w-100";
                let label =document.createElement("label")
                label.innerHTML ='Resource Account';
                detailsContainer.appendChild(label);
                resource.resource_holder.forEach(data => {
                        let colRow = document.createElement('div');
                        colRow.className = "col-md-6";
                        colRow.innerHTML = `
                        <div class="d-flex flex-column w-100 border-top p-1">
                            <div class="d-flex w-100 justify-content-start align-items-center " >
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span class="ml-1">${data.username}</span>
                                <span class="ml-1 user-clip" onclick="userClip(\'${data.username}\')"  style="color: #03c2fc; cursor: pointer" id="'.$value->username.'" >copy</span>
                            </div>
                            <div class="mt-1 d-flex w-100 justify-content-start align-items-center">
                                <i class="fa fa-key" aria-hidden="true"></i>
                                <span class="ml-1">${data.password.substring(0, 8).replace(/\*/g, '%')}</span>
                                <span class="ml-1 password-clip" onclick="passwordClip(\'${data.password}\')" style="color: #03c2fc; cursor: pointer" id="'.$value->password.'" >copy</span>
                            </div>
                        </div>
                        `;
                        rowCon.appendChild(colRow)
                })
                detailsContainer.appendChild(rowCon);
                $("#UpdateResouceUserModal").modal({
                    backdrop: "static",
                    keyboard: true,
                        show: true
                })
       }
    })
        $("#li_resource").addClass('menu-open');
        $("#li_resource>a.li_parent").addClass('active');
        $("#li_resource_vid").addClass('active');
       
    </script>
    @endsection
</x-app-layout>