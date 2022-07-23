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
            ['name' => 'Super Administrator', 'route' => '#'],
        ],
        'pageTitle' => 'Manage Super Administrator',
        
    ])

    <div class="card">
      <div class="card-body">
        <blockquote class="blockquote">
          <p>Manage Super Administrator</p>
          <footer class="card-blockquote"><cite title="Source title">Under Construction</cite></footer>
        </blockquote>
      </div>
    </div>

    @endsection
    
    @section('script')
    <script>
        $("#li_users").addClass('menu-open');
        $("#li_users>a.li_parent").addClass('active');
        $("#li_superadmin").addClass('active');
    </script>
    @endsection
</x-app-layout>
