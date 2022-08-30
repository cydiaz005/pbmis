<table id="ro-table" class="table table-bordered">
<thead>
</thead>
<tbody>
</tbody>
<tfoot>
</tfoot>
</table>


@section('fl-view-script')
<script>
		(function() {
			var data_entry = {};
			var central_office = [];
			var regional_office = [];
			var consolidated_office = [];
			var consolidated_budget = [];

			var tbl_central_office = $('#co-table');
            var tbl_offices = $('#ro-table');
            var tbl_fiscal = $('#fiscal-table');
            var filter_ro = $('.regional-office-filter');
            var filter_co = $('.central-office-filter');
            var table_count = 0;
			var visible_rows = {ro:[], co:[]}
			var categories = Object.values(JSON.parse('<?php echo json_encode($categories, JSON_FORCE_OBJECT) ?>'));
			var service_regions = Object.values(JSON.parse('<?php echo json_encode($service_regions, JSON_FORCE_OBJECT) ?>'));
			var fiscal_budget = {!! json_encode($fiscal_budget) !!};
            var regional_total = [];
			var year = "{{$year}}";
			var entry_rows = 0;


			console.log({fiscal_budget});
			const options = {
				minimumFractionDigits: 2,
				maximumFractionDigits: 2
			};

            let formatter = function(num){
				if(this.value){
					this.value = Number(toFloat(this.value)).toLocaleString('en', options);
					document.querySelector('#item-req-con-total').innerHTML = computeTotal();
				}
				else{
					return Number(toFloat(num)).toLocaleString('en', options);
				}
			}

			Object.keys(service_regions).map(function(key) {
				(service_regions[key].co == '1')?
				central_office.push(service_regions[key]):
				regional_office.push(service_regions[key])
			});


			buildTable(regional_office, tbl_offices);
			createSubTotal('ro',tbl_offices);

			buildTable(central_office, tbl_offices);
			createSRTotal(tbl_offices);

			createSubTotal('co',tbl_offices);

			createGrandTotal(tbl_offices);





			retain();
            function retain(){


				fiscal_budget['entries'].forEach(fb => {
					cat_id = "#cat-"+fb.cat_id;
					sr_id = "#sr-"+fb.serreg_id;
                    key = 'sr-id-'+fb.serreg_id;
                    if (!(key in consolidated_budget)){
                        consolidated_budget[key] = [];
                    }
                    consolidated_budget[key].push(fb.amount);
					$(sr_id).find(cat_id).html('PHP '+formatter(fb.amount));
				});

                Object.keys(consolidated_budget).forEach(key => {
                    let sub_total = 0;
                    consolidated_budget[key].forEach(budget => {
                        sub_total += budget;
                    });
                    regional_total[key] = sub_total;
                });


                Object.keys(regional_total).forEach(value => {
                    let id = "#"+value;
                    $(id).text("PHP "+formatter(regional_total[value]));
                });


			}

			function toFloat(num){
				num = num.toString();
				num = num.replace(/,/g, '');
				num = num.replace(/[a-z]/gi, '');
				num = parseFloat(num) || 0;
				return num;
			}

			function buildTable(offices, table) {
				let row;
				let allotment_class;
				let fund_chargeability;
				let fund_chargeability_class;
				(!table_count)?createHeading(table):0;
                 ++table_count;
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
				});

				tbl_fiscal.removeClass('d-none');
			}
			function createSRTotal(table) {
				const ids = $.map($('tbody > tr'), tr => tr.id);
				ids.forEach(id => {
					(id)? $('#'+id).append("<td id='reg_total'></td>"):false;
				});

				fiscal_budget['sr_total'].forEach(element => {
					let id = 'sr-'+element.serreg_id;
					(ids.includes(id))? $("#"+id+"> #reg_total").text("PHP "+formatter(element.total)):false;
					console.log(element);
				});


			}
			function createSubTotal(key, table){
				let entry_rows = 0;
				let sub_row = appendRowBody(table);
				let reference = (key == 'ro')? fiscal_budget['ro_subtotal']:fiscal_budget['co_subtotal'];
				let sum = (key == 'ro')? fiscal_budget['ro_subtotal_sum']:fiscal_budget['co_subtotal_sum'];

				sub_row.append('<td>SUB TOTAL</td>');

				let id = key+'-subtotal';
				sub_row.prop('id', id);
				categories.forEach(category => {
					let fclasses = category['fund_chargeability_class'];
					for (let index = 0; index < Object.keys(fclasses).length; index++) {
						sub_row.append('<td id="cat-'+fclasses[index]['id']+'"></td>');

					}
				});


				reference.forEach(budget => {
					$('#'+id).find('#cat-'+budget.cat_id).text("PHP "+formatter(budget.total));
				});
				sub_row.append('<td>PHP '+formatter(sum)+'</td>');


			}
			function createGrandTotal(table) {
				let sub_row = appendRowFooter(table);
				sub_row.append('<td>GRAND TOTAL</td>');


				let id = 'grand-total';
				sub_row.prop('id', id);
				categories.forEach(category => {
					let fclasses = category['fund_chargeability_class'];
					for (let index = 0; index < Object.keys(fclasses).length; index++) {
						sub_row.append('<td id="cat-'+fclasses[index]['id']+'"></td>');

					}
				});

				// fiscal_budget['cat_total'].forEach(budget => {
				// 	sub_row.append('<td>PHP '+formatter(budget.total)+'</td>');
				// });
				fiscal_budget['cat_total'].forEach(budget => {
					$('#'+id).find('#cat-'+budget.cat_id).text("PHP "+formatter(budget.total));
				});
				sub_row.append('<td>PHP '+formatter(fiscal_budget['overall_total'])+'</td>');


			}

			function createHeading(table){
				let row;

				row = appendRowHeading(table);
				thead(row, 'Offices', 1, 2).addClass('sticky-col office-column')
				Object.keys(categories).map(function(key) {
					allotment_class = categories[key].accronym;
					fund_chargeability_class = categories[key].fund_chargeability_class;
					thead(row, allotment_class, Object.values(fund_chargeability_class).length, 1);
				});

				thead(row, 'Total', 1, 2).addClass('sticky-col total-column');

				row = appendRowHeading(table);

				Object.keys(categories).map(function(key) {
					allotment_class = categories[key].accronym;
					fund_chargeability_class = categories[key].fund_chargeability_class;

					Object.values(fund_chargeability_class).forEach((sub_class, id) => {
						fund_chargeability = sub_class.fund_chargeability
						thead(row, fund_chargeability.accronym, 1, 1);
					});
				});

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
				row.append('<td id="cat-'+meta.ffc_id+'"></td>');
				const td = row.find('td').last();
				const key = "fcc-"+sub_class;
			}


			function getOfficeTotal(office){
				let sum = 0;
				const td = $('#'+office.toLowerCase()+'-total');
				Object.values(data_entry[office]).forEach(entries => {
					sum+=parseFloat(entries);
				});
			}
		})();
    </script>
@endsection
