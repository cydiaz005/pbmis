<x-app-layout>
    @section('style')
        <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
        <style>
            .progress {
                width: 100% !important;
            }

            .progress-bar-wrapper {
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
                width: 100% !important;
                height: 100% !important;
                display: flex;
                align-items: center;
                background: rgba(0, 0, 0, 0.1);
                padding: .5rem;
                border-radius: 10px;
            }

            div.note-editable {
                position: relative !important;
            }

            div.note-editable p {
                pointer-events: none !important;
            }

            div.note-editable.dz-drag-hover::after {
                content: 'Drop files here';
                /* background: red !important; */
                /* border: blue dashed 2px; */
                opacity: .7;
                width: 100%;
                height: 100%;
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
                text-align: center;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                color: #a7a7a7;
                font-size: 1.5rem;

            }

            .dz-upload {
                display: block;
                border-radius: 5px;
                background-color: #2C88D9;
                height: 10px;
                width: 0;
            }

            .dz-preview {
                width: 120px !important;
                height: 140px !important;
                position: relative;
                display: block;
                margin: 1.5rem;

            }

            .dz-image {
                position: relative;
                display: flex;
                justify-content: center;
            }

            .dz-image .dz-success-mark {
                position: absolute;
                right: 15px;
                top: 5px;
            }

            .dz-image img {
                border-radius: 20px;
                overflow: hidden;
                width: 90px !important;
                height: 90px !important;
                display: block;
                /* z-index: 10; */
            }

            .dz-error .dz-image img,
            .dz-complete .dz-image img {
                filter: none !important;
                -webkit-filter: none !important;
            }

            .dz-image img {
                object-fit: cover;
                filter: blur(8px);
                -webkit-filter: blur(8px);
            }

            .dz-remove {
                display: block;
                text-align: center;
                font-size: .8rem;
            }

            .bcc-mail-btn {
                position: absolute;
                top: 7px;
                right: 10px;
                color: #a7a7a7;
                font-weight: normal;
                cursor: pointer;
            }

        </style>
    @endsection

    @section('content')
        @livewire('partials.content-header', [
        'pageTitle' => 'Compose',
        'breadcrumb' => [
        ['name' => 'Home', 'route' => '/dashboard/admin'],
        ['name' => 'Mail', 'route' => '#'],
        ['name' => 'Compose', 'route' => '#'],
        ]
        ])
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    @include('pages.mail.mail-navs')
                    <div class="col-md-9">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><?php 
                                
                                if(@$draftmail){ ?>
                                    Update Draft Email
                                    <?php
                                }else{ ?>
                                    Compose New Message
                                    <?php
                                } 
                                
                                ?></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group position-relative">
                                    <input id="sendTo" class="form-control" placeholder="To:">
                                    {{-- <a class="bcc-mail-btn" for="mail-thread">BCC</a> --}}
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Subject:" id="mail-subject">
                                </div>
                                <div class="form-group">
                                    <div>
                                        <textarea id="compose-textarea" class="form-control" style="height: 300px"></textarea>
                                    </div>
                                </div>
                                <div id="file-preview" class="dropzone-previews row mx-0">

                                </div>
                                <div id="template-preview" class="d-none">
                                    <div class="dz-preview dz-file-preview">
                                        <div class="dz-image">
                                            <img data-dz-thumbnail>
                                            <div class="progress-bar-wrapper">
                                                <div class="progress progress-xs">
                                                    <div class="progress-bar bg-success progress-bar-striped"
                                                        role="progressbar" aria-valuenow="60" aria-valuemin="0"
                                                        aria-valuemax="100" style="width: 0%">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dz-details">
                                            <div class="dz-filename text-truncate text-center"><span
                                                    data-dz-name>Test</span></div>
                                            <small class="text-muted text-center">
                                                <div class="dz-size" data-dz-size>10 KB</div>
                                            </small>
                                        </div>
                                        <div class="dz-error-message text-danger text-center"><small><span
                                                    data-dz-errormessage></span></small></div>
                                        <div class="d-flex justify-content-center">
                                            <a class="dz-remove" data-dz-remove></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <div id="upload-btn" class="btn btn-default btn-file">
                                        <i class="fas fa-paperclip"></i> Attachment
                                    </div>
                                    <p class="help-block">Max. 32MB</p>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="float-right">
                                    <?php 
                                if(!@$draftmail){ ?>
                                    <button type="button" id="save-draft-btn" class="btn btn-default"><i
                                            class="fas fa-pencil-alt"></i> Draft</button>
                                    <?php
                                }    
                            ?>

                                    <button type="button" id="send-mail-btn" class="btn btn-primary "><i
                                            class="far fa-envelope"></i> Send</button>
                                </div>
                                <button type="reset" class="btn btn-default" id="discard"><i
                                        class="fas fa-times"></i>Discard</button>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    @endsection

    @section('script')
        <script>
            let draftMail = @json(@$draftmail);
            const token = `{{ csrf_token() }}`;
            const header= 'X-CSRF-TOKEN';
        </script>
        <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
        <script src="{{ asset('js/mail/compose.js') }}"></script>
        <script>
      
            $("#discard").on("click", () => {
               // window.location.href = "/mail/inbox";
            })
            $("#li_mail").addClass('active');
            if(draftMail){
                
                let filePreview = document.getElementById("file-preview");
                const reLoadContent = (preview) =>  {
                    preview.forEach(data => {
                 
                            let div = document.createElement("div");
                            div.className = "dz-preview dz-processing dz-image-preview dz-complete";
                            div.innerHTML = `                         
                                        <div class="dz-image">
                                            <img data-dz-thumbnail src="${window.location.origin+"/"}${data.path}" alt="${data.name}">
                                        </div>
                                        <div class="dz-details">
                                            <div class="dz-filename text-truncate text-center"><span
                                                    data-dz-name>Test</span></div>
                                            <small class="text-muted text-center">
                                                <div class="dz-size" data-dz-size>${data.size}</div>
                                            </small>
                                            
                                        </div>
                                        <a class="dz-remove remove-to-mail" data-dz-remove="" style="cursor: pointer">Remove file</a>
                            `;
                            div.querySelector(".remove-to-mail").onclick = (e) => {
                                    var target = event.target;
                                    $.ajax({
                                    url: `/mail/delete-mail-file/${data.id}`,
                                    type: "POST",
                                    beforeSend: function(xhr){
                                        xhr.setRequestHeader('X-CSRF-TOKEN', token)
                                        xhr.setRequestHeader('X-Requested-With', "XMLHttpRequest")
                                    ;},
                                        success: function (result) {
                                            var parent = target.parentElement.remove();
                                    }});
                            }
                            filePreview.appendChild(div)

                    })  
                }
                $("file-preview").empty();
                if(Array.isArray(draftMail.mail.files)){
                    reLoadContent(draftMail.mail.files)
                }
               
            }

            
        </script>
    @endsection
</x-app-layout>
