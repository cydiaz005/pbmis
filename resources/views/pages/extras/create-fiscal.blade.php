<x-app-layout>
    @section('style')
	<style>
		
		.papbtn-con a {
			font-size: 13px;
			padding: 6px 15px;
			color: #FFF;
		}
		.paptbl-con {
			min-height: 28rem;
		}
		.main-label {
			font-size: 17px;
		}
		.sub-label {
			color: #808080;
			margin-left: 1.15rem;
			
		}
		/* ---------------- */
		table th {
			padding: 0.3rem !important;
		}
		.paptbl-con table td {
			padding: 0.2rem !important;
			font-size: 12px !important;
		}
		.paptbl-con table td input {
			padding: 0.5rem !important;
			font-size: 12px !important;
			text-align:left;
			border:none;
		}
		.paptbl-con table td input:focus {
			border: none !important;
			box-shadow: none;
		}
		.paptbl-con table td , thead th {
			text-align: center;
		}
		thead th {
			border-color: gray !important;
			z-index: 999;
		}

		thead th {
			color: #000000 !important;
		}
		.office-head, .mooe-head, .co-head, .total-head{
			background-color: #ffff008c;
		}
		.gas-head {
			background-color: #ffa500a3;
		}
		.drrm-head {
			background-color: #6495edc2;
		}
		.qrf-head {
			background-color: #cd5c5cba;
		}
		.regional-head {
			background-color: #00800080;
		}
		.cancel-btn:hover {
			border: 1px solid var(--ocd-secondary);
		}
		.view {
		margin: auto;
		width: 600px;
		}

		.table-sticky-wrapper {
		position: relative;
		overflow: auto;
		border: 1px solid black;
		white-space: nowrap;
		}

		.sticky-col {
		position: -webkit-sticky;
		position: sticky;
		background-color: #f5f5f5;
		/* z-index: 10; */
		}

		.office-column {
			width: 100px;
			left: 0px;
		}

		.total-column {
			width: 150px;
			right: 0px;
		}

		.fiscal-header {
			background-color: #8ECAE6 !important;	
		}
		.wfl-form input{
			border: none !important;
			background: none !important;
		}
		.d-none{
			display:none !important;
		}
		.entry{
			min-width: 100% !important;
			
		}
		
		.office-filter{
			margin-left: 10px !important;
		}
				
	</style>
    <script>
    </script>
    @endsection

    @section('content')

    @livewire('partials.content-header', [
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
            ['name' => 'Forms', 'route' => '#'],
            ['name' => 'Working Fiscal Limits', 'route' => '/pages/form/fiscal-limits'],
			['name' => 'Create', 'route' => '#'],
        ],
        'pageTitle' => 'Working Fiscal Limits',
        
    ])

	{{-- @livewire('fiscalimits-tab-content.builder') --}}


	<!--  -->
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header d-flex p-0">
					<!-- <h3 class="card-title p-3">Offices</h3> -->
					<ul class="nav nav-pills ml-auto p-2">
						<li class="nav-item"><a class="nav-filter nav-link active" href="#tab_1" data-filter="tab_1_filter" data-toggle="tab">Regional Office</a></li>
						<li class="nav-item"><a class="nav-filter nav-link" href="#tab_2" data-filter="tab_2_filter" data-toggle="tab">Central Office</a></li>
						<li class="nav-item tab-filter tab_1_filter">
							<select class="selectpicker office-filter regional-office-filter" data-key="ro" multiple data-live-search="true">
								<!-- <option value="*">Show All</option> -->
								@foreach($service_regions as $sr)
									@if($sr['co'] == 0)
									<option value="{{$sr->accronym}}">{{$sr->accronym}}</option>
									@endif
								@endforeach
							</select>
							&nbsp;
							<i class="fas fa-filter txt-primary"></i>
						</li>
						<li class="nav-item tab-filter tab_2_filter d-none">
							<select class="selectpicker office-filter central-office-filter" data-key="co" multiple data-live-search="true">
								<!-- <option value="*">Show All</option> -->
								@foreach($service_regions as $sr)
									@if($sr['co'] == 1)
									<option value="{{$sr->accronym}}">{{$sr->accronym}}</option>
									@endif
								@endforeach
							</select>
							&nbsp;
							<i class="fas fa-filter txt-primary"></i>
						</li>
					</ul>   
				</div>
				<div class="card-body">
					<div class="tab-content">
						
						<div class="tab-pane active" id="tab_1">
							{{--$service_regions--}}
							<div class="row">					
								<div class="col-12">
									<div class="table-sticky-wrapper p-0 wfl-form">
										@php $cat_column = [] @endphp
										<table class="table table-bordered">
										<thead>
											<tr>
												<th class="sticky-col office-column" rowspan="2">
													Office
												</th>
												@foreach($categories as $category)    
												<th colspan="{{count($category->fundChargeabilityClass)}}">{{$category->accronym}}</th>
												@endforeach
												<th class="sticky-col total-column" rowspan="2">Total</th>
											</tr>
											<tr>
												@foreach($categories as $category)    
													@foreach($category->fundChargeabilityClass as $class)
													<th>{{$class->fundChargeability->accronym}}</th>
													@php array_push($cat_column, $category->accronym."-".$class->fundChargeability->accronym) @endphp
													@endforeach   
												@endforeach
											</tr>
										</thead>
										<tbody>
											<!-- Regional Office  -->
											@foreach(array_keys($data_entry['ro']) as $regional_key)
											<tr class="row-ro {{$regional_key}}">
												<td class="sticky-col office-column">{{$regional_key}}</td>
												@foreach(array_keys($data_entry['ro'][$regional_key]) as $category_key)
												
												@if ($loop->last)
												<td class="sticky-col total-column">
													<input 
													type="number" 
													class="summary ro {{$category_key}}"
													data-office = 'ro'
													data-region = "{{$regional_key}}"
													data-category = "{{$category_key}}"
													data-column = "{{$loop->index}}"
													readonly
													>
												</td>
												@else
												<td>
													<input 
													type="number" 
													class="entry ro {{$regional_key}} col-{{$loop->index}}"
													data-office = 'ro'
													data-region = "{{$regional_key}}"
													data-category = "{{$category_key}}"
													data-column = "{{$loop->index}}"
													>
												</td>
												@endif
												@endforeach
											</tr>
											@endforeach
											<tr>
												<td class=" fiscal-header sticky-col office-column">
													RO's TOTAL
												</th>
												@foreach($categories as $category)    
													@foreach($category->fundChargeabilityClass as $class)
													<td class=" fiscal-header ">
														<input 
														type="number" 
														class="summary ro col-{{$loop->index}}-total"
														data-column = "{{$loop->index}}"
														readonly
														disabled
														>
													</td>
													@endforeach   
												@endforeach
												<td class=" fiscal-header sticky-col total-column">&nbsp;</th>
											</tr>
										</tbody>

										</table>
									</div>
								</div>
							</div>
						</div>

						<div class="tab-pane" id="tab_2">
							<div class="row">

							<div class="col-12">
									<div class="table-sticky-wrapper p-0 wfl-form">
										@php $cat_column = [] @endphp
										<table class="table table-bordered">
										<thead>
											<tr>
												<th class="sticky-col office-column" rowspan="2">
													Office
												</th>
												@foreach($categories as $category)    
												<th colspan="{{count($category->fundChargeabilityClass)}}">{{$category->accronym}}</th>
												@endforeach
												<th class="sticky-col total-column" rowspan="2">Total</th>
											</tr>
											<tr>
												@foreach($categories as $category)    
													@foreach($category->fundChargeabilityClass as $class)
													<th>{{$class->fundChargeability->accronym}}</th>
													@php array_push($cat_column, $category->accronym."-".$class->fundChargeability->accronym) @endphp
													@endforeach   
												@endforeach
											</tr>
										</thead>
										<tbody>
											<!-- Central Office  -->
											@foreach(array_keys($data_entry['co']) as $regional_key)
											<tr class="row-co {{$regional_key}}">
												<td class="sticky-col office-column">{{$regional_key}}</td>
												@foreach(array_keys($data_entry['co'][$regional_key]) as $category_key)
												
												@if ($loop->last)
												<td class="sticky-col total-column">
													<input 
													type="number" 
													class="summary co {{$category_key}}"
													data-office = 'co'
													data-region = "{{$regional_key}}"
													data-category = "{{$category_key}}"
													data-column = "{{$loop->index}}"
													readonly
													>
												</td>
												@else
												<td>
													<input 
													type="number" 
													class="entry co {{$regional_key}} col-{{$loop->index}}"
													data-office = 'co'
													data-region = "{{$regional_key}}"
													data-category = "{{$category_key}}"
													data-column = "{{$loop->index}}"
													>
												</td>
												@endif
												@endforeach
											</tr>
											@endforeach
											<tr>
												<td class=" fiscal-header sticky-col office-column">
													CO's TOTAL
												</th>
												@foreach($categories as $category)    
													@foreach($category->fundChargeabilityClass as $class)
													<td class=" fiscal-header ">
														<input 
														type="number" 
														class="summary co col-{{$loop->index}}-total"
														data-column = "{{$loop->index}}"
														readonly
														disabled
														>
													</td>
													@endforeach   
												@endforeach
												<td class=" fiscal-header sticky-col total-column">&nbsp;</th>
											</tr>
										</tbody>

										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
    @endsection
    
    @section('script')
    <script>
		(function () {
			$("#li_forms").addClass('menu-open');
			$("#li_forms>a.li_parent").addClass('active');
			$("#li_fiscal").addClass('active');
			
			let entry = {}; 
			$('.entry').on('change', getRegionalSummary);
			$('.office-filter').on('change', officeFilter);
			$('.nav-filter').on('click', changeFilter);

			function getRegionalSummary() {
				let office = $(this).data('office');
				let region = $(this).data('region');
				let category = $(this).data('category');
				let column = $(this).data('column');
				let value = $(this).val();
				

				$('input.'+office+'.'+region+'-TOTAL').val(getRowTotal(region));
				$('input.'+office+'.col-'+column+'-total').val(getColumnTotal(office, column));

			}

			function getRowTotal(region) {
				let entries = $('input.entry.'+region);
				let total = parseFloat(0);
				for (let i = 0; i < entries.length; i++) {
					let entry = entries[i].value;
					if (entry) {
						total += parseFloat(entry);
					}
				}
				return total;
			}

			function getColumnTotal(office, column) {
				console.log(
					{
						"getColumnTotal": [
							office, column
						]
					}
				);

				let entries = $('input.entry.'+office+'.col-'+column);
				let total = parseFloat(0);
				for (let i = 0; i < entries.length; i++) {
					let entry = entries[i].value;
					if (entry) {
						total += parseFloat(entry);
					}
				}
				return total;
			}

			function officeFilter() {
				let checked = $(this).val();
				let key = $(this).data('key');
				$('.row-'+key).addClass('d-none');
				
				for (let sr = 0; sr < checked.length; sr++) {
					let cssClass = checked[sr];
					console.log('.'+cssClass);
					$('.'+cssClass).removeClass('d-none');
				}

				console.log($(this).val());


				// console.log($(this).val(['*']));
				// $(this).selectpicker('refresh');
			}

			function changeFilter() {
				let filter = $(this).data('filter');
				$('.tab-filter').addClass('d-none');
				$('.'+filter).removeClass('d-none')
				console.log({filter});
			}

		})();

		// let toInt = function(num){
		// 	num = num.toString();
		// 	num = num.replace(/[^\d.-]+/g,'');
		// 	num = parseInt(num) || 0;
		// 	return num;
		// }
		// let formatter = function(num){
		// 	if(this.value){
		// 		this.value = Number(toInt(this.value)).toLocaleString('en', options);
		// 		document.querySelector('#item-req-con-total').innerHTML = computeTotal();
		// 	}
		// 	else{
		// 		return Number(toInt(num)).toLocaleString('en', options);
		// 	}
		// }
		
	
    </script>
    @endsection
</x-app-layout>
