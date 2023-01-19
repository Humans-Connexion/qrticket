# Customizations GLPI plugin

Customize computer's fields and add functionality for QR code creation.

IMPORTANT:: main folder should be renamed to customizations!

## Installation:
- download the archive file
- copy content of archive into your `glpi/plugins/` folder, rename the main folder to `customizations`. You should have a directory like this: `glpi/plugins/customizations/`.
- go to glpi plugins settings to install and enable the plugin.
- no additional configurations are needed. The fields in the Computers section will be filtered automaticaly and the QR code functionality will be added as menu item in the Action menu.

## GLPi compatibility:
Implemented with 10.0.5

## QR code creation functionality
The functionality for QR code creation could be found in the Actions menu - the last item in the menu (Customizations - Print QRcodes).