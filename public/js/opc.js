function OPC(){
    let createElement = function (el, className, innerHTML) {
        let element = document.createElement(el);
        if(className)
        element.className = className;
        if (innerHTML)
        element.innerHTML = innerHTML;
        return element;
    }

    function generateHeaders(){
        let texts1 = ["Major Final Outputs", "PERFORMANCE MEASURES", "PERFORMANCE TARGETS", "SUCCESS INDICATOR Measures + Targets", "Outstanding", ""];
    }



    this.get=function(url, data=false){
        let props = {
            url: url || '/form/opc/fetch',
            done: function(res){
               console.log("OPC Result",res);
            }
        }
        if(data){
            props['data']=data;
        }
        new HttpRequest(props);
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
        fetch(window.location.origin+opts.url, headers)
        .then(function (response) {
            if (!response.ok) {
                throw new Error("HTTP status " + response.status);
            }
            return response.json();
        })
        .then(opts.done);
    }
    
}