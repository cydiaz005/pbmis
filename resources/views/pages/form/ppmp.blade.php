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
        'pageTitle' => 'Project Procurement Management Plan (PPMP)',
        
    ])
    
    <div class="px-4 pt-4" style="background-color: #ebecf0 !important; margin-top: 20px; margin-bottom: 20px;padding:20px;">
        @include('pages.form.form-filter',[ "filters"=>["search","stage","region","month","year"]])
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
                        <a class="nav-link text-center active" id="vert-tabs-review-tab" data-toggle="pill" href="#vert-tabs-review" role="tab" 
                            aria-controls="vert-tabs-review" aria-selected="false">
                            <img class="fileicon" src="{{ asset('images/folder.png') }}">
                            FOR REVIEW</a>
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
                            </div>
                            <div class="d-none" id="pagination-links-all" style="border-top: 1px solid #ececec;">

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
                            </div>
                            <div class="d-none" id="pagination-links-published" style="border-top: 1px solid #ececec;">
                            </div>
                        </div>
                        <div class="tab-pane fade active show" id="vert-tabs-review" role="tabpanel" aria-labelledby="vert-tabs-review-tab">
                            <div class="row" style="padding: 0 10px;">
                                <div class="col-md-12" id="for-review-container">
                                   <div class="text-center my-5 py-5 pre-loader">Loading....</div>
                                </div>
                            </div>
                            <div class="d-none" id="pagination-links-for_review" style="border-top: 1px solid #ececec;">

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
                        <div class="tab-pane fade" id="vert-tabs-resolved" role="tabpanel" aria-labelledby="vert-tabs-resolved-tab">
                            <div class="row" style="padding: 0 10px;">
                                <div class="col-md-12" id="resolved-container">
                                   <div class="text-center my-5 py-5 pre-loader">Loading....</div>
                                </div>
                            </div>
                            <div class="d-none" id="pagination-links-resolved" style="border-top: 1px solid #ececec;">

                            </div>
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
        const fileList = new FileList('ppmp', {
            filters: ['search', 'stage', 'service_region', 'month', 'year'],
        });
        const user_id = {{Auth::user()->id}};
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
                            window.location.href = window.location.origin+"/form/ppmp/view/"+element.id;
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
        const forReview = new fileList.newList({
            status: "for_review",
            container: "#for-review-container",
            controller: function(data){
                for (let i = 0; i < data.length; i++) {
                    const element = data[i];
                    console.log("elelemnt",element);
                    let card = forReview.generateList(data[i], {
                        publish: function(){
                            new PromptConfirmation('#confirmPublish', {
                                url: "/form/ppmp/publish",
                                title: "Publish File",
                                message: "Are you sure you want to publish this file?",
                                data: {id: element.id},
                                btnText: "Yes, continue",
                                done: function(res){
                                    forReview.removeFile(card);
                                    published.destroy();
                                }
                            });
                        },
                        viewEye: function(){
                            window.location.href = window.location.origin+"/form/ppmp/view/"+element.id;
                        },
                        return: function(){
                            console.log(element);
                            document.querySelector('#modal-return-pap-title').innerHTML=element.poe.pap_txt || element.poe.suggested_pap.paps;
                            $('#confirmReturn').modal('show');
                            document.querySelector('#modal-return-pap-btn').onclick=function(){
                                $('#confirmReturn').modal('hide');
                                $('.spinner_modal').modal('show');
                                new FormReturn({
                                    url: '/form/poe/return',
                                    data: {
                                        poe_id: element.poe_id,
                                        ppmp_id: element.id,
                                    },
                                    done: function(res){
                                        console.log(res);
                                        forReview.removeFile(card);
                                        $('.spinner_modal').modal('hide');
                                    }
                                });
                            }
                        },
                        delete: function(){
                            let modalData={
                                matchString: 'delete',
                                url: "/form/ppmp/delete",
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
                                url: "/form/ppmp/lock-unlock",
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
                            window.location.href = window.location.origin+"/form/ppmp/view/"+element.id;
                        },
                        edit: function(){
                            new PromptConfirmation('#confirmEdit', {
                                url: "/form/poe/edit/"+element.poe_id,
                                redirect: true,
                            });
                        },
                        resolve: function(){
                            new PromptConfirmation('#confirmUnlock', {
                                url: "/form/ppmp/resolve",
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
                                url: "/form/ppmp/delete",
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
                                url: "/form/ppmp/delete",
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
                                url: "/form/ppmp/delete",
                                title: "Permanently Delete",
                                message: "Are you sure you want to permanently delete this file? After a file is permanently deleted, it <strong style='color: #343a40'>cannot be recovered.</strong>",
                                data: {id: element.id},
                                btnText: "Yes, delete file",
                                done: function(res){
                                    returned.removeFile(card);
                                }
                            }
                            new PromptConfirmation('#confirmDelete', modalData);
                        },
                        view: function(){
                            window.location.href = window.location.origin+"/form/ppmp/view/"+element.id;//poebefore
                        },
                        publish: function(){
                            new PromptConfirmation('#confirmPublish', {
                                url: "/form/ppmp/publish",
                                title: "Publish File",
                                message: "Are you sure you want to publish this file?",
                                data: {id: element.id},
                                btnText: "Yes, continue",
                                done: function(res){
                                    let badge = card.querySelector('.badge-primary');
                                    badge.classList.remove('badge_draft');
                                    badge.classList.add('badge_published');
                                    badge.innerHTML="Published";
                                    
                                    published.destroy();
                                    forReview.destroy();

                                    let formBtns = {
                                        view: buttons.view,
                                        delete: buttons.delete,
                                    };
                                    element.status_id = 2;
                                    allForms.reRenderElement(card, element, formBtns, true);
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
                        return: function(){
                            console.log(element);
                            document.querySelector('#modal-return-pap-title').innerHTML=element.poe.pap_txt || element.poe.suggested_pap.paps;
                            $('#confirmReturn').modal('show');
                            document.querySelector('#modal-return-pap-btn').onclick=function(){
                                $('#confirmReturn').modal('hide');
                                $('.spinner_modal').modal('show');
                                new FormReturn({
                                    url: '/form/poe/return',
                                    data: {
                                        poe_id: element.poe_id,
                                        ppmp_id: element.id,
                                    },
                                    done: function(res){
                                        console.log(res);
                                        forReview.removeFile(card);
                                        $('.spinner_modal').modal('hide');
                                    }
                                });
                            }
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
        document.querySelector('#vert-tabs-review-tab').onclick=function(){
            forReview.getFiles();
        }
        document.querySelector('#vert-tabs-returned-tab').onclick=function(){
            returned.getFiles();
        }
        document.querySelector('#vert-tabs-resolved-tab').onclick=function(){
            resolved.getFiles();
        }
        forReview.getFiles();
    </script>
    <script>
        $("#li_forms").addClass('menu-open');
        $("#li_forms>a.li_parent").addClass('active');
        $("#li_ppmpform").addClass('active');
	</script>
    @endsection
</x-app-layout>
