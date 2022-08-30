<x-app-layout>
	@php
	(@$_GET['fiscal_year']>=2022 &&  @$_GET['fiscal_year']<=date("Y"))? true: abort(404);
	@endphp
    @section('style')
	<style>
		.d-none{
			display: none !important;
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
		position: relative !important;
		overflow: auto !important;
		white-space: nowrap !important;
		}

		td.sticky-col, th.sticky-col  {
		position: -webkit-sticky !important;
		position: sticky !important;
		background-color: #f5f5f5 !important;
		/* z-index: 10; */
		}

		td.office-column, th.office-column {
			width: 100px;
			left: 0px !important;
		}

		td.total-column , th.total-column{
			width: 150px;
			right: 0px !important;
		}

		.fiscal-header {
			background-color: #8ECAE6 !important;	
		}

		input{
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
		.table-sticky-wrapper.active {
			background: rgba(255,255,255,0.3);
			cursor: grabbing;
			cursor: -webkit-grabbing;
			transform: scale(1);
    	}
		.table-sticky-wrapper table {
			position: relative;
			border-collapse: collapse; 
		}
		/* .fiscal-limit-table table thead {
			background-color: #1c20ab;
			color: #c2c7d0;
			position: sticky;
			position: -webkit-sticky;
			z-index: 999;
			top: 0;
		} */
		.cell.active {
			background-color: #1c20ab1a;
		}
		.table-sticky-wrapper::-webkit-scrollbar {
			width: 3px;
			height: 3px;
		}
		.table-sticky-wrapper::-webkit-scrollbar-thumb {
			background-color: #c1c1c1;
		}
		
		.fiscal-limit-table {
			height: 50rem;
		}

		
	</style>
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

	@if(@$categories)
	<div id="fiscal-table" class="card d-none">
		<div class="card-header d-flex p-0">
			<!-- <h3 class="card-title p-3">Offices</h3> -->
			<ul class="nav nav-pills ml-auto p-2">
				<li class="nav-item"><a id="ro-link" class="nav-filter nav-link active" href="#tab_1" data-filter="tab_1_filter" data-toggle="tab">Regional Office</a></li>
				<li class="nav-item"><a id="co-link" class="nav-filter nav-link" href="#tab_2" data-filter="tab_2_filter" data-toggle="tab">Central Office</a></li>
				<li class="nav-item tab-filter tab_1_filter">
					<select class="selectpicker office-filter regional-office-filter" data-key="ro" multiple data-live-search="true">
						<!-- <option value="*">Show All</option> -->
						@foreach($service_regions as $sr)
							@if($sr['co'] == 0)
							<option value="{{$sr->accronym}}">{{$sr->accronym}}</option>
							@endif
						@endforeach
					</select>
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
				</li>
				<div class="card-tools" style="margin-left: 10px">
					<button type="button" class="btn btn-secondary d-none" id="dummEntry">
						Generate Dummy Data
					</button>
					<button type="button" id="fiscal-undo" class="btn btn-secondary">
						<i class="fa fa-undo" aria-hidden="true"></i>
					</button>
					<button type="button" id="fiscal-save" class="btn btn-primary">
						<i class="fas fa-save"></i>
					</button>
				</div>
			</ul>   
		
		</div>
		<div class="card-body">
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1">
					<div class="row">					
						<div class="col-12">
							<div class="table-sticky-wrapper">
								<table id="ro-table" class="table table-bordered">
									<thead>
									</thead>
									<tbody>
									</tbody>
									<tfoot>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>

				<div class="tab-pane" id="tab_2">
					<div class="row">
						<div class="col-12">
							<div class="table-sticky-wrapper">
								<table id="co-table" class="table table-bordered table-hover">
									<thead>
									</thead>
									<tbody>
									</tbody>
									<tfoot>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif

	

    @endsection
    
    @section('script')
    <script>
		(function() {
			
			var data_entry = {};
			var central_office = [];
			var regional_office = [];
			var tbl_central_office = $('#co-table');
            var tbl_regional_office = $('#ro-table');
            var tbl_fiscal = $('#fiscal-table');
            var btn_undo = $('#fiscal-undo');
            var btn_save = $('#fiscal-save');
            var dummEntry = $('#dummEntry');
            var filter_ro = $('.regional-office-filter');
            var filter_co = $('.central-office-filter');

			var visible_rows = {ro:[], co:[]}
			var categories = Object.values(JSON.parse('<?php echo json_encode($categories, JSON_FORCE_OBJECT) ?>'));
			var service_regions = Object.values(JSON.parse('<?php echo json_encode($service_regions, JSON_FORCE_OBJECT) ?>'));
			var year = "{{@$_GET['fiscal_year']}}";			
			const options = {
				minimumFractionDigits: 2,
				maximumFractionDigits: 2
			};

			var Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000
			});

			
			$('.selectpicker').on('change', function(){
				let vissible  = $(this).val();
				let table = ($(this).data('key') == 'ro') ? tbl_regional_office: tbl_central_office;
				table.find('.tr-entry').addClass('d-none');

				vissible.forEach(cssClass => {
					cssClass = cssClass.toLowerCase();
					table.find('.'+cssClass).removeClass('d-none');
				});
			});


			Object.keys(service_regions).map(function(key) {
				(service_regions[key].co == '1')? 
				central_office.push(service_regions[key]):
				regional_office.push(service_regions[key])
			});

			buildTable(regional_office, tbl_regional_office);
			buildTable(central_office, tbl_central_office);
			btn_undo.on('click', resetLimits);
			btn_save.on('click', saveLimits);
			dummEntry.on('click', dummy);
			getVisible();
			getFiscalYearBudget();



			function dummy() {
				for (let index = 0; index < $('.entry').length; index++) {
					let entry = $($('.entry')[index]);
					let entry_value = (entry.val())?entry.val(): randomIntFromInterval(11,99);
					let multiplier = randomIntFromInterval(1111,9999);
					entry.val(entry_value*multiplier);
					entry.trigger('change');
				}
			}


			$('#ro-link').on('click', function () {
				// console.log("ro trigger");
				$('.tab_1_filter').removeClass('d-none');
				$('.tab_2_filter').addClass('d-none')
			})
			$('#co-link').on('click', function () {
				// console.log("co trigger");
				$('.tab_1_filter').addClass('d-none');
				$('.tab_2_filter').removeClass('d-none')
			})

			function getVisible() {
				let filter_ro_opts = filter_ro.find('option');
				let filter_co_opts = filter_co.find('option');
		
				for (let ro_index = 0; ro_index < filter_ro_opts.length; ro_index++) {
					const ro_element = $(filter_ro_opts[ro_index]);
					visible_rows['ro'].push(ro_element.attr('value'))
				}

				for (let co_index = 0; co_index < filter_co_opts.length; co_index++) {
					const co_element = $(filter_co_opts[co_index]);
					visible_rows['co'].push(co_element.attr('value'))
				}

				filter_ro.val(visible_rows['ro']);
				filter_co.val(visible_rows['co']);


			}

			function toFloat(num){
				num = num.toString();
				num = num.replace(/,/g, '');
				num = num.replace(/[a-z]/gi, '');
				num = parseFloat(num) || 0;
				return num;
			}

			let formatter = function(num){
				if(this.value){
					this.value = Number(toFloat(this.value)).toLocaleString('en', options);
					document.querySelector('#item-req-con-total').innerHTML = computeTotal();
				}
				else{
					return Number(toFloat(num)).toLocaleString('en', options);
				}
			}
	

			function getFiscalYearBudget() {
				$.ajax({
					type:'POST',
					url: window.location.origin+"/form/working-fiscal-limit/edit",
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					data: {year},
					success:retain,
				});
			}

			function retain(fiscal_budget){
				fiscal_budget.forEach(fb => {
					$cat_id = "#cat-"+fb.cat_id;
					$sr_id = "#sr-"+fb.serreg_id;
					$($sr_id).find($cat_id).val(fb.amount);
					$($sr_id).find($cat_id).trigger('change');
					// console.log(fb);	
				});
			}

			function randomIntFromInterval(min, max) {
				return Math.floor(Math.random() * (max - min + 1) + min)
			}

			function buildTable(offices, table) {
				let row;
				let allotment_class;
				let fund_chargeability;
				let fund_chargeability_class;
				createHeading(table);
				offices.forEach(office => {
					row = appendRowBody(table);
					dataTitle(row, office);
					Object.keys(categories).map(function(key) {
						allotment_class = categories[key].accronym;
						fund_chargeability_class = categories[key].fund_chargeability_class;
						Object.values(fund_chargeability_class).forEach((sub_class, id) => {
							fund_chargeability = sub_class.fund_chargeability
							const meta = {
								ffc_id: sub_class.id,
								ac: allotment_class,
								fc: fund_chargeability.accronym
							};
							dataInput(row, office.accronym, sub_class.id, meta);
						});
					});
					dataTotal(row, office.accronym);
				});
				createSummary(table);
				tbl_fiscal.removeClass('d-none');
			}

			function createHeading(table){
				let row;

				// Table Header Row #1 
				row = appendRowHeading(table);

				// thead -> row, title, colspan, rowspan
				thead(row, 'Offices', 1, 2).addClass('sticky-col office-column')
				Object.keys(categories).map(function(key) {
					allotment_class = categories[key].accronym;
					fund_chargeability_class = categories[key].fund_chargeability_class;
					thead(row, allotment_class, Object.values(fund_chargeability_class).length, 1);
				});

				thead(row, 'Total', 1, 2).addClass('sticky-col total-column');

				// Table Header Row #2
				row = appendRowHeading(table);

				Object.keys(categories).map(function(key) {
					allotment_class = categories[key].accronym;
					fund_chargeability_class = categories[key].fund_chargeability_class;

					Object.values(fund_chargeability_class).forEach((sub_class, id) => {
						fund_chargeability = sub_class.fund_chargeability
						thead(row, fund_chargeability.accronym, 1, 1);
						// console.log(sub_class);
					});
				});

			}

			function createSummary(table) {
				let row = appendRowFooter(table);
				row.addClass('tsummary');
				tsummary(row, 'Sub-Total').addClass('sticky-col office-column');
				Object.keys(categories).map(function(key) {
					allotment_class = categories[key].accronym;
					fund_chargeability_class = categories[key].fund_chargeability_class;
					Object.values(fund_chargeability_class).forEach((sub_class, id) => {
						fund_chargeability = sub_class.fund_chargeability
						dataSummary(row);
					});
				});
				summaryTotal(row);

			}

			function appendRowHeading(table){
				let thead = table.find('thead');
				thead.append("<tr></tr>")
				return thead.find('tr').last();
			}

			function appendRowBody(table){
				let tbody = table.find('tbody');
				tbody.append("<tr class='tr-entry'></tr>")
				return tbody.find('tr').last();
			}

			function appendRowFooter(table){
				let tfoot = table.find('tfoot');
				tfoot.append("<tr></tr>")
				return tfoot.find('tr').last();
			}
			
			function thead(row, title, colspan, rowspan) {
				colspan = (colspan)? colspan: 1;
				rowspan = (rowspan)? rowspan: 1;
				row.append('<th colspan="'+colspan+'" rowspan="'+rowspan+'">'+title+'</th>')
				return row.find('th').last();
			}

			function tsummary(row, title, colspan, rowspan) {
				colspan = (colspan)? colspan: 1;
				rowspan = (rowspan)? rowspan: 1;
				row.append('<td class="entry-summary" colspan="'+colspan+'" rowspan="'+rowspan+'">'+title+'</td>')
				return row.find('td').last();
			}
			
			function dataTitle(row, title) {
				row.append('<td class="sticky-col office-column">'+title.accronym+'</td>')
				row.find('td').last().parent().addClass(title.accronym.toLowerCase());
				row.find('td').last().parent().prop('id', 'sr-'+title.id);
			}
			
			function dataInput(row, office, sub_class, meta) {
				row.append('<td></td>');
				const td = row.find('td').last();
				const key = "fcc-"+sub_class;
				td.html('<input id="cat-'+meta.ffc_id+'" type="text" class="entry">');
				td.find('input').on('change', function () {
					(!data_entry.hasOwnProperty(office))?  
					data_entry[office] = {} : 0;
					data_entry[office][sub_class] = $(this).val();
					getOfficeTotal(office);
					columnTotal(row, office, $(this));
					$(this).val(formatter($(this).val()));
					// console.log($(this).val());
				})
			}

			function dataSummary(row) {
				row.append('<td></td>');
				const td = row.find('td').last();
				td.addClass('fiscal-header')
				td.html('<input type="text" readonly disabled>');
				td.find('input').on('change', function () {
					(!data_entry.hasOwnProperty(office))?  
					data_entry[office] = {} : 0;
					data_entry[office][sub_class] = $(this).val();
					getOfficeTotal(office);
					columnTotal(row, office, $(this));
					consolidateTotal();
					//console.log(data_entry);
				})
			}
			

			function summaryTotal(row) {
				row.append('<td></td>');
				const td = row.find('td').last();
				td.addClass('sticky-col total-column')
				td.html('<input class="sub-total" type="text" value="0.00" disabled readonly>');

			}

			function dataTotal(row, key) {
				row.append('<td id="'+key.toLowerCase()+'-total" class="sticky-col total-column"></td>');
				const td = row.find('td').last();
				td.html('<input type="text" value="0.00" disabled readonly>');
			}


			function getOfficeTotal(office){
				let sum = 0;
				const td = $('#'+office.toLowerCase()+'-total');
				Object.values(data_entry[office]).forEach(entries => {
					sum+=parseFloat(entries);
				});
				td.find('input').val(formatter(sum));
			}


			function columnTotal(row, office, el) {
				let sum = parseFloat(0);
				let td = el.parent();
				let tdIndex = td.index();
				let tbody = td.closest('tbody');
				let trow =	tbody.find('tr') ;
				for (let index = 0; index < trow.length; index++) {
					const element = $(trow[index]);
					const column = element.children().eq(tdIndex);
					const entry = column.find('input');
					// console.log(column.css('border','1px solid red'));
					(entry.val())? sum+=parseFloat(entry.val()): false;
				}
				let tsummary = $(tbody.parent().find('.tsummary'));
				tsummary.children().eq(tdIndex).find('input').val(formatter(sum));
				subTotal(tsummary)
				console.log({columnTotal:sum});
			}

			function subTotal(el) {
				let sum = parseFloat(0);
				let entry_totals = el.find('input');
				for (let index = 0; index < entry_totals.length-1; index++) {
					const entry = $(entry_totals[index]);
					(entry.val())? 	sum += parseFloat(entry.val()):parseFloat(0);
				}
				el.find('.sub-total').val(formatter(sum));
			}
			


			function resetLimits() {
				$('input').val("");
				$('input').trigger('change')
			}

			function saveLimits() {
				toastr.info("Saving, Please wait.");

				$.ajax({
					type:'POST',
					url: window.location.origin+"/form/working-fiscal-limit/save",
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					data: {data_entry},
					success:function(response){
 						toastr.success("Fiscal limit has been successfuly set.");

						setTimeout(() => {
							
						window.location.href = window.location.origin+"/form/working-fiscal-limit/";
						}, 3000)
						
					}
				});
			}
		 // draggable table
		 let table_con = document.querySelector('.table-sticky-wrapper');
			let isDown = false;
			let startX;
			let scrollLeft;

			table_con.addEventListener('mousedown', (e) => {
				isDown = true;
				table_con.classList.add('active');
				startX = e.pageX - table_con.offsetLeft;
				scrollLeft = table_con.scrollLeft;
			});
			table_con.addEventListener('mouseleave', () => {
				isDown = false;
				table_con.classList.remove('active');
			});
			table_con.addEventListener('mouseup', () => {
				isDown = false;
				table_con.classList.remove('active');
			});
			table_con.addEventListener('mousemove', (e) => {
				if(!isDown) return;
				e.preventDefault();
				const x = e.pageX - table_con.offsetLeft;
				const walk = (x - startX) * 2; //scroll-fast
				table_con.scrollLeft = scrollLeft - walk;
				
			});
			$(function() {
				$('td').dblclick(function() {
					$('tr').removeClass('active');
					$(this).parent().addClass('active'); 
				});
			});
		})();
    </script>
    @endsection
</x-app-layout>
