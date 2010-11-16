<?php

include_once (PHPWG_ROOT_PATH.'/include/constants.php');
include_once (REGPHPBB_PATH.'include/constants.php');

function PhpBB_Linkuser($pwg_id, $bb_id)
{
	$query = "
SELECT pwg.id as pwg_id, bb.user_id as bb_id
FROM ".USERS_TABLE." pwg, ".PhpBB_USERS_TABLE." bb
WHERE pwg.id = ".$pwg_id."
AND bb.user_id = ".$bb_id."
AND pwg.username = bb.username
;";

	$data = pwg_db_fetch_row(pwg_query($query));

	if (!empty($data))
	{
		$subquery = "
DELETE FROM ".Register_PhpBB_ID_TABLE."
WHERE id_user_pwg = '".$pwg_id."'
OR id_user_PhpBB = '".$bb_id."'
;";

		$subresult = pwg_query($subquery);

		$subquery = "
INSERT INTO ".Register_PhpBB_ID_TABLE."
  (id_user_pwg, id_user_PhpBB)
VALUES (".$pwg_id.", ".$bb_id.")
;";

		$subresult = pwg_query($subquery);
	}
}



function PhpBB_Unlinkuser($bb_id)
{
	$query = "
DELETE FROM ".Register_PhpBB_ID_TABLE."
WHERE id_user_PhpBB = ".$bb_id."
;";

	$result = pwg_query($query);
}



function PhpBB_Adduser($pwg_id, $login, $password, $adresse_mail)
{
	global $conf;

	$conf_Register_PhpBB = isset($conf['Register_PhpBB']) ? explode(";" , $conf['Register_PhpBB']) : array();

	$registred = time();
	$registred_ip = $_SERVER['REMOTE_ADDR'];

	// Check if UAM is installed and if bridge is set - Exception for admins and webmasters
	if (function_exists('FindAvailableConfirmMailID') and isset($conf_Register_PhpBB[5]) and $conf_Register_PhpBB[5] == 'true')
	{
		$default_user_group = '7';
	}
	else
	{
		$query = "
SELECT group_id
FROM ".PhpBB_GROUPS_TABLE."
WHERE group_name = 'REGISTERED'
;";

		$default_user_group = pwg_db_fetch_assoc(pwg_query($query));
	}

	$query = "
UPDATE ".PhpBB_CONFIG_TABLE."
SET config_value = config_value+1
WHERE config_name = 'num_users'
;";

	$result = pwg_query($query);

	$query = "
UPDATE ".PhpBB_CONFIG_TABLE."
SET config_value = '".pwg_db_real_escape_string($login)."'
WHERE config_name = 'newest_username'
;";
	$result = pwg_query($query);

	$query = "
SELECT config_value
FROM ".PhpBB_CONFIG_TABLE."
WHERE config_name = 'board_timezone'
;";

	$board_timezone = pwg_db_fetch_assoc(pwg_query($query));

	$query = "
SELECT config_value
FROM ".PhpBB_CONFIG_TABLE."
WHERE config_name = 'default_dateformat'
;";

	$default_dateformat = pwg_db_fetch_assoc(pwg_query($query));

	$query = "
SELECT config_value
FROM ".PhpBB_CONFIG_TABLE."
WHERE config_name = 'default_lang'
;";

	$default_lang = pwg_db_fetch_assoc(pwg_query($query));

	$query = "
SELECT config_value
FROM ".PhpBB_CONFIG_TABLE."
WHERE config_name = 'default_style'
;";

	$default_style = pwg_db_fetch_assoc(pwg_query($query));

	$query = "
SELECT group_colour
FROM ".PhpBB_GROUPS_TABLE."
WHERE group_id = '".$default_user_group."'
;";
	$default_colour = pwg_db_fetch_assoc(pwg_query($query));

	$query = '
INSERT INTO '.PhpBB_USERS_TABLE." (
    username,
    username_clean,
    ". ( isset($default_user_group['group_id']) ? 'group_id' : '' ) .",
	user_password,
	user_email,
	". ( isset($board_timezone['config_value']) ? 'user_timezone' : '' ) .",
	". ( isset($default_lang['config_value']) ? 'user_lang' : '' ) .",
	". ( isset($default_dateformat['config_value']) ? 'user_dateformat' : '' ) .",
	". ( isset($default_style['config_value']) ? 'user_style' : '' ) .",
	user_colour,
	user_regdate,
	user_ip,
	user_lastvisit,
	user_new
	)
VALUES(
	'".pwg_db_real_escape_string($login)."',
	'".strtolower(pwg_db_real_escape_string($login))."',
	". ( isset($default_user_group['group_id']) ? "'".$default_user_group['group_id']."'" : '' ) .",
	'".$password."',
	'".$adresse_mail."',
	". ( isset($board_timezone['config_value']) ? "'".$board_timezone['config_value']."'" : '' ) .",
	". ( isset($default_lang['config_value']) ? "'".$default_lang['config_value']."'" : '' ) .",
	". ( isset($default_dateformat['config_value']) ? "'".$default_dateformat['config_value']."'" : '' ) .",
	". ( isset($default_style['config_value']) ? "'".$default_style['config_value']."'" : '' ) .",
	'".$default_colour['group_colour']."',
	'".$registred."',
	'".$registred_ip."',
	'".$registred."',
	'0'
	)
