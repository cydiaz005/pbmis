@php
    $overallbudget = 0;
    foreach (@$reports as $fund_group){
        foreach (@$fund_group as $poe){
            $overallbudget += $poe->total;
        }
    }
@endphp
<table id="tbl-apbreport" class="table table-bordered">
    <thead>
    <tr>
        <th colspan="7">OFFICE OF CIVIL DEFENSE</th>
    </tr>
    <tr>
        <th colspan="7">ANNUAL PLANS AND BUDGET FY{{$year}}</th>
    </tr>
    <tr>
        <th colspan="7">Projects/Activities</th>
    </tr>
    <tr>
        <th>OVERALL BUDGET:</th>
        <th colspan="7">PHP {{number_format($overallbudget, 2)}}</th>
    </tr>
    <tr>
        <th>OPERATIONS</th>
        <th colspan="7">PHP {{number_format(0, 2)}}</th>
    </tr>
    <tr>
        <th>Organizational Outcome (OO)</th>
        <th colspan="7">Resiliency of Communities to Disasters Improved</th>
    </tr>
    <tr>
        <th>PROGRAM</th>
        <th colspan="7">Civil Protection Program</th>
    </tr>
    <tr>
        <th>Project/Activities</th>
        <th>Q1 Target</th>
        <th>Q2 Target</th>
        <th>Q3 Target</th>
        <th>Q4 Target</th>
        <th>Budget</th>
        <th>POE Tags</th>
    </tr>
    </thead>
    <tbody>
    @php
        $papnum = 0;
    @endphp
    @foreach (@$reports as $fund_group_key => $fund_group)
        {{--dd($fund_group)--}}
        <tr class="bg-primary">
            <td colspan="7" class="txt-center">
                {{ $fund_group_key }}
            </td>
        </tr>

        @php $subpapnum = 0 @endphp
        @foreach (@$fund_group as $poe)
            <tr class="bg-info">
                <td class="txt-center">
                    <strong> {{++$papnum}}. {{ ($poe->pap_txt) ? $poe->pap_txt : $poe->suggestedPap->paps }} </strong>
                </td>
                @for ($i = 0; $i < 4; $i++)
                    <td></td>
                @endfor
                <td>PHP {{number_format($poe->total, 2)}}</td>
                <td>
                    @foreach (@$poe->poeTags as $tag)
                        <span class="badge bg-white">
                                        {{$tag->papTag->tag}}
                                    </span>
                    @endforeach
                </td>

            </tr>
            @foreach (@$poe->subpap as $subpap)
                @php
                    $sub_total = 0;
                    $ireqnum = 0;
                    foreach ($subpap->itemRequirements as $item_req){
                        foreach ($item_req->itemMonthSum as $months){
                            $sub_total += $sub_total + $months->sum;
                        }
                    }
                @endphp
                <tr class="bg-warning">
                    <td class="txt-center">
                        {{$papnum}}.{{++$subpapnum}}. {{ ($subpap->subpap_txt) ? $subpap->subpap_txt : $subpap->suggestedSubPap->subpaps }}
                    </td>
                    @for ($i = 0; $i < 4; $i++)
                        <td></td>
                    @endfor
                    <td>PHP {{number_format($sub_total, 2)}}</td>
                    <td></td>
                </tr>
                @foreach (@$subpap->itemRequirements as $item_req)

                    @php
                        $quarter = [0,0,0,0];
                        foreach ($item_req->itemMonths as $months){
                            if($months->month <= 3){
                                $quarter[0] += $months->qty;
                            }
                            elseif($months->month <= 6){
                                $quarter[1] += $months->qty;
                            }
                            elseif($months->month <= 9){
                                $quarter[2] += $months->qty;
                            }
                            else{
                                $quarter[3] += $months->qty;
                            }
                        }
                    @endphp
                    <tr>
                        <td>
                            {{$papnum}}.{{$subpapnum}}.{{++$ireqnum}}.
                            {{($item_req->itemreq_txt) ? $item_req->itemreq_txt : $item_req->suggestedItemRequirement->ireq }}
                        </td>
                        <td>{{($quarter[0])? $quarter[0].' '.$subpap->quarterTarget->quarter_target:'';}}</td>
                        <td>{{($quarter[1])? $quarter[1].' '.$subpap->quarterTarget->quarter_target:'';}}</td>
                        <td>{{($quarter[2])? $quarter[2].' '.$subpap->quarterTarget->quarter_target:'';}}</td>
                        <td>{{($quarter[3])? $quarter[3].' '.$subpap->quarterTarget->quarter_target:'';}}</td>
                        <td>PHP {{ number_format($item_req->itemMonthSum[0]->sum, 2) }}</td>
                        <td></td>
                    </tr>
                @endforeach
            @endforeach
        @endforeach
    @endforeach
    </tbody>
</table>
