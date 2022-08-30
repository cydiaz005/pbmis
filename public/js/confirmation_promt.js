function PromptConfirmation(id, opts){
    let modal = document.querySelector(id);
    let btn_pos = modal.querySelector('.btn-pos');
    let fetching = false;
    let setInnerHtml=function(el, text){
        if(text){
            el.innerHTML=text;
        }
    }
    setInnerHtml(btn_pos, opts.btnText);
    setInnerHtml(modal.querySelector('.cnfrmodal_title'), opts.title);
    setInnerHtml(modal.querySelector('.cnfrmodal_text'), opts.message);
    if(opts.matchString){
        let text = document.querySelector('#match-string');
        text.value='';
        document.querySelector('#match-string-display').innerHTML=opts.matchString;
        btn_pos.onclick=function(){
            if(text.value===opts.matchString){
                sendRequest();
            }
            else{
                $(id).modal('hide');
            }
        }
    }
    else{
        btn_pos.onclick=sendRequest;
    }
    $(id).modal('show');
    function sendRequest(){
        $(id).modal('hide');
        if(!opts.url){
            opts.done();
        }
        else if(opts.redirect){
            window.location.href = window.location.origin+opts.url;
        }
        else{
            $('.spinner_modal').modal('show');
            if (!fetching) {
                fetching = true;
                fetch(window.location.origin+opts.url, {
                    method: opts.method || "post",
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
                .then(function (res) {
                    fetching = false;
                    $('.spinner_modal').modal('hide');
                    opts.done(res);
                });
            }
        }
    }
}