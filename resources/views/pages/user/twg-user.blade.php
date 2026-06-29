<x-app-layout>
    @section('style')
    <style>
        .table.power-grid-table thead tr th:nth-child(2) > div {
          width: 3rem;
        }
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
