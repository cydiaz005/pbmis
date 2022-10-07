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
            padding-right: 20px;
        }
        .nav-tabs.flex-column {
            border-right: 0;
            background: #f2f2fb;
        }
    </style>
    @endsection
    @section('content')

    @livewire('partials.content-header', [
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
            ['name' => 'Forms', 'route' => '#'],
            ['name' => 'Budget Form-Unfunded', 'route' => '#'],
        ],
        'pageTitle' => 'Budget Form (Unfunded)',
        
    ])
    <div class="px-4 pt-4" style="background-color: #ebecf0 !important; margin-top: 20px; margin-bottom: 20px;padding:20px;">
        @include('pages.form.form-filter',[ "filters"=>["stage","region","year"]])
    </div>
    <div class="card card-default">
        <div class="card-body" style="padding: 0;">
            <div class="row">
                <div class="col-12 tabcontent">
                    <div class="tab-content" id="vert-tabs-tabContent">
                        <div class="tab-pane fade" id="vert-tabs-all" role="tabpanel" aria-labelledby="vert-tabs-all-tab">
                            @livewire('funded-tab-content.all')
                        </div>
                        <div class="tab-pane fade active show" id="vert-tabs-published" role="tabpanel" aria-labelledby="vert-tabs-published-tab">
                            <div class="row" style="padding: 0 10px;">
                                <div class="col-md-6">
                                    <div class="col-md-12" id="published-budget-container">
                                        <div class="text-center my-5 py-5 pre-loader">Loading....</div>
                                    </div>
                                    <div class="d-none" id="pagination-links-all" style="border-top: 1px solid #ececec;">

                                    </div>    
                                </div>
                                <!-- pap -->
                                <div class="col-md-6" style="padding-left: 30px;">
                                    <div class="card card-default">
                                        <div class="card-body" style="padding: 20px;">
                                            <p style="margin-bottom: 30px;font-size: 18px;">
                                                <strong id="budget-form-title">Budget Form (Unfunded) {{date('Y')}}</strong>
                                            </p>
                                
                                            <div id="funded-forms" style="max-height: 50rem; overflow-y: auto !important">
                                                <div class="text-center my-5 py-5 pre-loader">No selected.</div>
                                                {{-- <div class="text-center my-5 py-5 pre-loader">Loading....</div> --}}
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-returned" role="tabpanel" aria-labelledby="vert-tabs-returned-tab">
                            @livewire('funded-tab-content.returned')
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-resolved" role="tabpanel" aria-labelledby="vert-tabs-resolved-tab">
                            @livewire('funded-tab-content.resolved')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>

    @livewire('modal-confirmation')
@endsection

@section('script')
    <script src="{{asset('js/poe.js')}}"></script>
    <script>
        // $('.sidebar-mini').addClass('sidebar-collapse');
        $("#li_forms").addClass('menu-open');
        $("#li_forms>a.li_parent").addClass('active');
        $("#li_unfundedform").addClass('active');

        const fileList1 = new FileList('ppmp');
        const published = new fileList1.newList({
            url: '/form/ppmp/get/unfunded-forms',
            status: "published",
            container: "#funded-forms",
            pagination: "scroll",
            paginationContainer: "#funded-forms",
            controller: function(data){
                for (let i = 0; i < data.length; i++) {
                    const element = data[i];
                    let card = published.generatePpmpClassification(data[i], {
                        return: function(){
                            document.querySelector('#modal-return-pap-title').innerHTML=element.poe.pap_txt || element.poe.suggested_pap.paps;
                            $('#confirmReturn').modal('show');
                            document.querySelector('#modal-return-pap-btn').onclick=function(){
                                $('#confirmReturn').modal('hide');
                                $('.spinner_modal').modal('show');
                                new FormReturn({
                                    url: '/form/ppmp/return',
                                    data: {
                                        ppmp_id: element.id,
                                        type: "budgetForm"
                                    },
                                    done: function(res){
                                        console.log(res);
                                        if(document.querySelector("#funded-forms").children.length == 1){
                                            document.querySelector('.budgetselected').remove();
                                        }
                                        published.removeFile(card);
                                        $('.spinner_modal').modal('hide');
                                    }
                                });
                            }
                        },
                        viewEye: function(){
                            window.location.href = window.location.origin+"/form/ppmp/view/"+element.id;
                        },
                    });
                }
            }
        });
        // 


        const fileList = new FileList('ppmp',{
            filters: ['stage', 'service_region', 'year'],
        });
        let lastClickedId;
        const budget = new fileList.newList({
            url: "/reports/budget/unfunded/fetch",
            status: "all",
            container: "#published-budget-container",
            controller: function(data, other_params){
                for (let i = 0; i < data.length; i++) {
                    const element = data[i];
                    let card = budget.generateBudgetList(data[i]);
                    card.onclick=function(){
                        if(lastClickedId != element.id){
                            for (let x = 0; x < card.parentNode.children.length; x++) {
                                const el = card.parentNode.children[x];
                                el.classList.remove('budgetselected');
                            }
                            fileList1.filters.service_region = element.service_region_id;
                            card.classList.add('budgetselected');
                            lastClickedId =  element.id;
                            published.destroy();
                            published.getFiles();
                        }
                    }
                }
            }
        });
        budget.getFiles();
        fileList.on('filter', function(){
            lastClickedId=undefined;
            published.destroy();
            document.querySelector("#funded-forms").innerHTML='<div class="text-center my-5 py-5 pre-loader">No selected.</div>';
            document.querySelector("#budget-form-title").innerHTML='Budget Form (Funded) '+fileList.filters.year;
        });

    </script>
@endsection
</x-app-layout>
