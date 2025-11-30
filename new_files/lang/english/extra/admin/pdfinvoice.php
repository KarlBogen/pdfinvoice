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

defined('MODULE_PDFINVOICE_INVOICE_GROUP') OR define('MODULE_PDFINVOICE_INVOICE_GROUP', '');
define('BOX_CONFIGURATION_'.MODULE_PDFINVOICE_INVOICE_GROUP, 'PDFInvoice Configuration');
// Invoice
define('PDFINVOICE_FILENAME_TITLE', 'Invoice:<br>Invoice filename');
define('PDFINVOICE_FILENAME_DESC', 'Filename of invoice. <strong>Please without .pdf</strong>. Spaces will be replaced with underscores. Variables: <strong>{oID}</strong> (Order-ID), <strong>{bill}</strong> (Invoice-No.), <strong>{cID}</strong> (Customer-No. or Customer-ID).');
define('PDFINVOICE_MAIL_INVOICE_COPY_TITLE', 'Invoice:<br>Invoice - Forward mail');
define('PDFINVOICE_MAIL_INVOICE_COPY_DESC', 'Please enter forwarding addresses for mails of the invoice-Mail.');
define('PDFINVOICE_USE_ORDERID_TITLE', 'Invoice:<br>Order number as invoice number');
define('PDFINVOICE_USE_ORDERID_DESC', 'Use order number instead of invoice number.');
define('PDFINVOICE_USE_ORDERID_PREFIX_TITLE', 'Invoice:<br>Invoice number prefix');
define('PDFINVOICE_USE_ORDERID_PREFIX_DESC', 'Prefix for the invoice number. Only used if order number is used as invoice number.');
define('PDFINVOICE_USE_ORDERID_SUFFIX_TITLE', 'Invoice:<br>Invoicenumber Suffix');
define('PDFINVOICE_USE_ORDERID_SUFFIX_DESC', 'Suffix for the invoice number. Only used if order number is used as invoice number.');
define('PDFINVOICE_SEND_ORDER_TITLE', 'Invoice:<br>Automatically send PDF invoices');
define('PDFINVOICE_SEND_ORDER_DESC', 'Invoice-PDF will be automatically send after the order process is finished.');
define('PDFINVOICE_SEND_WITH_ORDER_MAIL_TITLE', 'Invoice:<br>Invoice PDF as attachment of order mail');
define('PDFINVOICE_SEND_WITH_ORDER_MAIL_DESC', 'If this option is activated, the invoice PDF will be sent as an attachment to the order mail and not as a separate message.<br>Note: "Automatically send PDF invoices" must be activated.');
define('PDFINVOICE_STATUS_COMMENT_TITLE', 'Invoice:<br>Comment to order history');
define('PDFINVOICE_STATUS_COMMENT_DESC', 'Comment added to the system when an invoice is sent.');
define('PDFINVOICE_UPDATE_STATUS_TITLE', 'Invoice:<br>Update order status');
define('PDFINVOICE_UPDATE_STATUS_DESC', 'Update status automatically after PDF-Invoice-Mail.');
define('PDFINVOICE_STATUS_ID_INVOICE_TITLE', 'Invoice:<br>Order Status after the mail - Invoice-PDF');
define('PDFINVOICE_STATUS_ID_INVOICE_DESC', 'The order status that is saved after the Invoice-PDF has been sent by email (only if update order status = Yes.');
define('PDFINVOICE_STATUS_SEND_TITLE', 'Invoice:<br>Send invoice on order status update');
define('PDFINVOICE_STATUS_SEND_DESC', 'If this option is activated, the Invoice-PDF will be sent after order status update.');
define('PDFINVOICE_STATUS_SEND_ID_TITLE', 'Invoice:<br>Send order status for Invoice-PDF');
define('PDFINVOICE_STATUS_SEND_ID_DESC', 'The Invoice will be send on update to this order status.');
define('PDFINVOICE_ENABLE_QRCODES_TITLE', 'Rechnung:<br>QR-Codes of products');
define('PDFINVOICE_ENABLE_QRCODES_DESC', 'If this option is activated, QR-Codes of the products would be displayed in the PDF-Invoice.');
// Packing slip
define('PDFINVOICE_FILENAME_SLIP_TITLE', 'Packing slip:<br>Packing slip filename');
define('PDFINVOICE_FILENAME_SLIP_DESC', 'Filename of packing slip. <strong>Please without .pdf</strong>. Spaces will be replaced with underscores. Variables: <strong>{oID}</strong> (Order-ID), <strong>{bill}</strong> (Invoice-No.), <strong>{cID}</strong> (Customer-No. or Customer-ID).');
define('PDFINVOICE_MAIL_SLIP_COPY_TITLE', 'Packing slip:<br>Packing-Slip - Forward mail');
define('PDFINVOICE_MAIL_SLIP_COPY_DESC', 'Please enter forwarding addresses for mails of the packing slip.');
define('PDFINVOICE_SEND_SLIP_WITH_ORDER_TITLE', 'Packing slip:<br>Automatically send PDF packing slip');
define('PDFINVOICE_SEND_SLIP_WITH_ORDER_DESC', 'Packing-Slip-PDF will be automatically send after the order process is finished (not as attachment of the Invoice).<br />If the option "Forward packing slip" is activated, the packaging slip will not be sent to the customer, but to the logistics provider.');
define('PDFINVOICE_STATUS_COMMENT_SLIP_TITLE', 'Packing slip:<br>Comment to order history');
define('PDFINVOICE_STATUS_COMMENT_SLIP_DESC', 'Comment that is added to the system when packing slip is sent.');
define('PDFINVOICE_MAIL_SLIP_FORWARDER_TITLE', 'Packing slip:<br>Forward packing slip');
define('PDFINVOICE_MAIL_SLIP_FORWARDER_DESC', 'If this option is activated, the packing slip will not be sent to the customer, but to the logistics provider.');
define('PDFINVOICE_MAIL_SLIP_FORWARDER_NAME_TITLE', 'Packing slip:<br>Forwarder name');
define('PDFINVOICE_MAIL_SLIP_FORWARDER_NAME_DESC', 'Enter name of the forwarder, who should get the packing slip');
define('PDFINVOICE_MAIL_SLIP_FORWARDER_EMAIL_TITLE', 'Packing slip:<br>Forwarder email');
define('PDFINVOICE_MAIL_SLIP_FORWARDER_EMAIL_DESC', 'Enter email of the forwarder, who should get the packing slip');
define('PDFINVOICE_UPDATE_STATUS_SLIP_TITLE', 'Packing slip:<br>Update order status');
define('PDFINVOICE_UPDATE_STATUS_SLIP_DESC', 'Update status automatically after PDF-Slip-Mail.');
define('PDFINVOICE_STATUS_ID_SLIP_TITLE', 'Packing slip:<br>Order Status after the PDF-Slip-Mail');
define('PDFINVOICE_STATUS_ID_SLIP_DESC', 'The order status that is saved after the Slip-PDF has been sent by email (only if update order status = Yes).');
define('PDFINVOICE_STATUS_SEND_WITH_SLIP_TITLE', 'Packing slip:<br>Send Packing Slip on order status update');
define('PDFINVOICE_STATUS_SEND_WITH_SLIP_DESC', 'If this option is activated, the packaging slip will be sent after order status update.<br />If the option "Forward packing slip" is activated, the packaging slip will not be sent to the customer, but to the logistics provider.');
define('PDFINVOICE_STATUS_SEND_WITH_SLIP_ID_TITLE', 'Packing slip:<br>Send order status for Slip-PDF');
define('PDFINVOICE_STATUS_SEND_WITH_SLIP_ID_DESC', 'The packing slip will be send on update to this order status.');
// PDF settings
define('PDFINVOICE_PROTECT_PDF_TITLE', 'PDF setting:<br>PDF Protection');
define('PDFINVOICE_PROTECT_PDF_DESC', 'Prevent PDF from edit with a Masterpassword');
define('PDFINVOICE_MASTER_PASS_TITLE', 'PDF setting:<br>PDF Masterpassword');
define('PDFINVOICE_MASTER_PASS_DESC', 'Password for PDF (can be empty).');
define('PDFINVOICE_USE_CUSTOMER_ID_TITLE', 'PDF setting:<br>Use customers-id instead of customers number (cID)');
define('PDFINVOICE_USE_CUSTOMER_ID_DESC', 'Use the customers-id instead of customers number. The placeholder {cID} in the filename is replaced by the customer-ID (applies to invoice and packing slip).');
// Check, if Module Invoicenumber active
define('PDFINVOICE_INVOICE_CHECK_MODUL_INVOICENUMBER', '<strong>The "PDFInvoice" system module is installed and active.</strong><br />For the functionality of this module, the system module "Invoice numbers" must be installed and active!');
// Standard PDF texts
defined('TEXT_PDFINVOICE_RECHNUNG') OR define('TEXT_PDFINVOICE_RECHNUNG', 'your invoice');
defined('TEXT_PDFINVOICE_LIEFERSCHEIN') OR define('TEXT_PDFINVOICE_LIEFERSCHEIN', 'your packing slip');
defined('PDFINVOICE_MAIL_SUBJECT') OR define('PDFINVOICE_MAIL_SUBJECT', 'Your invoice');
defined('PDFINVOICE_MAIL_SUBJECT_SLIP') OR define('PDFINVOICE_MAIL_SUBJECT_SLIP', 'Your packing slip');
defined('TEXT_PDFINVOICE_SEITE') OR define('TEXT_PDFINVOICE_SEITE', 'Page ');
defined('TEXT_PDFINVOICE_SEITE_VON') OR define('TEXT_PDFINVOICE_SEITE_VON', ' of ');

define('BUTTON_GROUP_PDFINVOICE_INVOICE_TITLE', 'PDF Invoice:');
define('BUTTON_INVOICE_PDF', 'Invoice PDF');
define('BUTTON_PACKINGSLIP_PDF', 'Packing slip PDF');
define('BUTTON_INVOICE_NR', 'Bill number:');
define('BUTTON_SET_INVOICE_NR', 'Set bill number');
