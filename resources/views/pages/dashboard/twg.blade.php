<x-app-layout>
    @section('style')
	<style>
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
        'pageTitle' => 'Technical Working Group Dashboard',
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => 'dashboard/admin'],
            ['name' => 'TWG', 'route' => '#'],
        ]
    ])

	<div class="row">
		<div class="col-md-8">
			<div class="row">
				@foreach ($poe as $key=>$count)
					<div class="col-lg-4 col-12">
						<!-- small box -->
						<div class="small-box bg-tertiary">
						<div class="inner">
							{{-- <h3>{{$count}} {{$count > 1 ? "POES":"POE"}}</h3> --}}
							<h3>{{$count}} <small style="font-size:50%">POE</small></h3>
							<p class="text-capitalize">{{$key}}</p>
						</div>
						<div class="icon">
							<i class="fas fa-newspaper"></i>
						</div>
						</div>
					</div>
				@endforeach
			</div>
			<hr>
			<br>
			<div class="row">
				@foreach ($ppmp as $key=>$count)
					<div class="col-lg-4 col-12">
						<!-- small box -->
						<div class="small-box bg-primary">
						<div class="inner">
							{{-- <h3>{{$count}} {{$count > 1 ? "POES":"POE"}}</h3> --}}
							<h3>{{$count}} <small style="font-size:50%">PPMP</small></h3>
							<p class="text-capitalize">{{$key}}</p>
						</div>
						<div class="icon">
							<i class="fas fa-newspaper"></i>
						</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
		<div class="col-md-4">
			@livewire('components.activity-log', ['log_names' => ['poe', 'ppmp']])
		</div>
	</div>


    @endsection
    
    @section('script')

  <script>
    $("#li_twgdashboard").addClass('active');
  </script>
    @endsection
</x-app-layout>
