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

define ("PLUGIN_CUSTOMIZATIONS_VERSION", "0.3.3");

// Minimal GLPI version, inclusive
define('PLUGIN_CUSTOMIZATIONS_MIN_GLPI', '10.0.0');
// Maximum GLPI version, exclusive
define('PLUGIN_CUSTOMIZATIONS_MAX_GLPI', '10.0.99');

// Init the hooks of the plugins -Needed
function plugin_init_customizations() {
   global $PLUGIN_HOOKS;

   require_once(__DIR__ . '/vendor/autoload.php');

   $PLUGIN_HOOKS['csrf_compliant']['customizations'] = true;

   $PLUGIN_HOOKS['use_massive_action']['customizations'] = 1;

   $PLUGIN_HOOKS['add_javascript']['customizations'] = array('js/customizations.js');
}

function plugin_version_customizations() {

   return [
      'name'           => 'Customizations',
      'shortname'      => 'customizations',
      'version'        => PLUGIN_CUSTOMIZATIONS_VERSION,
      'author'         => '<a href="mailto:s.simeonova@tinqin.com">Sia Simeonova</a>',
      'requirements'   => [
         'glpi' => [
            'min' => PLUGIN_CUSTOMIZATIONS_MIN_GLPI,
            'max' => PLUGIN_CUSTOMIZATIONS_MAX_GLPI,
         ]
      ]
   ];
}
