$(function () {

    let here = document.getElementsByClassName('here')[0];
    if(here != undefined && here.getAttribute('title') == 'Computers' ){
        let fields = document.getElementsByClassName('justify-content-between');
        for (let field of fields) {
            let title = field.getAttribute('title');
            if(title !== 'Computer' &&  title !== 'Computers' && title !== 'Contracts' && title !== 'Tickets'){
                field.classList.add("d-none");
            }
        }
    }
});