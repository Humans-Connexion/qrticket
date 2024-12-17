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

define ("PLUGIN_QRTICKET_VERSION", "0.4.4");

// Minimal GLPI version, inclusive
define('PLUGIN_QRTICKET_MIN_GLPI', '10.0.17');
// Maximum GLPI version, exclusive
define('PLUGIN_QRTICKET_MAX_GLPI', '10.1.0');

// Init the hooks of the plugins -Needed
function plugin_init_qrticket() {
   global $PLUGIN_HOOKS;

   require_once(__DIR__ . '/vendor/autoload.php');

   $PLUGIN_HOOKS['csrf_compliant']['qrticket'] = true;

   $PLUGIN_HOOKS['use_massive_action']['qrticket'] = 1;

   $PLUGIN_HOOKS['add_javascript']['qrticket'] = array('js/qrticket.js');
}

function plugin_version_qrticket() {

   return [
      'name'           => 'qrticket',
      'shortname'      => 'qrticket',
      'version'        => PLUGIN_QRTICKET_VERSION,
      'author'         => '<a href="mailto:s.simeonova@tinqin.com">Sia Simeonova</a>',
      'requirements'   => [
         'glpi' => [
            'min' => PLUGIN_QRTICKET_MIN_GLPI,
            'max' => PLUGIN_QRTICKET_MAX_GLPI,
         ]
      ]
   ];
}
