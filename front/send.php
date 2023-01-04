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

include ('../../../inc/includes.php');

if (!defined("GLPI_PLUGIN_DOC_DIR")) {
    define("GLPI_PLUGIN_DOC_DIR", GLPI_ROOT . "/files/_plugins");
}
$docDir = GLPI_PLUGIN_DOC_DIR.'/customizations';

if (isset($_GET['file'])) {
   $filename = $_GET['file'];

   // Security test : document in $docDir
   if (strstr($filename, "../") || strstr($filename, "..\\")) {
      echo "Security attack !!!";
      Toolbox::logDebug("[Plugin customizations][security][sendfile] ".
               $_SESSION["glpiname"]." try to get a non standard file : ".$filename);
      exit;
   }

   $file = $docDir.'/'.$filename;
   if (!file_exists($file)) {
      echo "Error file $filename does not exist"; //TODO : traduire
   } else {
      // Now send the file with header() magic
      header("Expires: Mon, 26 Nov 1962 00:00:00 GMT");
      header('Pragma: private'); /// IE BUG + SSL
      //header('Pragma: no-cache');
      header('Cache-control: private, must-revalidate'); /// IE BUG + SSL
      header("Content-disposition: filename=\"$filename\"");
      header("Content-type: application/pdf");

      $f=fopen($file, "r");

      if (!$f) {
         echo "Error opening file $filename";
      } else {
         $fsize=filesize($file);

         if ($fsize) {
            echo fread($f, filesize($file));
         } else {
            echo 'error';
         }
      }
   }
}
