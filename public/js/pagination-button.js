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
    let ul = createElement('ul', 'pagination float-right');
    
    for (let i = 0; i < opts.links.length; i++) {
        const element = opts.links[i];
        let li =  createElement('li', 'page-item');
        let a = createElement('a', 'page-link', element.label);
        // a.href = element.url;
        li.appendChild(a);
        ul.appendChild(li);
        a.onclick=function(){
            renderEvent('click', element.url);
        }
    }
    container.appendChild(ul);


    this.on=function(e,f){
        eventListeners[e]=f;
    }
    function renderEvent(e, params){
        if(eventListeners[e]){
            eventListeners[e](params);
        }
    }
}