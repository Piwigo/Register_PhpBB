<?php
// +-----------------------------------------------------------------------+
// | Plugin Name : Register_PhpBB                                          |
// | Plugin Version : 1.2a                                                 |
// | File Version : 0.2                                                    |
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

// ******************************************
// ** Database install - uninstall queries **
// ******************************************

  define('REGISTER_PHPBB_PATH' , PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');
  include_once(REGISTER_PHPBB_PATH.'include/constants.php');
  
function plugin_install()
{
	$q = '
INSERT INTO '.CONFIG_TABLE.' (param,value,comment)
	VALUES
	("phpbb_status","0","Activation of Register_PhpBB plugin");';

  pwg_query($q);

	$q = '
INSERT INTO '.CONFIG_TABLE.' (param,value,comment)
	VALUES
	("phpbb_prefix","phpbb_","PhpBB prefix tables");';

  pwg_query($q);

	$q = '
INSERT INTO '.CONFIG_TABLE.' (param,value,comment)
	VALUES
	("phpbb_admin","admin","PWG administrator username. Must be the same as PhpBB administrator username");';

  pwg_query($q);

	$q = '
INSERT INTO '.CONFIG_TABLE.' (param,value,comment)
	VALUES
	("phpbb_timezone","1","Timezone");';

  pwg_query($q);

	$q = '
INSERT INTO '.CONFIG_TABLE.' (param,value,comment)
	VALUES
	("phpbb_language","English","Language");';

  pwg_query($q);

	$q = '
INSERT INTO '.CONFIG_TABLE.' (param,value,comment)
	VALUES
	("phpbb_style","1","Default forum\'s skin ID");';

  pwg_query($q);
  
  	$q = '
INSERT INTO '.CONFIG_TABLE.' (param,value,comment)
	VALUES
	("phpbb_del_pt","1","Deletion of topics and posts from deleted user");';

  pwg_query($q);

	$q = '
CREATE TABLE IF NOT EXISTS '.PLUGIN_REGISTER_PHPBB_ID.' (
  id_user_pwg smallint(5) NOT NULL default "0",
  id_user_phpbb int(10) NOT NULL default "0",
  KEY id_user_pwg (id_user_pwg,id_user_phpbb));';

  pwg_query($q);
}


function plugin_uninstall()
{
  $q = '
DELETE FROM '.CONFIG_TABLE.' WHERE param="phpbb_status" LIMIT 1;';
  pwg_query( $q );

  $q = '
DELETE FROM '.CONFIG_TABLE.' WHERE param="phpbb_prefix" LIMIT 1;';
  pwg_query( $q );

  $q = '
DELETE FROM '.CONFIG_TABLE.' WHERE param="phpbb_admin" LIMIT 1;';
  pwg_query( $q );

  $q = '
DELETE FROM '.CONFIG_TABLE.' WHERE param="phpbb_timezone" LIMIT 1;';
  pwg_query( $q );

  $q = '
DELETE FROM '.CONFIG_TABLE.' WHERE param="phpbb_language" LIMIT 1;';
  pwg_query( $q );

  $q = '
DELETE FROM '.CONFIG_TABLE.' WHERE param="phpbb_style" LIMIT 1;';
  pwg_query( $q );

  $q = '
DELETE FROM '.CONFIG_TABLE.' WHERE param="phpbb_del_pt" LIMIT 1;';
  pwg_query( $q );

  $q = 'DROP TABLE '.PLUGIN_REGISTER_PHPBB_ID.';';
  pwg_query( $q );
}

?>