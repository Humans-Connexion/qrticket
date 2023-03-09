<?php

// Non menu entry case
//header("Location:../../central.php");

include ('../../../inc/includes.php');

Session::checkRight("config", UPDATE);

// To be available when plugin is not activated
Plugin::load('qrticket');

Html::header(__('qrticket', 'qrticket'), $_SERVER['PHP_SELF'], "config", "plugins");
// $pbConfig = new PluginBarcodeConfig();
// $pbConfig->showForm('');

Html::footer();
