<x-app-layout>
    @section('style')
	<style>
		.collapsing{
			width: 105rem !important;
		}
		.table-con{
			overflow-x: auto;
		}
		.table-width{
			width: 105rem !important;
		}
		thead{
			background: #adb9ca;
		}
		th{
			color: #000000;
			padding: 1rem;
		}
		td{
			padding: .6rem;
		}
		.priority-width{
			width: 4rem;
		}
		.projects-width{
			width: 25rem;
		}
		.target-width{
			width: 8rem;
		}
		.total-width{
			width: 8rem;
		}
		.budget-width{
			width: 8rem;
		}
		.chargeability-width{
			width: 5rem;
		}
		.climate-width{}

		.priority-title{
			border-bottom: 1px solid #adb9ca;
		}
		.priority-title:hover{
			background: #ffc107;
			cursor: pointer;
		}
		[aria-expanded="false"] {

		}
		.priority-icon{
			transition: -webkit-transform ease-in-out .3s;
			transition: transform ease-in-out .3s;
			transition: transform ease-in-out .3s,-webkit-transform ease-in-out .3s
		}
		.collapsed .priority-icon{
			-webkit-transform: rotate(90deg);
    		transform: rotate(90deg);

		}
	</style>
    @endsection
    @section('content')

    @livewire('partials.content-header', [
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
        ],
        'pageTitle' => 'LIST OF PAPS (PER PRIORITY CLASSIFICATION)',

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
	<div class="card card-primary card-outline card-outline-tabs" style="border-top: none">
		<div class="card-body table-con">
			<table class="table-width">
				<thead>
					<tr>
						<th class="priority-width">Region</th>
						<th class="projects-width">Projects/Activities</th>
						<th class="target-width">Q1 Target</th>
						<th class="target-width">Q2 Target</th>
						<th class="target-width">Q3 Target</th>
						<th class="target-width">Q4 Target</th>
						<th class="total-width">Total</th>
						<th class="budget-width">Budget</th>
						<th class="chargeability-width">Chargeability</th>
						<th class="climate-width">Climate Change-Related</th>
					</tr>
				</thead>
			</table>
			@foreach ($target_sectors as $target_sector)
			<div>
				<div class="p-3 table-width priority-title collapsed" data-priority="{{$target_sector->id}}" aria-expanded="false">
					{{$target_sector->sector}} 
					<i class="ml-3 fas fa-angle-down priority-icon"></i>
				</div>
				<div class="collapse" id="priority-data-collapse-{{$target_sector->id}}">
					<table class="table-width">
						<tr>
							<td colspan="10" class="text-center">Loading...</td>
						</tr>
					</table>
				</div>
			</div>
			@endforeach
			
		</div>
		<!-- /.card -->
	</div>

    @endsection

    @section('script')
	<script src="{{asset('js/poe.js')}}"></script>
    <script>
		let region_titles = document.querySelectorAll('.priority-title');
		let toggled_data = [];
		for (let i = 0; i < region_titles.length; i++) {
			const element = region_titles[i];
			element.onclick=function(){
				let pc_id = this.dataset.priority;
				let collapsible_element = document.querySelector("#priority-data-collapse-"+pc_id);

				if(collapsible_element.classList.contains('show')){
					$("#priority-data-collapse-"+pc_id).collapse('hide');
					this.classList.add('collapsed');
				}
				else{
					$("#priority-data-collapse-"+pc_id).collapse('show');
					this.classList.remove('collapsed');
					getPoes(pc_id);
				}

			}
		}

		function getPoes(pc_id){
			if(toggled_data.includes(pc_id)){
				return;
			}
			new HttpRequest({
				url: "/form/poe/fetch/by-group",
				data: {target_sector: pc_id, year: "{{$selected_year}}"},
				done: function(res){
					toggled_data.push(pc_id);
					console.log("res", res);
					let table = document.querySelector('#priority-data-collapse-'+pc_id).querySelector('table');
					if(Object.keys(res).length > 0){
						let rows = '';
						for (const pc in res) {
							const priority_class = res[pc];
							rows += `<tr>
								<td class="priority-width" style="background: yellow">${priority_class[0].service_region.accronym}</td>
								<td colspan="9"><strong>${priority_class[0].mfo.priority_class.accronym}:  ${priority_class[0].mfo.desc}</strong></td>
							</tr>`;
							for (let i = 0; i < priority_class.length; i++) {
								const poe = priority_class[i];
								let poe_tags = '';
								for (let p = 0; p < poe.poe_tags.length; p++) {
									poe_tags += `<span class="usertag badge badge-primary">${poe.poe_tags[p].pap_tag.tag}</span><br>`;
								}
								rows += `<tr>
										<td class="priority-width" style="background: yellow">${poe.service_region.accronym}</td>
										<td colspan="8" style="padding-left: 2rem;"><strong>${i+1}. ${poe.pap_txt || poe.suggested_pap.paps}</strong></td>
										<td><strong>${poe_tags}</td>
									</tr>`;
								for (let x = 0; x < poe.subpap.length; x++) {
									const subpap = poe.subpap[x];
									const quarter_target = subpap.quarter_target.quarter_target;
									let total_targets = 0;
									let item_req_rows = '';
									for (let y = 0; y < subpap.item_requirements.length; y++) {
										const item_requirement = subpap.item_requirements[y];
										let req_total_targets = 0;
										let qtr_target_totals = {
											1:0,
											2:0,
											3:0,
											4:0,
										};
										for (let index = 0; index < item_requirement.item_months.length; index++) {
											const element = item_requirement.item_months[index];
											qtr_target_totals[element.quarter] += parseInt(element.qty);
											total_targets += parseInt(element.qty);
											req_total_targets += parseInt(element.qty);
										}

										item_req_rows += `<tr>
											<td class="priority-width" style="background: yellow">${poe.service_region.accronym}</td>
											<td class="projects-width" style="padding-left: 6rem;"><i>${i+1}.${x+1}.${y+1}. ${item_requirement.itemreq_txt || item_requirement.suggested_item_requirement.ireq}</i></td>
											<td class="target-width text-center">${qtr_target_totals[1] > 0 ? (qtr_target_totals[1]+" "+quarter_target):""}</td>
											<td class="target-width text-center">${qtr_target_totals[2] > 0 ? (qtr_target_totals[2]+" "+quarter_target):""}</td>
											<td class="target-width text-center">${qtr_target_totals[3] > 0 ? (qtr_target_totals[3]+" "+quarter_target):""}</td>
											<td class="target-width text-center">${qtr_target_totals[4] > 0 ? (qtr_target_totals[4]+" "+quarter_target):""}</td>
											<td class="total-width text-center">${req_total_targets > 0 ? (req_total_targets+" "+quarter_target):""}</td>
											<td class="budget-width">${item_requirement.total}</td>
											<td class="chargeability-width">${poe.category_class.fund_chargeability.accronym}</td>
											<td class="climate-width"></td>
										</tr>`;
									}
									rows += `<tr>
										<td class="priority-width" style="background: yellow">${poe.service_region.accronym}</td>
										<td colspan="5" style="padding-left: 4rem;">${i+1}.${x+1}. ${subpap.subpap_txt || subpap.suggested_sub_pap.subpaps}</td>
										<td class="total-width text-center"><strong>${total_targets > 0 ? (total_targets+" "+quarter_target):""}</strong></td>
									</tr>`;
									rows += item_req_rows;
								}
							}
						}

						table.innerHTML=rows;
					}
					else{
						table.innerHTML='<tr><td colspan="10" class="text-center">Empty</td></tr>';
					}

				}
			});
		}
    </script>
    @endsection
</x-app-layout>
