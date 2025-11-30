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
define('BOX_CONFIGURATION_'.MODULE_PDFINVOICE_INVOICE_GROUP, 'PDF Rechnung - Konfiguration');
// Rechnung
define('PDFINVOICE_FILENAME_TITLE', 'Rechnung:<br>Dateiname der Rechnung');
define('PDFINVOICE_FILENAME_DESC', 'Dateiname der Rechnung. Leerzeichen werden durch einen Unterstrich ersetzt.<br>Variablen: <strong>{oID}</strong> (Order-ID), <strong>{bill}</strong> (Rechnungsnummer), <strong>{cID}</strong> (Kundennummer oder Kunden-ID). <strong>Bitte ohne .pdf</strong>.');
define('PDFINVOICE_MAIL_INVOICE_COPY_TITLE', 'Rechnung:<br>Rechnung - Weiterleitungsadresse');
define('PDFINVOICE_MAIL_INVOICE_COPY_DESC', 'Geben Sie hier eine E-Mailaddresse an, wenn Sie eine Kopie erhalten wollen.');
define('PDFINVOICE_USE_ORDERID_TITLE', 'Rechnung:<br>Bestellnummer als Rechnungsnummer');
define('PDFINVOICE_USE_ORDERID_DESC', 'Durch diese Option wird die Bestellnummer als Rechnungsnummer verwendet.');
define('PDFINVOICE_USE_ORDERID_PREFIX_TITLE', 'Rechnung:<br>Rechnungsnummer Prefix');
define('PDFINVOICE_USE_ORDERID_PREFIX_DESC', 'Prefix f&uuml;r die Rechnungsnummer, falls die Bestellnummer als Rechnungsnummer verwendet wird.');
define('PDFINVOICE_USE_ORDERID_SUFFIX_TITLE', 'Rechnung:<br>Rechnungsnummer Suffix');
define('PDFINVOICE_USE_ORDERID_SUFFIX_DESC', 'Suffix f&uuml;r die Rechnungsnummer, falls die Bestellnummer als Rechnungsnummer verwendet wird.');
define('PDFINVOICE_SEND_ORDER_TITLE', 'Rechnung:<br>PDF-Rechnung automatisch versenden');
define('PDFINVOICE_SEND_ORDER_DESC', 'Wenn diese Option aktiviert ist, wird die Rechnungs-PDF direkt nach der Bestellung automatisch verschickt.');
define('PDFINVOICE_SEND_WITH_ORDER_MAIL_TITLE', 'Rechnung:<br>PDF-Rechnungs als Anhang der Bestellbest&auml;tigung');
define('PDFINVOICE_SEND_WITH_ORDER_MAIL_DESC', 'Wenn diese Option aktiviert ist, wird die Rechnungs-PDF als Anhang der Bestellbest&auml;tigung und nicht als eigene Nachricht verschickt.<br>Hinweis: der automatische Versand muss aktiviert sein.');
define('PDFINVOICE_STATUS_COMMENT_TITLE', 'Rechnung:<br>Kommentar in der Bestellhistorie');
define('PDFINVOICE_STATUS_COMMENT_DESC', 'Kommentar der beim Verschicken einer Rechnung in das System hinzugef&uuml;gt wird.');
define('PDFINVOICE_UPDATE_STATUS_TITLE', 'Rechnung:<br>Bestellstatus aktualisieren');
define('PDFINVOICE_UPDATE_STATUS_DESC', 'Bestellstatus wird nach dem Mailversand der PDF-Rechnung automatisch aktualisiert.');
define('PDFINVOICE_STATUS_ID_INVOICE_TITLE', 'Rechnung:<br>Bestellstatus nach Versand - PDF-Rechnungs');
define('PDFINVOICE_STATUS_ID_INVOICE_DESC', 'Der Bestellstatus der nach dem Mailversand der Rechnungs-PDF gespeichert wird (nur bei Bestellstatus aktualisieren = Ja.');
define('PDFINVOICE_STATUS_SEND_TITLE', 'Rechnung:<br>Rechnung bei Umstellung Bestellstatus versenden');
define('PDFINVOICE_STATUS_SEND_DESC', 'Wenn diese Option aktiviert ist, wird die PDF-Rechnung direkt nach der Umstellung des Bestellstatus automatisch verschickt.');
define('PDFINVOICE_STATUS_SEND_ID_TITLE', 'Rechnung:<br>Bestellstatus automatischer Rechnungsversand');
define('PDFINVOICE_STATUS_SEND_ID_DESC', 'Bei Umstellung auf diesen Bestellstatus wird die Rechnung automatisch verschickt.');
define('PDFINVOICE_ENABLE_QRCODES_TITLE', 'Rechnung:<br>QR-Codes der Artikel');
define('PDFINVOICE_ENABLE_QRCODES_DESC', 'Wenn diese Option aktiviert ist, werden QR-Codes der Artikel in der Rechnung angezeigt.');
// Lieferschein
define('PDFINVOICE_FILENAME_SLIP_TITLE', '<br><br>Lieferschein:<br>Dateiname des Lieferscheins<br><br>');
define('PDFINVOICE_FILENAME_SLIP_DESC', '<br><br>Dateiname des Lieferscheins. Leerzeichen werden durch einen Unterstrich ersetzt.<br>Variablen: <strong>{oID}</strong> (Order-ID), <strong>{bill}</strong> (Rechnungsnummer), <strong>{cID}</strong> (Kundennummer oder Kunden-ID). <strong>Bitte ohne .pdf</strong>.<br><br>');
define('PDFINVOICE_MAIL_SLIP_COPY_TITLE', 'Lieferschein:<br>Lieferschein - Weiterleitungsadresse');
define('PDFINVOICE_MAIL_SLIP_COPY_DESC', 'Geben Sie hier eine E-Mailaddresse an, wenn Sie eine Kopie erhalten wollen.');
define('PDFINVOICE_SEND_SLIP_WITH_ORDER_TITLE', 'Lieferschein:<br>PDF-Lieferschein automatisch versenden');
define('PDFINVOICE_SEND_SLIP_WITH_ORDER_DESC', 'Wenn diese Option aktiviert ist, wird das Lieferschein-PDF direkt nach der Bestellung automatisch verschickt (nicht als Anhang).<br />Ist die Option "Lieferschein an Logistiker" aktiviert, wird der Lieferschein nicht an den Kunden, sondern an den Logistiker gesandt.');
define('PDFINVOICE_STATUS_COMMENT_SLIP_TITLE', 'Lieferschein:<br>Kommentar in der Bestellhistorie');
define('PDFINVOICE_STATUS_COMMENT_SLIP_DESC', 'Kommentar der beim Verschicken eines Lieferschein in das System hinzugef&uuml;gt wird.');
define('PDFINVOICE_MAIL_SLIP_FORWARDER_TITLE', 'Lieferschein:<br>Lieferschein an Logistiker');
define('PDFINVOICE_MAIL_SLIP_FORWARDER_DESC', 'Wenn diese Option aktiviert ist, wird der Lieferschein nicht an den Kunden, sondern an den Logistiker versandt.');
define('PDFINVOICE_MAIL_SLIP_FORWARDER_NAME_TITLE', 'Lieferschein:<br>Logistiker Name');
define('PDFINVOICE_MAIL_SLIP_FORWARDER_NAME_DESC', 'Geben Sie hier den Namen des Logistikers ein, der den Lieferschein erhält');
define('PDFINVOICE_MAIL_SLIP_FORWARDER_EMAIL_TITLE', 'Lieferschein:<br>Logistiker Email');
define('PDFINVOICE_MAIL_SLIP_FORWARDER_EMAIL_DESC', 'Geben Sie hier die E-Mail-Addresse des Logistikers ein, der den Lieferschein erhält');
define('PDFINVOICE_UPDATE_STATUS_SLIP_TITLE', 'Lieferschein:<br>Bestellstatus aktualisieren');
define('PDFINVOICE_UPDATE_STATUS_SLIP_DESC', 'Bestellstatus wird nach dem Mailversand des PDF-Lieferscheins automatisch aktualisiert.');
define('PDFINVOICE_STATUS_ID_SLIP_TITLE', 'Lieferschein:<br>Bestellstatus nach Versand - PDF-Lieferschein');
define('PDFINVOICE_STATUS_ID_SLIP_DESC', 'Der Bestellstatus der nach dem Mailversand das Lieferschein-PDF gespeichert wird (nur bei Bestellstatus aktualisieren = Ja.');
define('PDFINVOICE_STATUS_SEND_WITH_SLIP_TITLE', 'Lieferschein:<br>Lieferschein bei Umstellung Bestellstatus versenden');
define('PDFINVOICE_STATUS_SEND_WITH_SLIP_DESC', 'Wenn diese Option aktiviert ist, wird der PDF-Lieferschein direkt nach der Umstellung des Bestellstatus automatisch verschickt.<br />Ist die Option "Lieferschein an Logistiker" aktiviert, wird der Lieferschein nicht an den Kunden, sondern an den Logistiker gesandt.');
define('PDFINVOICE_STATUS_SEND_WITH_SLIP_ID_TITLE', 'Lieferschein:<br>Bestellstatus automatischer Lieferscheinversand');
define('PDFINVOICE_STATUS_SEND_WITH_SLIP_ID_DESC', 'Bei Umstellung auf diesen Bestellstatus wird der Lieferschein verschickt.');
// PDF Einstellungen
define('PDFINVOICE_PROTECT_PDF_TITLE', '<br><br>PDF Einstellung:<br>PDF-Schutz<br><br>');
define('PDFINVOICE_PROTECT_PDF_DESC', '<br><br>Damit PDF-Rechnungen/Lieferscheine nicht ohne weiteres editiert werden k&ouml;nnen.<br><br>');
define('PDFINVOICE_MASTER_PASS_TITLE', 'PDF Einstellung:<br>PDF Masterpasswort');
define('PDFINVOICE_MASTER_PASS_DESC', 'Passwort f&uuml;r PDF-Rechnungen/Lieferscheine (Eingabefeld kann auch leer bleiben).');
define('PDFINVOICE_USE_CUSTOMER_ID_TITLE', 'PDF Einstellung:<br>Nutze Kunden-ID als Kundennummer');
define('PDFINVOICE_USE_CUSTOMER_ID_DESC', 'Die Kunden-ID wird als Kundennummer verwendet. Der Platzhalter {cID} im Dateinamen wird durch die Kunden-ID ersetzt (gilt f&uuml;r Rechnung und Lieferschein).');
// Prüfen, ob Modul Rechnungsnummer aktiv
define('PDFINVOICE_INVOICE_CHECK_MODUL_INVOICENUMBER', '<strong>Das System Modul "PDF Rechnung" ist installiert und aktiv.</strong><br />F&uuml;r die Funktionalit&#228;t dieses Moduls muss das System Modul "Rechnungsnummern" installiert und aktiv sein!');
// Standardtexte
defined('TEXT_PDFINVOICE_RECHNUNG') OR define('TEXT_PDFINVOICE_RECHNUNG', 'ihre Rechnung');
defined('TEXT_PDFINVOICE_LIEFERSCHEIN') OR define('TEXT_PDFINVOICE_LIEFERSCHEIN', 'ihren Lieferschein');
defined('PDFINVOICE_MAIL_SUBJECT') OR define('PDFINVOICE_MAIL_SUBJECT', 'Ihre Rechnung');
defined('PDFINVOICE_MAIL_SUBJECT_SLIP') OR define('PDFINVOICE_MAIL_SUBJECT_SLIP', 'Ihr Lieferschein');
defined('TEXT_PDFINVOICE_SEITE') OR define('TEXT_PDFINVOICE_SEITE', 'Seite ');
defined('TEXT_PDFINVOICE_SEITE_VON') OR define('TEXT_PDFINVOICE_SEITE_VON', ' von ');

define('BUTTON_GROUP_PDFINVOICE_INVOICE_TITLE', 'PDF Rechnung:');
define('BUTTON_INVOICE_PDF', 'Rechnung PDF');
define('BUTTON_PACKINGSLIP_PDF', 'Lieferschein PDF');
define('BUTTON_INVOICE_NR', 'Rechnungsnummer:');
define('BUTTON_SET_INVOICE_NR', 'Rechnungsnummer vergeben');
