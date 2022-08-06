<x-app-layout>
  @section('style')
  <style>
    @media (min-width: 1281px) {
      div.small-box {
        height: 7.05rem;
      }
      div.small-box .inner {
        width: 9rem;
      }
      div.small-box .inner p {
        line-height: 1;
      }
    }
    @media (min-width: 1025px) and (max-width: 1280px) {
      div.small-box {
        height: 7.05rem;
      }
      div.small-box .inner {
        width: 9rem;
      }
      div.small-box .inner p {
        line-height: 1;
      }
    }
    .bg-secondary {
      background-color: var(--ocd-tertiary-dark-hover) !important;
      color: var(--ocd-primary) !important;
    }

    .progress-group {
      margin-bottom: 1rem;
    }
    
    .timeline>.time-label>span {
      width: 60%;
      text-align: center;
    }

    .tertiary-dark {
      background: #ebebf1 !important;
      color: var(--ocd-primary) !important;
    }

    .timeline>div {
      margin-right: 0;
    }

    .timeline>div>.timeline-item {
      margin-right: 0;
      margin-left: 45px;
      padding-top: 8px;
    }

    .timeline::before {
      left: 20px;
    }

    .timeline>div>.fa,
    .timeline>div>.fab,
    .timeline>div>.fad,
    .timeline>div>.fal,
    .timeline>div>.far,
    .timeline>div>.fas,
    .timeline>div>.ion,
    .timeline>div>.svg-inline--fa {
      left: 8px;
    }

    h5.timeline-header {
      font-size: 15px !important;
    }

    .timeline>div>.timeline-item>.time {
      font-size: 15px;
      padding-top: 20px;
      float: none;
    }

    .timeline>div>.timeline-item>.timeline-header {
      border: 0;
    }

    .timeline>div>.timeline-item>.timeline-body {
      padding-top: 0;
      font-size: 14px;
    }

    .timeline-inverse>div>.timeline-item {
      background-color: #f8f9fa;
      border: 1px solid #e1b695;
    }
  </style>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  @endsection

  @section('content')

  @livewire('partials.content-header', [
  'pageTitle' => 'Super Administrator Dashboard',
  'breadcrumb' => [
  ['name' => 'Dashboard', 'route' => 'dashboard/admin'],
  ['name' => 'Super Admin', 'route' => '#'],
  ]
  ])

  <div class="row">
    <div class="col-md-8">
      <div class="row">
        <div class="col-lg-4 col-12">
          @livewire('widgets.user.admin-count')
        </div>
        <div class="col-lg-4 col-12">
          @livewire('widgets.user.twg-count')
        </div>
        <div class="col-lg-4 col-12">
          @livewire('widgets.user.pfo-count')
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <!-- log_names can be pass as array of log_name - default: null; -->
      <!-- sort_type can be pass as 'asc' or 'desc' - default: 'desc'  -->
      <!-- field can be pass as any string of field in activity_log db - default: 'id'  -->
      @livewire('components.activity-log', ['log_names' => ['poe']])
    </div>
  </div>

  @endsection

  @section('script')
  <script>
    const labels = [
      'January',
      'February',
      'March',
      'April',
      'May',
      'June',
    ];

    const data = {
      labels: labels,
      datasets: [{
        label: 'My First dataset',
        backgroundColor: '#2C88D9',
        borderColor: '#2C88D9',
        data: [0, 10, 30, 2, 20, 30, 45],
      }]
    };

    const config = {
      type: 'line',
      data: data,
      options: {}
    };

    const myChart = new Chart(
      document.getElementById('myChart'),
      config
    );
  </script>
  <script>
    $("#li_superdashboard").addClass('active');
  </script>
  @endsection
</x-app-layout>