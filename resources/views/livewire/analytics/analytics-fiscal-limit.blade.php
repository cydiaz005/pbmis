<div id="fmd-analytics-loading" class="alert alert-primary" role="alert">
    Loading ...
</div>
<div id="fmd-analytics" class="d-none">
<div class="container">
    <div class="row" style="margin-bottom: 20px;">
        <div class="col-5"></div>
        <!-- <div class="col-2">
            <select id="filter-stage" class="form-control form-input">
                <option disabled>Choose Stage<i class="fa fa-stack-exchange" aria-hidden="true"></i></option>
                <option selected="" value="1">[ IND ] Indicative</option>
                <option value="2">[ NEP ] National Expenditure Program</option>
                <option value="3">[ GAA ] General Appropriation Act</option>
            </select>
        </div> -->
        <div class="col-2">
            <select class="form-control" id="select-office">
                <option disabled>Choose Office</option>
                <option value="1" selected>Central Office</option>
                <option value="0">Regional Office</option>
            </select>
        </div>
        <div class="col-2">
            <select class="form-control" id="select-dataset">
                <option disabled>Choose Dataset</option>
                <option value="allotment_class">Allotment Class</option>
                <option value="fund_chargeability" selected>Fund Chargeability</option>
                <option value="category">Category</option>
            </select>
        </div>
        <div class="col-2">
            <select class="form-control" id="select-year">
                <option disabled hidden>Choose Year</option>
                @for($i = 2022; $i <= \Carbon\Carbon::now()->format('Y') + 3; $i++)
                    <option {{$i == \Carbon\Carbon::now()->format('Y') ? "selected":""}} value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
        </div>
        <div class="col-1">
            <button type="button" id="chart-refresh" class="btn btn-primary">Refresh</button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <canvas id="fiscal-budget"></canvas>
            </div>
        </div>
    </div>
    <br>
</div>
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-body" style="overflow: auto">
                <table id="widget-fiscal-table" class="table table-hover">
                    <thead>
                    </thead>
                    <tbody>
                    </tbody>
                    <!-- <tfoot>
                    </tfoot> -->
                </table>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <canvas id="fiscal-budget-breakdown"></canvas>
                <br>
                <ul id="nav-breakdown" class="nav flex-column">
                    <!-- <li class="nav-item">
                        <a href="#" class="nav-link">
                            Projects <span class="float-right badge">31</span>
                        </a>
                    </li> -->
                </ul>
            </div>
        </div>
    </div>
</div>
</div>

