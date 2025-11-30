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
?>

  <div class="div_box mrg5">
    <!-- BOC BUTTONS BLOCK -->
    <table class="table" style="margin-bottom:10px;border: none !important;">
      <tr>
        <td>
          <div class="flt-l">
            <strong><?php echo BUTTON_GROUP_PDFINVOICE_INVOICE_TITLE ?></strong>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="flt-l">
            <a class="button" href="<?php echo xtc_href_link(FILENAME_ORDERS, 'oID=' . $oID . ((isset($_GET['page'])) ? '&page=' . $_GET['page'] : '')); ?>"><?php echo BUTTON_BACK; ?></a>
          </div>
          <div class="flt-r">
            <?php
            include_once(DIR_WS_MODULES . 'iframe_box.php');
            if ($order->info['ibn_billnr'] != '') {
            ?>
              <span style="padding:5px; position:relative; top:4px; font-size:9pt; border:1px solid #aaaaaa; background-color: #ffffff;"><?php echo BUTTON_INVOICE_NR . ' ' . $order->info['ibn_billnr']; ?></span>
            <?php
              echo '<a class="button but_green" href="javascript:iframeBox_show(0, \'' . BUTTON_GROUP_PDFINVOICE_INVOICE_TITLE . '\',\'' . FILENAME_PRINT_ORDER_PDFINVOICE . '\', \'&oID=' . $_GET['oID'] . '\');" >' . BUTTON_INVOICE_PDF . '</a>';
            } else {
              echo '<a class="button ibillnr-btn" href="' . xtc_href_link(FILENAME_ORDERS, xtc_get_all_get_params(array('oID', 'action')) . 'oID=' . $oID . '&action=custom&subaction=set_pdfinvoice_ibillnr') . '">' . BUTTON_BILL . '</a>';
            }
            echo '<a class="button but_green" href="javascript:iframeBox_show(0, \'' . BUTTON_GROUP_PDFINVOICE_INVOICE_TITLE . '\',\'' . FILENAME_PRINT_PACKINGSLIP_PDFINVOICE . '\', \'&oID=' . $_GET['oID'] . '\');" >' . BUTTON_PACKINGSLIP_PDF . '</a>';
            ?>
          </div>
        </td>
      </tr>
    </table>
    <!-- EOC BUTTONS BLOCK -->
  </div>
<?php
}
