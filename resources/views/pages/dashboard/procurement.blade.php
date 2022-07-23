<x-app-layout>
    @section('style')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .active-service-region{
            color: #fff;
            background-color: #007BFF !important;
        }
    </style>
    @endsection

    @section('content')

    @livewire('partials.content-header', [
        'pageTitle' => 'Procurement Dashboard',
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => 'dashboard/procurement'],
            ['name' => 'Procurement', 'route' => '#'],
        ]
    ])
   
    @endsection
    @section('script')
    <script>
      $("#li_procurementdashboard").addClass('active');
    </script>
    @endsection
</x-app-layout>
