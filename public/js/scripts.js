setMaxAndMinInputDate();
function setMinDateInput(element, min_date){
    element.setAttribute('min', min_date);
    element.onfocusout=function(){
        if(this.value < min_date){
            toastr.error('Minimum date is '+min_date);
            this.value="";
        }
    }
}
function setMaxDateInput(element, max_date){
    element.setAttribute('max', max_date);
    element.onfocusout=function(){
        if(this.value >= max_date){
            toastr.error('Maximum date is '+max_date);
            this.value="";
        }
    }
}

function setMaxAndMinInputDate(){
    let date_inputs = document.querySelectorAll('[data-min-date], [data-max-date]');
    for (let i = 0; i < date_inputs.length; i++) {
        const element = date_inputs[i];
        let min_date = element.getAttribute('data-min-date');
        let max_date = element.getAttribute('data-max-date');
        if(min_date){
            setMinDateInput(element, min_date);
        }
        if(max_date){
            setMaxDateInput(element, max_date)
        }
    }
}