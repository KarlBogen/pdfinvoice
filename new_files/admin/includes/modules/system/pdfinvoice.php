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

define('MODULE_PDFINVOICE_COPYRIGHT', ' © by <a href="https://github.com/KarlBogen" target="_blank" style="color: #e67e22; font-weight: bold;">Karl</a>');
define('MODULE_PDFINVOICE_VERSION', '1.0.0');

if ($_SESSION['language_code'] == 'de') {
  define(
    'MODULE_PDFINVOICE_TEXT_DESCRIPTION',
    '<div style="text-align:center"><h3>PDF Rechnung</h3></div>'
      . ((!defined('MODULE_INVOICE_NUMBER_STATUS') || strtolower(MODULE_INVOICE_NUMBER_STATUS) != 'true') ?
        '<div style="text-align:center;color:red;">
        <strong>Das System Modul "Rechnungsnummern" muss installiert und aktiv sein.<br />Dieses ist zur Funktionalit&auml;t dieses Moduls notwendig!<br /><br /></strong>
      </div>' :
        '<br />')
      . '<strong>Mit diesem Modul k&ouml;nnen PDF-Rechnungen und PDF-Lieferscheine erstellt und per Mailsystem versandt werden</strong><br />'
  );
  define('MODULE_PDFINVOICE_TEXT_TITLE', 'PDF Rechnung');
  define('MODULE_PDFINVOICE_INVOICE_STATUS_TITLE', 'Modul aktiv?');
  define('MODULE_PDFINVOICE_INVOICE_STATUS_DESC', '');
  define('MODULE_PDFINVOICE_DELETE_BUTTON', 'Alle Moduldateien l&ouml;schen');
  define('MODULE_PDFINVOICE_DELETE_CONFIRM', 'Sollen alle Moduldateien gel&ouml;scht werden?<br>Hinweis: Das PDF-Verzeichnis <strong>' . DIR_ADMIN  . 'invoice</strong> wird nicht gel&ouml;scht!');
  define('MODULE_PDFINVOICE_DELETE_FILES_INFO', 'Das PDF-Verzeichnis "' . DIR_ADMIN  . 'invoice" wird nicht gel&ouml;scht!');
  define('MODULE_PDFINVOICE_DELETE_FILE_ERROR', ' - konnte nicht gel&ouml;scht werden!');
} else {
  define(
    'MODULE_PDFINVOICE_TEXT_DESCRIPTION',
    '<div style="text-align:center"><h3>PDF Invoice</h3></div>'
      . ((!defined('MODULE_INVOICE_NUMBER_STATUS') || strtolower(MODULE_INVOICE_NUMBER_STATUS) != 'true') ?
        '<div style="text-align:center;color:red;">
        <strong>The system module "Invoice numbers" have to be installed.<br />This is necessary for the functionality of this module!<br /><br /></strong>
      </div>' :
        '<br />')
      . '<strong>This module allows you to create and send PDF invoices and PDF packing slips via email system.</strong><br />'
  );
  define('MODULE_PDFINVOICE_TEXT_TITLE', 'PDF Invoice');
  define('MODULE_PDFINVOICE_INVOICE_STATUS_TITLE', 'Module active?');
  define('MODULE_PDFINVOICE_INVOICE_STATUS_DESC', '');
  define('MODULE_PDFINVOICE_DELETE_BUTTON', 'Delete all modules files');
  define('MODULE_PDFINVOICE_DELETE_CONFIRM', 'Should all modules files be deleted?<br>Note: The folder <strong>' . DIR_ADMIN  . 'invoice</strong> would not be deleted!');
  define('MODULE_PDFINVOICE_DELETE_FILES_INFO', 'The folder "' . DIR_ADMIN  . 'invoice" would not be deleted!');
  define('MODULE_PDFINVOICE_DELETE_FILE_ERROR', ' - could not be deleted!');
}


class pdfinvoice
{

  var $code;
  var $title;
  var $description;
  var $sort_order;
  var $enabled;
  var $properties;
  var $_check;

