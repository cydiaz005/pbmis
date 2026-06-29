<x-app-layout>
    @section('style')
        <style>
            th {
                vertical-align: top;
                padding: 1em
            }

            td{
                position:relative;
            }

            .text-th{
                min-width: 200px;
            }
            .text-td{
                min-width: 200px;
                min-height: 75px;
                height: 75px;
            }
            .rating-th{
                min-width: 75px;
                max-width: 75px;
                width:75px
            }
            .text-th-sm{
                min-width: 125px;
                max-width: 125px;
                width:125px
            }
            textarea{
                width: 100%;
                top: 0; left: 0; right: 0; bottom: 0;
                position: absolute;
                resize: none;
                border: none;
                -webkit-box-sizing: border-box; /* <=iOS4, <= Android  2.3 */
                -moz-box-sizing: border-box; /* FF1+ */
                box-sizing: border-box; /* Chrome, IE8, Opera, Safari 5.1*/
                font-size: small
            }
            .full-inp{
                width: 100%;
                top: 0; left: 0; right: 0; bottom: 0;
                position: absolute;
                resize: none;
                border: none;
                -webkit-box-sizing: border-box; /* <=iOS4, <= Android  2.3 */
                -moz-box-sizing: border-box; /* FF1+ */
                box-sizing: border-box; /* Chrome, IE8, Opera, Safari 5.1*/
            }
            .full-inp-computed{
                background-color: #b8daff;
                width: 100%;
                top: 0; left: 0; right: 0; bottom: 0;
                position: absolute;
                resize: none;
                border: none;
                -webkit-box-sizing: border-box; /* <=iOS4, <= Android  2.3 */
                -moz-box-sizing: border-box; /* FF1+ */
                box-sizing: border-box; /* Chrome, IE8, Opera, Safari 5.1*/
            }
            .full-inp-computed-warning{
                background-color: #ffeeba;
                width: 100%;
                top: 0; left: 0; right: 0; bottom: 0;
                position: absolute;
                resize: none;
                border: none;
                -webkit-box-sizing: border-box; /* <=iOS4, <= Android  2.3 */
                -moz-box-sizing: border-box; /* FF1+ */
                box-sizing: border-box; /* Chrome, IE8, Opera, Safari 5.1*/
            }


        </style>
    @endsection
    @section('content')

        @livewire('partials.content-header', [
            'breadcrumb' => [
                ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
                ['name' => 'Forms', 'route' => '#'],
                ['name' => 'OPC Form', 'route' => '#'],
            ],
            'pageTitle' => 'OPC Form',

        ])
        <div class="card card-default">
            <div class="card-body p-3">
                <div class="table-responsive">
                    <div class="mb-3">
                        <button id="pageOneButton" type="button" class="btn btn-secondary border">OPS</button>
                        <button id="pageTwoButton" type="button" class="btn border">OPC</button>
                        <button onclick="downloadXlsx('{{\App\Models\ServiceRegion::find($fname->serreg_id)->accronym}}');" type="button" style="background-color: #28a745 !important;" class="btn btn-success border">Export as excel</button>
                    </div>
                    @if(isset($opcItems))
                        <table id="pageOneTable" class="text-sm table table-bordered">
                            <thead>
                            <tr>
                                <th  rowspan="2" valign="top" scope="col">Major Final Outputs</th>
                                <th rowspan="2" valign="top" scope="col">PERFORMANCE MEASURES</th>
                                <th style="width:10rem;" rowspan="2" valign="top" scope="col">PERFORMANCE TARGETS</th>
                                <th style="width:20rem" rowspan="2" valign="top" scope="col">SUCCESS INDICATOR Measures + Targets</th>
                                <th style="width:40rem" colspan="5" valign="top" scope="col">PERFORMANCE STANDARDS
                                </th>
                            </tr>
                            <tr>
                                <td  valign="top">Outstanding</td>
                                <td  valign="top">Very Satisfactory</td>
                                <td  valign="top">Satisfactory</td>
                                <td  valign="top">Unsatisfactory</td>
                                <td  valign="top">Poor</td>
                            </tr>
                            </thead>
                            <tbody class="text-sm">
                            {{-- TITLES --}}
                            @foreach ($opcItems as $priorityClassId=>$dataGroupedByPC)
                                <tr>
                                <tr>
                                    <th colspan="9" class="table-secondary"  valign="top">{{App\Models\PriorityClass::find($priorityClassId)->class}}</th>
                                </tr>
                                @foreach($dataGroupedByPC as $opcItem)
                                    @php
                                        $mfo_id = $opcItem->id;
                                        $pc_id = $opcItem->mfo->pc_id;
                                    @endphp
                                    @if(isset($pms[0]))
                                        <tr>
                                            <td class="text-td" scope="row" rowspan="{{count($pms)}}">{{ $opcItem->mfo->desc }}</td>
                                            <td class="text-td" dir="ltr">{{$pms[0]->name}}</td>
                                            <td class="text-td">
                                                <!-- PT 1 -->
                                                <textarea
                                                    disabled

                                                    name="data[{{$mfo_id}}][performance_measures][{{$pms[0]->id}}][target]" id="" >
                                                {{$opcItem->performanceMeasures->pluck('pivot')->pluck('target')->first()}}
                                            </textarea>
                                            </td>
                                            <td class="text-td" style="height:20rem" rowspan="{{count($pms)}}">
                                                <!-- Success Indicator -->
                                                <textarea
                                                    disabled

                                                    onchange="onSuccessIndicatorChanger()" colspan="10" name="data[{{$mfo_id}}][success_indicator_mt]" id="data[{{$mfo_id}}][success_indicator_mt]" >{{$opcItem->success_indicator_mt}}</textarea>
                                            </td>
                                            <td class="text-td" rowspan="{{count($pms)}}">
                                                <!-- Outstanding -->
                                                <textarea
                                                    disabled

                                                    colspan="10" name="data[{{$mfo_id}}][ps_outstanding]" id="ps_outstanding" >{{$opcItem->ps_outstanding}}</textarea>
                                            </td>
                                            <td class="text-td"  rowspan="{{count($pms)}}">
                                                <!-- Very Satisfactory -->
                                                <textarea
                                                    disabled

                                                    colspan="10" name="data[{{$mfo_id}}][ps_very_satisfactory]" id="ps_very_satisfactory" >{{$opcItem->ps_very_satisfactory}}</textarea>
                                            </td>
                                            <td class="text-td"  rowspan="{{count($pms)}}">
                                                <!-- Satisfactory -->
                                                <textarea
                                                    disabled

                                                    colspan="10" name="data[{{$mfo_id}}][ps_satisfactory]" id="ps_satisfactory" >{{$opcItem->ps_satisfactory}}</textarea>
                                            </td>
                                            <td class="text-td"  rowspan="{{count($pms)}}">
                                                <!-- Unsatisfactory -->
                                                <textarea
                                                    disabled

                                                    colspan="10" name="data[{{$mfo_id}}][ps_unsatisfactory]" id="ps_unsatisfactory" >{{$opcItem->ps_unsatisfactory}}</textarea>
                                            </td>
                                            <td class="text-td"  rowspan="{{count($pms)}}">
                                                <!-- Poor -->
                                                <textarea
                                                    disabled

                                                    colspan="10" name="data[{{$mfo_id}}][ps_poor]" id="ps_poor" >{{$opcItem->ps_poor}}</textarea>
                                            </td>
                                            <input
                                                name="data[{{$mfo_id}}][pc_id]" value="{{$pc_id}}" type="hidden">

                                        </tr>
                                    @endif
                                    @php
                                        $isFirst = true;
                                    @endphp
                                    @foreach($opcItem->performanceMeasures as $key=>$pm)
                                        @if($isFirst)
                                            @php
                                                $isFirst = false;
                                                continue;
                                            @endphp
                                        @endif
                                        <tr>
                                            <td class="text-td">{{$pm->name}}</td>
                                            <td class="text-td">
                                        <textarea
                                            disabled

                                            name="data[{{$mfo_id}}][performance_measures][{{$pm->id}}][target]" id="" >{{$pm->pivot->target}}</textarea>
                                            </td>
                                        </tr>
                                        @endforeach

                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>


                        <!-- TODO REFACTOR RUNNING TIME 2(n^3) page one + page two-->
                        <table id="pageTwoTable"  class="hidden text-sm table table-bordered">
                            <thead>
                            <tr>
                                <th class="text-th" rowspan="2" valign="top" scope="col">Major Final Outputs</th>
                                <th class="text-th" rowspan="2" valign="top" scope="col">SUCCESS INDICATOR Measures + Targets</th>
                                <th class="text-th-sm" rowspan="2" valign="top" scope="col">Alloted Budget</th>
                                <th class="text-th" rowspan="2" valign="top" scope="col">Division Accountable/Section</th>
                                <th class="text-th" rowspan="2" valign="top" scope="col">Actual Accomplishments</th>
                                <th class="text-th" colspan="{{count($pms)+1}}" valign="top" scope="col">Rating
                                <th class="text-th" rowspan="2" valign="top" scope="col">Remarks
                                </th>
                            </tr>
                            <tr>

                                @foreach($pms as $key=>$pm)
                                    <td class="rating-th"  valign="top">{{$pm->legend}}{{$key+1}}</td>
                                @endforeach
                                <td class="rating-th"  valign="top">A{{count($pms)+1}}</td>

                            </tr>
                            </thead>
                            <tbody class="text-sm">
                            @php
                                $pcCount = 1;
                            @endphp

                            @foreach ($opcItems as $priorityClassId=>$dataGroupedByPC)
                                @php
                                    $pcSize = count($opcItems);
                                    $perc = 1;
                                    if($pcSize==2){
                                        $perc = $pcCount==1?0.8:0.2;
                                    }
                                    else if ($pcSize==3) {

                                        if($pcCount==1){
                                            $perc = 0.5;
                                        }
                                        else if($pcCount==2){
                                            $perc = 0.3;
                                        }
                                        else{
                                            $perc = 0.2;
                                        }
                                    }
                                    $pcCount +=1;
                                @endphp
                                <tr>
                                <tr>
                                    <th colspan="{{count($pms)+7}}" class="table-secondary"  valign="top">{{App\Models\PriorityClass::find($priorityClassId)->class}}</th>
                                </tr>
                                @foreach($dataGroupedByPC as $opcItem)
                                    @php
                                        $mfo_poes = $opcItem->mfo->poes;
                                       $total_alloted_budget = 0;
                                        foreach ($mfo_poes as $mfo_poe) {
                                            if($mfo_poe->stage->active==1){
                                                    $total_alloted_budget += $mfo_poe->total;
                                                }
                                        }
                                        $mfo_id = $opcItem->id;

                                    @endphp
                                    <tr>
                                        <td scope="row">{{ $opcItem->mfo->desc }}</td>
                                        <td class="" dir="ltr">
                                            <p id="data[{{$mfo_id}}][success_indicator_mt]p" >{{$opcItem->success_indicator_mt}}</p>

                                        </td>
                                        <td >
                                            <p id="data[{{$mfo_id}}][alloted_budget]p" >
                                                &#8369;{{number_format((float)$total_alloted_budget, 2, '.', ',')}}</p>
                                            </p>
                                        </td>
                                        <td>
                                            <!-- Division Accountable -->
                                            <textarea
                                                disabled

                                                name="data[{{$mfo_id}}][division_accountable]" id="" >{{$opcItem->division_accountable}}</textarea>
                                        </td>
                                        <td>
                                            <!-- Actual Accomplishments -->
                                            <textarea
                                                disabled

                                                name="data[{{$mfo_id}}][actual_accomplishments]" id="" >{{$opcItem->actual_accomplishments}}</textarea>
                                        </td>


                                        @foreach ($opcItem->performanceMeasures as $pm)
                                            <td>
                                                <input
                                                    disabled

                                                    step="any"
                                                    pc="{{$priorityClassId}}" pm="{{$pm->id}}"
                                                    computed_name="data[{{$mfo_id}}][performance_measures][{{$pm->id}}][rating][{{$priorityClassId}}]"
                                                    mfo="{{$mfo_id}}"  class="full-inp" name="data[{{$mfo_id}}][performance_measures][{{$pm->id}}][rating]" type="number" value="{{$pm->pivot->rating}}">
                                            </td>
                                        @endforeach

                                        {{--
 @foreach ($opcItem->performanceMeasures as $pm)
                                           <td>
                                            <textarea  name="data[{{$mfo_id}}][rating][{{$pm->id}}]" id="" > {{$pm->pivot->rating}}</textarea>
                                        </td>

                                        @endforeach

                                        --}}


                                        <td >
                                            <!-- A4 -->
                                            <input
                                                step="any"

                                                type="number"
                                                class="full-inp"
                                                disabled
                                                id="data[{{$mfo_id}}][average]" >
                                        </td>
                                        <td >
                                            <!-- Remarks -->
                                            <textarea
                                                disabled
                                                name="data[{{$mfo_id}}][remarks]" id="" >{{$opcItem->remarks}}</textarea>
                                        </td>
                                    </tr>
                                    </tr>
                                @endforeach
                                <tr class="table-primary">
                                    <th scope="row" colspan="5">Average Point Score ({{App\Models\PriorityClass::find($priorityClassId)->class}})</td>

                                    @foreach($pms as $pm)
                                        <td>
                                            {{-- AVP INP --}}
                                            <input
                                                step="any"

                                                disabled
                                                id="data[{{$pm->id}}][avp][{{$priorityClassId}}]"  pm="{{$pm->id}}" mfo="{{$mfo_id}}" class="full-inp-computed"  type="number" value="0">
                                        </td>
                                    @endforeach
                                    <td  >
                                        {{--OVERALL AVP INP --}}
                                        <input
                                            step="any"

                                            type="number"
                                            class="full-inp-computed"
                                            disabled
                                            id="data[{{$mfo_id}}][overall_avp][{{$priorityClassId}}]" value="0">
                                    </td>
                                    <td >

                                    </td>
                                </tr>
                                <tr class="table-primary">
                                    <th scope="row" colspan="5">Weighted Point Score ({{$perc*100}}%)</td>

                                    @foreach($pms as $pm)
                                        <td>
                                            {{-- WPS INP --}}
                                            <input
                                                step="any"
                                                disabled

                                                perc="{{$perc}}" mfo="{{$mfo_id}}" class="full-inp-computed" id="data[{{$pm->id}}][wps][{{$priorityClassId}}]"  type="number" value="0">
                                        </td>
                                    @endforeach
                                    <td  >
                                        {{--OVERALL WPS INP --}}
                                        <input
                                            step="any"

                                            type="number"
                                            class="full-inp-computed"
                                            disabled
                                            id="data[{{$mfo_id}}][overall_wps][{{$priorityClassId}}]"
                                            value="0">
                                    </td>
                                    <td >
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="table-warning">
                                <th scope="row" colspan="{{count($pms)+7}}">TOTAL AVERAGE POINT SCORE </td>
                            </tr>

                            @foreach ($opcItems as $priorityClassId=>$dataGroupedByPC)
                                @php
                                    $pcSize = count($opcItems);
                                    $perc = 1;
                                    if($pcSize==2){
                                        $perc = $pcCount==1?0.8:0.2;
                                    }
                                    else if ($pcSize==3) {

                                        if($pcCount==1){
                                            $perc = 0.5;
                                        }
                                        else if($pcCount==2){
                                            $perc = 0.3;
                                        }
                                        else{
                                            $perc = 0.2;
                                        }
                                    }
                                    $pcCount +=1;

                                @endphp

                                <tr>
                                <tr class="table-warning">
                                    <th scope="row" colspan="5">{{App\Models\PriorityClass::find($priorityClassId)->class}}</td>

                                    @foreach($pms as $pm)
                                        <td>
                                            {{-- AVP INP --}}
                                            <input
                                                step="any"

                                                disabled
                                                id="data[{{$pm->id}}][avp][{{$priorityClassId}}]"  pm="{{$pm->id}}" mfo="{{$mfo_id}}" class="full-inp-computed-warning"  type="number" value="0">
                                        </td>
                                    @endforeach
                                    <td  >
                                        {{--OVERALL AVP INP --}}
                                        <input
                                            step="any"
                                            type="number"
                                            class="full-inp-computed-warning"
                                            disabled
                                            id="data[{{$mfo_id}}][overall_avp][{{$priorityClassId}}]" value="0">
                                    </td>
                                    <td >

                                    </td>
                                </tr>
                            @endforeach




                            <tr>
                                <th scope="row" colspan="{{5}}">ADD:  POINT SCORE FOR ADDITIONAL CRITERIA (NTF and IATF Functions)</td>
                                <td scope="row" colspan="{{count($pms)+2}}">
                                    <input disabled min="0" max="5" name="add_point_score" id="add_point_score" value="{{$opc->add_point_score}}">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" colspan="{{5}}">OVERALL PERFORMANCE RATING</td>
                                <td scope="row" colspan="{{count($pms)+2}}">
                                    <input disabled id="opr" name="" id="" value="0">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" colspan="{{5}}">OVERALL EQUIVALENT ADJECTIVAL RATING</td>
                                <td scope="row" colspan="{{count($pms)+2}}">
                                    <p id="oear" name=""  ></p>
                                </td>
                            </tr>


                            </tbody>
                        </table>


                    @endif

                </div>


            </div>

            <!-- /.card -->
        </div>


        @livewire('modal-confirmation')
    @endsection

    @section('script')
        <script src="https://code.jquery.com/jquery-2.1.4.js" integrity="sha256-siFczlgw4jULnUICcdm9gjQPZkw/YPDqhQ9+nAOScE4=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/amcharts/3.21.15/plugins/export/libs/FileSaver.js/FileSaver.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.6/xlsx.full.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.10.3/xlsx.full.min.js">
        </script>

        <script>
            var elt = document.getElementById('pageOneTable');
            var elt2 = document.getElementById('pageTwoTable');

            var ws = XLSX.utils.table_to_sheet(elt);
            var ws2 = XLSX.utils.table_to_sheet(elt2);

            /* create a new blank workbook */
            var wb = XLSX.utils.book_new();

            XLSX.utils.book_append_sheet(wb, ws, "OPS");
            XLSX.utils.book_append_sheet(wb, ws2, "OPC");

            var wbout = XLSX.write(wb, {
                bookType: 'xlsx',
                bookSST: true,
                type: 'binary'
            });

            function downloadXlsx(fname) {
                saveAs(new Blob([s2ab(wbout)], {
                    type: "application/octet-stream"
                }), fname+'.xlsx');
            }

            function s2ab(s) {
                var buf = new ArrayBuffer(s.length);
                var view = new Uint8Array(buf);
                for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
                return buf;
            }

        </script>
        <script>

            let page = 1;




            let pageOneButton = document.getElementById("pageOneButton")
            let pageTwoButton = document.getElementById("pageTwoButton")
            let pageOneTable = document.getElementById("pageOneTable")
            let pageTwoTable = document.getElementById("pageTwoTable")
            let submitButton = document.getElementById("submitButton")

            pageOneButton.addEventListener("click",function(){
                page = 1
                pageTwoButton.classList.remove("btn-secondary")
                pageOneButton.classList.add("btn-secondary")
                pageOneTable.style.display = "table"
                pageTwoTable.style.display = "none"
                submitButton.style.display = "none"

            })
            pageTwoButton.addEventListener("click",function(){
                page = 2
                pageOneButton.classList.remove("btn-secondary")
                pageTwoButton.classList.add("btn-secondary")
                pageOneTable.style.display = "none"
                pageTwoTable.style.display = "table"
                submitButton.style.display = "block"

            })
            let maxRating = 5
            let minRating = 0
            $("input[name*='rating']").attr({
                "max" : maxRating,
                "min" : minRating
            });

            $(document).ready(function() {
                $("input[name*='rating']").each(function(i,el){
                    if(Number($(this).val())>maxRating){
                        $(this).val(maxRating);
                    }
                    else if(Number($(this).val())<minRating){
                        $(this).val(minRating);
                    }
                    let mfo_id = $(el).attr('mfo')
                    let pm_id = $(el).attr('pm')
                    let sum = 0;
                    let length = 0;
                    let pc_id = $(el).attr("pc")
                    $(`input[name*='data[${mfo_id}][performance_measures]`).each(function(i,el){
                        if(Number($(el).val())>=1)
                        {
                            sum += Number($(el).val())
                            length++
                        }
                    })
                    length>0&&$(`input[id*='data[${mfo_id}][average]']`).val(Number(sum/length).toFixed(2))
                    let sum_avp = 0;
                    let avp_length = 0;

                    $(`input[computed_name*='[performance_measures][${pm_id}][rating][${pc_id}]`).each(function(i,el){

                        if(Number($(el).val())>=1)
                        {
                            sum_avp += Number($(el).val())
                            avp_length++
                        }
                    })
                    if(avp_length>0){
                        $(`input[id*='data[${pm_id}][avp][${pc_id}]`).val(Number(sum_avp/avp_length).toFixed(2))
                        let wpsInp = $(`input[id*='data[${pm_id}][wps][${pc_id}]`)
                        wpsInp.val(Number((sum_avp/avp_length)*Number(wpsInp.attr('perc'))).toFixed(2))
                    }
                    let overall_avp = 0;
                    let overall_avp_length = 0;
                    $(`input[id*='[avp][${pc_id}]`).each(function(i,el){
                        if(Number($(el).val())>=1)
                        {
                            overall_avp += Number($(el).val())
                            overall_avp_length++
                        }
                    })
                    overall_avp_length>0&&$(`input[id*='[overall_avp][${pc_id}]`).val(Number(overall_avp/overall_avp_length).toFixed(2))

                    let overall_wps = 0;
                    let overall_wps_length = 0;
                    $(`input[id*='[wps][${pc_id}]`).each(function(i,el){
                        if(Number($(el).val())>0)
                        {
                            overall_wps += Number($(el).val())
                            overall_wps_length++
                        }
                    })
                    overall_wps_length>0&&$(`input[id*='[overall_wps][${pc_id}]`).val(Number(overall_wps/overall_wps_length).toFixed(2))


                    let addPointScore =  $(`#add_point_score`).val();

                    let opr = 0;
                    $(`input[id*='[overall_wps]`).each(function(i,el){
                        opr += Number($(el).val())
                    })

                    opr+=Number(addPointScore)

                    if(opr>5){
                        $(`#opr`).val(Number(opr).toFixed(2)+" You have exceeded the maximum performance rating!")
                        $(`#opr`).css({'background-color':'#dc3545','color':'white'})

                    }else if(opr<=5){
                        $(`#opr`).css({'background-color':'white','color':'black'})
                    }
                    $(`input[id*='opr`).val(Number(opr).toFixed(2))

                    let ratingText;
                    if(opr>5){
                        ratingText = 'You have exceeded the maximum performance rating'
                    }
                    else if(opr>=4.3){
                        ratingText = 'Outstanding';
                    }
                    else if(opr>=3.5){
                        ratingText = 'Very Satisfactory';
                    }
                    else if(opr>=3.0){
                        ratingText = 'Satisfactory';
                    }
                    else if(opr>=1.6){
                        ratingText = 'Unsatisfactory';
                    }
                    else if(opr>=1){
                        ratingText = "Poor"
                    }
                    $(`#oear
                `).text(ratingText)

                })

                let addPointScore =  $(`#add_point_score`).val();
                let opr = 0;
                $(`input[id*='[overall_wps]`).each(function(i,el){
                    opr += Number($(el).val())
                })
                opr+=Number(addPointScore)

                $(`input[id*='opr`).val(Number(opr).toFixed(2))
                let ratingText;

                if(opr>=4.3){
                    ratingText = 'Outstanding';
                }
                else if(opr>=3.5){
                    ratingText = 'Very Satisfactory';
                }
                else if(opr>=3.0){
                    ratingText = 'Satisfactory';
                }
                else if(opr>=1.6){
                    ratingText = 'Unsatisfactory';
                }
                else if(opr>=1){
                    ratingText = "Poor"
                }
                $(`#oear
            `).text(ratingText)
            });
            $("input[name*='rating']").each(function(i,el){
                el.addEventListener('input',function(event){


                    if(Number($(this).val())>maxRating){
                        $(this).val(maxRating);
                    }
                    else if(Number($(this).val())<minRating){
                        $(this).val(minRating);
                    }

                    let mfo_id = $(el).attr('mfo')
                    let pm_id = $(el).attr('pm')
                    let sum = 0;
                    let length = 0;
                    let pc_id = $(el).attr("pc")
                    $(`input[name*='data[${mfo_id}][performance_measures]`).each(function(i,el){
                        if(Number($(el).val())>=1)
                        {
                            sum += Number($(el).val())
                            length++
                        }

                    })
                    length>0&&$(`input[id*='data[${mfo_id}][average]']`).val(Number(sum/length).toFixed(2))


                    let sum_avp = 0;
                    let avp_length = 0;

                    $(`input[computed_name*='[performance_measures][${pm_id}][rating][${pc_id}]`).each(function(i,el){

                        if(Number($(el).val())>=1)
                        {
                            sum_avp += Number($(el).val())
                            avp_length++
                        }
                    })
                    if(avp_length>0){
                        $(`input[id*='data[${pm_id}][avp][${pc_id}]`).val(Number(sum_avp/avp_length).toFixed(2))
                        let wpsInp = $(`input[id*='data[${pm_id}][wps][${pc_id}]`)
                        wpsInp.val(Number((sum_avp/avp_length)*Number(wpsInp.attr('perc'))).toFixed(2))
                    }

                    let overall_avp = 0;
                    let overall_avp_length = 0;
                    $(`input[id*='[avp][${pc_id}]`).each(function(i,el){
                        if(Number($(el).val())>=1)
                        {
                            overall_avp += Number($(el).val())
                            overall_avp_length++
                        }
                    })
                    overall_avp_length>0&&$(`input[id*='[overall_avp][${pc_id}]`).val(Number(overall_avp/overall_avp_length).toFixed(2))


                    let overall_wps = 0;
                    let overall_wps_length = 0;
                    $(`input[id*='[wps][${pc_id}]`).each(function(i,el){
                        if(Number($(el).val())>0){
                            overall_wps += Number($(el).val())
                            overall_wps_length++
                        }
                    })
                    overall_wps_length>0&&$(`input[id*='[overall_wps][${pc_id}]`).val(Number(overall_wps/overall_wps_length).toFixed(2))

                    let addPointScore =  $(`#add_point_score`).val();
                    let opr = 0;
                    $(`input[id*='[overall_wps]`).each(function(i,el){
                        opr += Number($(el).val())
                    })

                    opr+=Number(addPointScore)

                    if(opr>5){
                        $(`#opr`).val(Number(opr).toFixed(2)+" You have exceeded the maximum performance rating!")
                        $(`#opr`).css({'background-color':'#dc3545','color':'white'})

                    }else if(opr<=5){
                        $(`#opr`).css({'background-color':'white','color':'black'})
                    }
                    $(`input[id*='opr`).val(Number(opr).toFixed(2))


                    let ratingText;
                    if(opr>5){
                        ratingText = 'You have exceeded the maximum performance rating'
                    }
                    else if(opr>=4.3){
                        ratingText = 'Outstanding';
                    }
                    else if(opr>=3.5){
                        ratingText = 'Very Satisfactory';
                    }
                    else if(opr>=3.0){
                        ratingText = 'Satisfactory';
                    }
                    else if(opr>=1.6){
                        ratingText = 'Unsatisfactory';
                    }
                    else if(opr>=1){
                        ratingText = "Poor"
                    }
                    $(`#oear
            `).text(ratingText)
                })
            })
            $(`#add_point_score`).on('input propertychange',function(){
                if(Number($(this).val())>maxRating){
                    $(this).val(maxRating);
                }
                else if(Number($(this).val())<minRating){
                    $(this).val(minRating);
                }
                let addPointScore =  $(`#add_point_score`).val();
                let opr = 0;
                $(`input[id*='[overall_wps]`).each(function(i,el){
                    opr += Number($(el).val())
                })
                opr+=Number(addPointScore)

                if(opr>5){
                    $(`#opr`).val(Number(opr).toFixed(2)+" You have exceeded the maximum performance rating!")
                    $(`#opr`).css({'background-color':'#dc3545','color':'white'})
                }else if(opr<=5){
                    $(`#opr`).css({'background-color':'white','color':'black'})
                }
                $(`input[id*='opr`).val(Number(opr).toFixed(2))
                let ratingText;
                if(opr>5){
                    ratingText = 'You have exceeded the maximum performance rating'
                }
                else if(opr>=4.3){
                    ratingText = 'Outstanding';
                }
                else if(opr>=3.5){
                    ratingText = 'Very Satisfactory';
                }
                else if(opr>=3.0){
                    ratingText = 'Satisfactory';
                }
                else if(opr>=1.6){
                    ratingText = 'Unsatisfactory';
                }
                else if(opr>=1){
                    ratingText = "Poor"
                }
                $(`#oear
            `).text(ratingText)
            })


            $("textarea[name*='success_indicator_mt']").each(function (i, el) {
                const sc = document.getElementById(el.id+"p")
                el.addEventListener("change",function(event){
                    sc.innerHTML = event.target.value
                })
            });


            // $('.sidebar-mini').addClass('sidebar-collapse');
            $("#li_forms").addClass('menu-open');
            $("#li_forms>a.li_parent").addClass('active');
            $("#li_opcform").addClass('active');

        </script>
    @endsection
</x-app-layout>
