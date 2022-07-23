<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
            <div class="row">
                <div class="col-6"></div>
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
                            <option value="0">Alotment Class</option>
                            <option value="1" selected>Fund Chargeability</option>
                            <option value="2">Category</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <select class="form-control" id="select-year">
                            <option disabled>Choose Year</option>
                            <option value="2020" selected>2020</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <canvas class="canvas"></canvas>
                    </div>
                </div>
                <br>
                <hr>
                <br>
                <div class="row">
                    <div class="col-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Office</th>
                                    <th>PS</th>
                                    <th>MOOE</th>
                                    <th>CO</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $office = ['AFMS','CBTS','EO', 'PDPS', 'PAO']@endphp
                                <tr>
                                    <td>AFMS</td>
                                    <td>123</td>
                                    <td>345</td>
                                    <td>654</td>
                                    <td>456</td>
                                </tr>
                                <tr>
                                    <td>CBTS</td>
                                    <td>123</td>
                                    <td>345</td>
                                    <td>654</td>
                                    <td>456</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Total</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                            
                        </table>
                    </div>
                    <div class="col-8">
                        <canvas class="canvas2"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('analytics-fiscal-limit')
<script src="{{asset('js/analytics/chart-builder.js')}}"></script>
<script src="{{asset('js/analytics/fiscal-limit.js')}}"></script>
<script>
(function () {

	let dataset_labels = [];
	let data_labels = [];
	let data_headers = {};
	let data_body = {};

    let select_office = $('#select-office');
    let select_dataset = $('#select-dataset');
    let select_year = $('#select-year');

    query();
    select_office.on('change', query);
    select_dataset.on('change', query);
    select_year.on('change', query);

    function query() {
        const route = ['allotment-class','fund-chargeabilty','category'];
        const handler = [allotmentClass,fundChargeabilty,category];
        console.log(select_dataset.val());
        console.log(route[select_dataset.val()]);
        let url = window.location.origin+"/analytics/budget/" + route[select_dataset.val()];
        $.ajax({
            type:'GET',
            url: url,
            handler:handler,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                office: select_office.val(),
                year: select_year.val(),
            },
            success:function(response){
                handler[ [select_dataset.val()] ](response);
            }
        });
    }

    function allotmentClass(params) {
        clearOptions();
        console.log(params);
    }

    function fundChargeabilty(params) {
        clearOptions();
        console.log(params);
    }

    function category(params) {
        clearOptions();
        let index = 0;
        params.forEach(param => {
            let key = param['accronym'];
            data_labels.push(key);
            (!(key in data_body))? data_body[key] = {} : false;
            (param.fiscal_limit).forEach(budget => {
                const allotment_class = budget.category.allotment_class.accronym;
                const fund_chargeability = budget.category.fund_chargeability.accronym;
                const accronym = allotment_class+'-'+fund_chargeability;

                (!(dataset_labels.includes(accronym)))? dataset_labels.push(accronym): false;
                data_body[key][accronym] = budget.amount;
            });
        });
        console.log({dataset_labels, data_labels, data_body});
        chartData.labels = data_labels;
        fiscal_chart.update();
        console.log({chartData});
        serialize();
    }

    function serialize() {
        // datasets: [
        //     {
        //         label: 'Dataset 1',
        //         backgroundColor: window.chartColors.red,
        //         data: [
        //             100,1000,500
        //         ]
        //     }
        // ];
        let dataset = [];
        dataset_labels.forEach(key => {
            dataset.push({
                label: key,
                backgroundColor: color(),
                data: []
            });
            console.log(key);
            let index = dataset.length - 1;
            Object.values(data_body).forEach( obj => {
                console.log({
                    key,
                    obj,
                    data: obj[key]
                });
                (key in obj)? dataset[index].data.push(obj[key]): 0;
                // console.log(element);
            });
        });
        chartData.datasets = dataset;
        fiscal_chart.update();
      

        console.log({dataset});


    }

    function color() {
        const randomColor = Math.floor(Math.random()*16777215).toString(16);
        return "#" + randomColor;
    }

    function clearOptions(){
        dataset_labels = [];
        data_headers = {};
        data_body = {};
        console.clear();
    }
   
})();
</script>
@endsection
