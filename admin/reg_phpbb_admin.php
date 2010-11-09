<?php
// +-----------------------------------------------------------------------+
// | Plugin Name : Register_PhpBB                                          |
// | Plugin Version : 1.2a                                                 |
// | File Version : 0.1                                                    |
// | Plugin Version author : Eric <lucifer@infernoweb.net>                 |
// | Plugin description :                                                  |
// | Ce plugin permet l'enregistrement d'un utilisateur directement dans   |
// | phpbb - This plugin allows to automatically register a PWG user in a  |
// | phpbb forum                                                           |
// +-----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify  |
// | it under the terms of the GNU General Public License as published by  |
// | the Free Software Foundation                                          |
// |                                                                       |
// | This program is distributed in the hope that it will be useful, but   |
// | WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU      |
// | General Public License for more details.                              |
// |                                                                       |
// | You should have received a copy of the GNU General Public License     |
// | along with this program; if not, write to the Free Software           |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, |
// | USA.                                                                  |
// +-----------------------------------------------------------------------+

// ***************************************
// ** Plugin Administration panel setup **
// ***************************************

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

/* ****************************************************** */
/* Plugin template initialisation for admin panel display */
/* ****************************************************** */

$me = get_plugin_data($plugin_id);

global $template;

// Setup plugin Language
  $RPlang = ( isset($user['language']) ) ?
    $user['language'] : $conf['default_language']; // en_UK.iso-8859-1
  $my_path = dirname(__FILE__).'/../';
  $rp = array();
  if ( !@file_exists($my_path."language/$RPlang/lang.admin.regphpbb.php") )
  {
    $SIElang = 'en_UK.iso-8859-1';
  }
// Include language
  @include_once( $my_path."language/$RPlang/lang.admin.regphpbb.php" );

// Load configuration settings from database
load_conf_from_db('param like \'phpbb\\_%\'');

// Update configuration settings in database
if ( isset($_POST['submit']) )
{
  $query = '
UPDATE '.CONFIG_TABLE.'
  SET value="'.$_POST['phpbb_status'].'"
  WHERE param="phpbb_status"
  LIMIT 1';
  pwg_query($query);

  $query = '
UPDATE '.CONFIG_TABLE.'
  SET value="'.$_POST['phpbb_prefix'].'"
  WHERE param="phpbb_prefix"
  LIMIT 1';
  pwg_query($query);
  
  $query = '
UPDATE '.CONFIG_TABLE.'
  SET value="'.$_POST['phpbb_admin'].'"
  WHERE param="phpbb_admin"
  LIMIT 1';
  pwg_query($query);

  $query = '
UPDATE '.CONFIG_TABLE.'
  SET value="'.$_POST['phpbb_timezone'].'"
  WHERE param="phpbb_timezone"
  LIMIT 1';
  pwg_query($query);
  
  $query = '
UPDATE '.CONFIG_TABLE.'
  SET value="'.$_POST['phpbb_language'].'"
  WHERE param="phpbb_language"
  LIMIT 1';
  pwg_query($query);
  
  $query = '
UPDATE '.CONFIG_TABLE.'
  SET value="'.$_POST['phpbb_style'].'"
  WHERE param="phpbb_style"
  LIMIT 1';
  pwg_query($query);
  
  $query = '
UPDATE '.CONFIG_TABLE.'
  SET value="'.$_POST['phpbb_del_pt'].'"
  WHERE param="phpbb_del_pt"
  LIMIT 1';
  pwg_query($query);

// Reload settings for correct display after update
load_conf_from_db('param like \'phpbb\\_%\'');
}

// Users migration from PWG to PhpBB
//TODO: How to insert migration results in pwg template or a new blank window ?
if ( isset($_POST['Migration']) )
{
	include_once (PHPWG_ROOT_PATH.'plugins/Register_Phpbb/include/constants.php');
	include (PHPWG_ROOT_PATH.'plugins/Register_Phpbb/reg_phpbb_migration.php');
}

// Users table synchronization
//TODO: How to insert synchronization results in pwg template or a new blank window ?
if ( isset($_POST['Synchro']) )
{
	include_once (PHPWG_ROOT_PATH.'plugins/Register_Phpbb/include/constants.php');
	include (PHPWG_ROOT_PATH.'plugins/Register_Phpbb/reg_phpbb_synchro.php');
}

/* Template settings */
$template->assign_vars(
    array(
      'PHPBB_STATUS' => $conf['phpbb_status'],
	  'PHPBB_PREFIX' => $conf['phpbb_prefix'],
      'PHPBB_ADMIN' => $conf['phpbb_admin'],
      'PHPBB_TIMEZONE' => $conf['phpbb_timezone'],
      'PHPBB_LANGUAGE' => $conf['phpbb_language'],
      'PHPBB_STYLE' => $conf['phpbb_style'],
      'PHPBB_DEL_PT' => $conf['phpbb_del_pt'],
    )
  );

$template->set_filenames( array('plugin_admin_content' => dirname(__FILE__).'/reg_phpbb_admin.tpl') );

$template->assign_var_from_handle( 'ADMIN_CONTENT', 'plugin_admin_content');
?>