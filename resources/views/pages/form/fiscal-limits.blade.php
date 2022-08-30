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
    </style>
    @endsection
    @section('content')

    @livewire('partials.content-header', [
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
            ['name' => 'Forms', 'route' => '#'],
            ['name' => 'Working Fiscal Limits', 'route' => '#'],
        ],
        'pageTitle' => 'Working Fiscal Limits',
        
    ])

    <div class="px-4 pt-4" style="background-color: #ebecf0 !important; margin-top: 20px; margin-bottom: 20px;padding:20px;">
        @include('pages.form.form-filter',[ "filters"=>["stage", "year"]])
    </div>
    <div class="card card-default">
        <div class="card-body" style="padding: 0;">
            <div class="row">
                <div class="col-5 col-sm-2 tabheader">
                    <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link text-center active" id="vert-tabs-all-tab" data-toggle="pill" href="#vert-tabs-all" role="tab" 
                            aria-controls="vert-tabs-all" aria-selected="false">
                            <img class="fileicon" src="{{ asset('images/folder.png') }}">
                            ALL FORMS</a>
                    </div>
                </div>
                <div class="col-7 col-sm-10 tabcontent p-4">
                    <div class="d-flex justify-content-end mb-3">
                        @if(@$fiscal_limit_count == 0)
                        <button type="button" id="btn_create_fiscal" class="btn btn-primary">Create</button>
                        @endif
                    </div>
                    <div class="col-md-12" id="published-container">
                       <div class="text-center my-5 py-5 pre-loader">Loading....</div>
                    </div>
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
    <script src="{{asset('js/poe.js')}}"></script>
    <script>    
        let year = "{{ date('Y', strtotime(@$list->created_at)) }}";
        let modal_edit = $('#confirmEdit .btn-pos');
        let modal_delete = $('#confirmDelete');

        $('#btn_create_fiscal').on('click', function () {
            let url = window.location.origin + "/form/working-fiscal-limit/create/?fiscal_year=2022";
            location.replace(url);
        })


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
                        edit: function(){
                            new PromptConfirmation('#confirmEdit', {
                                url: "/form/working-fiscal-limit/modify/?fiscal_year="+element.year,
                                redirect: true,
                            });
                        },
                        delete: function(){
                            let modalData={
                                matchString: 'delete',
                                url: "/form/working-fiscal-limit/delete",
                                title: "Permanently Delete",
                                message: "Are you sure you want to permanently delete this file? After a file is permanently deleted, it <strong style='color: #343a40'>cannot be recovered.</strong>",
                                data: {year: element.year, stage_id:element.stage_id},
                                btnText: "Yes, delete file",
                                done: function(res){
                                    console.log("res",res);
                                    published.removeFile(card);
                                }
                            }
                            new PromptConfirmation('#confirmDelete', modalData);
                        }
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
