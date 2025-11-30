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

require('includes/application_top.php');

// include needed functions
require_once(DIR_FS_INC . 'xtc_php_mail.inc.php');
require_once(DIR_FS_INC . 'xtc_pdf_invoice.inc.php');

// classes in global scope
include_once(DIR_WS_CLASSES . 'order.php');
$order = new order((int)$_GET['oID']);
include_once(DIR_FS_CATALOG . DIR_WS_CLASSES . 'xtcPrice.php');
$xtPrice = new xtcPrice($order->info['currency'], $order->info['status']);

// check for oID
if (!isset($_GET['oID'])) {
  die('Something went wrong! No oID was given!');
} else {
  $oID = xtc_db_input($_GET['oID']);
}

if (isset($_GET['send'])) {
  // erstellt und versendet PDF-Rechnung
  $filePrefix = xtc_pdf_invoice($oID, true, false, true, true);

  // erstellt PDF-Rechnung
} else {
  $filePrefix = xtc_pdf_invoice($oID, false);
}

require(DIR_WS_INCLUDES . 'head.php');
?>
</head>

<body <?php if (isset($_GET['send'])) echo "onload='window.parent.location.reload();window.parent.iframeBox_close();'"; ?>>
  <table class="tableBody">
    <tr>
      <td class="boxCenter">
        <div class="pageHeadingImage"><?php echo xtc_image(DIR_WS_ICONS . 'heading/icon_configuration.png', PDFINVOICE_PRINT_ORDER_PDFINVOICE_TITLE); ?></div>
        <div class="flt-l">
          <div class="pageHeading pdg2"><?php echo PDFINVOICE_PRINT_ORDER_PDFINVOICE_TITLE; ?></div>
        </div>
        <div class="admin_container cf clear">
          <table class="clear tableConfig">
            <tr>
              <td class="dataTableConfig col-left"><?php echo PDFINVOICE_PRINT_ORDER_SEND_TEXT; ?></td>
              <td class="dataTableConfig col-middle"><a class="button but_green" href="<?php echo $_SERVER['PHP_SELF']; ?>?oID=<?php echo $_GET['oID']; ?>&send=1"><?php echo PDFINVOICE_PRINT_ORDER_SEND; ?></a></td>
            </tr>
            <tr>
              <td class="dataTableConfig col-left"><?php echo PDFINVOICE_PRINT_ORDER_DL_TEXT; ?></td>
              <td class="dataTableConfig col-middle"><a class="button but_green" href="invoice/<?php echo $filePrefix; ?>.pdf"><?php echo PDFINVOICE_PRINT_ORDER_DL; ?></a></td>
            </tr>
            <tr>
              <td class="txta-l" colspan="3" style="border:none;">
                <input class="button" type="button" value="<?php echo PDFINVOICE_CLOSE_WINDOW; ?>" onclick="window.parent.iframeBox_close();" />
              </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
  </table>
</body>

</html>