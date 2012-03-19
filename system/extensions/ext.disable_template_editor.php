<?php  if ( ! defined('EXT')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package   ExpressionEngine
 * @author    ExpressionEngine Dev Team
 * @copyright Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license   http://expressionengine.com/user_guide/license.html
 * @link      http://expressionengine.com
 * @since     Version 2.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Disable Template Editor Extension
 *
 * @package     ExpressionEngine
 * @subpackage  Addons
 * @category    Extension
 * @author      CueBit
 * @link        http://cuebit.co.uk/
 */
class Disable_template_editor
{
  public $settings       = array();
  public $name           = 'Disable Template Editor';
  public $version        = '1.0.1';
  public $description    = 'Disables the EE template editor for users to control templates via source control. This prevents folks from creating out of sync issues between the server and repo.';
  public $settings_exist = 'n';
  public $docs_url       = 'https://github.com/cuebit/disable_template_editor';

  /**
   * Class constructor
   *
   * @access  public
   * @param   mixed   $settings [settings array or empty string if none exist]
   * @return  void
   */
  public function __construct($settings = '')
  {
    $this->settings = $settings;
  }

  // --------------------------------------------------------------------

  /**
   * Class constructor fallback for PHP4
   *
   * @access public
   * @return void
   */
  public function Disable_template_editor()
  {
    call_user_func_array(array($this, '__construct'), func_get_args());
  }

  // --------------------------------------------------------------------

  /**
   * Activate Extension
   *
   * Register hooks by adding them to the database.
   *
   * @access public
   * @return void
   */
  public function activate_extension()
  {
    global $DB;

    $DB->query(
      $DB->insert_string('exp_extensions',
        array(
          'extension_id' => '',
          'class'        => __CLASS__,
          'method'       => 'inject_cp_js',
          'hook'         => 'show_full_control_panel_end',
          'settings'     => serialize($this->settings),
          'version'      => $this->version,
          'enabled'      => 'y'
        )//array
      )//insert_string
    );//query
  }

  // --------------------------------------------------------------------

  /**
   * Update Extension
   *
   * Mandatory method though there won't be any database changes.
   *
   * @access public
   * @param  mixed    $current [current installed version]
   * @return boolean
   */
  public function update_extension($current = '')
  {
    if ($current == '' OR $current == $this->version)
    {
      return FALSE;
    }
  }

  // --------------------------------------------------------------------

  /**
   * Disable Extension
   *
   * Remove the extension reference from the database.
   *
   * @access public
   * @return void
   */
  public function disable_extension()
  {
    global $DB;

    $DB->query(
      sprintf("DELETE FROM exp_extensions WHERE class = '%s'", __CLASS__)
    );
  }

  // --------------------------------------------------------------------

  /**
   * Adds script tags to the head of CP pages
   *
   * @access public
   * @return string
   */
  public function inject_cp_js($html)
  {
    global $EXT;

    $html = ($EXT->last_call !== FALSE) ? $EXT->last_call : $html;
    $find = '</body>';
    $replace = <<<EOF
<script type="text/javascript">
  $(function(){
    $('.templatePrefBox').each(function(){
      $('.itemWrapper', this).filter(':eq(1),:eq(2),:eq(3)').hide();
    });
    if($('.templatePrefBox').length) $('.breadcrumbRight > a').hide();
    if($('#template_data').length){
      $('#template_data').attr('readonly','readonly');
      $('.templatebox, #notes, #noteslink').hide();
      $('#revisions')
        .find('.tableHeading:first').text('Read-only. Template in source control ').end()
        .find('.tableHeading:not(:first)').hide();
    }
  });
</script>
</body>
EOF;

    $html = str_replace($find, $replace, $html);

    return $html;
  }
}

/* End of file ext.disable_template_editor.php */
/* Location: ./system/extensions/ext.disable_template_editor.php */