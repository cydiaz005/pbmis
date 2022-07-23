<x-app-layout>
    @section('style')
        <link href="{{ asset('sweetalert2/sweetalert2.css') }}" />
        <link href="{{ asset('sweetalert2/sweetalert2.min.css') }}" />
    @endsection

    @section('content')
        @livewire('partials.content-header', [
        'pageTitle' => 'Read Mail',
        'breadcrumb' => [
        ['name' => 'Home', 'route' => '/dashboard/admin'],
        ['name' => 'Mail', 'route' => '#'],
        ['name' => 'Read', 'route' => '#'],
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
                                <h3 class="card-title">Read Mail</h3>

                                <div class="card-tools">
                                    <?php  
                                    if($type == "trash"){ ?>
                                    <button type="button" id="recover-email" class="btn btn-default btn-sm"
                                        data-container="body" title="Recover">
                                        <i class="fa fa-recycle" aria-hidden="true"></i>
                                    </button>
                                    <?php }else {  ?>
                                    <button type="button" id="delete-email" class="btn btn-default btn-sm"
                                        data-container="body" title="Delete">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                    <?php } ?>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-3">
                                <div class="mailbox-read-info p-1">
                                    <h5>{{ count($mail->recipients) < 0 ? 'No Reciept found' : '' }}</h5>
                                    <h6>To:
                                        <div class="row m-0 appendDiv">
                                            <?php 
                                        if(gettype($mail->recipients == "array")){
                                            foreach ($mail->recipients as $value) { ?>

                                            <div class="col-md-3 col-6 my-2">
                                                <div class="d-flex align-items-center chip_append">
                                                    <img src="https://ui-avatars.com/api/?name={{ $value->user->firstname . ' ' . $value->user->lastname }} Jonas Alan&amp;color=7F9CF5&amp;background=EBF4FF"
                                                        width="36" height="36" style="border-radius: 50%;">
                                                    <div class="d-flex justify-content-between text-truncate w-100">
                                                        <span
                                                            class="artist_name text-truncate ml-2">{{ $value->user->email }}</span>
                                                    </div>
                                                </div>
                                            </div>


                                            <?php 
                                            }
                                        }
                                    ?>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <span class="mailbox-read-time">{{ $date }}</span>
                                        </div>
                                    </h6>
                                </div>
                                <div class="mailbox-read-info p-1">
                                    <h5>{{ @$mail->subject ?: 'No Subject' }}</h5>
                                    <h6>From: {{ @$mail->sender->email }}
                                        <span class="mailbox-read-time float-right">{{ $date }}</span>
                                    </h6>
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
                                                <div class="text-left"><i
                                                        class="fas fa-paperclip mr-2"></i>{{ $file->name }}</div>
                                                <div class="d-flex justify-content-between mailbox-attachment-size mt-2">
                                                    <span>{{ $file->size }}</span>
                                                    <a href="{{ asset($file->path) }}"
                                                        class="btn btn-default btn-sm float-right" download><i
                                                            class="fas fa-cloud-download-alt"></i></a>
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
                                            <textarea id="textarea" class="form-control" placeholder="Write here..."
                                                style="border: none; resize: none;"></textarea>
                                            <hr>
                                            <div class="d-flex justify-content-between mt-2">
                                                <button type="button" class="btn btn-primary mr-2" id="sendReply"
                                                    disabled>Send</button>
                                                <button type="button" class="btn mr-2 hide-reply-btn"><i
                                                        class="fas fa-trash"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start mt-3">
                                    <div>
                                        <button type="button" class="btn btn-default mr-2 reply-btn"><i
                                                class="fas fa-reply"></i> Reply</button>

                                    </div>
                                </div>
                            </div>



                            {{-- <!-- /.card-footer -->
                                    <div class="card-footer">
                                        <button type="button" class="btn btn-default" id="delete-email"><i class="far fa-trash-alt"></i> Delete</button>
                                    </div> --}}



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
        <script src="{{ asset('js/mail/mail.js') }}"></script>
        <script src="{{ asset('sweetalert2/sweetalert2.all.js') }}"></script>
        <script src="{{ asset('sweetalert2/sweetalert2.all.min.js') }}"></script>
        <script>
            console.log(@json($mail));
            const token = `{{ csrf_token() }}`;
            const header = 'X-CSRF-TOKEN';
            let next_page_url;
            let fetching = false;
            const typeOf = '{{ @$type }}';
            const imboxId = '{{ $inboxId }}';
            console.log("trashId", imboxId)
            const mail_id_ = '{{ $mail->id }}';
            $('.reply-btn').on('click', function() {
                $('#compose-container').slideDown('fast');
            });
            $('.hide-reply-btn').on('click', function() {
                $('#compose-container').slideUp('fast');
            });
            const mail_id = '{{ $mail->id }}';
            const sender_id = '{{ $mail->sender_id }}';
            let sendReply = document.querySelector('#sendReply');

            let textarea = document.getElementById("textarea");
            let heightLimit = 200; /* Maximum height: 200px */

            textarea.oninput = function() {
                textarea.style.height = ""; /* Reset the height*/
                console.log(textarea.scrollHeight);
                textarea.style.height = Math.min(textarea.scrollHeight, heightLimit) + "px";

                if (textarea.value != "") {
                    // sendReply.classList.add('disabled')
                    sendReply.disabled = false;
                    sendReply.onclick = function() {
                        new AddReply();
                    }
                } else {
                    sendReply.disabled = true;
                    sendReply.onclick = null;
                }
            };

            function generateHtml(data) {
                const createElement = function(el, className, innerHTML, style) {
                    let element = document.createElement(el);
                    if (className && className != '')
                        element.className = className;
                    if (innerHTML && innerHTML != '')
                        element.innerHTML = innerHTML;
                    if (style)
                        element.style = style;
                    return element;
                }

                let mainDiv = createElement('div', 'py-4', '', 'border-top: 1px solid #e6e6e6');
                let div2 = createElement('div', 'w-100 row mx-2');
                let img = createElement('img', '', '', 'border-radius: 50%; height: 48px; width: 48px');
                img.src = data.img;
                let divCon = createElement('div', 'ml-3 pt-1', '', 'width: calc(100% - 70px)');
                let div3 = createElement('div', 'row mx-0');
                let divNameEmail = createElement('div', 'd-flex flex-column justify-content-center mr-1', '',
                    'width: calc(100% - 8.5rem)');
                let name = createElement('span', '', data.name, 'line-height: 1rem');
                let email = createElement('span', '', data.email, 'font-size: 70%;');
                let date = createElement('span', 'mailbox-read-time', data.date, 'width: 8rem');
                let message = createElement('div', 'mt-3', data.message);

                mainDiv.appendChild(div2);
                div2.appendChild(img);
                div2.appendChild(divCon);
                divCon.appendChild(div3);
                div3.appendChild(divNameEmail);
                divNameEmail.appendChild(name);
                divNameEmail.appendChild(email);
                div3.appendChild(date);
                divCon.appendChild(message);
                document.querySelector('#reply-container').appendChild(mainDiv);

                return date;
            }

            function AddReply() {
                const param = {
                    mail_id: mail_id,
                    message: textarea.value,
                    sender_id: sender_id,
                    type: '{{@$type}}',
                    trashable_id: '{{@$trashable_id}}',
                    trashable: '{{@$trashableType}}',
                    trashId : '{{@$inboxId}}'
                }
                const user = @json(Auth::user());
                console.log(user)
                const data = {
                    name: `${user.firstname} ${user.lastname}`,
                    email: user.email,
                    img: checkLogo(user.profile_photo_path, `${user.firstname} ${user.lastname}`),
                    date: 'Sending',
                    message: textarea.value,
                }
                let date = generateHtml(data);
                textarea.value = '';
                sendReply.disabled = true;
                $('#compose-container').hide();

                fetch(window.location.origin + '/mail/save-reply', {
                        method: "post",
                        headers: {
                            "Cache-Control": "no-cache",
                            Accept: "application/json, text/plain, */*",
                            "Content-Type": "application/json",
                            "X-CSRF-Token": document.querySelector('[name="csrf-token"]').content,
                        },
                        body: JSON.stringify(param),
                    })
                    .then(function(response) {
                        if (!response.ok) {
                            date.innerHTML = '<span class="text-danger">Failed.</span>'
                            throw new Error("HTTP status " + response.status);
                        }
                        return response.text();
                    })
                    .then(function(res) {
                        console.log(res);
                        date.innerHTML = 'Just now';
                        const typeOf = '{{@$type}}';
                        const trashable = '{{@$trashableType}}';
                        if(typeOf){
                            if(typeOf == "trash"){
                                if(trashable){
                                  
                                    if(trashable == "AppModelsUserSentbox"){
                                        window.location.href = `/mail/read/sent/${mail_id_}`
                                    }else{
                                        window.location.href = `/mail/read/inbox/${mail_id_}`
                                    }
                                }
                              
                            }
                        }
                    });
            }
            getReplies(window.location.origin + '/mail/get/replies/' + mail_id);

            function getReplies(url) {
                if (fetching) {
                    console.log('fetching');
                    return
                }
                if (!url || url == null) {
                    console.log('no url');
                    return
                }
                fetching = true;
                fetch(url, {
                        method: "post",
                        headers: {
                            Accept: "application/json, text/plain, */*",
                            // "Content-Type": "application/json",
                            "X-CSRF-Token": document.querySelector('[name="csrf-token"]').content,
                        },
                    })
                    .then(function(response) {
                        if (!response.ok) {
                            throw new Error("HTTP status " + response.status);
                        }
                        return response.json();
                    })
                    .then(function(res) {
                        fetching = false;
                        console.log(res);
                        next_page_url = res.next_page_url;
                        for (const key in res.data) {
                            if (key != "server_time") {
                                const element = res.data[key];
                                console.log(element)
                                const data = {
                                    name: `${element.user.firstname} ${element.user.lastname}`,
                                    email: element.user.email,
                                    img: checkLogo(element.user.profile_photo_path,
                                        `${element.user.firstname} ${element.user.lastname}`),
                                    date: getElapsedTime(res.data.server_time, element.created_at),
                                    message: element.message,
                                }
                                generateHtml(data);
                            }
                        }

                    });
            }

            window.onscroll = function(ev) {
                if ((window.innerHeight + window.scrollY) >= document.body.scrollHeight - 30) {
                    // console.log('bottom');
                    getReplies(next_page_url);
                }

            };

            $("#delete-email").on("click", () => {
                Swal.fire({
                    icon: "warning",
                    title: 'Are You sure?',
                    text: "You wont revert this action!",
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Proceed',
                    denyButtonText: `Cancel`,
                    reverseButtons: true
                }).then(async (result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/mail/trash-sent-data",
                            data: {
                                ids: {
                                    [imboxId]: imboxId
                                },
                                type: typeOf
                            },
                            type: "POST",
                            beforeSend: function(xhr) {
                                xhr.setRequestHeader('X-CSRF-TOKEN', token)
                                xhr.setRequestHeader('X-Requested-With', "XMLHttpRequest");
                            },
                            success: function(result) {
                                if (typeOf == "sentbox") {
                                    window.location.href = "/mail/sent"
                                } else if (typeOf == "inbox") {
                                    window.location.href = "/mail/inbox"
                                }

                            }
                        });
                       

                    }
                })

            })
            $("#li_mail").addClass('active');
            $("#recover-email").on("click", () => {
                Swal.fire({
                    icon: "warning",
                    title: 'Are You sure ?',
                    text: "You want to Recover",
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Proceed',
                    denyButtonText: `Cancel`,
                    reverseButtons: true
                }).then(async (result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        const trash = @json(@$trashable);
                      
                        if(trash){
                            const trashable_id = "{{@$trashable_id}}";
                            console.log(trash)
                        $.ajax({
                            url: "/mail/recover-trashdata",
                            data: {
                                type: trash.trashable_type == "App\\Models\\UserInbox" ? "userinbox" :"sentbox",
                                trash_id: imboxId,
                                trashable_id: trash.trashable_id
                            },
                            type: "POST",
                            beforeSend: function(xhr) {
                                xhr.setRequestHeader('X-CSRF-TOKEN', token)
                                xhr.setRequestHeader('X-Requested-With', "XMLHttpRequest");
                            },
                            success: function(result) {
                                if (trash.trashable_type == "App\\Models\\UserInbox") {
                                    window.location.href = "/mail/inbox"
                                } else {
                                    window.location.href = "/mail/sent"
                                }

                            }
                        });
                        }
                       
                    }
                });
            })
        </script>
    @endsection
</x-app-layout>
