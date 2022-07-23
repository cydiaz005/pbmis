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
            ['name' => 'APB Report', 'route' => '#'],
        ],
        'pageTitle' => 'Annual Plans and Budget (APB) Form 1A',

    ])

            <div>
                <div class="card">
                    <div class="card-body" style="overflow: auto;">
                        <div class="form-group">
                            <button id="btn-export-excel" type="button" style="background-color: #218838 !important;" class="btn btn-success">Export Excel</button>
                            <button id="btn-export-pdf" type="button" style="background-color: #dc3545 !important;"  class="btn btn-danger">Export PDF</button>
                        </div>
                        @livewire('reports.views.apb-form-view',[
                            'year' => $year,
                            'serreg_id' => $service_region->id,
                            'funded_status' => $funded_status,
                        ])
                    </div>
                </div>
            </div>


    @livewire('modal-confirmation')
    @endsection
    @section('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>
{{--    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>--}}
            <script src="{{asset('js/xlsx-export/xlsx.full.min.js')}}"></script>
            <script src="{{asset('js/xlsx-export/xlsx.bundle.js')}}"></script>
            <script src="{{asset('js/poe.js')}}"></script>->id
            <script>
        // $('.sidebar-mini').addClass('sidebar-collapse');
        $("#li_reports").addClass('menu-open');
        $("#li_reports>a.li_parent").addClass('active');

        $("#li_apbreport").addClass('active');
                

        document.querySelector('#btn-export-excel').onclick=function(){
            let _this = this;
            _this.innerHTML='Exporting...';
            exportAPBExcel({
                year: '{{@$year}}',
                serreg_id: '{{@$service_region->id}}',
                stage_id: '{{@$stage}}',
            }, function(){
                _this.innerHTML='Export Excel';
            });
        }
        document.querySelector('#btn-export-pdf').onclick=function(){
            let _this = this;
            _this.innerHTML='Exporting...';
            exportAPBpdf({
                year: '{{@$year}}',
                service_region_id: '{{@$service_region->id}}',
                stage_id: '{{@$stage}}',
            }, function(){
                _this.innerHTML='Export PDF';
            });
        }


       
    </script>
    @endsection
</x-app-layout>
