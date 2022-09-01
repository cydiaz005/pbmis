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
        'pageTitle' => 'Budget Dashboard',
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => 'dashboard/admin'],
            ['name' => 'Budget', 'route' => '#'],
        ]
    ])
   
    @livewire('analytics.analytics-fiscal-limit')
    @endsection
    
    @section('script')

    @yield('analytics-fiscal-limit')
    <script>
      $("#li_budgetdashboard").addClass('active');
    </script>
    @endsection
</x-app-layout>
