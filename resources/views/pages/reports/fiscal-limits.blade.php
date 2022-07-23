<x-app-layout>
    @section('style')
    <link rel="stylesheet" href="{{ asset('theme-alte3/plugins/daterangepicker/daterangepicker.css') }}">
    <style>
    </style>
    @endsection
    @section('content')

    @livewire('partials.content-header', [
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
            ['name' => 'Reports', 'route' => '#'],
            ['name' => 'Working Fiscal Limits', 'route' => '#'],
        ],
        'pageTitle' => 'Working Fiscal Limits',

    ])

    <div class="px-4 pt-4" style="background-color: #ebecf0 !important; margin-top: 20px; margin-bottom: 20px;padding:20px;">
        @include('pages.form.form-filter',[ "filters"=>["stage", "year"]])
    </div>
    <div class="card card-default">
        <div class="card-body">
            <div class="col-md-12" id="published-container">
                <div class="text-center my-5 py-5 pre-loader">Loading....</div>
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
        const fileList = new FileList('fiscal',{
            filters: ['stage', 'year'],
            url: "/form/working-fiscal-limit/fetch"
        });
        const published = new fileList.newList({
            status: "published",
            container: "#published-container",
            controller: function(data, other_params){
                for (let i = 0; i < data.length; i++) {
                    const element = data[i];
                    let card = published.generateFiscalList(data[i], {
                        viewReport: function(){
                            window.location.href = window.location.origin+"/reports/fiscal-limit/get/"+element.stage_id+"/"+element.year;
                        },
                        exportExcel: function(){
                            let _this = this;
                            _this.innerHTML='Exporting...';
                            exportFiscalLimitExcel({
                                year: element.year,
                                stage_id: element.stage_id,
                            }, function(){
                                _this.innerHTML='Export Excel';
                            });
                        },
                        exportPDF: function(){
                            let _this = this;
                            _this.innerHTML='Exporting...';
                            exportFiscalLimitPDF({
                                year: element.year,
                                stage_id: element.stage_id,
                            }, function(){
                                _this.innerHTML='Export PDF';
                            });
                        },
                    });
                }
            },
        });
        published.getFiles();

        $("#li_forms").addClass('menu-open');
        $("#li_forms>a.li_parent").addClass('active');
        $("#li_fiscal").addClass('active');

    </script>
    @endsection
</x-app-layout>
