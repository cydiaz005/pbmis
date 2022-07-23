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
            ['name' => 'POE Report', 'route' => '#'],
        ],
        'pageTitle' => 'Program of Expenditures (POE)',

    ])
    <div class="px-4 pt-4" style="background-color: #ebecf0 !important; margin-top: 20px; margin-bottom: 20px;padding:20px;">
        @if(auth()->user()->hasRole(['Planning Focal/Officer']))
        @include('pages.form.form-filter',[ "filters"=>["search","stage","month","year"]])
        @else
        @include('pages.form.form-filter',[ "filters"=>["search","stage","region","month","year"]])
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
        // $('.sidebar-mini').addClass('sidebar-collapse');
        $("#li_reports").addClass('menu-open');
        $("#li_reports>a.li_parent").addClass('active');
        $("#li_poereport").addClass('active');

        @if(auth()->user()->hasRole(['Planning Focal/Officer']))
            const filters = ['search', 'stage', 'month', 'year'];
        @else
            const filters = ['search', 'stage', 'service_region', 'month', 'year'];
        @endif

        const fileList = new FileList('poe',{
            filters: filters,
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
                    let card = published.generateList(data[i], {
                        viewReport: function(){
                            window.location.href = window.location.origin+"/reports/view/poe/"+element.id;
                        },
                        exportExcel: function(){
                            let _this = this;
                            _this.innerHTML='Exporting...';
                            exportData(element.id, element, function(){
                                _this.innerHTML='Export Excel';
                            });
                            console.log('downloaded');
                        },
                        exportPDF: function(){
                            let _this = this;
                            _this.innerHTML='Exporting...';
                            exportPoePDF(element, function(){
                                _this.innerHTML='Export PDF';
                            });
                        },
                    });
                }
            }
        });
        published.getFiles();
    </script>
    @endsection
</x-app-layout>
