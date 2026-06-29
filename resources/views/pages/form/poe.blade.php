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
            ['name' => 'POE Form', 'route' => '#'],
        ],
        'pageTitle' => 'Program of Expenditures (POE)',
        'log_names' => ['poe']
    ])
   

    <div class="px-4 pt-4" style="background-color: #ebecf0 !important; margin-top: 20px; margin-bottom: 20px;padding:20px;">
        @if(auth()->user()->hasRole(["Planning Focal/Officer"]))
        @include("pages.form.form-filter",["filters"=>["search","stage","month","year"]])
        @else
        @include("pages.form.form-filter",["filters"=>["search","stage","region","month","year"]])
        @endif
    </div>
    <div class="card card-default">
        <div class="card-body" style="padding: 0;">
            <div class="row">
                <div class="col-5 col-sm-2 tabheader">
                    <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link text-center" id="vert-tabs-all-tab" data-toggle="pill" href="#vert-tabs-all" role="tab" 
                            aria-controls="vert-tabs-all" aria-selected="false">
                            <img class="fileicon" src="{{ asset('images/folder.png') }}">
                            ALL FORMS</a>
                        <a class="nav-link text-center" id="vert-tabs-published-tab" data-toggle="pill" href="#vert-tabs-published" role="tab" 
                            aria-controls="vert-tabs-published" aria-selected="true">
                            <img class="fileicon" src="{{ asset('images/folder.png') }}">
                            PUBLISHED</a>
                        <a class="nav-link text-center active" id="vert-tabs-draft-tab" data-toggle="pill" href="#vert-tabs-draft" role="tab" 
                            aria-controls="vert-tabs-draft" aria-selected="false">
                            <img class="fileicon" src="{{ asset('images/folder.png') }}">
                            DRAFT</a>
                        <a class="nav-link text-center" id="vert-tabs-returned-tab" data-toggle="pill" href="#vert-tabs-returned" role="tab" 
                            aria-controls="vert-tabs-returned" aria-selected="false">
                            <img class="fileicon" src="{{ asset('images/folder.png') }}">
                            RETURNED</a>
                        <a class="nav-link text-center" id="vert-tabs-resolved-tab" data-toggle="pill" href="#vert-tabs-resolved" role="tab" 
                            aria-controls="vert-tabs-resolved" aria-selected="false">
                            <img class="fileicon" src="{{ asset('images/folder.png') }}">
                            RESOLVED</a>
                    </div>
                </div>
                <div class="col-7 col-sm-10 tabcontent">
                    <div class="tab-content" id="vert-tabs-tabContent">
                        <div class="tab-pane fade" id="vert-tabs-all" role="tabpanel" aria-labelledby="vert-tabs-all-tab">
                            <div class="row" style="padding: 0 10px;">
                                <div class="col-md-12" id="allforms-container">
                                    <div class="text-center my-5 py-5 pre-loader">Loading....</div>
                                </div>
                                <div class="d-none" id="pagination-links-all" style="border-top: 1px solid #ececec;">

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-published" role="tabpanel" aria-labelledby="vert-tabs-published-tab">
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
                                <div class="d-none" id="pagination-links-published" style="border-top: 1px solid #ececec;">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade active show" id="vert-tabs-draft" role="tabpanel" aria-labelledby="vert-tabs-draft-tab">
                            <div class="card-header" style="padding: 20px;border-bottom: 0;">
                                <a href="#createPAPmodal" data-toggle="modal" type="button" class="btn btn-primary float-right">
                                <i class="fas fa-plus"></i>&nbsp;
                                    Add New</a>
                            </div>
                            <div class="row" style="padding: 0 10px;">
                                <div class="col-md-12" id="drafts-container">
                                   <div class="text-center my-5 py-5 pre-loader">Loading....</div>
                                </div>
                                <div class="d-none" id="pagination-links-drafts" style="border-top: 1px solid #ececec;">

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-returned" role="tabpanel" aria-labelledby="vert-tabs-returned-tab">
                            <div class="row" style="padding: 0 10px;">
                                <div class="col-md-12" id="returned-container">
                                   <div class="text-center my-5 py-5 pre-loader">Loading....</div>
                                </div>
                                <div class="d-none" id="pagination-links-returned" style="border-top: 1px solid #ececec;">

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-resolved" role="tabpanel" aria-labelledby="vert-tabs-resolved-tab">
                            <div class="row" style="padding: 0 10px;">
                                <div class="col-md-12" id="resolved-container">
                                   <div class="text-center my-5 py-5 pre-loader">Loading....</div>
                                </div>
                                <div class="d-none" id="pagination-links-resolved" style="border-top: 1px solid #ececec;">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>


    <!-- create pap -->
    {{-- <div class="modal fade" id="createPAPmodal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="/form/poe/poe-create" method="POST" id="">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create POE</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">PAP</label>
                        <input type="text" name="papname" id="papname" class="form-control form-input" required>
                    </div>
                    <div class="form-group">
						<label class="input-label" for="target_sector">MFO</label><br>
						<select name="mfo" class="select2 form-control" for="target_sector" id="mfo" required>
                            <option value="">Select MFO</option>
                            @foreach ($mfo as $mfo)
                                <option value="{{$mfo->mfo_id}}">{{$mfo->mfo->priorityClass->accronym}}-{{$mfo->mfo->desc}}</option>
                            @endforeach
						</select>
					</div>
                    <div class="form-group" style="display: none" id="kdp-container">
                        <label class="input-label" for="target_sector">KDP/KP/KS</label><br>
                        <select name="kdp" class="select2 form-control" for="target_sector" id="kdp" required>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </div>
            </form>
        </div>
    </div> --}}
    @include('pages.form.poepapkdpmfo-modal', ["mfo"=>$mfo])
    @livewire('modal-confirmation')
    @endsection
    
    @section('script')
    <script src="{{asset('js/poe.js')}}"></script>
    <script>
        const user_id = {{Auth::user()->id}};
        
        // let fetching = false;
        // $('.select2').select2({
        //     theme: 'bootstrap4'
        // })
        // $('#mfo').on('change', function(){
        //     const mfo_id = $(this).val();
        //     $('#kdp-container').slideUp();
        //     getKDPs(mfo_id);
        // });
        
        // const pap = new Searchable('#papname', {
        //     url: window.location.origin+'/form/poe/search/pap',
        //     disableNoDataFound: true,
        //     searchingPropmt: false,
        //     props: {
        //         id: 'id',
        //         text: 'paps',
        //     },
        //     onClick: 'triggerClick',
        //     triggerClick: function(data, onRemove){
        //         pap.getElement().value = data.text;
        //         pap.removeData();
        //     }
        // });
        // function getKDPs(mfo_id) {
        //     if(fetching){return}
        //     fetching = true;
        //     fetch(window.location.origin+"/form/poe/get/kdp/"+mfo_id, {
        //         method: "get",
        //         headers: {
        //             Accept: "application/json, text/plain, */*",
        //             // "Content-Type": "application/json",
        //             "X-CSRF-Token": document.querySelector('[name="csrf-token"]').content,
        //         },
        //     })
        //     .then(function (response) {
        //         if (!response.ok) {
        //             throw new Error("HTTP status " + response.status);
        //         }
        //         return response.json();
        //     })
        //     .then(function (res) {
        //         console.log(res);
        //         let kdp = document.querySelector('#kdp');
        //         kdp.innerHTML='';
        //         for (let i = 0; i < res.length; i++) {
        //             const element = res[i];
        //             let opt = document.createElement('option');
        //             opt.value = res[i].kdp.id;
        //             opt.innerHTML=res[i].kdp.desc;
        //             kdp.appendChild(opt);
        //         }
        //         fetching = false;
        //         $('#kdp-container').slideDown();
        //     });
        // }

        let poe_data = new PoePapKdpMfo({
			create: true,
		});

        
        @if(auth()->user()->hasRole(['Planning Focal/Officer']))
        const filters = ['search', 'stage', 'month', 'year'];
        @else
        const filters = ['search', 'stage', 'service_region', 'month', 'year'];
        @endif



        const fileList = new FileList('poe', {
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
                        view: function(){
                            window.location.href = window.location.origin+"/form/poe/view/"+element.id;
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
        const drafts = new fileList.newList({
            status: "drafts",
            container: "#drafts-container",
            controller: function(data){
                for (let i = 0; i < data.length; i++) {
                    const element = data[i];
                    let card = drafts.generateList(data[i], {
                        publish: function(){
                            new PromptConfirmation('#confirmPublish', {
                                url: "/form/poe/publish",
                                title: "Publish File",
                                message: "Are you sure you want to publish this file?",
                                data: {id: element.id},
                                btnText: "Yes, continue",
                                done: function(res){
                                    drafts.removeFile(card);
                                    published.destroy();
                                }
                            });
                        },
                        edit: function(){
                            new PromptConfirmation('#confirmEdit', {
                                url: "/form/poe/edit/"+element.id,
                                redirect: true,
                            });
                        },
                        delete: function(){
                            let modalData={
                                matchString: 'delete',
                                url: "/form/poe/delete",
                                title: "Permanently Delete",
                                message: "Are you sure you want to permanently delete this file? After a file is permanently deleted, it <strong style='color: #343a40'>cannot be recovered.</strong>",
                                data: {id: element.id},
                                btnText: "Yes, delete file",
                                done: function(res){
                                    returned.removeFile(card);
                                }
                            }
                            new PromptConfirmation('#confirmDelete', modalData);
                        }
                    });
                }
            }
        });
        const returned = new fileList.newList({
            status: "returned",
            container: "#returned-container",
            controller: function(data){
                for (let i = 0; i < data.length; i++) {
                    const element = data[i];
                    let card;
                    let buttons={
                        lockOrUnlock: function(locked){
                            let _this = this;
                            let modalData={
                                url: "/form/poe/lock-unlock",
                                title: "Lock File",
                                message: "Are you sure you want to lock this file? If a file is locked for editing, it <strong style='color: #343a40'>cannot be edited or modified by anyone</strong> unless you unlock the file first.",
                                data: {id: element.id, status:'1'},
                                btnText: "Yes, lock file",
                                done: function(res){
                                    if(element.locked=="0"){
                                        element.locked="1";
                                    }
                                    else{
                                        element.locked="0";
                                    }
                                    returned.reRenderElement(card, element, _this);
                                }
                            }
                            if(locked){
                                modalData.data.status='0';
                                modalData.title="Unlock File";
                                modalData.btnText="Yes, continue";
                                modalData.message="Unlocking a file means anyone who has an access on this file can edit. Are you sure you want to continue?";
                            }
                            new PromptConfirmation('#confirmUnlock', modalData);
                        },
                        viewEye: function(){
                            window.location.href = window.location.origin+"/form/poe/view/"+element.id;
                        },
                        edit: function(){
                            new PromptConfirmation('#confirmEdit', {
                                url: "/form/poe/edit/"+element.id,
                                redirect: true,
                            });
                        },
                        resolve: function(){
                            new PromptConfirmation('#confirmUnlock', {
                                url: "/form/poe/resolve",
                                title: "Resolve Form",
                                message: "Are you sure?",
                                data: {id: element.id},
                                btnText: "Yes, continue",
                                done: function(res){
                                    returned.removeFile(card);
                                    resolved.destroy();
                                }
                            });
                        },
                        delete: function(){
                            let modalData={
                                matchString: 'delete',
                                url: "/form/poe/delete",
                                title: "Permanently Delete",
                                message: "Are you sure you want to permanently delete this file? After a file is permanently deleted, it <strong style='color: #343a40'>cannot be recovered.</strong>",
                                data: {id: element.id},
                                btnText: "Yes, delete file",
                                done: function(res){
                                    returned.removeFile(card);
                                }
                            }
                            new PromptConfirmation('#confirmDelete', modalData);
                        }
                    }
                    if(element.locked == '1' && element.locker_user_id != user_id){
                        delete buttons['lockOrUnlock'];
                    }
                    card = returned.generateReturnedList(element, buttons);
                }
            }
        });
        const resolved = new fileList.newList({
            status: "resolved",
            container: "#resolved-container",
            controller: function(data){
                for (let i = 0; i < data.length; i++) {
                    const element = data[i];
                    let card;
                    let buttons={
                        lockOrUnlock: function(locked){
                            let _this = this;
                            let modalData={
                                url: "/form/poe/lock-unlock",
                                title: "Lock File",
                                message: "Are you sure you want to lock this file? If a file is locked for editing, it <strong style='color: #343a40'>cannot be edited or modified by anyone</strong> unless you unlock the file first.",
                                data: {id: element.id},
                                btnText: "Yes, lock file",
                                done: function(res){
                                    if(element.locked=="0"){
                                        element.locked="1";
                                    }
                                    else{
                                        element.locked="0";
                                    }
                                    resolved.reRenderElement(card, element, _this);
                                }
                            }
                            if(locked){
                                modalData.title="Unlock File";
                                modalData.btnText="Yes, continue";
                                modalData.message="Unlocking a file means anyone who has an access on this file can edit. Are you sure you want to continue?";
                            }
                            new PromptConfirmation('#confirmUnlock', modalData);
                        },
                        viewEye: function(){
                            window.location.href = window.location.origin+"/form/poe/view/"+element.id;
                        },
                        edit: function(){
                            new PromptConfirmation('#confirmEdit', {
                                url: "/form/poe/edit/"+element.id,
                                redirect: true,
                            });
                        },
                        delete: function(){
                            let modalData={
                                matchString: 'delete',
                                url: "/form/poe/delete",
                                title: "Permanently Delete",
                                message: "Are you sure you want to permanently delete this file? After a file is permanently deleted, it <strong style='color: #343a40'>cannot be recovered.</strong>",
                                data: {id: element.id},
                                btnText: "Yes, delete file",
                                done: function(res){
                                    resolved.removeFile(card);
                                }
                            }
                            new PromptConfirmation('#confirmDelete', modalData);
                        }
                    }
                    if(element.locked == '1' && element.locker_user_id != user_id){
                        delete buttons['lockOrUnlock'];
                    }
                    card = resolved.generateReturnedList(element, buttons);
                }
            }
        });
        const allForms = new fileList.newList({
            status: "all",
            container: "#allforms-container",
            controller: function(data){
                console.log("all",data);
                for (let i = 0; i < data.length; i++) {
                    const element = data[i];
                    let card;
                    let buttons={
                        lockOrUnlock: function(locked, btns){
                            let _this = this;
                            let modalData={
                                url: "/form/poe/lock-unlock",
                                title: "Lock File",
                                message: "Are you sure you want to lock this file? If a file is locked for editing, it <strong style='color: #343a40'>cannot be edited or modified by anyone</strong> unless you unlock the file first.",
                                data: {id: element.id},
                                btnText: "Yes, lock file",
                                done: function(res){
                                    if(element.locked=="0"){
                                        element.locked="1";
                                    }
                                    else{
                                        element.locked="0";
                                    }
                                    allForms.reRenderElement(card, element, btns, true);
                                }
                            }
                            if(locked){
                                modalData.title="Unlock File";
                                modalData.btnText="Yes, continue";
                                modalData.message="Unlocking a file means anyone who has an access on this file can edit. Are you sure you want to continue?";
                            }
                            new PromptConfirmation('#confirmUnlock', modalData);
                        },
                        viewEye: function(){
                            window.location.href = window.location.origin+"/form/poe/view/"+element.id;
                        },
                        edit: function(){
                            new PromptConfirmation('#confirmEdit', {
                                url: "/form/poe/edit/"+element.id,
                                redirect: true,
                            });
                        },
                        delete: function(){
                            let modalData={
                                matchString: 'delete',
                                url: "/form/poe/delete",
                                title: "Permanently Delete",
                                message: "Are you sure you want to permanently delete this file? After a file is permanently deleted, it <strong style='color: #343a40'>cannot be recovered.</strong>",
                                data: {id: element.id},
                                btnText: "Yes, delete file",
                                done: function(res){
                                    allForms.removeFile(card);
                                    let renderForm = {
                                        1: drafts.destroy,
                                        2: published.destroy,
                                        4: resolved.destroy,
                                        5: returned.destroy,
                                    }
                                    renderForm[element.status_id]();
                                }
                            }
                            new PromptConfirmation('#confirmDelete', modalData);
                        },
                        view: function(){
                            window.location.href = window.location.origin+"/form/poe/view/"+element.id;
                        },
                        publish: function(){
                            new PromptConfirmation('#confirmPublish', {
                                url: "/form/poe/publish",
                                title: "Publish File",
                                message: "Are you sure you want to publish this file?",
                                data: {id: element.id},
                                btnText: "Yes, continue",
                                done: function(res){
                                    // drafts.removeFile(card);
                                    let badge = card.querySelector('.badge-primary');
                                    badge.classList.remove('badge_draft');
                                    badge.classList.add('badge_published');
                                    badge.innerHTML="Published";
                                    let formBtns = {
                                        view: buttons.view,
                                        delete: buttons.delete,
                                    };
                                    element.status_id = 2;
                                    allForms.reRenderElement(card, element, formBtns, true);
                                    published.destroy();
                                    drafts.destroy();
                                }
                            });
                        },
                        resolve: function(){
                            console.log("buttons", buttons);
                            new PromptConfirmation('#confirmUnlock', {
                                url: "/form/poe/resolve",
                                title: "Resolve Form",
                                message: "Okay.",
                                data: {id: element.id},
                                btnText: "Yes, continue",
                                done: function(res){
                                    let badge = card.querySelector('.badge-primary');
                                    badge.classList.remove('badge_returned');
                                    badge.classList.add('badge_resolved');
                                    badge.innerHTML="Resolved";
                                    element.status_id = 4;
                                    let formBtns = {
                                        lockOrUnlock: buttons.lockOrUnlock,
                                        viewEye: buttons.viewEye,
                                        edit: buttons.edit,
                                        delete: buttons.delete,
                                    };
                                    allForms.reRenderElement(card, element, formBtns, true);
                                    resolved.destroy();
                                }
                            });
                        },
                    }
                    if(element.locked == '1' && element.locker_user_id != user_id){
                        delete buttons['lockOrUnlock'];
                    }
                    card = allForms.generateAllForms(element, buttons);
                }
            }
        });

        
        document.querySelector('#vert-tabs-all-tab').onclick=function(){
            allForms.getFiles();
        }
        document.querySelector('#vert-tabs-published-tab').onclick=function(){
            published.getFiles();
        }
        document.querySelector('#vert-tabs-draft-tab').onclick=function(){
            drafts.getFiles();
        }
        document.querySelector('#vert-tabs-returned-tab').onclick=function(){
            returned.getFiles();
        }
        document.querySelector('#vert-tabs-resolved-tab').onclick=function(){
            resolved.getFiles();
        }

        drafts.getFiles();
    
    </script>
    <script>
        $("#li_forms").addClass('menu-open');
        $("#li_forms>a.li_parent").addClass('active');
        $("#li_poeform").addClass('active');
    </script>
    @endsection
</x-app-layout>
