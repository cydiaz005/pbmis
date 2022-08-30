// let ls = new Searchable('#myInput', {
//     onClick: 'appendChip',
//     externalInvite: true,
//     searchableData: [...admins, ...members, ...recommended_artist],
//     searchableFields: ['name'],
//     imageElement: 'img',
//     textElement: 'name',
// });
function Searchable(el, opts) {
    el = document.querySelector(el);
    if (!el) {
        return;
    }
    el.autocomplete = "off";
    let fetching = false;
    let ids = [];
    let selected;
    let data = [];
    let loadedIds = [];
    let deletedIds = [];
    let wrapper;
    let _this = this;
    let ul;
    let appendDiv;
    let itemClick;
    let beforeSearchFunction;
    let selectedDataLimit = opts.selectedDataLimit || 0;
    let dataLimitMessage = opts.dataLimitMessage || "Data limit reaced.";
    if (el.parentNode["searchable-wrapper"]) {
        if (el.parentNode.previousElementSibling["searchable-appendDiv"]) {
            el.parentNode.previousElementSibling.remove();
        }
        let main_parent = el.parentNode.parentNode;
        let clone_el = el.cloneNode(true);
        main_parent.insertBefore(clone_el, el.parentNode);
        el.parentNode.remove();
        el = clone_el;
    }
    wrapper = document.createElement("div");
    wrapper["searchable-wrapper"] = true;
    appendDiv = document.createElement("div");
    appendDiv["searchable-appendDiv"] = true;
    appendDiv.className = "row m-0 appendDiv";
    if (opts.appendDivider) {
        let ad = opts.appendDivider;
        appendDiv.className = "appendDiv";
        ad.divLabels.forEach((element) => {
            let mainDiv = document.createElement("div");
            let hr = document.createElement("hr");
            hr.style.display = 'none';
            hr.className = 'mt-0';
            if(element != ''){
                let label = document.createElement("label");
                label.className = 'm-0';
                label.innerHTML = '<small class="pending-con">'+element+'</small>';
                mainDiv.append(label);
            }
            let div = document.createElement("div");
            div.className = "row m-0";
            mainDiv.append(div);
            mainDiv.append(hr);
            mainDiv.style.display = "none";
            appendDiv.appendChild(mainDiv);
        });
    }
    ul = document.createElement("ul");
    wrapper.className = "searchable-parent position-relative";
    ul.className = "position-absolute w-100 p-0 m-0";
    el.parentNode.insertBefore(wrapper, el);
    wrapper.parentNode.insertBefore(appendDiv, wrapper);
    wrapper.appendChild(el);
    wrapper.appendChild(ul);
    const boldQuery = (str, query) => {
        const n = str.toUpperCase();
        const q = query.toUpperCase();
        const x = n.indexOf(q);
        if (!q || x === -1) {
            return str;
        }
        const l = q.length;
        return (
            str.substr(0, x) +
            "<b>" +
            str.substr(x, l) +
            "</b>" +
            str.substr(x + l)
        );
    };
    function getProp(d) {
        let obj = {};
        for (const key in opts.props) {
            obj[key] = eval("d." + opts.props[key]) || null;
        }
        return obj;
    }
    let update_list = (text) => {
        if (el.value == "") {
            reset();
            return;
        }
        if (data.length == 0) {
            if (opts.externalInvite === true) {
                $("#invite_modal").on("show.bs.modal", function (event) {
                    $("#invite_email").val(el.value);
                });
                ul.innerHTML =
                    '<li class="text-center">' +
                    (opts.inviteMessage ||
                        'User may not be registered in avails yet. <a href="#invite_modal" data-toggle="modal">Invite?</a>') +
                    "</li>";
            } else {
                if(opts.disableNoDataFound){
                    ul.innerHTML = '';
                }
                else{
                    ul.innerHTML = '<li class="text-center">No data found</li>';
                }
            }
        } else {
            reset();
            data.forEach((obj) => {
                obj = getProp(obj);
                let textProp =
                    opts.boldResultMatch === false
                        ? obj.text
                        : boldQuery(obj.text, text);
                let li = document.createElement("li");
                let img = "img" in obj ? '<img src="'+checkLogo(obj.img, obj.text)+'" style="border-radius: 50%" width="36" height="36" class="mr-2">':"";
                let div = '<div class="d-inline-block">';
                div +='<div class="d-flex flex-column justify-content-center">';
                div +='<span  style="line-height: 1rem">' + textProp + "</span>";
                div += "subText" in obj &&
                    obj.subText != null &&
                    obj.subText != undefined
                        ? '<small style="font-size: 70%; ">' +
                          obj.subText +
                          "</small>"
                        : "";
                div += "</div>";
                div += "</div>";
                li.innerHTML =
                    '<div class="d-flex align-items-center">' +
                    img +
                    div +
                    "</div>";
                ul.appendChild(li);
                li.addEventListener("click", function () {
                    if (!itemClick[opts.onClick]) {
                        itemClick.custom(obj, opts[opts.onClick], true);
                    } else {
                        itemClick[opts.onClick](obj, true);
                    }
                });
            });
        }
        ul.style.display = "block";
    };
    let reset = () => {
        ul.innerHTML = "";
        ul.style.display = "none";
    };
    let preload = () => {
        ul.innerHTML = '<li class="text-center">Searching..</li>';
        ul.style.display = "block";
    };
    el.onkeyup = function () {
        if (this.value != "") {
            if(opts.searchingPropmt != false){
                preload();
            }
            search();
        } else {
            reset();
        }
    };
    document.removeEventListener("click", resetOutsideClick);
    document.addEventListener("click", resetOutsideClick);
    function resetOutsideClick(e) {
        if (!wrapper.contains(e.target)) {
            reset();
        }
    }
    function removeId(id) {
        if (ids.includes(id)) {
            ids.splice(ids.indexOf(id), 1);
        }
        if (loadedIds.includes(id)) {
            deletedIds.push(id);
        }
        // for (let i = 0; i < appendDiv.children.length; i++) {
        //     let n = appendDiv.children[i].querySelector('div').children.length;
        //     if(n == 1){
        //         appendDiv.children[i].style.display = 'none';
        //     }
        // }
    }
    function addId(id) {
        selected = id;
        if (!loadedIds.includes(id)) {
            ids.push(id);
        }
        if (deletedIds.includes(id)) {
            deletedIds.splice(deletedIds.indexOf(id), 1);
        }
    }
    function appendHtml(forAppend, status) {
        if (opts.appendDivider) {
            let ad = opts.appendDivider;
            appendDiv.className = "appendDiv";
            for (let i = 0; i < ad.values.length; i++) {
                if(ad.values[i].includes(status)){
                    appendDiv.children[i].querySelector('div').appendChild(forAppend);
                    appendDiv.children[i].style = '';
                    if((appendDiv.children.length - 1) != i){
                        appendDiv.children[i].lastChild.style = '';
                    }
                    break;
                }
            }
        }
        else{
            appendDiv.appendChild(forAppend);
        }
    }
    el.onfocus = function () {
        if (el.value != "") {
            update_list(el.value);
        }
    };
    const search = () => {
        if (beforeSearchFunction) {
            beforeSearchFunction();
        }
        if (opts.searchableData && opts.searchableData.length > 0) {
            let condition = "";
            let first = true;
            opts.searchableFields.forEach((f) => {
                if (first) {
                    condition +=
                        "sd." +
                        f +
                        '.toLowerCase().includes("' +
                        el.value +
                        '".toLowerCase())';
                    first = false;
                } else {
                    condition +=
                        "|| sd." +
                        f +
                        '.toLowerCase().includes("' +
                        el.value +
                        '".toLowerCase())';
                }
            });
            data = [];
            let counter = 0;
            for (let i = 0; i < opts.searchableData.length; i++) {
                let sd = opts.searchableData[i];
                if (eval(condition)) {
                    data.push(sd);
                    counter++;
                    if (counter >= 5) {
                        break;
                    }
                }
            }
            console.log("DATA", data);
            update_list(el.value);
        } else {
            let except = _this.activeIds();
            let param = {
                query: el.value,
                except: except,
            };
            for (const key in _this.addParam) {
                param[key] = _this.addParam[key];
            }
            console.log("param", param);
            fetching = false;
            if (!fetching) {
                fetching = true;
                fetch(opts.url, {
                    method: "post",
                    headers: {
                        "Cache-Control": "no-cache",
                        Accept: "application/json, text/plain, */*",
                        "Content-Type": "application/json",
                        "X-CSRF-Token": document.querySelector(
                            '[name="csrf-token"]'
                        ).content,
                    },
                    body: JSON.stringify(param),
                })
                    .then(function (response) {
                        if (!response.ok) {
                            throw new Error("HTTP status " + response.status);
                        }
                        // return response.text();
                        return response.json();
                    })
                    .then(function (res) {
                        console.log("PARAMS", param);
                        console.log("RES", res);
                        // data = [...res];
                        data = res;
                        update_list(el.value);
                        fetching = false;
                    });
            }
        }
    };
        itemClick = {
        appendChip: (data, willInsertId) => {
            if (selectedDataLimit && ids.length >= selectedDataLimit) {
                toastr.error(dataLimitMessage);
                return;
            }
            if (ids.includes(data.id)) {
                toastr.error("Already added");
                return;
            }
            if (willInsertId) {
                addId(data.id);
            }
            let divChip = document.createElement("div");
            divChip.className = "col-md-3 col-6 my-2";
            let divCon = document.createElement("div");
            divCon.className = "d-flex align-items-center chip_append";
            if ("img" in data) {
                let img = document.createElement("img");
                img.src = checkLogo(data.img, data.text);
                img.style.borderRadius = "50%";
                img.width = 36;
                img.height = 36;
                divCon.appendChild(img);
            }
            let span1 = document.createElement("span");
            span1.className = "artist_name text-truncate ml-2";
            span1.innerHTML = data.appendTextDisplay || data.text;
            let removeIcon = document.createElement("span");
            removeIcon.className = "pl-2 remove-chip";
            removeIcon.innerHTML = "&times;";
            let nameDiv = document.createElement("div");
            nameDiv.className =
                "d-flex justify-content-between text-truncate w-100";
            nameDiv.appendChild(span1);
            nameDiv.appendChild(removeIcon);
            divCon.appendChild(nameDiv);
            divChip.appendChild(divCon);
            appendHtml(divChip, data.status);
            reset();
            el.value = "";
            removeIcon.addEventListener("click", function () {
                removeId(data.id);
                divChip.remove();
            });
        },
        appendFrame: (data, willInsertId) => {
            if (ids.includes(data.id)) {
                toastr.error("Already added");
                return;
            }
            if (willInsertId) {
                addId(data.id);
            }

            let divChip = document.createElement("div");
            divChip.className =
                "d-flex flex-column align-items-center col-lg-2 col-md-3 col-4 my-2";

            let removeIcon = document.createElement("span");
            removeIcon.className = "pl-2 remove-frame";
            removeIcon.innerHTML = "&times;";

            let img = document.createElement("img");
            img.src = checkLogo(data.img, data.text);
            img.width = 64;
            img.height = 64;

            let imgCon = document.createElement("div");
            imgCon.className = "position-relative";
            imgCon.appendChild(img);
            imgCon.appendChild(removeIcon);
            divChip.appendChild(imgCon);

            let small = document.createElement("small");
            small.className = "w-100 text-truncate text-center";
            small.innerHTML = '<a class="text-dark">' + data.text + "</a>";
            divChip.appendChild(small);
            appendHtml(divChip, data.status);
            reset();
            el.value = "";
            removeIcon.addEventListener("click", function () {
                removeId(data.id);
                divChip.remove();
            });
        },
        showMap: (data, willInsertId) => {
            reset();
            el.value = data.name;
            selected = data.id;
            new ShowMap(data, opts.map).showInfoWindow();
        },
        custom: (data, customFunction, willInsertId) => {
            if (selectedDataLimit && ids.length >= selectedDataLimit) {
                toastr.error(dataLimitMessage);
                return;
            }
            if (ids.includes(data.id)) {
                toastr.error("Already added");
                return;
            }
            if (willInsertId) {
                addId(data.id);
            }
            reset();
            el.value = "";
            let onRemove = function () {
                removeId(data);
            };
            customFunction(data, onRemove);
        },
    };
    this.addParam = {};
    this.searchExcept = [];
    this.getElement=function(){
        return el;
    }

    this.updateType = (t) => {
        ids = [];
        type = t;
    };
    this.loadDataFromIds = (a_ids) => {
        a_ids.forEach((id) => {
            opts.searchableData.forEach((el) => {
                if (id == el.id) {
                    itemClick[opts.onClick](el);
                }
            });
        });
    };
    this.getDeleted = () => {
        return deletedIds;
    };
    this.addData = (d) => {
        let obj = getProp(d);
        console.log("obj", obj);
        if (!itemClick[opts.onClick]) {
            itemClick.custom(obj, opts[opts.onClick], false);
        } else {
            itemClick[opts.onClick](obj, false);
        }
        if (opts.onClick && obj.id) {
            loadedIds.push(obj.id);
        }
    };
    this.removeData = () => {
        appendDiv.innerHTML = "";
        ids = [];
    };
    this.setDataLimitMessage = (m) => {
        dataLimitMessage = m;
    };
    this.setSelectedDataLimit = (n) => {
        selectedDataLimit = n;
    };
    this.beforeSearch = (fun) => {
        beforeSearchFunction = fun;
    };
    this.loadIds = (idss) => {
        ids = idss;
    };
    this.getIds = () => {
        return ids;
    };
    this.activeIds = () => {

        let except = [..._this.searchExcept, ...ids, ...loadedIds];
        deletedIds.forEach((id) => {
            
            if (except.includes(id)) {
                except.splice(except.indexOf(id), 1);
            }
        });
        return except;
    };
    this.getSelected = () => {
        return selected;
    };
    this.setSelected = (s) => {
        selected = s;
    };
    this.addIdx = (id) => {
        selected = id;
        if (!loadedIds.includes(id)) {
            ids.push(id);
        }
        if (deletedIds.includes(id)) {
            deletedIds.splice(deletedIds.indexOf(id), 1);
        }
    }
}
function checkLogo(src, name){
    let imgsrc = src;
    if(imgsrc == null || imgsrc == ""){
        imgsrc = "https://ui-avatars.com/api/?name="+name+"&color=7F9CF5&background=EBF4FF";
    }
    else{
        if(imgsrc.substr(0, 4) !== "http"){
            imgsrc = window.location.origin+"/"+imgsrc;
        }
    }
    return imgsrc;
}
