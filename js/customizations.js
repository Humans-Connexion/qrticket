$(function () {

    let here = document.getElementsByClassName('here')[0];

    if(here != undefined && here.getAttribute('title') == 'Computers' ){ // English
        let fields = document.getElementsByClassName('justify-content-between');
        for (let field of fields) {
            let title = field.getAttribute('title');
            if(title !== 'Computer' &&  title !== 'Computers' && title !== 'Contracts' && title !== 'Tickets'){
                field.classList.add("d-none");
            }
        }
    }else if(here != undefined && here.getAttribute('title') == 'Ordinateurs'){ // French
        let fields = document.getElementsByClassName('justify-content-between');
        for (let field of fields) {
            let title = field.getAttribute('title');
            if(title !== 'Ordinateur' &&  title !== 'Ordinateurs' && title !== 'Contrats' && title !== 'Tickets'){
                field.classList.add("d-none");
            }
        }
    }
});