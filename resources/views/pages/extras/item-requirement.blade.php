<x-app-layout>
    @section('style')
    <script>
    </script>
    @endsection

    @section('content')

    @livewire('partials.content-header', [
       'pageTitle' => 'Default Item Requirement',
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
            ['name' => 'Field Dependency', 'route' => '#'],
            ['name' => 'Data Entry', 'route' => '#'],
            ['name' => 'Default Item Requirement', 'route' => '#'],
        ]
    ])




    @endsection
    
    @section('script')
    <script>
        $("#li_field").addClass('menu-open');
        $("#li_field>a.li_parent").addClass('active');
        $("#li_defaultitem").addClass('active');
    </script>
    @endsection
</x-app-layout>
