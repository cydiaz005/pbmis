function Notification(){
    const inNotifPage = location.pathname.split('/')[1] === "notifications";
    let iconBells=document.querySelectorAll('#show_notifslide');
    let createElement = function(el, className, innerHTML){
        let element = document.createElement(el);
        if(className){
            element.className = className;
        }
        if(innerHTML){
            element.innerHTML = innerHTML;
        }
        return element;
    }
    let notif_length=0;
  
    let active_tab = 0;
    let tabs = ['All', 'Band', 'Venue', 'Agency'];
    let empty = createElement('div', 'text-center', '<small class="text-muted">Empty notification</small>');
    const fetchIndicatorElement = createElement('div','text-center text-muted my-2', '<small>Last Page</small>');
    let notif_contents = document.querySelector('#notif_contents');
    let notif_classification = document.querySelector('#notif_classification');
    if(!notif_classification){
        return;
    }
    
    if(inNotifPage){
        // iconBells=document.querySelector('.all-notif-bell');
        notif_contents = document.querySelector('#all-notif');
    }
    
    // notif_classification.innerHTML='';
    // for (let i = 0; i < tabs.length; i++) {
    //     let tab = createElement('div', 'usertype-notif '+ ((i==active_tab) ? 'active-notif':''), '<small class="usertype-txt">'+tabs[i]+'</small>');
    //     notif_classification.appendChild(tab);
    //     tab.onclick = function (){
    //         empty.remove();
    //         notif_classification.children[active_tab].classList.remove('active-notif');
    //         active_tab = i;
    //         tab.classList.add('active-notif');
    //         // Filter Notification
    //         let hasNotif = false;
    //         for (let q = 0; q < notif_contents.children.length; q++) {
    //             const element = notif_contents.children[q];
    //             console.log(hasNotif);
    //             if(!element.classList.contains(tabs[i].toLowerCase()) && tabs[i] != 'All'){
    //                 element.classList.remove('d-inline-flex');
    //                 element.style.display = 'none';
    //             }
    //             else{
    //                 hasNotif = true;
    //                 element.classList.add('d-inline-flex');
    //                 element.style.display = 'block';
    //             }
    //         }
    //         if(!hasNotif){
    //             notif_contents.appendChild(empty);
    //         }
    //     }
    // }
    getNotifications();

    function updateNotifCount(){
        if(notif_length < 1){
            $("#show_notifslide").remove();
        }else{
            $("#show_notifslide").text(notif_length);
           
        }
    }
    async function sendNotif(opts){
        fetch(window.location.origin+opts.url, {
            method: "post",
            headers: {
                "Cache-Control": "no-cache",
                Accept: "application/json, text/plain, */*",
                "Content-Type": "application/json",
                "X-CSRF-Token": document.querySelector('[name="csrf-token"]').content,
            },
            body: JSON.stringify(opts.data),
        })
        .then(function (response) {
            if (!response.ok) {
                throw new Error("HTTP status " + response.status);
            }
            return response.text();
        })
        .then(opts.done);
    }
    function getNotifications(){

        let firstFetch = true;
        const fetchsrcoll = new FetchScroll({
            url: '/notification/get',
            container: inNotifPage ? undefined:notif_contents,
        });

       
        fetchsrcoll.on('beforeFetch', function(){
            fetchIndicatorElement.firstChild.innerHTML="loading...";
            notif_contents.appendChild(fetchIndicatorElement);
        });

        fetchsrcoll.on('fetch', function(res, isLastPage, other_params){
            console.log("res",res);
            if(firstFetch){
                notif_contents.innerHTML = '';
                firstFetch = false;
                if(res.length == 0){
                    notif_contents.appendChild(empty); 
                }
                notif_length = other_params.count;
                updateNotifCount();
            }
            else{
                fetchIndicatorElement.remove();
            }
            console.log("NOTIFICATIONS", res);
            renderNotifHtml(res);

            if(isLastPage){
                fetchIndicatorElement.firstChild.innerHTML="Last Page";
                notif_contents.appendChild(fetchIndicatorElement);
            }
        });

        // fetch(window.location.origin+'/notification/get', {
        //     method: "get",
        //     headers: {
        //         "Cache-Control": "no-cache",
        //         Accept: "application/json, text/plain, */*",
        //         "X-CSRF-Token": document.querySelector('[name="csrf-token"]').content,
        //     },
        // })
        // .then(function (response) {
        //     if (!response.ok) {
        //         throw new Error("HTTP status " + response.status);
        //     }
        //     return response.json();
        // })
        // .then(function (res) {
        //     console.log("NOTIFICATIONS", res.paginationData.data);
           
        // });
    }
    function getElapsedTime(date){
        let jsDate = new Date(date).getTime();
        let diff = (server_date_time_in_seconds - (jsDate / 1000)) - 28800; 
        const units = ["min","hour","day","week","month","year"];
        const conversions = [60, 60, 24, 7, 31, 365];
        let dt_diff = "Just now";
        let i=0;
        if(diff > 60){
            for (i=0; i < conversions.length; i++) { 
                if(diff > conversions[i]){
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

    function renderNotifHtml(data){ 
        // if(data.length == 0){
        //     notif_contents.appendChild(empty);
        //     return;
        // }
        // // notif_contents.innerHTML = ''
        for (let i = 0; i < data.length; i++) {
            generateNotification(data[i]);
        }
      //  notif_length = data.filter(d => d.seen == "0").length;
      
        updateNotifCount();
    }
    function generateConfirmationButton(){
        let confirmBtn = createElement('button', 'btn btn-primary notif-avails-btn notif-confirm-btn', 'Confirm');
        let confirmBtnDiv = createElement('div', 'mr-1');
        confirmBtnDiv.appendChild(confirmBtn);
        let cancelBtn = createElement('button', 'btn notif-avails-btn notif-remove-btn', 'Remove');
        let cancelBtnDiv = createElement('div');
        cancelBtnDiv.appendChild(cancelBtn);

        return {
            confirmBtnDiv: confirmBtnDiv,
            cancelBtnDiv: cancelBtnDiv,
        }
    }
    function generateHtml(data){
        let div = createElement('div', `dropdown-item d-inline-flex notif_con ${data.seen == "0" ? "" : "seen-notif"}`);
        let img = createElement('img', 'z-depth-2 notif_image');
        let divConfirmCon = createElement('div', 'confirm-con');
        let divInfo = createElement('div', 'info-con');
        let name = createElement('span', 'name-sec notif_message');
        let message = createElement('span', 'notiftype-message');
        message.style="font-weight: 400";
        name.appendChild(message);
        let timeElapsed = createElement('span', 'address-sec time-info notif_message');
        divInfo.appendChild(name);
        divInfo.appendChild(timeElapsed);
        let divBtns = createElement('div', 'notif-button-con d-flex mt-1');

        divConfirmCon.appendChild(divInfo);
        divConfirmCon.appendChild(divBtns);

        div.appendChild(img);
        div.appendChild(divConfirmCon);

        return {
            div: div,
            sender_img: img,
            sender_name: name,
            message: message, 
            divButtons: divBtns,
            timeElapsed: timeElapsed,
        }
    }
    function generateNotification(data){
        let arr = data.notif_type.split("-");
        let sender_name = `${data.sender.firstname} ${data.sender.lastname}`
        let sender_img = checkLogo(data.sender.profile_photo_path !== ''? data.sender.profile_photo_path:data.sender.profile_photo_url, sender_name)
        // console.log('sender_img', sender_img);
        // let sender_img = checkLogo(data.sender.profile_photo_path || data.sender.profile_photo_url, sender_name)
        console.log('data.sender',data.sender);
  
        let html = generateHtml(data);
        html.sender_name.innerHTML='<strong >'+sender_name+"</strong>";
        html.sender_name.appendChild(html.message);
        html.sender_img.src=sender_img;
        html.message.innerHTML=" "+data.message;
        html.timeElapsed.innerHTML=getElapsedTime(data.created_at);
        
      
        notif_contents.appendChild(html.div);
        if(data.seen == 0) {
            notif_length++;
        }
        html.div.onclick=function(){
            sendNotif({
                url: '/notification/seen',
                data: {id:data.id},
                done: function(){
                    notif_length--;
                    updateNotifCount();
                    html.div.classList.remove("seen-notif");
                }
            })
            let page = arr[0].split("Staff");
            setTimeout(() => {
                if(data.notif_type=="user-new-announcement"){
                    window.location.href=window.location.origin+"/bulletin/board";
                }
                else if(data.notif_type=="user-new-user"){
                    window.location.href=window.location.origin+"/user/unverified";
                }
                else if (data.notif_type == "user-new-mail"){
                    window.location.href=window.location.origin+"/mail/read/inbox/" + data.notifiable_id;
                }
                else if(data.notif_type == "user-return-ppmpClassification"){
                    window.location.href=window.location.origin+"/form/ppmp"   
                }
                else if (data.notif_type == "user-change-status" || data.notif_type == "user-change-role"){
                    if(typeUser){
                        if(typeUser == "Developer"){
                            window.location.href=window.location.origin+"/user/all";
                        }else if(typeUser == "Super Administrator"){
                            window.location.href=window.location.origin+"/user/all";
                        }else if(typeUser == "Administrator"){
                            window.location.href=window.location.origin+"/dashboard/administrator";
                        }
                    }else{
                        console.log("heelo")
                    }
                }else if (data.notif_type === "user-update-working-fiscal-limit"){
                        const year = new Date(data.created_at).getFullYear();
                        window.location.href=window.location.origin+`/form/working-fiscal-limit/modify/?fiscal_year=${year}`;
                }else if (data.notif_type === "user-create-poe" || data.notif_type === "user-update-poe"  || 
                data.notif_type === "user-returned-poe"
                ){
                    window.location.href=window.location.origin+`/form/poe/view/${data.notifiable_id}`;
                }else if (data.notif_type === "user-published-poe" ){
                    window.location.href=window.location.origin+`/form/ppmp/view/${data.notifiable_id}`;
                }

            }, 300);
        }
    }
    function sendNotification(url, params){
        sendNotif({
            url: url,
            data: params,
            done: function(res){
                console.log(res);
                div.remove();
                if(notif_contents.children.length==0){
                    notif_contents.appendChild(empty);
                }
                notif_length--;
                updateNotifCount();
            }
        });
    }
}

new Notification();