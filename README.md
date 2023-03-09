# QRTicket GLPI plugin

Customize computer's fields and add functionality for QR code creation.

IMPORTANT:: main folder should not be renamed!

## Installation:
- download the archive file
- copy the content of the archive into your `glpi/plugins/` folder. You should have a directory like this: `glpi/plugins/qrticket/`.
- go to glpi plugins settings to install and enable the plugin.
- no additional configurations are needed. The fields in the Computers section will be filtered automaticaly and the QR code functionality will be added as menu item in the Action menu.

## GLPI compatibility:
Implemented with 10.0.5

## QR code creation functionality
The functionality for QR code creation could be found in the Actions menu - the last item in the menu (QRTicket - Print QRcodes).