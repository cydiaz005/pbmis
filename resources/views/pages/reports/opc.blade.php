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
            ['name' => 'OPC Report', 'route' => '#'],
        ],
        'pageTitle' => 'OPC Report',
    ])

    <div class="px-4 pt-4" style="background-color: #ebecf0 !important; margin-top: 20px; margin-bottom: 20px;padding:20px;">
        @if(auth()->user()->hasRole(['Planning Focal/Officer']))
        @include('pages.form.form-filter',[ "filters"=>["semester","year"]])
        @else
        @include('pages.form.form-filter',[ "filters"=>["region","semester","year"]])
        @endif
    </div>
    <div class="card card-default">
        <div class="card-body">
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
        $("#li_opcreport").addClass('active');
        @if(auth()->user()->hasRole(['Planning Focal/Officer']))
            const filters = ['semester', 'year'];
        @else
            const filters = ['service_region', 'semester', 'year'];
        @endif
        const fileList = new FileList('opc',{
            filters: filters,
            url: "/reports/opc/fetch"
        });
        const published = new fileList.newList({
            status: "published",
            container: "#published-container",
            controller: function(data, other_params){
                for (let i = 0; i < data.length; i++) {
                    const element = data[i];
                    let card = published.generateBudgetList(data[i], {
                        viewReport: function(){
                            window.location.href = window.location.origin+"/reports/opc/"+element.id;
                        },
                        exportExcel: function(){
                            let _this = this;
                            _this.innerHTML='Exporting...';
                            exportOPCexcel({
                                id: element.id,
                                year: element.year,
                                region: element.accronym,
                            },function(){
                                _this.innerHTML='Export Excel';
                            });
                        },
                        exportPDF: function(){
                            console.log('downloaded',element);
                            let _this = this;
                            _this.innerHTML='Exporting...';
                            exportOPCpdf({
                                id: element.id,
                                year: element.year,
                                region: element.accronym,
                            }, function(){
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
        function ExportToExcel(type, fn, dl,accr) {
            var elt = document.getElementById('tbl-apbreport');
            var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
            return dl ?
                XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
                XLSX.writeFile(wb, fn || (accr+'_Annual_Plans_And_Budget.' + ('xlsx')));
        }
    </script>
    @endsection
</x-app-layout>
