<x-app-layout>
    <link rel="stylesheet" type="text/css" 
     href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
            ['name' => 'OPC/OPS Form', 'route' => '#'],
        ],
        'pageTitle' => 'OPC/OPS Form',
    ])

    <div class="d-flex justify-content-end mb-3">
        <a href="#createOPCmodal" data-toggle="modal" class="btn btn-warning">Create</a>
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

                            <a class="nav-link text-center" id="vert-tabs-published-tab" data-toggle="pill" href="#vert-tabs-published" role="tab" 
                            aria-controls="vert-tabs-published" aria-selected="true">
                            <img class="fileicon" src="{{ asset('images/folder.png') }}">
                            PUBLISHED</a>
                            <a class="nav-link text-center" id="vert-tabs-review-tab" data-toggle="pill" href="#vert-tabs-review" role="tab" 
                            aria-controls="vert-tabs-review" aria-selected="false">
                            <img class="fileicon" src="{{ asset('images/folder.png') }}">
                            FOR REVIEW</a>
                        <a class="nav-link text-center" id="vert-tabs-draft-tab" data-toggle="pill" href="#vert-tabs-draft" role="tab" 
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
                       
                       
                        <div class="tab-pane fade active show" id="vert-tabs-all" role="tabpanel" aria-labelledby="vert-tabs-all-tab">
                            @livewire('opc-tab-content.all')
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-draft" role="tabpanel" aria-labelledby="vert-tabs-returned-tab">
                            @livewire('opc-tab-content.draft')
                       
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-published" role="tabpanel" aria-labelledby="vert-tabs-returned-tab">
                            @livewire('opc-tab-content.published')
                       
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-returned" role="tabpanel" aria-labelledby="vert-tabs-returned-tab">
                            @livewire('opc-tab-content.returned')
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-review" role="tabpanel" aria-labelledby="vert-tabs-review-tab">
                            @livewire('opc-tab-content.review')
                        
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
                            <option value="1">1st Semester</option>
                            <option value="2">2nd Semester</option>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        let selectedId;

        @if(Session::has('error'))
            toastr.error("{{ session('error') }}");
        @endif
       
        
        const onEdit=(id)=>{
            selectedId = id;
        }
        const onDelete=(id)=>{
            selectedId = id;
        }

        const onUnlock=(id)=>{
            selectedId = id;
        }
        const onPublish=(id)=>{
            selectedId = id;
        }
        const onSubmit =(id)=> {
            selectedId = id;
        }
        const onReturn=(id)=>{
            selectedId = id;
        }
       

        const confirmPublishButton = document.querySelector("#confirmPublishButton")
        const confirmDeleteButton = document.querySelector("#confirmDeleteButton")
        const confirmEditButton = document.querySelector("#confirmEditButton")
        const confirmReturnButton = document.querySelector("#confirmReturnButton")
        const confirmSubmitButton = document.querySelector("#confirmSubmitButton")
      
        const confirmUnlockButton = document.querySelector("#confirmUnlockButton")
        confirmUnlockButton.addEventListener('click', async()=>{
                try {
                    await $.ajax({
                        type:'PUT',
                        url: window.location.origin+"/form/opc/unlock/"+selectedId,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: async function(response){
                            console.log({response});
                        }
                    })
                } catch (error) {
            console.error(error.message)
                    
                }
                finally{
                    location.reload()
                }
        })

        confirmPublishButton.addEventListener('click', async()=>{
                try {
                    await $.ajax({
                        type:'PUT',
                        url: window.location.origin+"/form/opc/publish/"+selectedId,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: async function(response){
                            console.log({response});
                        }
                    })
                } catch (error) {
                    console.error(error.message)
                }
                finally{
                    location.reload()
                }
        })

        


        confirmEditButton.addEventListener('click',function(){
            window.location.replace(window.location.href+"/edit/"+selectedId);
        })
        confirmDeleteButton.addEventListener('click', async()=>{

            try {
                await $.ajax({
            type:'DELETE',
            url: window.location.origin+"/form/opc/delete/"+selectedId,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: async function(response){
                console.log({response});
            }
            })
            } catch (error) {
                
            }
            finally{
                location.reload()

            }
           
        
          
        })

        confirmSubmitButton.addEventListener('click', async()=>{
                try {
                await $.ajax({
                type:'PUT',
                url: window.location.origin+"/form/opc/change-status/"+selectedId,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    status_id:3
                },
                success: async function(response){
                    console.log({response});
                }
                })
                } catch (error) {
                    
                }
                finally{
                    location.reload()

            }

        })

        confirmReturnButton.addEventListener('click', async()=>{
                try {
                    await $.ajax({
                        type:'PUT',
                        url: window.location.origin+"/form/opc/change-status/"+selectedId,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {
                            status_id: 4
                        },
                        success: async function(response){
                            console.log({response});
                        }
                    })
                } catch (error) {
                    
                }
                finally{
                    location.reload()

            }

        })

        const from_date = document.querySelector("#from_date");
        const to_date = document.querySelector("#to_date");


        from_date.onchange = function(){
            let sanitized_from_date = new Date(from_date.value)
            let max_to_date = new Date(from_date.value)
            max_to_date.setFullYear(sanitized_from_date.getFullYear()+1); 
            var dd = max_to_date.getDate();
            var mm = max_to_date.getMonth() + 1; 
            var yyyy = max_to_date.getFullYear();

            if (dd < 10) {
            dd = '0' + dd;
            }

            if (mm < 10) {
            mm = '0' + mm;
            } 
            max_to_date_string = yyyy + '-' + mm + '-' + dd;

            if(to_date.value){
                let sanitized_to_date = new Date(to_date.value)
                if(sanitized_to_date.getTime()>max_to_date.getTime()){
                    to_date.value = max_to_date_string
                }
            }
            else{
                to_date.value = max_to_date_string
            }

            to_date.setAttribute("max",max_to_date_string);

        };

        // $('.sidebar-mini').addClass('sidebar-collapse');
        $("#li_forms").addClass('menu-open');
        $("#li_forms>a.li_parent").addClass('active');
        $("#li_opcform").addClass('active');



    </script>
    @endsection
</x-app-layout>
