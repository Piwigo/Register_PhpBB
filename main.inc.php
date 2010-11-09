<?php
/*
Plugin Name: Register PhpBB
Version: 1.2a
Description: Ce plugin permet d'enregistrer automatiquement un utilisateur de PWG dans un forum PhpBB. Rendez-vous dans le panneau d'administration du plugin pour finaliser les paramètres - This plugin allows to automatically register a PWG user in a PhpBB forum. Go to plugin administration panel to finalize the settings. Based on original Mod by Flipflip.
Plugin URI: http://phpwebgallery.net/ext/extension_view.php?eid=129
Author: Eric
Author URI: http://www.infernoweb.net
*/
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

/* ******************* */
/* Class of the plugin */
/* ******************* */
class Register_PhpBB
{
/* Set the administration panel of the plugin */
  function plugin_admin_menu($menu)
  {
    array_push($menu,
        array(
          'NAME' => 'Register PhpBB',
          'URL' => get_admin_plugin_menu_link(dirname(__FILE__).'/admin/reg_phpbb_admin.php')
        )
      );
    return $menu;
  }

/* User adding */
  function PhpBB_Adduser($register_user)
  {
  	include_once (PHPWG_ROOT_PATH.'/include/constants.php');
  	include_once (dirname(__FILE__).'/include/constants.php');
	load_conf_from_db('param like \'phpbb\\_%\'');
	global $conf;
	if ($conf['phpbb_status'])
		include (dirname(__FILE__).'/reg_phpbb_adduser.php');
  }

/* User deletion */
   function PhpBB_Deluser($user_id)
  {
  	include_once (PHPWG_ROOT_PATH.'/include/constants.php');
  	include_once (dirname(__FILE__).'/include/constants.php');
	load_conf_from_db('param like \'phpbb\\_%\'');
  	global $conf;
	if ($conf['phpbb_status'])
		include (dirname(__FILE__).'/reg_phpbb_deluser.php');
  }
}

$obj = new Register_PhpBB(); /* class loading */

add_event_handler( 'register_user', array(&$obj, 'PhpBB_Adduser') );
add_event_handler( 'delete_user', array(&$obj, 'PhpBB_Deluser') );
add_event_handler('get_admin_plugin_menu_links', array(&$obj, 'plugin_admin_menu') );
set_plugin_data($plugin['id'], $obj);
?>