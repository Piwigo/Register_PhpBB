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

// *********************************************
// ** Correspondence table re synchronization **
// *********************************************

include_once( PHPWG_ROOT_PATH.'include/common.inc.php' );

// Empty the ids from table
$query_1 = "TRUNCATE ".PLUGIN_REGISTER_PHPBB_ID.";";
$result_1 = pwg_query($query_1);

// Selection of all PWG accounts
$query = "
        SELECT id AS id_pwg, username
		FROM ".USERS_TABLE.";
	";
$result = pwg_query($query);

while($data = mysql_fetch_array($result))
{
    // Selection of PhpBB user's id in relation with PWG user's id
    $query_2 = "
            SELECT user_id AS id_phpbb
			FROM ".$conf['phpbb_prefix']."users
			WHERE username = '".$data['username']."';
		";
    $result_2 = pwg_query($query_2);

    while($data_1 = mysql_fetch_array($result_2))
    {
        // Insert PWG id and PhpBB id in correspondence table
        $query_3 = "
                INSERT INTO ".PLUGIN_REGISTER_PHPBB_ID." (id_user_pwg, id_user_phpbb)
                VALUES (".$data['id_pwg'].", ".$data_1['id_phpbb'].");";
        $result_3 = pwg_query($query_3);
    }
}
echo 'Re synchronization done !';

//TODO: Get re synchro result into a template
?>