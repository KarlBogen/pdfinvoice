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

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

// Code wurde hauptsächlich aus "admin/print_order.php" gemischt mit "admin/print_packingslip.php" übernommen

class makePdf
{

  var $fileprefix;
  var $filename;
  var $pdfhtml;

  function __construct($oID, $deliverSlip = false)
  {
    global $order;

    $this->filePrefix = $this->createFilePrefix($deliverSlip);

    // Dateiname für Rechnung und Lieferschein
    $this->filename = DIR_FS_DOCUMENT_ROOT . DIR_ADMIN  . 'invoice/' . $this->filePrefix . '.pdf';

    $this->pdfhtml = '';
  }

  public function createPdfData($oID, $deliverSlip = false)
  {

    global $order, $xtPrice;

    // wird nur für Rechnung benötigt
    if ($deliverSlip === false) require_once(DIR_FS_INC . 'xtc_get_countries.inc.php');

    $pdf_smarty = new Smarty();

    //get store name and store name_address
    $pdf_smarty->assign('store_name', STORE_NAME);
    $pdf_smarty->assign('store_name_address', STORE_NAME_ADDRESS);

    // get order data - Klasse jetzt global
    //include_once(DIR_WS_CLASSES . 'order.php');
    //$order = new order((int)$_GET['oID']);

    $pdf_smarty->assign('address_label_customer', xtc_address_format($order->customer['format_id'], $order->customer, 1, '', '<br />'));
    $pdf_smarty->assign('address_label_shipping', xtc_address_format($order->delivery['format_id'], $order->delivery, 1, '', '<br />'));
    $pdf_smarty->assign('address_label_payment', xtc_address_format($order->billing['format_id'], $order->billing, 1, '', '<br />'));
    $pdf_smarty->assign('csID', $order->customer['csID']);

    $pdf_smarty->assign('vatID', $order->customer['vat_id']);

    $pdf_smarty->assign('gender', $order->customer['gender']);
    $pdf_smarty->assign('name', $order->customer['name']);

    // get products data - Klasse jetzt global
    //include_once(DIR_FS_CATALOG.DIR_WS_CLASSES .'xtcPrice.php');
    //$xtPrice = new xtcPrice($order->info['currency'], $order->info['status']);

    $order_total = $order->getTotalData($order->info['order_id']);
    $order_data = $order->getOrderData($order->info['order_id']);

    $pdf_smarty->assign('order_data', $order_data);
    $pdf_smarty->assign('order_total', $order_total['data']);

    // wird nur für Rechnung benötigt
    if ($deliverSlip === false) {
      $pdf_smarty->assign('vat_info', 0);
      if (
        count($order_data) > 0
        && in_array($order_data[0]['ALLOW_TAX'], array('0', '4'))
      ) {
        $store_country = xtc_get_countriesList(STORE_COUNTRY);

        $countries_array = array();
        $countries_query = xtc_db_query("SELECT c.countries_iso_code_2
                                       FROM " . TABLE_TAX_RATES . " tr
                                       JOIN " . TABLE_ZONES_TO_GEO_ZONES . " ztgz
                                            ON tr.tax_zone_id = ztgz.geo_zone_id
                                       JOIN " . TABLE_COUNTRIES . " c
                                            ON ztgz.zone_country_id = c.countries_id
                                      WHERE tr.tax_rate > 0
                                   GROUP BY c.countries_id");
        if (xtc_db_num_rows($countries_query) > 0) {
          while ($countries = xtc_db_fetch_array($countries_query)) {
            $countries_array[] = $countries['countries_iso_code_2'];
          }
        }

        if (
          in_array($order->delivery['country_iso_2'], $countries_array)
          && in_array($store_country['countries_iso_code_2'], $countries_array)
          && $order->delivery['country_iso_2'] != $store_country['countries_iso_code_2']
        ) {
          $pdf_smarty->assign('vat_info', 1);
        } elseif ($order->delivery['country_iso_2'] != $store_country['countries_iso_code_2']) {
          $pdf_smarty->assign('vat_info', 2);
        }
      }
    }
    // assign language to template for caching
    $languages_query = xtc_db_query("select code, language_charset from " . TABLE_LANGUAGES . " WHERE directory ='" . $order->info['language'] . "'");
    $langcode = xtc_db_fetch_array($languages_query);
    $pdf_smarty->assign('langcode', $langcode['code']);
    $pdf_smarty->assign('charset', $langcode['language_charset']);
    $pdf_smarty->assign('language', $order->info['language']);

    $absolutpath = DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE;
    $pdf_smarty->assign('override', file_exists($absolutpath . '/lang/lang_' . $order->info['language'] . '.pdf_override') ? true : false);

    $pdf_smarty->assign('logo_path', $absolutpath . '/img/');
    $pdf_smarty->assign('tpl_path', 'templates/' . CURRENT_TEMPLATE . '/');
    if (function_exists('xtc_catalog_href_link')) {
      $pdf_smarty->assign('base_href', xtc_catalog_href_link('', '', $request_type, false, false));
    } else {
      $pdf_smarty->assign('base_href', xtc_href_link('', '', $request_type, false, false));
    }

    $pdf_smarty->assign('oID', $order->info['order_id']);
    if ($order->info['payment_method'] != '' && $order->info['payment_method'] != 'no_payment') {
      // DIR_WS_CLASSES kann nicht genutzt werden - im Checkout ist komplette Shop-URL enthalten
      require_once(DIR_FS_CATALOG . 'includes/classes/payment.php');
      $payment_modules = new payment($order->info['payment_method']);
      $payment_method = $payment_modules::payment_title($order->info['payment_method'], $order->info['order_id']);

      if (in_array($order->info['payment_method'], array('paypalplus', 'paypalpui'))) {
        require_once(DIR_FS_EXTERNAL . 'paypal/classes/PayPalInfo.php');
        $paypal = new PayPalInfo($order->info['payment_method']);
        $pdf_smarty->assign('PAYMENT_INFO', $paypal->get_payment_instructions($order->info['order_id']));
      }
      $pdf_smarty->assign('PAYMENT_METHOD', $payment_method);
    }
    $pdf_smarty->assign('COMMENTS', nl2br($order->info['comments']));
    $pdf_smarty->assign('DATE', xtc_date_long($order->info['date_purchased']));
    $pdf_smarty->assign('INVOICE_NUMBER', isset($order->info['ibn_billnr']) && $order->info['ibn_billnr'] != '' ? $order->info['ibn_billnr'] :  $order->info['order_id']);
    $pdf_smarty->assign('INVOICE_DATE', isset($order->info['ibn_billdate']) && $order->info['ibn_billdate'] != '0000-00-00' ? xtc_date_short($order->info['ibn_billdate']) :  xtc_date_short($order->info['date_purchased']));
    $pdf_smarty->assign('DELIVERY_DATE', isset($order->info['ibn_billdate']) && $order->info['ibn_billdate'] != '0000-00-00' ? xtc_date_short($order->info['ibn_billdate']) :  xtc_date_short($order->info['date_purchased']));
    $pdf_smarty->assign('SHIPPING_CLASS', $order->info['shipping_class']);

    require_once(DIR_FS_CATALOG . 'includes/classes/main.php');
    $main = new main();

    $invoice_data = $main->getContentData(INVOICE_INFOS);
    $pdf_smarty->assign('ADDRESS_SMALL', $invoice_data['content_heading']);
    $pdf_smarty->assign('ADDRESS_LARGE', $invoice_data['content_text']);

    // dont allow cache
    $pdf_smarty->caching = 0;
    $pdf_smarty->template_dir = DIR_FS_CATALOG . 'templates';
    $pdf_smarty->compile_dir = DIR_FS_CATALOG . 'templates_c';
    $pdf_smarty->config_dir = DIR_FS_CATALOG . 'lang';

    if ($deliverSlip === false) {
      $tpl = 'print_order_pdf.html';
    } else {
      $tpl = 'print_packingslip_pdf.html';
    }

    foreach(auto_include(DIR_FS_EXTERNAL . 'pdfinvoice/extra/','php') as $file) require ($file);

    $pdfhtml = $pdf_smarty->fetch(CURRENT_TEMPLATE . '/admin/' . $tpl);
    $this->pdfhtml = $pdfhtml;

    return;
  }

  public function generatePdf($deliverSlip = false)
  {

    global $order;

    require_once(DIR_FS_EXTERNAL . 'pdfinvoice/vendor/autoload.php');

    try {

      $html2pdf = new Html2Pdf('P', 'A4', 'de', true, 'UTF-8', array(0, 10, 0, 10));
      $html2pdf->pdf->SetDisplayMode('fullpage');

      $html2pdf->pdf->SetTitle(STORE_NAME . ' - ' . ($deliverSlip === false ? PDFINVOICE_MAIL_SUBJECT :  PDFINVOICE_MAIL_SUBJECT_SLIP));
      $html2pdf->pdf->SetAuthor(STORE_NAME);
      $html2pdf->pdf->SetCreator("PDF-Rechnung (c) 2025 Karl");
      if ($deliverSlip === false) {
        $html2pdf->pdf->setSubject('Invoice');
        $html2pdf->pdf->setKeywords('Invoice, ZUGFerd, XRechnung');
      }

      /* BOF AGI factur_x 1/2 */
      if (!$deliverSlip && defined('MODULE_SYSTEM_FACTUR_X_STATUS') && MODULE_SYSTEM_FACTUR_X_STATUS == 'true') {
        $tmp = xtc_db_query('SELECT bill_id, xml_data, bill_number FROM factur_x WHERE orders_id=' . (int)$order->info['orders_id'] . " ORDER BY created_at DESC LIMIT 1");
        if (xtc_db_num_rows($tmp)) {
          $factur_x = xtc_db_fetch_array($tmp);
        } else {
          foreach (auto_include(DIR_FS_EXTERNAL . 'factur_x/extra/create/', 'php') as $file) require($file);
          if (!class_exists('FACTUR_X_ORDER')) {
            require_once(DIR_FS_EXTERNAL . 'factur_x/factur_x_order.class.php');
            $factur_x_order = new FACTUR_X_ORDER($order->info['orders_id']); // X-Rechnung initialisieren
          }
          $bill_id = $factur_x_order->create_new();
          $tmp = xtc_db_query('SELECT bill_id, xml_data, bill_number FROM factur_x WHERE bill_id=' . $bill_id);
          $factur_x = xtc_db_fetch_array($tmp);
        }
        if ($factur_x) {
          require_once('ext/factur_x.fpdf_zugferd.php');
          // EXTENDED muss gesetzt werden, da die XML-Daten "extended" kodiert sind
          // <ram:ID>urn:cen.eu:en16931:2017#conformant#urn:factur-x.eu:1p0:extended</ram:ID>
          $profile = 'EXTENDED';
          // Import XMP Daten
          $zugferd = new PDF_ZUGFeRD($profile);
          $html2pdf->pdf->EmbedFileFromString($zugferd->filename, $factur_x['xml_data']);
          $html2pdf->pdf->setExtraXMPRDF($zugferd->extraXMPRDF);
          $html2pdf->pdf->setExtraXMPPdfaextension($zugferd->extraXMPPdfaextension);
        }
      } else {
        // bei ZUGFerd-Rechnung darf das PDF nicht geschützt werden
        // nur Drucken erlaubt, kein User-Passwort, jedoch ein Master-Passwort
        if (PDFINVOICE_PROTECT_PDF == 'true') {
          $html2pdf->pdf->SetProtection(array('print'), '', PDFINVOICE_MASTER_PASS);
        }
      }
      /* EOF AGI factur_x 1/2 */

      $html2pdf->writeHTML($this->pdfhtml);

      $html2pdf->output($this->filename, 'F');
      //$html2pdf->output();

    } catch (Html2PdfException $e) {
      $html2pdf->clean();

      $formatter = new ExceptionFormatter($e);
      echo $formatter->getHtmlMessage();
    }

    return $this->filePrefix;
  }

  public function sendPDF($oID, $deliverSlip, $updateStatus)
  {

    global $order;

    // attachment file
    $attachement_filename = $this->filename;

    // mail name
    $name = $order->customer['firstname'] . " " . $order->customer['lastname'];

    // create new Smarty Object
    $smarty = new Smarty;

    $smarty->assign('GENDER', $order->customer['gender']);
    $smarty->assign('LASTNAME', $name);

    // assign language to template for caching
    $smarty->assign('language', $_SESSION['language']);
    $smarty->caching = false;

    // set dirs manual
    $smarty->template_dir = DIR_FS_CATALOG . 'templates';
    $smarty->compile_dir = DIR_FS_CATALOG . 'templates_c';
    $smarty->config_dir = DIR_FS_CATALOG . 'lang';

    $smarty->assign('tpl_path', 'templates/' . CURRENT_TEMPLATE . '/');
    $smarty->assign('logo_path', HTTP_SERVER . DIR_WS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/img/');

    // text assigns
    if ($deliverSlip === true) {
      $smarty->assign('PDFINVOICE_TYPE', TEXT_PDFINVOICE_LIEFERSCHEIN);
      $smarty->assign('ORDER_DATE', xtc_date_short($order->info['date_purchased']));
    } else {
      $smarty->assign('PDFINVOICE_TYPE', TEXT_PDFINVOICE_RECHNUNG);
      $smarty->assign('ORDER_DATE', isset($order->info['ibn_billdate']) && $order->info['ibn_billdate'] != '0000-00-00' ? xtc_date_short($order->info['ibn_billdate']) :  xtc_date_short($order->info['date_purchased']));
    }

    $smarty->assign('ORDER_NR', $oID);

    // should we forward the packaging slip to a defined mail?
    if (PDFINVOICE_MAIL_SLIP_FORWARDER == 'true' && $deliverSlip === true) {
      $smarty->assign('FORWARDER_MAIL', true);
    }

    $html_mail = $smarty->fetch(DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/admin/mail/' . $_SESSION['language'] . '/invoice_mail.html');
    $txt_mail = $smarty->fetch(DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/admin/mail/' . $_SESSION['language'] . '/invoice_mail.txt');

    // generate mail subject
    if ($deliverSlip === true) {
      $subject_text = PDFINVOICE_MAIL_SUBJECT_SLIP;
    } else {
      $subject_text = PDFINVOICE_MAIL_SUBJECT;
    }
    $mail_subject = str_replace('{oID}', $oID, $subject_text);

    if (PDFINVOICE_MAIL_SLIP_FORWARDER == 'true' && $deliverSlip === true) {
      // sende mail to forwarder
      xtc_php_mail(
        EMAIL_BILLING_ADDRESS,
        EMAIL_BILLING_NAME,
        PDFINVOICE_MAIL_SLIP_FORWARDER_EMAIL,
        PDFINVOICE_MAIL_SLIP_FORWARDER_NAME,
        '',
        EMAIL_BILLING_REPLY_ADDRESS,
        EMAIL_BILLING_REPLY_ADDRESS_NAME,
        $attachement_filename,
        '',
        $mail_subject,
        $html_mail,
        $txt_mail,
        2
      );
    } else {
      // send customer mail
      xtc_php_mail(
        EMAIL_BILLING_ADDRESS,
        EMAIL_BILLING_NAME,
        $order->customer['email_address'],
        $name,
        '',
        EMAIL_BILLING_REPLY_ADDRESS,
        EMAIL_BILLING_REPLY_ADDRESS_NAME,
        $attachement_filename,
        '',
        $mail_subject,
        $html_mail,
        $txt_mail,
        2
      );
    }

    // send copy if needed
    if ($deliverSlip === true && PDFINVOICE_MAIL_SLIP_COPY != '') {
      $copyMail = PDFINVOICE_MAIL_SLIP_COPY;
    } else if ($deliverSlip === false && PDFINVOICE_MAIL_INVOICE_COPY != '') {
      $copyMail = PDFINVOICE_MAIL_INVOICE_COPY;
    }

    // copy mail needed?
    if (isset($copyMail) && $copyMail != '') {
      xtc_php_mail(
        EMAIL_BILLING_ADDRESS,
        EMAIL_BILLING_NAME,
        $copyMail,
        $name,
        '',
        EMAIL_BILLING_REPLY_ADDRESS,
        EMAIL_BILLING_REPLY_ADDRESS_NAME,
        $attachement_filename,
        '',
        $mail_subject,
        $html_mail,
        $txt_mail,
        2
      );
    }

    // Update Status to notified
    $customer_notified = '1';

    // switch status with deliverSlip
    if ($deliverSlip === true) {
      $comments = PDFINVOICE_STATUS_COMMENT_SLIP;
    } else {
      $comments = PDFINVOICE_STATUS_COMMENT;
    }

    // Orderstatus aktualisieren
    if (PDFINVOICE_UPDATE_STATUS == 'true') {
      $orders_status_id = (is_numeric(PDFINVOICE_STATUS_ID_INVOICE)) ? PDFINVOICE_STATUS_ID_INVOICE : '1';
    } elseif (PDFINVOICE_UPDATE_STATUS_SLIP == 'true' && $deliverSlip === true) {
      $orders_status_id = (is_numeric(PDFINVOICE_STATUS_ID_SLIP)) ? PDFINVOICE_STATUS_ID_SLIP : '1';
    } else {
      $orders_status_id = $order->info['orders_status_id'];
    }
    $orders_status_id = trim($orders_status_id);

    // insert notice
    $sqlStatus = "
        INSERT INTO " . TABLE_ORDERS_STATUS_HISTORY . " (
            orders_id,
            orders_status_id,
            date_added,
            customer_notified,
            comments
        ) VALUES (
            '" . xtc_db_input($oID) . "',
            '" . $orders_status_id . "',
            now(),
            '" . $customer_notified . "',
             '" . xtc_db_input($comments) . "'
        )";
    $resStatus = xtc_db_query($sqlStatus);

    // update orders_status on order
    if ((PDFINVOICE_UPDATE_STATUS == 'true' && $updateStatus === true) || (PDFINVOICE_UPDATE_STATUS_SLIP == 'true' && $deliverSlip === true)) {
      $sqlUpdateStatus = "UPDATE " . TABLE_ORDERS . " SET orders_status = '" . $orders_status_id . "' WHERE orders_id = '" . xtc_db_input($oID) . "'";
      $resUpdateStatus = xtc_db_query($sqlUpdateStatus);
    }
  }

  protected function createFilePrefix($deliverSlip = false)
  {

    global $order, $xtPrice;

    // use customers_id as the real id?
    if (PDFINVOICE_USE_CUSTOMER_ID == 'true') {
      $customers_id = $order->customer['id'];
    } else {
      $customers_id = $order->customer['cid'] != '' ? $order->customer['cid'] : $order->customer['id'];
    }
    // ibn_billnr
    if ($order->info['ibn_billnr'] == '') {

      if (PDFINVOICE_USE_ORDERID == 'true') {
        $ibn_billnr = PDFINVOICE_USE_ORDERID_PREFIX . (int)$order->info['order_id'] . PDFINVOICE_USE_ORDERID_SUFFIX;
      } else {
        $billnr_query = xtc_db_query("SELECT configuration_value
                                      FROM " . TABLE_CONFIGURATION . "
                                     WHERE configuration_key = 'MODULE_INVOICE_NUMBER_IBN_BILLNR'");
        $billnr = xtc_db_fetch_array($billnr_query);
        $n = (int)$billnr['configuration_value'];

        if ($n > 0) {
          xtc_db_query("UPDATE " . TABLE_CONFIGURATION . "
                         SET configuration_value = " . ($n + 1) . "
                       WHERE configuration_key = 'MODULE_INVOICE_NUMBER_IBN_BILLNR'");

          $ibn_billnr = MODULE_INVOICE_NUMBER_IBN_BILLNR_FORMAT;
          $ibn_billnr = str_replace('{n}', $n, $ibn_billnr);
          $ibn_billnr = str_replace('{d}', date('d'), $ibn_billnr);
          $ibn_billnr = str_replace('{m}', date('m'), $ibn_billnr);
          $ibn_billnr = str_replace('{y}', date('Y'), $ibn_billnr);
        }
      }

      $sql_data_array = array(
        'ibn_billnr' => xtc_db_prepare_input($ibn_billnr),
        'ibn_billdate' => 'now()'
      );
      xtc_db_perform(TABLE_ORDERS, $sql_data_array, 'update', "orders_id = '" . (int)$order->info['order_id'] . "'");

      $order->info['ibn_billnr'] = $ibn_billnr;
    }

    $order_bill = $order->info['ibn_billnr'];

    if ($deliverSlip === false) {
      $filePrefix = PDFINVOICE_FILENAME;
    } else {
      $filePrefix = PDFINVOICE_FILENAME_SLIP;
    }

    // replace Variables for filePrefix
    $filePrefix = trim($filePrefix);
    $filePrefix = str_replace('{oID}', $order->info['order_id'], $filePrefix);
    $filePrefix = str_replace('{bill}', $order_bill, $filePrefix);
    $filePrefix = str_replace('{cID}', $customers_id, $filePrefix);
    $filePrefix = str_replace(' ', '_', $filePrefix);
    if ($filePrefix == '') $filePrefix = $order->info['order_id'];

    return $filePrefix;
  }
}
