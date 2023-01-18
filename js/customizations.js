$(function () {

    let computerPageName = ['Computers', 'Ordinateurs'];

    let here = document.getElementsByClassName('here')[0];

    if(here != undefined && computerPageName.includes(here.getAttribute('title'))){

        let allowedValuesEng = ['Computer', 'Computers', 'Contracts', 'Tickets'];
        let allowedValuesFr = ['Ordinateur', 'Ordinateurs', 'Contrats', 'Tickets'];

        // fix menu for desktop
        let fields = document.getElementsByClassName('justify-content-between');
        if(fields != undefined){
            for (let field of fields) {
                let title = field.getAttribute('title');
                if((!allowedValuesEng.includes(title)) && (!allowedValuesFr.includes(title))){
                    field.classList.add("d-none");
                }
            }
        }

        // fix mobile dropdown menu
        let dropdown = document.getElementById('tabspanel-select');
        if(dropdown !== null){
            for(var i=0; i < dropdown.length; i++)
            {
               let item = dropdown.options[i].text;
                if((!allowedValuesEng.includes(item)) && (!allowedValuesFr.includes(item))){
                    dropdown.options[i].classList.add("d-none");
                    dropdown.options[i].selected = false;
                }
            }
            dropdown.options[0].selected = true;
        }
    }
});