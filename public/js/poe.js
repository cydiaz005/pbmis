function FileList(type, opts={}){
    let loaded_files = [];
    let fileList = this;
    let eventListeners={};
    let instances = {};
    let fetching = false;
    const mainUrl = opts.url || '/form/'+type+'/fetch';

    this.activeInstance = null;
    this.filters={
        search_query: undefined,
        stage: undefined,
        service_region: undefined,
        month: undefined,
        year: undefined,
        semester: undefined,
    }
    this.newList=function(opts){
        instances[opts.status] = new File(opts);
        return instances[opts.status];
    }
    this.on=function(e,f){
        eventListeners[e]=f;
    }

    if(opts.filters){
        initFilters();
    }

    function destroyAllInstance(){
        for (const key in instances) {
            instances[key].destroy();
        }
        console.log("adwwad");
        if(!fetching){
            if(opts.refreshAll){
                for (const key in instances) {
                    instances[key].getFiles(undefined, true);
                }
            }
            else{
                instances[fileList.activeInstance].getFiles();
            }
        }
        
        renderEvent('filter');
    }
    function initFilters(){
        if(opts.filters.includes('search')){
            document.querySelector("#filter-search").oninput=function(){
                if(this.value ==""){
                    fileList.filters.search_query=undefined;
                }
                else{
                    fileList.filters.search_query=this.value;
                }
                destroyAllInstance();
            }
        }
        if(opts.filters.includes('stage')){
            fileList.filters.stage = document.querySelector("#filter-stage").value;
            document.querySelector("#filter-stage").onchange=function(){
                if(this.value ==""){
                    fileList.filters.stage=undefined;
                }
                else{
                    fileList.filters.stage=this.value;
                }
                destroyAllInstance();
            }
        }
        if(opts.filters.includes('service_region')){
            fileList.filters.service_region = document.querySelector("#filter-serreg").value;
            document.querySelector("#filter-serreg").onchange=function(){
                if(this.value =="*"){
                    fileList.filters.service_region=undefined;
                }
                else{
                    fileList.filters.service_region=this.value;
                }
                destroyAllInstance();
            }
        }
        if(opts.filters.includes('month')){
            // fileList.filters.month = document.querySelector("#filter-month").value;
            document.querySelector("#filter-month").onchange=function(){
                if(this.value =="*"){
                    fileList.filters.month=undefined;
                }
                else{
                    fileList.filters.month=this.value;
                }
                destroyAllInstance();
            }
        }
        if(opts.filters.includes('semester')){
            // fileList.filters.month = document.querySelector("#filter-month").value;
            document.querySelector("#filter-semester").onchange=function(){
                if(this.value =="*"){
                    fileList.filters.semester=undefined;
                }
                else{
                    fileList.filters.semester=this.value;
                }
                destroyAllInstance();
            }
        }
        if(opts.filters.includes('year')){
            fileList.filters.year = document.querySelector("#filter-year").value;
            document.querySelector("#filter-year").onchange=function(){
                if(this.value ==""){
                    fileList.filters.year=undefined;
                }
                else{
                    fileList.filters.year=this.value;
                }
                destroyAllInstance();
            }
        }

    }
    function renderEvent(e,params){
        console.log("render event");
        if(eventListeners[e]){
            eventListeners[e]();
        }
    }
    function File(opts){
        console.log("opts",opts);
        const status = opts.status;
        const statuses =  {
            all: 0,
            drafts: 1,
            published: 2,
            for_review: 3,
            returned: 4,
            resolved: 5,
        };
        const container = document.querySelector(opts.container);
        const controller = opts.controller;
        const empty_div = document.createElement('div');
        empty_div.className = 'text-center my-5 py-5 empty-placeholder';
        empty_div.innerHTML= opts.emptyMessage || 'Empty';
        let fileUrl = opts.url || mainUrl;
        let paginationButtons = new ButtonLinks({
            el:"#pagination-links-"+status,
        });
        let _this = this;

        paginationButtons.on('click', function(link){
            _this.destroy();
            _this.getFiles(link);
        });

        let btns = {
            publish: '<a type="button" class="btn btn-sm btn-primary mx-1"><i class="fas fa-check"></i>&nbsp; Publish</a> &nbsp;',
            edit: '<a type="button" class="btn btn-sm btn-primary mx-1"><i class="fas fa-edit"></i></a> &nbsp;',
            delete: '<a type="button" class="btn btn-sm btn-primary mx-1"><i class="fas fa-trash"></i></a>',
            view: '<a type="button" class="btn btn-sm btn-primary mx-1"><i class="fas fa-eye"></i>&nbsp; View</a> &nbsp;',
            viewReport: '<a type="button" class="btn btn-sm btn-primary mx-1">View</a> &nbsp;',
            exportExcel: '<a type="button" class="btn btn-sm btn-success mx-1" style="background: #28a745 !important;">Export Excel</a> &nbsp;',
            exportPDF: '<a type="button" class="btn btn-sm btn-danger mx-1" style="background: #dc3545 !important;">Export PDF</a> &nbsp;',
            viewEye: '<a type="button" class="btn btn-sm btn-primary mx-1"><i class="fas fa-eye"></i></a>',
            return: '<a type="button" class="btn btn-sm btn-primary mx-1"><i class="fas fa-undo-alt"></i> &nbsp;Return</a>&nbsp;',
            unlock: '<a type="button" class="btn btn-sm btn-primary mx-1"><i class="fas fa-lock"></i>&nbsp; Unlock Form</a>&nbsp;',
            lock: '<a type="button" class="btn btn-sm btn-primary mx-1"><i class="fas fa-lock"></i>&nbsp; Lock Form</a>&nbsp;',
            resolve: '<a type="button" class="btn btn-sm btn-primary mx-1"><i class="fas fa-save"></i>&nbsp; Resolve</a>&nbsp;',
            submit: '<a type="button" class="btn btn-sm btn-primary mx-1"><i class="fas fa-save"></i>&nbsp; Submit</a>&nbsp;',
            empty: '<a type="button" class="btn btn-sm btn-primary mx-1"></a>&nbsp;',
            download: '<a type="button" class="btn btn-sm btn-primary mx-1"><i class="fas fa-download"></i>&nbsp;Download Report</a> &nbsp;',
            approve: '<a type="button" class="btn btn-sm btn-primary mx-1">&nbsp;Approve</a> &nbsp;',
        }
        
        this.removeFile=function(file){
            file.remove();
            this.refresh();
        }
        // this.hasFile=function(file){
        //     console.log("container.children",container.children);
        //     return container.children.length > 0;
        // }
        this.refresh=function(){
            if(container.children.length==0){
                container.appendChild(empty_div);
            }
            else{
                empty_div.remove();
            }
        }
        this.generateList = function(data, buttons, oldCard){
            data = getData(data);
            let card = document.createElement('div');
            if(oldCard){
                card = oldCard;
            }
            card.className = 'card frmcard';
            card.innerHTML = getTemplate();
            let pap_title = card.querySelector('.frmcard_title');
            let service_region = card.querySelector('.service-region');
            let category = card.querySelector('.frmcard_author');
            let edited_by_container = card.querySelector('.edited_by');
            let buttons_container = card.querySelector('.frmcard_btns');
            let created_at = card.querySelector('.formatted_date');

            service_region.innerHTML = data.service_region.accronym;
            pap_title.innerHTML = "<span class='frmcard-data-id'> ID #"+data.id+"</span>" + (data.pap_txt || data.suggested_pap.paps);
            category.innerHTML = data.category.category;
            created_at.innerHTML=data.formatted_created_at;
            console.log();
            for (const key in buttons) {
                let div = document.createElement('div');
                div.innerHTML = btns[key];
                let btn = div.firstChild;
                btn.onclick = buttons[key];
                buttons_container.appendChild(btn);
            }
            console.log(opts.container);
            if(!oldCard){
                container.appendChild(card);
            }
            return card;
        }
        this.generateReturnedList = function(data, buttons, oldCard){
            console.log("buttons generateReturnedList", buttons);
            let card = document.createElement('div');
            if(oldCard){
                card = oldCard;
            }
            data = getData(data);
            let baseClass = 'card-'+opts.container.substring(1,opts.container.length)+'-';
            card.className = 'card frmcard'
            card.id=baseClass+data.id;
            card.innerHTML = getReturnedTemplate(data.locked, status);
            card.querySelector('.card-body').setAttribute('data-target', '#'+baseClass+"collapse-"+data.id);
            card.querySelector('.collapse').setAttribute('id', baseClass+"collapse-"+data.id);
            card.querySelector('.collapse').setAttribute('data', "parent:'#"+baseClass+data.id+"'");
            
            let pap_title = card.querySelector('.frmcard_title');
            let service_region = card.querySelector('.service-region');
            let category = card.querySelector('.frmcard_author');
            let buttons_container = card.querySelector('.returned-buttons');
            let date_returned = card.querySelector('.date-returned');
            let reason_truncated = card.querySelector('.reason-truncated');
            let reason_returned = card.querySelector('.reason-complete');
            let returner = card.querySelector('.returner-name');

            service_region.innerHTML = data.service_region.accronym;
            pap_title.innerHTML = "<span class='frmcard-data-id'> ID #"+data.id+"</span>" + (data.pap_txt || data.suggested_pap.paps);
            category.innerHTML = data.category.category;
            date_returned.innerHTML=data.formatted_updated_at;
            reason_truncated.innerHTML=data.returnable.reason;
            reason_returned.innerHTML=data.returnable.reason;
            returner.innerHTML=data.returnable.returner.firstname+" "+data.returnable.returner.lastname;
            for (const key in buttons) {
                let div = document.createElement('div');
                let btn;
                if(key=="lockOrUnlock"){
                    div.innerHTML = btns['empty'];
                    btn = div.firstChild;
                    btn.innerHTML='<i class="fas fa-lock"></i>&nbsp; Lock Form';
                    if(data.locked=="1"){
                        btn.innerHTML='<i class="fas fa-lock"></i>&nbsp; Unlock Form';
                    }
                    btn.onclick = function(){
                        buttons[key](parseInt(data.locked), buttons);
                    }
                }
                else{
                    div.innerHTML = btns[key];
                    btn = div.firstChild;
                    btn.onclick = buttons[key];
                }
                buttons_container.appendChild(btn);
            }
            console.log(opts.container);
            if(!oldCard){
                container.appendChild(card);
            }
            
            return card;
        }
        this.reRenderElement=function(card, data, buttons, withBadge = false){
            console.log("buttons", buttons);
            let badge='';
            if(withBadge){
                badge = card.firstChild;
            }
            card.innerHTML='';
            let normalList = [1,2,3]
            if(normalList.includes(data.status_id)){
                card = this.generateList(data, buttons, card);
            }
            else{
                card = this.generateReturnedList(data, buttons, card);
            }
            if(withBadge){
                card.prepend(badge);
            }
        }
        this.reRenderOpcElement=function(card, data, buttons, withBadge = false){
            console.log("buttons", buttons);
            let badge='';
            if(withBadge){
                badge = card.firstChild;
            }
            card.innerHTML='';
            let normalList = [1,2,3]
            if(normalList.includes(data.status_id)){
                card = this.generateOpcList(data, buttons, card);
            }
            else{
                card = this.generateReturnedOpc(data, buttons, card);
            }
            if(withBadge){
                card.prepend(badge);
            }
        }
        this.destroy=function(){
            console.log("removed", status);
            console.log("loaded_files", [...loaded_files]);
            let index = loaded_files.indexOf(status);
            if(loaded_files[index]){
                loaded_files.splice(index, 1);
            }
            console.log('loaded_files',loaded_files);
            container.innerHTML = '<div class="text-center my-5 py-5 pre-loader">Loading....</div>';
        }
        this.getFiles = async function(url, force=false) {
            fileList.activeInstance=status;
            if(loaded_files.includes(status) && !force){return;}
            if(fetching && !force){return}
            loaded_files.push(status);
            fetching = true;
            let params = {
                status: statuses[status],
                filters: fileList.filters,
            }
            if(opts.params){
                for (const key in opts.params) {
                    params[key] = opts.params[key];
                }
            }

            new HttpRequest({
                url: url || fileUrl,
                method: 'post',
                data: params,
                done: function(res){
                    console.log(res);
                    fetching = false;
                    let preloader = container.querySelector('.pre-loader');
                    if(preloader){
                        preloader.remove();
                    }

                    let other_params = {};
                    let data = res;
                    if(res.pagination_data){
                        data = res.pagination_data;
                        for (const key in res) {
                            if(key != "pagination_data"){
                                other_params[key]=res[key];
                            }
                        }
                    }
                    if(data.data.length==0){
                        container.appendChild(empty_div);
                        if(opts.pagination != "scroll"){
                            paginationButtons.hide();
                        }
                        if(opts.empty){
                            opts.empty();
                        }
                    }
                    else{
                        if(controller(data.data, other_params)==false){
                            container.innerHTML="";
                            container.appendChild(empty_div);
                            
                        }
                        if(opts.pagination == "scroll"){
                            if(opts.paginationContainer){
                                document.querySelector(opts.paginationContainer).onscroll = function() {
                                    if(this.scrollHeight - this.scrollTop - this.clientHeight < 30){
                                        console.log('bottom-div');
                                        if(data.next_page_url){
                                            _this.getFiles(data.next_page_url, true);
                                        }a
                                    }
                                }
                            }
                            else{
                                window.onscroll = function(ev) {
                                    if ((window.innerHeight + window.scrollY) >= document.body.scrollHeight - 30) {
                                        console.log('bottom-doc');
                                        if(data.next_page_url){
                                            _this.getFiles(data.next_page_url, true);
                                        }
                                    }
                                };
                            }                   
                        }
                        else{
                            if(data.links.length > 3){
                                paginationButtons.generateLinks(data.links);
                            }
                        }
                    }
                }
            });
        }
        this.generatePpmpClassification=function(data, buttons, draggable){
            data = getData(data);
            let card = document.createElement('div');
            card.className = 'card frmcard';
            if(draggable){
                card.className = 'row align-items-center justify-content-center drag_frmcard';
            }
            card.innerHTML = getPlainTemplate(draggable);
            card.dataset.id = data.id;
            let pap_title = card.querySelector('.frmcard_title');
            let category = card.querySelector('.frmcard_author');
            let buttons_container = card.querySelector('.frmcard_btns');
            let service_region = card.querySelector('.service-region');
            service_region.innerHTML = data.service_region.accronym;
            pap_title.innerHTML = data.pap_txt || data.suggested_pap.paps;
            category.innerHTML = data.category.category;

            for (const key in buttons) {
                let div = document.createElement('div');
                div.innerHTML = btns[key];
                let btn = div.firstChild;
                btn.onclick = buttons[key];
                buttons_container.appendChild(btn);
            }
            container.appendChild(card);
            return card;
        }
        this.generateAllForms = function(data, buttons){
            let _this = this;
            let renderForm = {
                getBadge: function(text, class_color){
                    let badge = document.createElement('span');
                    badge.className="badge badge-primary "+class_color;
                    badge.innerHTML=text;
                    return badge;
                },
                1: function(){
                    let formBtns = {
                        publish: buttons['publish'],
                        edit: buttons['edit'],
                        delete: buttons['delete'],
                    };
                    let card = _this.generateList(data, formBtns);
                    card.prepend(this.getBadge("Draft", "badge_draft"));
                    return card;
                },
                2: function(){
                    let formBtns = {
                        view: buttons['view'],
                        delete: buttons['delete'],
                    };
                    let card = _this.generateList(data, formBtns);
                    card.prepend(this.getBadge("Published", "badge_published"));
                    return card;
                },
                3: function(){
                    let formBtns = {
                        publish: buttons['publish'],
                        edit: buttons['edit'],
                        delete: buttons['delete'],
                    };
                    let card = _this.generateList(data, formBtns);
                    card.prepend(this.getBadge("For Review", "badge_draft"));
                    return card;
                },
                4: function(){
                    let formBtns = {
                        lockOrUnlock: buttons['lockOrUnlock'],
                        viewEye: buttons['viewEye'],
                        edit: buttons['edit'],
                        resolve: buttons['resolve'],
                        delete: buttons['delete'],
                    };
                    let card = _this.generateReturnedList(data, formBtns);
                    card.prepend(this.getBadge("Returned", "badge_returned"));
                    return card;
                },
                5: function(){
                    let formBtns = {
                        lockOrUnlock: buttons['lockOrUnlock'],
                        viewEye: buttons['viewEye'],
                        edit: buttons['edit'],
                        delete: buttons['delete'],
                    };
                    let card = _this.generateReturnedList(data, formBtns);
                    card.prepend(this.getBadge("Resolved", "badge_resolved"));
                    return card;
                },
            }
            return renderForm[data.status_id]();
        }
        this.generateAllOpcForms = function(data, buttons){
            let _this = this;
            let renderForm = {
                getBadge: function(text, class_color){
                    let badge = document.createElement('span');
                    badge.className="badge badge-primary "+class_color;
                    badge.innerHTML=text;
                    return badge;
                },
                1: function(){
                    let formBtns = {
                        submit: buttons['submit'],
                        edit: buttons['edit'],
                        delete: buttons['delete'],
                    };
                    let card = _this.generateOpcList(data, formBtns);
                    card.prepend(this.getBadge("Draft", "badge_draft"));
                    return card;
                },
                2: function(){
                    let formBtns = {
                        view: buttons['view'],
                        delete: buttons['delete'],
                    };
                    let card = _this.generateOpcList(data, formBtns);
                    card.prepend(this.getBadge("Published", "badge_published"));
                    return card;
                },
                3: function(){
                    let formBtns = {
                        publish: buttons['publish'],
                        viewEye: buttons['viewEye'],
                        edit: buttons['edit'],
                        delete: buttons['delete'],
                    };
                    let card = _this.generateOpcList(data, formBtns);
                    card.prepend(this.getBadge("For Review", "badge_draft"));
                    return card;
                },
                4: function(){
                    let formBtns = {
                        lockOrUnlock: buttons['lockOrUnlock'],
                        viewEye: buttons['viewEye'],
                        edit: buttons['edit'],
                        resolve: buttons['resolve'],
                        delete: buttons['delete'],
                    };
                    let card = _this.generateReturnedOpc(data, formBtns);
                    card.prepend(this.getBadge("Returned", "badge_returned"));
                    return card;
                },
                5: function(){
                    let formBtns = {
                        lockOrUnlock: buttons['lockOrUnlock'],
                        viewEye: buttons['viewEye'],
                        edit: buttons['edit'],
                        delete: buttons['delete'],
                    };
                    let card = _this.generateReturnedList(data, formBtns);
                    card.prepend(this.getBadge("Resolved", "badge_resolved"));
                    return card;
                },
            }
            return renderForm[data.status_id]();
        }
        this.generateBudgetList = function(data, buttons, oldCard){
            let card = document.createElement('div');
            if(oldCard){
                card = oldCard;
            }
            card.className = 'card frmcard';
            card.innerHTML = getBudgetTemplate();
            let pap_title = card.querySelector('.frmcard_title');
            let service_region = card.querySelector('.service-region');
            let budgetHtml = card.querySelector('.frmcard_author');
            let edited_by_container = card.querySelector('.edited_by');
            let buttons_container = card.querySelector('.frmcard_btns');
            let created_at = card.querySelector('.formatted_date');

            service_region.innerHTML = data.accronym;
            pap_title.innerHTML = data.accronym + (type == "budget" ? " Budget Form": type == "apb" ? " APB":"");
            budgetHtml.innerHTML = numberFormatter(data.budget);
            if(type == "opc"){
                pap_title.innerHTML = ` <span class="frmcard-data-id">${data.opc_code}</span>${data.accronym} OPC`;
                budgetHtml.innerHTML = "";
            }
           
            created_at.innerHTML=data.year;
            for (const key in buttons) {
                let div = document.createElement('div');
                div.innerHTML = btns[key];
                let btn = div.firstChild;
                btn.onclick = buttons[key];
                buttons_container.appendChild(btn);
            }
            console.log(opts.container);
            if(!oldCard){
                container.appendChild(card);
            }
            return card;
        }
        this.generateAppForm = function(data, buttons, oldCard){
            let card = document.createElement('div');
            if(oldCard){
                card = oldCard;
            }
            card.className = 'card frmcard';
            card.innerHTML = getAppFormTemplate();
            let pap_title = card.querySelector('.frmcard_title');
            let service_region = card.querySelector('.service-region');
            let budgetHtml = card.querySelector('.frmcard_author');
            let edited_by_container = card.querySelector('.edited_by');
            let buttons_container = card.querySelector('.frmcard_btns');
            let created_at = card.querySelector('.formatted_date');
            let created_at_label = created_at.previousElementSibling;
            created_at_label.innerHTML="Date Created";
            pap_title.innerHTML = "APP Form "+data.year;
            created_at.innerHTML=data.formatted_created_at;
            for (const key in buttons) {
                let div = document.createElement('div');
                div.innerHTML = btns[key];
                let btn = div.firstChild;
                btn.onclick = buttons[key];
                buttons_container.appendChild(btn);
            }
            console.log(opts.container);
            if(!oldCard){
                container.appendChild(card);
            }
            return card;
        }
        this.generateOpcList = function(data, buttons, oldCard){
            let card = document.createElement('div');
            if(oldCard){
                card = oldCard;
            }
            card.className = 'card frmcard';
            card.innerHTML = getBudgetTemplate();
            let pap_title = card.querySelector('.frmcard_title');
            let service_region = card.querySelector('.service-region');
            let budgetHtml = card.querySelector('.frmcard_author');
            let edited_by_container = card.querySelector('.edited_by');
            let buttons_container = card.querySelector('.frmcard_btns');
            let created_at = card.querySelector('.formatted_date');
            let created_at_label = created_at.previousElementSibling;
            created_at_label.innerHTML="Date Created";
            service_region.innerHTML = data.service_region.accronym;
            pap_title.innerHTML = "OPC/OPS";
            budgetHtml.innerHTML = data.semester==1 ? "1st Semester":"2nd Semester";
            created_at.innerHTML=data.formatted_created_at;
            for (const key in buttons) {
                let div = document.createElement('div');
                div.innerHTML = btns[key];
                let btn = div.firstChild;
                btn.onclick = buttons[key];
                buttons_container.appendChild(btn);
            }
            console.log(opts.container);
            if(!oldCard){
                container.appendChild(card);
            }
            return card;
        }
        this.generateReturnedOpc = function(data, buttons, oldCard){
            console.log("buttons generateReturnedList", buttons);
            let card = document.createElement('div');
            if(oldCard){
                card = oldCard;
            }
            data = getData(data);
            let baseClass = 'card-'+opts.container.substring(1,opts.container.length)+'-';
            card.className = 'card frmcard'
            card.id=baseClass+data.id;
            card.innerHTML = getReturnedTemplate(data.locked, status);
            card.querySelector('.card-body').setAttribute('data-target', '#'+baseClass+"collapse-"+data.id);
            card.querySelector('.collapse').setAttribute('id', baseClass+"collapse-"+data.id);
            card.querySelector('.collapse').setAttribute('data', "parent:'#"+baseClass+data.id+"'");
            
            let pap_title = card.querySelector('.frmcard_title');
            let service_region = card.querySelector('.service-region');
            let category = card.querySelector('.frmcard_author');
            let buttons_container = card.querySelector('.returned-buttons');
            let date_returned = card.querySelector('.date-returned');
            let reason_truncated = card.querySelector('.reason-truncated');
            let reason_returned = card.querySelector('.reason-complete');
            let returner = card.querySelector('.returner-name');

            service_region.innerHTML = data.service_region.accronym;
            pap_title.innerHTML = "OPC/OPS";
            category.innerHTML = data.semester == "1" ? "1st Semester":"2nd Semester";
            date_returned.innerHTML=data.formatted_updated_at;
            reason_truncated.innerHTML=data.returnable.reason;
            reason_returned.innerHTML=data.returnable.reason;
            returner.innerHTML=data.returnable.returner.firstname+" "+data.returnable.returner.lastname;
            for (const key in buttons) {
                let div = document.createElement('div');
                let btn;
                if(key=="lockOrUnlock"){
                    div.innerHTML = btns['empty'];
                    btn = div.firstChild;
                    btn.innerHTML='<i class="fas fa-lock"></i>&nbsp; Lock Form';
                    if(data.locked=="1"){
                        btn.innerHTML='<i class="fas fa-lock"></i>&nbsp; Unlock Form';
                    }
                    btn.onclick = function(){
                        buttons[key](parseInt(data.locked), buttons);
                    }
                }
                else{
                    div.innerHTML = btns[key];
                    btn = div.firstChild;
                    btn.onclick = buttons[key];
                }
                buttons_container.appendChild(btn);
            }
            console.log(opts.container);
            if(!oldCard){
                container.appendChild(card);
            }
            
            return card;
        }
        this.generateFiscalList = function(data, buttons, oldCard){
            let card = document.createElement('div');
            if(oldCard){
                card = oldCard;
            }
            card.className = 'card frmcard';
            card.innerHTML = getFiscalTemplate();
            let pap_title = card.querySelector('.frmcard_title');
            let budgetHtml = card.querySelector('.frmcard_author');
            let edited_by_container = card.querySelector('.edited_by');
            let buttons_container = card.querySelector('.frmcard_btns');
            let created_at = card.querySelector('.formatted_date');
            pap_title.innerHTML = "Working Fiscal Limit";
            budgetHtml.innerHTML = numberFormatter(data.budget);
            created_at.innerHTML=data.year;
            for (const key in buttons) {
                let div = document.createElement('div');
                div.innerHTML = btns[key];
                let btn = div.firstChild;
                btn.onclick = buttons[key];
                buttons_container.appendChild(btn);
            }
            console.log(opts.container);
            if(!oldCard){
                container.appendChild(card);
            }
            return card;
        }
    }
    function getData(data){
        if(type=="ppmp"){
            data.poe.id = data.id;
            data.poe.created_at = data.created_at;
            data.poe.returnable = data.returnable;
            data.poe.locked = data.locked;
            data.poe.locker_user_id = data.locker_user_id;
            return data.poe;
        }
        else{
            return data;
        }
    }
    function numberFormatter(num){
        if(!num){
            return "0.00";
        }
        let toInt = function(num){
            num = num.toString();
            num = num.replace(/,/g, '');
            num = num.replace(/[a-z]/gi, '');
            num = parseFloat(num) || 0;
            return num;
        }
        return Number(toInt(num)).toLocaleString('en', {
			minimumFractionDigits: 2,
			maximumFractionDigits: 2
		});
    }
    function getTemplate(){
        let template='<div class="card-body">';
        template+='<div class="row align-items-center">';
        template+='<div class="col-md-8">';
        template+='<div class="row align-items-center">';
        template+='<div class="col-md-2 frmcardivimg">';
        template+='<img class="frmcard_img" src="'+window.location.origin+'/images/poeicon.png">';
        template+='</div>';
        template+='<div class="col-md-10 frmcardivname">';
        template+='<p class="frmcard_service">Service/Region: <span class="text-uppercase service-region">Region I</span></p>';
        template+='<h4 class="frmcard_title text-truncate">PAP Title here</h4>';
        template+='<p class="frmcard_author">MOOE - GAS</p>';
        template+='</div>';
        template+='</div>';
        template+='</div>';
        template+='<div class="col-md-4">';
        template+='<div class="row align-items-center">';
        template+='<div class="col-md-12 text-right created_at">';
        template+='<h4 class="frmcard_date">Date Created:</h4>';
        template+='<p class="frmcard_date formatted_date">12/12/2021</p>';
        template+='</div>';
        template+='</div>';
        template+='</div>';
        template+='</div>';
        template+='</div>';
        template+='<div class="frmcard_btns">';
        template+='</div>';
        return template;
    }
    function getAppFormTemplate(){
        let template='<div class="card-body">';
        template+='<div class="row align-items-center">';
        template+='<div class="col-md-8">';
        template+='<div class="row align-items-center">';
        template+='<div class="col-md-2 frmcardivimg">';
        template+='<img class="frmcard_img" src="'+window.location.origin+'/images/appicon.png">';
        template+='</div>';
        template+='<div class="col-md-10 frmcardivname">';
        template+='<h4 class="frmcard_title text-truncate">PAP Title here</h4>';
        template+='</div>';
        template+='</div>';
        template+='</div>';
        template+='<div class="col-md-4">';
        template+='<div class="row align-items-center">';
        template+='<div class="col-md-12 text-right created_at">';
        template+='<h4 class="frmcard_date">Date Created:</h4>';
        template+='<p class="frmcard_date formatted_date">12/12/2021</p>';
        template+='</div>';
        template+='</div>';
        template+='</div>';
        template+='</div>';
        template+='</div>';
        template+='<div class="frmcard_btns">';
        template+='</div>';
        return template;
    }
    function getFiscalTemplate(){
        let template='<div class="card-body">';
        template+='<div class="row align-items-center">';
        template+='<div class="col-md-8">';
        template+='<div class="row align-items-center">';
        template+='<div class="col-md-2 frmcardivimg">';
        template+='<img class="frmcard_img" src="'+window.location.origin+'/images/'+type+'icon.png">';
        template+='</div>';
        template+='<div class="col-md-10 frmcardivname">';
        template+='<h4 class="frmcard_title text-truncate">PAP Title here</h4>';
        template+='<p class="frmcard_author">MOOE - GAS</p>';
        template+='</div>';
        template+='</div>';
        template+='</div>';
        template+='<div class="col-md-4">';
        template+='<div class="row align-items-center">';
        template+='<div class="col-md-12 text-right created_at">';
        template+='<h4 class="frmcard_date">Fiscal Year</h4>';
        template+='<p class="frmcard_date formatted_date">12/12/2021</p>';
        template+='</div>';
        template+='</div>';
        template+='</div>';
        template+='</div>';
        template+='</div>';
        template+='<div class="frmcard_btns">';
        template+='</div>';
        return template;
    }
    function getBudgetTemplate(){
        let template='<div class="card-body">';
        template+='<div class="row align-items-center">';
        template+='<div class="col-md-8">';
        template+='<div class="row align-items-center">';
        template+='<div class="col-md-2 frmcardivimg">';
        template+='<img class="frmcard_img" src="'+window.location.origin+'/images/'+type+'icon.png">';
        template+='</div>';
        template+='<div class="col-md-10 frmcardivname">';
        template+='<p class="frmcard_service">Service/Region: <span class="text-uppercase service-region">Region I</span></p>';
        template+='<h4 class="frmcard_title text-truncate">PAP Title here</h4>';
        template+='<p class="frmcard_author">MOOE - GAS</p>';
        template+='</div>';
        template+='</div>';
        template+='</div>';
        template+='<div class="col-md-4">';
        template+='<div class="row align-items-center">';
        template+='<div class="col-md-12 text-right created_at">';
        template+='<h4 class="frmcard_date">Fiscal Year</h4>';
        template+='<p class="frmcard_date formatted_date">12/12/2021</p>';
        template+='</div>';
        template+='</div>';
        template+='</div>';
        template+='</div>';
        template+='</div>';
        template+='<div class="frmcard_btns">';
        template+='</div>';
        return template;
    }
    function getPlainTemplate(draggable){
        let template='';
        if(draggable){
            template+='<div class="col-md-1 text-center drag_frmdiv">';
            template+='<i class="fas fa-grip-vertical"></i>';
            template+='</div>';
            template+='<div class="col-md-11" style="padding:0;">';
            template+='<div class="card frmcard">';
        }
        template+='<div class="card-body">';
        template+='<div class="row align-items-center">';
        template+='<div class="col-md-2 frmcardivimg">';
        template+='<img class="frmcard_img" src="'+window.location.origin+'/images/ppmpicon.png">';
        template+='</div>';
        template+='<div class="col-md-10">';
        template+='<p class="frmcard_service">Service/Region: <span class="text-uppercase service-region">Region I</span></p>';
        template+='<h4 class="frmcard_title text-truncate">PPMP - PAP Title here</h4>';
        template+='<p class="frmcard_author">Author</p>';
        template+='</div>';
        template+='</div>';
        template+='</div>';
        template+='<div class="frmcard_btns">';
        template+='</div>';
        template+='</div>';
        if(draggable){
            template+='</div>';
            template+='</div>';
        }
        return template;
    }
    function getReturnedTemplate(locked, status){
        let template='';
        if(locked=="1"){
            template+='<img class="frmlocked" src="'+window.location.origin+'/images/lock.png">';
        }
        template+='<div class="card-body" data-toggle="collapse">';
        template+='<div class="row align-items-center">';
        template+='<div class="col-md-6">';
        template+='<div class="row align-items-center">';
        template+='<div class="col-md-2 frmcardivimg">';
        template+='<img class="frmcard_img" src="'+window.location.origin+'/images/poeicon.png">';
        template+='</div>';
        template+='<div class="col-md-10 frmcardivname">';
        template+='<p class="frmcard_service">Service/Region: <span class="text-uppercase service-region">Region I</span></p>';
        template+='<h4 class="frmcard_title text-truncate" style="width:95%">PAP Title here</h4>';
        template+='<p class="frmcard_author">MOOE - GAS</p>';
        template+='</div>';
        template+='</div>';
        template+='</div>';
        template+='<div class="col-md-6">';
        template+='<div class="row align-items-center">';
        template+='<div class="col-md-4 text-left">';
        template+='<h4 class="frmcard_date text-capitalize">Date '+status+':</h4>';
        template+='<p class="frmcard_date date-returned">12/12/2021</p>';
        template+='</div>';
        template+='<div class="col-md-8 text-left">';
        template+='<h4 class="frmcard_accreason">Reason of Return:</h4>';
        template+='<p class="frmcard_accreason reason-truncated text-truncate">';
        template+='</p>';
        template+='</div>';
        template+='</div>';
        template+='</div>';
        template+='</div>';
        template+='</div>';
        template+='<div class="collapse">';
        template+='<div class="accord_body">';
        template+='<h4 class="frmcard_accrtitle">Reason of Return</h4>';
        template+='<p class="frmcard_accrauthor reason-complete">';
        template+='<br>';
        template+='</p>';
        template+='<div class="row">';
        template+='<div class="col">';
        template+='<p class="frmcard_edited">- <strong class="returner-name">juan dela cruz</strong></p>';
        template+='</div>';
        template+='<div class="col text-right returned-buttons">';
        template+='</div>';
        template+='</div>';
        template+='</div>';
        template+='</div>';

        return template;
    }
}
function getSubpaps(poe_id, callback){
    new HttpRequest({
        url: "/form/poe/get/subpaps",
        data: {poe_id:poe_id},
        done: function(res){
            callback(res);
        }
    });
}
function limitStringInput(element, length, reason_el){
    if(element){
        element.oninput=function(){
            if(this.value.length > length){
                this.value = this.value.substring(0, length);;
                if(reason_el){
                    reason_el.innerHTML=length;
                }
                return false;
            }
            else{
                if(reason_el){
                    reason_el.innerHTML=this.value.length;
                }
            }
        };
    }
}

