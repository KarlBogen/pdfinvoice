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

// prüfen, ob Systemmodul installiert und Status true ist
if (defined('MODULE_PDFINVOICE_INVOICE_STATUS') && MODULE_PDFINVOICE_INVOICE_STATUS == 'true' && PDFINVOICE_USE_ORDERID == 'true') {

  if (strpos($_SERVER['PHP_SELF'], 'orders.php') !== false) {
?>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#buttons_block .ibillnr-btn').remove();
      });
    </script>
<?php
  }
}
