<?php
/*
Plugin Name: Register PhpBB
Version: 2.1.a
Description: Link user registration from Piwigo to PhpBB forum (registration, password changing, deletion) - Original Eric's Register_FluxBB plugin adapted to PhpBB. / Liez l'inscription des utilisateurs de Piwigo avec votre forum PhpBB - Adaptation du plugin Register_FluxBB d'Eric.
Plugin URI: http://fr.piwigo.org/ext/extension_view.php?eid=129
Author: Pierric, Eric
Author URI: http://www.infernoweb.net
*/

/*
--------------------------------------------------------------------------------
  Author     : Pierric, Eric
    email    : pierrot007@gmail.com, eric@piwigo.org
    website  : http://www.infernoweb.net
    PWG user : http://fr.piwigo.org/forum/profile.php?id=5784, http://forum.phpwebgallery.net/profile.php?id=1106
--------------------------------------------------------------------------------

:: HISTORY

2.1.a		- 15/11/2010 - Initial release.
--------------------------------------------------------------------------------
*/

// pour faciliter le debug - make debug easier :o)
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', true);

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

if (!defined('REGPHPBB_DIR')) define('REGPHPBB_DIR' , basename(dirname(__FILE__)));
if (!defined('REGPHPBB_PATH')) define('REGPHPBB_PATH' , PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');

include_once (REGPHPBB_PATH.'include/constants.php');
include_once (REGPHPBB_PATH.'include/functions.inc.php');


/* plugin administration */
add_event_handler('get_admin_plugin_menu_links', 'Register_PhpBB_admin_menu');

function Register_PhpBB_admin_menu($menu)
{
  array_push($menu, array(
    'NAME' => 'Register PhpBB',
    'URL'  => get_admin_plugin_menu_link(REGPHPBB_PATH.'admin/admin.php')));
  return $menu;
}


/* user creation*/
add_event_handler('register_user', 'Register_PhpBB_Adduser');

function Register_PhpBB_Adduser($register_user)
{
  global $conf;

  // Exclusion of Adult_Content users
  if ($register_user['username'] != "16" and $register_user['username'] != "18")
  {
    include_once (REGPHPBB_PATH.'include/functions.inc.php');

    // Warning : PhpBB uses md5 hash like Piwigo, but not like PhpBB !
    PhpBB_Adduser($register_user['id'], $register_user['username'], md5($_POST['password']), $register_user['email']);
  }
}


/* user deletion */
add_event_handler('delete_user', 'Register_PhpBB_Deluser');

function Register_PhpBB_Deluser($user_id)
{
  include_once (REGPHPBB_PATH.'include/functions.inc.php');

  PhpBB_Deluser( PhpBB_Searchuser($user_id), true );
}


/* Profile management */
if (script_basename() == 'profile')
{
  add_event_handler('loc_begin_profile', 'Register_PhpBB_InitPage', EVENT_HANDLER_PRIORITY_NEUTRAL, 2);

  function Register_PhpBB_InitPage()
  {
    global $conf, $user;
    include_once (REGPHPBB_PATH.'include/functions.inc.php');

    if (isset($_POST['validate']) and !is_admin())
    {
    if (!empty($_POST['use_new_pwd']))
      {
      $query = '
SELECT '.$conf['user_fields']['username'].' AS username
FROM '.USERS_TABLE.'
WHERE '.$conf['user_fields']['id'].' = \''.$user['id'].'\'
;';

      list($username) = pwg_db_fetch_row(pwg_query($query));

      PhpBB_Updateuser($user['id'], stripslashes($username), md5($_POST['use_new_pwd']), $_POST['mail_address']);
      }
    }
  }
}


/* Access validation in PhpBB when validated in Piwigo through UAM plugin */
add_event_handler('login_success', 'UAM_Bridge', EVENT_HANDLER_PRIORITY_NEUTRAL, 2);

function UAM_Bridge()
{
  global $conf, $user;

  $conf_Register_PhpBB = isset($conf['Register_PhpBB']) ? explode(";" , $conf['Register_PhpBB']) : array();

  // Check if UAM is installed and if bridge is set - Exception for admins and webmasters
  $query ='
SELECT user_id, status
FROM '.USER_INFOS_TABLE.'
WHERE user_id = '.$user['id'].'
;';
  $data = pwg_db_fetch_assoc(pwg_query($query));

  if ($data['status'] <> "admin" and $data['status'] <> "webmaster")
  {
    if (function_exists('FindAvailableConfirmMailID') and isset($conf_Register_PhpBB[5]) and $conf_Register_PhpBB[5] == 'true')
    {
      $conf_UAM = unserialize($conf['UserAdvManager']);

      // Getting unvalidated users group else Piwigo's default group
      if (isset($conf_UAM[2]) and $conf_UAM[2] != '-1')
      {
        $Waitingroup = $conf_UAM[2];
      }
      else
      {
        $query = '
SELECT id
FROM '.GROUPS_TABLE.'
WHERE is_default = "true"
LIMIT 1
;';
        $data = pwg_db_fetch_assoc(pwg_query($query));
        $Waitingroup = $data['id'];
      }

      // check if logged in user is in a Piwigo's validated or unvalidated users group
      $query = '
SELECT *
FROM '.USER_GROUP_TABLE.'
WHERE user_id = '.$user['id'].'
AND group_id = '.$Waitingroup.'
;';
      $count = pwg_db_num_rows(pwg_query($query));

      // Check if logged in user is in a PhpBB's unvalidated group
      $query = "
SELECT group_id
FROM ".PhpBB_USERS_TABLE."
WHERE user_id = ".PhpBB_Searchuser($user['id'])."
;";

      $data = pwg_db_fetch_assoc(pwg_query($query));

      $query = "
SELECT group_id
FROM ".PhpBB_GROUPS_TABLE."
WHERE group_name = '".$conf_Register_PhpBB[6]."'
;";
      $data1 = pwg_db_fetch_assoc(pwg_query($query));

      // Logged in user switch to the default PhpBB's group if he'is validated
      if ($count == 0 and $data['group_id'] != $data1['group_id'])
      {
        $query = "
SELECT group_id, group_colour
FROM ".PhpBB_GROUPS_TABLE."
WHERE group_name = '".$conf_Register_PhpBB[6]."'
;";
        $default_user = pwg_db_fetch_assoc(pwg_query($query));

        $query = "
UPDATE ".PhpBB_USERS_TABLE."
SET group_id = '".$default_user['group_id']."', user_colour = '".$default_user['group_colour']."'
WHERE user_id = ".PhpBB_Searchuser($user['id'])."
;";
        $result = pwg_query($query);

      	$query = "
UPDATE ".PhpBB_USERGROUP_TABLE."
SET group_id = '".$default_user['group_id']."'
WHERE user_id = ".PhpBB_Searchuser($user['id'])."
;";
      	$result = pwg_query($query);
      }
    }
  }
}
?>