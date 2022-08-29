<x-app-layout>
    @section('style')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .table-container{
            overflow-x: auto;
        }
        .table-container th{
            min-width: 15rem !important;
        }
    </style>
    @endsection

    @section('content')

    @livewire('partials.content-header', [
        'pageTitle' => 'Procurement Dashboard',
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => 'dashboard/procurement'],
            ['name' => 'Procurement', 'route' => '#'],
        ]
    ])

    <div class="p-4 table-container" id="table-container">

    </div>
    @endsection
    @section('script')
    <script>
        
        let data = @json($data);
        const table_container = document.querySelector('#table-container');
        let procurement_totals = {};

        console.log(data);

        let table1 = generateTable();
        generate_thead(table1).appendChild(generateHeaders('OCD Central Office'));
        generate_tbody(table1).appendChild(generateContentHeaders());

        generateRowContent(table1, data.service_regions[2], 'qty_amount');



        let table2 = generateTable();
        generate_thead(table2).appendChild(generateHeaders('OCD Regional Office'));
        generate_tbody(table2).appendChild(generateContentHeaders());

        generateRowContent(table2, data.service_regions[1], 'qty_amount');


        let table4 = generateTable();
        generate_thead(table4).appendChild(generateHeaders('TIER 2 PROPOSAL'));
        generate_tbody(table4).appendChild(generateContentHeaders());

        generateRowContent(table4, data.division_sections, 'div_sec');


        let table3 = generateTable();
        generate_thead(table3).appendChild(generateHeaders('OCD-WIDE'));
        generate_tbody(table3).appendChild(generateContentHeaders());

        generateRowTotal(table3);


        function generateTable() {
            let table = document.createElement('table');
            table.className="table table-list";
            table_container.appendChild(table);
            return table;
        }






        function generate_thead(table){
            let thead = document.createElement('thead');
            table.appendChild(thead);
            return thead;
        }
        function generate_tbody(table){
            let tbody = document.createElement('tbody');
            table.appendChild(tbody);
            return tbody;
        }

        function generateHeaders(title){
            let tr = document.createElement('tr');
            let append_td = function(text, colSpan){
                let th= document.createElement('th');
                th.innerHTML=text;
                if(colSpan){
                    th.colSpan=colSpan;
                }
                tr.appendChild(th);
                return th;
            }
            append_td(title);
            for (const key in data.procurement_modes) {
                const procurement_mode = data.procurement_modes[key];
                append_td(`${procurement_mode.section} - ${procurement_mode.title}`, 2);
            }
            append_td("Total", 2);
            return tr;
        }
        function generateContentHeaders(){
            let tr = document.createElement('tr');
            let row_header = '<td>PMO</td>';
            for (const key in data.procurement_modes) {
                const procurement_mode = data.procurement_modes[key];
                row_header += `<td>Qty</td><td>Amount</td>`;
            }
            row_header += '<td>Qty</td><td>Amount</td>';
            tr.innerHTML=row_header;
            return tr;
        }

        function generateRowContent(table, data_key_values, type){
            for (const key in data_key_values) {
                let tr = document.createElement('tr');
                let row_content = '';
                const data_key_value = data_key_values[key];
                row_content += `<td>${data_key_value.accronym}</td>`;

                let row_total = {
                    amount: 0,
                    qty: 0,
                }

                for (const key in data.procurement_modes) {
                    const procurement_mode = data.procurement_modes[key];
                    let qty = !data.data[type][data_key_value.id] ? 0 : data.data[type][data_key_value.id][procurement_mode.id] ? data.data[type][data_key_value.id][procurement_mode.id].qty : 0;
                    let amount = !data.data[type][data_key_value.id] ? 0 : data.data[type][data_key_value.id][procurement_mode.id] ? data.data[type][data_key_value.id][procurement_mode.id].amount: 0;
                    
                    row_total.amount += amount;
                    row_total.qty += qty;
                    
                    row_content += `<td>${
                        qty > 0 ? qty : ''
                    }</td><td>${
                        amount > 0 ? '₱ ' + Number(amount).toLocaleString('en', {minimumFractionDigits: 2, maximumFractionDigits: 2}) : ''
                    }</td>`;

                    if(!procurement_totals[procurement_mode.id]){
                        procurement_totals[procurement_mode.id] = {
                            amount: 0,
                            qty: 0,
                        };
                    }
                    procurement_totals[procurement_mode.id].amount += amount;
                    procurement_totals[procurement_mode.id].qty += qty;
                }
                
                row_content += `<td>${
                    row_total.qty > 0 ? row_total.qty : ''
                }</td><td>${
                    row_total.amount > 0 ? '₱ ' + Number(row_total.amount).toLocaleString('en', {minimumFractionDigits: 2, maximumFractionDigits: 2}) : ''
                }</td>`;

                tr.innerHTML=row_content;
                table.querySelector('tbody').appendChild(tr);
            }
        }

        function generateRowTotal(table){
            let tr = document.createElement('tr');
            let row_content = '';
            row_content += `<td>Total</td>`;
            let over_all_total = {
                amount: 0,
                qty: 0,
            };
            for (const key in data.procurement_modes) {
                const procurement_mode = data.procurement_modes[key];
                row_content += `<td>${
                    procurement_totals[procurement_mode.id].qty
                }</td><td>₱ ${
                    Number(procurement_totals[procurement_mode.id].amount).toLocaleString('en', {minimumFractionDigits: 2, maximumFractionDigits: 2})
                }</td>`;

                over_all_total.amount += procurement_totals[procurement_mode.id].amount;
                over_all_total.qty += procurement_totals[procurement_mode.id].qty;
            }

            row_content += `<td>${
                over_all_total.qty
            }</td><td>₱ ${
                Number(over_all_total.amount).toLocaleString('en', {minimumFractionDigits: 2, maximumFractionDigits: 2})
            }</td>`;
            
            tr.innerHTML=row_content;
            table.querySelector('tbody').appendChild(tr);
        }




        
    </script>
    <script>
      $("#li_procurementdashboard").addClass('active');

        




    </script>
    @endsection
</x-app-layout>
