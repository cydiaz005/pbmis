<x-app-layout>
    @section('style')
  <style>
		.full-screen-icon{
			position: absolute;
			right: 0;
			top:0;
		}
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
			height: 94%;
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
		.table-con{
			width: 100%;
			max-height: 60rem;
			transition: width 0.2s ease-in;
		}
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
            ['name' => 'POE Form', 'route' => '#'],
        ],
        'pageTitle' => 'PROGRAM OF EXPENDITURES (POE)',
        
    ])
	<div class="mb-2">
		<button id="export-excel" class="btn btn-success btn-sm">Export Excel</button>
		<button id="export-pdf" class="btn btn-danger btn-sm">Export PDF</button>
	</div>
   	<div class="createpoe-container row mx-0">
      	<div class="card card-default item-requirement-con" id="itemrequire-fields" style="word-wrap: unset">
         	<div class="card-header" style="border-bottom: 0; padding: 0.5rem;">
            	<h3 class="card-title">Create item requirement</h3><br>
				<i class="fas fa-times"></i>
         	</div>
         	<div class="card-body" style="padding: 0.5rem;">
			 	<div class="form-group">
					<input class="form-control" id="item_subpap_title" placeholder="Subpap code">
            	</div>
				<div class="form-group">
					<textarea class="form-control"  rows="3" placeholder="Account code" id="item_account_code"></textarea>
				</div>
				<div class="form-group">
					<textarea class="form-control" id="item_requirement" rows="3" placeholder="Enter item requirement"></textarea>
				</div>
				<div class="form-group">
					<select id="item_procurement_mode" class="form-select appearance-none border rounded w-full pl-2 pr-3" style="height: 40px; color: gray;">
						<option value="" disabled selected hidden>Select procurement mode</option>
						@foreach ($procurement_modes as $procurement_mode)
							<option data-id="{{$procurement_mode->id}}" value="{{$procurement_mode->id}}">{{$procurement_mode->title}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<input  id="item_unit" class="form-control"  placeholder="Unit">
				</div>
				<div class="form-group">
					<input id="item_cost" class="form-control"  placeholder="Per capita cost">
				</div>
				<div class="form-group row">
					<div class="col-md-6">
						<input  id="item_qty_pax" class="form-control"  placeholder="Qty/pax">
					</div>
					<div class="col-md-6">
						<input  id="item_days" class="form-control" placeholder="No. of days">
					</div>
            	</div>
				<div class="form-group fa-sm">
					Total: <span id="item-req-con-total">0</span>
				</div>
				<label for="month-selection">Select Month</label>
				<div class="form-group grid-container" id="item_months">
					<div class="grid-item">Jan</div>
					<div class="grid-item">Feb</div>
					<div class="grid-item">Mar</div>  
					<div class="grid-item">Apr</div>
					<div class="grid-item">May</div>
					<div class="grid-item">Jun</div>  
					<div class="grid-item">Jul</div>
					<div class="grid-item">Aug</div>
					<div class="grid-item">Sep</div>  
					<div class="grid-item">Oct</div>
					<div class="grid-item">Nov</div>
					<div class="grid-item">Dec</div>
				</div>
				<div>
					<small class="text-danger" id="total-error"></small>
				</div>
				<div class="form-group">
					<div class="form-group row mx-0" id="item_month_values">
						<div class="col-md-6 form-group" style="display: none">
							<input type="text" class="form-control" placeholder="January">
						</div>
						<div class="col-md-6 form-group" style="display: none">
							<input type="text" class="form-control" placeholder="February">
						</div>
						<div class="col-md-6 form-group" style="display: none">
							<input type="text" class="form-control" placeholder="March">
						</div>
						<div class="col-md-6 form-group" style="display: none">
							<input type="text" class="form-control" placeholder="April">
						</div>
						<div class="col-md-6 form-group" style="display: none">
							<input type="text" class="form-control" placeholder="May">
						</div>
						<div class="col-md-6 form-group" style="display: none">
							<input type="text" class="form-control" placeholder="June">
						</div>
						<div class="col-md-6 form-group" style="display: none">
							<input type="text" class="form-control" placeholder="July">
						</div>
						<div class="col-md-6 form-group" style="display: none">
							<input type="text" class="form-control" placeholder="August">
						</div>
						<div class="col-md-6 form-group" style="display: none">
							<input type="text" class="form-control" placeholder="September">
						</div>
						<div class="col-md-6 form-group" style="display: none">
							<input type="text" class="form-control" placeholder="October">
						</div>
						<div class="col-md-6 form-group" style="display: none">
							<input type="text" class="form-control" placeholder="November">
						</div>
						<div class="col-md-6 form-group" style="display: none">
							<input type="text" class="form-control" placeholder="December">
						</div>
					</div>
				</div>
				<div class="form-group">
					<a type="button" class="btn btn-primary btn-sm btn-block" id="add-item-requirement">Add</a>
				</div>
         	</div> 
      	</div>
		<div class="card card-default table-con">
			<div class="card-header" style="border-bottom: 0;">
				<div class="d-flex justify-content-between mb-2">
					<div class="pap-con col-md-4">
						<h3 class="card-title">PAP: {{(@$poe->pap_txt) ?: $poe->suggestedPap->paps}}</h3>
					</div>
					<div class="total-budget-con col-md-4">
						<p class="card-title total-budget">Total Budget: <span id="total-pap-budget"></span></p>
					</div>
					<div class="papbtn-con  col-md-4">
						<div class="pr-3">
							<h3 class="card-title">Creator: {{$poe->creator->firstname}} {{$poe->creator->middlename ? $poe->creator->middlename." ".$poe->creator->lastname:$poe->creator->lastname}}</h3>
						</div>
						<a class="nav-link ml-2 text-dark full-screen-icon" id="toggle-fullscreen" href="#" role="button">
							<i class="fas fa-expand-arrows-alt"></i>
						</a>
					</div>
				</div>
				<div class="row mx-0 mb-3">
					<div class="pap-con col-md-4">
						<h3 class="card-title">MFO: {{@$poe->mfo->desc}}</h3>
					</div>
					<div class="pap-con col-md-4">
						<h3 class="card-title">KDP: {{@$poe->kdp->desc}}</h3>
					</div>
				</div>
				<div class="row m-0">
					<div class="form-group col-md-4">
						@php
							$pt=[];
							$p = $poe->poeTags;
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
							$r = $poe->targetSectors;
							for ($i=0; $i < count($r); $i++) { 
								array_push($ts,$r[$i]->targetSector->sector);
							}
						@endphp
						<label class="input-label" for="target_sector">Target Sector</label><br>
						<h3 class="card-title">{{count($ts) ? implode(", ",$ts):"None"}}</h3>
					</div>
					<div class="form-group  col-md-4">
						<label class="input-label" for="target_sector">Georaphical Location</label><br>
						<h3 class="card-title">{{@$poe->geolocation}}</h3>
					</div>
					<div class="form-group  col-md-4">
						<h3 class="card-title">Category Code: {{@$poe->category->category}}</h3>
					</div>
					<div class="form-group  col-md-4">
						<h3 class="card-title">Thematic Areas/Clusters: {{@$poe->thematicAreaCluster->thematic_area_cluster}}</h3>
					</div>
					<div class="form-group  col-md-4">
						<h3 class="card-title">Service Region: {{@$poe->serviceRegion->service_region}}</h3>
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
						<!-- POE REPORT VIEW CONTENT -->
					</table>
				</div>
			</div>
		
		</div>
    </div>
    @endsection
    
    @section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>
	<script src="{{asset('js/xlsx-export/xlsx.full.min.js')}}"></script>
    <script src="{{asset('js/xlsx-export/xlsx.bundle.js')}}"></script>
	<script src="{{asset('js/poe.js')}}"></script>
    <script>
		$('.selectpicker').selectpicker();
		let source_id = 1;
		console.log("poe->poeTags",@json($poe->poeTags));
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
			const monthStartIndex = 8;
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
				"pax",
			];
			// let toInt = function(num){
			// 	num = num.toString();
			// 	num = num.replace(/[^\d.-]+/g,'');
			// 	num = parseInt(num) || 0;
			// 	return num;
			// }
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
			let item_months = document.querySelector('#item_months');
			let item_month_values = document.querySelector('#item_month_values');
			let item_account_code = document.querySelector('#item_account_code');
			let item_requirement = document.querySelector('#item_requirement');
			let item_procurement_mode = document.querySelector('#item_procurement_mode');
			let item_unit = document.querySelector('#item_unit');
			let item_cost = document.querySelector('#item_cost');
			let item_qty_pax = document.querySelector('#item_qty_pax');
			let item_days = document.querySelector('#item_days');
			item_cost.onchange=formatter;
			item_qty_pax.onchange=formatter;
			item_days.onchange=formatter;

			let init_month_selection = function(){	
				for (let i = 0; i < item_months.children.length; i++) {
					const element = item_months.children[i];
					element.classList.remove('d-none');
					element.onclick = function(){
						// if(disabledMonthSelection){return}
						if(selectedMonths.includes(i)){
							selectedMonths.splice(selectedMonths.indexOf(i), 1);
							element.classList.remove('selected-month');
							item_month_values.children[i].style.display="none";
						}
						else{
							selectedMonths.push(i);
							element.classList.add('selected-month');
							item_month_values.children[i].style="";
						}
					}
					item_month_values.children[i].getElementsByTagName('input')[1].onchange=formatter;
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
			let resetItemRequirement = function(){
				item_account_code.value='';
				item_requirement.value='';
				item_procurement_mode.value='';
				item_unit.value='';
				item_cost.value='';
				item_qty_pax.value='';
				item_days.value='';
				document.querySelector('#total-error').innerHTML='';
				document.querySelector('#item-req-con-total').innerHTML = 0;
				document.querySelector('#add-item-requirement').innerHTML="Add";
				for (let index = 0; index < selectedMonths.length; index++) {
					const element = selectedMonths[index];
					item_months.children[element].classList.remove('selected-month');
					item_month_values.children[element].style.display='none';
					item_month_values.children[element].getElementsByTagName('input')[0].value='';
					item_month_values.children[element].getElementsByTagName('input')[1].value='';
				}
				selectedMonths=[];
				disabledMonthSelection = true;
			}
			let createNewItemRequirement = function () {
				resetItemRequirement();
				if(item_category_code.value ==''){
					toastr.error('Category code not set');
					return;
				}
				init_month_selection();
				document.querySelector('.item-requirement-con').classList.add('toggle');
				document.querySelector('.table-con').classList.add('irc-toggle');
				document.querySelector('#item_subpap_title').value=subpapdata.name;

				document.querySelector('#add-item-requirement').onclick=function(){
					let data = getItemData();
					if(data){
						generateSubPapContent(data);
						resetItemRequirement();
					}
				}
			}
			const totalEl = createElement('span', "font-weight-bold");
			let subPAPname = createElement('span', 'font-weight-bold');
			subPAPname.innerHTML = subpapdata.name;
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
						item_cost: toInt(this.data.item_cost),
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
				classes = ["code-width", "item-req-width", "procurement-width", "unit-width", "cost-width", "quantity-width", "num-days-width", "total-width"]
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
					"Code/No.",
					"Item Requirements",
					"Procurement Mode",
					"Unit",
					"Per Capita Cost",
					"Qty/Pax",
					"No. of Days",
					"Total",
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
					classes = ["code-width", "item-req-width", "total-width"]
				);
				const cells = subpap_header_tr.children;
				const select = createElement('select', "");
				const val = [
					SUB_PAP_CODE,
					subPAPname,
					totalEl,
				];
				for (let i = 0; i < cells.length; i++) {
					if (val[i]) {
						cells[i].append(val[i]);
					}
				}
				cells[1].colSpan="6";
				mainDiv.appendChild(subpap_header_tr);
			}
			let generateTotal = function () {
				ul_total = createElement("tfoot", "header");
				let ul_total_tr = createElement("tr", "header");
				ul_total.append(ul_total_tr);
				generateCell(ul_total_tr);
				totalSupPap = createElement('span', "", "-");
				const data = [
					"",
					"Total",
					"",
					"",
					"",
					"",
					"",
					totalSupPap,
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
				let prev_item_months = [...data.item_months];

				let setData = function(data, forUpdate=false){
					let cellData = [
						data.item_account_code,
						data.item_requirement,
						data.item_procurement_mode_text,
						data.item_unit,
						formatter(data.item_cost),
						data.item_qty_pax,
						data.item_days,
						total,
						'',
					];
					let cells = ul_cell.children;
					for (let i = 0; i < cells.length; i++) {
						cells[i].innerHTML="";
						if (cellData[i]) {
							cells[i].append(cellData[i]);
						}
					}
					for (let index = 0; index < 12; index++) {
						cells[index + monthStartIndex].style='';
					}
					if(forUpdate){
						for (let index = 0; index < prev_item_months.length; index++) {
							const element = prev_item_months[index];
							addMonthTotal((element.month), element.amount, true);
						}
					}
					for (let index = 0; index < data.item_months.length; index++) {
						const element = data.item_months[index];
						let val = element.amount;
						let div = createElement('div', 'text-center');
						div.appendChild(createElement('div', 'font-weight-bold text-truncate', element.qty+' '+'<span class="item-req-t-name">'+subpapdata.target_name+'</span>'));
						div.appendChild(createElement('div', '', formatter(val)));
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
                let c,q,d;
                if(qty || cost || days){
                    c = toInt(cost) || 1;
                    q = toInt(qty) || 1;
                    d = toInt(days) || 1;
                }
                else{
                    if(item_cost.value==""&&item_qty_pax.value==""&&item_days.value==""){return 0}
                    c = toInt(item_cost.value) || 1;
                    q = toInt(item_qty_pax.value) || 1;
                    d = toInt(item_days.value) || 1;
                }
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
				}
				data.item_total = computeTotal();
				let totalMonthValues = 0
				for (let index = 0; index < selectedMonths.length; index++) {
					const element = selectedMonths[index];

					let val = (toInt(item_month_values.children[element].getElementsByTagName('input')[1].value) || 0);
					let qty = item_month_values.children[element].getElementsByTagName('input')[0].value;
					if(qty===undefined || qty < 0 || qty == ''){
						error = true;
						toastr.error('Qty for '+item_month_values.children[element].getElementsByTagName('input')[1].placeholder+' not set');
					}
					totalMonthValues += val;
					data.item_months.push({
						month: parseInt(element) + 1,
						amount: val,
						qty: qty,
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
				console.log("month-"+m,subpap_header_tr.children[(monthStartIndex - 5) + (toInt(m) - 1)]);
				if(subtract){
					subpap_months_added_count[m]--;
					let td = subpap_header_tr.children[(monthStartIndex - 5) + (toInt(m) - 1)];
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
					let td = subpap_header_tr.children[(monthStartIndex - 5) + (toInt(m) - 1)];
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
					sub_pap_name: subpapdata.name,
					item_reqs: item_req_data,
					subpap_quarter_target: subpapdata.subpap_quarter_target,
				};
			}
			this.getTotal = function () {
				return parseFloat(totalEl.innerHTML.replace(/,/g, ''))
			}
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
			if (Object.keys(subpaps).length == 0) {
				container.appendChild(ul_header);
				generateHeaders();
				generateTotal();
			}
			generateSubpapHeader();
			container.insertBefore(mainDiv, ul_total);

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
			});
		}
		
		const poe_id = {{@$poe->id}};

		getSubpaps(poe_id, function(res){
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

		document.querySelector("#export-excel").onclick=function(){
			let _this = this;
			_this.innerHTML='Exporting...';
			exportData('{{@$poe->id}}', @json(@$poe), function(){
				_this.innerHTML='Export Excel';
			});
		}
		document.querySelector("#export-pdf").onclick=function(){
			let _this = this;
			_this.innerHTML='Exporting...';
			exportPoePDF(@json(@$poe), function(){
				_this.innerHTML='Export PDF';
			});
		}
		
      </script>
	  <script>
        $("#li_forms").addClass('menu-open');
        $("#li_forms>a.li_parent").addClass('active');
        $("#li_poeform").addClass('active');
	</script>
    @endsection
</x-app-layout>
