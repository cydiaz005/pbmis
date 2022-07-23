<x-app-layout>
    @section('style')
        <style>
        </style>
    @endsection
    @section('content')

        @livewire('partials.content-header', [
            'breadcrumb' => [
                ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
                ['name' => 'Reports', 'route' => '#'],
                ['name' => 'Budget Report (funded)', 'route' => '#'],
            ],
            'pageTitle' => 'Budget Report (FUNDED)',

        ])

        <div class="px-4 pt-4" style="background-color: #ebecf0 !important; margin-top: 20px; margin-bottom: 20px;padding:20px;">
            @if(auth()->user()->hasRole(['Planning Focal/Officer']))
            @include('pages.form.form-filter',[ "filters"=>["stage","year"]])
            @else
            @include('pages.form.form-filter',[ "filters"=>["stage","region","year"]])
            @endif
        </div>
        <div class="card card-default">
            <div class="card-body">
                <div id="stage-count-container" class="d-none">
                    <div class="d-flex">
                        <div class="col-md-4 col-12">
                            <div class="info-box bg-counter">
                                <div class="info-box-content">
                                    <div class="info-box-icon">
                                        <img class="" src="{{ asset('images/file-icon.png') }}" />
                                    </div>
                                    <div class="info-box-counter">
                                        <p class="info-box-text m-0 stage-count" data-value-id="1"><span>0</span> FILES</p>
                                        <p class="info-box-text m-0" style="letter-spacing: 2px">IND</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="info-box bg-counter">
                                <div class="info-box-content">
                                    <div class="info-box-icon">
                                        <img class="" src="{{ asset('images/file-icon.png') }}" />
                                    </div>
                                    <div class="info-box-counter">
                                        <p class="info-box-text m-0 stage-count" data-value-id="2"><span>0</span> FILES</p>
                                        <p class="info-box-text m-0" style="letter-spacing: 2px">NEP</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="info-box bg-counter">
                                <div class="info-box-content">
                                    <div class="info-box-icon">
                                        <img class="" src="{{ asset('images/file-icon.png') }}" />
                                    </div>
                                    <div class="info-box-counter">
                                        <p class="info-box-text m-0 stage-count" data-value-id="3"><span>0</span> FILES</p>
                                        <p class="info-box-text m-0" style="letter-spacing: 2px">GAA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="padding: 0 10px;">
                    <div class="col-md-12" id="published-container">
                        <div class="text-center my-5 py-5 pre-loader">Loading....</div>
                    </div>
                </div>
                <div class="d-none" id="pagination-links-published" style="border-top: 1px solid #ececec;">

                </div>
            </div>
            <!-- /.card -->
        </div>


        @livewire('modal-confirmation')
    @endsection

    @section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>
    <script src="{{asset('js/xlsx-export/xlsx.full.min.js')}}"></script>
    <script src="{{asset('js/xlsx-export/xlsx.bundle.js')}}"></script>
    <script src="{{asset('js/poe.js')}}"></script>
    <script>
            $("#li_reports").addClass('menu-open');
            $("#li_reports>a.li_parent").addClass('active');
            $("#li_budgetreport").addClass('active');

            @if(auth()->user()->hasRole(['Planning Focal/Officer']))
                const filters = ['stage','year'];
            @else
                const filters = ['stage', 'service_region', 'year'];
            @endif
            const fileList = new FileList('budget',{
                filters: filters,
                url: "/reports/budget/funded/fetch"
            });

            const published = new fileList.newList({
                status: "published",
                container: "#published-container",
                controller: function(data, other_params){
                    document.querySelector('#stage-count-container').classList.remove('d-none');
                    const stage_counts = document.querySelectorAll('.stage-count');
                    for (let i = 0; i < stage_counts.length; i++) {
                        const element = stage_counts[i];
                        element.querySelector('span').innerHTML = 0;
                        if(other_params.stages[element.dataset.valueId]){
                            element.querySelector('span').innerHTML = other_params.stages[element.dataset.valueId].row_count || 0;
                        }
                    }
                    for (let i = 0; i < data.length; i++) {
                        const element = data[i];
                        let card = published.generateBudgetList(data[i], {
                            viewReport: function(){
                                window.location.href = window.location.origin+"/reports/budget/funded/get/"+element.stage_id+"/"+element.year+"/"+element.service_region_id;
                            },
                            exportExcel: function(){
                                let _this = this;
                                _this.innerHTML='Exporting...';

                                exportBudgetReportToExcel({
                                    year: element.year,
                                    service_region_id: element.service_region_id,
                                    funded_status: '1',
                                    stage_id: element.stage_id,
                                },function(){
                                    _this.innerHTML='Export Excel';
                                });
                            },
                            exportPDF: function(){
                                let _this = this;
                                _this.innerHTML='Exporting...';
                                exportBudgetReportToPDF({
                                    year: element.year,
                                    service_region_id: element.service_region_id,
                                    funded_status: '1',
                                    stage_id: element.stage_id,
                                },function(){
                                    _this.innerHTML='Export PDF';
                                });
                            },
                        });
                    }
                },
                empty: function(){
                    const stage_counts = document.querySelectorAll('.stage-count');
                    for (let i = 0; i < stage_counts.length; i++) {
                        const element = stage_counts[i];
                        element.querySelector('span').innerHTML = 0;
                    }
                }
            });
            published.getFiles();
            function getPDF(){

                var HTML_Width = $(".canvas_div_pdf").width();
                var HTML_Height = $(".canvas_div_pdf").height();
                var top_left_margin = 15;
                var PDF_Width = HTML_Width+(top_left_margin*2);
                var PDF_Height = (PDF_Width*1.5)+(top_left_margin*2);
                var canvas_image_width = HTML_Width;
                var canvas_image_height = HTML_Height;

                var totalPDFPages = Math.ceil(HTML_Height/PDF_Height)-1;


                html2canvas($(".canvas_div_pdf")[0],{allowTaint:true}).then(function(canvas) {
                    canvas.getContext('2d');

                    console.log(canvas.height+"  "+canvas.width);


                    var imgData = canvas.toDataURL("image/jpeg", 1.0);
                    var pdf = new jsPDF({
                        unit: 'pt',
                        format: [900, (PDF_Height-2000)],
                        orientation: 'landscape',
                        height: PDF_Width,
                    });
                    pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin,canvas_image_width,canvas_image_height);


                    for (var i = 1; i <= totalPDFPages; i++) {
                        pdf.addPage(PDF_Width, PDF_Height);
                        pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
                    }

                    pdf.save("HTML-Document.pdf");
                    $('#budget_report').remove();
                });

            };
            function exportToExcel(table_elt, filename) {
                const l = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];

                // Extract Data (create a workbook object from the table)
                var workbook = XLSX.utils.table_to_book(table_elt);

                // Process Data (add a new row)
                var ws = workbook.Sheets["Sheet1"];
                console.log("ws", ws);

                //add style to headers
                for (let j = 0; j < l.length; j++) {
                    let key = l[j]+1;
                    if (Object.hasOwnProperty.call(ws, key)) {
                        ws[key].s = {
                            font: {
                                name: "Calibri",
                                sz: 12,
                                bold: true,
                                // color: { rgb: "FFFFAA00" },
                            },
                            border: {
                                top: {
                                    style: 'medium',
                                    color: 'FFFFAA00',
                                },
                                right: {
                                    style: 'medium',
                                    color: 'FFFFAA00',
                                },
                                left: {
                                    style: 'medium',
                                    color: 'FFFFAA00',
                                },
                                bottom: {
                                    style: 'medium',
                                    color: 'FFFFAA00',
                                },
                            },
                        }
                    }
                }
                for (let j = 0; j < l.length; j++) {
                    let num = 1;
                    while(true){
                        let key = l[j]+ num;
                        if (Object.hasOwnProperty.call(ws, key)) {
                            ws[key].s = {
                                alignment: {
                                    wrapText: true,
                                    vertical: 'center',
                                }
                            }
                        }
                        else{
                            break;
                        }
                        num++;
                    }
                }
                // ws["A1"].s = {
                //     font: {
                //         name: "Calibri",
                //         sz: 12,
                //         bold: true,
                //         wrapText: false,
                //         // color: { rgb: "FFFFAA00" },
                //     },
                // };

                let wscols = [
                    {wch:76},
                    {wch:58},
                    {wch:83},
                    {wch:12},
                    {wch:15},
                    {wch:13},
                    {wch:15},
                    {wch:15},
                    {wch:15},
                    {wch:15},
                    {wch:15},
                    {wch:15},
                    {wch:15},
                    {wch:15},
                    {wch:15},
                    {wch:15},
                    {wch:15},
                    {wch:15},
                    {wch:15},
                    {wch:15},
                ];
                ws['!cols'] = wscols;

                XLSX.writeFile(workbook, filename+".xlsx");
                $('#budget_report').remove();

                return;
            }

        </script>
    @endsection
</x-app-layout>
