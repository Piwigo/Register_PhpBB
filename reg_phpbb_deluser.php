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

// ********************************************
// ** Delete user from the PhpBB users table **
// ********************************************

// Load Plugin settings from database
load_conf_from_db('param like \'phpbb\\_%\'');

global $conf;

// ID selection in the pwg/phpbb correspondence table
$query = "
        SELECT id_user_phpbb, id_user_pwg FROM ".PLUGIN_REGISTER_PHPBB_ID."
        WHERE id_user_pwg = ".$user_id.";
    ";
$result = pwg_query($query);

while($data = mysql_fetch_array($result))
{
  // Selection du nom d'utilisateur
  $query_0 = "
		SELECT username, user_id
		FROM ".$conf['phpbb_prefix']."users
		WHERE user_id = ".$data['id_user_phpbb'].";
	";
  $result_0 = pwg_query($query_0);
  
  while ($data_0 = mysql_fetch_array($result_0))
  {
    // Suppression des liens groupe -- utilisateur
    $query_1 = "
			DELETE FROM ".$conf['phpbb_prefix']."groups
			WHERE group_name = '".$data_0['username']."';
		";
    $result_1 = pwg_query($query_1);
  }
    
  // Si יgale א 0, suppression de tous les posts et topics
  if ($conf['phpbb_del_pt'] == 0)
  {
    // Suppression des posts de l'utilisateur
    $query_2 = "
			DELETE FROM ".$conf['phpbb_prefix']."posts
			WHERE poster_id = ".$data['id_user_phpbb'].";
		";
    $result_2 = pwg_query($query_2);

    // Suppression des topics de cet utilisateur
    $query_3 = "
			DELETE FROM ".$conf['phpbb_prefix']."topics
			WHERE topic_poster = ".$data['id_user_phpbb'].";
		";
    $result_3 = pwg_query($query_3);
  }

  // Suppression des abonnements de l'utilisateur
  $query_4 = "
  		DELETE FROM ".$conf['phpbb_prefix']."topics_watch
		WHERE user_id = ".$data['id_user_phpbb'].";
	";
  $result_4 = pwg_query($query_4);
  
  // Suppression du compte utilisateur
  $query_5 = "
  		DELETE FROM ".$conf['phpbb_prefix']."users
		WHERE user_id = ".$data['id_user_phpbb'].";
	";
  $result_5 = pwg_query($query_5);
  
  // Suppression des liens groupe -- utilisateur
  $query_6 = "
  		DELETE FROM ".$conf['phpbb_prefix']."user_group
		WHERE user_id = ".$data['id_user_phpbb'].";
	";
  $result_6 = pwg_query($query_6);
 
  // Suppression de la correspondance pwg/phpbb
  $query_7 = "
  		DELETE FROM ".PLUGIN_REGISTER_PHPBB_ID."
  		WHERE id_user_pwg = ".$user_id.";
	";
  $result_7 = pwg_query($query_7);
}
?>