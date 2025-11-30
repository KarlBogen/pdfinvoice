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

if (
  defined('MODULE_PDFINVOICE_INVOICE_STATUS') && MODULE_PDFINVOICE_INVOICE_STATUS != 'false' &&
  (!defined('MODULE_INVOICE_NUMBER_STATUS') || strtolower(MODULE_INVOICE_NUMBER_STATUS) != 'true')
) {
  global $messageStack;
  $messageStack->add(PDFINVOICE_INVOICE_CHECK_MODUL_INVOICENUMBER, 'error');
}
