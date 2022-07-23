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
                <div class="col-7 col-sm-10 tabcontent" style="min-height: 25rem">
                    <div class="tab-content" id="vert-tabs-tabContent">
                        <div class="tab-pane fade active show" id="vert-tabs-all" role="tabpanel" aria-labelledby="vert-tabs-all-tab">
                            <div class="card-header" style="padding: 20px;border-bottom: 0;">
                                <a href="#create-app-form-modal" data-toggle="modal" type="button" class="btn btn-primary float-right">
                                <i class="fas fa-plus"></i>&nbsp;
                                    Add New</a>
                            </div>
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
                                <div class="d-none" id="pagination-links-all" style="border-top: 1px solid #ececec;">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <div class="modal fade" id="create-app-form-modal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create APP Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">Year</label>
                        <select name="app-form-year" id="app-form-year" class="form-control form-input" required>
                            @for ($i=2021; $i <= date('Y'); $i++)
                                <option value="{{$i}}" {{$i == date('Y') ? "selected":""}}>{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="create-app-form-btn">Create</button>
                </div>
            </div>
        </div>
    </div>


    <!-- create pap -->

    @livewire('modal-confirmation')
    @endsection
    
    @section('script')
    <script src="{{asset('js/poe.js')}}"></script>
    <script>
        let fetching = false;

        document.querySelector("#create-app-form-btn").onclick=function(){
            window.location.href="/form/app-form/create/"+document.querySelector('#app-form-year').value
        }
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
                        edit: function(){
                            new PromptConfirmation('#confirmEdit', {
                                url: "/form/app-form/edit/"+element.id,
                                redirect: true,
                            });
                        },
                        delete: function(){
                            let modalData={
                                matchString: 'delete',
                                url: "/form/app-form/delete",
                                title: "Permanently Delete",
                                message: "Are you sure you want to permanently delete this file? After a file is permanently deleted, it <strong style='color: #343a40'>cannot be recovered.</strong>",
                                data: {id: element.id},
                                btnText: "Yes, delete file",
                                done: function(res){
                                    allForms.removeFile(card);
                                }
                            }
                            new PromptConfirmation('#confirmDelete', modalData);
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
        $("#li_forms").addClass('menu-open');
        $("#li_forms>a.li_parent").addClass('active');
        $("#li_appform").addClass('active');
    </script>
    @endsection
</x-app-layout>
