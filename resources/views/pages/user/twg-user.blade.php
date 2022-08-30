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
            ['name' => 'Technical Working Group', 'route' => '#'],
        ],
        'pageTitle' => 'Manage Technical Working Group',
        
    ])
    <!-- -->
  <!-- Main content -->
  <section class="content">
    <div class="card">
      <div class="card-body">
        @livewire('t-w-g-users-table')

      </div>
    </div>
  </section>
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
        $("#li_twg").addClass('active');
    </script>
    @endsection
</x-app-layout>
