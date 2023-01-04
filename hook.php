<?php

/*
   ------------------------------------------------------------------------
   Customizations

   Copyright (C) 2023 by the Customizations plugin Development Team.

   ------------------------------------------------------------------------

   @package   Plugin Customizations
   @author    Sia Simeonova
   @since     2023

   ------------------------------------------------------------------------
 */

// Define actions :
function plugin_customizations_MassiveActions($itemtype) {
   $generate_qrcode_action  = 'PluginCustomizationsQRcode' . MassiveAction::CLASS_ACTION_SEPARATOR . 'Generate';
   $generate_qrcode_label   = '<i class="fas fa-qrcode"></i> ' . __('Customizations', 'qrcode')." - ".__('Print QRcodes', 'qrcode');

   if (!is_a($itemtype, CommonDBTM::class, true)) {
      return [];
   }

   return [ $generate_qrcode_action => $generate_qrcode_label ];
}

// Install process for plugin : need to return true if succeeded
function plugin_customizations_install() {
   if (!file_exists(GLPI_PLUGIN_DOC_DIR."/customizations")) {
      mkdir(GLPI_PLUGIN_DOC_DIR."/customizations");
   }

   return true;
}

// Uninstall process for plugin : need to return true if succeeded
function plugin_customizations_uninstall() {
   return true;
}