limitStringInput(
    document.querySelector('#modal-return-pap-reason'),
    200,
    document.querySelector('#modal-return-reason-length')
)
function FormReturn(opts){
    let error = false;
    let reason = document.querySelector('#modal-return-pap-reason');
    if(reason.value==""){
        toastr.error('Reason required');
        error = true;
    }
    else if(reason.value.length > 200){
        toastr.error('String limit reached.');
        error = true;
    }
    if(!error){
        opts.data['reason'] = reason.value;
        new HttpRequest(opts);
    }
}
function HttpRequest(opts){
    let headers = {
        method: opts.method || "POST",
        headers: {
            Accept: "application/json, text/plain, */*",
            "Content-Type": "application/json",
            "X-CSRF-Token": document.querySelector('[name="csrf-token"]').content,
        },
    }
    if(opts.data){
        headers['body'] = JSON.stringify(opts.data);
    }
    let url = isValidHttpUrl(opts.url) ? opts.url:window.location.origin+opts.url;
    fetch(url, headers)
    .then(function (response) {
        if (!response.ok) {
            throw new Error("HTTP status " + response.status);
        }
        if(opts.dataType=="text"){
            return response.text();
        }
        else{
            return response.json();
        }
    })
    .then(opts.done);
}
function isValidHttpUrl(string) {
    let url;

    try {
        url = new URL(string);
    } catch (_) {
        return false;  
    }

    return url.protocol === "http:" || url.protocol === "https:";
}
function exportPpmp(poe_id, papdata,callback){
    let source_id = 1;
    let error = false;
    const base_code = "SUBPAP ";
    let subpaps = {};
    let ul_total;
    let totalSupPap;
    const options = {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    };
    let createElement = function (el, className, innerHTML) {
        let element = document.createElement(el);
        if(className)
        element.className = className;
        if (innerHTML)
        element.innerHTML = innerHTML;
        return element;
    }
    const container = createElement('table');
    container.border="2";
    appendPapData();
    function SubPap(subpapdata) {
        console.log("subpapdata",subpapdata);
        // const container = document.querySelector(el);
        const subpap_id = source_id;
        const SUB_PAP_CODE = base_code + subpap_id;
        const monthStartIndex = 5;
        let disabledMonthSelection = true;
        let contents = [];
        let selectedMonths = [];
        let contents_source_id = 1;
        let monthsTotal={};
        let subpap_months_added={};
        let subpap_months_added_count={};
        const expense_class = [
            "",
            "PS",
            "MOOE",
            "CO",
        ];
        const codes = [
            "",
            "123001",
            "543002",
            "513003",
            "503004",
            "500015",
        ];
        const units = [
            "",
            "set",
            "pax"
        ];
        function toInt(num){
            num = num.toString();
            num = num.replace(/,/g, '');
            num = num.replace(/[a-z]/gi, '');
            num = parseFloat(num) || 0;
            return num;
        }
        let createElement = function (el, className, innerHTML) {
            let element = document.createElement(el);
            if(className)
            element.className = className;
            if (innerHTML)
            element.innerHTML = innerHTML;
            return element;
        }

        const totalEl = createElement('span', "font-weight-bold");
        let subPAPname = createElement('span', 'font-weight-bold');
        subPAPname.innerHTML = subpapdata.name;
        const table = createElement("table", "");
        const ul_header_tr = createElement("tr", "header");
        const ul_header = createElement("thead", "header");
        ul_header.append(ul_header_tr);
        const mainDiv = createElement("tbody", "");
        const subpap_header_tr = createElement('tr', "cell");

        let SubPapApi = (function () {
            function SubPapApi(source_id, data, cell) {
                this.data = data;
                this.source_id = source_id;
                this.cell = cell;
            }
            SubPapApi.prototype.getData = function () {
                return {
                    item_account_code: this.data.item_account_code,
                    item_account_code_id: this.data.item_account_code_id,
                    item_requirement: this.data.item_requirement,
                    item_procurement_mode: this.data.item_procurement_mode,
                    item_unit: this.data.item_unit,
                    item_cost: this.data.item_cost,
                    item_qty_pax: toInt(this.data.item_qty_pax),
                    item_days: toInt(this.data.item_days),
                    item_months: this.data.item_months,
                }
            }
            SubPapApi.prototype.getTotal = function () {
                return this.data.total.innerHTML;
            }
            SubPapApi.prototype.update = function (data) {
                for (const key in data) {
                    this.data[key] = data[key];
                }
            }
            SubPapApi.prototype.remove = function () {
                this.cell.remove();
                delete contents[this.source_id];
            }
            return SubPapApi;
        }());
        let generateCell = function (ul_cell,
            classes = ["code-width", "item-req-width", "procurement-width", "total-width", "procurement-width"]
        ) {
            for (let i = 0; i < classes.length; i++) {
                let li = createElement('td', classes[i]);
                ul_cell.append(li);
            }
            for (let i = 0; i < 12; i++) {
                let li = createElement('td');
                ul_cell.append(li);
            }
        }
        let generateHeaders = function () {
            generateCell(ul_header_tr);
            const data = [
                // "Action",
                "Code/No.",
                "General Description",
                "Quantity/Size",
                "Estimated Budget",
                "Procurement Mode",
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ];
            const cells = ul_header_tr.children;
            for (let i = 0; i < data.length; i++) {
                if (data[i] != undefined) {
                    cells[i].append(data[i]);
                }
            }
        }
        let generateSubpapHeader = function () {
            generateCell(subpap_header_tr, 
                ["code-width", "item-req-width", "total-width", "procurement-width"]
            );
            const cells = subpap_header_tr.children;
            const select = createElement('select', "");
            const data = [
                // addContent,
                SUB_PAP_CODE,
                subPAPname,
                totalEl,
            ];
            for (let i = 0; i < cells.length; i++) {
                if (data[i]) {
                    cells[i].append(data[i]);
                }
            }
            cells[1].colSpan="2";
            mainDiv.appendChild(subpap_header_tr);
        }
        let generateTotal = function () {
            ul_total = createElement("tfoot", "header");
            let ul_total_tr = createElement("tr", "header");
            ul_total.append(ul_total_tr);
            ul_total.classList.add('font-weight-bold');
            generateCell(ul_total_tr);
            totalSupPap = createElement('span', "", "-");
            const data = [
                // "",
                "",
                "Total",
                "",
                totalSupPap
            ];
            const cells = ul_total_tr.children;
            for (let i = 0; i < data.length; i++) {
                if (data[i] != undefined) {
                    cells[i].append(data[i]);
                }
            }
            for (let i = monthStartIndex; i < (monthStartIndex + 12); i++) {
                let span = createElement('span', 'text-center');
                span.id='month-total-'+((i-monthStartIndex)+1);
                console.log(cells[i]);
                cells[i].append(span);
            }
            container.appendChild(ul_total)
        }
        function computeSubPapTotal() {
            let sum = 0;
            for (const key in contents) {
                let a = parseFloat(contents[key].getTotal().replace(/,/g, ''));
                sum += parseFloat(a) || 0;
            }
            if (!isNaN(sum)) {
                totalEl.innerHTML = Number(sum).toLocaleString('en', options);
            }
            computeSubPapTotalTotalan();
        }

        function generateSubPapContent(data, tr) {
            const ul_cell = createElement('tr', "cell");
            generateCell(ul_cell);

            let total = createElement('span', '', data.item_total);
            let dropdown = '';
            dropdown += '<button class="btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-ellipsis-h fa-sm"></i></button>'
            dropdown += '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">'
            dropdown += '<a class="dropdown-item insert-item" href="#"><i class="fas fa-plus"></i>&nbsp;&nbsp;Insert item requirement<br><small class="sub-label">Click to insert new item requirement</small></a><hr>'
            dropdown += '<a class="dropdown-item edit-item" href="#"><i class="fas fa-edit"></i>&nbsp;&nbsp;Edit</a>'
            dropdown += '<a class="dropdown-item delete-item" href="#"><i class="fas fa-trash"></i>&nbsp;&nbsp;Delete</a>'
            dropdown += '<hr><a class="dropdown-item add-item-comment" href="#"><i class="fas fa-comment-alt"></i>&nbsp;&nbsp;Comment<br><small class="sub-label">Click to view comment section</small></a>'
            dropdown += '</div>';
            const actionDropdown = createElement("div", "dropdown");
            actionDropdown.innerHTML = dropdown;
            let insert_item = actionDropdown.querySelector('.insert-item');
            let edit_subpap = actionDropdown.querySelector('.edit-item');
            let delete_subpap = actionDropdown.querySelector('.delete-item');
            let add_comment = actionDropdown.querySelector('.add-item-comment');

            let setData = function(data){
                let cellData = [
                    // actionDropdown,
                    data.item_account_code,
                    data.item_requirement,
                    data.item_qty_pax+" "+data.item_unit+" x "+data.item_days+" days",
                    total,
                    data.item_procurement_mode_text,
                ];
                let cells = ul_cell.children;
                for (let i = 0; i < cells.length; i++) {
                    cells[i].innerHTML="";
                    if (cellData[i]) {
                        cells[i].append(cellData[i]);
                    }
                }
                for (let index = 0; index < data.item_months.length; index++) {
                    const element = data.item_months[index];
                    let val = formatter(element.amount);
                    let div = createElement('div', 'text-center');
                    div.appendChild(createElement('div', 'font-weight-bold text-truncate', element.qty+' '+'<span class="item-req-t-name">'+subpapdata.target_name+'</span>'));
                    div.appendChild(createElement('div', '', val));
                    cells[(element.month-1) + monthStartIndex].append(div);
                    cells[(element.month-1) + monthStartIndex].style.backgroundColor="#ffff138c";
                    cells[(element.month-1) + monthStartIndex].style.maxWidth="7rem";
                    addMonthTotal((element.month), toInt(val));
                }
            }
            setData(data);
            if(tr){
                mainDiv.insertBefore(ul_cell, tr)
            }
            else{
                mainDiv.appendChild(ul_cell);
            }
            data['total'] = total;
            const subPapApi = new SubPapApi(contents_source_id, data, ul_cell);
            contents[contents_source_id] = subPapApi;
            contents_source_id++;
            computeSubPapTotal();
        }
        function computeTotal(qty, cost, days) {
            let c = toInt(qty) || 1;
            let q = toInt(cost) || 1;
            let d = toInt(days) || 1;
            let t = c * q * d;
            if (!isNaN(t)) {
                return Number(t).toLocaleString('en', options);;
            }
        }
        function getItemData(){
            error=false;
            console.log(selectedMonths);
            let data = {
                item_account_code: item_account_code.value,
                item_account_code_id: ac.getSelected(),
                item_requirement: item_requirement.value,
                item_procurement_mode: item_procurement_mode.value,
                item_procurement_mode_text: document.querySelector('#item_procurement_mode').selectedOptions[0].innerHTML,
                item_unit: item_unit.value,
                item_cost: item_cost.value,
                item_qty_pax: item_qty_pax.value,
                item_days: item_days.value,
                item_total: 0,
                item_months: [],
                item_selected_months: [...selectedMonths],
                item_selected_months_values: [],
            }
            data.item_total = computeTotal();
            let totalMonthValues = 0
            for (let index = 0; index < selectedMonths.length; index++) {
                const element = selectedMonths[index];
                let val = (toInt(item_month_values.children[element].querySelector('input').value) || 0);
                totalMonthValues += val;
                data.item_selected_months_values.push(val);
                data.item_months.push({
                    month: parseInt(element) + 1,
                    amount: val,
                });
            }
            let errElement = document.querySelector('#total-error');

            if(toInt(data.item_total) != toInt(totalMonthValues)){
                let val = formatter(toInt(data.item_total) - toInt(totalMonthValues));
                errElement.innerHTML='Total did not match. ('+val+')';
                console.log(val);
                return false;
            }
            check_error(data.item_account_code, "Account code not set");
            check_error(data.item_requirement, "Item requirement not set");
            check_error(data.item_procurement_mode, "Item procurement mode not set");
            check_error(data.item_cost, "Item cost not set");
            check_error(data.item_unit, "Item unit not set");
            check_error(data.item_qty_pax, "Item quantity not set");
            check_error(data.item_days, "Item number of days not set");

            if(error){
                return false;
            }
            errElement.innerHTML='';
            return data;
        }
        function addMonthTotal(m, a, subtract = false){
            console.log(m, a);
            console.log('month-total-'+m);
            let totalMonth = container.querySelector('#month-total-'+m);
            let aa = toInt(totalMonth.innerHTML);
            let val = 0;
            if(subtract){
                val = aa - a;
            }
            else{
                val = aa + a;
            }

            if(val <= 0){
                totalMonth.innerHTML = "";
            }
            else{
                totalMonth.innerHTML = formatter(val);
            }

            if(!subpap_months_added_count[m]){
                subpap_months_added_count[m] = 0;
            }

            if(subtract){
                subpap_months_added_count[m]--;
                let td = subpap_header_tr.children[(monthStartIndex - 1) + (toInt(m) - 1)];
                subpap_months_added[m] -= a;
                if(subpap_months_added[m] == 0){
                    delete subpap_months_added[m];
                    td.style='';
                    td.innerHTML='';
                }
                else{
                    td.innerHTML = formatter(subpap_months_added[m]);
                }
                // if(subpap_months_added_count[m] == 1){
                // 	td.style='';
                // 	td.innerHTML='';
                // }
            }
            else{
                let td = subpap_header_tr.children[(monthStartIndex - 1) + (toInt(m) - 1)];
                subpap_months_added_count[m]++;
                if(subpap_months_added[m]){
                    subpap_months_added[m] += a;
                }
                else{
                    // td.style.backgroundColor='#FFFF00';
                    td.style.fontWeight='600';
                    subpap_months_added[m] = a;
                }
                td.innerHTML = formatter(subpap_months_added[m]);
            }
        }
        this.getData = function () {
            let item_req_data = [];
            for (const key in contents) {
                item_req_data.push(contents[key].getData());
            }
            return {
                sub_pap_name: name,
                item_reqs: item_req_data,
            };
        }
        this.getTotal = function () {
            return parseFloat(totalEl.innerHTML.replace(/,/g, ''))
        }

        if (Object.keys(subpaps).length == 0) {
            container.appendChild(ul_header);
            generateHeaders();
            generateTotal();
        }
        generateSubpapHeader();
        container.insertBefore(mainDiv, ul_total);

        this.addItemRequirement=function(item_requirements){
            for (let i = 0; i < item_requirements.length; i++) {
                let item = item_requirements[i];
                let data = {
                    item_account_code: item.chart_of_account.code+"-"+item.chart_of_account.expense_object,
                    item_account_code_id: item.chart_of_account.id,
                    item_requirement: item.itemreq_txt || item.suggested_item_requirement.ireq,
                    item_procurement_mode: item.procurement_mode_id,
                    item_procurement_mode_text: item.procurement_mode.title,
                    item_unit: item.unit || item.suggested_unit.unit,
                    item_cost: formatter(item.per_capita_cost),
                    item_qty_pax: item.qty_pax,
                    item_days: item.no_of_days,
                    item_total: 0,
                    item_months: item.item_months,
                }
                data.item_total = computeTotal(data.item_qty_pax, data.item_cost, data.item_days);
                generateSubPapContent(data);
            }
        }
    }	
    function toFloat(num){
        num = num.toString();
        num = num.replace(/,/g, '');
        num = num.replace(/[a-z]/gi, '');
        num = parseFloat(num) || 0;
        return num;
    }
    function computeSubPapTotalTotalan() {
        let total = 0;
        for (const key in subpaps) {
            const subpap = subpaps[key];
            if (!isNaN(subpap.getTotal())) {
                total += subpap.getTotal();
            }
            if (!isNaN(total)) {
                totalSupPap.innerHTML = Number(toFloat(total)).toLocaleString('en', options);
                // document.querySelector('#total-pap-budget').innerHTML = Number(total).toLocaleString('en', options);
            }
        }	
        if (!isNaN(total)) {
            return total;
        }
        return 0;
    }
    function toCommaSeparated(arr, key){
        let data = [];
        for (let i = 0; i < arr.length; i++) {
            data.push(eval('arr[i].'+key));
        }
        return data.join(',');
    }
    function appendPapData() {
        let tbody = createElement('tbody');
        let tr1 = createElement('tr');
        let papname = createElement('td', '', papdata.pap_txt || papdata.suggested_pap.paps);
        let totalbudget = createElement('td', '', 'Total Budget: '+Number(toFloat(papdata.total)).toLocaleString('en', options));
        papname.colSpan="3";
        totalbudget.colSpan="3";
        tr1.appendChild(papname);
        tr1.appendChild(totalbudget);

        let tr2 = createElement('tr');
        let mfo = createElement('td', '', 'MFO: '+papdata.mfo.desc);
        let kdp = createElement('td', '', 'KDP: '+papdata.kdp.desc);
        mfo.colSpan="3";
        kdp.colSpan="3";
        tr2.appendChild(mfo);
        tr2.appendChild(kdp);

        let tr3 = createElement('tr');
        let form_related = createElement('td', '', 'KDP: '+toCommaSeparated(papdata.poe_tags, 'pap_tag.tag'));
        let target_sector = createElement('td', '', 'KDP: '+toCommaSeparated(papdata.target_sectors, 'target_sector.sector'));
        let geolocation = createElement('td', '', 'KDP: '+papdata.geolocation);
        form_related.colSpan="2";
        target_sector.colSpan="2";
        geolocation.colSpan="2";
        tr3.appendChild(form_related);
        tr3.appendChild(target_sector);
        tr3.appendChild(geolocation);

        let tr4 = createElement('tr');
        let category = createElement('td', '', 'Category Code: '+papdata.category.category);
        let thematic = createElement('td', '', 'Thematic Areas/Clusters: '+papdata.thematic_area_cluster.thematic_area_cluster);
        let service_region = createElement('td', '', 'Service Region: '+papdata.service_region.service_region);
        category.colSpan="2";
        thematic.colSpan="2";
        service_region.colSpan="2";
        tr4.appendChild(category);
        tr4.appendChild(thematic);
        tr4.appendChild(service_region);

        tbody.appendChild(tr1);
        tbody.appendChild(createElement('tr'));
        tbody.appendChild(tr2);
        tbody.appendChild(createElement('tr'));
        tbody.appendChild(tr3);
        tbody.appendChild(createElement('tr'));
        tbody.appendChild(tr4);
        tbody.appendChild(createElement('tr'));
        tbody.appendChild(createElement('tr'));
        container.appendChild(tbody);
    }
    getSubpaps(poe_id, function(res){
        console.log("subpaps",res);
        for (let i = 0; i < res.length; i++) {
            let subpap = new SubPap({
                name: res[i].subpap_txt || res[i].suggested_sub_pap.subpaps,
                subpap_quarter_target: res[i].quarter_target_id,
                target_name: res[i].quarter_target.quarter_target,
            });
            subpaps[source_id] = subpap;
            source_id++;
            subpap.addItemRequirement(res[i].item_requirements);
        }
        console.log(subpaps);
        exportToExcel(container, (papdata.pap_txt || papdata.suggested_pap.paps), callback);
    });
    
}
function exportData(poe_id, papdata, callback){
    let source_id = 1;
    let error = false;
    const base_code = "SUBPAP ";
    let subpaps = {};
    let ul_total;
    let totalSupPap;
    const options = {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    };
    let createElement = function (el, className, innerHTML) {
        let element = document.createElement(el);
        if(className)
        element.className = className;
        if (innerHTML)
        element.innerHTML = innerHTML;
        return element;
    }
    const container = createElement('table');
    container.border="2";
    appendPapData();
    function SubPap(subpapdata) {
        const subpap_id = source_id;
        const SUB_PAP_CODE = base_code + subpap_id;
        const monthStartIndex = 8;
        let contents = [];
        let selectedMonths = [];
        let contents_source_id = 1;
        let subpap_months_added={};
        let subpap_months_added_count={};
        
        let toInt = function(num){
            num = num.toString();
            num = num.replace(/[^\d.-]+/g,'');
            num = parseInt(num) || 0;
            return num;
        }
        let formatter = function(num){
            if(this.value){
                this.value = Number(toInt(this.value)).toLocaleString('en', options);
                document.querySelector('#item-req-con-total').innerHTML = computeTotal();
            }
            else{
                return Number(toInt(num)).toLocaleString('en', options);
            }
        }

        let createElement = function (el, className, innerHTML) {
            let element = document.createElement(el);
            if(className)
            element.className = className;
            if (innerHTML)
            element.innerHTML = innerHTML;
            return element;
        }
        const totalEl = createElement('span', "font-weight-bold");
        let subPAPname = createElement('span', 'font-weight-bold');
        subPAPname.innerHTML = subpapdata.name;
        const ul_header_tr = createElement("tr", "header");
        const ul_header = createElement("thead", "header");
        ul_header.append(ul_header_tr);
        const mainDiv = createElement("tbody", "");
        const subpap_header_tr = createElement('tr', "cell");
            
        let SubPapApi = (function () {
            function SubPapApi(source_id, data, cell) {
                this.data = data;
                this.source_id = source_id;
                this.cell = cell;
            }
            SubPapApi.prototype.getData = function () {
                return {
                    item_account_code: this.data.item_account_code,
                    item_account_code_id: this.data.item_account_code_id,
                    item_requirement: this.data.item_requirement,
                    item_procurement_mode: this.data.item_procurement_mode,
                    item_unit: this.data.item_unit,
                    item_cost: toInt(this.data.item_cost),
                    item_qty_pax: toInt(this.data.item_qty_pax),
                    item_days: toInt(this.data.item_days),
                    item_months: this.data.item_months,
                }
            }
            SubPapApi.prototype.getTotal = function () {
                return this.data.total.innerHTML;
            }
            SubPapApi.prototype.update = function (data) {
                for (const key in data) {
                    this.data[key] = data[key];
                }
            }
            SubPapApi.prototype.remove = function () {
                this.cell.remove();
                delete contents[this.source_id];
            }
            return SubPapApi;
        }());
        let generateCell = function (ul_cell, 
            classes = ["code-width", "item-req-width", "procurement-width", "unit-width", "cost-width", "quantity-width", "num-days-width", "total-width"]
        ) {
            for (let i = 0; i < classes.length; i++) {
                let li = createElement('td', classes[i]);
                ul_cell.append(li);
            }
            for (let i = 0; i < 12; i++) {
                let li = createElement('td');
                ul_cell.append(li);
            }
        }
        let generateHeaders = function () {
            generateCell(ul_header_tr);
            const data = [
                "Code/No.",
                "Item Requirements",
                "Procurement Mode",
                "Unit",
                "Per Capita Cost",
                "Qty/Pax",
                "No. of Days",
                "Total",
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ];
            const cells = ul_header_tr.children;
            for (let i = 0; i < data.length; i++) {
                if (data[i] != undefined) {
                    cells[i].append(data[i]);
                }
            }
        }
        let generateSubpapHeader = function () {
            generateCell(subpap_header_tr,
                classes = ["code-width", "item-req-width", "total-width"]
            );
            const cells = subpap_header_tr.children;
            const select = createElement('select', "");
            const val = [
                SUB_PAP_CODE,
                subPAPname,
                totalEl,
            ];
            for (let i = 0; i < cells.length; i++) {
                if (val[i]) {
                    cells[i].append(val[i]);
                }
            }
            cells[1].colSpan="6";
            mainDiv.appendChild(subpap_header_tr);
        }
        let generateTotal = function () {
            ul_total = createElement("tfoot", "header");
            let ul_total_tr = createElement("tr", "header");
            ul_total.append(ul_total_tr);
            generateCell(ul_total_tr);
            totalSupPap = createElement('span', "", "-");
            const data = [
                "",
                "Total",
                "",
                "",
                "",
                "",
                "",
                totalSupPap,
            ];
            const cells = ul_total_tr.children;
            for (let i = 0; i < data.length; i++) {
                if (data[i] != undefined) {
                    cells[i].append(data[i]);
                }
            }
            for (let i = monthStartIndex; i < (monthStartIndex + 12); i++) {
                let span = createElement('span', 'text-center');
                span.id='month-total-'+((i-monthStartIndex)+1);
                cells[i].append(span);
            }
            container.appendChild(ul_total)
        }
        function computeSubPapTotal() {
            let sum = 0;
            for (const key in contents) {
                let a = parseFloat(contents[key].getTotal().replace(/,/g, ''));
                sum += parseInt(a) || 0;
            }
            if (!isNaN(sum)) {
                totalEl.innerHTML = Number(sum).toLocaleString('en', options);
            }
            computeSubPapTotalTotalan();
        }
        function generateSubPapContent(data, tr) {
            const ul_cell = createElement('tr', "cell");
            generateCell(ul_cell);

            let total = createElement('span', '', data.item_total);
            let prev_item_months = [...data.item_months];

            let setData = function(data, forUpdate=false){
                let cellData = [
                    data.item_account_code,
                    data.item_requirement,
                    data.item_procurement_mode_text,
                    data.item_unit,
                    formatter(data.item_cost),
                    data.item_qty_pax,
                    data.item_days,
                    total,
                    '',
                ];
                let cells = ul_cell.children;
                for (let i = 0; i < cells.length; i++) {
                    cells[i].innerHTML="";
                    if (cellData[i]) {
                        cells[i].append(cellData[i]);
                    }
                }
                for (let index = 0; index < 12; index++) {
                    cells[index + monthStartIndex].style='';
                }
                if(forUpdate){
                    console.log("prev_item_months",prev_item_months);
                    console.log("current",data.item_months);
                    for (let index = 0; index < prev_item_months.length; index++) {
                        const element = prev_item_months[index];
                        addMonthTotal((element.month), toInt(element.amount), true);
                    }
                }
                for (let index = 0; index < data.item_months.length; index++) {
                    const element = data.item_months[index];
                    let val = formatter(element.amount);
                    let div = createElement('div', 'text-center');
                    div.appendChild(createElement('div', '', element.qty+' - '+subpapdata.target_name+', '+val));
                    cells[(element.month-1) + monthStartIndex].append(div);
                    cells[(element.month-1) + monthStartIndex].style.backgroundColor="#FFFF00";
                    cells[(element.month-1) + monthStartIndex].style.maxWidth="7rem";
                    addMonthTotal((element.month), toInt(val));
                }
            }
            setData(data);

            if(tr){
                mainDiv.insertBefore(ul_cell, tr)
            }
            else{
                mainDiv.appendChild(ul_cell);
            }
            data['total'] = total;
            const subPapApi = new SubPapApi(contents_source_id, data, ul_cell);
            contents[contents_source_id] = subPapApi;
            contents_source_id++;
            computeSubPapTotal();
        }
        function computeTotal(qty, cost, days) {
            let c,q,d;
            if(qty || cost || days){
                c = toInt(cost) || 1;
                q = toInt(qty) || 1;
                d = toInt(days) || 1;
            }
            else{
                if(item_cost.value==""&&item_qty_pax.value==""&&item_days.value==""){return 0}
                c = toInt(item_cost.value) || 1;
                q = toInt(item_qty_pax.value) || 1;
                d = toInt(item_days.value) || 1;
            }
            let t = c * q * d;
            if (!isNaN(t)) {
                return Number(t).toLocaleString('en', options);;
            }
        }
        function addMonthTotal(m, a, subtract = false){
            console.log(m, a);
            console.log('month-total-'+m);
            let totalMonth = container.querySelector('#month-total-'+m);
            let aa = toInt(totalMonth.innerHTML);
            let val = 0;
            if(subtract){
                val = aa - a;
            }
            else{
                val = aa + a;
            }

            if(val <= 0){
                totalMonth.innerHTML = "";
            }
            else{
                totalMonth.innerHTML = formatter(val);
            }

            if(!subpap_months_added_count[m]){
                subpap_months_added_count[m] = 0;
            }

            if(subtract){
                subpap_months_added_count[m]--;
                let td = subpap_header_tr.children[(monthStartIndex - 5) + (toInt(m) - 1)];
                subpap_months_added[m] -= a;
                if(subpap_months_added[m] == 0){
                    delete subpap_months_added[m];
                    td.style='';
                    td.innerHTML='';
                }
                else{
                    td.innerHTML = formatter(subpap_months_added[m]);
                }
                // if(subpap_months_added_count[m] == 1){
                // 	td.style='';
                // 	td.innerHTML='';
                // }
            }
            else{
                let td = subpap_header_tr.children[(monthStartIndex - 5) + (toInt(m) - 1)];
                subpap_months_added_count[m]++;
                if(subpap_months_added[m]){
                    subpap_months_added[m] += a;
                }
                else{
                    // td.style.backgroundColor='#FFFF00';
                    td.style.fontWeight='600';
                    subpap_months_added[m] = a;
                }
                td.innerHTML = formatter(subpap_months_added[m]);
            }
        }
        this.getData = function () {
            let item_req_data = [];
            for (const key in contents) {
                item_req_data.push(contents[key].getData());
            }
            return {
                sub_pap_name: subpapdata.name,
                item_reqs: item_req_data,
                subpap_quarter_target: subpapdata.subpap_quarter_target,
            };
        }
        this.getTotal = function () {
            return parseFloat(totalEl.innerHTML.replace(/,/g, ''))
        }
        this.addItemRequirement=function(item_requirements){
            for (let i = 0; i < item_requirements.length; i++) {
                let item = item_requirements[i];
                let data = {
                    item_account_code: item.chart_of_account.code+"-"+item.chart_of_account.expense_object,
                    item_account_code_id: item.chart_of_account.id,
                    item_requirement: item.itemreq_txt || item.suggested_item_requirement.ireq,
                    item_procurement_mode: item.procurement_mode_id,
                    item_procurement_mode_text: item.procurement_mode.title,
                    item_unit: item.unit || item.suggested_unit.unit,
                    item_cost: formatter(item.per_capita_cost),
                    item_qty_pax: item.qty_pax,
                    item_days: item.no_of_days,
                    item_total: 0,
                    item_months: item.item_months,
                }
                data.item_total = computeTotal(data.item_qty_pax, data.item_cost, data.item_days);
                generateSubPapContent(data);
            }
        }
        if (Object.keys(subpaps).length == 0) {
            container.appendChild(ul_header);
            generateHeaders();
            generateTotal();
        }
        generateSubpapHeader();
        container.insertBefore(mainDiv, ul_total);
    }
    function computeSubPapTotalTotalan() {
        let total = 0;
        for (const key in subpaps) {
            const subpap = subpaps[key];
            if (!isNaN(subpap.getTotal())) {
                total += subpap.getTotal();
            }
            if (!isNaN(total)) {
                totalSupPap.innerHTML = Number(toFloat(total)).toLocaleString('en', options);
                // document.querySelector('#total-pap-budget').innerHTML = Number(total).toLocaleString('en', options);
            }
        }	
        if (!isNaN(total)) {
            return total;
        }
        return 0;
    }
    function toCommaSeparated(arr, key){
        let data = [];
        for (let i = 0; i < arr.length; i++) {
            data.push(eval('arr[i].'+key));
        }
        return data.join(',');
    }
    function appendPapData() {
        let tbody = createElement('tbody');
        let tr1 = createElement('tr');
        let papname = createElement('td', '', papdata.pap_txt || papdata.suggested_pap.paps);
        let totalbudget = createElement('td', '', 'Total Budget: '+Number(toFloat(papdata.total)).toLocaleString('en', options));
        papname.colSpan="3";
        totalbudget.colSpan="3";
        tr1.appendChild(papname);
        tr1.appendChild(totalbudget);

        let tr2 = createElement('tr');
        let mfo = createElement('td', '', 'MFO: '+papdata.mfo.desc);
        let kdp = createElement('td', '', 'KDP: '+papdata.kdp.desc);
        mfo.colSpan="3";
        kdp.colSpan="3";
        tr2.appendChild(mfo);
        tr2.appendChild(kdp);

        let tr3 = createElement('tr');
        let form_related = createElement('td', '', 'KDP: '+toCommaSeparated(papdata.poe_tags, 'pap_tag.tag'));
        let target_sector = createElement('td', '', 'KDP: '+toCommaSeparated(papdata.target_sectors, 'target_sector.sector'));
        let geolocation = createElement('td', '', 'KDP: '+papdata.geolocation);
        form_related.colSpan="2";
        target_sector.colSpan="2";
        geolocation.colSpan="2";
        tr3.appendChild(form_related);
        tr3.appendChild(target_sector);
        tr3.appendChild(geolocation);

        let tr4 = createElement('tr');
        let category = createElement('td', '', 'Category Code: '+papdata.category.category);
        let thematic = createElement('td', '', 'Thematic Areas/Clusters: '+papdata.thematic_area_cluster.thematic_area_cluster);
        let service_region = createElement('td', '', 'Service Region: '+papdata.service_region.service_region);
        category.colSpan="2";
        thematic.colSpan="2";
        service_region.colSpan="2";
        tr4.appendChild(category);
        tr4.appendChild(thematic);
        tr4.appendChild(service_region);

        tbody.appendChild(tr1);
        tbody.appendChild(createElement('tr'));
        tbody.appendChild(tr2);
        tbody.appendChild(createElement('tr'));
        tbody.appendChild(tr3);
        tbody.appendChild(createElement('tr'));
        tbody.appendChild(tr4);
        tbody.appendChild(createElement('tr'));
        tbody.appendChild(createElement('tr'));
        container.appendChild(tbody);
    }
    getSubpaps(poe_id, function(res){
        // console.log("subpaps",res);
        for (let i = 0; i < res.length; i++) {
            let subpap = new SubPap({
                name: res[i].subpap_txt || res[i].suggested_sub_pap.subpaps,
                subpap_quarter_target: res[i].quarter_target_id,
                target_name: res[i].quarter_target.quarter_target,
            });
            subpaps[source_id] = subpap;
            source_id++;
            subpap.addItemRequirement(res[i].item_requirements);
        }
        exportToExcel(container, (papdata.pap_txt || papdata.suggested_pap.paps), callback);
    });
    
}
function exportToExcel(table_elt, filename, callback) {
    const l = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];

    // Extract Data (create a workbook object from the table)
    var workbook = XLSX.utils.table_to_book(table_elt, {raw:true});
    
    // Process Data (add a new row)
    var ws = workbook.Sheets["Sheet1"];
    console.log("ws", ws);

    //add style to headers
    for (let j = 0; j < l.length; j++) {
        let key = l[j]+10;
        if (Object.hasOwnProperty.call(ws, key)) {
            ws[key].s = {
                font: {
                    name: "Calibri",
                    sz: 12,
                    bold: true,
                    // color: { rgb: "FFFFAA00" },
                },
                border: {
                    top: {
                        style: 'medium',
                        color: 'FFFFAA00',
                    },
                    right: {
                        style: 'medium',
                        color: 'FFFFAA00',
                    },
                    left: {
                        style: 'medium',
                        color: 'FFFFAA00',
                    },
                    bottom: {
                        style: 'medium',
                        color: 'FFFFAA00',
                    },
                },
            }
        }
    }
    for (let j = 0; j < l.length; j++) {
        let num = 11;
        while(true){
            let key = l[j]+ num;
            if (Object.hasOwnProperty.call(ws, key)) {
                ws[key].s = {
                    alignment: {
                        wrapText: true,
                        vertical: 'center',
                    }
                }
            }
            else{
                break;
            }
            num++;
        }
    }

    let wscols = [
        {wch:20},
        {wch:35},
        {wch:30},
        {wch:40},
        {wch:20},
        {wch:10},
        {wch:10},
        {wch:10},
        {wch:10},
        {wch:10},
        {wch:10},
        {wch:10},
        {wch:10},
        {wch:15},
        {wch:15},
        {wch:15},
        {wch:15},
        {wch:15},
        {wch:15},
        {wch:15},
    ];
    ws['!cols'] = wscols;
    
    XLSX.writeFile(workbook, filename+".xlsx");
    callback ? callback():null;
    return;
}
function ButtonLinks(opts){
    let createElement = function (el, className, innerHTML) {
        let element = document.createElement(el);
        if(className)
        element.className = className;
        if (innerHTML)
        element.innerHTML = innerHTML;
        return element;
    }
    let container = document.querySelector(opts.el);
    let eventListeners={};
    

    this.generateLinks=function(links){
        let ul = createElement('ul', 'pagination float-right p-3');
        let clearActive=function(){
            for (let i = 0; i < ul.children.length; i++) {
                const element = ul.children[i];
                // element.classList.remove('active');
                element.firstChild.style="";
            }
        }
        for (let i = 0; i < links.length; i++) {
            const element = links[i];
            let li =  createElement('li', 'page-item');

            let a = createElement('a', 'page-link', element.label);
            if(element.active){
                a.style="background:yellow";
            }
            // a.href = element.url;
            li.appendChild(a);
            ul.appendChild(li);
            a.onclick=function(){
                renderEvent('click', element.url);
            }
        }
        container.innerHTML="";
        container.appendChild(ul);
        container.className="col justify-content-end p-3";
    }
    this.hide=function(){
        if(container){
            container.className="d-none";
        }
    }
    this.on=function(e,f){
        eventListeners[e]=f;
    }
    function renderEvent(e, params){
        if(eventListeners[e]){
            eventListeners[e](params);
        }
    }
}
function toFloat(num){
    num = num.toString();
    num = num.replace(/,/g, '');
    num = num.replace(/[a-z]/gi, '');
    num = parseFloat(num) || 0;
    return num;
}
function formatter(num){
    const options = {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    };
    if(this.value){
        this.value = Number(toFloat(this.value)).toLocaleString('en', options);
        document.querySelector('#item-req-con-total').innerHTML = computeTotal();
    }
    else{
        return Number(toFloat(num)).toLocaleString('en', options);
    }
}
function exportPoePDF(data, callback){
    var doc = new jsPDF('l', 'pt', [1920, 1080]);
    // doc.text('TEst', (doc.internal.pageSize.getWidth() / 2), 50, null, null, 'center');
    doc.text('TEst', (doc.internal.pageSize.getWidth() / 2), 50, {align: 'center'});
    // doc.text('TEst', null, 50, {align: 'center'});
    let body = []
    let head = [[]];

    let head_labels = [
        "CODE/NO.",	
        "ITEM REQUIREMENTS",	
        "PROCUREMENT MODE",	
        "UNIT",	
        "PER CAPITA COST",	
        "QTY/PAX",	
        "NO. OF DAYS",	
        "TOTAL",	
        "JAN",	
        "FEB",	
        "MAR",	
        "APR",	
        "MAY",	
        "JUN",	
        "JUL",	
        "AUG",	
        "SEP",	
        "OCT",	
        "NOV",	
        "DEC",
    ];
    for (let i = 0; i < head_labels.length; i++) {
        head[0].push({
            content: head_labels[i],
            // styles: { valign: 'middle', halign: 'center', lineWidth: 1},
        });
    }
    console.log(doc);
    let height= 0;
    // doc.table(10, 100)
    doc.autoTable({
        startY: 60,
        tableWidth: 1920,
        body: [
            [
                {
                    content: "Pap: " + (data.pap_txt || data.suggested_pap.paps),
                },
                {
                    content: "Budget: " + data.total,
                    colSpan: 2,
                },
            ],
            [
                {
                    content: "MFO: " + data.mfo.desc,
                },
                {
                    content: "KDP: " + data.kdp.desc,
                    colSpan: 2,
                },
            ],
            [
                {
                    content: "Form Related: " + Object.keys(data.poe_tags).map(function(k){return data.poe_tags[k].pap_tag.tag}).join(","),
                },
                {
                    content: "Target Sector: " + Object.keys(data.target_sectors).map(function(k){return data.target_sectors[k].target_sector.sector}).join(","),
                },
                {
                    content: "Georaphical Location: " + data.geolocation,
                },
            ],
            [
                {
                    content: "Category Code: " + data.category.category,
                },
                {
                    content: "Thematic Areas/Clusters: " + data.thematic_area_cluster.thematic_area_cluster,
                },
                {
                    content: "Service Region: " + data.service_region.accronym,
                },
            ],
        ],
        theme: 'plain',
        showHead: 'never',
        willDrawCell: function(data){
            console.log("data",data);
            data.cell.styles.fontStyle='bold';
            if(((data.row.index + 1) % 2) != 0){
                //label
                data.cell.styles.textColor='#808080';
                data.cell.styles.fontSize=7;
            }
        },
        didDrawPage: function(data) {
            console.log(data);
            height = data.cursor.y || 0;
        }
    })
    let month_total = {}
    let add_month_total=function(obj, amount, month){
        if(!obj[month]){
            obj[month]=0;
        }
        obj[month] += toFloat(amount);
    }
    getSubpaps(data.id, function(res){
        console.log("subpaps",res);
        let SUB_PAP_CODE = 1;
        for (let i = 0; i < res.length; i++) {
            const subpap = res[i];
            let subpap_month_total = {}
            let subpap_total = 0;
            let item_req_rows = [];
            let subpap_row =[
                {
                    content: "SUBPAP "+SUB_PAP_CODE,
                },
                {
                    content: subpap.subpap_txt || subpap.suggested_sub_pap.subpaps,
                    colSpan: 6,
                    styles: { fontStyle: 'bold'},
                },
                {
                    content: formatter(subpap_total),
                    styles: { halign: 'center', valign: "middle", fontStyle: 'bold' },
                }
            ]
            body.push(subpap_row);
            
            for (let x = 0; x < subpap.item_requirements.length; x++) {
                const item_requirement = subpap.item_requirements[x];
                subpap_total += toFloat(item_requirement.total);
                let item_req_row = [
                    {
                        content: item_requirement.chart_of_account.code+" - "+item_requirement.chart_of_account.expense_object,
                    },
                    {
                        content: item_requirement.itemreq_txt || item_requirement.suggested_item_requirement.ireq,
                    },
                    {
                        content: item_requirement.procurement_mode.title,
                    },
                    {
                        content: item_requirement.unit || item_requirement.suggested_unit.unit,
                    },
                    {
                        content: formatter(item_requirement.per_capita_cost),
                        styles: { halign: 'center', valign: "middle" }
                    },
                    {
                        content: item_requirement.qty_pax,
                        styles: { halign: 'center', valign: "middle" }
                    },
                    {
                        content: item_requirement.no_of_days,
                        styles: { halign: 'center', valign: "middle" }
                    },
                    {
                        content: item_requirement.total,
                        styles: { halign: 'center', valign: "middle" }
                    },
                ];
                let item_req_month = {}
                for (let j = 0; j < item_requirement.item_months.length; j++) {
                    const item_month = item_requirement.item_months[j];
                    add_month_total(subpap_month_total, item_month.amount, item_month.month);
                    add_month_total(month_total, item_month.amount, item_month.month);
                    if(!item_req_month[item_month.month]){
                        item_req_month[item_month.month] = "";
                    }
                    item_req_month[item_month.month] += "\n"+item_month.qty+" "+subpap.quarter_target.quarter_target+"\n"+formatter(item_month.amount);
                }
                for (let x = 1; x <= 12; x++) {
                    item_req_row.push(
                        {
                            content: item_req_month[x] || "",
                            styles: { halign: 'center', valign: "middle"}
                        },
                    );
                    if(item_req_month[x]){
                        item_req_row[item_req_row.length - 1].styles.fillColor = '#ffff3d';
                    }
                }
                body.push(item_req_row);
            }
            for (let x = 1; x <= 12; x++) {
                subpap_row.push({
                    content: subpap_month_total[x] ? formatter(subpap_month_total[x]) : "",
                    styles: { halign: 'center', valign: "middle", fontStyle: 'bold' },
                });
            }
            subpap_row[2].content=formatter(subpap_total);

            SUB_PAP_CODE++;
        }
        let total_row = [
            {
                content: "",
            },
            {
                content: "Total",
                colSpan: 6,
                styles: { fontStyle: 'bold'},
            },
            {
                content: formatter(data.total),
                styles: { halign: 'center', valign: "middle", fontStyle: 'bold' },
            }
        ];
        for (let x = 1; x <= 12; x++) {
            total_row.push({
                content: month_total[x] ? formatter(month_total[x]) : "",
                styles: { halign: 'center', valign: "middle", fontStyle: 'bold' },
            });
        }
        body.push(total_row);

        doc.autoTable({
            startY: height + 20,
            head: head,
            body: body,
            theme: 'striped',
            headStyles: {
                fillColor: [28, 32, 171],
                valign: 'middle', 
                halign: 'center', 
                lineWidth: 1
            },
        })
        doc.save((data.pap_txt || data.suggested_pap.paps)+'.pdf');
        callback ? callback():null;
    });

    
}
function exportPpmpPDF(data, callback){
    const poe_id = data.poe_id;
    data = data.poe;
    console.log("data",data);
    var doc = new jsPDF('l', 'pt', [3920, 1080]);
    // doc.text('TEst', (doc.internal.pageSize.getWidth() / 2), 50, null, null, 'center');
    doc.text('TEst', (doc.internal.pageSize.getWidth() / 2), 50, {align: 'center'});
    // doc.text('TEst', null, 50, {align: 'center'});
    let body = []
    let head = [[]];

    let head_labels = [
        "CODE/NO.",	
        "GENERAL DESCRIPTION",	
        "QUANTITY/SIZE",	
        "ESTIMATED BUDGET",	
        "PROCUREMENT MODE",	
        "JAN",	
        "FEB",	
        "MAR",	
        "APR",	
        "MAY",	
        "JUN",	
        "JUL",	
        "AUG",	
        "SEP",	
        "OCT",	
        "NOV",	
        "DEC",
    ];
    for (let i = 0; i < head_labels.length; i++) {
        head[0].push({
            content: head_labels[i],
            // styles: { valign: 'middle', halign: 'center', lineWidth: 1},
        });
    }
    console.log(doc);
    let height= 0;
    // doc.table(10, 100)
    doc.autoTable({
        startY: 60,
        tableWidth: 2500,
        body: [
            [
                {
                    content: "Pap: " + (data.pap_txt || data.suggested_pap.paps),
                },
                {
                    content: "Budget: " + data.total,
                    colSpan: 2,
                },
            ],
            [
                {
                    content: "MFO: " + data.mfo.desc,
                },
                {
                    content: "KDP: " + data.kdp.desc,
                    colSpan: 2,
                },
            ],
            [
                {
                    content: "Form Related: " + Object.keys(data.poe_tags).map(function(k){return data.poe_tags[k].pap_tag.tag}).join(","),
                },
                {
                    content: "Target Sector: " + Object.keys(data.target_sectors).map(function(k){return data.target_sectors[k].target_sector.sector}).join(","),
                },
                {
                    content: "Georaphical Location: " + data.geolocation,
                },
            ],
            [
                {
                    content: "Category Code: " + data.category.category,
                },
                {
                    content: "Thematic Areas/Clusters: " + data.thematic_area_cluster.thematic_area_cluster,
                },
                {
                    content: "Service Region: " + data.service_region.accronym,
                },
            ],
        ],
        theme: 'plain',
        showHead: 'never',
        willDrawCell: function(data){
            data.cell.styles.fontStyle='bold';
            if(((data.row.index + 1) % 2) != 0){
                //label
                data.cell.styles.textColor='#808080';
                data.cell.styles.fontSize=7;
            }
        },
        didDrawPage: function(data) {
            console.log(data);
            height = data.cursor.y || 0;
        }
    })
    let month_total = {}
    let add_month_total=function(obj, amount, month){
        if(!obj[month]){
            obj[month]=0;
        }
        obj[month] += toFloat(amount);
    }
    getSubpaps(poe_id, function(res){
        console.log("res",res);
        let SUB_PAP_CODE = 1;
        for (let i = 0; i < res.length; i++) {
            const subpap = res[i];
            let subpap_month_total = {}
            let subpap_total = 0;
            let item_req_rows = [];
            let subpap_row =[
                {
                    content: "SUBPAP "+SUB_PAP_CODE,
                },
                {
                    content: subpap.subpap_txt || subpap.suggested_sub_pap.subpaps,
                    colSpan: 2,
                    styles: { fontStyle: 'bold'},
                },
                {
                    content: formatter(subpap_total),
                    styles: { halign: 'center', valign: "middle", fontStyle: 'bold' },
                },
                {
                    content: '',
                },
            ]
            body.push(subpap_row);
            
            for (let x = 0; x < subpap.item_requirements.length; x++) {
                const item_requirement = subpap.item_requirements[x];
                subpap_total += toFloat(item_requirement.total);
                let item_req_row = [
                    {
                        content: item_requirement.chart_of_account.code+" - "+item_requirement.chart_of_account.expense_object,
                    },
                    {
                        content: item_requirement.itemreq_txt || item_requirement.suggested_item_requirement.ireq,
                    },
                    {
                        content: item_requirement.qty_pax+" "+item_requirement.unit+" x "+item_requirement.no_of_days+" day(s)",
                        styles: { halign: 'center', valign: "middle" }
                    },
                    {
                        content: item_requirement.total,
                        styles: { halign: 'center', valign: "middle" }
                    },
                    {
                        content: item_requirement.procurement_mode.title,
                        styles: { halign: 'center', valign: "middle" }
                    },
                ];
                let item_req_month = {}
                for (let j = 0; j < item_requirement.item_months.length; j++) {
                    const item_month = item_requirement.item_months[j];
                    add_month_total(subpap_month_total, item_month.amount, item_month.month);
                    add_month_total(month_total, item_month.amount, item_month.month);
                    if(!item_req_month[item_month.month]){
                        item_req_month[item_month.month] = "";
                    }
                    item_req_month[item_month.month] += "\n"+item_month.qty+" "+subpap.quarter_target.quarter_target+"\n"+formatter(item_month.amount);
                }
                for (let x = 1; x <= 12; x++) {
                    item_req_row.push(
                        {
                            content: item_req_month[x] || "",
                            styles: { halign: 'center', valign: "middle"}
                        },
                    );
                    if(item_req_month[x]){
                        item_req_row[item_req_row.length - 1].styles.fillColor = '#ffff3d';
                    }
                }
                body.push(item_req_row);
            }
            for (let x = 1; x <= 12; x++) {
                subpap_row.push({
                    content: subpap_month_total[x] ? formatter(subpap_month_total[x]) : "",
                    styles: { halign: 'center', valign: "middle", fontStyle: 'bold' },
                });
            }
            subpap_row[2].content=formatter(subpap_total);

            SUB_PAP_CODE++;
        }
        let total_row = [
            {
                content: "",
            },
            {
                content: "Total",
                colSpan: 2,
                styles: { fontStyle: 'bold'},
            },
            {
                content: formatter(data.total),
                styles: { halign: 'center', valign: "middle", fontStyle: 'bold' },
            }
        ];
        for (let x = 1; x <= 12; x++) {
            total_row.push({
                content: month_total[x] ? formatter(month_total[x]) : "",
                styles: { halign: 'center', valign: "middle", fontStyle: 'bold' },
            });
        }
        body.push(total_row);

        doc.autoTable({
            startY: height + 20,
            head: head,
            body: body,
            theme: 'striped',
            headStyles: {
                fillColor: [28, 32, 171],
                valign: 'middle', 
                halign: 'center', 
                lineWidth: 1
            },
        })
        doc.save((data.pap_txt || data.suggested_pap.paps)+'.pdf');
        callback ? callback():null;
    });

    
}
function exportBudgetReportToPDF(params, callback){
    let exportPDF = function(data){
        console.log("data",data);

        // data = data.form_ppmp;
        var doc = new jsPDF('l', 'pt', [3920, 1080]);
        const title = `CY-${params.year} ANNUAL PLANS AND BUDGET ${params.funded_status == "0" ? " (UNFUNDED)":" (FUNDED)"}`;
        doc.text(title, (doc.internal.pageSize.getWidth() / 2), 50, {align: 'center'});
        let body = []
    
        let head = [
            [
                {
                    content: "P/A/P",
                    rowSpan: 2,
                },
                {
                    content: "SUB P/A/P",
                    rowSpan: 2,
                },
                {
                    content: "ITEM REQUIREMENTS",
                    rowSpan: 2,
                },
                {
                    content: "EXPENSE OBJECT",
                    rowSpan: 2,
                },
                {
                    content: "ACCOUNT CODE",
                    rowSpan: 2,
                },
                {
                    content: "APB",
                    colSpan: 12,
                },
                {
                    content: "TOTAL",
                    rowSpan: 2,
                },
            ],
            [									
                {
                    content: "JANUARY",
                },
                {
                    content: "FEBRUARY",
                },
                {
                    content: "MARCH",
                },
                {
                    content: "APRIL",
                },
                {
                    content: "MAY",
                },
                {
                    content: "JUNE",
                },
                {
                    content: "JULY",
                },
                {
                    content: "AUGUST",
                },
                {
                    content: "SEPTEMBER",
                },
                {
                    content: "OCTOBER",
                },
                {
                    content: "NOVEMBER",
                },
                {
                    content: "DECEMBER",
                },
            ],
            [
                {
                    content: "(A)",
                },
                {
                    content: "(B)",
                },
                {
                    content: "(C)",
                },
                {
                    content: "(D)",
                },
                {
                    content: "(E)",
                },
                {
                    content: "(F)",
                },
                {
                    content: "(G)",
                },
                {
                    content: "(H)",
                },
                {
                    content: "(I)",
                },
                {
                    content: "(J)",
                },
                {
                    content: "(K)",
                },
                {
                    content: "(L)",
                },
                {
                    content: "(M)",
                },
                {
                    content: "(N)",
                },
                {
                    content: "(O)",
                },
                {
                    content: "(P)",
                },
                {
                    content: "(Q)",
                },
                {
                    content: "(R = F + G + H + I + J + K + L + M + N + O + P + Q )",
                },
            ]
        ];
        
        let month_total = {}
        let add_month_total=function(obj, amount, month){
            if(!obj[month]){
                obj[month]=0;
            }
            obj[month] += toFloat(amount);
        }

        //ppmp with fund chargeability id as key
        for (const key in data.form_ppmp) {
            const ppmps = data.form_ppmp[key];
            console.log("ppmps", ppmps);
            // fund chargeability row
            body.push([
                {
                    content: data.fund_chargeability[key].type,
                    styles: {valign: 'middle', halign: 'center', fillColor: "#ef8d42", textColor: "#ffffff"},
                    colSpan: 18,
                }
            ]);


            //array of ppmp with poe
            for (let a = 0; a < ppmps.length; a++) {
                const ppmp = ppmps[a];
                let ppmp_per_month_total = {};
                let ppmp_sub_total = 0;
                // loop subpap
                for (let b = 0; b < ppmp.poe.subpap.length; b++) {
                    const subpap = ppmp.poe.subpap[b];
                    
                    // loop item requirements
                    for (let c = 0; c < subpap.item_requirements.length; c++) {
                        const item_requirement = subpap.item_requirements[c];
                        let ppmp_row = [];
                        ppmp_row.push(
                            {
                                content: b==0 && c==0 ? (ppmp.poe.pap_txt || ppmp.poe.suggested_pap.paps):"",
                            },
                            {
                                content: c==0 ? (subpap.subpap_txt || subpap.suggested_sub_pap.subpaps):"",
                            },
                            {
                                content: item_requirement.itemreq_txt || item_requirement.suggested_item_requirement.ireq,
                            },
                            {
                                content: item_requirement.chart_of_account.expense_object,
                            },
                            {
                                content: item_requirement.chart_of_account.code,
                            },
                        );
                        let item_req_month = {}
                        let item_req_total = 0;
                        for (let j = 0; j < item_requirement.item_months.length; j++) {
                            const item_month = item_requirement.item_months[j];
                            add_month_total(month_total, item_month.amount, item_month.month);
                            add_month_total(ppmp_per_month_total, item_month.amount, item_month.month);
                            if(!item_req_month[item_month.month]){
                                item_req_month[item_month.month] = 0;
                            }
                            item_req_total += parseFloat(item_month.amount);
                            ppmp_sub_total += parseFloat(item_month.amount);
                            item_req_month[item_month.month] += parseFloat(item_month.amount);
                        }
                        for (let d = 1; d <= 12; d++) {
                            ppmp_row.push(
                                {
                                    content: item_req_month[d] ? formatter(item_req_month[d]):"",
                                },
                            );
                        }
                        ppmp_row.push(
                            {
                                content: formatter(item_req_total),
                            },
                        );
                        body.push(ppmp_row);
                    }
                }

                //ppmp subtotal row
                let sub_total_row = [];
                sub_total_row.push(
                    {
                        content: 'Sub Total',
                        colSpan: 5,
                        styles: {fillColor: "#404396", textColor: "#ffffff"},
                    },
                );
                for (let d = 1; d <= 12; d++) {
                    sub_total_row.push(
                        {
                            content: ppmp_per_month_total[d] ? formatter(ppmp_per_month_total[d]):"",
                            styles: {fillColor: "#404396", textColor: "#ffffff"},
                        },
                    );
                }
                sub_total_row.push(
                    {
                        content: formatter(ppmp_sub_total),
                        styles: {fillColor: "#404396", textColor: "#ffffff"},
                    },
                );
                body.push(sub_total_row);
            }
        }
        //grand total row
        let grand_total_row = [];
        let grand_total = 0;
        grand_total_row.push(
            {
                content: 'Grand Total',
                colSpan: 5,
                styles: {fillColor: "#1c20ab", textColor: "#ffffff"},
            },
        );
        for (let d = 1; d <= 12; d++) {
            grand_total += month_total[d] ? month_total[d]:0;
            grand_total_row.push(
                {
                    content: month_total[d] ? formatter(month_total[d]):"",
                    styles: {fillColor: "#1c20ab", textColor: "#ffffff"},
                },
            );
        }
        grand_total_row.push(
            {
                content: formatter(grand_total),
                styles: {fillColor: "#1c20ab", textColor: "#ffffff"},
            },
        );
        body.push(grand_total_row);

        doc.autoTable({
            startY: 60,
            head: head,
            body: body,
            theme: 'striped',
            headStyles: {
                fillColor: '#ffffff',
                valign: 'middle', 
                halign: 'center', 
                lineWidth: 1,
                textColor: '#000000',
            },
            bodyStyles: {
                cellPadding: 10,
            },
        })
        doc.save(title+'.pdf');
        callback ? callback():null;
    }
    new HttpRequest({
        url: "/reports/budget/funded/data",
        data: params,
        done: function(res){
            console.log("res",res);
            exportPDF(res);
        }
    });
}
function exportBudgetReportToExcel(params, callback){
    const title = `CY-${params.year} ANNUAL PLANS AND BUDGET ${params.funded_status == "0" ? " (UNFUNDED)":" (FUNDED)"}`;
    new HttpRequest({
        url: "/reports/table/budget-unfunded",
        data: params,
        dataType:"text",
        done: function(res){
            console.log("res",res);
            let div = document.createElement('div');
            div.innerHTML=res;

            table_elt = div.querySelector('table');
            console.log(table_elt);
            // Extract Data (create a workbook object from the table)
            var workbook = XLSX.utils.table_to_book(table_elt);
            
            // Process Data (add a new row)
            var ws = workbook.Sheets["Sheet1"];

            //Wrap all cell nad center vertically
            for (const key in ws) {
                if(!key.includes("!")){
                    ws[key].s = {
                        alignment: {
                            wrapText: true,
                            vertical: 'center',
                        }
                    }
                }
            }


            const header_cell = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R"];
            //add style to headers
            for (let j = 0; j < header_cell.length; j++) {
                for (let i = 2; i <= 4; i++) {
                    let key = header_cell[j] + i;
                    if(!ws[key]){
                        ws[key]={
                            s: "",
                            t: "s",
                            v: ""
                        }
                    }
                    ws[key].t = "s";
                    ws[key].s = {
                        alignment: {
                            wrapText: true,
                            vertical: 'center',
                        },
                        font: {
                            name: "Calibri",
                            sz: 12,
                            bold: true,
                            // color: { rgb: "FFFFAA00" },
                        },
                        border: {
                            top: {
                                style: 'medium',
                                color: 'FFFFAA00',
                            },
                            right: {
                                style: 'medium',
                                color: 'FFFFAA00',
                            },
                            left: {
                                style: 'medium',
                                color: 'FFFFAA00',
                            },
                            bottom: {
                                style: 'medium',
                                color: 'FFFFAA00',
                            },
                        },
                    }
                }
            }
            ws["A1"].s = {
                font: {
                    name: "Calibri",
                    sz: 12,
                    bold: true,
                    alignment: {
                        wrapText: true,
                        vertical: 'center',
                        horizontal: 'center',
                    }
                },
            };

            let wscols = [
                {wch:50},
                {wch:50},
                {wch:50},
                {wch:50},
                {wch:20},

                {wch:25},
                {wch:25},
                {wch:25},
                {wch:25},
                {wch:25},
                {wch:25},
                {wch:25},
                {wch:25},
                {wch:25},
                {wch:25},
                {wch:25},
                {wch:25},

                {wch:45},
            ];
            ws['!cols'] = wscols;
            
            XLSX.writeFile(workbook, title+".xlsx");
            callback ? callback():null;
        }
    });
}
function exportFiscalLimitPDF(params, callback){
    new HttpRequest({
        url: "/reports/fiscal-limit/fetch",
        data: params,
        done: function(res){
            const allotment_classes = res.ac; 
            const fund_chargeability = res.fc; 
            const service_regions = res.service_regions; 
            const ac_order = [1,3,2];

            console.log("res",res);

            let grand_totals = {}
            let head = [[],[]];
            let body = [];
            let totals = {
                total_sub_total: 0,
                total_grand_total: 0, 
                region_total: 0,
                _grand_totals: {},
                _sub_totals: {},
            }
            
            let col_count = Object.keys(res.header).reduce((a,b)=>parseInt(a)+Object.keys(res.header[b]).length, 0) + 2;
            //header
            head[0].push(
                {
                    content: "OFFICES",
                    rowSpan: 2,
                },
            );
            for (let i = 0; i < ac_order.length; i++) {
                const key = ac_order[i];
                if(res.header[key]){
                    head[0].push(
                        {
                            content: allotment_classes[key].accronym,
                            colSpan: Object.keys(res.header[key]).length,
                        },
                    );
                    for (const fc_id in res.header[key]) {
                        head[1].push(
                            {
                                content: fund_chargeability[fc_id].accronym,
                            },
                        );
                    }
                }
            }
            head[0].push(
                {
                    content: "TOTAL",
                    rowSpan: 2,
                },
            );

            let add_to_total=function(obj, ac_id, fc_id, amount){
                if(!obj[ac_id]){
                    obj[ac_id]={};
                }
                if(!obj[ac_id][fc_id]){
                    obj[ac_id][fc_id]=[{amount:0}];
                }
                obj[ac_id][fc_id][0].amount += amount;
            }

            let add_row = function(data, row, opts){
                for (let i = 0; i < ac_order.length; i++) {
                    const key = ac_order[i];
                    if(data[key]){
                        for (const fc_id in data[key]) {
                            try {
                                let amount = data[key][fc_id][0].amount;
                                row.push({
                                    content: formatter(amount),
                                    styles: opts.styles,
                                });
                                if(opts.total_keys){
                                    for (let i = 0; i < opts.total_keys.length; i++) {
                                        const t_key = opts.total_keys[i];
                                        if(t_key.charAt(0)=="_"){
                                            add_to_total(totals[t_key], key, fc_id, amount);
                                        }
                                        else{
                                            totals[t_key] += amount;
                                        }
                                    }
                                }
                            } catch (error) {
                                row.push({
                                    content: "",
                                    styles: opts.styles,
                                });
                            }
                        }
                    }
                }
            }

            
            //body
            for (const office_id in res.body) {
                totals.total_sub_total=0;
                totals._sub_totals={};
                body.push([
                    {
                        content: office_id == "1" ? "Regional Office":"Central Office",
                        colSpan: col_count,
                        styles: {valign: 'middle', halign: 'center', fillColor: "#ef8d42", textColor: "#ffffff", fontStyle: 'bold', fontSize: 13},
                    }
                ]);
                for (const region_id in res.body[office_id]) {
                    totals.region_total=0;
                    const element = res.body[office_id][region_id];
                    let region_row = [];
                    region_row.push({
                        content: service_regions[region_id].accronym,
                    });
                    add_row(element, region_row, {
                        total_keys: ['total_sub_total', 'total_grand_total', 'region_total','_grand_totals', '_sub_totals'],
                    });
                    region_row.push({
                        content: formatter(totals.region_total),
                    });
                    body.push(region_row);
                }

                let subtotal_row = [];
                subtotal_row.push({
                    content: "Sub Total",
                    styles: {fillColor: "#404396", textColor: "#ffffff"}
                });
                add_row(totals._sub_totals, subtotal_row, {
                    styles: {fillColor: "#404396", textColor: "#ffffff"},
                    // total_keys: ['total_sub_total', 'total_grand_total', '_grand_totals'],
                });
                subtotal_row.push({
                    content: formatter(totals.total_sub_total),
                    styles: {fillColor: "#404396", textColor: "#ffffff"}
                });
                body.push(subtotal_row);
            }
            console.log("totals", totals);

            //grand total trow
            let grandtotal_row = [];
            grandtotal_row.push({
                content: "Grand Total",
                styles: {fillColor: "#1c20ab", textColor: "#ffffff"}
            });
            add_row(totals._grand_totals, grandtotal_row, {
                styles: {fillColor: "#1c20ab", textColor: "#ffffff"}
            });
            grandtotal_row.push({
                content: formatter(totals.total_grand_total),
                styles: {fillColor: "#1c20ab", textColor: "#ffffff"}
            });
            body.push(grandtotal_row);

            var doc = new jsPDF('l', 'pt', [1920, 1080]);
            const title = `FISCAL LIMITS ${params.year}`;
            doc.text(title, (doc.internal.pageSize.getWidth() / 2), 50, {align: 'center'});

            doc.autoTable({
                startY: 60,
                head: head,
                body: body,
                theme: 'striped',
                headStyles: {
                    fillColor: '#ffffff',
                    valign: 'middle', 
                    halign: 'center', 
                    lineWidth: 1,
                    textColor: '#000000',
                    fontStyle: 'bold', 
                    fontSize: 14
                },
                bodyStyles: {
                    cellPadding: 10,
                },
            })
            doc.save(title+'.pdf');
            callback ? callback():null;
        }
    });
}
function exportFiscalLimitExcel(params, callback){
    new HttpRequest({
        url: "/reports/fiscal-limit/fetch",
        data: params,
        done: function(res){
            const allotment_classes = res.ac; 
            const fund_chargeability = res.fc; 
            const service_regions = res.service_regions; 
            const ac_order = [1,3,2];
            const table = document.createElement('table');
            const thead = document.createElement('thead');
            const tbody = document.createElement('tbody');
            table.appendChild(thead);
            table.appendChild(tbody);
            let table_content={
                head: ['',''],
                body: '',
            }

            let grand_totals = {}
            // let head = [[],[]];
            // let body = [];
            let totals = {
                total_sub_total: 0,
                total_grand_total: 0, 
                region_total: 0,
                _grand_totals: {},
                _sub_totals: {},
            }
            
            let col_count = Object.keys(res.header).reduce((a,b)=>parseInt(a)+Object.keys(res.header[b]).length, 0) + 2;
            //header
            table_content.head[0] += `<tr>
                    <td rowSpan="2">OFFICES</td>`;
            table_content.head[1] += `<tr>`;

            for (let i = 0; i < ac_order.length; i++) {
                const key = ac_order[i];
                if(res.header[key]){
                    table_content.head[0] += `
                        <td colSpan="${Object.keys(res.header[key]).length}">${allotment_classes[key].accronym}</td>
                    `;
                    for (const fc_id in res.header[key]) {
                        table_content.head[1] += `
                            <td>${fund_chargeability[fc_id].accronym}</td>
                        `;
                    }
                }
            }
            table_content.head[0] += `
                    <td rowSpan="2">TOTAL</td>
                </tr>    
            `;
            table_content.head[1] += `</tr>`;
            thead.innerHTML = table_content.head[0] + table_content.head[1];

            let add_to_total=function(obj, ac_id, fc_id, amount){
                if(!obj[ac_id]){
                    obj[ac_id]={};
                }
                if(!obj[ac_id][fc_id]){
                    obj[ac_id][fc_id]=[{amount:0}];
                }
                obj[ac_id][fc_id][0].amount += amount;
            }

            let add_row = function(data, row, opts){
                for (let i = 0; i < ac_order.length; i++) {
                    const key = ac_order[i];
                    if(data[key]){
                        for (const fc_id in data[key]) {
                            try {
                                let amount = data[key][fc_id][0].amount;
                                row.innerHTML += `<td>${formatter(amount)}</td>`;
                                if(opts.total_keys){
                                    for (let i = 0; i < opts.total_keys.length; i++) {
                                        const t_key = opts.total_keys[i];
                                        if(t_key.charAt(0)=="_"){
                                            add_to_total(totals[t_key], key, fc_id, amount);
                                        }
                                        else{
                                            totals[t_key] += amount;
                                        }
                                    }
                                }
                            } catch (error) {
                                row.innerHTML += `<td></td>`;
                            }
                        }
                    }
                }
            }
            
            //body
            for (const office_id in res.body) {
                let tr1 = document.createElement('tr');
                tr1.innerHTML=`<td colSpan=${col_count}>${office_id == "1" ? "Regional Office":"Central Office"}</td>`;
                tbody.appendChild(tr1);

                for (const region_id in res.body[office_id]) {
                    const element = res.body[office_id][region_id];
                    let tr2 = document.createElement('tr');
                    tr2.innerHTML=`<td>${service_regions[region_id].accronym}</td>`;
                    add_row(element, tr2, {
                        total_keys: ['total_sub_total', 'total_grand_total', 'region_total','_grand_totals', '_sub_totals'],
                    });
                    tr2.innerHTML+=`<td>${formatter(totals.region_total)}`;
                    tbody.appendChild(tr2);
                }

                let tr3 = document.createElement('tr');
                tr3.innerHTML=`<td>Sub Total</td>`;
                add_row(totals._sub_totals, tr3, {});
                tr3.innerHTML+=`<td>${formatter(totals.total_sub_total)}</td>`;
                tbody.appendChild(tr3);
            }
            //grand total trow
            let tr4 = document.createElement('tr');
            tr4.innerHTML=`<td>Grand Total</td>`;
            add_row(totals._grand_totals, tr4, {});
            tr4.innerHTML+=`<td>${formatter(totals.total_grand_total)}</td>`;
            tbody.appendChild(tr4);
            const title = `FISCAL LIMITS ${params.year}`;

            var workbook = XLSX.utils.table_to_book(table);
            
            // Process Data (add a new row)
            var ws = workbook.Sheets["Sheet1"];

            //Wrap all cell nad center vertically
            for (const key in ws) {
                if(!key.includes("!")){
                    ws[key].s = {
                        alignment: {
                            wrapText: true,
                            vertical: 'center',
                        }
                    }
                }
            }


            const header_cell = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];
            //add style to headers
            for (let j = 0; j < col_count; j++) {
                for (let i = 1; i <= 2; i++) {
                    let key = header_cell[j] + i;
                    if(!ws[key]){
                        ws[key]={
                            s: "",
                            t: "s",
                            v: ""
                        }
                    }
                    ws[key].t = "s";
                    ws[key].s = {
                        alignment: {
                            wrapText: true,
                            vertical: 'center',
                        },
                        font: {
                            name: "Calibri",
                            sz: 12,
                            bold: true,
                            // color: { rgb: "FFFFAA00" },
                        },
                        border: {
                            top: {
                                style: 'medium',
                                color: 'FFFFAA00',
                            },
                            right: {
                                style: 'medium',
                                color: 'FFFFAA00',
                            },
                            left: {
                                style: 'medium',
                                color: 'FFFFAA00',
                            },
                            bottom: {
                                style: 'medium',
                                color: 'FFFFAA00',
                            },
                        },
                    }
                }
            }
            // ws["A1"].s = {
            //     font: {
            //         name: "Calibri",
            //         sz: 12,
            //         bold: true,
            //         alignment: {
            //             wrapText: true,
            //             vertical: 'center',
            //             horizontal: 'center',
            //         }
            //     },
            // };
            let wscols = [];
            for (let i = 0; i < col_count; i++) {
                wscols.push({wch:20});
            }
            ws['!cols'] = wscols;
            
            XLSX.writeFile(workbook, title+".xlsx");
            callback ? callback():null;
        }
    });
}
function exportAPBExcel(params, callback){
    new HttpRequest({
        url: "/reports/table/apb",
        data: params,
        dataType: 'text',
        done: function(res){
            let div = document.createElement('div');
            div.innerHTML=res;
            const table = div.querySelector('table');

            const title = `ANNUAL PLANS AND BUDGET FY ${params.year}`;

            var workbook = XLSX.utils.table_to_book(table);
            
            // Process Data (add a new row)
            var ws = workbook.Sheets["Sheet1"];

            //Wrap all cell nad center vertically
            for (const key in ws) {
                if(!key.includes("!")){
                    ws[key].s = {
                        alignment: {
                            wrapText: true,
                            vertical: 'center',
                        }
                    }
                }
            }


            const header_cell = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];
            //add style to headers
            for (let j = 0; j < 7; j++) {
                for (let i = 8; i <= 8; i++) {
                    let key = header_cell[j] + i;
                    if(!ws[key]){
                        ws[key]={
                            s: "",
                            t: "s",
                            v: ""
                        }
                    }
                    ws[key].t = "s";
                    ws[key].s = {
                        alignment: {
                            wrapText: true,
                            vertical: 'center',
                        },
                        font: {
                            name: "Calibri",
                            sz: 12,
                            bold: true,
                            // color: { rgb: "FFFFAA00" },
                        },
                        border: {
                            top: {
                                style: 'medium',
                                color: 'FFFFAA00',
                            },
                            right: {
                                style: 'medium',
                                color: 'FFFFAA00',
                            },
                            left: {
                                style: 'medium',
                                color: 'FFFFAA00',
                            },
                            bottom: {
                                style: 'medium',
                                color: 'FFFFAA00',
                            },
                        },
                    }
                }
            }
            // ws["A1"].s = {
            //     font: {
            //         name: "Calibri",
            //         sz: 12,
            //         bold: true,
            //         alignment: {
            //             wrapText: true,
            //             vertical: 'center',
            //             horizontal: 'center',
            //         }
            //     },
            // };
            ws['!cols'] = [
                {wch:50},

                {wch:20},
                {wch:20},
                {wch:20},
                {wch:20},
                {wch:20},

                {wch:30},
            ];
            
            XLSX.writeFile(workbook, title+".xlsx");
            callback ? callback():null;
        }
    });
}
function exportAPBpdf(params, callback){
    new HttpRequest({
        url: "/reports/apb/data",
        data: params,
        done: function(res){
            console.log("res",res);
            let height= 0;
            let body = [];
            let doc = new jsPDF('l', 'pt', [1920, 1080]);
            doc.text('OFFICE OF CIVIL DEFENSE', (doc.internal.pageSize.getWidth() / 2), 50, {align: 'center'});
            doc.text(`ANNUAL PLANS AND BUDGET FY ${params.year}`, (doc.internal.pageSize.getWidth() / 2), 70, {align: 'center'});
            doc.autoTable({
                startY: 90,
                // tableWidth: 1920,
                body: [
                    [
                        {
                            content: "PROJECTS/ACTIVITIES",
                            colSpan: 3,
                        },
                    ],
                    [
                        {
                            content: "OVERALL BUDGET",
                            colSpan: 2,
                        },
                        {
                            content: formatter(res.total_budget),
                        },
                    ],
                    [
                        {
                            content: "OPERATIONS",
                            colSpan: 2,
                        },
                        {
                            content: "0.00",
                        },
                    ],
                    [
                        {
                            content: "ORGANIZATIONAL OUTCOME (OO):",
                            colSpan: 2,
                        },
                        {
                            content: "RESILIENCY OF COMMUNITIES TO DISASTERS IMPROVED",
                        },
                    ],
                    [
                        {
                            content: "PROGRAM",
                            colSpan: 2,
                        },
                        {
                            content: "Civil Protection Program",
                        },
                    ]
                ],
                bodyStyles: {
                    valign: 'middle', 
                    // halign: 'center', 
                    lineWidth: 1,
                    minCellWidth: 200
                },
                theme: 'plain',
                showHead: 'never',
                willDrawCell: function(data){
                    data.cell.styles.fontStyle='bold';
                    if(((data.row.index + 1) % 2) != 0){
                        //label
                        data.cell.styles.textColor='#808080';
                        data.cell.styles.fontSize=7;
                    }
                },
                didDrawPage: function(data) {
                    console.log(data);
                    height = data.cursor.y || 0;
                }
            })
            let ppmp_count = 1;
            for (const key in res.form_ppmp) {
                //Fund Chargeability row
                body.push([{
                    content: res.fund_chargeability[key].type,
                    colSpan: 7,
                    styles: {fillColor: '#1c20ab', textColor: '#ffffff'}
                }]);

                const ppmps = res.form_ppmp[key];
                for (let i = 0; i < ppmps.length; i++) {
                    const ppmp = ppmps[i];

                    let pap_tags = [];
                    let subpap_count = 1;
                    for (let s = 0; s < ppmp.poe.poe_tags.length; s++) {
                        pap_tags.push(ppmp.poe.poe_tags[s].pap_tag.tag);
                    }
                            
                    body.push([
                        {
                            content: ppmp_count+". "+(ppmp.poe.pap_txt || ppmp.poe.suggested_pap.paps),
                            colSpan: 5,
                            styles: {fillColor: '#404396', textColor: '#ffffff'},
                        },
                        {
                            content: formatter(ppmp.poe.total),
                            styles: {fillColor: '#404396', textColor: '#ffffff'},
                        },
                        {
                            content: pap_tags.join(', '),
                            styles: {fillColor: '#404396', textColor: '#ffffff'},
                        }
                    ]);
                    
                    const subpaps = ppmp.poe.subpap;
                    for (let x = 0; x < subpaps.length; x++) {
                        const subpap = subpaps[x];
                        const qtr_target = subpap.quarter_target.quarter_target;
                        let subpap_total = 0;
                        let subpap_row = [
                            {
                                content: ppmp_count+'.'+subpap_count+". "+(subpap.subpap_txt || subpap.suggested_sub_pap.subpaps),
                                colSpan: 5,
                                styles: {fillColor: '#ef8d42'},
                            },
                            {
                                content: 0,
                                styles: {fillColor: '#ef8d42', textColor: '#ffffff'},
                            },
                            {
                                content: '',
                                styles: {fillColor: '#ef8d42', textColor: '#ffffff'},
                            }
                        ];
                        body.push(subpap_row);
                        // let item_req_rows = [];

                        let item_req_count = 1;
                        for (let j = 0; j < subpap.item_requirements.length; j++) {
                            const item_requirement = subpap.item_requirements[j];
                            subpap_total += toFloat(item_requirement.total);
                            
                            let qtr = {
                                1: 0,
                                2: 0,
                                3: 0,
                                4: 0,
                            };

                            for (let m = 0; m < item_requirement.item_months.length; m++) {
                                qtr[item_requirement.item_months[m].quarter] += parseInt(item_requirement.item_months[m].qty);
                            }

                            let item_req_row = [
                                {
                                    content: ppmp_count+'.'+subpap_count+'.'+item_req_count+'. '+(item_requirement.itemreq_txt || item_requirement.suggested_item_requirement.ireq),
                                },
                                {
                                    content:  qtr[1] > 0 ? (qtr[1]+" "+qtr_target):"",
                                },
                                {
                                    content:  qtr[2] > 0 ? (qtr[2]+" "+qtr_target):"",
                                },
                                {
                                    content:  qtr[3] > 0 ? (qtr[3]+" "+qtr_target):"",
                                },
                                {
                                    content:  qtr[4] > 0 ? (qtr[4]+" "+qtr_target):"",
                                },
                                {
                                    content: item_requirement.total,
                                },
                            ];
                            body.push(item_req_row);
                            item_req_count++;
                        }
                        subpap_row[1].content = formatter(subpap_total);
                        subpap_count++;
                    }
                }
                ppmp_count++;
            }




            
            doc.autoTable({
                startY: height + 10,
                head: [
                    [
                        {
                            content: 'PROJECT/ACTIVITIES',
                        },
                        {
                            content: 'Q1 TARGET',
                        },
                        {
                            content: 'Q2 TARGET',
                        },
                        {
                            content: 'Q3 TARGET',
                        },
                        {
                            content: 'Q4 TARGET',
                        },
                        {
                            content: 'BUDGET',
                        },
                        {
                            content: 'POE TAGS',
                        },
                    ],
                ],
                body: body,
                theme: 'striped',
                headStyles: {
                    // fillColor: [28, 32, 171],
                    valign: 'middle', 
                    halign: 'center', 
                    lineWidth: 1
                },
            })
            doc.save(`ANNUAL PLANS AND BUDGET FY ${params.year}.pdf`);


            console.log("res",res);
            callback ? callback():null;
        }
    });
}
// function exportOPCexcel(id, callback){
//     new HttpRequest({
//         url: "/reports/opc/"+id,
//         method: 'get',
//         dataType: 'text',
//         done: function(res){
//             // console.log("res",res);
//             // return;
//             let div = document.createElement('div');
//             div.innerHTML=res;
//             const ops_table = div.querySelector('#pageOneTable');
//             const opc_table = div.querySelector('#pageTwoTable');

            

