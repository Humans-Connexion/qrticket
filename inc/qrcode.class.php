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

if (!defined('GLPI_ROOT')) {
    die("You can't access directly to this file");
}

class PluginCustomizationsQRcode {

   const DOC_PATH = GLPI_PLUGIN_DOC_DIR.'/customizations/';

   const FILE_EXTENSION = 'png';
   const CONFIGS = [
      'type' => 'QRcode', 
      'size' => 'A4', 
      'orientation' => 'Portrait',
      'marginTop' => '30', 
      'marginBottom' => '30', 
      'marginLeft' => '30', 
      'marginRight' => '30',
      'marginHorizontal' => '25', 
      'marginVertical' => '30', 
      'maxCodeWidth' => '110', 
      'maxCodeHeight' => '100',
      'txtSize' => '8',
      'txtSpacing' => '3'
   ];

   static function generateQRcode($itemType, $itemId, $rand, $number, $data) {
      global $CFG_GLPI;

      /** @var CommonDBTM $item */
      $item = new $itemType();
      $item->getFromDB($itemId);

      $URLById= 'URL = ' . $CFG_GLPI['url_base'] . "/front/helpdesk.public.php?create_ticket=1" . "?asset=" . $itemType . 's' . " - " .  $item->fields['name'] . " - " . $item->fields['serial'] . " - " . $item->fields['otherserial'];
      $a_content = [];

      $b_content = [];
 
      if ($data['id']) {
         $a_content[] = ('ID').' = '.$item->fields['id'];
         if ($data['displayid']) {
            $label = ('ID').': ';
            $b_content[] = $label.$item->fields['id'];
         }
      }

      if ($data['displayname']) {
         $label = ('Item Name').': ';
         $b_content[] = $label.$item->fields['name'];
      }

      if ($data['url']  && !$item->no_form_page) {
            $a_content[] = $URLById;
      }

      if (count($a_content) > 0) {
         $codeContents = implode("\n", $a_content);
         QRcode::png($codeContents,
                     GLPI_PLUGIN_DOC_DIR.'/customizations/_tmp_'.$rand.'-'.$number.'.png',
                     QR_ECLEVEL_L,
                     4);
         return [GLPI_PLUGIN_DOC_DIR.'/customizations/_tmp_'.$rand.'-'.$number.'.png',$b_content];
      }
      return false;
   }

   static function cleanQRcodeFiles($rand, $number) {
      for ($i = 0; $i < $number; $i++) {
         unlink(GLPI_PLUGIN_DOC_DIR.'/customizations/_tmp_'.$rand.'-'.$i.'.png');
      }
   }

   function showFormMassiveAction(MassiveAction $ma) {

      $fields       = [];
      $no_form_page = true;

      $itemtype = $ma->getItemtype(false);
      if (is_a($itemtype, CommonDBTM::class, true)) {
         /** @var CommonDBTM $item */
         $item = new $itemtype();
         $item->getEmpty();
         $fields = array_keys($item->fields);
         $no_form_page = $item->no_form_page;
      }

      echo '<input type="hidden" name="type" value="QRcode" />';
      echo '<center>';
      echo '<table>';

      echo '<tr>';
      echo '<td>';
      echo ('ID')." : </td><td>";
      Dropdown::showYesNo("id", 1, -1, ['width' => '100']);
      echo '</td>';
      echo '<td>';
      echo ('Display ID')." : </td><td>";
      Dropdown::showYesNo("displayid", 0, -1, ['width' => '100']);
      echo '</td>';
      echo '</tr>';

      if (in_array('name', $fields)) {
         echo '<tr>';
         echo '<td>';
         echo ('Name')." : </td><td>";
         Dropdown::showYesNo("name", 1, -1, ['width' => '100']);
         echo '</td>';
         echo '<td>';
         echo ('Display name')." : </td><td>";
         Dropdown::showYesNo("displayname", 1, -1, ['width' => '100']);
         echo '</td>';
         echo '</tr>';
      } else {
         echo Html::hidden('name', ['value' => 0]);
      }

      echo '<tr>';
      echo '<td>';
      echo ('Web page of the device')." : </td><td>";
      Dropdown::showYesNo("url", 1, -1, ['width' => '100']);
      echo '</td>';

      echo '</tr>';

      if (!$no_form_page) {
         echo '<tr>';
         echo '<td>';
         echo ('Web page of the item')." : </td><td>";
         Dropdown::showYesNo("url", 1, -1, ['width' => '100']);
         echo '</td>';
         echo '</tr>';
      } else {
         echo Html::hidden('url', ['value' => 0]);
      }

      echo '</table>';
      echo '<br/>';

      echo Html::submit(__('Create', 'barcode'), ['value' => 'create']);
   }

   function getSpecificMassiveActions($checkitem = null) {
      return [];
   }

   /**
    * @see CommonDBTM::showMassiveActionsSubForm()
   **/
   static function showMassiveActionsSubForm(MassiveAction $ma) {
      switch ($ma->getAction()) {
         case 'Generate':
            $pbQRcode = new self();
            $pbQRcode->showFormMassiveAction($ma);
            return true;

      }
      return false;
   }

