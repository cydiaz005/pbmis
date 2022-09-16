<x-app-layout>
    @section('style')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .active-service-region{
            color: #fff;
            background-color: #007BFF !important;
        }
        .reset-zoom-btn{
            position: absolute;
            top: 5px;
            right: 5px;
        }
        .chart-fullscreen{
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100vw;
            height: 100vh;
            z-index: 9999999;
            background: #ffffff;
            padding: 1rem;
        }
        /* .region-selector{
            position: absolute;
            top: 5px;
            left: 5px;
        } */
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
        {{-- <canvas id="myChart" width="400" height="400"></canvas> --}}
    <div class="d-flex justify-content-end pt-5 px-5">
        <a href="/dashboard/procurement/list" class="small-box-footer" style="color: var(--ocd-primary);">View List <i class="ml-2 fas fa-arrow-circle-right"></i></a>
    </div>
    <div class="p-md-5 mx-md-5" id="chart-container">
        <div class="p-5 d-flex justify-content-center align-items-center">Loading...</div>
    </div>
    @endsection
    @section('script')
    <script src="{{asset('js/analytics/chart-builder.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@0.7.7"></script>

    <script>
        
        
        // for (let i = 0; i < 5; i++) {
        //     generateChart();
        // }
        let result = [];
        let procurement_colors = {};
        let fc_colors = {};
        let ac_colors = {};
        let month_colors = {};
        
        const months = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ];

        function generateChart(type, title){
            let mainDiv = document.createElement('div');

            let div = document.createElement('div');
            div.className="position-relative my-5";

            let resetZoomButton = document.createElement('button');
            resetZoomButton.className="btn btn-sm btn-secondary reset-zoom-btn";
            resetZoomButton.innerHTML='<i class="fas fa-redo-alt"></i>';

            let canvas = document.createElement('canvas');

            let selector = document.createElement('select');
            selector.setAttribute('class', 'selectpicker region-selector');
            selector.setAttribute('multiple', true);
            selector.setAttribute('data-live-search', true);
            let opts = ``;
            for (const key in result.service_regions) {
                const service_region = result.service_regions[key];
                opts += `<option ${key==1 ? "selected":""} value="${result.service_regions[key].id}">${result.service_regions[key].service_region}</option>`;
            }
            selector.innerHTML=opts;

            div.appendChild(selector); 
            div.appendChild(resetZoomButton); 
            div.appendChild(canvas);

            mainDiv.appendChild(div);
            mainDiv.appendChild(document.createElement('hr'));

            const barChart = new Chart(canvas, {
                type: 'bar',
                data: getData(type, [1]),
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        yAxes: [{
                            ticks: {
                                // Include a dollar sign in the ticks
                                callback: function(value, index, values) {
                                    if(type=="amount"){
                                        return '₱' + Number(value).toLocaleString('en', {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })
                                    }
                                    else{
                                        return value.toFixed(2);
                                    }
                                    return value;
                                }
                            }
                        }]
                    },
                    title: {
                        display: true,
                        text: title,
                        fontSize: 22,
                    },
                    legend: {
                        display: true,
                        position: "bottom",
                    },
                    plugins: {
                        zoom: {
                            pan: {
                                enabled: true,
                                mode: 'xy'
                            },
                            zoom: {
                                enabled: true,
                                mode: 'xy',
                            }
                        }
                    }
                }
            });

            document.querySelector('#chart-container').appendChild(mainDiv);

            resetZoomButton.onclick=function(){
                barChart.resetZoom();
                // mainDiv.className="chart-fullscreen";
            }
            selector.onchange=function(){
                console.log("dawwad", $(selector).val());
                barChart.data = getData(type, $(selector).val());
                barChart.update();
            }
        }

        fetchData();
        function fetchData(){
            fetch("/dashboard/procurement/get-data", {       
                method: "POST",
                headers: {
                    Accept: "application/json, text/plain, */*",
                    "Content-Type": "application/json",
                    "X-CSRF-Token": document.querySelector('[name="csrf-token"]').content,
                },
                body: [],
            }).then(function (response) {
                if (!response.ok) {
                    throw new Error("HTTP status " + response.status);
                }
                return response.json();
            }).then(function(res){
                console.log("res",res);

                // data: {
                //     labels: ['a', 'b', 'c'],
                //     datasets: [
                //         {
                //             label: 'Red',
                //             data: [12, 19, 3],
                //             backgroundColor: "red",
                //         },
                //         {
                //             label: 'Blue',
                //             data: [12, 7, 5],
                //             backgroundColor: "blue",
                //         },
                //         {
                //             label: 'Yellow',
                //             data: [12, 1, 10],
                //             backgroundColor: "yellow",
                //         },
                //     ]
                // },
                document.querySelector('#chart-container').innerHTML="";
                result = res;

                generateChart("quantity", "Mode of Procurement in Quantity");
                generateChart("amount", "Mode of Procurement in Amount");
                generateChart("month", "Schedule of Procurement");
                generateChart("fund_chargeability", "Source of Fund");
                generateChart("allotment_class", "MOOE or CO");


                $('.selectpicker').selectpicker();
            });

            
        }
        function getData(type, selected_regions){
            const procurement_data = result.data[type];

            let data = {
                labels: [],
                datasets: [],
            };
                
            selected_regions.sort(function(a, b) {
                return a - b;
            });

            for (let i = 0; i < selected_regions.length; i++) {
                data.labels.push(result.service_regions[selected_regions[i]].service_region);
            }

            if(type == "quantity"){
                for (const x in result.procurement_modes) {
                    const d = result.procurement_modes[x];
                    if(!procurement_colors[d.id]){
                        procurement_colors[d.id] = randomColor(0.5);
                    }
                    let val = {
                        label: d.section,
                        data: [],
                        backgroundColor: procurement_colors[d.id],
                    };
                    
                    for (let i = 0; i < selected_regions.length; i++) {
                        val.data.push(
                            !procurement_data[selected_regions[i]] ? 0 : procurement_data[selected_regions[i]][d.id] ? procurement_data[selected_regions[i]][d.id].count : 0
                        );
                    }
                    data.datasets.push(val);
                }
            }
            else if(type == "amount"){
                for (const x in result.procurement_modes) {
                    const d = result.procurement_modes[x];
                    if(!procurement_colors[d.id]){
                        procurement_colors[d.id] = randomColor(0.5);
                    }
                    let val = {
                        label: d.section,
                        data: [],
                        backgroundColor: procurement_colors[d.id],
                    };
                    
                    for (let i = 0; i < selected_regions.length; i++) {
                        val.data.push(
                            !procurement_data[selected_regions[i]] ? 0 : procurement_data[selected_regions[i]][d.id] ? procurement_data[selected_regions[i]][d.id].amount : 0
                        );
                    }
                    data.datasets.push(val);
                }
            }
            else if(type == "month"){
                for (let i = 0; i < months.length; i++) {
                    if(!month_colors[i]){
                        month_colors[i] = randomColor(0.5);
                    }
                    let val = {
                        label: months[i],
                        data: [],
                        backgroundColor: month_colors[i],
                    };
                    let month_key = i + 1;
                    for (let i = 0; i < selected_regions.length; i++) {
                        val.data.push(
                            !procurement_data[selected_regions[i]] ? 0 : procurement_data[selected_regions[i]][month_key] ? procurement_data[selected_regions[i]][month_key] : 0
                        );
                    }
                    data.datasets.push(val);
                }
            }
            else if(type == "fund_chargeability"){
                for (const x in result.fund_chargeabilities) {
                    const d = result.fund_chargeabilities[x];
                    if(!fc_colors[d.id]){
                        fc_colors[d.id] = randomColor(0.5);
                    }
                    let val = {
                        label: d.accronym,
                        data: [],
                        backgroundColor: fc_colors[d.id],
                    };
                    
                    for (let i = 0; i < selected_regions.length; i++) {
                        val.data.push(
                            !procurement_data[selected_regions[i]] ? 0 : procurement_data[selected_regions[i]][d.id] ? procurement_data[selected_regions[i]][d.id].count : 0
                        );
                    }
                    data.datasets.push(val);
                }
            }
            else if(type == "allotment_class"){
                for (const x in result.allotment_classes) {
                    const d = result.allotment_classes[x];
                    if(!fc_colors[d.id]){
                        fc_colors[d.id] = randomColor(0.5);
                    }
                    let val = {
                        label: d.accronym,
                        data: [],
                        backgroundColor: fc_colors[d.id],
                    };
                    
                    for (let i = 0; i < selected_regions.length; i++) {
                        val.data.push(
                            !procurement_data[selected_regions[i]] ? 0 : procurement_data[selected_regions[i]][d.id] ? procurement_data[selected_regions[i]][d.id].count : 0
                        );
                    }
                    data.datasets.push(val);
                }
            }



            return data;
        }
        function randomColorFactor() {
			return Math.round(Math.random() * 255);
		}
		function randomColor(opacity = 1) {
			return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',' + (opacity || '.3') + ')';
		}
    </script>
    <script>
        $("#li_procurementdashboard").addClass('active');
    </script>
    @endsection
</x-app-layout>