//             var ops_ws = XLSX.utils.table_to_sheet(ops_table);
//             var opc_ws = XLSX.utils.table_to_sheet(opc_table);

//             var workbook = XLSX.utils.book_new();

//             XLSX.utils.book_append_sheet(workbook, ops_ws, "OPS");
//             XLSX.utils.book_append_sheet(workbook, opc_ws, "OPC");


//             let addStyles=function(ws){
//                 for (const key in ws) {
//                     if(!key.includes("!")){
//                         ws[key].s = {
//                             alignment: {
//                                 wrapText: true,
//                                 vertical: 'center',
//                             }
//                         }
//                     }
//                 }

//                 //add style to headers
//                 const header_cell = ["A","B","C","D","E","F","G","H","I","J"];
//                 for (let j = 0; j < header_cell.length; j++) {
//                     for (let i = 1; i <= 2; i++) {
//                         let key = header_cell[j] + i;
//                         if(!ws[key]){
//                             ws[key]={
//                                 s: "",
//                                 t: "s",
//                                 v: ""
//                             }
//                         }
//                         ws[key].t = "s";
//                         ws[key].s = {
//                             alignment: {
//                                 wrapText: true,
//                                 vertical: 'center',
//                             },
//                             font: {
//                                 name: "Calibri",
//                                 sz: 12,
//                                 bold: true,
//                                 // color: { rgb: "FFFFAA00" },
//                             },
//                             border: {
//                                 top: {
//                                     style: 'medium',
//                                     color: 'FFFFAA00',
//                                 },
//                                 right: {
//                                     style: 'medium',
//                                     color: 'FFFFAA00',
//                                 },
//                                 left: {
//                                     style: 'medium',
//                                     color: 'FFFFAA00',
//                                 },
//                                 bottom: {
//                                     style: 'medium',
//                                     color: 'FFFFAA00',
//                                 },
//                             },
//                         }
//                     }
//                 }
//             }


