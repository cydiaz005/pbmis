<x-app-layout>
{{--    <div class="canvas_div_pdf">--}}

{{--        <!--Add HTML content you want to convert to PDF-->--}}

{{--    </div>--}}
    @section('style')
    <style>
        tr > td{
            white-space: nowrap;
        }
        tr > th{
            white-space: nowrap;
        }
    </style>
    @endsection
    @section('content')

    @livewire('partials.content-header', [
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
            ['name' => 'Reports', 'route' => '#'],
            ['name' => 'Budget Report', 'route' => '#'],
        ],
        'pageTitle' => 'Budget Report - '.$service_region->service_region.'(UnFunded)',
    ])

    @livewire('reports.views.budget-form-view',[
        'year' => $year,
        'serreg_id' => $service_region->id,
        'funded_status' => $funded_status,
    ])

    @livewire('modal-confirmation')
    @endsection

    @section('script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>
    <script src="{{asset('js/xlsx-export/xlsx.full.min.js')}}"></script>
    <script src="{{asset('js/xlsx-export/xlsx.bundle.js')}}"></script>
    <script src="{{asset('js/poe.js')}}"></script>
    <script>
        document.querySelector('#btn-export-budgetreport').onclick=function(){
            let _this = this;
            _this.innerHTML='Exporting...';

            exportBudgetReportToExcel({
                year: '{{$year}}',
                service_region_id: '{{$service_region->id}}',
                funded_status: '0',
                stage_id: '{{$stage}}',
            },function(){
                _this.innerHTML='Export Excel';
            });
        }
        document.querySelector('#btn-export-pdf').onclick=function(){
            let _this = this;
            _this.innerHTML='Exporting...';
            exportBudgetReportToPDF({
                year: '{{$year}}',
                service_region_id: '{{$service_region->id}}',
                funded_status: '0',
                stage_id: '{{$stage}}',
            },function(){
                _this.innerHTML='Export PDF';
            });
        }
    </script>
    @endsection
</x-app-layout>
