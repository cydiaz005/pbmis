<x-app-layout>
    @section('style')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <style>
        canvas{
            margin-top: 10px !important;
            margin-bottom: 20px !important;

        }

        .analytics-tbl{
            margin-top: 20px !important;
        }
    </style>
    @endsection
    
    @section('content')

    @livewire('partials.content-header', [
        'pageTitle' => 'Plans Dashboard',
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => 'dashboard/plans'],
            ['name' => 'Plans', 'route' => '#'],
        ]
    ])
    <form action="{{ url()->current() }}" method="get" id="fy-dform">
        <div class="row align-items-center px-3 pb-3">
            <label class="m-0 text-muted small mr-2">Fiscal Year</label>
            <select onchange="document.getElementById('fy-dform').submit()" name="year" class="form-control form-control-sm form-input mt-0" style="max-width: 7rem">
                @for($i = 2022; $i <= \Carbon\Carbon::now()->format('Y') + 6; $i++)
                    @php
                        $selected_year = request('year') ?: date('Y') + 1;
                    @endphp
                        <option {{$i == $selected_year ? "selected":""}} value="{{$i}}">F.Y. {{$i}}</option>
                @endfor
            </select>
        </div>
    </form>

    <div class="container">
        @livewire('analytics.plans.summative-widget')

        <!-- <div class="row">
            <div class="col-6">
            </div>
            <div class="col-6">
                <div class="card">
                    <img class="card-img-top" src="holder.js/100x180/" alt="">
                    <div class="card-body">
                        <h4 class="card-title">Title</h4>
                        <p class="card-text">Text</p>
                    </div>
                </div>
            </div>
        </div> -->
    </div>

    @endsection

   
    @section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @yield('analytics-script')

    <script>
      $("#li_plansdashboard").addClass('active');
    </script>
    @endsection
</x-app-layout>
