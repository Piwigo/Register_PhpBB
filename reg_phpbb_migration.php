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

// **************************************
// ** User migration from PWG to PhpBB **
// **************************************

include_once( PHPWG_ROOT_PATH.'include/common.inc.php' );

echo '<h2>Migration des comptes PhpWebGallery vers PhpBB</h2>';

// Select of PWG users
$query = 'SELECT username, password, mail_address FROM '.USERS_TABLE.';';
$result = pwg_query($query);

$registred = time();
$registred_ip = '127.0.0.1';

while ($row = mysql_fetch_array($result))
{
    if(($row['username'] != 'guest') AND ($row['username'] != $conf['phpbb_admin']))
    {
        echo '<b>Transfert du compte :</b> '.$row['username'].' --> ';
        
        // Getting the last user Id
        $query_1 = '
				SELECT MAX(user_id) AS total
				FROM '.$conf['phpbb_prefix'].'users;
			';
		$result_1 = pwg_query($query_1);
    	$row_1 = mysql_fetch_array($result_1);
		// The new user Id is the last one + 1
		$user_id = $row_1['total'] + 1;
        
        $query_2 = "
			INSERT INTO ".$conf['phpbb_prefix']."users
			(user_id, user_active, user_actkey, username, user_password, user_session_time, user_session_page, user_lastvisit, user_regdate, user_level, user_posts, user_style, user_lang, user_dateformat, user_new_privmsg, user_unread_privmsg, user_last_privmsg, user_login_tries, user_last_login_try, user_viewemail, user_attachsig, user_allowhtml, user_allowbbcode, user_allowsmile, user_allowavatar, user_allow_pm, user_allow_viewonline, user_notify, user_notify_pm, user_popup_pm, user_rank, user_avatar_type, user_email)
			VALUES (
				'".$user_id."',
				'1',
			    '',
			    '".$row['username']."',
			    '".$row['password']."', 
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
			    '".$row['mail_address']."'
			);
		";
        $result_2 = pwg_query($query_2);

        // Get PhpBB user Id
        $id_user_phpbb = mysql_insert_id();

		$query_3 = "
				INSERT INTO ".$conf['phpbb_prefix']."groups
				(group_name, group_description, group_single_user, group_moderator)
				VALUES ('".$row['username']."', 'Personal User', 1, 0);
			";
    	$result_3 = pwg_query($query_3);

    	$group_id = mysql_insert_id();

    	$query_4 = "
				INSERT INTO ".$conf['phpbb_prefix']."user_group
				(group_id, user_id, user_pending)
				VALUES ('".$group_id."','".$id_user_phpbb."','0');
			";
    	$result_4 = pwg_query($query_4);

        // Get PWG user Id
        $user_id_pwg = get_userid($row['username']);

        // Insert of PWG user id and PhpBB user id on correspondence table
        $query_5 = "
                INSERT INTO ".PLUGIN_REGISTER_PHPBB_ID." (id_user_pwg, id_user_phpbb)
                VALUES('".$user_id_pwg."', '".$id_user_phpbb."');
			";
        $result_5 = pwg_query($query_5);
        echo '<b>Migration done !</b><br>';
    }
}

//TODO: Get the migration result into a template
?>