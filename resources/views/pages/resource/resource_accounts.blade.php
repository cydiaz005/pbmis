<x-app-layout>
    @section('style')
    <style>
      /* .main-footer {
          margin-left: 0 !important;
      } */
    </style>
    @endsection

    @section('content')

    @livewire('partials.content-header', [
      'pageTitle' => 'Resource User Accounts',
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
            ['name' => 'Accounts', 'route' => '#'],

        ],
    ])

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">All Resource Users</h3>
           
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
              <a href="#createResouceUserModal" data-toggle="modal" type="button" class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp;
              Create Resource User</a>
          </div>
              <?php  
            }
         ?>
        </div>
      <div class="card-body">
        @livewire('resource-user-table')
      </div>
    </div>



     <!-- create user -->
     <div class="modal fade" id="createResouceUserModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          
        
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Create Resource User</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                    <label>Username</label>
                    <input placeholder="username" type="text" class="form-control" id="username" />
                </div>

                <div class="form-group mt-2">
                    <label>Password</label>
                    <input placeholder="username" type="password" class="form-control" id="password" />
                </div>
                <div class="form-group mt-2">
                    <label>Role to View</label>
                    <select default="" class="form-control " id="role">
                        <option>Select Role</option>
                        @foreach(@$roles as $key => $value)
                        <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button  class="btn btn-primary" id="create-user">Create</button>
              </div>
          </div>
      
      </div>
    </div>
   <!-- update user -->
   <div class="modal fade" id="updateResouceUserModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        
      
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Resource User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                  <label>Username</label>
                  <input placeholder="username" type="text" class="form-control" id="usernameU" />
              </div>

              <div class="form-group mt-2">
                  <label>Password</label>
                  <input placeholder="username" type="password" class="form-control" id="passwordU" />
              </div>
              <div class="form-group mt-2">
                  <label>Role to View</label>
                  <select default="" class="form-control " id="roleU">
                      <option>Select Role</option>
                      @foreach(@$roles as $key => $value)
                      <option value="{{$value->id}}">{{$value->name}}</option>
                      @endforeach
                  </select>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button  class="btn btn-primary" id="update-user">Save</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Delete Resource Account</h5>
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
        const token = `{{ csrf_token() }}`;
        const header = 'X-CSRF-TOKEN';
        let resourceAccountId = null;
        function userClip(data) {
        navigator.clipboard.writeText(data);
      toastr.success("copied text")
    }
    function passwordClip(data) {
        // navigator.clipboard.writeText(data);
        copyToClipboard(data) ;
        toastr.success("copied text")
    }
    function copyToClipboard(text) {
        var input = document.body.appendChild(document.createElement("input"));
        input.value = text;
        input.focus();
        input.select();
        document.execCommand('copy');
        input.parentNode.removeChild(input);
    }
    // $(".button-edit").on("click", (e) => {
    //     $(".spinner_modal").modal({
    //             show: true,
    //             keyboard: false,
    //             backdrop: "static"
    //     })
    // })
    
      $("#create-user").on("click", () => {
          
            const username = $("#username").val();
            const password = $("#password").val();
              const role = $("#role").val();
            if(!username){
                toastr.error("Username Required")
                return;
            }
            if(!password){
              toastr.error("Password Required")
              return;
            }
            if(!role){
              toastr.error("Role Required")
              return;
            }
            if(password.length < 8){
              toastr.error("Password must be 8 or greater characters")
              return;
            }

            $(".spinner_modal").modal({
                show: true,
                keyboard: false,
                backdrop: "static"
            })
            $("#createResouceUserModal").modal("hide");
            $.ajax({
                  url: "/resource/resource-account",
                  data: {
                  username,
                  password,
                  role
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
      $(".button-edit , .fa-trash").on("click", (e) => {
                $('.spinner_modal').modal({
                    backdrop: "static",
                    keyboard: false,
                    show: true
                })
        })
      $("#li_resource").addClass('menu-open');
        $("#li_resource>a.li_parent").addClass('active');
        $("#li_resource_accounts").addClass('active');
        window.addEventListener('ActionEventEdit', event => {
          
         const {resouceAccount} = event.detail;
         if(resouceAccount){
            resourceAccountId = resouceAccount.id;
            $(".spinner_modal").modal("hide");
            $("#updateResouceUserModal").modal({
              show: true,
              keyboard: false,
              backdrop: "static"
          })
          console.log(resouceAccount)
          $("#usernameU").val(resouceAccount.username);
          $("#passwordU").val(resouceAccount.password);
            var mySelect = document.getElementById('roleU');
              for(var i, j = 0; i = mySelect.options[j]; j++) {
                  if(i.value == resouceAccount.role_id) {
                      mySelect.selectedIndex = j;
                      break;
                  }
              }
       
         }
         
        })
        $("#update-user").on("click", ()=> {
          if(resourceAccountId){
            $(".spinner_modal").modal({
              show: true,
              keyboard: false,
              backdrop: "static"
          })
          $("#updateResouceUserModal").modal('hide');
              $.ajax({
                  url: "/resource/resource-account",
                  data: {
                    id: resourceAccountId,
                    username: $("#usernameU").val(),
                    password: $("#passwordU").val(),
                    role: $("#roleU").val(),
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
                  })
                  return;
                }
            toastr.error("Failed to Update")
        })
        window.addEventListener('ActionEventDelete', event => {
          $(".spinner_modal").modal({
              show: true,
              keyboard: false,
              backdrop: "static"
          })
         const {resouceAccount} = event.detail;
         if(resouceAccount){

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
                          url: "/resource/resource-account",
                            data: {id: resouceAccount.id},
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
    </script>
    @endsection
</x-app-layout>
