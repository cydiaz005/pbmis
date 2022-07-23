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
            padding-top: 40px;
        }
        .nav-tabs.flex-column {
            border-right: 0;
            background: #f2f2fb;
        }
        .frmcard{
            margin-bottom: 0;
            /* margin-right: -6%; */
            border-radius: 0;
        }
        .badge-status{
            position: absolute;
            right: 0;
            font-size: 10px !important;
            border-radius: 0;
            padding: 3px 10px;
            font-weight: 400;
            color: #fff;
            text-transform: uppercase;
            border-top-right-radius: 0.25rem;
            border-bottom-left-radius: 0.25rem;
            top: 0;
        }
        .badge-status.unclassified{
            background: var(--red);
        }
        .badge-status.funded{
            background: var(--ocd-tertiary);
        }
        .badge-status.unfunded{
            background: var(--ocd-secondary-hover);
        }
    </style>
    @endsection
    @section('content')

    @livewire('partials.content-header', [
        'breadcrumb' => [
            ['name' => 'Dashboard', 'route' => '/dashboard/admin'],
            ['name' => 'Forms', 'route' => '#'],
            ['name' => 'PPMP Classification', 'route' => '#'],
        ],
        'pageTitle' => 'Project Procurement Management Plan (PPMP) Classification',
    ])
    
    <div class="px-4 pt-4" style="background-color: #ebecf0 !important; margin-top: 20px; margin-bottom: 20px;padding:20px;">
        @include('pages.form.form-filter',[ "filters"=>["search","stage","region","month","year"]])
    </div>
    @if (Auth::user()->hasPermissionTo("form-ppmp-classification-all-access"))
    <div class="">
        <label for="">End Date</label>
        <div class="d-flex justify-content-between">
            <div class="form-group d-flex align-items-center">
                <input type="date" id="classification_end_date" class="form-control" style="width: 10rem" value="{{@$end_date->value}}">
                <button type="button" class="btn btn-primary ml-3" id="save-classification-end-date">Set Due</button>
            </div>
            <div class="d-flex align-items-end">
                <a class="nav-link d-none">Saving(<span id="saving_count">0</span>)...</a>
            </div>
        </div>
    </div>
    @else
        <div class="d-flex justify-content-end w-100">
            <a class="nav-link d-none">Saving(<span id="saving_count">0</span>)...</a>
        </div>
    @endif
    @if(@$lock_all)
       <p class="text-danger mb-2 font-weight-bold">Ppmp Classification locked</p> 
    @endif
    <div class="row">
        <div class="col-md-5">
            <div class="card card-default draggablefrmheight">
                <div class="card-body" style="padding: 30px;">
                    <p class="mb-3"><strong>Note:</strong> Drag PPMP to the right</p>
                    <div id="ppmps">
                        <div class="text-center my-5 py-5 pre-loader">Loading....</div>
                    </div>
                    <div class="d-none" id="pagination-links-draft" style="border-top: 1px solid #ececec;">

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card card-default">
            <div class="card-header" style="padding: 20px;">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Project Procurement Management Plan (PPMP)</h3>
                    {{-- <button class="btn btn-primary" id="save-classifications"><i class="fas fa-save"></i> SAVE</button> --}}
                </div>
                    
                </div>
                <div class="card-body" style="padding: 0;">
                    <div class="row draggefrmheight">
                        <div class="col-5 col-sm-3 tabheader">
                            <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link text-center active" id="vert-tabs-funded-tab" data-toggle="pill" href="#vert-tabs-funded" role="tab" 
                                    aria-controls="vert-tabs-funded" aria-selected="false">
                                    <img class="fileicon" src="{{ asset('images/folder.png') }}">
                                    FUNDED</a>
                                <a class="nav-link text-center" id="vert-tabs-unfunded-tab" data-toggle="pill" href="#vert-tabs-unfunded" role="tab" 
                                    aria-controls="vert-tabs-unfunded" aria-selected="true">
                                    <img class="fileicon" src="{{ asset('images/folder.png') }}">
                                    UNFUNDED</a>
                            </div>
                        </div>
                        <div class="col-7 col-sm-9 tabcontent">
                            <div class="tab-content" id="vert-tabs-tabContent">
                                <div class="tab-pane fade active show" id="vert-tabs-funded" role="tabpanel" aria-labelledby="vert-tabs-funded-tab">
                                    {{-- <div class="text-center placeholder">Drag Here</div> --}}
                                    <div id="ppmps-funded" style="min-height: 15rem">
                                        <div class="text-center my-5 py-5 pre-loader">Loading....</div>
                                    </div>
                                    <div class="d-none" id="pagination-links-published" style="border-top: 1px solid #ececec;">

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="vert-tabs-unfunded" role="tabpanel" aria-labelledby="vert-tabs-unfunded-tab">
                                    {{-- <div class="text-center placeholder">Drag Here</div> --}}
                                    <div id="ppmps-unfunded" style="min-height: 15rem">
                                        <div class="text-center my-5 py-5 pre-loader">Loading....</div>
                                        {{-- @livewire('ppmp-classify-tabcontent.unfunded') --}}
                                    </div>
                                    <div class="d-none" id="pagination-links-for_review" style="border-top: 1px solid #ececec;">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @livewire('modal-confirmation')
    @endsection
    
    @section('script')
    <script src="{{asset('js/poe.js')}}"></script>
    <script src="{{asset('js/settings.js')}}"></script>
    <script>
        console.log(@json($end_date));
        // $('.sidebar-mini').addClass('sidebar-collapse');
        const fundedContainer = document.querySelector('#vert-tabs-funded');
        const unfundedContainer = document.querySelector('#vert-tabs-unfunded');

        const ppmp_con = document.getElementById('ppmps');
        const f_con = document.getElementById('ppmps-funded');
        const uf_con = document.getElementById('ppmps-unfunded');
        // let funded = [];
        // let unfunded = [];
        const isAdmin = {{Auth::user()->hasPermissionTo("form-ppmp-classification-all-access") ? "true":"false"}};
        let myInterval = 0;
        let saving_count = 0;
        let saving_count_el = document.querySelector("#saving_count");

        const fileList = new FileList('ppmp', {
            url: '/form/ppmp/get/unclassified-forms',
            filters: ['search', 'stage', 'service_region', 'month', 'year'],
            refreshAll: true,
        });
        
        const unclassified = new fileList.newList({
            status: "draft",
            container: "#ppmps",
            params: {
                request_status: "all",
            },
            controller: function(data){
                let added = 0;
                for (const key in data) {
                    let card;
                    let btns = {
                        view: function(){
                            window.location.href = window.location.origin+"/form/ppmp/view/"+data[key].id;
                        },
                    }
                    btns['return']=function(){
                        document.querySelector('#modal-return-pap-title').innerHTML=data[key].poe.paptxt || data[key].poe.suggested_pap.paps;
                        $('#confirmReturn').modal('show');
                        document.querySelector('#modal-return-pap-btn').onclick=function(){
                            $('#confirmReturn').modal('hide');
                            $('.spinner_modal').modal('show');
                            new FormReturn({
                                url: '/form/ppmp/return',
                                data: {
                                    ppmp_id: data[key].id,
                                },
                                done: function(res){
                                    console.log(res);
                                    unclassified.removeFile(card);
                                    $('.spinner_modal').modal('hide');
                                }
                            });
                        }
                    }
                    card = unclassified.generatePpmpClassification(data[key], btns, true); 
                }
            }
        });
        const funded = new fileList.newList({
            status: "published",
            container: "#ppmps-funded",
            emptyMessage: "Drag here",
            params: {
                request_status: "1",
            },
            controller: function(data){
                for (const key in data) {
                    let card;
                    let btns = {
                        view: function(){
                            window.location.href = window.location.origin+"/form/ppmp/view/"+data[key].id;
                        },
                    }
                    if(isAdmin){
                        btns['approve']=function(){
                            new PromptConfirmation('#confirmPublish', {
                                url: "/form/ppmp/approve-classification",
                                title: "Approve",
                                message: "Are you sure you want to approve this file?",
                                data: {id: data[key].id},
                                btnText: "Yes, continue",
                                done: function(res){
                                    funded.removeFile(card);
                                }
                            });
                        }
                    }
                    card = funded.generatePpmpClassification(data[key], btns, true); 
                }
            }
        });
        const unfunded = new fileList.newList({
            status: "for_review",
            container: "#ppmps-unfunded",
            emptyMessage: "Drag here",
            params: {
                request_status: "0",
            },
            controller: function(data){
                for (const key in data) {
                    let card;
                    let btns = {
                        view: function(){
                            window.location.href = window.location.origin+"/form/ppmp/view/"+data[key].id;
                        },
                    }
                    if(isAdmin){
                        btns['approve']=function(){
                            new PromptConfirmation('#confirmPublish', {
                                url: "/form/ppmp/approve-classification",
                                title: "Approve",
                                message: "Are you sure you want to approve this file?",
                                data: {id: data[key].id},
                                btnText: "Yes, continue",
                                done: function(res){
                                    unfunded.removeFile(card);
                                }
                            });
                        }
                    }
                    card = unfunded.generatePpmpClassification(data[key], btns, true); 
                }
            }
        });




        
        document.querySelector('#vert-tabs-funded-tab').ondragover=function(){
            if(myInterval > 10){
                $(this).tab('show');
                myInterval = 0;
            }
            myInterval++;
            console.log(myInterval);
        }
        document.querySelector('#vert-tabs-funded-tab').ondragleave=function(){
            myInterval = 0;
        }
        document.querySelector('#vert-tabs-unfunded-tab').ondragover=function(){
            if(myInterval > 10){
                $(this).tab('show');
                myInterval = 0;
            }
            myInterval++;
            console.log(myInterval);
        }
        document.querySelector('#vert-tabs-unfunded-tab').ondragleave=function(){
            myInterval = 0;
        }

        @if(!$lock_all)
        new Sortable(ppmp_con, {
            handle: '.drag_frmdiv',
            group: 'shared', // set both lists to same group
            animation: 150,
            sort: false, 
            dataIdAttr: 'data-id',
            onAdd: function (evt) {
                let id = evt.clone.dataset.id;
                unclassified.refresh();
                updatePpmpStatus({
                    id: id,
                });
                updateButton(evt.item, null, id);
            },
            onRemove: function (evt) {
                unclassified.refresh();
            },
        });
        new Sortable(f_con, {
            handle: '.drag_frmdiv',
            group: 'shared', // set both lists to same group
            animation: 150,
            sort: false, 
            dataIdAttr: 'data-id',
            onAdd: function (evt) {
                funded.refresh();
                let id = evt.clone.dataset.id;
                updatePpmpStatus({
                    id: id,
                    request_status: "1",
                });
                updateButton(evt.item, 1, id);
            },
            onRemove: function (evt) {
                funded.refresh();
                // let id = evt.clone.dataset.id;
                // funded.splice(funded.indexOf(id), 1);
            },
        });
        new Sortable(uf_con, {
            handle: '.drag_frmdiv',
            group: 'shared', // set both lists to same group
            animation: 150,
            sort: false, 
            dataIdAttr: 'data-id',
            onAdd: function (evt) {
                unfunded.refresh();
                let id = evt.clone.dataset.id;
                updatePpmpStatus({
                    id: id,
                    request_status: "0",
                });
                updateButton(evt.item, 0, id);
            },
            onRemove: function (evt) {
                unfunded.refresh();
                // let id = evt.clone.dataset.id;
                // unfunded.splice(unfunded.indexOf(id), 1);
            },
        });
        function updateButton(element, status, id){
            if(isAdmin){
                let approve_btn = element.querySelector('.frmcard_btns').querySelectorAll('a')[1];
                if(status==1 || status==0){
                    approve_btn.innerHTML='&nbsp;Approve';
                    approve_btn.onclick=function(){
                        new PromptConfirmation('#confirmPublish', {
                            url: "/form/ppmp/approve-classification",
                            title: "Approve",
                            message: "Are you sure you want to approve this file?",
                            data: {id: id},
                            btnText: "Yes, continue",
                            done: function(res){
                                if(status==1){
                                    funded.removeFile(element);
                                }
                                else{
                                    unfunded.removeFile(element);
                                }
                            }
                        });
                    }
                }
                else{
                    approve_btn.innerHTML='<i class="fas fa-undo-alt"></i> &nbsp;Return';
                    approve_btn.onclick=function(){
                        document.querySelector('#modal-return-pap-title').innerHTML=element.querySelector('.frmcard_title').innerHTML;
                        $('#confirmReturn').modal('show');
                        document.querySelector('#modal-return-pap-btn').onclick=function(){
                            $('#confirmReturn').modal('hide');
                            $('.spinner_modal').modal('show');
                            new FormReturn({
                                url: '/form/ppmp/return',
                                data: {
                                    ppmp_id: id,
                                },
                                done: function(res){
                                    unclassified.removeFile(element);
                                    $('.spinner_modal').modal('hide');
                                }
                            });
                        }
                    }
                }
            }
        }
        @if (Auth::user()->hasPermissionTo("form-ppmp-classification-all-access"))
            const setting = new Settings();
            document.querySelector("#save-classification-end-date").onclick=function(){
                let date = document.querySelector('#classification_end_date');
                console.log("date", date.value);
                setting.update({key:"classification_end_date", value:date.value}, function(res){
                    console.log("res_date", res);
                });
            }
        @endif
        function updatePpmpStatus(data){
            saving_count++;
            saving_count_el.parentNode.classList.remove('d-none');
            saving_count_el.innerHTML=saving_count;
            document.querySelector("#saving_count").innerHTML=saving_count;
            fetch(window.location.origin + "/form/ppmp/save-classifications",{
                method: "POST",
                headers: {
                    Accept: "application/json, text/plain, */*",
                    "Content-Type": "application/json",
                    "X-CSRF-Token": document.querySelector('[name="csrf-token"]').content,
                },
                body: JSON.stringify(data),
            })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error("HTTP status " + response.status);
                }
                return response.json();
            })
            .then(function(res){
                console.log(res);
                saving_count--;
                saving_count_el.innerHTML=saving_count;
                if(!saving_count){
                    saving_count_el.parentNode.classList.add('d-none');
                }
            }); 
        }
        function UntrackedFile(){
            let data = {};
            let elements = {};
            this.updateOrCreate=function(file){
                if(elements[file.id]){
                    if(data[file.id].status == null){
                        elements[file.id].orig_card.remove();
                    }               
                    elements[file.id].cloned_card.remove();
                }
                data[file.id] = {
                    id: file.id,
                    status: file.status,
                }
                elements[file.id] = {
                    cloned_card: file.cloned_card,
                    orig_card: file.orig_card,
                }
                addElementTag(file.id);
                published.refresh();
                untracked_files_placeholder.remove();
                
            }
            this.exists=function(id){
                return data[id] ? true:false;
            }

            function addElementTag(id){
                let text = data[id].status == 1 ? "funded":data[id].status == 0 ? "unfunded":"unclassified";
                let badge = document.createElement('span');
                badge.className="badge badge-primary badge-status "+text;
                badge.innerHTML= text;
                let oldBadge = elements[id].cloned_card.querySelector('.badge');
                if(oldBadge){
                    oldBadge.remove();
                }
                let oldBadgeItem = elements[id].orig_card.querySelector('.badge');
                if(oldBadgeItem){
                    oldBadgeItem.remove();
                }
                elements[id].cloned_card.querySelector('.card').prepend(badge);
                elements[id].cloned_card.style="";
                untracked_files.append(elements[id].cloned_card);
            }

            this.get=function(){
                console.log(elements);
                console.log(data);
            }
        }
        @endif
        unclassified.getFiles(undefined, true);
        funded.getFiles(undefined, true);
        unfunded.getFiles(undefined, true);

    </script>
    <script>
        $("#li_forms").addClass('menu-open');
        $("#li_forms>a.li_parent").addClass('active');
        $("#li_ppmpclassify").addClass('active');
	</script>
    @endsection
</x-app-layout>
