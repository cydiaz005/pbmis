<x-app-layout>
    @section('style')
	<style>
		.formname {
			color: var(--ocd-primary);
		}
		ul{
			display: flex;
			widows: 50rem !important;
			margin: 0;
			padding: 0;
			position: relative;
		}
		ul.header > li{
			border: 1px solid #5f5f5f;
			padding: 1rem;
			text-align: center;
			word-break: break-word!important;
			word-wrap: break-word!important;
			font-weight: bold;
		}
		ul.cell > li{
			border: 1px solid #5f5f5f;
			border-top: none;
		}
		li{
			list-style: none;
		}
		td > input, td > select, td > span{
			width: 100%;
			border: none;
			outline: none;
			text-align: center;
		}
		li > span{
			text-align: center;
			display: block;
		}
		li > input:focus,  li > select:focus{
			width: 100%;
			outline: none;
		}
		.code-width{
			min-width: 13rem;
			max-width: 13rem;
		}

		.item-req-width{
			min-width:13rem;
			max-width: 13rem;
		}
		.unit-width{
			min-width: 5rem;
			max-width: 5rem;
		}
		.cost-width{
			min-width: 8rem;
			max-width: 8rem;
		}
		.quantity-width{
			min-width: 5rem;
			max-width: 5rem;
		}
		.num-days-width{
				min-width: 5rem;
				max-width: 5rem;
		}
		.total-width{
			min-width: 7rem;
				max-width: 7rem;
		}
		.month-width{
			min-width: 7rem;
				max-width: 7rem;
		}
		.allot-class-width {
				min-width: 7rem;
				max-width: 7rem;
		}
		.procurement-width {
				min-width: 10rem;
				max-width: 10rem;
		}
		.circle{
			border-radius: 50%;
			height: 1.2rem;
			width: 1.2rem;
			position: absolute;
			right: -2rem;
		}
		.div-table {
			display: table;
			width: 700px !important;
			background-color: #eee;
			border: 1px solid #666666;
			border-spacing: 5px; /* cellspacing:poor IE support for  this */
		}
		.div-table-row {
			display: table-row;
			width: auto;
			clear: both;
		}
		.div-table-col {
			float: left; /* fix for  buggy browsers */
			display: table-column;
			background-color: #ccc;
		}
		.div-table-col.w-id{
			width: 5rem;
		}
		.div-table-col.w-name{
			width: 10rem;
		}
		.div-table-col.w-email{
			width: 8rem;
		}
		.grid-container {
			display: grid;
			grid-template-columns: auto auto auto auto;
			border: 1px solid lightgray;
			border-radius:

		}
		.grid-item {
			background-color: rgba(255, 255, 255, 0.8);
			border: 1px solid lightgray;
			padding: 7px;
			font-size: 12px;
			text-align: center;
			cursor: pointer;

		}
		.card.item-requirement-con {
			background-color: #EBECF0;
		}
		.card.item-requirement-con .card-body .form-control {
			border: 1px solid #CED4DA;
			font-size: 14px;
		}
		.card.item-requirement-con .card-body .form-group:first-child .form-control{
			height: 40px;
		}
		.card.item-requirement-con .card-body .form-group textarea{
			height: 60px;
		}
		label[for="month-selection"] {
			font-size: 14px;
			color: gray;
		}
		.papbtn-con a {
			font-size: 13px;
			padding: 6px 15px;
			color: #FFF;
		}
		.paptbl-con {
			height: 40rem;
		}
		.paptbl-con table thead td {
			font-weight: 700;
		}

		.paptbl-con table td {
			padding: 7px !important;
			vertical-align: middle;
			font-size: 13px;
		}
		.dropdown-menu a {
			font-size: 0.9rem;
			margin-bottom: 0.3rem;
			padding: 0.4rem 0.9rem;

		}
		.dropdown-menu a:first-child, .dropdown-menu a:last-child {
			line-height: 1.1;

		}
		.main-label {
			font-size: 17px;
		}
		.sub-label {
			color: #808080;
			margin-left: 1.15rem;

		}
		.dropdown-item:focus, .dropdown-item:hover{
			border-left: 2px solid var(--ocd-secondary);
			background-color: #F2F2F2;
			margin-left: -2px;
		}
		.dropdown-menu.show {
			min-width: 15rem;
		}
		hr {
			margin: 0.4rem 0.9rem;
		}
		.pap-tbl-con {
			min-height: 600px;
		}
		.no-data-label {
			width: 300px;
			height: 100px;

			text-align: center;
			position: absolute;
			top: 0;
			bottom: 0;
			left: 0;
			right: 0;
			margin: auto;
		}
		.card-title {
			font-size: 16px;
		}
		.form-control.geographical-loc {
			font-size: 14px;
			height: 2.25rem;
		}
		.input-label {
			font-size: 13px;
			color: #808080;
			line-height: 0;
		}
		/* bootstrap */
		.bootstrap-select .dropdown-toggle .filter-option {
			border: 1px solid #CED4DA;
			border-radius: 3px;
			font-size: 14px;

		}
		.bootstrap-select.show-tick .dropdown-menu .selected span.check-mark {

		}
		.paptbl-con{
			overflow-x: auto;
		}
		.item-requirement-con .fa-times{
			position: absolute;
			top: 10px;
			right: 10px;
			cursor: pointer;
		}
		.item-requirement-con .fa-times:hover{
			color: var(--ocd-secondary);
		}
		.item-requirement-con{
			width: 0px;
			transition: width 0.2s ease-in;
			opacity: 0;
		}
		.table-con{
			width: 100%;
			max-height: 60rem;
			transition: width 0.2s ease-in;
		}
		.table-con.irc-toggle{
			width: calc(100% - 350px);
		}
		.item-requirement-con.toggle{
			opacity: 1;
			width: 350px;
		}
		.selected-month{
			background: #dd9761 !important;
			color: #ffffff !important;
		}
		.add-comment, .add-item-comment{
			display: none;
		}
			/* .show-item-requirement {
				left: 16%;
				width: 25%;
				z-index: 2;
			}
			.paptbl-con::-webkit-scrollbar {
				width: 3px;
				height: 5px;
			}
			.paptbl-con::-webkit-scrollbar-track {
				box-shadow: inset 0 0 5px #f8f9fa;
				border-radius: 10px;
			}
			.paptbl-con::-webkit-scrollbar-thumb {
				background: #ececec;
				border-radius: 10px;
			} */
		.paptbl-con.active {
			background: rgba(255,255,255,0.3);
			cursor: grabbing;
			cursor: -webkit-grabbing;
			transform: scale(1);
  		}
		.paptbl-con table {
			position: relative;
			border-collapse: collapse; 
		}
		.paptbl-con table thead td {
			background-color: #1c20ab;
			color: #ffffff;
			position: sticky;
  			position: -webkit-sticky;
			z-index: 999;
			top: 0;
		}
		.cell.active {
			background-color: #1c20ab1a;
		}
		.paptbl-con::-webkit-scrollbar {
			width: 3px;
			height: 3px;
		}
		.paptbl-con::-webkit-scrollbar-thumb {
			background-color: #c1c1c1;
		}
	</style>
    @endsection
    @section('content')

    @livewire('partials.content-header', [
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
            ['name' => 'Forms', 'route' => '#'],
            ['name' => 'PPMP Form', 'route' => '#'],
        ],
        'pageTitle' => 'Project Procurement Management Plan (PPMP)',

    ])
	<div class="mb-2">
		<button id="export-excel" class="btn btn-success btn-sm">Export Excel</button>
		<button id="export-pdf" class="btn btn-danger btn-sm">Export PDF</button>
	</div>
	<div class="card card-primary card-outline card-outline-tabs" style="border-top: none">
		@if (@$ppmp->status_id == 3 || @$ppmp->status_id == 4)
		<div class="card-header p-0 border-bottom-0" style="background-color: #f4f6f9">
			<ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-tabContent" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">PPMP</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="custom-tabs-four-profile-tab" href="{{route('edit-poe', ['id' => $ppmp->poe->id])}}" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">POE</a>
				</li>
			</ul>
		</div>
		@endif
		<div class="card-body p-0">
			<div class="tab-content" id="custom-tabs-four-tabContent">
				<div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
					<div class="createpoe-container row mx-0">
						<div class="card card-default item-requirement-con" id="itemrequire-fields">
						   <div class="card-header" style="border-bottom: 0; padding: 0.5rem;">
							  <h3 class="card-title">Comments</h3><br>
							  <i class="fas fa-times"></i>
						   </div>
						   <div class="card-body" style="padding: 0.5rem;">

						   </div>
						</div>
						<div class="table-con">
							<div class="card-header" style="border-bottom: 0;">
								<div class="d-flex justify-content-between mb-2">
									<div class="pap-con col-md-4">
										<h3 class="card-title">PAP: {{(@$ppmp->poe->pap_txt) ?: $ppmp->poe->suggestedPap->paps}}</h3>
									</div>
									<div class="total-budget-con col-md-4">
										<p class="card-title total-budget">Total Budget: <span id="total-pap-budget"></span></p>
									</div>
									<div class="d-flex justify-end papbtn-con  col-md-4">
										<a class="nav-link ml-2 text-dark" id="toggle-fullscreen" href="#" role="button">
											<i class="fas fa-expand-arrows-alt"></i>
										</a>
									</div>
								</div>
								<div class="row mx-0 mb-3">
									<div class="pap-con col-md-4">
										<h3 class="card-title">MFO: {{@$ppmp->poe->mfo->desc}}</h3>
									</div>
									<div class="pap-con col-md-4">
										<h3 class="card-title">KDP: {{@$ppmp->poe->kdp->desc}}</h3>
									</div>
								</div>
								<div class="row m-0">
									<div class="form-group col-md-4">
										@php
											$pt=[];
											$p = $ppmp->poe->poeTags;
											for ($i=0; $i < count($p); $i++) {
												array_push($pt,$p[$i]->papTag->tag);
											}
										@endphp
										<label class="input-label" for="form_related">Form Related</label><br>
										<h3 class="card-title">{{count($pt) ? implode(", ",$pt):"None"}}</h3>
									</div>

									<div class="form-group  col-md-4">
										@php
											$ts=[];
											$r = $ppmp->poe->targetSectors;
											for ($i=0; $i < count($r); $i++) {
												array_push($ts,$r[$i]->targetSector->sector);
											}
										@endphp
										<label class="input-label" for="target_sector">Target Sector (Read Only)</label><br>
										<h3 class="card-title">{{count($ts) ? implode(", ",$ts):"None"}}</h3>
									</div>
									<div class="form-group  col-md-4">
										<label class="input-label" for="target_sector">Georaphical Location</label><br>
										<h3 class="card-title">Category Code: {{@$ppmp->poe->geolocation}}</h3>
									</div>
									<div class="form-group  col-md-4">
                                        {{-- <a id="dload">dload</a> --}}
										<h3 class="card-title">Category Code: {{@$ppmp->poe->category->category}}</h3>
									</div>
									<div class="form-group  col-md-4">
										<h3 class="card-title">Thematic Areas/Clusters: {{@$ppmp->poe->thematicAreaCluster->thematic_area_cluster}}</h3>
									</div>
									<div class="form-group  col-md-4">
										<h3 class="card-title">Service Region: {{@$ppmp->poe->serviceRegion->service_region}}</h3>
									</div>
								</div>
							</div>

						  	<div class="card-body  p-0">
							  <div class="m-3 paptbl-con">
								  <div class="no-data-label">
									  {{-- <p class="main-label">No Data Available</p> --}}
									  <small class="sub-label">Loading....</small>
								  </div>
								  <table class="table table-bordered text-center align-content-center pap-tbl" id="con_el">
								  </table>
							  </div>
							</div>
					  	</div>
				  	</div>
				</div>
				<div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">

				</div>
			</div>
		</div>
		<!-- /.card -->
	</div>

    @endsection

    @section('script')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>
	<script src="{{asset('js/xlsx-export/xlsx.full.min.js')}}"></script>
    <script src="{{asset('js/xlsx-export/xlsx.bundle.js')}}"></script>
	<script src="{{asset('js/poe.js')}}"></script>
    <script>
		console.log("ppmp",@json($ppmp));
		$('.selectpicker').selectpicker();
		let source_id = 1;
		const base_code = "SUBPAP ";
		let subpaps = {};
		let ul_total;
		let totalSupPap;
		const options = {
			minimumFractionDigits: 2,
			maximumFractionDigits: 2
		};

		function SubPap(el, subpapdata) {
			const container = document.querySelector(el);
			const subpap_id = source_id;
			const SUB_PAP_CODE = base_code + subpap_id;
			const monthStartIndex = 5;
			let disabledMonthSelection = true;
			document.querySelector('.no-data-label').style.display="none";
			let contents = [];
			let selectedMonths = [];
			let contents_source_id = 1;
			let monthsTotal={};
			let subpap_months_added={};
			let subpap_months_added_count={};
			const expense_class = [
				"",
				"PS",
				"MOOE",
				"CO",
			];
			const codes = [
				"",
				"123001",
				"543002",
				"513003",
				"503004",
				"500015",
			];
			const units = [
				"",
				"set",
				"pax"
			];
			function toInt(num){
				num = num.toString();
				num = num.replace(/,/g, '');
				num = num.replace(/[a-z]/gi, '');
				num = parseFloat(num) || 0;
				return num;
			}
			let formatter = function(num){
				if(this.value){
					this.value = Number(toInt(this.value)).toLocaleString('en', options);
					document.querySelector('#item-req-con-total').innerHTML = computeTotal();
				}
				else{
					return Number(toInt(num)).toLocaleString('en', options);
				}
			}
			let createElement = function (el, className, innerHTML) {
				let element = document.createElement(el);
				if(className)
				element.className = className;
				if (innerHTML)
				element.innerHTML = innerHTML;
				return element;
			}

			const totalEl = createElement('span', "font-weight-bold");
			let subPAPname = createElement('span', 'font-weight-bold');
			subPAPname.innerHTML = subpapdata.name;
			const table = createElement("table", "");
			const ul_header_tr = createElement("tr", "header");
			const ul_header = createElement("thead", "header");
			ul_header.append(ul_header_tr);
			const mainDiv = createElement("tbody", "");
			const subpap_header_tr = createElement('tr', "cell");

			let SubPapApi = (function () {
				function SubPapApi(source_id, data, cell) {
					this.data = data;
					this.source_id = source_id;
					this.cell = cell;
				}
				SubPapApi.prototype.getData = function () {
					return {
						item_account_code: this.data.item_account_code,
						item_account_code_id: this.data.item_account_code_id,
						item_requirement: this.data.item_requirement,
						item_procurement_mode: this.data.item_procurement_mode,
						item_unit: this.data.item_unit,
						item_cost: this.data.item_cost,
						item_qty_pax: toInt(this.data.item_qty_pax),
						item_days: toInt(this.data.item_days),
						item_months: this.data.item_months,
					}
				}
				SubPapApi.prototype.getTotal = function () {
					return this.data.total.innerHTML;
				}
				SubPapApi.prototype.update = function (data) {
					for (const key in data) {
						this.data[key] = data[key];
					}
				}
				SubPapApi.prototype.remove = function () {
					this.cell.remove();
					delete contents[this.source_id];
				}
				return SubPapApi;
			}());
			let generateCell = function (ul_cell,
				classes = ["code-width", "item-req-width", "procurement-width", "total-width", "procurement-width"]
			) {
				for (let i = 0; i < classes.length; i++) {
					let li = createElement('td', classes[i]);
					ul_cell.append(li);
				}
				for (let i = 0; i < 12; i++) {
					let li = createElement('td');
					ul_cell.append(li);
				}
			}
			let generateHeaders = function () {
				generateCell(ul_header_tr);
				const data = [
					// "Action",
					"Code/No.",
					"General Description",
					"Quantity/Size",
					"Estimated Budget",
					"Procurement Mode",
					"Jan",
					"Feb",
					"Mar",
					"Apr",
					"May",
					"Jun",
					"Jul",
					"Aug",
					"Sep",
					"Oct",
					"Nov",
					"Dec",
				];
				const cells = ul_header_tr.children;
				for (let i = 0; i < data.length; i++) {
					if (data[i] != undefined) {
						cells[i].append(data[i]);
					}
				}
			}
			let generateSubpapHeader = function () {
				generateCell(subpap_header_tr, 
					["code-width", "item-req-width", "total-width", "procurement-width"]
				);
				const cells = subpap_header_tr.children;
				const select = createElement('select', "");
				const data = [
					// addContent,
					SUB_PAP_CODE,
					subPAPname,
					totalEl,
				];
				for (let i = 0; i < cells.length; i++) {
					if (data[i]) {
						cells[i].append(data[i]);
					}
				}
				cells[1].colSpan="2";
				mainDiv.appendChild(subpap_header_tr);
			}
			let generateTotal = function () {
				ul_total = createElement("tfoot", "header");
				let ul_total_tr = createElement("tr", "header");
				ul_total.append(ul_total_tr);
				ul_total.classList.add('font-weight-bold');
				generateCell(ul_total_tr);
				totalSupPap = createElement('span', "", "-");
				const data = [
					// "",
					"",
					"Total",
					"",
					totalSupPap
				];
				const cells = ul_total_tr.children;
				for (let i = 0; i < data.length; i++) {
					if (data[i] != undefined) {
						cells[i].append(data[i]);
					}
				}
				for (let i = monthStartIndex; i < (monthStartIndex + 12); i++) {
					let span = createElement('span', 'text-center');
					span.id='month-total-'+((i-monthStartIndex)+1);
					cells[i].append(span);
				}
				container.appendChild(ul_total)
			}
			function computeSubPapTotal() {
				let sum = 0;
				for (const key in contents) {
					let a = parseFloat(contents[key].getTotal().replace(/,/g, ''));
					sum += parseFloat(a) || 0;
				}
				if (!isNaN(sum)) {
					totalEl.innerHTML = Number(sum).toLocaleString('en', options);
				}
				computeSubPapTotalTotalan();
			}
			function computeSubPapTotalTotalan() {
				let total = 0;
				for (const key in subpaps) {
					const subpap = subpaps[key];
					if (!isNaN(subpap.getTotal())) {
						total += subpap.getTotal();
					}
					if (!isNaN(total)) {
						totalSupPap.innerHTML = Number(total).toLocaleString('en', options);
						document.querySelector('#total-pap-budget').innerHTML = Number(total).toLocaleString('en', options);
					}
				}
			}
			function generateSubPapContent(data, tr) {
				const ul_cell = createElement('tr', "cell");
				generateCell(ul_cell);

				let total = createElement('span', '', data.item_total);
				let dropdown = '';
				dropdown += '<button class="btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-ellipsis-h fa-sm"></i></button>'
				dropdown += '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">'
				dropdown += '<a class="dropdown-item insert-item" href="#"><i class="fas fa-plus"></i>&nbsp;&nbsp;Insert item requirement<br><small class="sub-label">Click to insert new item requirement</small></a><hr>'
				dropdown += '<a class="dropdown-item edit-item" href="#"><i class="fas fa-edit"></i>&nbsp;&nbsp;Edit</a>'
				dropdown += '<a class="dropdown-item delete-item" href="#"><i class="fas fa-trash"></i>&nbsp;&nbsp;Delete</a>'
				dropdown += '<hr><a class="dropdown-item add-item-comment" href="#"><i class="fas fa-comment-alt"></i>&nbsp;&nbsp;Comment<br><small class="sub-label">Click to view comment section</small></a>'
				dropdown += '</div>';
				const actionDropdown = createElement("div", "dropdown");
				actionDropdown.innerHTML = dropdown;
				let insert_item = actionDropdown.querySelector('.insert-item');
				let edit_subpap = actionDropdown.querySelector('.edit-item');
				let delete_subpap = actionDropdown.querySelector('.delete-item');
				let add_comment = actionDropdown.querySelector('.add-item-comment');

				let setData = function(data){
					let cellData = [
						// actionDropdown,
						data.item_account_code,
						data.item_requirement,
						data.item_qty_pax+" "+data.item_unit+" x "+data.item_days+" days",
						total,
						data.item_procurement_mode_text,
					];
					let cells = ul_cell.children;
					for (let i = 0; i < cells.length; i++) {
						cells[i].innerHTML="";
						if (cellData[i]) {
							cells[i].append(cellData[i]);
						}
					}
					for (let index = 0; index < data.item_months.length; index++) {
						const element = data.item_months[index];
						let val = formatter(element.amount);
						let div = createElement('div', 'text-center');
						div.appendChild(createElement('div', 'font-weight-bold text-truncate', element.qty+' '+'<span class="item-req-t-name">'+subpapdata.target_name+'</span>'));
						div.appendChild(createElement('div', '', val));
						cells[(element.month-1) + monthStartIndex].append(div);
						cells[(element.month-1) + monthStartIndex].style.backgroundColor="#ffff138c";
						cells[(element.month-1) + monthStartIndex].style.maxWidth="7rem";
						addMonthTotal((element.month), toInt(val));
					}
				}
				setData(data);
				if(tr){
					mainDiv.insertBefore(ul_cell, tr)
				}
				else{
					mainDiv.appendChild(ul_cell);
				}
				data['total'] = total;
				const subPapApi = new SubPapApi(contents_source_id, data, ul_cell);
				contents[contents_source_id] = subPapApi;
				contents_source_id++;
				computeSubPapTotal();
			}
			function computeTotal(qty, cost, days) {
				let c = toInt(qty) || 1;
				let q = toInt(cost) || 1;
				let d = toInt(days) || 1;
				let t = c * q * d;
				if (!isNaN(t)) {
					return Number(t).toLocaleString('en', options);;
				}
			}
			function getItemData(){
				error=false;
				let data = {
					item_account_code: item_account_code.value,
					item_account_code_id: ac.getSelected(),
					item_requirement: item_requirement.value,
					item_procurement_mode: item_procurement_mode.value,
					item_procurement_mode_text: document.querySelector('#item_procurement_mode').selectedOptions[0].innerHTML,
					item_unit: item_unit.value,
					item_cost: item_cost.value,
					item_qty_pax: item_qty_pax.value,
					item_days: item_days.value,
					item_total: 0,
					item_months: [],
					item_selected_months: [...selectedMonths],
					item_selected_months_values: [],
				}
				data.item_total = computeTotal();
				let totalMonthValues = 0
				for (let index = 0; index < selectedMonths.length; index++) {
					const element = selectedMonths[index];
					let val = (toInt(item_month_values.children[element].querySelector('input').value) || 0);
					totalMonthValues += val;
					data.item_selected_months_values.push(val);
					data.item_months.push({
						month: parseInt(element) + 1,
						amount: val,
					});
				}
				let errElement = document.querySelector('#total-error');

				if(toInt(data.item_total) != toInt(totalMonthValues)){
					let val = formatter(toInt(data.item_total) - toInt(totalMonthValues));
					errElement.innerHTML='Total did not match. ('+val+')';
					return false;
				}
				check_error(data.item_account_code, "Account code not set");
				check_error(data.item_requirement, "Item requirement not set");
				check_error(data.item_procurement_mode, "Item procurement mode not set");
				check_error(data.item_cost, "Item cost not set");
				check_error(data.item_unit, "Item unit not set");
				check_error(data.item_qty_pax, "Item quantity not set");
				check_error(data.item_days, "Item number of days not set");

				if(error){
					return false;
				}
				errElement.innerHTML='';
				return data;
			}
			function addMonthTotal(m, a, subtract = false){
				let totalMonth = document.querySelector('#month-total-'+m);
				let aa = toInt(totalMonth.innerHTML);
				let val = 0;
				if(subtract){
					val = aa - a;
				}
				else{
					val = aa + a;
				}

				if(val <= 0){
					totalMonth.innerHTML = "";
				}
				else{
					totalMonth.innerHTML = formatter(val);
				}

				if(!subpap_months_added_count[m]){
					subpap_months_added_count[m] = 0;
				}

				if(subtract){
					subpap_months_added_count[m]--;
					let td = subpap_header_tr.children[(monthStartIndex - 1) + (toInt(m) - 1)];
					subpap_months_added[m] -= a;
					if(subpap_months_added[m] == 0){
						delete subpap_months_added[m];
						td.style='';
						td.innerHTML='';
					}
					else{
						td.innerHTML = formatter(subpap_months_added[m]);
					}
					// if(subpap_months_added_count[m] == 1){
					// 	td.style='';
					// 	td.innerHTML='';
					// }
				}
				else{
					let td = subpap_header_tr.children[(monthStartIndex - 1) + (toInt(m) - 1)];
					subpap_months_added_count[m]++;
					if(subpap_months_added[m]){
						subpap_months_added[m] += a;
					}
					else{
						// td.style.backgroundColor='#FFFF00';
						td.style.fontWeight='600';
						subpap_months_added[m] = a;
					}
					td.innerHTML = formatter(subpap_months_added[m]);
				}
			}
			this.getData = function () {
				let item_req_data = [];
				for (const key in contents) {
					item_req_data.push(contents[key].getData());
				}
				return {
					sub_pap_name: name,
					item_reqs: item_req_data,
				};
			}
			this.getTotal = function () {
				return parseFloat(totalEl.innerHTML.replace(/,/g, ''))
			}

			if (Object.keys(subpaps).length == 0) {
				container.appendChild(ul_header);
				generateHeaders();
				generateTotal();
			}
			generateSubpapHeader();
			container.insertBefore(mainDiv, ul_total);

			this.addItemRequirement=function(item_requirements){
				for (let i = 0; i < item_requirements.length; i++) {
					let item = item_requirements[i];
					let data = {
						item_account_code: item.chart_of_account.code+"-"+item.chart_of_account.expense_object,
						item_account_code_id: item.chart_of_account.id,
						item_requirement: item.itemreq_txt || item.suggested_item_requirement.ireq,
						item_procurement_mode: item.procurement_mode_id,
						item_procurement_mode_text: item.procurement_mode.title,
						item_unit: item.unit || item.suggested_unit.unit,
						item_cost: formatter(item.per_capita_cost),
						item_qty_pax: item.qty_pax,
						item_days: item.no_of_days,
						item_total: 0,
						item_months: item.item_months,
					}
					data.item_total = computeTotal(data.item_qty_pax, data.item_cost, data.item_days);
					generateSubPapContent(data);
				}
			}
			// draggable table
			let table_con = document.querySelector('.paptbl-con');
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
			})
		}	
		const poe_id = {{@$ppmp->poe->id}};
		getSubpaps(poe_id, function(res){
			console.log("subpaps",res);
			for (let i = 0; i < res.length; i++) {
				let subpap = new SubPap("#con_el", {
					name: res[i].subpap_txt || res[i].suggested_sub_pap.subpaps,
					subpap_quarter_target: res[i].quarter_target_id,
					target_name: res[i].quarter_target.quarter_target,
				});
				subpaps[source_id] = subpap;
				source_id++;
				subpap.addItemRequirement(res[i].item_requirements);
			}
		});
		document.querySelector("#export-excel").onclick=function(){
			let _this = this;
			_this.innerHTML='Exporting...';
			exportPpmp(@json($ppmp->poe_id), @json(@$ppmp->poe), function(){
				_this.innerHTML='Export Excel';
			});
		}
		document.querySelector("#export-pdf").onclick=function(){
			let _this = this;
			_this.innerHTML='Exporting...';
			exportPpmpPDF(@json(@$ppmp), function(){
				_this.innerHTML='Export PDF';
			});
		}
		$('#toggle-fullscreen').on('click', function(){
			if (
				document.fullscreenElement ||
				document.webkitFullscreenElement ||
				document.mozFullScreenElement ||
				document.msFullscreenElement
			) {
				if (document.exitFullscreen) {
				document.exitFullscreen();
				} else if (document.mozCancelFullScreen) {
				document.mozCancelFullScreen();
				} else if (document.webkitExitFullscreen) {
				document.webkitExitFullscreen();
				} else if (document.msExitFullscreen) {
				document.msExitFullscreen();
				}
			} else {
				element = $('.createpoe-container').get(0);
				if (element.requestFullscreen) {
				element.requestFullscreen();
				} else if (element.mozRequestFullScreen) {
				element.mozRequestFullScreen();
				} else if (element.webkitRequestFullscreen) {
				element.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
				} else if (element.msRequestFullscreen) {
				element.msRequestFullscreen();
				}
			}
			
		});

      </script>
	  <script>
        $("#li_forms").addClass('menu-open');
        $("#li_forms>a.li_parent").addClass('active');
        $("#li_ppmpform").addClass('active');
	</script>
    @endsection
</x-app-layout>
