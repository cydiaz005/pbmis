<x-app-layout>
    @section('style')
    <script>
    </script>
    @endsection

    @section('content')

    @livewire('partials.content-header', [
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
            ['name' => 'Users', 'route' => '#'],
            ['name' => 'Planning Focal', 'route' => '#'],
        ],
        'pageTitle' => 'Manage Planning Focal/Officer',
        
    ])
    <!-- -->

    <div class="card">
      <div class="card-body">
        @livewire('planning-focal-users-table')
      </div>
    </div>

    @endsection
    
    @section('script')
    <script>

async function onChangeRole (userId,roleId,roleName){
          let buttonRole = document.getElementById('buttonRole'+userId);
          buttonRole.innerHTML = roleName
          buttonRole.setAttribute("roleId",roleId)
          // location.reload();
        }
        async function onChangeStatus (userId,status){
          let roleId = document.getElementById('buttonRole'+userId).getAttribute('roleId');
          try {
            await $.ajax({
              type:'PUT',
              url: window.location.origin+"/user/"+userId+"/change-role",
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              data: {
                  roleId
              },
              success:function(response){
                  console.log({response});
              }
          });
          await $.ajax({
              type:'PUT',
              url: window.location.origin+"/user/"+userId+"/change-status",
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              data: {
                status
              },
              success:function(response){
                  console.log({response});
              }
          });
          location.reload();
            
          } catch (error) {

            console.error(error.message);
            
          }
        }


        $("#li_users").addClass('menu-open');
        $("#li_users>a.li_parent").addClass('active');
        $("#li_planningfocal").addClass('active');
    </script>
    @endsection
</x-app-layout>
