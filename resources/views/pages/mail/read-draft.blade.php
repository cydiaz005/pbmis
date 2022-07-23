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




 <!-- Main content -->
 <section class="content">
    <div class="container-fluid">
        <div class="row">
            @include('pages.mail.mail-navs')
            <div class="col-md-9">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Read Mail</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-default btn-sm" data-container="body" title="Delete">
                                <i class="far fa-trash-alt"></i>
                            </button>
                            <button type="button" class="btn btn-default btn-sm" data-container="body" title="Reply">
                                <i class="fas fa-reply"></i>
                            </button>
                            <button type="button" class="btn btn-default btn-sm" data-container="body" title="Forward">
                                <i class="fas fa-share"></i>
                            </button>
                            <button type="button" class="btn btn-default btn-sm" title="Print">
                                <i class="fas fa-print"></i>
                            </button>
                        </div>
                    </div>
                <!-- /.card-header -->
                    <div class="card-body p-3">
                        <div class="mailbox-read-info">
                            <h5>{{count($mail->recipients) < 0 ?"No Reciept found": ""}}</h5>
                            <h6>From:
                                <div class="row m-0 appendDiv">
                                <?php 
                                    if(gettype($mail->recipients == "array")){
                                        foreach ($mail->recipients as $value) { ?>
                                                
                                                        <div class="col-md-3 col-6 my-2">
                                                            <div class="d-flex align-items-center chip_append">
                                                                <img src="https://ui-avatars.com/api/?name={{$value->user->firstname." ".$value->user->lastname}} Jonas Alan&amp;color=7F9CF5&amp;background=EBF4FF" width="36" height="36" style="border-radius: 50%;">
                                                                    <div class="d-flex justify-content-between text-truncate w-100">
                                                                        <span class="artist_name text-truncate ml-2">{{$value->user->email}}</span>
                                                                    </div>
                                                            </div>
                                                        </div>
                                               
                                        
                                        <?php 
                                        }
                                    }
                                ?>
                                 </div>
                            <span class="mailbox-read-time float-right">{{$date}}</span></h6>
                        </div>
                        <div class="mailbox-read-info">
                            <h5>{{(@$mail->subject) ?: "No Subject"}}</h5>
                            <h6>From: {{@$mail->sender->email}}
                            <span class="mailbox-read-time float-right">{{$date}}</span></h6>
                        </div>
                        <div class="mailbox-read-message">
                            {!! @$mail->message !!}
                        </div>
                        <!-- /.mailbox-read-message -->
                    </div>
                <!-- /.card-body -->
                    <div class="card-footer bg-white text-left">
                        <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                            @foreach (@$mail->files as $file)
                            <li>
                                <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>
                                <div class="mailbox-attachment-info">
                                    <div class="text-left"><i class="fas fa-paperclip mr-2"></i>{{$file->name}}</div>
                                    <div class="d-flex justify-content-between mailbox-attachment-size mt-2">
                                        <span>1,245 KB</span>
                                        <a href="{{asset($file->path)}}" class="btn btn-default btn-sm float-right" download><i class="fas fa-cloud-download-alt"></i></a>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        <div id="reply-container" class="mt-3">
                        </div>
                        <div id="compose-container" class="card mt-4" style="display: none">
                            <div class="card-body pb-1">
                                <div class="form-group">
                                    <textarea id="textarea" class="form-control" placeholder="Write here..." style="border: none; resize: none;"></textarea>
                                    <hr>
                                    <div class="d-flex justify-content-between mt-2">
                                        <button type="button" class="btn btn-primary mr-2" id="sendReply" disabled>Send</button>
                                        <button type="button" class="btn mr-2 hide-reply-btn"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start mt-3">
                            <div>
                                <button type="button" class="btn btn-default mr-2 reply-btn"><i class="fas fa-reply"></i> Reply</button>
                                {{-- <button type="button" class="btn btn-default"><i class="fas fa-share"></i> Forward</button> --}}
                            </div>
                        </div>
                    </div>
                <!-- /.card-footer -->
                    <div class="card-footer">
                        <button type="button" class="btn btn-default"><i class="far fa-trash-alt"></i> Delete</button>
                        <button type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
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
    <script src="{{asset('js/mail/mail.js')}}"></script>
    <script>
$("#li_mail").addClass('active');
</script>
@endsection
</x-app-layout>