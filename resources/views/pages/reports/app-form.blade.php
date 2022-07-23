<x-app-layout>
    @section('style')
    <style>
        .formname {
            color: var(--ocd-primary);
        }
        .tabheader{
            padding-right: 0;
        }
        .nav-tabs.flex-column .nav-link.active {
            background: #fff;
            border: 0;
            /* border-left: 3px solid var(--ocd-tertiary-dark); */
            border-radius: 0;
            color: var(--ocd-primary);
            opacity: 1;
            border-right: 1px solid transparent;
        }
        .nav-tabs.flex-column .nav-link {
            padding: 30px;
            font-weight: 600;
            font-size: 16px;
            border: 0;
            /* border-left: 3px solid var(--ocd-tertiary-dark); */
            background: #f2f2fb;
            margin: 0;
            border-radius: 0;
            transition: 0.3s;
            color: #555b60;
            border-right: 1px solid #dee2e6;
        }
        .nav-tabs.flex-column .nav-link:hover {
            border-color: transparent;
            /* border-left: 3px solid var(--ocd-tertiary-dark); */
            background: #f9f9f9;
            opacity: 1;
            color: #343a40;
            border-right: 1px solid transparent;
        }
        div#vert-tabs-tabContent {
            padding: 30px;
        }
        .nav-tabs.flex-column {
            border-right: 0;
            background: #f2f2fb;
        }
        .select2-container{
            width: 100%;
            display: block;
        }
    </style>
    @endsection
    @section('content')

    @livewire('partials.content-header', [
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
            ['name' => 'Forms', 'route' => '#'],
            ['name' => 'APP Form', 'route' => '#'],
        ],
        'pageTitle' => '(APP)',
    ])
   

    <div class="px-4 pt-4" style="background-color: #ebecf0 !important; margin-top: 20px; margin-bottom: 20px;padding:20px;">
        @include('pages.form.form-filter',[ "filters"=>["stage", "year"]])
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
                <div class="col-md-12" id="allforms-container">
                   <div class="text-center my-5 py-5 pre-loader">Loading....</div>
                </div>
            </div>
            <div class="d-none" id="pagination-links-published" style="border-top: 1px solid #ececec;">

            </div>
        </div>
        <!-- /.card -->
    </div>


    <!-- create pap -->

    @livewire('modal-confirmation')
    @endsection
    
    @section('script')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.4/jspdf.plugin.autotable.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script><!-- html2canvas 1.0.0-alpha.11 or higher version is needed --> --}}
    
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script> --}}

    
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>
    
    <script src="{{asset('js/jspdf-auto-table-examples.js')}}"></script>
    <script src="{{asset('js/poe.js')}}"></script>
    <script src="{{asset('js/xlsx-export/xlsx.full.min.js')}}"></script>
    <script src="{{asset('js/xlsx-export/xlsx.bundle.js')}}"></script>
    <script src="{{asset('js/app-form.js')}}"></script>
    <script>
        console.log("jspdf", jsPDF);
        const user_id = {{Auth::user()->id}};
        const pap = new Searchable('#papname', {
            url: window.location.origin+'/form/poe/search/pap',
            disableNoDataFound: true,
            searchingPropmt: false,
            props: {
                id: 'id',
                text: 'paps',
            },
            onClick: 'triggerClick',
            triggerClick: function(data, onRemove){
                pap.getElement().value = data.text;
                pap.removeData();
            }
        });

        const filters = ['stage', 'year'];

        const fileList = new FileList('app-form', {
            filters: filters,
            url: "/form/app-form/list",
        });
        
        const allForms = new fileList.newList({
            status: "all",
            container: "#allforms-container",
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
                    let card;
                    let buttons={
                        viewEye: function(){
                            window.location.href = window.location.origin+"/form/app-form/view/"+element.id;
                        },
                        exportExcel: function(){
                            const appForm = new AppForm({
                                params: {
                                    year: element.year,
                                    app_form_id: element.id,
                                }
                            });
                            appForm.generateReport('excel');
                            let _this = this;
                            _this.innerHTML='Exporting...';
                            appForm.on('report-generated', function(){
                                _this.innerHTML='Export Excel';
                            });
                        },
                        exportPDF: function(){
                            const appForm = new AppForm({
                                params: {
                                    year: element.year,
                                    app_form_id: element.id,
                                }
                            });
                            appForm.generateReport('pdf');
                            let _this = this;
                            _this.innerHTML='Exporting...';
                            appForm.on('report-generated', function(){
                                _this.innerHTML='Export PDF';
                            });
                        },
                    }
                    if(element.locked == '1' && element.locker_user_id != user_id){
                        delete buttons['lockOrUnlock'];
                    }
                    card = allForms.generateAppForm(element, buttons);
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

        allForms.getFiles();
    
    </script>
    <script>
        $("#li_reports").addClass('menu-open');
        $("#li_reports>a.li_parent").addClass('active');
        $("#li_appreport").addClass('active');

    </script>
    @endsection
</x-app-layout>
