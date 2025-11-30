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

if (
  defined('MODULE_PDFINVOICE_INVOICE_STATUS')
  && MODULE_PDFINVOICE_INVOICE_STATUS == 'true'
) {

  require_once(DIR_FS_INC . 'xtc_pdf_invoice.inc.php');

  // Orderstatus nicht durch PDFInvoice updaten, wird von Order-Update erledigt
  $updateStatus = !$email_preview ? false : true;

  // sende Rechnung bei bestimmtem Orderstatus automatisch
  $sendBill = (is_numeric(PDFINVOICE_STATUS_SEND_ID)) ? (int)PDFINVOICE_STATUS_SEND_ID : 1;
  if (PDFINVOICE_STATUS_SEND == 'true' && isset($status) && $sendBill == $status) {
    xtc_pdf_invoice(xtc_db_prepare_input($_GET['oID']), true, false, $updateStatus);
  }

  // sende Lieferschein bei bestimmtem Orderstatus automatisch
  $sendSlip = (is_numeric(PDFINVOICE_STATUS_SEND_WITH_SLIP_ID)) ? (int)PDFINVOICE_STATUS_SEND_WITH_SLIP_ID : 1;
  if (PDFINVOICE_STATUS_SEND_WITH_SLIP == 'true' && isset($status) && $sendSlip == $status) {
    xtc_pdf_invoice(xtc_db_prepare_input($_GET['oID']), true, true, $updateStatus);
  }
}