//             addStyles(ops_ws);
//             addStyles(opc_ws);

//             ops_ws['!cols'] = [
//                 {wch:50},
//                 {wch:30},
//                 {wch:30},
//                 {wch:30},

//                 {wch:20},
//                 {wch:20},
//                 {wch:20},
//                 {wch:20},
//                 {wch:20},
//             ];

//             opc_ws['!cols'] = [
//                 {wch:50},
//                 {wch:30},
//                 {wch:20},
//                 {wch:20},
//                 {wch:20},

//                 {wch:15},
//                 {wch:15},
//                 {wch:15},
//                 {wch:15},

//                 {wch:30},
//             ];
            
//             XLSX.writeFile(workbook, "test.xlsx");
//             callback ? callback():null;
//         }
//     });
// }

function exportOPCexcel(params, callback){
    new HttpRequest({
        url: "/reports/opc/data",
        data:{id: params.id},
        done: function(res){
            console.log("res",res);
            const priority_classes = res.priority_classes;
            const opc = res.opc;
            const opc_items = res.opc_items;
            let ops_body = '';
            let opc_body = '';
            let ops_table = document.createElement('table');
            let opc_table = document.createElement('table');
            ops_table.innerHTML=`
                <thead>
                    <tr>
                        <th rowspan="2" valign="top" scope="col">Major Final Outputs</th>
                        <th rowspan="2" valign="top" scope="col">PERFORMANCE MEASURES</th>
                        <th style="width:10rem;" rowspan="2" valign="top" scope="col">PERFORMANCE TARGETS</th>
                        <th style="width:20rem" rowspan="2" valign="top" scope="col">SUCCESS INDICATOR Measures + Targets</th>
                        <th style="width:40rem" colspan="5" valign="top" scope="col">PERFORMANCE STANDARDS
                        </th>
                    </tr>
                    <tr>
                        <td valign="top">Outstanding</td>
                        <td valign="top">Very Satisfactory</td>
                        <td valign="top">Satisfactory</td>
                        <td valign="top">Unsatisfactory</td>
                        <td valign="top">Poor</td>
                    </tr>
                </thead>
            `;
            opc_table.innerHTML=`
                <thead>
                    <tr>
                        <th class="text-th" rowspan="2" valign="top" scope="col">Major Final Outputs</th>
                        <th class="text-th" rowspan="2" valign="top" scope="col">SUCCESS INDICATOR Measures + Targets</th>
                        <th class="text-th-sm" rowspan="2" valign="top" scope="col">Alloted Budget</th>
                        <th class="text-th" rowspan="2" valign="top" scope="col">Division Accountable/Section</th>
                        <th class="text-th" rowspan="2" valign="top" scope="col">Actual Accomplishments</th>
                        <th class="text-th" colspan="4" valign="top" scope="col">Rating</th>
                        <th class="text-th" rowspan="2" valign="top" scope="col">Remarks</th>
                    </tr>
                    <tr>
                        <th class="rating-th" valign="top">Ql1</th>
                        <th class="rating-th" valign="top">Qn2</th>
                        <th class="rating-th" valign="top">T3</th>
                        <th class="rating-th" valign="top">A4</th>
                    </tr>
                </thead>
            `;

            const pc_ids = Object.keys(opc_items);
            let total_weighted_point_percentage = 0;
            let total_average_points = {};
            let getWeightedPointPercentage = function(pc_id){
                if(pc_ids.length == 3){
                    return pc_id == 1 ? .5 : pc_id == 2 ? .3 : pc_id == 3 ? .2:1;
                }
                else if(pc_ids.length == 2){
                    if(pc_ids.includes('1') && pc_ids.includes('2')){
                        return pc_id == 1 ? .8:.2;
                    }
                    else if(pc_ids.includes('1') && pc_ids.includes('3')){
                        return pc_id == 1 ? .8:.2;
                    }
                    else if(pc_ids.includes('2') && pc_ids.includes('3')){
                        return pc_id == 2 ? .8:.2;
                    }
                }
                else{
                    return 1;
                }
            }

            for (const pc_id in opc_items) {
                ops_body += `<tr>
                    <td colspan="9">${priority_classes[pc_id].class}</td>
                </tr>`;

                for (let i = 0; i < opc_items[pc_id].length; i++) {
                    const opc_item = opc_items[pc_id][i];
                    ops_body += `<tr>
                        <td rowspan="3">${opc_item.mfo.desc}</td>
                        <td>Quality</td>
                        <td>${opc_item.performance_measures.filter((pm)=>pm.name=='Quality')[0].pivot.target}</td>
                        <td rowspan="3">${opc_item.success_indicator_mt}</td>
                        <td rowspan="3">${opc_item.ps_outstanding}</td>
                        <td rowspan="3">${opc_item.ps_very_satisfactory}</td>
                        <td rowspan="3">${opc_item.ps_satisfactory}</td>
                        <td rowspan="3">${opc_item.ps_unsatisfactory}</td>
                        <td rowspan="3">${opc_item.ps_poor}</td>
                    </tr>
                    <tr>
                        <td>Quantity</td>
                        <td>${opc_item.performance_measures.filter((pm)=>pm.name=='Quantity')[0].pivot.target}</td>
                    </tr>
                    <tr>
                        <td>Timeliness</td>
                        <td>${opc_item.performance_measures.filter((pm)=>pm.name=='Timeliness')[0].pivot.target}</td>
                    </tr>`;
                }
            }
            for (const pc_id in opc_items) {
                let opc_items_count = opc_items[pc_id].length;
                let ratings = {
                    qn:0, 
                    ql:0,
                    t:0,
                    a:0,
                };

                total_average_points[pc_id] = ratings;
                opc_body += `
                    <tr>
                        <td colspan="10">${priority_classes[pc_id].class}</td>
                    </tr>
                `;

                for (let i = 0; i < opc_items[pc_id].length; i++) {
                    const opc_item = opc_items[pc_id][i];
                    let qn = opc_item.performance_measures.filter((pm)=>pm.legend=='Qn')[0].pivot.rating;
                    let ql = opc_item.performance_measures.filter((pm)=>pm.legend=='Ql')[0].pivot.rating;
                    let t = opc_item.performance_measures.filter((pm)=>pm.legend=='T')[0].pivot.rating;
                    let a = (qn + ql + t) / 3;
                    ratings.qn += qn;
                    ratings.ql += ql;
                    ratings.t += t;
                    ratings.a += a;

                    opc_body += `
                        <tr>
                            <td>${opc_item.mfo.desc}</td>
                            <td>${opc_item.success_indicator_mt}</td>
                            <td>${opc_item.mfo.total_budget}</td>
                            <td>${opc_item.division_accountable}</td>
                            <td>${opc_item.actual_accomplishments}</td>
                            <td>${ql}</td>
                            <td>${qn}</td>
                            <td>${t}</td>
                            <td>${formatter(a)}</td>
                            <td>${opc_item.remarks}</td>
                        </tr>
                    `;
                }
                opc_body += `
                    <tr>
                        <td colspan="5">Average Point Score (${priority_classes[pc_id].class})</td>
                        <td>${formatter(ratings.ql / opc_items_count)}</td>
                        <td>${formatter(ratings.qn / opc_items_count)}</td>
                        <td>${formatter(ratings.t / opc_items_count)}</td>
                        <td>${formatter(ratings.a / opc_items_count)}</td>
                        <td></td>
                    </tr>
                `;

                let weighted_point_percentage = getWeightedPointPercentage(pc_id);
                total_weighted_point_percentage += (ratings.a / opc_items_count) * weighted_point_percentage;

                opc_body += `
                    <tr>
                        <td colspan="5">Weighted Point Score (${weighted_point_percentage * 100}%)</td>
                        <td>${formatter((ratings.ql / opc_items_count) * weighted_point_percentage)}</td>
                        <td>${formatter((ratings.qn / opc_items_count) * weighted_point_percentage)}</td>
                        <td>${formatter((ratings.t / opc_items_count) * weighted_point_percentage)}</td>
                        <td>${formatter((ratings.a / opc_items_count) * weighted_point_percentage)}</td>
                        <td></td>
                    </tr>
                `;
            }
            opc_body += `
                <tr>
                    <td colspan="10">TOTAL AVERAGE POINT SCORE</td>
                </tr>
            `;
            for (const key in total_average_points) {
                const ratings = total_average_points[key];
                let opc_items_count = opc_items[key].length;

                opc_body += `
                    <tr>
                        <td colspan="5">${priority_classes[key].class}</td>
                        <td>${formatter(ratings.ql / opc_items_count)}</td>
                        <td>${formatter(ratings.qn / opc_items_count)}</td>
                        <td>${formatter(ratings.t / opc_items_count)}</td>
                        <td>${formatter(ratings.a / opc_items_count)}</td>
                        <td></td>
                    </tr>
                `;
            }
            total_weighted_point_percentage += opc.add_point_score;
            opc_body += `
                <tr>
                    <td colspan="5">POINT SCORE FOR ADDITIONAL CRITERIA (NTF and IATF Functions)</td>
                    <td colspan="5">${opc.add_point_score}</td>
                </tr>
                <tr>
                    <td colspan="5">OVERALL PERFORMANCE RATING</td>
                    <td colspan="5">${formatter(total_weighted_point_percentage)}</td>
                </tr>
                <tr>
                    <td colspan="5">OVERALL EQUIVALENT ADJECTIVAL RATING</td>
                    <td colspan="5">
                    ${total_weighted_point_percentage > 4.2 ? "OUTSTANDING":
                        total_weighted_point_percentage > 3.4 ? "VERY SATISFACTORY":
                            total_weighted_point_percentage > 2.9 ? "SATISFACTORY":
                                total_weighted_point_percentage > 1.5 ? "UNSATISFACTORY":"POOR"}
                    </td>
                </tr>
            `;

            let ops_tbl = document.createElement('tbody');
            let opc_tbl = document.createElement('tbody');
            ops_tbl.innerHTML=ops_body;
            opc_tbl.innerHTML=opc_body;
            ops_table.appendChild(ops_tbl);
            opc_table.appendChild(opc_tbl);

            var ops_ws = XLSX.utils.table_to_sheet(ops_table, {raw:true});
            var opc_ws = XLSX.utils.table_to_sheet(opc_table, {raw:true});

            var workbook = XLSX.utils.book_new();

            XLSX.utils.book_append_sheet(workbook, ops_ws, "OPS");
            XLSX.utils.book_append_sheet(workbook, opc_ws, "OPC");

            ops_ws['!cols'] = [
                {wch:50},
                {wch:30},
                {wch:30},
                {wch:30},

                {wch:20},
                {wch:20},
                {wch:20},
                {wch:20},
                {wch:20},
            ];

            opc_ws['!cols'] = [
                {wch:50},
                {wch:30},
                {wch:20},
                {wch:20},
                {wch:20},

                {wch:15},
                {wch:15},
                {wch:15},
                {wch:15},

                {wch:30},
            ];

            XLSX.writeFile(workbook, `OPC FY ${params.year} - ${params.region}.xlsx`);
            callback ? callback():null;
        }
    });		
}
function exportOPCpdf(params, callback){
    new HttpRequest({
        url: "/reports/opc/data",
        data:{id: params.id},
        done: function(res){
            console.log("res",res);
            const priority_classes = res.priority_classes;
            const opc = res.opc;
            const opc_items = res.opc_items;
            let ops_body = [];
            let opc_body = [];
            let doc = new jsPDF('l', 'pt', [1920, 1080]);
            doc.text('OFFICE OF CIVIL DEFENSE', (doc.internal.pageSize.getWidth() / 2), 50, {align: 'center'});
            doc.text(`OPC FY ${params.year}`, (doc.internal.pageSize.getWidth() / 2), 70, {align: 'center'});
            const pc_ids = Object.keys(opc_items);
            let total_weighted_point_percentage = 0;
            let total_average_points = {};
            let getWeightedPointPercentage = function(pc_id){
                console.log("get wpp", pc_id);
                console.log("get wpp ids", pc_ids);
                console.log("pc_ids.includes(1)",pc_ids.includes(1));
                console.log("pc_ids.includes(2)",pc_ids.includes(2));
                if(pc_ids.length == 3){
                    return pc_id == 1 ? .5 : pc_id == 2 ? .3 : pc_id == 3 ? .2:1;
                }
                else if(pc_ids.length == 2){
                    if(pc_ids.includes('1') && pc_ids.includes('2')){
                        return pc_id == 1 ? .8:.2;
                    }
                    else if(pc_ids.includes('1') && pc_ids.includes('3')){
                        return pc_id == 1 ? .8:.2;
                    }
                    else if(pc_ids.includes('2') && pc_ids.includes('3')){
                        return pc_id == 2 ? .8:.2;
                    }
                }
                else{
                    return 1;
                }
            }

            for (const pc_id in opc_items) {
                ops_body.push([
                    {
                        content: priority_classes[pc_id].class,
                        colSpan: 9,
                        styles: {fillColor: '#d6d8db'}
                    }
                ]);

                for (let i = 0; i < opc_items[pc_id].length; i++) {
                    const opc_item = opc_items[pc_id][i];
                    ops_body.push([
                        {
                            content: opc_item.mfo.desc,
                            rowSpan: 3,
                        },
                        {
                            content: "Quality"
                        },
                        {
                            content: opc_item.performance_measures.filter((pm)=>pm.name=='Quality')[0].pivot.target
                        },
                        {
                            content: opc_item.success_indicator_mt,
                            rowSpan: 3,
                        },
                        {
                            content: opc_item.ps_outstanding,
                            rowSpan: 3,
                        },
                        {
                            content: opc_item.ps_very_satisfactory,
                            rowSpan: 3,
                        },
                        {
                            content: opc_item.ps_satisfactory,
                            rowSpan: 3,
                        },
                        {
                            content: opc_item.ps_unsatisfactory,
                            rowSpan: 3,
                        },
                        {
                            content: opc_item.ps_poor,
                            rowSpan: 3,
                        },
                    ]);
                    ops_body.push([
                        {
                            content: "Quantity"
                        },
                        {
                            content: opc_item.performance_measures.filter((pm)=>pm.name=='Quantity')[0].pivot.target
                        },
                    ]);
                    ops_body.push([
                        {
                            content: "Timeliness"
                        },
                        {
                            content: opc_item.performance_measures.filter((pm)=>pm.name=='Timeliness')[0].pivot.target
                        },
                    ]);
                }
            }

            //ops table
            doc.autoTable({
                startY: 90,
                head: [
                    [
                        {
                            content: 'MAJOR FINAL OUTPUTS',
                            rowSpan: 2,
                        },
                        {
                            content: 'PERFORMANCE MEASURES',
                            rowSpan: 2,
                        },
                        {
                            content: 'PERFORMANCE TARGETS',
                            rowSpan: 2,
                        },
                        {
                            content: 'SUCCESS INDICATOR MEASURES + TARGETS',
                            rowSpan: 2,
                        },
                        {
                            content: 'PERFORMANCE STANDARDS',
                            colSpan: 5,
                        }
                    ],
                    [
                        {
                            content: 'OUTSTANDING',
                        },
                        {
                            content: 'VERY SATISFACTORY',
                        },
                        {
                            content: 'SATISFACTORY',
                        },
                        {
                            content: 'UNSATISFACTORY',
                        },
                        {
                            content: 'POOR',
                        },
                    ],
                ],
                body: ops_body,
                theme: 'striped',
                headStyles: {
                    // fillColor: [28, 32, 171],
                    valign: 'middle', 
                    halign: 'center', 
                    lineWidth: 1
                },
            })
            doc.addPage();


            for (const pc_id in opc_items) {
                let opc_items_count = opc_items[pc_id].length;
                let ratings = {
                    qn:0, 
                    ql:0,
                    t:0,
                    a:0,
                };

                total_average_points[pc_id] = ratings;
                opc_body.push([
                    {
                        content: priority_classes[pc_id].class,
                        colSpan: 10,
                        styles: {fillColor: '#d6d8db'}
                    }
                ]);

                for (let i = 0; i < opc_items[pc_id].length; i++) {
                    const opc_item = opc_items[pc_id][i];
                    let qn = opc_item.performance_measures.filter((pm)=>pm.legend=='Qn')[0].pivot.rating;
                    let ql = opc_item.performance_measures.filter((pm)=>pm.legend=='Ql')[0].pivot.rating;
                    let t = opc_item.performance_measures.filter((pm)=>pm.legend=='T')[0].pivot.rating;
                    let a = (qn + ql + t) / 3;
                    ratings.qn += qn;
                    ratings.ql += ql;
                    ratings.t += t;
                    ratings.a += a;

                    opc_body.push([
                        {
                            content: opc_item.mfo.desc,
                        },
                        {
                            content: opc_item.success_indicator_mt,
                        },
                        {
                            content: opc_item.mfo.total_budget,
                        },
                        {
                            content: opc_item.division_accountable,
                        },
                        {
                            content: opc_item.actual_accomplishments,
                        },

                        
                        {
                            content: ql,
                        },
                        {
                            content: qn,
                        },
                        {
                            content: t,
                        },
                        {
                            content: formatter(a),
                        },
                        {
                            content: opc_item.remarks,
                        },
                    ]);
                }
    
                opc_body.push([
                    {
                        content: `Average Point Score (${priority_classes[pc_id].class})`,
                        colSpan: 5,
                        styles: {fillColor: '#7abaff'}
                    },
                    {
                        content: formatter(ratings.ql / opc_items_count),
                        styles: {fillColor: '#7abaff'}
                    },
                    {
                        content: formatter(ratings.qn / opc_items_count),
                        styles: {fillColor: '#7abaff'}
                    },
                    {
                        content: formatter(ratings.t / opc_items_count),
                        styles: {fillColor: '#7abaff'}
                    },
                    {
                        content: formatter(ratings.a / opc_items_count),
                        styles: {fillColor: '#7abaff'}
                    },
                    {
                        content: '',
                        styles: {fillColor: '#7abaff'}
                    },
                ]);
                console.log("getWeightedPointPercentage(pc_id)", getWeightedPointPercentage(pc_id));
                let weighted_point_percentage = getWeightedPointPercentage(pc_id);
                total_weighted_point_percentage += (ratings.a / opc_items_count) * weighted_point_percentage;
                opc_body.push([
                    {
                        content: `Weighted Point Score (${weighted_point_percentage * 100}%)`,
                        colSpan: 5,
                        styles: {fillColor: '#7abaff'}
                    },
                    {
                        content: formatter((ratings.ql / opc_items_count) * weighted_point_percentage),
                        styles: {fillColor: '#7abaff'}
                    },
                    {
                        content: formatter((ratings.qn / opc_items_count) * weighted_point_percentage),
                        styles: {fillColor: '#7abaff'}
                    },
                    {
                        content: formatter((ratings.t / opc_items_count) * weighted_point_percentage),
                        styles: {fillColor: '#7abaff'}
                    },
                    {
                        content: formatter((ratings.a / opc_items_count) * weighted_point_percentage),
                        styles: {fillColor: '#7abaff'}
                    },
                    {
                        content: '',
                        styles: {fillColor: '#7abaff'}
                    },
                ]);
            }

            opc_body.push([
                {
                    content: 'TOTAL AVERAGE POINT SCORE',
                    colSpan: 10,
                    styles: {fillColor: '#ffdf7e'}
                }
            ]);

            for (const key in total_average_points) {
                const ratings = total_average_points[key];
                let opc_items_count = opc_items[key].length;
                opc_body.push([
                    {
                        content: priority_classes[key].class,
                        colSpan: 5,
                        styles: {fillColor: '#ffdf7e'}
                    },
                    {
                        content: formatter(ratings.ql / opc_items_count),
                        styles: {fillColor: '#ffdf7e'}
                    },
                    {
                        content: formatter(ratings.qn / opc_items_count),
                        styles: {fillColor: '#ffdf7e'}
                    },
                    {
                        content: formatter(ratings.t / opc_items_count),
                        styles: {fillColor: '#ffdf7e'}
                    },
                    {
                        content: formatter(ratings.a / opc_items_count),
                        styles: {fillColor: '#ffdf7e'}
                    },
                    {
                        content: '',
                        styles: {fillColor: '#ffdf7e'}
                    },
                ]);
            }
            total_weighted_point_percentage += opc.add_point_score;
            opc_body.push(
                [
                    {
                        content: 'POINT SCORE FOR ADDITIONAL CRITERIA (NTF and IATF Functions)',
                        colSpan: 5,
                    },
                    {
                        content: opc.add_point_score,
                        colSpan: 5,
                    },
                ], 
                [
                    {
                        content: 'OVERALL PERFORMANCE RATING',
                        colSpan: 5,
                    },
                    {
                        content: formatter(total_weighted_point_percentage),
                        colSpan: 5,
                    },
                ],
                [
                    {
                        content: 'OVERALL EQUIVALENT ADJECTIVAL RATING',
                        colSpan: 5,
                    },
                    {
                        content: total_weighted_point_percentage > 4.2 ? "OUTSTANDING":
                                    total_weighted_point_percentage > 3.4 ? "VERY SATISFACTORY":
                                        total_weighted_point_percentage > 2.9 ? "SATISFACTORY":
                                            total_weighted_point_percentage > 1.5 ? "UNSATISFACTORY":"POOR",
                        colSpan: 5,
                    },
                ]
            );


            //opc table
            doc.autoTable({
                startY: 90,
                head: [
                    [
                        {
                            content: 'MAJOR FINAL OUTPUTS',
                            rowSpan: 2,
                        },
                        {
                            content: 'SUCCESS INDICATOR MEASURES + TARGETS',
                            rowSpan: 2,
                        },
                        {
                            content: 'ALLOTED BUDGET',
                            rowSpan: 2,
                        },
                        {
                            content: 'DIVISION ACCOUNTABLE/SECTION',
                            rowSpan: 2,
                        },
                        {
                            content: 'ACTUAL ACCOMPLISHMENTS',
                            rowSpan: 2,
                        },
                        {
                            content: 'RATING',
                            colSpan: 4,
                        },
                        {
                            content: 'REMARKS',
                        },
                    ],
                    [
                        {
                            content: 'QL1',
                        },
                        {
                            content: 'QN2',
                        },
                        {
                            content: 'T3',
                        },
                        {
                            content: 'A4',
                        },
                    ],
                ],
                body: opc_body,
                theme: 'striped',
                headStyles: {
                    // fillColor: [28, 32, 171],
                    valign: 'middle', 
                    halign: 'center', 
                    lineWidth: 1
                },
            })





            doc.save(`OPC FY ${params.year} - ${params.region}.pdf`);
            callback ? callback():null;
        }
    });
    				
				
}