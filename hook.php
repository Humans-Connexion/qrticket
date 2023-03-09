<?php

/*
   ------------------------------------------------------------------------
   QRTicket

   Copyright (C) 2023 by the Human's Connexion Development Team.

   ------------------------------------------------------------------------

   @package   Plugin QRTicket
   @author    Sia Simeonova
   @since     2023

   ------------------------------------------------------------------------
 */

// Define actions :
function plugin_qrticket_MassiveActions($itemtype) {
   $generate_qrcode_action  = 'PluginQrticketQRcode' . MassiveAction::CLASS_ACTION_SEPARATOR . 'Generate';
   $generate_qrcode_label   = '<i class="fas fa-qrcode"></i> ' . __('QRTicket', 'qrticket')." - ".__('Print QRcodes', 'qrticket');

   if (!is_a($itemtype, CommonDBTM::class, true)) {
      return [];
   }

   return [ $generate_qrcode_action => $generate_qrcode_label ];
}

// Install process for plugin : need to return true if succeeded
function plugin_qrticket_install() {
   if (!file_exists(GLPI_PLUGIN_DOC_DIR."/qrticket")) {
      mkdir(GLPI_PLUGIN_DOC_DIR."/qrticket");
   }

   return true;
}

// Uninstall process for plugin : need to return true if succeeded
function plugin_qrticket_uninstall() {
   return true;
}