  public function __construct()
  {
    $this->code = 'pdfinvoice';
    $this->title = MODULE_PDFINVOICE_TEXT_TITLE . MODULE_PDFINVOICE_COPYRIGHT . ' - Version: ' . MODULE_PDFINVOICE_VERSION;
    $this->description = '';
    if (defined('MODULE_PDFINVOICE_INVOICE_STATUS')) $this->description .= '<a class="button btnbox but_green" style="text-align:center;" onclick="this.blur();" href="' . xtc_href_link(FILENAME_MODULE_EXPORT, 'set=system&module=' . $this->code . '&action=update') . '">Update</a><br /><br />';
    $this->description .= '<a class="button btnbox but_red" style="text-align:center;" onclick="return confirmLink(\'' . MODULE_PDFINVOICE_DELETE_CONFIRM . '\', \'\' ,this);" href="' . xtc_href_link(FILENAME_MODULE_EXPORT, 'set=system&module=' . $this->code . '&action=custom') . '">' . MODULE_PDFINVOICE_DELETE_BUTTON . '</a><br />';
    $this->description .= MODULE_PDFINVOICE_TEXT_DESCRIPTION;
    $this->sort_order = ((defined('MODULE_PDFINVOICE_INVOICE_SORT_ORDER')) ? MODULE_PDFINVOICE_INVOICE_SORT_ORDER : '');
    $this->enabled = ((defined('MODULE_PDFINVOICE_INVOICE_STATUS') && MODULE_PDFINVOICE_INVOICE_STATUS == 'true') ? true : false);
    $this->properties = array('process_key' => false);
  }

  public function process($file)
  {
    // do nothing
  }

