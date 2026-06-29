
function Mail(type, opts){
    let fetching = false;
    const container = document.querySelector(opts.container);
    let obj = {};
    let allData = {};
    let unCheck = false;
    let nextpage = null;
    init();
    this.deleted = function() {
        return obj;
    }
    function init(){
        getMails(opts.url);
    }
    this.clickAll = function() {
            if(typeof allData === "object"){
                Object.keys(allData).map(key => {
                    if(allData[key].id){
                        obj[allData[key].id] = allData[key].id
                    }
                  
                    return;
                })
            }
    
        const boxes = document.querySelectorAll(".delete-boxes");
           
        for(let box of boxes){
            box.checked = !unCheck;
        }
        unCheck = !unCheck;
    }

    function generateRow(data) {
        const createElement = function(el, className, innerHTML){
            let element = document.createElement(el);
            if(className && className != '')
            element.className = className;
            if(innerHTML)
            element.innerHTML = innerHTML;
            return element;
        }
        
        let badge = '';
        let bold = '';
        if(data.status == '1'){
            badge = '<span class="right badge badge-danger">New</span> - ';
            bold = 'font-weight-bold';
        }
        const tr = createElement('tr', bold);
        const td1 = createElement('td');
        const delDiv = createElement('div', 'icheck-primary');
        const delCheckbox = createElement('input', 'icheck-primary');
        delCheckbox.type = "checkbox";
        delCheckbox.id = "del" + data.id;
        delCheckbox.className = "delete-boxes";

        const delLabel = createElement('label');
        delDiv.appendChild(delCheckbox);
        delDiv.appendChild(delLabel);
        td1.appendChild(delDiv);
     
       
        const td2 = createElement('td');
        const nameDiv = createElement('div', 'text-truncate name-div');
        if(opts.sendType){
            nameDiv.innerHTML = `From: ${data.name}`;
        }else{
            let mailsAdd = "";
            if(data.recipients){
                if(Array.isArray(data.recipients)){
                    data.recipients.forEach((data, i) => {
                        if(i == 0 ){
                            mailsAdd +=  data.user.email
                        }else{
                            mailsAdd +=  " , " + data.user.email
                        }
                       
                    })
                }
            }
            nameDiv.innerHTML = `To: ${mailsAdd}`;
        }
        if(data.trashType){
            if(data.typeOfTrash){
                let mailsAdd = "";
                if(Array.isArray(data.mail.recipients)){
                    data.mail.recipients.forEach((data, i) => {
                        if(i == 0 ){
                            mailsAdd +=  data.user.email
                        }else{
                            mailsAdd +=  " , " + data.user.email
                        }
                       
                    })
                }
              
                nameDiv.innerHTML = `To: ${mailsAdd}`;
            }else{
               
                nameDiv.innerHTML = `From: ${data.mail.sender.email}`;
            }
            
        }
        
        td2.appendChild(nameDiv);

        const td3 = createElement('td');
        const subjectDiv = createElement('div', 'text-truncate subject-div');
        subjectDiv.innerHTML = badge+ ((data.subject == null) ? "No Subject":data.subject);
        td3.appendChild(subjectDiv);
        
        let clip = '';
        if(data.files){
            clip = '<i class="fas fa-paperclip"></i>';
        }
        const td4 = createElement('td', '', clip);
        const td5 = createElement('td', '', data.elapsedTime);
        
        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tr.appendChild(td4);
        tr.appendChild(td5);
        container.appendChild(tr);

        tr.onclick=function(e){
            if(e.target != delCheckbox){
                if(opts.type_read){
                   
                    if(opts.type_read === "draft"){
                        window.location.href = "/mail/compose/draft/"+data.mail_id;
                        return
                    }
                    if(opts.type_read === "trash"){
                        window.location.href = "/mail/read/trash/"+data.parentId;
                       
                        return
                    }
                   return;
                }
                window.location.href = "read/"+type+"/"+data.mail_id;
                return;
            }
        }
        delCheckbox.onchange=function(e){
            e.stopPropagation();
            if(obj[data.parentId]){
                delete obj[data.parentId];
            }else{
                obj[data.parentId] = data.parentId;
            }
           
        }
    } 
    function formatData(data){
        if(Object.keys(data).length == 2){
            container.innerHTML = '<tr><td colspan="5" class="text-center">Empty</td></tr>';
            return;
        }
        for (const key in data) {
            if(key != "server_time" && key != "type"){
                const element = data[key];
        
                let d = {
                    parentId: element.id,
                    id: element.mail.id,
                    mail_id: element.mail_id,
                    subject: element.mail.subject,
                    status: element.status,
                    files: (element.mail.files.length > 0),
                    recipients: data[key].mail.recipients,
                    elapsedTime: getElapsedTime(data.server_time, element.updated_at),
                }
                if(data.type == 'inbox'){
                    d['name'] = element.mail.sender.firstname + " " +element.mail.sender.lastname;
                }
                else if(data.type == 'sentbox'){
                    
                    d['name'] = element.mail.sender.firstname + " " +element.mail.sender.lastname;
                }
                generateRow(d);
                
            }
        }
    }
    function getMails(url) {
        if(fetching){return}
        fetching = true;
        //  if(!opts.query) $('.spinner_modal').modal('show');
        fetch(window.location.origin+url, {
            method: "post",
            headers: {
                Accept: "application/json, text/plain, */*",
                "Content-Type": "application/json",
                "X-CSRF-Token": document.querySelector('[name="csrf-token"]').content,
            },
            body: JSON.stringify({search_query:opts.query})
        })
        .then(function (response) {
            if (!response.ok) {
                $('.spinner_modal').modal('hide');
                throw new Error("HTTP status " + response.status);
            }
            $('.spinner_modal').modal('hide');
            return response.json();
        })
        .then(function (res) {
            $('.spinner_modal').modal('hide');
            $('#sentbox-container').empty();
            $("#inbox-container").empty();
            Object.keys(res.data).forEach(key => {
                if(res.data[key].id){
                    allData[key] = res.data[key];
                }
            })
            
           nextpage = res.next_page_url;
       
            if(opts.trash){
               
                formatTrash(res.data);
                
                return;
            }
            formatData(res.data);
        
          
        });
    }
    function paginateMails(url){
        
        fetch(url, {
            method: "post",
            headers: {
                Accept: "application/json, text/plain, */*",
                "Content-Type": "application/json",
                "X-CSRF-Token": document.querySelector('[name="csrf-token"]').content,
            },
            body: JSON.stringify({search_query:$("#search-input").val()})
        })
        .then(function (response) {
            if (!response.ok) {
                $('.spinner_modal').modal('hide');
                throw new Error("HTTP status " + response.status);
            }
            $('.spinner_modal').modal('hide');
            return response.json();
        })
        .then(function (res) {
            $('.spinner_modal').modal('hide');
            Object.keys(res.data).forEach(key => {
                if(res.data[key].id){
                    allData[key] = res.data[key];
                }
            })
            nextpage = res.next_page_url
            if(opts.trash){
                formatTrash(res.data);
                
                return;
            }
            formatData(res.data);
        
          
        });
    }
    function formatTrash(trashbale){
  
        
        if(Object.keys(trashbale).length == 2){
            container.innerHTML = '<tr><td colspan="5" class="text-center">Empty</td></tr>';
            return;
        }
       
        for (const key in trashbale) {
                let trash = trashbale[key];
                console.log(trash);
                if(trash.trashable_type == "App\\Models\\UserSentbox" || trash.trashable_type == "App\\Models\\UserInbox"){
                   if(trash.trashable){
                    const typeOfTrash = trash.trashable_type == "App\\Models\\UserSentbox";
                    let d = {
                        trashType: true,
                        typeOfTrash: typeOfTrash,
                        parentId: trash.id,
                        id: trash?.trashable?.mail?.id,
                        mail_id: trash.trashable.mail_id,
                        subject: trash.trashable.mail.subject,
                        status: trash.trashable.mail.status,
                        files: (trash.trashable.mail.files.length > 0),
                        mail: trash.trashable.mail,
                        elapsedTime: getElapsedTime(trash.server_time, trash.created_at),
                        name: trash.trashable.mail.sender.firstname + " " +trash.trashable.mail.sender.lastname
                    }
                    generateRow(d);
                   }
                  
                   
                  
                   
                  
                } 
                
        }
    }
    window.onscroll = function(ev) {
        if ((window.innerHeight + window.scrollY) >= document.body.scrollHeight) {
            if(nextpage){
                paginateMails(nextpage)
               
            }
       
        }
    };
}

function getElapsedTime(server_time_now, date2){
    // let jsDate = new Date(Date.parse(date2.replace(/[-]/g,'/'))).getTime();
    let jsDate = new Date(date2).getTime();
    let diff = server_time_now - (jsDate / 1000);
    const units = ["min","hour","day","week","month","year"];
    const conversions = [60, 60, 24, 7, 31, 365];
    let dt_diff = "Just now";
    let i=0;
    if(diff > 60){
        for (i=0; i < conversions.length; i++) { 
            if(diff > 60){
                diff = diff / conversions[i];
            }
            else{
                break;
            }
        }
        diff = diff | 0;
        let unit = units[i - 1];
        if(diff > 1){
            unit = unit+"s";
        }
        dt_diff = diff + " "+unit+" ago";
    }
    return dt_diff;
}








 
