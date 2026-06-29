function Settings(){
    let fetching = false;
    
    this.update = function(data, callback){
        updateSettings(data, callback);
    }

    function updateSettings(data, callback){
        if(!fetching){
            fetching = true;
            let url = window.location.origin + "/settings/update";
            if(data.constructor === Array){
                url = window.location.origin + "/settings/update-multiple";
            }
            $('.spinner_modal').modal('show');
            fetch(url, {
                method: "POST",
                headers: {
                    Accept: "application/json, text/plain, */*",
                    "Content-Type": "application/json",
                    "X-CSRF-Token": document.querySelector('[name="csrf-token"]').content,
                },
                body: JSON.stringify(data),
            })
            .then(function (response) {
                fetching = false;
                $('.spinner_modal').modal('hide');
                if (!response.ok) {
                    throw new Error("HTTP status " + response.status);
                }
                return response.json();
            })
            .then(callback);
        }
    }
}