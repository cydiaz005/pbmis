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
          ['name' => 'Administrator', 'route' => '#'],
      ],
      'pageTitle' => 'Manage Administrator',
      
  ])
  <!-- -->
    <!-- Main content -->
    <section class="content">
  <div class="card">
    <div class="card-body">
      @livewire('unverified-user-table')
    </div>
  </div>

</section>



  @endsection
  
  @section('script')
  <script>
      $("#li_users").addClass('menu-open');
      $("#li_users>a.li_parent").addClass('active');
      $("#li_unveried").addClass('active');
  </script>
  @endsection
</x-app-layout>
