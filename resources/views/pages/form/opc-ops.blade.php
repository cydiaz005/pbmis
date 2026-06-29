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
            ['name' => 'PPMP Form', 'route' => '#'],
        ],
        'pageTitle' => 'OPC/OPS Form',
        
    ])
    <div class="px-4 pt-4" style="background-color: #ebecf0 !important; margin-top: 20px; margin-bottom: 20px;padding:20px;">
        @if(auth()->user()->hasRole(["Planning Focal/Officer"]))
        @include("pages.form.form-filter",["filters"=>["semester","year"]])
        @else
        @include("pages.form.form-filter",["filters"=>["region","semester","year"]])
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
                        @if(!auth()->user()->hasRole(["Planning Focal/Officer"]))
                        <a class="nav-link text-center" id="vert-tabs-review-tab" data-toggle="pill" href="#vert-tabs-review" role="tab" 
                            aria-controls="vert-tabs-review" aria-selected="false">
                            <img class="fileicon" src="{{ asset('images/folder.png') }}">
                            FOR REVIEW</a>
                        @endif
                        <a class="nav-link text-center active" id="vert-tabs-draft-tab" data-toggle="pill" href="#vert-tabs-draft" role="tab" 
                            aria-controls="vert-tabs-draft" aria-selected="false">
                            <img class="fileicon" src="{{ asset('images/folder.png') }}">
                            DRAFT</a>
                        <a class="nav-link text-center" id="vert-tabs-returned-tab" data-toggle="pill" href="#vert-tabs-returned" role="tab" 
                            aria-controls="vert-tabs-returned" aria-selected="false">
                            <img class="fileicon" src="{{ asset('images/folder.png') }}">
                            RETURNED</a>
                    </div>
                </div>
                <div class="col-7 col-sm-10 tabcontent">
                    <div class="tab-content" id="vert-tabs-tabContent">
                        <div class="tab-pane fade" id="vert-tabs-all" role="tabpanel" aria-labelledby="vert-tabs-all-tab">
                            <div class="row" style="padding: 0 10px;">
                                <div class="col-md-12" id="allforms-container">
                                <div class="text-center my-5 py-5 pre-loader">Loading....</div>
                                </div>
                            </div>
                            <div class="d-none" id="pagination-links-all" style="border-top: 1px solid #ececec;">

                            </div>
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-published" role="tabpanel" aria-labelledby="vert-tabs-published-tab">
                            <div class="row" style="padding: 0 10px;">
                                <div class="col-md-12" id="published-container">
                                   <div class="text-center my-5 py-5 pre-loader">Loading....</div>
                                </div>
                            </div>
                            <div class="d-none" id="pagination-links-published" style="border-top: 1px solid #ececec;">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-review" role="tabpanel" aria-labelledby="vert-tabs-review-tab">
                            <div class="row" style="padding: 0 10px;">
                                <div class="col-md-12" id="for-review-container">
                                   <div class="text-center my-5 py-5 pre-loader">Loading....</div>
                                </div>
                            </div>
                            <div class="d-none" id="pagination-links-for_review" style="border-top: 1px solid #ececec;">

                            </div>
                        </div>
                        <div class="tab-pane fade active show" id="vert-tabs-draft" role="tabpanel" aria-labelledby="vert-tabs-draft-tab">
                            <div class="card-header d-flex justify-content-end" style="padding: 20px;border-bottom: 0;">
                                <a href="#createOPCmodal" data-toggle="modal" class="btn btn-warning">Create</a>
                            </div>
                            <div class="row" style="padding: 0 10px;">
                                <div class="col-md-12" id="drafts-container">
                                   <div class="text-center my-5 py-5 pre-loader">Loading....</div>
                                </div>
                            </div>
                            <div class="d-none" id="pagination-links-drafts" style="border-top: 1px solid #ececec;">

                            </div>
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-returned" role="tabpanel" aria-labelledby="vert-tabs-returned-tab">
                            <div class="row" style="padding: 0 10px;">
                                <div class="col-md-12" id="returned-container">
                                   <div class="text-center my-5 py-5 pre-loader">Loading....</div>
                                </div>
                            </div>
                            <div class="d-none" id="pagination-links-returned" style="border-top: 1px solid #ececec;">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <div class="modal fade" id="createOPCmodal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="/form/opc/init-create" method="POST" id="">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create OPC/OPS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- <div class="mb-3">
                        <label class="input-label" for="target_sector">From</label><br>
                        <input type="date" id="from_date" value="" name="from_date" class="form-control form-input" required>
                    </div>
                    <div class="mb-3">
                        <label class="input-label" for="target_sector">To</label><br>
                        <input type="date" id="to_date"  max="" value="" name="to_date" class="form-control form-input" required>
                    </div> --}}
                  
                    <div class="form-group">
						<label class="input-label" for="semester">Semester</label><br>
						<select name="semester" class="select2 form-control" for="semester" id="semester" required>
                            <option value="">Select Semester</option>
                                <option value="1">1st Semester </option>
                                <option value="2">2nd Semester  </option>
						</select>
					</div>
                    <div class="form-group">
						<label class="input-label" for="year">Year</label><br>
                        <select name="year" class="select2 form-control" for="year" id="year" required>
                            <option value="">Select Year</option>
                            <option value="{{date("Y")}}">{{date("Y")}}</option>
                            <option value="{{date("Y")-1}}">{{date("Y")-1}}</option>
                        </select>
					</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button id="confirmCreateButton" type="submit" class="btn btn-primary">Create</button>
                </div>
            </div>
            </form>
        </div>
    </div>
    @livewire('modal-confirmation')
    @endsection
    
    @section('script')
    <script src="{{asset('js/poe.js')}}"></script>
    <script>
        @if(auth()->user()->hasRole(['Planning Focal/Officer']))
        const filters = ['semester', 'year'];
        @else
        const filters = ['service_region', 'semester', 'year'];
        @endif
        const fileList = new FileList('opc',{
            filters: filters,
            url: '/form/opc/fetch-data',
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
                                url: "/form/opc/lock-unlock",
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
                                    allForms.reRenderOpcElement(card, element, btns, true);
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
                            window.location.href = window.location.origin+"/form/opc/"+element.id;
                        },
                        edit: function(){
                            new PromptConfirmation('#confirmEdit', {
                                url: "/form/opc/edit/"+element.id,
                                redirect: true,
                            });
                        },
                        delete: function(){
                            let modalData={
                                method: 'DELETE',
                                matchString: 'delete',
                                url: "/form/opc/delete/"+element.id,
                                title: "Permanently Delete",
                                message: "Are you sure you want to permanently delete this file? After a file is permanently deleted, it <strong style='color: #343a40'>cannot be recovered.</strong>",
                                btnText: "Yes, delete file",
                                done: function(res){
                                    drafts.removeFile(card);
                                    allForms.destroy();
                                }
                            }
                            new PromptConfirmation('#confirmDelete', modalData);
                        },
                        view: function(){
                            window.location.href = window.location.origin+"/form/opc/"+element.id;
                        },
                        publish: function(){
                            new PromptConfirmation('#confirmPublish', {
                                method: "PUT",
                                url: "/form/opc/publish/"+element.id,
                                title: "Publish File",
                                message: "Are you sure you want to publish this file?",
                                data: {id: element.id},
                                btnText: "Yes, continue",
                                done: function(res){
                                    forReview.removeFile(card);
                                    published.destroy();
                                    allForms.destroy();
                                }
                            });
                        },
                        submit: function(){
                            new PromptConfirmation('#confirmPublish', {
                                url: "/form/opc/change-status/"+element.id,
                                method: "PUT",
                                title: "Submit File",
                                message: "Are you sure you want to submit this file?",
                                data: {status_id: 3},
                                btnText: "Yes, continue",
                                done: function(res){
                                    drafts.removeFile(card);
                                    allForms.destroy();
                                    forReview.destroy();
                                }
                            });
                        },
                    }
                    card = allForms.generateAllOpcForms(element, buttons);
                }
            }
        });
        const published = new fileList.newList({
            status: "published",
            container: "#published-container",
            controller: function(data, other_params){
                for (let i = 0; i < data.length; i++) {
                    const element = data[i];
                    let card = published.generateOpcList(data[i], {
                        view: function(){
                            window.location.href = window.location.origin+"/form/opc/"+element.id;
                        },
                        delete: function(){
                            console.log('deleted');
                        }
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
        @if(!auth()->user()->hasRole(['Planning Focal/Officer']))
        const forReview = new fileList.newList({
            status: "for_review",
            container: "#for-review-container",
            controller: function(data){
                for (let i = 0; i < data.length; i++) {
                    const element = data[i];
                    console.log("elelemnt",element);
                    let card = forReview.generateOpcList(data[i], {
                        publish: function(){
                            new PromptConfirmation('#confirmPublish', {
                                method: "PUT",
                                url: "/form/opc/publish/"+element.id,
                                title: "Publish File",
                                message: "Are you sure you want to publish this file?",
                                data: {id: element.id},
                                btnText: "Yes, continue",
                                done: function(res){
                                    forReview.removeFile(card);
                                    published.destroy();
                                    allForms.destroy();
                                }
                            });
                        },
                        viewEye: function(){
                            window.location.href = window.location.origin+"/form/opc/"+element.id;
                        },
                        return: function(){
                            document.querySelector('#modal-return-pap-title').innerHTML="OPC/OPS, "+element.service_region.service_region + ", " + (element.semester == 1 ? "1st Semester":"2nd Semester");
                            $('#confirmReturn').modal('show');
                            document.querySelector('#modal-return-pap-btn').onclick=function(){
                                $('#confirmReturn').modal('hide');
                                $('.spinner_modal').modal('show');
                                new FormReturn({
                                    url: '/form/opc/return',
                                    data: {
                                        opc_id: element.id,
                                    },
                                    done: function(res){
                                        console.log(res);
                                        forReview.removeFile(card);
                                        allForms.destroy();
                                        $('.spinner_modal').modal('hide');
                                    }
                                });
                            }
                        },
                        delete: function(){
                            let modalData={
                                method: 'DELETE',
                                matchString: 'delete',
                                url: "/form/opc/delete/"+element.id,
                                title: "Permanently Delete",
                                message: "Are you sure you want to permanently delete this file? After a file is permanently deleted, it <strong style='color: #343a40'>cannot be recovered.</strong>",
                                btnText: "Yes, delete file",
                                done: function(res){
                                    drafts.removeFile(card);
                                    allForms.destroy();
                                }
                            }
                            new PromptConfirmation('#confirmDelete', modalData);
                        }
                    });
                }
            }
        });
        @endif
        const drafts = new fileList.newList({
            status: "drafts",
            container: "#drafts-container",
            controller: function(data){
                for (let i = 0; i < data.length; i++) {
                    const element = data[i];
                    let card = drafts.generateOpcList(data[i], {
                        submit: function(){
                            new PromptConfirmation('#confirmPublish', {
                                url: "/form/opc/change-status/"+element.id,
                                method: "PUT",
                                title: "Submit File",
                                message: "Are you sure you want to submit this file?",
                                data: {status_id: 3},
                                btnText: "Yes, continue",
                                done: function(res){
                                    drafts.removeFile(card);
                                    allForms.destroy();
                                    forReview.destroy();
                                }
                            });
                        },
                        edit: function(){
                            new PromptConfirmation('#confirmEdit', {
                                url: "/form/opc/edit/"+element.id,
                                redirect: true,
                            });
                        },
                        delete: function(){
                            let modalData={
                                method: 'DELETE',
                                matchString: 'delete',
                                url: "/form/opc/delete/"+element.id,
                                title: "Permanently Delete",
                                message: "Are you sure you want to permanently delete this file? After a file is permanently deleted, it <strong style='color: #343a40'>cannot be recovered.</strong>",
                                btnText: "Yes, delete file",
                                done: function(res){
                                    drafts.removeFile(card);
                                    allForms.destroy();
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
                                url: "/form/opc/lock-unlock",
                                title: "Lock File",
                                message: "Are you sure you want to lock this file? If a file is locked for editing, it <strong style='color: #343a40'>cannot be edited or modified by anyone</strong> unless you unlock the file first.",
                                data: {id: element.id, status:'1'},
                                btnText: "Yes, lock file",
                                done: function(res){
                                    console.log("res", res);
                                    if(element.locked=="0"){
                                        element.locked="1";
                                    }
                                    else{
                                        element.locked="0";
                                    }
                                    returned.reRenderOpcElement(card, element, _this);
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
                            window.location.href = window.location.origin+"/form/opc/"+element.id;
                        },
                        edit: function(){
                            new PromptConfirmation('#confirmEdit', {
                                url: "/form/opc/edit/"+element.id,
                                redirect: true,
                            });
                        },
                        submit: function(){
                            new PromptConfirmation('#confirmPublish', {
                                url: "/form/opc/change-status/"+element.id,
                                method: "PUT",
                                title: "Submit File",
                                message: "Are you sure you want to submit this file?",
                                data: {status_id: 3},
                                btnText: "Yes, continue",
                                done: function(res){
                                    drafts.removeFile(card);
                                    allForms.destroy();
                                    forReview.destroy();
                                }
                            });
                        },
                        delete: function(){
                            let modalData={
                                method: 'DELETE',
                                matchString: 'delete',
                                url: "/form/opc/delete/"+element.id,
                                title: "Permanently Delete",
                                message: "Are you sure you want to permanently delete this file? After a file is permanently deleted, it <strong style='color: #343a40'>cannot be recovered.</strong>",
                                btnText: "Yes, delete file",
                                done: function(res){
                                    drafts.removeFile(card);
                                    allForms.destroy();
                                }
                            }
                            new PromptConfirmation('#confirmDelete', modalData);
                        },
                    }
                    card = returned.generateReturnedOpc(element, buttons);
                }
            }
        });

        document.querySelector('#vert-tabs-all-tab').onclick=function(){
            allForms.getFiles();
        }
        document.querySelector('#vert-tabs-published-tab').onclick=function(){
            published.getFiles();
        }
        @if(!auth()->user()->hasRole(['Planning Focal/Officer']))
        document.querySelector('#vert-tabs-review-tab').onclick=function(){
            forReview.getFiles();
        }
        @endif
        document.querySelector('#vert-tabs-draft-tab').onclick=function(){
            drafts.getFiles();
        }
        document.querySelector('#vert-tabs-returned-tab').onclick=function(){
            returned.getFiles();
        }

        drafts.getFiles();
    </script>
    <script>
        $("#li_forms").addClass('menu-open');
        $("#li_forms>a.li_parent").addClass('active');
        $("#li_opcform").addClass('active');
	</script>
    @endsection
</x-app-layout>
