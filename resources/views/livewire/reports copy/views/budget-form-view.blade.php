<div class="card">
    <div class="card-body" style="overflow:auto">



        <table>
            <thead>
                <tr>
                    <th colspan="18">CY-{{$year}} ANNUAL PLANS AND BUDGET</th>
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
                @foreach (@$reports as $report)

                    <tr class="bg-gray">
                        <td colspan="18" class="txt-center">{{ $funded_chargeability[$loop->index] }}</td>
                    </tr>
                    @foreach ($report as $ppmp)
                        @php $subpap_count = 0; @endphp
                        @php $item_req_count = 0; @endphp
                        @php $grand_total_sum = 0; @endphp

                        @php $monthly_allocation = ["","","","","","","","","","","","",]; @endphp
                        @php $grand_total = [0,0,0,0,0,0,0,0,0,0,0,0]; @endphp

                        @foreach ($ppmp->subpap as $subpap)
                            
                            @php $item_req_count = count($subpap->itemRequirements); @endphp

                            @foreach ($subpap->itemRequirements as $item_req)
                                @php
                                foreach ($item_req->itemMonths as $item_months){
                                    for ($i = 0; $i < 12; $i++){
                                        if($i+1 == $item_months->month){
                                            $monthly_allocation[$i] = 'PHP '.number_format($item_months->amount, 2);
                                            $grand_total[$i] = $grand_total[$i] + $item_months->amount;
                                        }
                                    }
                                }
                                @endphp
                                <tr>
                                    <td> {{ ($ppmp->pap_txt) ? $ppmp->pap_txt : $ppmp->suggestedPap->paps }} </td>
                                    <td> {{ ($subpap->subpap_txt) ? $subpap->subpap_txt : $subpap->suggestedSubPap->subpaps }} </td>
                                    <td> {{ ($item_req->itemreq_txt) ? $item_req->itemreq_txt : $item_req->suggestedItemRequirement->ireq }}  </td>
                                    <td> {{ $item_req->chartOfAccount->expense_object }} </td>
                                    <td> {{ $item_req->chartOfAccount->code }} </td>
                                    @foreach ($monthly_allocation as $allocation)
                                    <td>{{$allocation}}</td>
                                    @endforeach 
                                    <td>PHP {{ number_format($ppmp->total, 2) }}</td>

                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                   
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td>Sub Total</td>
                    @for ($i = 0; $i < 17; $i++)
                    <td> - </td>
                    @endfor
                </tr>
                <tr>
                    <td>Grand Total</td>
                    @for ($i = 0; $i < 4; $i++)
                        <td> - </td>
                    @endfor
                    @foreach ($grand_total as $gtotal)
                                
                        $grand_total_sum = $grand_total_sum + $gtotal;
                        dd($gtotal);
                        <td> PHP {{ number_format($gtotal, 2) }} </td>
                    @endforeach
                    <td> {{$grand_total_sum}} </td>
                </tr>
            </tfoot>
        </table>

    </div>
</div>

<script>
    var app = {{ Js::from(@$report) }};
    console.log({app});
</script>