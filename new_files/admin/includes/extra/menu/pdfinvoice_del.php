<?php
/* ------------------------------------------------------------
  Module "PDFInvoice" made by Karl

  based on
  PDFBill NEXT by Robert Hoppe by Robert Hoppe
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
      define('MENU_NAME_PDFINVOICE_DEL', 'PDF Rechnung - Dateien L&ouml;schen ');
      break;
    case 'en':
      define('MENU_NAME_PDFINVOICE_DEL', 'PDF Invoice Files Delete ');
      break;
    default:
      define('MENU_NAME_PDFINVOICE_DEL', 'PDF Invoice Dateien L&ouml;schen ');
      break;
  }

  //BOX_HEADING_TOOLS = Name der box in der der neue Menueeintrag erscheinen soll
  $add_contents[BOX_HEADING_TOOLS][] = array(
    'admin_access_name' => 'pdfinvoice_del',   //Eintrag fuer Adminrechte
    'filename' => 'pdfinvoice_del.php',        //Dateiname der neuen Admindatei
    'boxname' => MENU_NAME_PDFINVOICE_DEL,     //Anzeigename im Menue
    'parameters' => '',                  //zusaetzliche Parameter z.B. 'set=export'
    'ssl' => ''                         //SSL oder NONSSL, kein Eintrag = NONSSL
  );
}
