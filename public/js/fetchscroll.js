function FetchScroll(opts){
    let eventListeners = {};
    let next_page_url;
    let fetching = false;
    let lastRequestData = null;

    this.on=function(event, fun){
        eventListeners[event] = fun;
    }
    this.fetch=function(param, force){
        opts.data = param;
        if(fetching){
            lastRequestData={
                url: opts.url,
            };
        }
        get(window.location.origin+opts.url);
    }

    get(window.location.origin+opts.url);
    function get(url){
        if(!url || fetching){return}
        fetching = true;
        console.log("DATA", opts.data);
        if(eventListeners['beforeFetch']){
            eventListeners['beforeFetch']();
        }
        fetch(url, {
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
            return response.json();
        })
        .then(function(res){
            fetching = false;
            let other_params = {};
            let data = [];
            let isLastPage = false;
            if(res.paginationData){
                next_page_url = res.paginationData.next_page_url;
                data = res.paginationData.data;
                if(res.paginationData.to == res.paginationData.total){
                    isLastPage=true;
                }
                for (const key in res) {
                    if(key != "paginationData"){
                        other_params[key]=res[key];
                    }
                }
            }
            else{
                data = res.data;
                next_page_url = res.next_page_url;
                if(res.to == res.total){
                    isLastPage=true;
                }
            }
            
            console.log('fts',res);
            if(lastRequestData != null){
                let lastReqUrl = lastRequestData.url;
                lastRequestData = null;
                get(lastReqUrl);
            }
            else{
                if(eventListeners['fetch']){
                    eventListeners['fetch'](data, isLastPage, other_params);
                }
            }
        });
    }

    if(opts.container){
        opts.container.addEventListener("scroll", function() {
            if(this.scrollHeight - this.scrollTop - this.clientHeight < 30){
                console.log('bottom-div');
                get(next_page_url);
            }
        });
    }
    else{
        window.onscroll = function(ev) {
            if ((window.innerHeight + window.scrollY) >= document.body.scrollHeight - 30) {
                console.log('bottom-doc');
                get(next_page_url);
            }
        };
    }
   
}