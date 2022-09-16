@section('analytics-style')

<style>
    .small-box-footer {
        background-color: var(--ocd-tertiary-dark);
        color: var(--ocd-primary);
    }
</style>
@endsection

<div>
   <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    Summative Data Graph (Per Office)
                </div>
                <div class="card-body">
                    <div class="row">
                        <canvas id="widget-office" class="pie-widgets"></canvas>
                    </div>
                    <div class="row analytics-tbl">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Summative Data</th>
                                    <th>No. of PAPs</th>
                                    <th>Total Budget</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td scope="row">CO Services</td>
                                    <td>{{@$co_summary['num_paps']}}</td>
                                    <td>{{@number_format($co_summary['total_budget'],2)}}</td>
                                </tr>
                                <tr>
                                    <td scope="row">Regional Offices</td>
                                    <td>{{@$ro_summary['num_paps']}}</td>
                                    <td>{{@number_format($ro_summary['total_budget'],2)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="/dashboard/plans-list-of-paps/office" class="small-box-footer" style="color: var(--ocd-primary);">View more details <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    Summative Data Graph (Priority Class)
                </div>
                <div class="card-body">
                    <div class="row">
                        <canvas id="widget-priority-class" class="pie-widgets"></canvas>
                    </div>
                    <div class="row analytics-tbl">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Summative Data</th>
                                    <th>No. of PAPs</th>
                                    <th>Total Budget</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($pclass_summary as $priority)
                                <tr>
                                    <td scope="row">{{@$priority->class}}</td>
                                    <td>{{@$priority->num_paps}}</td>
                                    <td>{{@number_format($priority->total_budget,2)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="/dashboard/plans-list-of-paps/priority-class" class="small-box-footer" style="color: var(--ocd-primary);">View more details <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    Summative Data Graph (PAP Tags)
                </div>
                <div class="card-body">
                    <div class="row">
                        <canvas id="widget-pap-tags" class="pie-widgets"></canvas>
                    </div>
                    <div class="row analytics-tbl">
                        
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Summative Data</th>
                                    <th>No. of PAPs</th>
                                    <th>Total Budget</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($tagging_summary as $tags)
                                <tr>
                                    <td scope="row">{{@$tags->tag}}</td>
                                    <td>{{@$tags->num_paps}}</td>
                                    <td>{{@number_format($tags->total_budget,2)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="/dashboard/plans-list-of-paps/paptag" class="small-box-footer" style="color: var(--ocd-primary);">View more details <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
   </div>

   <div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                Summative Data Graph (Per Target Sector)
            </div>
            <div class="card-body">
                   <div class="row">
                        <canvas id="widget-sectors" class="bar-widgets"></canvas>
                    </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Summative Data</th>
                            <th>No. of PAPs</th>
                            <th>Total Budget</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sector_summary as $target)
                        <tr>
                            <td scope="row">{{@$target->sector}}</td>
                            <td>{{@$target->num_paps}}</td>
                            <td>{{@number_format($target->total_budget,2)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="/dashboard/plans-list-of-paps/target-sector" class="small-box-footer" style="color: var(--ocd-primary);">View more details <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                Summative Data Graph (Per KDP/KP/KS)
            </div>
            <div class="card-body">
                   <div class="row">
                        <canvas id="widget-kdpkpks" class="bar-widgets"></canvas>
                    </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Summative Data</th>
                            <th>No. of PAPs</th>
                            <th>Total Budget</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kdpkpks_summary as $kdpkpks)
                        <tr>
                            <td scope="row">{{@$kdpkpks->desc}}</td>
                            <td>{{@$kdpkpks->num_paps}}</td>
                            <td>{{@number_format($kdpkpks->total_budget,2)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="/dashboard/plans-list-of-paps/kdpkpks" class="small-box-footer" style="color: var(--ocd-primary);">View more details <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
   </div>
</div>

@section('analytics-script')
<script>
    var co_summary = {{ Js::from(@$co_summary) }};
    var ro_summary = {{ Js::from(@$ro_summary) }};
    var pclass_summary = {{ Js::from(@$pclass_summary) }};
    var tagging_summary = {{ Js::from(@$tagging_summary) }};
    var sector_summary = {{ Js::from(@$sector_summary) }};
    var kdpkpks_summary = {{ Js::from(@$kdpkpks_summary) }};



    var pclass_properties  = {labels:[], data:[]};
    var tagging_properties  = {labels:[], data:[]};
    var sector_properties  = {labels:[], data:[]};
    var kdpkpks_properties  = {labels:[], data:[]};


    pclass_summary.forEach(element => {
        pclass_properties['labels'].push(element.class);
        pclass_properties['data'].push(element.total_budget);
    });

    tagging_summary.forEach(element => {
        tagging_properties['labels'].push(element.tag);
        tagging_properties['data'].push(element.total_budget);
    });

    sector_summary.forEach(element => {
        sector_properties['labels'].push(element.sector);
        sector_properties['data'].push([element.total_budget]);
    });

    kdpkpks_summary.forEach(element => {
        kdpkpks_properties['labels'].push(element.desc);
        kdpkpks_properties['data'].push([element.total_budget]);
    });

    console.log({pclass_properties});
    console.log({sector_summary, sector_properties});


    $officeChart = new Chart(document.getElementById("widget-office"), {
        type: 'pie',
        data: {
        labels: ["Central Office", "Regional Office"],
        datasets: [{
            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
            data: [co_summary.total_budget, ro_summary.total_budget]
        }]
        },
        options: {
            title: {
                display: true,
                text: 'OCD Offices'
            }
        },
    });

    $priorityClassChart = new Chart(document.getElementById("widget-priority-class"), {
        type: 'pie',
        data: {
        labels: pclass_properties.labels,
        datasets: [{
            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
            data: pclass_properties.data,
        }]
        },
        options: {
            title: {
                display: true,
                text: 'OCD Offices'
            }
        },
    });

    $papTagChart = new Chart(document.getElementById("widget-pap-tags"), {
        type: 'pie',
        data: {
        labels: tagging_properties.labels,
        datasets: [{
            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
            data: tagging_properties.data,
        }]
        },
        options: {
            title: {
                display: true,
                text: 'OCD Offices'
            }
        },
    });
    console.log({sector_properties});
    $targetSectorChart = new Chart(document.getElementById("widget-sectors"), {
        type: 'bar',
        data: {
        labels: sector_properties.labels,
        datasets: [{
            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
            data: sector_properties.data,
        }]
        },
        options: {
            indexAxis: 'y',
            legend: {
                display: false
            },
            title: {
                display: false,
                text: 'OCD Offices'
            }
        },
    });

    $kdpkpksChart = new Chart(document.getElementById("widget-kdpkpks"), {
        type: 'bar',
        data: {
        labels: kdpkpks_properties.labels,
        datasets: [{
            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
            data: kdpkpks_properties.data,
        }]
        },
        options: {
            indexAxis: 'y',
            legend: 'false'
        },
    });


    

    
</script>
@endsection
