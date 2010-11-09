<?php
// +-----------------------------------------------------------------------+
// | Plugin Name : Register_PhpBB                                          |
// | Plugin Version : 1.2a                                                 |
// | File Version : 0.3                                                    |
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

// *****************************************
// ** Add user to the PhpBB #_users table **
// *****************************************

// Load Plugin settings from database
load_conf_from_db('param like \'phpbb\\_%\'');

global $conf;

// Password hashing method
if (function_exists('sha1'))	// Only in PHP 4.3.0+
	{
    	$password = sha1($_POST['password']);
	}
else if (function_exists('mhash'))	// Only if Mhash library is loaded
	{
    	$password =  bin2hex(mhash(MHASH_SHA1, $_POST['password']));
	}
else
	{
    	$password =  md5($_POST['password']);
	}

// Getting the last user Id
$query0 = '
		SELECT MAX(user_id) AS total FROM
		'.$conf['phpbb_prefix'].'users;
	';
$result0 = pwg_query($query0);
$row0 = mysql_fetch_array($result0);

// New user Id is the last one + 1
$id_user_phpbb = $row0['total'] + 1;

// Registration date and time
$registred = time();

// Check wich email var is used
if (defined('IN_ADMIN') and IN_ADMIN) /* This is for adding a user in admin panel */
	{
		$mail = $_POST['email'];
		$query1 = "
        	INSERT INTO ".$conf['phpbb_prefix']."users
			(user_id, user_active, user_actkey, username, user_password, user_session_time, user_session_page, user_lastvisit, user_regdate, user_level, user_posts, user_style, user_lang, user_dateformat, user_new_privmsg, user_unread_privmsg, user_last_privmsg, user_login_tries, user_last_login_try, user_viewemail, user_attachsig, user_allowhtml, user_allowbbcode, user_allowsmile, user_allowavatar, user_allow_pm, user_allow_viewonline, user_notify, user_notify_pm, user_popup_pm, user_rank, user_avatar_type, user_email)
			VALUES (
				'".$id_user_phpbb."',
				'1',
			    '',
			    '".$_POST['login']."',
			    '".$password."', 
			    '0',
			    '0',
			    '".$registred."',
			    '".$registred."', 
				'0',
			    '0',
			    '".$conf['phpbb_style']."',
			    '".$conf['phpbb_language']."',
			    'D M d, Y g:i a',
			    '0',
			    '0',
			    '0',
			    '0',
		    	'0',
			    '0',
			    '1',
			    '0',
		    	'1',
			    '1',
			    '1',
			    '1',
		    	'1',
			    '0',
			    '1',
			    '1',
		    	'0',
			    '0',
			    '".$mail."'
			);
		";
		$result1 = pwg_query($query1);
	}
else /* This is when a user registered himself with the register form */
	{
		$query2 = "
			INSERT INTO ".$conf['phpbb_prefix']."users
			(user_id, user_active, user_actkey, username, user_password, user_session_time, user_session_page, user_lastvisit, user_regdate, user_level, user_posts, user_style, user_lang, user_dateformat, user_new_privmsg, user_unread_privmsg, user_last_privmsg, user_login_tries, user_last_login_try, user_viewemail, user_attachsig, user_allowhtml, user_allowbbcode, user_allowsmile, user_allowavatar, user_allow_pm, user_allow_viewonline, user_notify, user_notify_pm, user_popup_pm, user_rank, user_avatar_type, user_email)
			VALUES (
				'".$id_user_phpbb."',
				'1',
			    '',
			    '".$_POST['login']."',
			    '".$password."', 
			    '0',
			    '0',
			    '".$registred."',
			    '".$registred."', 
				'0',
			    '0',
			    '".$conf['phpbb_style']."',
			    '".$conf['phpbb_language']."',
			    'D M d, Y g:i a',
			    '0',
			    '0',
			    '0',
			    '0',
		    	'0',
			    '0',
			    '1',
			    '0',
		    	'1',
			    '1',
			    '1',
			    '1',
		    	'1',
			    '0',
			    '1',
			    '1',
		    	'0',
			    '0',
			    '".$_POST['mail_address']."'
			);
		";
		$result2 = pwg_query($query2);
	}

// Processing forum groups
$query3 = "
		INSERT INTO ".$conf['phpbb_prefix']."groups
			(group_name, group_description, group_single_user, group_moderator)
		VALUES ('".$_POST['login']."', 'Personal User', 1, 0)";
$result3 = pwg_query($query3);
 
$group_id = mysql_insert_id();
 
$query4 = "
		INSERT INTO ".$conf['phpbb_prefix']."user_group
			(group_id, user_id, user_pending)
		VALUES ('".$group_id."','".$id_user_phpbb."','0');
	";
$result4 = pwg_query($query4);

// Retrieve user ID in PhpBB user table
//$id_user_phpbb = mysql_insert_id();

// Retrieve user ID in PWG user table
$user_id_pwg = get_userid($_POST['login']);

// Insertion of the ID in the pwg/phpbb correspondence table
$query5 = "
        INSERT INTO ".PLUGIN_REGISTER_PHPBB_ID." (id_user_pwg, id_user_phpbb)
        VALUES('".$user_id_pwg."', '".$id_user_phpbb."');";
$result5 = pwg_query($query5);
?>