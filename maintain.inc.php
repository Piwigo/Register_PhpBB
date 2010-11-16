<?php

if(!defined("REGPHPBB_DIR")) define('REGPHPBB_DIR' , basename(dirname(__FILE__)));
if(!defined("REGPHPBB_PATH")) define('REGPHPBB_PATH' , PHPWG_PLUGINS_PATH.REGPHPBB_DIR.'/');
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', true);

include_once (PHPWG_ROOT_PATH.'/include/constants.php');
include_once (REGPHPBB_PATH.'include/constants.php');
include_once (REGPHPBB_PATH.'include/functions.inc.php');


function plugin_install()
{
  global $prefixeTable;

  $q = '
INSERT INTO '.CONFIG_TABLE.' (param,value,comment)
VALUES ("Register_PhpBB","phpbb_;admin;Anonymous;false;true;false;REGISTERED","Parametres Register_PhpBB")
;';

  pwg_query($q);

  $q = "
CREATE TABLE IF NOT EXISTS ".Register_PhpBB_ID_TABLE." (
  id_user_pwg smallint(5) NOT NULL default '0',
  id_user_PhpBB int(10) NOT NULL default '0',
PRIMARY KEY  (id_user_pwg),
  KEY id_user_pwg (id_user_pwg, id_user_PhpBB)
)
;";

  pwg_query($q);

}

function plugin_activate()
{
  global $conf;

/* Cleaning obsolete files */
/* *********************** */
  regphpbb_obsolete_files();

/* Check version < 2.3.0 */
  $conf_Register_PhpBB = isset($conf['Register_PhpBB']) ? explode(";" , $conf['Register_PhpBB']) : array();

  if (!isset($conf_Register_PhpBB[5]) and !isset($conf_Register_PhpBB[6]))
  {
    $upgrade_RFBB = $conf_Register_PhpBB[0].';'.$conf_Register_PhpBB[1].';'.$conf_Register_PhpBB[2].';'.$conf_Register_PhpBB[3].';'.$conf_Register_PhpBB[4].';false;REGISTERED';

    $query = '
UPDATE '.CONFIG_TABLE.'
SET value="'.$upgrade_RFBB.'"
WHERE param="Register_PhpBB"
LIMIT 1
;';
		pwg_query($query);
  }
}

function plugin_uninstall()
{
  global $conf;

  if (isset($conf['Register_PhpBB']))
  {
    $q = '
DELETE FROM '.CONFIG_TABLE.'
WHERE param="Register_PhpBB" LIMIT 1
;';

    pwg_query($q);
  }

  $q = 'DROP TABLE '.Register_PhpBB_ID_TABLE.';';
  pwg_query( $q );

}
?>