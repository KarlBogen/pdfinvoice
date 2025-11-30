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

if (
  defined('MODULE_PDFINVOICE_INVOICE_STATUS')
  && MODULE_PDFINVOICE_INVOICE_STATUS == 'true'
) {

  $pdf_send_with_order_mail = false;

  // Rechnung wird als Anhang der Bestellbestätigung versandt
  if (PDFINVOICE_SEND_ORDER == 'true') {

    require_once(DIR_FS_INC . 'xtc_pdf_invoice.inc.php');

    if (PDFINVOICE_SEND_WITH_ORDER_MAIL != 'false') {

      $filePrefix = xtc_pdf_invoice((int)$insert_id);

      if ($filePrefix != '') {
        $filename = DIR_FS_DOCUMENT_ROOT . DIR_ADMIN  . 'invoice/' . $filePrefix . '.pdf';
        if ($email_attachments != '') {
          $email_attachments = str_replace('::', '::' . $filename . ',', $email_attachments);
        } else {
          $email_attachments = $filename;
        }
      }
      $pdf_send_with_order_mail = true;
    }
  }
}