;";

	$result = pwg_query($query);

	$bb_id = pwg_db_insert_id();

	PhpBB_Linkuser($pwg_id, $bb_id);

	$query = "
SELECT user_id
FROM ".PhpBB_USERS_TABLE."
WHERE username = '".pwg_db_real_escape_string($login)."'
;";

	$userid = pwg_db_fetch_assoc(pwg_query($query));

	$query = "
UPDATE ".PhpBB_CONFIG_TABLE."
SET config_value = '".$userid."'
WHERE config_name = 'newest_user_id'
;";
	$result = pwg_query($query);

	$query = '
INSERT INTO '.PhpBB_USERGROUP_TABLE." (
    ". ( isset($default_user_group['group_id']) ? 'group_id' : '' ) .",
	user_id,
	group_leader,
	user_pending
	)
VALUES(
	". ( isset($default_user_group['group_id']) ? "'".$default_user_group['group_id']."'" : '' ) .",
	". ( isset($userid['user_id']) ? "'".$userid['user_id']."'" : '' ) .",
	'0',
	'0'
	)
;";

	$result = pwg_query($query);

	$query = "
UPDATE ".PhpBB_CONFIG_TABLE."
SET config_value = '".$default_colour."'
WHERE config_name = 'newest_user_colour'
;";
	$result = pwg_query($query);
}



function PhpBB_Searchuser($id_user_pwg)
{
	$query = "
SELECT id_user_PhpBB, id_user_pwg FROM ".Register_PhpBB_ID_TABLE."
WHERE id_user_pwg = ".$id_user_pwg."
LIMIT 1
;";

	$data = pwg_db_fetch_assoc(pwg_query($query));

	if (!empty($data))
		return $data['id_user_PhpBB'];
	else
		return '0';
}



function PhpBB_Deluser($id_user_PhpBB, $SuppTopicsPosts)
{
	global $conf;

	$conf_Register_PhpBB = isset($conf['Register_PhpBB']) ? explode(";" , $conf['Register_PhpBB']) : array();

	$query0 = "
SELECT username, user_id FROM ".PhpBB_USERS_TABLE."
WHERE user_id = ".$id_user_PhpBB."
LIMIT 1
;";

	$data0 = pwg_db_fetch_assoc(pwg_query($query0));


	$subquery = "
UPDATE ".PhpBB_POSTS_TABLE."
SET post_username = '".pwg_db_real_escape_string($data0['username'])."', poster_id = '1'
WHERE poster_id = ".$id_user_PhpBB."
;";

		$subresult = pwg_query($subquery);

		$subquery = "
UPDATE ".PhpBB_TOPICS_TABLE."
SET topic_poster = '1'
WHERE BINARY topic_poster = ".$id_user_PhpBB."
;";

		$subresult = pwg_query($subquery);

		$subquery = "
UPDATE ".PhpBB_TOPICS_TABLE."
SET topic_last_poster_id = '1'
WHERE topic_last_poster_id = ".$id_user_PhpBB."
;";
		$subresult = pwg_query($subquery);

		$subquery = "
UPDATE ".PhpBB_FORUMS_TABLE."
SET forum_last_poster_id = '1'
WHERE forum_last_poster_id = ".$id_user_PhpBB."
;";
		$subresult = pwg_query($subquery);


	$subquery = "
DELETE FROM ".PhpBB_TOPICSPOSTED_TABLE."
WHERE user_id = ".$id_user_PhpBB."
;";

	$subresult = pwg_query($subquery);

	$subquery = "
DELETE FROM ".PhpBB_FORUMSTRACK_TABLE."
WHERE user_id = ".$id_user_PhpBB."
;";

	$subresult = pwg_query($subquery);

	// Suppression des abonnements aux topics de l'utilisateur
	$subquery = "
DELETE FROM ".PhpBB_SUBSCRIPTIONS_TABLE."
WHERE user_id = ".$id_user_PhpBB."
;";

	$subresult = pwg_query($subquery);

	//Suppression des abonnements aux forums de l'utilisateur
	$subquery = "
DELETE FROM ".PhpBB_SUBFORUMS_TABLE."
WHERE user_id = ".$id_user_PhpBB."
;";

	$subresult = pwg_query($subquery);

	$subquery = "
UPDATE ".PhpBB_CONFIG_TABLE."
SET config_value = config_value-1
WHERE config_name = 'num_users'
;";

	$subresult = pwg_query($subquery);

	// Suppression du compte utilisateur
	$subquery = "
DELETE FROM ".PhpBB_USERS_TABLE."
WHERE user_id = ".$id_user_PhpBB."
;";

	$subresult = pwg_query($subquery);

	$subquery = "
DELETE FROM ".PhpBB_USERGROUP_TABLE."
WHERE user_id = ".$id_user_PhpBB."
;";

	$subresult = pwg_query($subquery);

	$subquery = "
UPDATE ".PhpBB_CONFIG_TABLE."
SET config_value = (SELECT username FROM ".PhpBB_USERS_TABLE." WHERE user_regdate = (SELECT MAX(user_regdate) FROM ".PhpBB_USERS_TABLE." WHERE ((group_id <> 6) AND (username <> 'Anonymous'))
LIMIT 1) LIMIT 1)
WHERE config_name = 'newest_username'
;";

	$subresult = pwg_query($subquery);

	$subquery = "
UPDATE ".PhpBB_CONFIG_TABLE."
SET config_value = (SELECT user_id FROM ".PhpBB_USERS_TABLE." WHERE user_regdate = (SELECT MAX(user_regdate) FROM ".PhpBB_USERS_TABLE." WHERE ((group_id <> 6) AND (username <> 'Anonymous'))
LIMIT 1) LIMIT 1)
WHERE config_name = 'newest_user_id'
;";

	$subresult = pwg_query($subquery);

	PhpBB_Unlinkuser($id_user_PhpBB);
}



