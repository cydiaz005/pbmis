// function Compose(){
    const sendTo = new Searchable('#sendTo', {
        url: window.location.origin+'/mail/search-emails',
        onClick: 'appendChip',
        props: {
            id: 'id',
            text: 'name',
            subText: 'email',
            img: 'img',
            appendTextDisplay: 'email',
        }
    });
    const sendMailBtn = document.querySelector('#send-mail-btn');
    const saveDraftBtn = document.querySelector('#save-draft-btn');
    const mailSubjectInput = document.querySelector('#mail-subject');
    let addedFiles = [];
    let uploadingFileCount = 0; 
    let fetching = false;
    sendMailBtn.onclick=sendMailProcess;
    if(saveDraftBtn){
        saveDraftBtn.onclick=saveDraftProcess;
    }

    if(draftMail){
        if(Array.isArray(draftMail.mail.recipients)){
            draftMail.mail.recipients.forEach(data => {
                const userData = {
                    id:  data.user.id,
                    name:  `${data.user.firstname} ${data.user.lastname}`,
                    email: `${data.user.email}`,
                    img: data.user.profile_photo_url,
                }
                sendTo.addData(userData)
            })
        }
        $("#mail-subject:text").val( draftMail.mail.subject);
     
        $('#compose-textarea').summernote('reset');
        $('#compose-textarea').summernote('pasteHTML',  draftMail.mail.message);
    }
  
    $('#compose-textarea').summernote({
        height: 250,
        focus: true,
        disableDragAndDrop:true,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview', 'help']],
        ],
    });
    const dropzone = new Dropzone("div.note-editable", { 
        url: "/mail/file/pre-upload" ,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('[name="csrf-token"]').content,
        },
        addRemoveLinks: true,
        uploadMultiple: false,
        clickable: "#upload-btn",
        parallelUploads: 100,
        maxFiles: 100,
        previewsContainer:"#file-preview",
        dictDefaultMessage: "<strong>Drop files here or click to upload. </strong>",
        thumbnailHeight: 90,
        thumbnailWidth: 90,
        maxFilesize: 32 * 1000 * 1000,
        thumbnailMethod: "contain",
        previewTemplate: document.querySelector('#template-preview').innerHTML,
        init: function() {
            this.on("addedfile", file => {
                let type = getfileType(file.type);
                console.log(file.type)
                if(!type){
                    this.emit("thumbnail", file, window.location.origin+"/images/file-thumbnails/any.png");
                }
            });
            this.on("complete", file => {
                let dzUpload = file.previewElement.querySelector('.progress-bar-wrapper');
                dzUpload.style.display = 'none';
            });
        },
        accept: function(file, done) {
            let type = getfileType(file.type);
            console.log(file.type)
            if(!type){
                file.status = Dropzone.CANCELED;
                this._errorProcessing([file],  "invalid file type", null);
            }else if (file.size > this.options.maxFilesize) {
                file.status = Dropzone.CANCELED;
                this._errorProcessing([file],  "File size limit reached", null);
            }else { 
                checkUploadingFileCount(1);
                done();
            }
        },
        uploadprogress: function(file, progress, bytesSent) {
            let dzSize = file.previewElement.querySelector('.dz-size');
            let dzUpload = file.previewElement.querySelector('.progress-bar');
            dzUpload.style.width = Math.ceil(progress) + "%";
            let sent = convertByte(bytesSent, 1024);
            if(progress > 98){
                sent = convertByte(file.size);
            }
            dzSize.innerHTML = sent+" / " +convertByte(file.size);
        },
        removedfile: function(file){
            if (file.previewElement != null && file.previewElement.parentNode != null) {
                file.previewElement.parentNode.removeChild(file.previewElement);
            }
            if(addedFiles.indexOf(file.server_path) >= 0){
                console.log("addedfiles", addedFiles);
                console.log("removed");
                addedFiles.splice(addedFiles.indexOf(file.server_path), 1);
                removeFileFromServer(file.server_path);
            }
        },
        success: function(file, response){
            addedFiles.push(response);
            checkUploadingFileCount(-1);
            file['server_path'] = response;
        },
        canceled: function(file) {
            checkUploadingFileCount(-1);
            return this.emit("error", file, this.options.dictUploadCanceled);
        },
        error: function(file, message){
            toastr.error(message);
            if (file.previewElement != null && file.previewElement.parentNode != null) {
                file.previewElement.parentNode.removeChild(file.previewElement);
            }
        },
    });
    function getfileType(type){
        const types = {
            image: ["image/png", "image/jpeg", "image/pdf", "application/pdf"]
        }

       
        for (const key in types) {
            if(types[key].includes(type)){
                return key;
            }
        }
    }
    function convertByte(bytes, num = 1000){
        let size = bytes / num;
        let unit = "KB";

        if(size > num){
            size = size / num;
            unit = "MB";
        }
        if(size > num){
            size = size / num;
            unit = "GB";
        }
        var rounded = Math.round(size * 10) / 10;
        var fixed = rounded .toFixed(1);

        return "<strong>"+fixed+"</strong>"+" "+ unit;
    }
    function removeFileFromServer(path){
        fetch(window.location.origin+'/mail/file/remove', {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": document.querySelector('[name="csrf-token"]').content,
            },
            body: JSON.stringify({path:path}),
        });
    }
    function checkUploadingFileCount(num){
        uploadingFileCount += num;
        if(uploadingFileCount <= 0){
            sendMailBtn.disabled = false;
            if(saveDraftBtn){
                saveDraftBtn.disabled = false;
                saveDraftBtn.classList.remove('disabled');
            }
           
            sendMailBtn.classList.remove('disabled');
          
        }
        else{
            if(saveDraftBtn){
                saveDraftBtn.disabled = true;
                saveDraftBtn.classList.add('disabled');
            }
            sendMailBtn.disabled = true;
           
            sendMailBtn.classList.add('disabled');
           
        }
    }
    function validated(type){
        $('.toast').remove();
        let error = false;
        const params = {
            ids: sendTo.getIds(),
            subject: mailSubjectInput.value,
            message: $('#compose-textarea').summernote('code'),
            addedFiles: addedFiles,
            type: type,
        }
        if(type == "mail"){
            if(params.ids.length == 0){
                error = true;
                toastr.error('No Recipients');
            }
        }
        if(params.subject == "" && $('#compose-textarea').summernote('isEmpty') && params.addedFiles.length == 0){
            error = true;
            toastr.error('Error: Empty Mail');
        }
        return (error) ? false:params;
    }
   async function sendMailProcess(){
        if(draftMail){
            $('.toast').remove();
            let error = false;
            const params = {
                ids: sendTo.activeIds(),
                subject: mailSubjectInput.value,
                message: $('#compose-textarea').summernote('code'),
                addedFiles: addedFiles,
                type: "mail",
            }
            console.log(sendTo.getIds())
            if(params.ids.length == 0){
                    error = true;
                    toastr.error('No Recipients');
                    return;
            }
            
            if(params.subject == "" && $('#compose-textarea').summernote('isEmpty')){
                error = true;
                toastr.error('Error: Empty Mail');
                return;
            }
            $('.spinner_modal').modal('show');
        const res = await fetch(window.location.origin+`/mail/update-sent/${draftMail.id}/${draftMail.mail.id}`, {
                method: "post",
                headers: {
                    "Cache-Control": "no-cache",
                    Accept: "application/json, text/plain, */*",
                    "Content-Type": "application/json",
                    "X-CSRF-Token": document.querySelector('[name="csrf-token"]').content,
                },
                body: JSON.stringify(params),
            })
            $('.spinner_modal').modal('hide');
            clear();
            if(res.status == 200){
                toastr.success('Sent');
                 setTimeout(() => {
                 window.location.href = "/mail/draft"
                }, 400)
               
            }
           
           
           


            return;
        }
        const data = validated('mail');
        if(data){
            $('.spinner_modal').modal('show');
            sendMail(data, "/mail/save-mail", function(res){
                clear();
                $('.spinner_modal').modal('hide');
                toastr.success('Sent');
                $.ajax({
                    url: "/mail/recount-mail",
                    data: {
                        type: "sender"
                    },
                    type: "POST",
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', token)
                        xhr.setRequestHeader('X-Requested-With', "XMLHttpRequest");
                    },
                    success: function(result) {
                      console.log(result)
                       $("#sent-badge").text(result)
                    }
                });
            });
        }
    }
    function clear(){
        addedFiles = [];
        dropzone.removeAllFiles(true);
        sendTo.removeData();
        $('#compose-textarea').summernote('reset');
        mailSubjectInput.value="";
    }
    function saveDraftProcess(){
        const data = validated('draft');
        if(data){
            data['status'] = '1';
            $('.spinner_modal').modal('show');
            sendMail(data, "/mail/save-mail", function(res){
                clear();
                $('.spinner_modal').modal('hide');
                toastr.success('Draft Saved');
                setTimeout(() => {
                    window.location.reload()
                }, 400)
            });
        }
    }
    function sendMail(param, url, callback){
        fetching = true;
        fetch(window.location.origin+url, {
            method: "post",
            headers: {
                "Cache-Control": "no-cache",
                Accept: "application/json, text/plain, */*",
                "Content-Type": "application/json",
                "X-CSRF-Token": document.querySelector('[name="csrf-token"]').content,
            },
            body: JSON.stringify(param),
        })
        .then(function (response) {
            if (!response.ok) {
                throw new Error("HTTP status " + response.status);
            }
            return response;
        })
        .then(callback);
    }
// }
    
    