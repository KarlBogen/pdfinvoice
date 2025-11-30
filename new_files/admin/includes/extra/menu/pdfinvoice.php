<?php
/* ------------------------------------------------------------
  Module "PDFInvoice" made by Karl

  based on
  PDFInvoice NEXT by Robert Hoppe by Robert Hoppe
  Copyright 2011 Robert Hoppe - xtcm@katado.com - http://www.katado.com
  and
  (c) 2015 ralph_84

  modified eCommerce Shopsoftware
  http://www.modified-shop.org

  Released under the GNU General Public License
-------------------------------------------------------------- */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

if (defined('MODULE_PDFINVOICE_INVOICE_STATUS') && MODULE_PDFINVOICE_INVOICE_STATUS == 'true') {

  //Sprachabhaengiger Menueeintrag, kann fuer weiter Sprachen ergaenzt werden
  switch ($_SESSION['language_code']) {
    case 'de':
      define('MENU_NAME_PDFINVOICE', 'PDF Rechnung - Konfiguration ');
      break;
    case 'en':
      define('MENU_NAME_PDFINVOICE', 'PDF Invoice - Configuration ');
      break;
    default:
      define('MENU_NAME_PDFINVOICE', 'PDF Rechnung - Konfiguration ');
      break;
  }

  // select configuration_group_id dynamically, noRiddle
  $pdf_gr_id_qu = xtc_db_query("SELECT configuration_group_id FROM " . TABLE_CONFIGURATION_GROUP . " WHERE configuration_group_title = 'PDFInvoice Configuration'");
  if (xtc_db_num_rows($pdf_gr_id_qu)) {
    $pdf_gr_id_arr = xtc_db_fetch_array($pdf_gr_id_qu);
    //BOX_HEADING_TOOLS = Name der box in der der neue Menueeintrag erscheinen soll
    $add_contents[BOX_HEADING_CONFIGURATION][] = array(
      'admin_access_name' => 'configuration',   //Eintrag fuer Adminrechte
      'filename' => 'configuration.php?gID=' . $pdf_gr_id_arr['configuration_group_id'],        //Dateiname der neuen Admindatei
      'boxname' => MENU_NAME_PDFINVOICE,     //Anzeigename im Menue
      'parameters' => '',                  //zusaetzliche Parameter z.B. 'set=export'
      'ssl' => ''                         //SSL oder NONSSL, kein Eintrag = NONSSL
    );
  }
}