@section('analytics-fiscal-limit')
<script src="{{asset('js/analytics/chart-builder.js')}}"></script>
<!-- <script src="{{asset('js/analytics/fiscal-limit.js')}}"></script> -->
<script>
(function () {

	let active_dataset = [];
    let select_office = $('#select-office');
    let select_dataset = $('#select-dataset');
    let select_year = $('#select-year');
    let nav_breakdown = $('#nav-breakdown');
    let fmd_analytics = $('#fmd-analytics');
    let fmd_analytics_loading = $('#fmd-analytics-loading');

    fmd_analytics.hide();
    fmd_analytics.removeClass('d-none');
    const options = {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    };

    let toInt = function(num){
        num = num.toString();
        num = num.replace(/[^\d.-]+/g,'');
        num = parseInt(num) || 0;
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

    let widget_fiscal_table = $('#widget-fiscal-table');
    let wf_thead = widget_fiscal_table.find('thead');
    let wf_tbody = widget_fiscal_table.find('tbody');
    let wf_tfoot = widget_fiscal_table.find('tfoot');
    let wf_trigger = wf_tbody.find('tr');
    console.log({widget_fiscal_table});

    let widget_fiscal = new ChartBuilder({
        title: "Disaggregation of Budget",
        canvas: $('#fiscal-budget'),
        type: 'bar',
        scales: {
            xAxes: [{
                stacked: true,
            }],
            yAxes: [{
                stacked: true,
                ticks: {
                    callback: function(value, index, values) {
                        return Number(value).toLocaleString('en', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })
                    }
                }
            }]
        }
    });

    let widget_breakdown = new ChartBuilder({
        title: "Budget Breakdown",
        canvas: $('#fiscal-budget-breakdown'),
        type: 'bar'
    });




    query();
    select_office.on('change', query);
    select_dataset.on('change', query);
    select_year.on('change', query);
    $('#chart-refresh').on('click', query);

    wf_tbody.delegate('tr', 'click', setActiveRow);

    function query() {
        fmd_analytics_loading.slideDown();
        let url = window.location.origin+"/analytics/budget/category";
        $.ajax({
            type:'GET',
            url: url,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                office: select_office.val(),
                year: select_year.val(),
            },
            success:function(response){
                updateChart(response);
            }
        });
    }

    function updateChart(params) {
        let budget = {};
        let chart_data;
        let dataset;

        params.forEach(service_region => {
            budget[service_region.accronym] = service_region.fiscal_limit;
        });
        chart_data = serviceRegionBudget(budget);
        dataset = getDataSet(chart_data);
        active_dataset = chart_data;
        widget_fiscal.data.labels = Object.keys(chart_data.breakdown);
        widget_fiscal.data.datasets = dataset;  
        widget_breakdown.data.labels = chart_data.labels;
        widget_fiscal.refresh();
        updateTable(chart_data);
    }


    function serviceRegionBudget(budget) {
        console.log({serviceRegionBudget: budget});
        let keys = Object.keys(budget);
        let labels = [];
        let breakdown = {};
        keys.forEach(key => {
            breakdown[key] = {}
            const active_budget = budget[key];
            let temp_label;
            active_budget.forEach(active => {
                const amount = active.amount;
                const category = active.category;
                temp_label = getKeyLabel(category);
                ( !(labels.includes(temp_label)) ) ? labels.push(temp_label):false;
                ( temp_label in breakdown[key] ) ? breakdown[key][temp_label] += amount : 
                breakdown[key][temp_label] = amount;
            });
        });
        return {labels, breakdown};
    }

    function getKeyLabel(category) {
        let label;
        let preferred = select_dataset.val();
        
        (preferred == "allotment_class")? 
        label = category.allotment_class.accronym:
        false;
        (preferred == "fund_chargeability")? 
        label = category.fund_chargeability.accronym:
        false;
        (preferred == "category")? 
        label = category.allotment_class.accronym+"-"+category.fund_chargeability.accronym:
        false;

        return label;


    }

    function getDataSet(chart_data) {
        let dataset = [];

        let labels = chart_data.labels;
        let breakdown = chart_data.breakdown;
 
        
        labels.forEach(label => {
            dataset.push({
                label: label,
                backgroundColor: color(),
                data:[]
            })
            const index = dataset.length-1;
            dataset[index].data = filterLabelValues(label, breakdown);
        

        });
        return dataset;
    }

    function filterLabelValues(label, value){
        let data = [];
        let keys = Object.keys(value);
        keys.forEach(key => {
            const temp = value[key];
            (label in temp)? data.push(temp[label]): data.push(0);
        });
        return data;
    }

    function updateTable(params) {
        let headers = params.labels;
        let body = params.breakdown;
       
        wf_thead.html('');
        wf_tbody.html('');
        wf_tfoot.html('');
        updateHeader(headers);
        updateBody(body, headers);
 
        refreshBreakdown();
    }

    function updateHeader(headers){
        let template = [];
        template.push("<tr>");
        template.push("<th>Office</th>");
        headers.forEach(header => {template.push("<th>"+header+"</th>")});
        template.push("<th>Total</th>");
        template.push("</tr>");
        wf_thead.html(template.join(""));
    }

    function updateBody(body, cells) {
        let value;
        let template = [];
        let keys = Object.keys(body);
        keys.forEach(key => {
            let total = 0;
            template.push('<tr>');
            template.push('<td>'+key+'</td>');
            cells.forEach(budget => {
                total+=body[key][budget];
                value = (body[key][budget])?formatter(body[key][budget]): formatter(0);

                template.push('<td>'+value+'</td>');
            });
            template.push('<td>'+formatter(total)+'</td>');
            template.push('</tr>');
            
        });
        wf_tbody.html(template.join(""));

    }


    function setActiveRow() {
        let region = $(this).find('td').first().html();
        let url = window.location.origin+"/analytics/budget/per-service-region";
        $(this).parent().find('tr').removeClass('active-service-region');
        $(this).addClass('active-service-region');

        $.ajax({
            type:'GET',
            url: url,
            region:region,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                region: region,
                year: select_year.val(),
            },
            success:function(response){
                serviceRegionBreakdown(this.region, response)
            }
        });
    }

    function serviceRegionBreakdown(key, params) {
        let regional_budget = active_dataset.breakdown[key];


        let preferred = select_dataset.val();

        (preferred == "allotment_class")? 
        srb_allotment_class(regional_budget, params):
        false;

        (preferred == "fund_chargeability")? 
        srb_fund_chargeability(regional_budget, params):
        false;

        (preferred == "category")? 
        srb_category(regional_budget, params):
        false;
    }


    function srb_allotment_class(budget, params) {
        let published = {};
        let keys = Object.keys(budget);        
        keys.forEach(key => {
            params.forEach(param => {
                (! (key in published) )? published[key] = 0 : false;
                (param.allotment_class == key)? published[key] += param.published : false;
                console.log({key, param, published});
            });
        });

        breakdown = [Object.values(budget), Object.values(published)];
        srbDataSet(breakdown);
    }

    function srb_fund_chargeability(budget, params) {
        let published = {};
        let breakdown = [];

        let keys = Object.keys(budget);        
        keys.forEach(key => {
            params.forEach(param => {
                (! (key in published) )? published[key] = 0 : false;
                (param.fund_chargeability == key)? published[key] += param.published : false;
                console.log({key, param, published});
            });
        });
 
        breakdown = [Object.values(budget), Object.values(published)];
        srbDataSet(breakdown);
    }

    function srb_category(budget, params) {
        let published = {};
        let breakdown = [];

        let keys = Object.keys(budget);  
        let serialized = {};

        params.forEach(param => {
            let key = param.allotment_class+"-"+param.fund_chargeability;
            serialized[key] = param.published;
        });   

        breakdown = [Object.values(budget), Object.values(serialized)];
        srbDataSet(breakdown);

    }
    
    function srbDataSet(breakdown) {
        let dataset = [];

        let labels = ['Allocated Budget', 'Published'];
        let colors = ['#39B0C3','#D2D6DE'];
 
        for (let index = 0; index < breakdown.length; index++) {
            const br = breakdown[index];
            dataset.push({
                label: labels[index],
                backgroundColor: colors[index],
                data: br
            })
            
        }

        widget_breakdown.data.datasets = dataset;  
        widget_breakdown.refresh();

        // <li class="nav-item">
        //     <a href="#" class="nav-link">
        //         Projects <span class="float-right badge">31</span>
        //     </a>
        // </li>
        setBreakdownSummary(breakdown);
    }
    function setBreakdownSummary(params) {
        nav_breakdown.html("");


        let pivot = params[0].length;
        let label = widget_breakdown.data.labels;
        let template = [];
        console.log({nav_breakdown});
        for (let index = 0; index < pivot; index++) {
            const summary = pivot[index];
            template.push('<li class="nav-item">');
            template.push('<a href="#" class="nav-link">');
            template.push(label[index]);
            template.push('<span class="float-right">');
            template.push(formatter(params[1][index])+' / ');
            template.push(formatter(params[0][index]));
            template.push('</span>');
            template.push('</a>');
            template.push('</li>');
        }
        nav_breakdown.html(template.join(""));
        console.log(template.join(""));
        console.log({setBreakdownSummary:pivot});
    }

    function refreshBreakdown(){
        console.log("toggled");
        wf_tbody.find('tr').first().trigger('click');
        fmd_analytics.show();
        fmd_analytics_loading.slideUp();
    }

    function color() {
        const randomColor = Math.floor(Math.random()*16777215).toString(16);
        return "#" + randomColor;
    }

})();
</script>
@endsection
