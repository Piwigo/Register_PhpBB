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

// Password hashing method
if (function_exists('sha1'))	// Only in PHP 4.3.0+
{
    $password = sha1($_POST['use_new_pwd']);
}
else if (function_exists('mhash'))	// Only if Mhash library is loaded
{
    $password =  bin2hex(mhash(MHASH_SHA1, $_POST['use_new_pwd']));
}
else
{
    $password =  md5($_POST['use_new_pwd']);
}

// Retrieve user ID in PhpBB user table
$query = '
        SELECT id_user_phpbb
        FROM '.PLUGIN_REGISTER_PHPBB_ID
        .' WHERE id_user_pwg = '.$userdata['id'].';
    ';
$result = pwg_query($query);

while($row = mysql_fetch_array($result))
{
    // Email modification
    $query = '
            UPDATE '.$conf['phpbb_prefix'].'users 
            SET user_email = \''.$_POST['mail_address'].'\'';

            // If new password field is empty
            // the change is set in the PhpBB
            // users table with password hashing.
            if (!empty($_POST['use_new_pwd']))
            {
                $query.= ', user_password = \''.$password.'\'';
            }
            $query.= ' WHERE id = '.$row['id_user_phpbb'].';
        ';
    $result = pwg_query($query);
}
?>