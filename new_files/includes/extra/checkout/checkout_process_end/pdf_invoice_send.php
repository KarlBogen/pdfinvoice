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

  // Rechnung wird nach der Bestellung als Anhang einer einzelnen Mail versandt - Vorlage mail/admin/invoice_mail.txt
  if (PDFINVOICE_SEND_ORDER == 'true' && PDFINVOICE_SEND_WITH_ORDER_MAIL != 'true') {
    xtc_pdf_invoice((int)$insert_id, true);
  }

  // Lieferschein wird nach der Bestellung als Anhang einer einzelnen Mail versandt - Vorlage mail/admin/invoice_mail.txt
  if (PDFINVOICE_SEND_SLIP_WITH_ORDER == 'true') {

    require_once(DIR_FS_INC . 'xtc_pdf_invoice.inc.php');

    xtc_pdf_invoice((int)$insert_id, true, true);
  }

  // Orderstatus wird automatisch upgedatet
  // Statusupdate muss nach checkout_process.php Anweisung "$payment_modules->after_process();" stehen
  // Hinweis: Einzelne Zahlmodule ändern Orderstatus
  if ($pdf_send_with_order_mail === true) {
    $orders_status_id = (is_numeric(PDFINVOICE_STATUS_ID_INVOICE)) ? PDFINVOICE_STATUS_ID_INVOICE : '1';

    $sql_data_array = array(
      'orders_id' => (int)$insert_id,
      'orders_status_id' => (int)$orders_status_id,
      'date_added' => 'now()',
      'customer_notified' => 1,
      'comments' => PDFINVOICE_STATUS_COMMENT,
    );
    xtc_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);

    if (PDFINVOICE_UPDATE_STATUS == 'true') {
      $sqlUpdateStatus = "UPDATE " . TABLE_ORDERS . " SET orders_status = '" . $orders_status_id . "' WHERE orders_id = '" . xtc_db_input($insert_id) . "'";
      $resUpdateStatus = xtc_db_query($sqlUpdateStatus);
    }
  }
}
