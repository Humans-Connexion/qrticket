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

// Non menu entry case
//header("Location:../../central.php");
include ('../../../inc/includes.php');
// Session::checkRight("config", UPDATE);
// To be available when plugin is not activated
Plugin::load('qrticket');
Html::header(__('QRTicket', 'qrticket'), $_SERVER['PHP_SELF'], "config", "plugins");
$itemtype = $_GET['itemtype'];
$item = new $itemtype();
$itemInventoryNumber[] = $_GET['inventoryNumber'];
foreach ($itemInventoryNumber as $key => $value) {
   if ($item->getFromDBByCrit(['otherserial' => $value])) {
      Html::redirect($item->getFormURLWithID($item->getID()));
   } else {
      Html::displayErrorAndDie(__('No item found'), true);
   }
};
Html::footer();
