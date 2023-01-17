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
        'pageTitle' => 'Planning Focal / Officer Dashboard',
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => 'dashboard/admin'],
            ['name' => 'FP/O', 'route' => '#'],
        ]
    ])
	<div class="row">
		<div class="col-md-8">
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
			<div class="row">
			@foreach ($data as $key=>$count)
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
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body" style="color: var(--ocd-primary)">
					<h3 class="text-center mb-3 text-dark">
						<strong>FISCAL LIMIT </strong>
					</h3>
					<span class="font-weight-normal">Fiscal Limit:</span> <strong>₱{{number_format($fiscal_limit, 2, '.', ',')}}</strong>
					<br>
					<span class="font-weight-normal">Total Programmed Budget:</span> <strong>₱{{number_format($total_programmed_budget, 2, '.', ',')}}</strong>
				</div>
			</div>
			@livewire('components.activity-log', ['log_names' => ['poe']])
		</div>
	</div>

    @endsection
    
    @section('script')
	<script>
		$("#li_fpodashboard").addClass('active');
	</script>
    @endsection
</x-app-layout>
