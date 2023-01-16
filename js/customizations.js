$(function () {

    let fields = document.getElementsByClassName('justify-content-between');
    for (let field of fields) {
        let title = field.getAttribute('title');
        if(title !== 'Computers' && title !== 'Contracts' && title !== 'Tickets'){
            field.classList.add("d-none");
        }
    }
});