function PhpBB_Updateuser($pwg_id, $username, $password, $adresse_mail)
{
	include_once( PHPWG_ROOT_PATH.'include/common.inc.php' );

	$query = "
SELECT id_user_PhpBB as PhpBB_id
FROM ".Register_PhpBB_ID_TABLE."
WHERE id_user_pwg = ".$pwg_id."
;";

	$row = pwg_db_fetch_assoc(pwg_query($query));

	if (!empty($row))
	{
		$query = "
UPDATE ".PhpBB_USERS_TABLE."
SET username = '".pwg_db_real_escape_string($username)."', username_clean = '".strtolower(pwg_db_real_escape_string($username))."', user_email = '".$adresse_mail."', user_password = '".$password."'
WHERE user_id = ".$row['PhpBB_id']."
;";

		$result = pwg_query($query);

		PhpBB_Linkuser($pwg_id, $row['PhpBB_id']);
	}
	else
	{
		$query = "
SELECT user_id as PhpBB_id
FROM ".PhpBB_USERS_TABLE."
WHERE BINARY username = BINARY '".pwg_db_real_escape_string($username)."'
;";

		$row = pwg_db_fetch_assoc(pwg_query($query));

		if (!empty($row))
		{
			$query = "
UPDATE ".PhpBB_USERS_TABLE."
SET username = '".pwg_db_real_escape_string($username)."', username_clean = '".strtolower(pwg_db_real_escape_string($username))."', user_email = '".$adresse_mail."', user_password = '".$password."'
WHERE user_id = ".$row['PhpBB_id']."
;";

			$result = pwg_query($query);

			PhpBB_Linkuser($pwg_id, $row['PhpBB_id']);
		}
	}
}


function RegPhpBB_Infos($dir)
{
	$path = $dir;

	$plg_data = implode( '', file($path.'main.inc.php') );
	if ( preg_match("|Plugin Name: (.*)|", $plg_data, $val) )
	{
		$plugin['name'] = trim( $val[1] );
	}
	if (preg_match("|Version: (.*)|", $plg_data, $val))
	{
		$plugin['version'] = trim($val[1]);
	}
	if ( preg_match("|Plugin URI: (.*)|", $plg_data, $val) )
	{
		$plugin['uri'] = trim($val[1]);
	}
	if ($desc = load_language('description.txt', $path.'/', array('return' => true)))
	{
		$plugin['description'] = trim($desc);
	}
	elseif ( preg_match("|Description: (.*)|", $plg_data, $val) )
	{
		$plugin['description'] = trim($val[1]);
	}
	if ( preg_match("|Author: (.*)|", $plg_data, $val) )
	{
		$plugin['author'] = trim($val[1]);
	}
	if ( preg_match("|Author URI: (.*)|", $plg_data, $val) )
	{
		$plugin['author uri'] = trim($val[1]);
	}
	if (!empty($plugin['uri']) and strpos($plugin['uri'] , 'extension_view.php?eid='))
	{
		list( , $extension) = explode('extension_view.php?eid=', $plugin['uri']);
		if (is_numeric($extension)) $plugin['extension'] = $extension;
	}
	// IMPORTANT SECURITY !
	$plugin = array_map('htmlspecialchars', $plugin);

	return $plugin ;
}

function regphpbb_obsolete_files()
{
	if (file_exists(REGPHPBB_PATH.'obsolete.list')
		and $old_files = file(REGPHPBB_PATH.'obsolete.list', FILE_IGNORE_NEW_LINES)
		and !empty($old_files))
	{
		array_push($old_files, 'obsolete.list');
		foreach($old_files as $old_file)
		{
			$path = REGPHPBB_PATH.$old_file;
			if (is_file($path))
			{
				@unlink($path);
			}
		}
	}
}
?>