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

// reload, wenn iFrame geschlossen wird
$reload = (!isset($_GET['send']) && empty($order->info['ibn_billnr'])) ? true : false;

if (isset($_GET['send'])) {
  // erstellt und versendet PDF-Lieferschein
  $filePrefix = xtc_pdf_invoice($oID, true, true, true, true);

  // erstellt PDF-Lieferschein
} else {
  $filePrefix = xtc_pdf_invoice($oID, false, true);
}

if (MODULE_PDFINVOICE_INVOICE_DOWNLOAD_BY_REDIRECT == 'true' && function_exists('symlink')) {

  define('DIR_FS_INVOICE_PUBLIC', DIR_FS_DOCUMENT_ROOT . DIR_ADMIN  . 'pub/');
  require_once(DIR_FS_INC . 'xtc_random_name.inc.php');
  require_once(DIR_FS_INC . 'xtc_unlink_temp_dir.inc.php');

  // This will work only on Unix/Linux hosts
  xtc_unlink_temp_dir(DIR_FS_INVOICE_PUBLIC);
  $tempdir = xtc_random_name();
  umask(0000);
  mkdir(DIR_FS_INVOICE_PUBLIC . $tempdir, 0777);
  if (!symlink(DIR_FS_DOCUMENT_ROOT . DIR_ADMIN  . 'invoice/' . $filePrefix . '.pdf', DIR_FS_INVOICE_PUBLIC . $tempdir . '/' . $filePrefix . '.pdf')) {
    link(DIR_FS_DOCUMENT_ROOT . DIR_ADMIN  . 'invoice/' . $filePrefix . '.pdf', DIR_FS_INVOICE_PUBLIC . $tempdir . '/' . $filePrefix . '.pdf');
  }
} else {
  require_once(DIR_FS_INC . 'readfile_chunked.inc.php');
  //Set chunk size for download
  $chunksize = 1 * (1024 * 1024);
  // Now send the file with header() magic
  header("Expires: Mon, 26 Nov 1962 00:00:00 GMT");
  header("Last-Modified: " . gmdate("D,d M Y H:i:s") . " GMT");
  header("Cache-Control: no-cache, must-revalidate");
  header("Pragma: no-cache");
  header("Content-Type: Application/octet-stream");
  header("Content-Length: " . filesize(DIR_FS_DOCUMENT_ROOT . DIR_ADMIN  . 'invoice/' . $filePrefix . '.pdf'));
  header("Content-disposition: attachment; filename=\"" . $filePrefix . '.pdf' . "\"");
  // This will work on all systems, but will need considerable resources
  // We could also loop with fread($fp, 4096) to save memory
  readfile_chunked(DIR_FS_DOCUMENT_ROOT . DIR_ADMIN . 'invoice/' . $filePrefix . '.pdf', $chunksize);
  exit();
}

require(DIR_WS_INCLUDES . 'head.php');
?>
</head>

<body <?php if (isset($_GET['send'])) echo "onload='window.parent.location.reload();window.parent.iframeBox_close();'"; ?>>
  <table class="tableBody">
    <tr>
      <td class="boxCenter">
        <div class="pageHeadingImage"><?php echo xtc_image(DIR_WS_ICONS . 'heading/icon_configuration.png', PDFINVOICE_PRINT_PACKINGSLIP_PDFINVOICE_TITLE); ?></div>
        <div class="flt-l">
          <div class="pageHeading pdg2"><?php echo PDFINVOICE_PRINT_PACKINGSLIP_PDFINVOICE_TITLE; ?></div>
        </div>
        <div class="admin_container cf clear">
          <table class="clear tableConfig">
            <tr>
              <td class="dataTableConfig col-left"><?php echo PDFINVOICE_PRINT_PACKINGSLIP_SEND_TEXT; ?></td>
              <td class="dataTableConfig col-middle"><a class="button but_green" href="<?php echo $_SERVER['PHP_SELF']; ?>?oID=<?php echo $_GET['oID']; ?>&send=1"><?php echo PDFINVOICE_PRINT_PACKINGSLIP_SEND; ?></a></td>
            </tr>
            <tr>
              <td class="dataTableConfig col-left"><?php echo PDFINVOICE_PRINT_PACKINGSLIP_DL_TEXT; ?></td>
              <td class="dataTableConfig col-middle"><a class="button but_green" href="<?php echo 'pub/' . $tempdir . '/' . $filePrefix . '.pdf'; ?>"><?php echo PDFINVOICE_PRINT_PACKINGSLIP_DL; ?></a></td>
            </tr>
            <tr>
              <td class="txta-l" colspan="3" style="border:none;">
                <input class="button" type="button" value="<?php echo PDFINVOICE_CLOSE_WINDOW; ?>" onclick="<?php if ($reload === true) echo 'window.parent.location.reload();'; ?>window.parent.iframeBox_close();" />
              </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
  </table>
  <?php if ($reload === true) { ?>
    <script>
      $(document).ready(function() {
        $('.iframeBox_close', window.parent.document).attr('onclick', "window.parent.location.reload();iframeBox_close();");
        $('.iframeBox', window.parent.document).attr('onclick', "window.parent.location.reload();iframeBox_close();");
      });
    </script>
  <?php } ?>
</body>

</html>