  public function display()
  {
    $text = '<br /><div align="center">' . xtc_button(BUTTON_SAVE) .
      xtc_button_link(BUTTON_CANCEL, xtc_href_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=' . $this->code) . "</div>");
    return array('text' => $text);
  }

  public function check()
  {
    if (!isset($this->_check)) {
      if (defined('MODULE_PDFINVOICE_INVOICE_STATUS')) {
        $this->_check = true;
      } else {
        $check_query = xtc_db_query("SELECT configuration_value
                                        FROM " . TABLE_CONFIGURATION . "
                                        WHERE configuration_key = 'MODULE_PDFINVOICE_INVOICE_STATUS'");
        $this->_check = xtc_db_num_rows($check_query);
      }
    }
    return $this->_check;
  }

  public function install()
  {
    xtc_db_query("ALTER TABLE " . TABLE_ADMIN_ACCESS . " ADD pdfinvoice_del INT( 1 ) NOT NULL ;");
    xtc_db_query("UPDATE " . TABLE_ADMIN_ACCESS . " SET pdfinvoice_del = '1' WHERE customers_id = '1';");
    xtc_db_query("ALTER TABLE " . TABLE_ADMIN_ACCESS . " ADD print_order_pdfinvoice INT( 1 ) NOT NULL ;");
    xtc_db_query("UPDATE " . TABLE_ADMIN_ACCESS . " SET print_order_pdfinvoice = '1' WHERE customers_id = '1';");
    xtc_db_query("ALTER TABLE " . TABLE_ADMIN_ACCESS . " ADD print_packingslip_pdfinvoice INT( 1 ) NOT NULL ;");
    xtc_db_query("UPDATE " . TABLE_ADMIN_ACCESS . " SET print_packingslip_pdfinvoice = '1' WHERE customers_id = '1';");
    xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION_GROUP . " (configuration_group_title, configuration_group_description, sort_order) VALUES ('PDFInvoice Configuration', 'PDFInvoice Configuration', NULL);");
    // Tabelle configuration
    $this->check_table_config();
  }

  public function remove()
  {
    $this->remove_table_config();
    xtc_db_query("DELETE FROM " . TABLE_CONFIGURATION_GROUP . " WHERE configuration_group_title = 'PDFInvoice Configuration'");
    xtc_db_query("ALTER TABLE " . TABLE_ADMIN_ACCESS . " DROP `pdfinvoice_del`");
    xtc_db_query("ALTER TABLE " . TABLE_ADMIN_ACCESS . " DROP `print_order_pdfinvoice`");
    xtc_db_query("ALTER TABLE " . TABLE_ADMIN_ACCESS . " DROP `print_packingslip_pdfinvoice`");
  }

  public function keys()
  {
    return array('MODULE_PDFINVOICE_INVOICE_STATUS');
  }


  public function update()
  {
    $this->check_table_config();
    $this->remove_obsolete_files_or_dirs();
  }

  public function custom()
  {
    global $messageStack;

    $messageStack->add_session(MODULE_PDFINVOICE_DELETE_FILES_INFO, 'success');

    // Systemmodule deinstallieren
    if (defined('MODULE_PDFINVOICE_INVOICE_STATUS') && MODULE_PDFINVOICE_INVOICE_STATUS == 'true') {
      $this->remove();
    }

    // Dateien definieren
    $shop_path = DIR_FS_CATALOG;
    $dirs_and_files = array();
    $dirs_and_files[] = $shop_path . DIR_ADMIN . 'pdfinvoice_del.php';
    $dirs_and_files[] = $shop_path . DIR_ADMIN . 'print_order_pdfinvoice.php';
    $dirs_and_files[] = $shop_path . DIR_ADMIN . 'print_packingslip_pdfinvoice.php';
    $dirs_and_files[] = $shop_path . DIR_ADMIN . 'includes/extra/application_top/application_top_end/pdf_invoice_check.php';
    $dirs_and_files[] = $shop_path . DIR_ADMIN . 'includes/extra/filenames/pdfinvoice.php';
    $dirs_and_files[] = $shop_path . DIR_ADMIN . 'includes/extra/javascript/pdfinvoice.js.php';
    $dirs_and_files[] = $shop_path . DIR_ADMIN . 'includes/extra/menu/pdfinvoice.php';
    $dirs_and_files[] = $shop_path . DIR_ADMIN . 'includes/extra/menu/pdfinvoice_del.php';
    $dirs_and_files[] = $shop_path . DIR_ADMIN . 'includes/extra/modules/orders/orders_action/pdfinvoice_invoice_number.php';
    $dirs_and_files[] = $shop_path . DIR_ADMIN . 'includes/extra/modules/orders/orders_info_blocks_end/pdf_invoice_buttons.php';
    $dirs_and_files[] = $shop_path . DIR_ADMIN . 'includes/extra/modules/orders/orders_update/pdf_invoice_send.php';

    $dirs_and_files[] = $shop_path . 'inc/xtc_pdf_invoice.inc.php';

    $dirs_and_files[] = $shop_path . 'includes/external/pdfinvoice';
    $dirs_and_files[] = $shop_path . 'includes/extra/checkout/checkout_process_end/pdf_invoice_send.php';
    $dirs_and_files[] = $shop_path . 'includes/extra/send_order/data/pdf_invoice_send.php';

    $dirs_and_files[] = $shop_path . 'lang/english/admin/pdfinvoice_del.php';
    $dirs_and_files[] = $shop_path . 'lang/english/admin/print_order_pdfinvoice.php';
    $dirs_and_files[] = $shop_path . 'lang/english/admin/print_packingslip_pdfinvoice.php';
    $dirs_and_files[] = $shop_path . 'lang/english/extra/admin/pdfinvoice.php';
    $dirs_and_files[] = $shop_path . 'lang/english/extra/pdfinvoice.php';

    $dirs_and_files[] = $shop_path . 'lang/german/admin/pdfinvoice_del.php';
    $dirs_and_files[] = $shop_path . 'lang/german/admin/print_order_pdfinvoice.php';
    $dirs_and_files[] = $shop_path . 'lang/german/admin/print_packingslip_pdfinvoice.php';
    $dirs_and_files[] = $shop_path . 'lang/german/extra/admin/pdfinvoice.php';
    $dirs_and_files[] = $shop_path . 'lang/german/extra/pdfinvoice.php';

    $templates = array('tpl_modified', 'tpl_modified_nova', 'tpl_modified_responsive', 'xtc5');
    foreach ($templates as $template) {
      $dirs_and_files[] = $shop_path . 'templates/' . $template . '/admin/print_order_pdf.html';
      $dirs_and_files[] = $shop_path . 'templates/' . $template . '/admin/print_packingslip_pdf.html';
      $dirs_and_files[] = $shop_path . 'templates/' . $template . '/admin/mail/english/invoice_mail.html';
      $dirs_and_files[] = $shop_path . 'templates/' . $template . '/admin/mail/english/invoice_mail.txt';
      $dirs_and_files[] = $shop_path . 'templates/' . $template . '/admin/mail/german/invoice_mail.html';
      $dirs_and_files[] = $shop_path . 'templates/' . $template . '/admin/mail/german/invoice_mail.txt';
      $dirs_and_files[] = $shop_path . 'templates/' . $template . '/img/logo_invoice.png';
      $dirs_and_files[] = $shop_path . 'templates/' . $template . '/lang/lang_english.pdf_strings';
      $dirs_and_files[] = $shop_path . 'templates/' . $template . '/lang/lang_german.pdf_strings';
    }

    // Dateien löschen
    foreach ($dirs_and_files as $dir_or_file) {
      if (!$this->rrmdir($dir_or_file)) {
        $messageStack->add_session($dir_or_file . MODULE_PDFINVOICE_DELETE_FILE_ERROR, 'error');
      }
    }

    // Datei selbst löschen
    unlink($shop_path . DIR_ADMIN . 'includes/modules/system/pdfinvoice.php');
    xtc_redirect(xtc_href_link(FILENAME_MODULE_EXPORT, 'set=system'));
  }

  protected function rrmdir($dir)
  {
    if (is_dir($dir)) {
      $objects = scandir($dir);
      foreach ($objects as $object) {
        if ($object != "." && $object != "..") {
          if (filetype($dir . "/" . $object) == "dir") $this->rrmdir($dir . "/" . $object);
          else unlink($dir . "/" . $object);
        }
      }
      reset($objects);
      rmdir($dir);
      return true;
    } elseif (is_file($dir)) {
      unlink($dir);
      return true;
    }
  }

  protected function check_table_config()
  {
    $config = $this->get_config();

    foreach ($config as $key => $value) {
      $query = xtc_db_query("SELECT configuration_key FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = '" . $key . "'");
      $exist = xtc_db_num_rows($query);
      if ($exist < 1) {
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values " . $value);
      }
    }
  }

  protected function remove_table_config()
  {
    $config = $this->get_config();

    foreach ($config as $key => $value) {
      xtc_db_query("DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = '" . $key . "'");
    }
  }

  protected function remove_obsolete_files_or_dirs()
  {
    global $messageStack;

    // Dateien definieren
    $shop_path = DIR_FS_CATALOG;
    $dirs_and_files = array();

    // Dateien löschen
    foreach ($dirs_and_files as $dir_or_file) {
      if (is_dir($dir_or_file) || is_file($dir_or_file)) {
        if (!$this->rrmdir($dir_or_file)) {
          $messageStack->add_session($dir_or_file . MODULE_PDFINVOICE_DELETE_FILE_ERROR, 'error');
        }
      }
    }
  }

  protected function get_config()
  {
    // select configuration_group_id dynamically, noRiddle
    $pdf_gr_id_qu = xtc_db_query("SELECT configuration_group_id FROM " . TABLE_CONFIGURATION_GROUP . " WHERE configuration_group_title = 'PDFInvoice Configuration'");
    if (xtc_db_num_rows($pdf_gr_id_qu)) {
      $pdf_gr_id_arr = xtc_db_fetch_array($pdf_gr_id_qu);
      $gr = (int)$pdf_gr_id_arr['configuration_group_id'];

      // alle Einträge in der Tabelle configuration werden hier definiert
      $config = array();

      $config['MODULE_PDFINVOICE_INVOICE_STATUS'] = "('MODULE_PDFINVOICE_INVOICE_STATUS', 'true', 6, 0, NULL, now(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),')";
      $config['MODULE_PDFINVOICE_INVOICE_GROUP'] = "('MODULE_PDFINVOICE_INVOICE_GROUP', '" . $gr . "', 6, 0, NULL, now(), NULL, NULL)";

      $config['PDFINVOICE_FILENAME'] = "('PDFINVOICE_FILENAME', 'RE_{oID}', " . $gr . ", 10, NULL, now(), NULL, NULL)";
      $config['PDFINVOICE_MAIL_INVOICE_COPY'] = "('PDFINVOICE_MAIL_INVOICE_COPY', '', " . $gr . ", 20, NULL, now(), NULL, NULL)";
      $config['PDFINVOICE_USE_ORDERID'] = "('PDFINVOICE_USE_ORDERID', 'false', " . $gr . ", 30, NULL, now(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),')";
      $config['PDFINVOICE_USE_ORDERID_PREFIX'] = "('PDFINVOICE_USE_ORDERID_PREFIX', 'RE', " . $gr . ", 40, NULL, now(), NULL, NULL)";
      $config['PDFINVOICE_USE_ORDERID_SUFFIX'] = "('PDFINVOICE_USE_ORDERID_SUFFIX', '', " . $gr . ", 50, NULL, now(), NULL, NULL)";
      $config['PDFINVOICE_SEND_ORDER'] = "('PDFINVOICE_SEND_ORDER', 'false', " . $gr . ", 60, NULL, now(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),')";
      $config['PDFINVOICE_SEND_WITH_ORDER_MAIL'] = "('PDFINVOICE_SEND_WITH_ORDER_MAIL', 'false', " . $gr . ", 70, NULL, now(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),')";
      $config['PDFINVOICE_STATUS_COMMENT'] = "('PDFINVOICE_STATUS_COMMENT', 'Rechnung versandt', " . $gr . ", 80, NULL, now(), NULL, NULL)";
      $config['PDFINVOICE_UPDATE_STATUS'] = "('PDFINVOICE_UPDATE_STATUS', 'false', " . $gr . ", 90, NULL, now(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),')";
      $config['PDFINVOICE_STATUS_ID_INVOICE'] = "('PDFINVOICE_STATUS_ID_INVOICE', '1', " . $gr . ", 100, NULL, now(), 'xtc_get_order_status_name' , 'xtc_cfg_pull_down_order_statuses(')";
      $config['PDFINVOICE_STATUS_SEND'] = "('PDFINVOICE_STATUS_SEND', 'false', " . $gr . ", 110, NULL, now(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),')";
      $config['PDFINVOICE_STATUS_SEND_ID'] = "('PDFINVOICE_STATUS_SEND_ID', '1', " . $gr . ", 120, NULL, now(), 'xtc_get_order_status_name' , 'xtc_cfg_pull_down_order_statuses(')";
      $config['PDFINVOICE_ENABLE_QRCODES'] = "('PDFINVOICE_ENABLE_QRCODES', 'false', " . $gr . ", 130, NULL, now(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),')";

      $config['PDFINVOICE_FILENAME_SLIP'] = "('PDFINVOICE_FILENAME_SLIP', 'PACK_{oID}', " . $gr . ", 200, NULL, now(), NULL, NULL)";
      $config['PDFINVOICE_MAIL_SLIP_COPY'] = "('PDFINVOICE_MAIL_SLIP_COPY', '', " . $gr . ", 210, NULL, now(), NULL, NULL)";
      $config['PDFINVOICE_SEND_SLIP_WITH_ORDER'] = "('PDFINVOICE_SEND_SLIP_WITH_ORDER', 'false', " . $gr . ", 220, NULL, now(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),')";
      $config['PDFINVOICE_STATUS_COMMENT_SLIP'] = "('PDFINVOICE_STATUS_COMMENT_SLIP', 'Lieferschein versandt', " . $gr . ", 230, NULL, now(), NULL, NULL)";
      $config['PDFINVOICE_MAIL_SLIP_FORWARDER'] = "('PDFINVOICE_MAIL_SLIP_FORWARDER', 'false', " . $gr . ", 240, NULL, now(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),')";
      $config['PDFINVOICE_MAIL_SLIP_FORWARDER_NAME'] = "('PDFINVOICE_MAIL_SLIP_FORWARDER_NAME', '', " . $gr . ", 250, NULL, now(), NULL, NULL)";
      $config['PDFINVOICE_MAIL_SLIP_FORWARDER_EMAIL'] = "('PDFINVOICE_MAIL_SLIP_FORWARDER_EMAIL', '', " . $gr . ", 260, NULL, now(), NULL, NULL)";
      $config['PDFINVOICE_UPDATE_STATUS_SLIP'] = "('PDFINVOICE_UPDATE_STATUS_SLIP', 'false', " . $gr . ", 270, NULL, now(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),')";
      $config['PDFINVOICE_STATUS_ID_SLIP'] = "('PDFINVOICE_STATUS_ID_SLIP', '1', " . $gr . ", 280, NULL, now(), 'xtc_get_order_status_name' , 'xtc_cfg_pull_down_order_statuses(')";
      $config['PDFINVOICE_STATUS_SEND_WITH_SLIP'] = "('PDFINVOICE_STATUS_SEND_WITH_SLIP', 'false', " . $gr . ", 290, NULL, now(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),')";
      $config['PDFINVOICE_STATUS_SEND_WITH_SLIP_ID'] = "('PDFINVOICE_STATUS_SEND_WITH_SLIP_ID', '1', " . $gr . ", 300, NULL, now(), 'xtc_get_order_status_name' , 'xtc_cfg_pull_down_order_statuses(')";

      $config['PDFINVOICE_PROTECT_PDF'] = "('PDFINVOICE_PROTECT_PDF', 'false', " . $gr . ", 400, NULL, now(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),')";
      $config['PDFINVOICE_MASTER_PASS'] = "('PDFINVOICE_MASTER_PASS', 'masterpass', " . $gr . ", 410, NULL, now(), NULL, NULL)";
      $config['PDFINVOICE_USE_CUSTOMER_ID'] = "('PDFINVOICE_USE_CUSTOMER_ID', 'false', " . $gr . ", 420, NULL, now(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),')";

      return $config;
    }
  }

  protected function table_exists($table_name)
  {
    $Table = xtc_db_query("show tables like '" . $table_name . "'");
    if (xtc_db_num_rows($Table) < 1) {
      return (false);
    } else {
      return (true);
    }
  }
}
