function hideMenuElements(){
    let allowedValuesEng = ['Computer', 'Computers', 'Contracts'];
    let allowedValuesFr = ['Ordinateur', 'Ordinateurs', 'Contrats'];

    // FIX DESKTOP DROPDOWN MENU
    let fields = document.getElementsByClassName('justify-content-between');
    if(fields != undefined){
        for (let field of fields) {
            let title = field.textContent.trim();
            if(
                (!allowedValuesEng.includes(title)) &&
                (!allowedValuesFr.includes(title)) &&
                (!title.includes('Tickets'))
            ){
                field.classList.add("d-none");
            }
        }
    }

    // FIX MOBILE DROPDOWN MENU
    let dropdown = document.getElementById('tabspanel-select');
    if(dropdown !== null){
        for(var i=0; i < dropdown.length; i++)
        {
            let item = dropdown.options[i].text;
            if((!allowedValuesEng.includes(item)) &&
                (!allowedValuesFr.includes(item)) &&
                (!item.includes('Tickets')))
            {
                dropdown.options[i].classList.add("d-none");
                dropdown.options[i].selected = false;
            }
        }
        dropdown.options[0].selected = true;
    }
}

function autoloadAssetInTicket(asset){
    document.getElementsByClassName('btn btn-sm btn-ghost-secondary mt-2')[0].click(); // click + button
    // Open assets dropdown
    let device = document.getElementById('tracking_my_devices');
    let elementRendered = device.getElementsByClassName('select2-selection__rendered')[0];
    let elementRenderedId = elementRendered.id;
    let random = elementRenderedId.replace('select2-dropdown_my_items','').replace('-container', '');

    let dropdownElementId = 'dropdown_my_items' + random;
    let dropdownElement = $('#' + dropdownElementId); // open asset dropdown
    dropdownElement.select2(); // initialise select2
    dropdownElement.select2('focus');
    dropdownElement.select2('open');

    var assetFound = false; // alert will be emitted if the asset has not been found
    let listItems = document.querySelectorAll('.select2-results__option');
        listItems.forEach((item, index) => {
            if (item.getAttribute('data-select2-id').endsWith(asset)) {
                assetFound = true;

                dropdownElement.val(asset);
                dropdownElement.trigger('change');

                let addButton = document.getElementsByClassName('btn btn-sm btn-outline-secondary')[0];
                addButton.click(); // add selected asset to the ticket
            }
        });

    dropdownElement.select2('close');

    if(!assetFound){
        alert(__('Asset not found!', 'customizations'));
    }
}

$(function () {
    let url = decodeURI(window.location.toString());
    let urlElements = url.split('=');
    console.log(urlElements)

    if(urlElements.length == 3 && urlElements[0].endsWith('/helpdesk.public.php?create_ticket') && urlElements[1]  ==  '1?asset'){
        autoloadAssetInTicket(urlElements[2]);
    } else if(urlElements.length == 2 && urlElements[0].endsWith('computer.form.php?id')){
        hideMenuElements();
    }
});
