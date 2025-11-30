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

function xtc_pdf_invoice($oID, $send = false, $deliverSlip = false, $updateStatus = true, $onlysend = false)
{
  global $order, $xtPrice;

  require_once(DIR_FS_EXTERNAL . 'pdfinvoice/makePdf.php');
  $pdfdata = new makePdf($oID, $deliverSlip);

  if ($onlysend === false) {
    $pdfdata->createPdfData($oID, $deliverSlip);

    $filePrefix = $pdfdata->generatePdf($deliverSlip);
  }

  if ($send === true) {
    $pdfdata->sendPdf($oID, $deliverSlip, $updateStatus);
  }

  // we need the filename, if the pdf is attachment
  return $filePrefix;
}
