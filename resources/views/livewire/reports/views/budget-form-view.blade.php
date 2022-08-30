<style>
    .budget-table-con {
        overflow-x: auto;
    }
    .budget-table-con.active {
        background: rgba(255,255,255,0.3);
        cursor: grabbing;
        cursor: -webkit-grabbing;
        transform: scale(1);
    }
    .table-bordered thead td, .table-bordered thead th {
        vertical-align: middle;
    }
    .cell.active td{
		background-color: #1c20ab1a;
	}
    tbody tr:hover td {
        background-color: #1c20ab1a;
    }
    .budget-table-con::-webkit-scrollbar {
        width: 3px;
        height: 3px;
    }
    .budget-table-con::-webkit-scrollbar-thumb {
        background-color: #c1c1c1;
    }
    /* thead {
        position: sticky;
        position: -webkit-sticky;
        z-index: 999;
        top: 0;
    } */
    thead tr {
        font-size: 14px;
        background-color: #ffffff;
    }
    .bg-info {
        background-color: #ef8d42 !important;
    }
    .bg-warning {
        background-color: #404396 !important;
    }
    .bg-warning td {
        color: #FFFFFF;
    }
</style>
<div class="card " id="budget1">
    <div class="card-body" style="overflow:auto">
        <div class="form-group">
            <button id="btn-export-budgetreport" type="button" class="btn btn-sm btn-primary">Export as Excel</button>
            <button id="btn-export-pdf" type="button" class="btn btn-sm btn-success" style="background-color: #218838 !important;">Export as PDF</button>
        </div>
            {{-- dd(@$reports) --}}
            @if(@$reports)
        <table class="table table-bordered canvas_div_pdf" id="tbl-budget-funded-report">
                <thead>
                    <tr>
                        <th colspan="18"><h1>CY-{{$year}} ANNUAL PLANS AND BUDGET</h1></th>
                    </tr>
                    <tr>
                        <th rowspan="2">P/A/P</th>
                        <th rowspan="2">SUB P/A/P</th>
                        <th rowspan="2">Item Requirements</th>
                        <th rowspan="2">Expense Object</th>
                        <th rowspan="2">Account Code</th>
                        <th colspan="12">APB</th>
                        <th rowspan="2">TOTAL</th>
                    </tr>
                    <tr>
                        <th>January</th>
                        <th>February</th>
                        <th>March</th>
                        <th>April</th>
                        <th>May</th>
                        <th>June</th>
                        <th>July</th>
                        <th>August</th>
                        <th>September</th>
                        <th>October</th>
                        <th>November</th>
                        <th>December</th>
                    </tr>
                    <tr>
                        @for ($i = 'a'; $i <= 'q'; $i++)
                            <th>({{ $i }})</th>
                        @endfor
                        <th colspan="1">
                            (R = @for ($i = 'f'; $i <= 'q'; $i++)
                                    {{ $i }} @if($i != 'q')  +  @endif
                            @endfor)
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php $sub_allocations_list = [] @endphp
                    @foreach (@$reports as $fund_group)
                        <tr class="bg-info">
                            <td colspan="18" class="txt-center">{{ $funded_chargeability[$loop->index] }}</td>
                        </tr>
                        @php
                        $sub_column_total = 0;
                        $sub_allocations_total = [0,0,0,0,0,0,0,0,0,0,0,0,0];
                        @endphp


                        @foreach ($fund_group as $poes)
                            @php
                                $ppmp_show = 1;
                                $subtotal = 0;
                            @endphp


                            @foreach ($poes->subpap as  $subpap)

                                @php $subpap_show = 1; @endphp

                                @foreach ($subpap->itemRequirements as $item_req)
                                    @php

                                    $monthly_allocation = [0,0,0,0,0,0,0,0,0,0,0,0];
                                    foreach($item_req->itemMonths as $item_month){
                                        $month_index = $item_month->month-1;
                                        $monthly_allocation[$month_index] += $item_month->amount;
                                        $sub_allocations_total[$month_index] += $item_month->amount;
                                    }
                                    $sub_allocations_total[12] += $item_req->itemMonthSum[0]->sum
                                    @endphp


                                    <tr class="cell">
                                        <td>
                                            @if ($ppmp_show == 1)
                                                <strong>{{ ($poes->pap_txt) ? $poes->pap_txt : $poes->suggestedPap->paps }} </strong>
                                                @php $ppmp_show = 0; @endphp
                                            @endif
                                        </td>
                                        <td>
                                            @if ($subpap_show == 1)
                                                {{ ($subpap->subpap_txt) ? $subpap->subpap_txt : $subpap->suggestedSubPap->subpaps }}
                                                @php $subpap_show = 0; @endphp
                                            @endif
                                        </td>
                                        <td>
                                            {{ ($item_req->itemreq_txt) ? $item_req->itemreq_txt : $item_req->suggestedItemRequirement->ireq }}
                                        </td>
                                        <td> {{ $item_req->chartOfAccount->expense_object }} </td>
                                        <td> {{ $item_req->chartOfAccount->code }} </td>



                                        @foreach ($monthly_allocation as $allotment)
                                        <td>

                                            {{ ($allotment) ? 'PHP '.number_format($allotment, 2) : '' }}

                                        </td>

                                        @endforeach
                                        <td>
                                            {{ 'PHP '.number_format($item_req->itemMonthSum[0]->sum, 2) }}
                                        </td>

                                    </tr>


                                @endforeach
                            @endforeach
                        @endforeach

                        <tr class="bg-warning">
                            <td>Sub Total</td>
                            @for ($i = 0; $i < 4; $i++)
                            <td>&nbsp;</td>
                            @endfor

                            @foreach ($sub_allocations_total as $sub_total)
                            <td>{{ ($sub_total)? 'PHP '.number_format($sub_total, 2): null }}</td>
                            @endforeach
                        </tr>

                        @php
                        array_push($sub_allocations_list, $sub_allocations_total);
                        $sub_allocations_total = [0,0,0,0,0,0,0,0,0,0,0,0,0];
                        @endphp
                    @endforeach

                </tbody>
                <tfoot>
                    @php
                    $sub_total = [0,0,0,0,0,0,0,0,0,0,0,0,0];
                    foreach ($sub_allocations_list as $list){
                        for ($i = 0; $i < count($sub_total) ; $i++){
                            $sub_total[$i] += $list[$i];
                        }
                    }
                    @endphp
                    <tr class="bg-primary">
                        <td>Grand Total</td>
                        @for ($i = 0; $i < 4; $i++)
                        <td>&nbsp;</td>
                        @endfor
                        @foreach ($sub_total as $total)
                        @if ($total)
                        <td> PHP {{ number_format($total,2) }} </td>
                        @else
                        <td>&nbsp;</td>
                        @endif
                        @endforeach
                    </tr>
                </tfoot>
            </table>
            @else
            No available content
            @endif

        </div>

    </div>
</div>
<script>
    // var app = {{-- Js::from(@$reports) --}};
    // console.log({app});

    // draggable table
    let table_con = document.querySelector('.budget-table-con');
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

    let tbody = document.querySelectorAll('td');
    for (let i = 0; i < tbody.length; i++) {
        const element = tbody[i];
        element.onclick = function(e) {
            let tr = document.querySelectorAll('tr')
            for (let i = 0; i < tr.length; i++) {
                const element_tr = tr[i];
                element_tr.classList.remove('active');
            }
            e.target.parentNode.classList.add('active')
        }
    }
</script>
