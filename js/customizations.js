function hideMenuElements(){
    let computerPageName = ['Computers', 'Ordinateurs'];

    let pageName = document.getElementsByClassName('here')[0];

    // HIDING OF MENU ELEMENTS
    if(pageName != undefined && computerPageName.includes(pageName.getAttribute('title'))){
        let allowedValuesEng = ['Computer', 'Computers', 'Contracts'];
        let allowedValuesFr = ['Ordinateur', 'Ordinateurs', 'Contrats'];

        // fix menu for desktop
        let fields = document.getElementsByClassName('justify-content-between');
        if(fields != undefined){
            for (let field of fields) {
                let title = field.textContent.trim();
                console.log(title);
                if(
                    (!allowedValuesEng.includes(title)) &&
                    (!allowedValuesFr.includes(title)) &&
                    (!title.includes('Tickets'))
                ){
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
}

function autoloadAssetInTicket(){
    let ticketPageTitle = 'ticket - glpi';
    let mobilePageTitle = 'ticket - new item - glpi';
    let mobilePageTitleFr = 'ticket - nouvel élément - glpi';

    let headerTitle = document.title.toLowerCase();

    if(headerTitle.includes(ticketPageTitle) || headerTitle.includes(mobilePageTitle) || headerTitle.includes(mobilePageTitleFr)){
        let url = decodeURI(window.location.toString());
        let params  = url.split('asset=');

        if(params[1]){ // case QR code scanned & arguments in the URL
        let asset = params[1];

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
                if (item.innerHTML.indexOf(asset) != -1) {
                    assetFound = true;
                    let valueArray = item.id.split("-");
                    if(valueArray.length > 1){
                        let value = valueArray.pop();

                        dropdownElement.val(value);
                        dropdownElement.trigger('change');
                    }

                    let addButton = document.getElementsByClassName('btn btn-sm btn-outline-secondary')[0];
                    addButton.click(); // add selected asset to the ticket
                }
            });

            dropdownElement.select2('close');

            if(!assetFound){
                alert('Asset "' + asset + '" not found!');
            }
        }
    }
}

$(function () {
    hideMenuElements();

    autoloadAssetInTicket();
});