   static function processMassiveActionsForOneItemtype(MassiveAction $ma, CommonDBTM $item, array $ids) {
      global $CFG_GLPI;

      switch ($ma->getAction()) {

         case 'Generate' :
            $rand     = mt_rand();
            $number   = 0;
            $codes    = [];
            $displayDataCollection = [];
            if ($ma->POST['eliminate'] > 0) {
               for ($nb=0; $nb < $ma->POST['eliminate']; $nb++) {
                  $codes[] = '';
                  $displayDataCollection[] = '';
               }
            }

               foreach ($ids as $key) {
                  $values = static::generateQRcode($item->getType(), $key, $rand, $number, $ma->POST);
                  $filename    = $values[0];
                  $displayData = $values[1];
                  if ($filename) {
                     $codes[] = $filename;
                     $displayDataCollection[] = $displayData;
                     $number++;
                  }
               }

            if (count($codes) > 0) {
               $params['codes']       = $codes;
               $params['displayData'] = $displayDataCollection;
               $params['type']        = $ma->POST['type'];
               $params['size']        = $ma->POST['size'];
               $params['border']      = $ma->POST['border'];
               $params['orientation'] = $ma->POST['orientation'];
               $file                  = static::printPDF($params);
               $filePath              = explode('/', $file);
               $filename              = $filePath[count($filePath)-1];

               $msg = "<a href='".Plugin::getWebDir('customizations').'/front/send.php?file='.urlencode($filename)."'>".__('Generated file', 'customizations')."</a>";
               Session::addMessageAfterRedirect($msg);
               static::cleanQRcodeFiles($rand, $number);
            }
            $ma->itemDone($item->getType(), 0, MassiveAction::ACTION_OK);

            break;

      }
      return;
   }

   static function printPDF($p_params) {
      $type        = $p_params['type'];
      $size        = $p_params['size'];
      $orientation = $p_params['orientation'];
      $codes       = [];

      $displayDataCollection = $p_params['displayData'] ?? [];

      $codes = $p_params['codes'];

      // create pdf
      // x is horizontal axis and y is vertical
      // x=0 and y=0 in bottom left hand corner
      $config = self::CONFIGS;

      $pdf = new Cezpdf($size, $orientation);
      $pdf->tempPath = GLPI_TMP_DIR;
      $pdf->selectFont(Plugin::getPhpDir('customizations')."/lib/ezpdf/fonts/Helvetica.afm");
      $pdf->ezSetMargins($config['marginTop'], $config['marginBottom'], $config['marginLeft'], $config['marginRight']);
      $pdf->ezStartPageNumbers($pdf->ez['pageWidth']-30, 10, 10, 'left', '{PAGENUM} / {TOTALPAGENUM}').
      $width   = $config['maxCodeWidth'];
      $height  = $config['maxCodeHeight'];
      $marginH = $config['marginHorizontal'];
      $marginV = $config['marginVertical'];
      $txtSize    = $config['txtSize'];
      $txtSpacing = $config['txtSpacing'];

      $heightimage = $height;

      $first=true;
      for ($ia = 0; $ia < count($codes); $ia++) {
         $code = $codes[$ia];
         $displayData = $displayDataCollection[$ia] ?? [];
         if ($first) {
            $x = $pdf->ez['leftMargin'];
            $y = $pdf->ez['pageHeight'] - $pdf->ez['topMargin'] - $height;
            $first = false;
         } else {
            if ($x + $width + $marginH > $pdf->ez['pageWidth']) { // new line
               $x = $pdf->ez['leftMargin'];
               if ($y - $height - $marginV < $pdf->ez['bottomMargin']) { // new page
                  $pdf->ezNewPage();
                  $y = $pdf->ez['pageHeight'] - $pdf->ez['topMargin'] - $height;
               } else {
                  $y -= $height + $marginV;
               }
            }
         }
         if ($code != '') {
               $imgFile = $code;
           
            if (file_exists($imgFile)) {
               $imgSize   = getimagesize($imgFile);
               $imgWidth  = $imgSize[0];
               $imgHeight = $imgSize[1];
               if ($imgWidth > $width) {
                  $ratio     = (100 * $width ) / $imgWidth;
                  $imgWidth  = $width;
                  $imgHeight = $imgHeight * ($ratio / 100);
               }
               if ($imgHeight > $heightimage) {
                  $ratio     = (100 * $heightimage ) / $imgHeight;
                  $imgHeight = $heightimage;
                  $imgWidth  = $imgWidth * ($ratio / 100);
               }

               $image = imagecreatefrompng($imgFile);
               if ($imgWidth < $width) {
                  $pdf->addImage($image,
                                 $x + (($width - $imgWidth) / 2),
                                 $y,
                                 $imgWidth,
                                 $imgHeight);
               } else {
                  $pdf->addImage($image,
                                 $x,
                                 $y,
                                 $imgWidth,
                                 $imgHeight);
               }

               $txtHeight = 0;
               for ($i = 0; $i < count($displayData); $i++) {
                   $pdf->addTextWrap(
                       $x,
                       $y - ($txtSpacing + $txtHeight),
                       $txtSize,
                       $displayData[$i],
                       $width,
                       'center');
                   $txtHeight += $txtSpacing/2 + $txtSize;
               }
               if ($p_params['border']) {
                  $pdf->Rectangle($x, $y - ($txtHeight + $txtSpacing*2),
                       $width, $height + ($txtHeight + $txtSpacing*2));
               }
            }
         }
         $x += $width + $marginH;
         $y -= 0;
      }
      $file    = $pdf->ezOutput();
      $pdfFile = $_SESSION['glpiID'].'_'.$type.'.pdf';

      file_put_contents(static::DOC_PATH.$pdfFile, $file);
      return '/files/_plugins/customizations/'.$pdfFile;
   }

   function create($p_code, $p_type, $p_ext) {
      if (!file_exists(static::DOC_PATH.$p_code.'_'.$p_type.'.'.$p_ext)) {
         ob_start();
         $barcode = new Image_Barcode();
         $resImg  = @imagepng(
            @$barcode->draw($p_code, $p_type, $p_ext, false)
         );
         $img = ob_get_clean();
         file_put_contents(static::DOC_PATH.$p_code.'_'.$p_type.'.'.$p_ext, $img);
         if (!$resImg) {
            return false;
         }
      }
      return true;
   }

}
