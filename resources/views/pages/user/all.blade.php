<x-app-layout>
    @section('style')
    <style>
      /* .main-footer {
          margin-left: 0 !important;
      } */
      .table.power-grid-table tbody tr:nth-child(1) td:nth-child(3) > div {
        width: 6rem;
      }
      .table.power-grid-table tbody tr:nth-child(1) td:nth-child(4) > div {
        width: 6rem;
      }
      .table.power-grid-table tbody tr:nth-child(1) td:nth-child(5) > div {
        width: 14rem;
      }
      .table.power-grid-table tbody tr:nth-child(1) td:nth-child(6) > div {
        width: 11rem;
      }
      .table.power-grid-table tbody tr:nth-child(1) td:nth-child(7) > div {
        width: 11rem;
      }
      .table.power-grid-table tbody tr:nth-child(1) td:nth-child(8) > div {
        width: 7rem;
      }
      .table.power-grid-table thead tr th:nth-child(9) > div {
        width: 6rem;
      }
      .table.power-grid-table tbody tr:nth-child(1) td:nth-child(10) > div {
        width: 10rem;
      }
      .table.power-grid-table tbody tr:nth-child(1) td:nth-child(11) > div {
        width: 10rem;
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
        ],
    ])

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">All Users</h3>
            <div class="card-tools">
                <a href="#createUserModal" data-toggle="modal" type="button" class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp;
                Create User</a>
            </div>
        </div>
      <div class="card-body">
        @livewire('user-table')
      </div>
    </div>

     <!-- create user -->
     <div class="modal fade" id="createUserModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <form action="/user/create" method="POST"  >
          @csrf
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Create User</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                @livewire('create-user-complete-info')

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Create</button>
              </div>
          </div>
          </form>
      </div>
    </div>
    @endsection
    @section('script')
    <script>
      async function onChangeRole (userId,roleId){
        $(".spinner_modal").modal({
          show: true,
          keyboard: false,
          backdrop: "static"
        })
        await $.ajax({
            type:'PUT',
            url: window.location.origin+"/user/"+userId+"/change-role",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                roleId
            },
            success:function(response){
                console.log({response});
                $(".spinner_modal").modal("hide")
            }
        });
        location.reload();
      }

      async function onChangeStatus (userId,status){
        $(".spinner_modal").modal({
          show: true,
          keyboard: false,
          backdrop: "static"
        })
        await $.ajax({
            type:'PUT',
            url: window.location.origin+"/user/"+userId+"/change-status",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
              status
            },
            success:function(response){
                console.log({response});
                $(".spinner_modal").modal("hide")
            }
        });
        location.reload();
      }
      async function onChangeService (userId,serreg_id){
        $(".spinner_modal").modal({
          show: true,
          keyboard: false,
          backdrop: "static"
        })
        await $.ajax({
            type:'PUT',
            url: window.location.origin+"/user/"+userId+"/change-service",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                serreg_id
            },
            success:function(response){
                console.log({response});
                $(".spinner_modal").modal("hide")
            }
        });
        location.reload();
      }
        $("#li_users").addClass('menu-open');
        $("#li_users>a.li_parent").addClass('active');
        $("#li_approval").addClass('active');

    </script>
    @endsection
</x-app-layout>
