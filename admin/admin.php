<?php

global $user, $lang, $conf, $template, $errors;

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

if (!defined('REGPHPBB_PATH')) define('REGPHPBB_PATH' , PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

include_once (PHPWG_ROOT_PATH.'admin/include/tabsheet.class.php');
include_once (PHPWG_ROOT_PATH.'/include/constants.php');

$my_base_url = get_admin_plugin_menu_link(__FILE__);
load_language('plugin.lang', REGPHPBB_PATH);

// +-----------------------------------------------------------------------+
// |                            Tabssheet                                  |
// +-----------------------------------------------------------------------+
if (!isset($_GET['tab']))
  $page['tab'] = 'info';
else
  $page['tab'] = $_GET['tab'];

$tabsheet = new tabsheet();
$tabsheet->add('info',
            l10n('Tab_Info'),
            $my_base_url.'&amp;tab=info');
$tabsheet->add('manage',
            l10n('Tab_Manage'),
            $my_base_url.'&amp;tab=manage');
$tabsheet->add('Migration',
            l10n('Tab_Migration'),
            $my_base_url.'&amp;tab=Migration');
$tabsheet->add('Synchro',
            l10n('Tab_Synchro'),
            $my_base_url.'&amp;tab=Synchro');
$tabsheet->select($page['tab']);
$tabsheet->assign();


$page['infos'] = array();
$error = array();

// +-----------------------------------------------------------------------+
// |                      Getting plugin version                           |
// +-----------------------------------------------------------------------+
$plugin =  RegPhpBB_Infos(REGPHPBB_PATH);
$version = $plugin['version'] ;

// +-----------------------------------------------------------------------+
// |                            Functions
// +-----------------------------------------------------------------------+
function Audit_PWG_PhpBB()
{
  global $page, $conf, $errors;

  $conf_Register_PhpBB = isset($conf['Register_PhpBB']) ? explode(";" , $conf['Register_PhpBB']) : array();

  $page_Register_PhpBB_admin = get_admin_plugin_menu_link(__FILE__);



  $msg_error_PWG_Dup = '';
  $msg_error_PhpBB_Dup = '';
  $msg_error_Link_Break = '';
  $msg_error_Link_Bad = '';
  $msg_error_Synchro = '';
  $msg_ok_Synchro = '';
  $msg_error_PWG2PhpBB = '';
  $msg_error_PhpBB2PWG = '';



  $query = "
SELECT COUNT(*) AS nbr_dup, id, username
FROM ".USERS_TABLE."
GROUP BY BINARY username
HAVING COUNT(*) > 1
;";
  $result = pwg_query($query);

  while($row = pwg_db_fetch_assoc($result))
    $msg_error_PWG_Dup .= '<br>'.l10n('Error_PWG_Dup').$row['nbr_dup'].' x '.stripslashes($row['username']);

  if ($msg_error_PWG_Dup == '')
    array_push($page['infos'], l10n('Audit_PWG_Dup').'<br>'.l10n('Audit_OK'));
  else
    $msg_error_PWG_Dup = l10n('Audit_PWG_Dup').$msg_error_PWG_Dup.'<br>'.l10n('Advise_PWG_Dup');



  $query = "
SELECT COUNT(*) AS nbr_dup, username
FROM ".PhpBB_USERS_TABLE."
GROUP BY BINARY username
HAVING COUNT(*) > 1
;";
  $result = pwg_query($query);

  while($row = pwg_db_fetch_assoc($result))
  {
    $msg_error_PhpBB_Dup .= '<br>'.l10n('Error_PhpBB_Dup').$row['nbr_dup'].' x '.stripslashes($row['username']);

    $subquery = "
SELECT user_id, username, user_email
FROM ".PhpBB_USERS_TABLE."
WHERE BINARY username = BINARY '".$row['username']."'
;";
    $subresult = pwg_query($subquery);

    while($subrow = pwg_db_fetch_assoc($subresult))
    {
      $msg_error_PhpBB_Dup .= '<br>id:'.$subrow['user_id'].'='.stripslashes($subrow['username']).' ('.$subrow['user_email'].')';

      if ( !is_adviser() )
      {
        $msg_error_PhpBB_Dup .= ' <a href="';

        $msg_error_PhpBB_Dup .= add_url_params($page_Register_PhpBB_admin, array(
          'action' => 'del_user',
          'user_id' => $subrow['user_id'],
        ));

        $msg_error_PhpBB_Dup .= '" title="'.l10n('Del_User').stripslashes($subrow['username']).'"';

        $msg_error_PhpBB_Dup .= $conf_Register_PhpBB[3]=='false' ?  ' onclick="return confirm(\''.l10n('Are you sure?').'\');" ' : ' ';

        $msg_error_PhpBB_Dup .= '><img src="'.REGPHPBB_PATH.'/admin/template/icon/user_delete.png" alt="'.l10n('Del_User').$subrow['username'].'" /></a>';
      }
    }
  }

  if ($msg_error_PhpBB_Dup == '')
    array_push($page['infos'], l10n('Audit_PhpBB_Dup').'<br>'.l10n('Audit_OK'));
  else
    $msg_error_PhpBB_Dup = l10n('Audit_PhpBB_Dup').$msg_error_PhpBB_Dup.'<br>'.l10n('Advise_PhpBB_Dup');



  $query = "
SELECT pwg.id as pwg_id, bb.user_id as bb_id, pwg.username as pwg_user, pwg.mail_address as pwg_mail
FROM ".PhpBB_USERS_TABLE." AS bb, ".USERS_TABLE." as pwg
WHERE bb.user_id NOT in (
  SELECT id_user_PhpBB
  FROM ".Register_PhpBB_ID_TABLE."
  )
AND pwg.id NOT in (
  SELECT id_user_pwg
  FROM ".Register_PhpBB_ID_TABLE."
  )
AND pwg.username = bb.username
AND pwg.mail_address = bb.user_email
;";

  $result = pwg_query($query);

  while($row = pwg_db_fetch_assoc($result))
  {
    $msg_error_Link_Break .= '<br>'.l10n('Error_Link_Break').stripslashes($row['pwg_user']).' ('.$row['pwg_mail'].')';

    if ( !is_adviser() )
    {
      $msg_error_Link_Break .= ' <a href="';

      $msg_error_Link_Break .= add_url_params($page_Register_PhpBB_admin, array(
        'action'   => 'new_link',
        'pwg_id' => $row['pwg_id'],
        'bb_id' => $row['bb_id'],
      ));

      $msg_error_Link_Break .= '" title="'.l10n('New_Link').stripslashes($row['pwg_user']).'"';

      $msg_error_Link_Break .= $conf_Register_PhpBB[3]=='false' ?  ' onclick="return confirm(\''.l10n('Are you sure?').'\');" ' : ' ';

      $msg_error_Link_Break .= '><img src="'.REGPHPBB_PATH.'/admin/template/icon/link_break.png" alt="'.l10n('New_Link').stripslashes($row['pwg_user']).'" /></a>';
    }
  }

  if ($msg_error_Link_Break == '')
    array_push($page['infos'], l10n('Audit_Link_Break').'<br>'.l10n('Audit_OK'));
  else
    $msg_error_Link_Break = l10n('Audit_Link_Break').$msg_error_Link_Break;



  $query = "
SELECT pwg.username as pwg_user, pwg.id as pwg_id, pwg.mail_address as pwg_mail, bb.user_id as bb_id, bb.username as bb_user, bb.user_email as bb_mail
FROM ".PhpBB_USERS_TABLE." AS bb
INNER JOIN ".Register_PhpBB_ID_TABLE." AS link ON link.id_user_PhpBB = bb.user_id
INNER JOIN ".USERS_TABLE." as pwg ON link.id_user_pwg = pwg.id
WHERE pwg.username <> bb.username
;";

  $result = pwg_query($query);

  while($row = pwg_db_fetch_assoc($result))
  {
    $msg_error_Link_Bad .= '<br>'.l10n('Error_Link_Del').stripslashes($row['pwg_user']).' ('.$row['pwg_mail'].')'.' -- '.stripslashes($row['bb_user']).' ('.$row['bb_mail'].')';

    if ( !is_adviser() )
    {
      $msg_error_Link_Bad .= ' <a href="';

      $msg_error_Link_Bad .= add_url_params($page_Register_PhpBB_admin, array(
        'action'   => 'link_del',
        'pwg_id' => $row['pwg_id'],
        'bb_id'  => $row['bb_id'],
      ));

      $msg_error_Link_Bad .= '" title="'.l10n('Link_Del').stripslashes($row['pwg_user']).' -- '.stripslashes($row['bb_user']).'"';

      $msg_error_Link_Bad .= $conf_Register_PhpBB[3]=='false' ?  ' onclick="return confirm(\''.l10n('Are you sure?').'\');" ' : ' ';

      $msg_error_Link_Bad .= '><img src="'.REGPHPBB_PATH.'/admin/template/icon/link_delete.png" alt="'.l10n('Link_Del').stripslashes($row['pwg_user']).' -- '.stripslashes($row['bb_user']).'" /></a>';

      $msg_error_Link_Bad .= ' -- <a href="';

      $msg_error_Link_Bad .= add_url_params($page_Register_PhpBB_admin, array(
        'action' => 'sync_user',
        'username' => stripslashes($row['pwg_user']),
      ));

      $msg_error_Link_Bad .= '" title="'.l10n('Sync_User').stripslashes($row['pwg_user']).' --> '.stripslashes($row['bb_user']).'"';

      $msg_error_Link_Bad .= $conf_Register_PhpBB[3]=='false' ?  ' onclick="return confirm(\''.l10n('Are you sure?').'\');" ' : ' ';

      $msg_error_Link_Bad .= '><img src="'.REGPHPBB_PATH.'/admin/template/icon/arrow_switch.png" alt="'.l10n('Sync_User').stripslashes($row['pwg_user']).' --> '.stripslashes($row['bb_user']).'" /></a>';
    }
  }


  $query = "
SELECT COUNT(*) as nbr_dead
FROM ".Register_PhpBB_ID_TABLE." AS Link
WHERE id_user_PhpBB NOT IN (
  SELECT user_id
  FROM ".PhpBB_USERS_TABLE."
  )
OR id_user_pwg NOT IN (
  SELECT id
  FROM ".USERS_TABLE."
  )
;";

  $Compteur = pwg_db_fetch_assoc(pwg_query($query));

  if (!empty($Compteur) and $Compteur['nbr_dead'] > 0)
  {
    $msg_error_Link_Bad .= '<br>'.l10n('Error_Link_Dead').$Compteur['nbr_dead'];

    if ( !is_adviser() )
    {
      $msg_error_Link_Bad .= ' <a href="';

      $msg_error_Link_Bad .= add_url_params($page_Register_PhpBB_admin, array(
        'action'   => 'link_dead',
      ));

      $msg_error_Link_Bad .= '" title="'.l10n('Link_Dead').$Compteur['nbr_dead'].'"';

      $msg_error_Link_Bad .= $conf_Register_PhpBB[3]=='false' ?  ' onclick="return confirm(\''.l10n('Are you sure?').'\');" ' : ' ';

      $msg_error_Link_Bad .= '><img src="'.REGPHPBB_PATH.'/admin/template/icon/link_delete.png" alt="'.l10n('Link_Dead').$Compteur['nbr_dead'].'" /></a>';
    }
  }

  $query = "
SELECT COUNT(*) AS nbr_dup, pwg.id AS pwg_id, pwg.username AS pwg_user, bb.username AS bb_user, bb.user_id AS bb_id
FROM ".PhpBB_USERS_TABLE." AS bb
INNER JOIN ".Register_PhpBB_ID_TABLE." AS link ON link.id_user_PhpBB = bb.user_id
INNER JOIN ".USERS_TABLE." as pwg ON link.id_user_pwg = pwg.id
GROUP BY link.id_user_pwg, link.id_user_PhpBB
HAVING COUNT(*) > 1
;";

  $result = pwg_query($query);

  while($row = pwg_db_fetch_assoc($result))
  {
    $msg_error_Link_Bad .= '<br>'.l10n('Error_Link_Dup').$row['nbr_dup'].' = '.stripslashes($row['pwg_user']).' -- '.stripslashes($row['bb_user']).')';

    if ( !is_adviser() )
    {
      $msg_error_Link_Bad .= ' <a href="';

      $msg_error_Link_Bad .= add_url_params($page_Register_PhpBB_admin, array(
        'action'   => 'new_link',
        'pwg_id' => $row['pwg_id'],
        'bb_id' => $row['bb_id'],
      ));

      $msg_error_Link_Bad .= '" title="'.l10n('Link_Dup').stripslashes($row['pwg_user']).' -- '.stripslashes($row['bb_user']).'"';

      $msg_error_Link_Bad .= $conf_Register_PhpBB[3]=='false' ?  ' onclick="return confirm(\''.l10n('Are you sure?').'\');" ' : ' ';

      $msg_error_Link_Bad .= '><img src="'.REGPHPBB_PATH.'/admin/template/icon/link_error.png" alt="'.l10n('Link_Dup').stripslashes($row['pwg_user']).' -- '.stripslashes($row['bb_user']).'" /></a>';
    }
  }

  if ($msg_error_Link_Bad == '')
    array_push($page['infos'], l10n('Audit_Link_Bad').'<br>'.l10n('Audit_OK'));
  else
    $msg_error_Link_Bad = l10n('Audit_Link_Bad').$msg_error_Link_Bad;



  $query = "
SELECT pwg.username as username, pwg.password as pwg_pwd, pwg.mail_address as pwg_eml, PhpBB.user_password as bb_pwd, PhpBB.user_email as bb_eml
FROM ".PhpBB_USERS_TABLE." AS PhpBB
INNER JOIN ".Register_PhpBB_ID_TABLE." AS link ON link.id_user_PhpBB = PhpBB.user_id
INNER JOIN ".USERS_TABLE." as pwg ON link.id_user_pwg = pwg.id
AND BINARY pwg.username = BINARY PhpBB.username
ORDER BY LOWER(pwg.username)
;";

  $result = pwg_query($query);

  while($row = pwg_db_fetch_assoc($result))
  {
    if ( ($row['pwg_pwd'] != $row['bb_pwd']) or ($row['pwg_eml'] != $row['bb_eml']) )
    {
      $msg_error_Synchro .= '<br>'.l10n('Error_Synchro').stripslashes($row['username']);

      if ( !is_adviser() )
      {
        $msg_error_Synchro .= ' <a href="';

        $msg_error_Synchro .= add_url_params($page_Register_PhpBB_admin, array(
          'action' => 'sync_user',
          'username' => stripslashes($row['username']),
        ));

        $msg_error_Synchro .= '" title="'.l10n('Sync_User').stripslashes($row['username']).'"';

        $msg_error_Synchro .= $conf_Register_PhpBB[3]=='false' ?  ' onclick="return confirm(\''.l10n('Are you sure?').'\');" ' : ' ';
        $msg_error_Synchro .= '><img src="'.REGPHPBB_PATH.'/admin/template/icon/user_refresh.png" alt="'.l10n('Sync_User').stripslashes($row['username']).'" /></a>';
      }

      if ($row['pwg_pwd'] != $row['bb_pwd'])
        $msg_error_Synchro .= '<br>'.l10n('Error_Synchro_Pswd');

      if ($row['pwg_eml'] != $row['bb_eml'])
        $msg_error_Synchro .= '<br>'.l10n('Error_Synchro_Mail').'<br>-- PWG = '.$row['pwg_eml'].'<br>-- PhpBB = '.$row['bb_eml'];
    }
    else if ($conf_Register_PhpBB[4] == 'true')
      $msg_ok_Synchro .= '<br> - '.stripslashes($row['username']).' ('.$row['pwg_eml'].')'.l10n('Audit_Synchro_OK');
  }

  if ($msg_error_Synchro <> '')
    $msg_error_Synchro = l10n('Audit_Synchro').$msg_error_Synchro;

  if ($msg_ok_Synchro <> '')
    if ($msg_error_Synchro <> '')
      array_push($page['infos'], l10n('Audit_Synchro').$msg_ok_Synchro.'<br><br>');
    else
      array_push($page['infos'], l10n('Audit_Synchro').$msg_ok_Synchro.'<br><br>'.l10n('Audit_OK'));


  $query = "
SELECT username, mail_address FROM ".USERS_TABLE."
WHERE BINARY username <> BINARY 'guest'
AND id not in (
  SELECT id_user_pwg FROM ".Register_PhpBB_ID_TABLE."
  )
AND BINARY username not in (
  SELECT username FROM ".PhpBB_USERS_TABLE."
  )
ORDER BY LOWER(username)
;";

  $result = pwg_query($query);

  while($row = pwg_db_fetch_assoc($result))
  {
    $msg_error_PWG2PhpBB .= '<br>'.l10n('Error_PWG2PhpBB').stripslashes($row['username']).' ('.$row['mail_address'].')';

    if ( !is_adviser() )
    {
      $msg_error_PWG2PhpBB .= ' <a href="';

      $msg_error_PWG2PhpBB .= add_url_params($page_Register_PhpBB_admin, array(
        'action' => 'add_user',
        'username' => stripslashes($row['username']),
      ));

      $msg_error_PWG2PhpBB .= '" title="'.l10n('Add_User').stripslashes($row['username']).'" ';

      $msg_error_PWG2PhpBB .= $conf_Register_PhpBB[3]=='false' ?  ' onclick="return confirm(\''.l10n('Are you sure?').'\');" ' : ' ';

      $msg_error_PWG2PhpBB .= '><img src="'.REGPHPBB_PATH.'/admin/template/icon/user_add.png" alt="'.l10n('Add_User').stripslashes($row['username']).'" /></a>';
    }
  }

  if ($msg_error_PWG2PhpBB == '')
    array_push($page['infos'], l10n('Audit_PWG2PhpBB').'<br>'.l10n('Audit_OK'));
  else
    $msg_error_PWG2PhpBB = l10n('Audit_PWG2PhpBB').$msg_error_PWG2PhpBB;



  $query = "
SELECT user_id, username, user_email FROM ".PhpBB_USERS_TABLE."
WHERE BINARY username <> BINARY '".$conf_Register_PhpBB[2]."'
AND user_id not in (
  SELECT id_user_PhpBB FROM ".Register_PhpBB_ID_TABLE."
  )
AND BINARY username not in (
  SELECT username FROM ".USERS_TABLE."
  )
ORDER BY LOWER(username)
;";

  $result = pwg_query($query);

  while($row = pwg_db_fetch_assoc($result))
  {
    $msg_error_PhpBB2PWG .= '<br>'.l10n('Error_PhpBB2PWG').stripslashes($row['username']).' ('.$row['user_email'].')';

    if ( !is_adviser() )
    {
      $msg_error_PhpBB2PWG .= ' <a href="';

      $msg_error_PhpBB2PWG .= add_url_params($page_Register_PhpBB_admin, array(
        'action' => 'del_user',
        'user_id' => $row['user_id'],
      ));

      $msg_error_PhpBB2PWG .= '" title="'.l10n('Del_User').stripslashes($row['username']).'"';

      $msg_error_PhpBB2PWG .= $conf_Register_PhpBB[3]=='false' ?  ' onclick="return confirm(\''.l10n('Are you sure?').'\');" ' : ' ';

      $msg_error_PhpBB2PWG .= '><img src="'.REGPHPBB_PATH.'/admin/template/icon/user_delete.png" alt="'.l10n('Del_User').stripslashes($row['username']).'" /></a>';
    }
  }

  if ($msg_error_PhpBB2PWG == '')
    array_push($page['infos'], l10n('Audit_PhpBB2PWG').'<br>'.l10n('Audit_OK'));
  else
    $msg_error_PhpBB2PWG = l10n('Audit_PhpBB2PWG').$msg_error_PhpBB2PWG;



  if ($msg_error_PWG_Dup <> '')
    $errors[] = $msg_error_PWG_Dup . ( ($msg_error_PhpBB_Dup == '' and $msg_error_Link_Break == '' and $msg_error_Link_Bad == '' and $msg_error_Synchro == '' and $msg_error_PWG2PhpBB == '' and $msg_error_PhpBB2PWG == '') ? '' : '<br><br>' );

  if ($msg_error_PhpBB_Dup <> '')
    $errors[] = $msg_error_PhpBB_Dup . ( ($msg_error_Link_Break == '' and $msg_error_Link_Bad == '' and $msg_error_Synchro == '' and $msg_error_PWG2PhpBB == '' and $msg_error_PhpBB2PWG == '') ? '' : '<br><br>' );

  if ($msg_error_Link_Break <> '')
    $errors[] = $msg_error_Link_Break . ( ($msg_error_Link_Bad == '' and $msg_error_Synchro == '' and $msg_error_PWG2PhpBB == '' and $msg_error_PhpBB2PWG == '') ? '' : '<br><br>' );

  if ($msg_error_Link_Bad <> '')
    $errors[] = $msg_error_Link_Bad . ( ($msg_error_Synchro == '' and $msg_error_PWG2PhpBB == '' and $msg_error_PhpBB2PWG == '') ? '' : '<br><br>' );

  if ($msg_error_Synchro <> '')
    $errors[] = $msg_error_Synchro . ( ($msg_error_PWG2PhpBB == '' and $msg_error_PhpBB2PWG == '') ? '' : '<br><br>' );

  if ($msg_error_PWG2PhpBB <> '')
    $errors[] = $msg_error_PWG2PhpBB . ( ($msg_error_PhpBB2PWG == '') ? '' : '<br><br>' );

  if ($msg_error_PhpBB2PWG <> '')
    $errors[] = $msg_error_PhpBB2PWG;
}




// +-----------------------------------------------------------------------+
// |                            Actions process
// +-----------------------------------------------------------------------+

if ( isset($_GET['action']) and ($_GET['action']=='link_dead') and !is_adviser() )
{
  $query = "
DELETE FROM ".Register_PhpBB_ID_TABLE."
WHERE id_user_PhpBB NOT IN (
  SELECT user_id
  FROM ".PhpBB_USERS_TABLE."
  )
OR id_user_pwg NOT IN (
  SELECT id
  FROM ".USERS_TABLE."
  )
;";

  $result = pwg_query($query);

  Audit_PWG_PhpBB();
}
else if ( isset($_GET['action']) and ($_GET['action']=='link_del') and isset($_GET['pwg_id']) and isset($_GET['bb_id']) and !is_adviser() )
{
  $query = "
DELETE FROM ".Register_PhpBB_ID_TABLE."
WHERE id_user_pwg = ".$_GET['pwg_id']."
AND id_user_PhpBB = ".$_GET['bb_id']."
;";

  $result = pwg_query($query);

  Audit_PWG_PhpBB();
}
else if ( isset($_GET['action']) and ($_GET['action']=='new_link') and isset($_GET['pwg_id']) and isset($_GET['bb_id']) and !is_adviser() )
{
  PhpBB_Linkuser($_GET['pwg_id'], $_GET['bb_id']);

  Audit_PWG_PhpBB();
}
else if ( isset($_GET['action']) and ($_GET['action']=='sync_user') and isset($_GET['username']) and !is_adviser() )
{
  $query = "
SELECT id AS id_pwg, username, password, mail_address
FROM ".USERS_TABLE."
WHERE BINARY username = BINARY '".pwg_db_real_escape_string($_GET['username'])."'
LIMIT 1
;";

  $data = pwg_db_fetch_assoc(pwg_query($query));

  if (!empty($data))
  {
    PhpBB_Updateuser($data['id_pwg'], stripslashes($data['username']), $data['password'], $data['mail_address']);
  }

  Audit_PWG_PhpBB();
}
else if ( isset($_GET['action']) and ($_GET['action']=='add_user') and isset($_GET['username']) and !is_adviser() )
{
  $query = "
SELECT id, username, password, mail_address
FROM ".USERS_TABLE."
WHERE BINARY username = BINARY '".pwg_db_real_escape_string($_GET['username'])."'
LIMIT 1
;";

  $data = pwg_db_fetch_assoc(pwg_query($query));

  if (!empty($data))
    PhpBB_Adduser($data['id'], stripslashes($data['username']), $data['password'], $data['mail_address']);

    Audit_PWG_PhpBB();
}
else if ( isset($_GET['action']) and ($_GET['action']=='del_user') and isset($_GET['id']) and !is_adviser() )
{
  PhpBB_Deluser( $_GET['id'], true );

  Audit_PWG_PhpBB();
}


// +-----------------------------------------------------------------------+
// |                            Tabssheet select                           |
// +-----------------------------------------------------------------------+

switch ($page['tab'])
{
  case 'info':

  $template->assign(
    array(
      'REGPHPBB_PATH'    => REGPHPBB_PATH,
      'REGPHPBB_VERSION' => $version,
    )
  );

  $template->set_filename('plugin_admin_content', dirname(__FILE__).'/template/info.tpl');
  $template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');

	break;

	case 'manage':

  if (isset($_POST['submit']) and !is_adviser() and isset($_POST['PhpBB_prefix']) and isset($_POST['PhpBB_admin']) and isset($_POST['PhpBB_guest']) and isset($_POST['PhpBB_confirm']) and isset($_POST['PhpBB_details']))
  {

/* Configuration controls */
// Piwigo's admin username control
    $query1 = "
SELECT username, id
FROM ".USERS_TABLE."
WHERE id = ".$conf['webmaster_id']."
;";

    $pwgadmin = pwg_db_fetch_assoc(pwg_query($query1));

// PhpBB's admin username control
    $query2 = "
SELECT username, user_id
FROM ".PhpBB_USERS_TABLE."
WHERE user_id = 2
;";

    $fbbadmin = pwg_db_fetch_assoc(pwg_query($query2));

// PhpBB's Anonymous username control
    $query3 = "
SELECT username, user_id
FROM ".PhpBB_USERS_TABLE."
WHERE user_id = 1
;";

    $fbbguest = pwg_db_fetch_assoc(pwg_query($query3));

// Compute configuration errors
    if (stripslashes($pwgadmin['username']) != stripslashes($_POST['PhpBB_admin']))
    {
      array_push($page['errors'], l10n('error_config_admin1'));
    }
    if (stripslashes($pwgadmin['username']) != stripslashes($fbbadmin['username']))
    {
      array_push($page['errors'], l10n('error_config_admin2'));
    }
    if (stripslashes($fbbguest['username']) != stripslashes($_POST['PhpBB_guest']))
    {
      array_push($page['errors'], l10n('error_config_guest'));
    }
    elseif (count($page['errors']) == 0)
    {
      if (!function_exists('FindAvailableConfirmMailID'))
      {
      $conf['Register_PhpBB'] = $_POST['PhpBB_prefix'].';'.addslashes($_POST['PhpBB_admin']).';'.addslashes($_POST['PhpBB_guest']).';'.$_POST['PhpBB_confirm'].';'.$_POST['PhpBB_details'].';false;REGISTERED';
      }
      elseif (function_exists('FindAvailableConfirmMailID'))
      {
        $conf_UAM = unserialize($conf['UserAdvManager']);

        if (isset($conf_UAM[1]) and ($conf_UAM[1] == 'true' or $conf_UAM[1] == 'local') and isset($conf_UAM[2]) and $conf_UAM[2] != '-1')
        {
          $conf['Register_PhpBB'] = $_POST['PhpBB_prefix'].';'.addslashes($_POST['PhpBB_admin']).';'.addslashes($_POST['PhpBB_guest']).';'.$_POST['PhpBB_confirm'].';'.$_POST['PhpBB_details'].';'.$_POST['PhpBB_UAM'].';'.$_POST['PhpBB_group'];
        }
        else
        {
          $conf['Register_PhpBB'] = $_POST['PhpBB_prefix'].';'.addslashes($_POST['PhpBB_admin']).';'.addslashes($_POST['PhpBB_guest']).';'.$_POST['PhpBB_confirm'].';'.$_POST['PhpBB_details'].';false;REGISTERED';
        }
      }

      $query = '
UPDATE '.CONFIG_TABLE.'
SET value="'.$conf['Register_PhpBB'].'"
WHERE param="Register_PhpBB"
LIMIT 1
;';

      pwg_query($query);

      array_push($page['infos'], l10n('save_config'));
    }
  }

  $conf_Register_PhpBB = isset($conf['Register_PhpBB']) ? explode(";" , $conf['Register_PhpBB']) : array();

  $template->assign(
    array
    (
      'REGPHPBB_PATH'       => REGPHPBB_PATH,
      'REGPHPBB_VERSION'    => $version,
      'PhpBB_PREFIX'        => $conf_Register_PhpBB[0],
      'PhpBB_ADMIN'         => stripslashes($conf_Register_PhpBB[1]),
      'PhpBB_GUEST'         => stripslashes($conf_Register_PhpBB[2]),
      'PhpBB_CONFIRM_TRUE'  => (isset($conf_Register_PhpBB[3]) and $conf_Register_PhpBB[3] == 'true') ? 'checked="checked"' : '',
      'PhpBB_CONFIRM_FALSE' => (isset($conf_Register_PhpBB[3]) and $conf_Register_PhpBB[3] == 'false') ? 'checked="checked"' : '',
      'PhpBB_DETAILS_TRUE'  => (isset($conf_Register_PhpBB[4]) and $conf_Register_PhpBB[4] == 'true') ? 'checked="checked"' : '',
      'PhpBB_DETAILS_FALSE' => (isset($conf_Register_PhpBB[4]) and $conf_Register_PhpBB[4] == 'false') ? 'checked="checked"' : '',
    )
  );

// If UAM exists and if UAM ConfirmMail is set, we can set this feature
  if (function_exists('FindAvailableConfirmMailID'))
  {
    $conf_UAM = unserialize($conf['UserAdvManager']);
    $UAM_bridge = false;

    if (isset($conf_UAM[1]) and ($conf_UAM[1] == 'true' or $conf_UAM[1] == 'local') and isset($conf_UAM[2]) and $conf_UAM[2] != '-1')
    {
      $UAM_bridge = true;
    }

    $template->assign(
      array
      (
        'UAM_BRIDGE'            => $UAM_bridge,
        'PhpBB_UAM_LINK_TRUE'  => (isset($conf_Register_PhpBB[5]) and $conf_Register_PhpBB[5] == 'true') ? 'checked="checked"' : '',
        'PhpBB_UAM_LINK_FALSE' => (isset($conf_Register_PhpBB[5]) and $conf_Register_PhpBB[5] == 'false') ? 'checked="checked"' : '',
        'PhpBB_GROUP'          => $conf_Register_PhpBB[6],
      )
    );
  }

  $template->set_filename('plugin_admin_content', dirname(__FILE__) . '/template/manage.tpl');
  $template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');

	break;

	case 'Migration':

  $conf_Register_PhpBB = isset($conf['Register_PhpBB']) ? explode(";" , $conf['Register_PhpBB']) : array();

  if ( isset($_POST['Migration']) and !is_adviser() )
  {
    array_push($page['infos'], l10n('Mig_Start').'<br><br>');

    array_push($page['infos'], l10n('Mig_Del_Link').'<br><br>');

    $query = "TRUNCATE ".Register_PhpBB_ID_TABLE.";";
    $result = pwg_query($query);


    $msg_Mig_Del_AllUsers = '';

    $query = "
SELECT username, user_id, group_id
FROM ".PhpBB_USERS_TABLE."
WHERE group_id != '6'
;";

    $result = pwg_query($query);

    while ($row = pwg_db_fetch_assoc($result))
    {
      if((stripslashes($row['username']) != stripslashes($conf_Register_PhpBB[2])) and (stripslashes($row['username']) != stripslashes($conf_Register_PhpBB[1])))
      {
        $msg_Mig_Del_AllUsers .= '<br> - '.l10n('Mig_Del_User').stripslashes($row['username']);

        PhpBB_Deluser($row['user_id'], false);
      }
    }

    array_push($page['infos'], l10n('Mig_Del_AllUsers').$msg_Mig_Del_AllUsers.'<br><br>');


    $query = "
SELECT id, username, password, mail_address
FROM ".USERS_TABLE."
;";

    $result = pwg_query($query);

    $registred = time();
    $registred_ip = $_SERVER['REMOTE_ADDR'];

    $msg_Mig_Add_AllUsers = '';

    while ($row = pwg_db_fetch_assoc($result))
    {
      if((stripslashes($row['username']) != 'guest') and (stripslashes($row['username']) != stripslashes($conf_Register_PhpBB[1])))
      {
        $msg_Mig_Add_AllUsers .= '<br> - '.l10n('Mig_Add_User').stripslashes($row['username']);

        PhpBB_Adduser($row['id'], stripslashes($row['username']), $row['password'], $row['mail_address']);
      }
    }

    array_push($page['infos'], l10n('Mig_Add_AllUsers').$msg_Mig_Add_AllUsers.'<br><br>');


    $query = "
SELECT id, username, password, mail_address
FROM ".USERS_TABLE."
WHERE username = '".$conf_Register_PhpBB[1]."'
;";

    $row = pwg_db_fetch_assoc(pwg_query($query));

    if (!empty($row))
    {
      array_push($page['infos'], l10n('Sync_User').stripslashes($row['username']).'<br><br>');

      PhpBB_Updateuser($row['id'], stripslashes($row['username']), $row['password'], $row['mail_address']);
    }

    array_push($page['infos'], l10n('Mig_End'));
  }
  else if ( isset($_POST['Audit']))
  {
    Audit_PWG_PhpBB();
  }

  $template->assign(
    array
    (
      'REGPHPBB_PATH'    => REGPHPBB_PATH,
      'REGPHPBB_VERSION' => $version,
    )
  );

  $template->set_filename('plugin_admin_content', dirname(__FILE__) . '/template/migration.tpl');
  $template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');

	break;

	case 'Synchro':

  if ( isset($_POST['Synchro']) and !is_adviser() )
  {
    global $page,$conf, $errors;

    $conf_Register_PhpBB = isset($conf['Register_PhpBB']) ? explode(";" , $conf['Register_PhpBB']) : array();

    $page_Register_PhpBB_admin = get_admin_plugin_menu_link(__FILE__);


    $msg_error_PWG_Dup = '';
    $msg_error_PhpBB_Dup = '';
    $msg_error_Link_Break = '';
    $msg_error_Link_Bad = '';
    $msg_error_Synchro = '';
    $msg_ok_Synchro = '';
    $msg_error_PhpBB2PWG = '';
    $msg_error_PWG2PhpBB = '';


    $query = "
SELECT COUNT(*) AS nbr_dup, id, username
FROM ".USERS_TABLE."
GROUP BY BINARY username
HAVING COUNT(*) > 1
;";

    $result = pwg_query($query);

    while($row = pwg_db_fetch_assoc($result))
      $msg_error_PWG_Dup .= '<br>'.l10n('Error_PWG_Dup').$row['nbr_dup'].' x '.stripslashes($row['username']);

      if ($msg_error_PWG_Dup <> '')
        $msg_error_PWG_Dup = l10n('Audit_PWG_Dup').$msg_error_PWG_Dup.'<br>'.l10n('Advise_PWG_Dup');


    $query = "
SELECT COUNT(*) AS nbr_dup, username
FROM ".PhpBB_USERS_TABLE."
GROUP BY BINARY username
HAVING COUNT(*) > 1
;";

    $result = pwg_query($query);

    while($row = pwg_db_fetch_assoc($result))
    {
      $msg_error_PhpBB_Dup .= '<br>'.l10n('Error_PhpBB_Dup').$row['nbr_dup'].' x '.stripslashes($row['username']);

      $subquery = "
SELECT user_id, username, user_email
FROM ".PhpBB_USERS_TABLE."
WHERE BINARY username = BINARY '".$row['username']."'
;";

      $subresult = pwg_query($subquery);

      while($subrow = pwg_db_fetch_assoc($subresult))
      {
        $msg_error_PhpBB_Dup .= '<br>id:'.$subrow['user_id'].'='.stripslashes($subrow['username']).' ('.$subrow['user_email'].')';

        if ( !is_adviser() )
        {
          $msg_error_PhpBB_Dup .= ' <a href="';

          $msg_error_PhpBB_Dup .= add_url_params($page_Register_PhpBB_admin, array(
            'action' => 'del_user',
            'user_id' => $subrow['user_id'],
          ));

          $msg_error_PhpBB_Dup .= '" title="'.l10n('Del_User').stripslashes($subrow['username']).'"';

          $msg_error_PhpBB_Dup .= $conf_Register_PhpBB[3]=='false' ?  ' onclick="return confirm(\''.l10n('Are you sure?').'\');" ' : ' ';

          $msg_error_PhpBB_Dup .= '><img src="'.REGPHPBB_PATH.'/admin/template/icon/user_delete.png" alt="'.l10n('Del_User').stripslashes($subrow['username']).'" /></a>';
        }
      }
    }

    if ($msg_error_PhpBB_Dup <> '')
      $msg_error_PhpBB_Dup = l10n('Sync_Check_Dup').$msg_error_PhpBB_Dup.'<br>'.l10n('Advise_PhpBB_Dup');


    if ($msg_error_PhpBB_Dup == '' and $msg_error_PWG_Dup == '')
    {
      $query = "
SELECT pwg.id as pwg_id, bb.user_id as bb_id, pwg.username as pwg_user, pwg.mail_address as pwg_mail
FROM ".PhpBB_USERS_TABLE." AS bb, ".USERS_TABLE." as pwg
WHERE bb.user_id NOT in (
  SELECT id_user_PhpBB
  FROM ".Register_PhpBB_ID_TABLE."
  )
AND pwg.id NOT in (
  SELECT id_user_pwg
  FROM ".Register_PhpBB_ID_TABLE."
  )
AND pwg.username = bb.username
AND pwg.mail_address = bb.user_email
;";

      $result = pwg_query($query);

      while($row = pwg_db_fetch_assoc($result))
      {
        $msg_error_Link_Break .= '<br>'.l10n('New_Link').stripslashes($row['pwg_user']).' ('.$row['pwg_mail'].')';

        PhpBB_Linkuser($row['pwg_id'], $row['bb_id']);
      }

      if ($msg_error_Link_Break == '')
        array_push($page['infos'], l10n('Sync_Link_Break').'<br>'.l10n('Sync_OK'));
      else
        $msg_error_Link_Break = l10n('Sync_Link_Break').$msg_error_Link_Break;


      $query = "
SELECT pwg.username as pwg_user, pwg.id as pwg_id, pwg.mail_address as pwg_mail, bb.user_id as bb_id, bb.username as bb_user, bb.user_email as bb_mail
FROM ".PhpBB_USERS_TABLE." AS bb
INNER JOIN ".Register_PhpBB_ID_TABLE." AS link ON link.id_user_PhpBB = bb.user_id
INNER JOIN ".USERS_TABLE." as pwg ON link.id_user_pwg = pwg.id
WHERE BINARY pwg.username <> BINARY bb.username
;";

      $result = pwg_query($query);

      while($row = pwg_db_fetch_assoc($result))
      {
        $msg_error_Link_Bad .= '<br>'.l10n('Link_Del').stripslashes($row['pwg_user']).' ('.$row['pwg_mail'].')'.' -- '.stripslashes($row['bb_user']).' ('.$row['bb_mail'].')';

        $subquery = "
DELETE FROM ".Register_PhpBB_ID_TABLE."
WHERE id_user_pwg = ".$row['pwg_id']."
AND id_user_PhpBB = ".$row['bb_id']."
;";

        $subresult = pwg_query($subquery);
      }


      $query = "
SELECT COUNT(*) as nbr_dead
FROM ".Register_PhpBB_ID_TABLE." AS Link
WHERE id_user_PhpBB NOT IN (
  SELECT user_id
  FROM ".PhpBB_USERS_TABLE."
  )
OR id_user_pwg NOT IN (
  SELECT id
  FROM ".USERS_TABLE."
  )
;";

      $Compteur = pwg_db_fetch_assoc(pwg_query($query));

      if ( !empty($Compteur) and $Compteur['nbr_dead'] > 0)
      {
        $msg_error_Link_Bad .= '<br>'.l10n('Link_Dead').$Compteur['nbr_dead'];

        $query = "
DELETE FROM ".Register_PhpBB_ID_TABLE."
WHERE id_user_PhpBB NOT IN (
  SELECT user_id
  FROM ".PhpBB_USERS_TABLE."
  )
OR id_user_pwg NOT IN (
  SELECT id
  FROM ".USERS_TABLE."
  )
;";

        $result = pwg_query($query);
      }


      $query = "
SELECT COUNT(*) AS nbr_dup, pwg.id AS pwg_id, pwg.username AS pwg_user, bb.username AS bb_user, bb.user_id AS bb_id
FROM ".PhpBB_USERS_TABLE." AS bb
INNER JOIN ".Register_PhpBB_ID_TABLE." AS link ON link.id_user_PhpBB = bb.user_id
INNER JOIN ".USERS_TABLE." as pwg ON link.id_user_pwg = pwg.id
GROUP BY link.id_user_pwg, link.id_user_PhpBB
HAVING COUNT(*) > 1
;";

      $result = pwg_query($query);

      while($row = pwg_db_fetch_assoc($result))
      {
        $msg_error_Link_Bad .= '<br>'.l10n('Link_Dup').$row['nbr_dup'].' = '.stripslashes($row['pwg_user']).' -- '.stripslashes($row['bb_user']).')';

        PhpBB_Linkuser($row['pwg_id'], $row['bb_id']);
      }

      if ($msg_error_Link_Bad == '')
        array_push($page['infos'], l10n('Sync_Link_Bad').'<br>'.l10n('Sync_OK'));
      else
        $msg_error_Link_Bad = l10n('Sync_Link_Bad').$msg_error_Link_Bad;


      $query = "
SELECT pwg.id as pwg_id, pwg.username as username, pwg.password as pwg_pwd, pwg.mail_address as pwg_eml, PhpBB.user_id as bb_id, PhpBB.user_password as bb_pwd, PhpBB.user_email as bb_eml
FROM ".PhpBB_USERS_TABLE." AS PhpBB
INNER JOIN ".Register_PhpBB_ID_TABLE." AS link ON link.id_user_PhpBB = PhpBB.user_id
INNER JOIN ".USERS_TABLE." as pwg ON link.id_user_pwg = pwg.id
AND BINARY pwg.username = BINARY PhpBB.username
ORDER BY LOWER(pwg.username)
;";

      $result = pwg_query($query);

      while($row = pwg_db_fetch_assoc($result))
      {
        if ( ($row['pwg_pwd'] != $row['bb_pwd']) or ($row['pwg_eml'] != $row['bb_eml']) )
        {
          $msg_error_Synchro .= '<br>'.l10n('Sync_User').stripslashes($row['username']);

          $query = "
SELECT id, username, password, mail_address
FROM ".USERS_TABLE."
WHERE BINARY id = '".$row['pwg_id']."'
;";

          $data = pwg_db_fetch_assoc(pwg_query($query));

          if (!empty($data))
            PhpBB_Updateuser($data['id'], stripslashes($data['username']), $data['password'], $data['mail_address']);
        }
      }

      if ($msg_error_Synchro == '')
        array_push($page['infos'], l10n('Sync_DataUser').'<br>'.l10n('Sync_OK'));
      else
        $msg_error_Synchro = l10n('Sync_DataUser').$msg_error_Synchro;


      $query = "
SELECT username, mail_address FROM ".USERS_TABLE."
WHERE BINARY username <> BINARY 'guest'
AND id not in (
  SELECT id_user_pwg FROM ".Register_PhpBB_ID_TABLE."
  )
AND BINARY username not in (
  SELECT username FROM ".PhpBB_USERS_TABLE."
  )
ORDER BY LOWER(username)
;";

      $result = pwg_query($query);

      while($row = pwg_db_fetch_assoc($result))
      {
        $msg_error_PWG2PhpBB .= '<br>'.l10n('Add_User').stripslashes($row['username']).' ('.$row['mail_address'].')';

        $query = "
SELECT id, username, password, mail_address
FROM ".USERS_TABLE."
WHERE BINARY username = BINARY '".$row['username']."'
LIMIT 1
;";

        $data = pwg_db_fetch_assoc(pwg_query($query));

        if (!empty($data))
          PhpBB_Adduser($data['id'], stripslashes($data['username']), $data['password'], $data['mail_address']);
      }

      if ($msg_error_PWG2PhpBB == '')
        array_push($page['infos'], l10n('Sync_PWG2PhpBB').'<br>'.l10n('Sync_OK'));
      else
        $msg_error_PWG2PhpBB = l10n('Sync_PWG2PhpBB').$msg_error_PWG2PhpBB;


      $query = "
SELECT user_id, username, group_id, user_email FROM ".PhpBB_USERS_TABLE."
WHERE BINARY username <> BINARY '".$conf_Register_PhpBB[2]."'
AND user_id not in (
  SELECT id_user_PhpBB FROM ".Register_PhpBB_ID_TABLE."
  )
AND BINARY username not in (
  SELECT username FROM ".USERS_TABLE."
  )
AND group_id <> '6'
ORDER BY LOWER(username)
;";

      $result = pwg_query($query);

      while($row = pwg_db_fetch_assoc($result))
      {
        $msg_error_PhpBB2PWG .= '<br>'.l10n('Error_PhpBB2PWG').stripslashes($row['username']).' ('.$row['user_email'].')';

        if ( !is_adviser() )
        {
          $msg_error_PhpBB2PWG .= ' <a href="';

          $msg_error_PhpBB2PWG .= add_url_params($page_Register_PhpBB_admin, array(
            'action' => 'del_user',
            'user_id' => $row['user_id'],
          ));

          $msg_error_PhpBB2PWG .= '" title="'.l10n('Del_User').stripslashes($row['username']).'"';

          $msg_error_PhpBB2PWG .= $conf_Register_PhpBB[3]=='false' ?  ' onclick="return confirm(\''.l10n('Are you sure?').'\');" ' : ' ';

          $msg_error_PhpBB2PWG .= '><img src="'.REGPHPBB_PATH.'/admin/template/icon/user_delete.png" alt="'.l10n('Del_User').stripslashes($row['username']).'" /></a>';
        }
      }

      if ($msg_error_PhpBB2PWG == '')
        array_push($page['infos'], l10n('Sync_PhpBB2PWG').'<br>'.l10n('Sync_OK'));
      else
        $msg_error_PhpBB2PWG = l10n('Sync_PhpBB2PWG').$msg_error_PhpBB2PWG;
    }
    else
      $errors[] = l10n('Advise_Check_Dup');


    if ($msg_error_PWG_Dup <> '')
      $errors[] = $msg_error_PWG_Dup . ( ($msg_error_PhpBB_Dup == '' and $msg_error_Link_Break == '' and $msg_error_Link_Bad == '' and $msg_error_Synchro == '' and $msg_error_PWG2PhpBB == '' and $msg_error_PhpBB2PWG == '') ? '' : '<br><br>' );

    if ($msg_error_PhpBB_Dup <> '')
      $errors[] = $msg_error_PhpBB_Dup . ( ($msg_error_Link_Break == '' and $msg_error_Link_Bad == '' and $msg_error_Synchro == '' and $msg_error_PWG2PhpBB == '' and $msg_error_PhpBB2PWG == '') ? '' : '<br><br>' );

    if ($msg_error_Link_Break <> '')
      $errors[] = $msg_error_Link_Break . ( ($msg_error_Link_Bad == '' and $msg_error_Synchro == '' and $msg_error_PWG2PhpBB == '' and $msg_error_PhpBB2PWG == '') ? '' : '<br><br>' );

    if ($msg_error_Link_Bad <> '')
      $errors[] = $msg_error_Link_Bad . ( ($msg_error_Synchro == '' and $msg_error_PWG2PhpBB == '' and $msg_error_PhpBB2PWG == '') ? '' : '<br><br>' );

    if ($msg_error_Synchro <> '')
      $errors[] = $msg_error_Synchro . ( ($msg_error_PWG2PhpBB == '' and $msg_error_PhpBB2PWG == '') ? '' : '<br><br>' );

    if ($msg_error_PWG2PhpBB <> '')
      $errors[] = $msg_error_PWG2PhpBB . ( ($msg_error_PhpBB2PWG == '') ? '' : '<br><br>' );

    if ($msg_error_PhpBB2PWG <> '')
      $errors[] = $msg_error_PhpBB2PWG;
  }
  else if ( isset($_POST['Audit']))
  {
    Audit_PWG_PhpBB();
  }

  $template->assign(
    array
    (
      'REGPHPBB_PATH'    => REGPHPBB_PATH,
      'REGPHPBB_VERSION' => $version,
    )
  );

  $template->set_filename('plugin_admin_content', dirname(__FILE__) . '/template/synchro.tpl');
  $template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');

	break;
}
?>