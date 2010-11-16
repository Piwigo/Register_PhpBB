<?php

global $prefixeTable, $conf;

$conf_Register_PhpBB = isset($conf['Register_PhpBB']) ? explode(";" , $conf['Register_PhpBB']) : array();

define('Register_PhpBB_ID_TABLE', $prefixeTable.'Register_PhpBB_id');

if (isset($conf_Register_PhpBB[0]))
{
  define('PhpBB_CONFIG_TABLE', $conf_Register_PhpBB[0].'config');
  define('PhpBB_USERS_TABLE', $conf_Register_PhpBB[0].'users');
  define('PhpBB_POSTS_TABLE', $conf_Register_PhpBB[0].'posts');
  define('PhpBB_TOPICS_TABLE', $conf_Register_PhpBB[0].'topics');
  define('PhpBB_SUBSCRIPTIONS_TABLE', $conf_Register_PhpBB[0].'topics_watch');
  define('PhpBB_GROUPS_TABLE', $conf_Register_PhpBB[0].'groups');
  define('PhpBB_SUBFORUMS_TABLE', $conf_Register_PhpBB[0].'forums_watch');
  define('PhpBB_USERGROUP_TABLE', $conf_Register_PhpBB[0].'user_group');
  define('PhpBB_FORUMS_TABLE', $conf_Register_PhpBB[0].'forums');
  define('PhpBB_TOPICSPOSTED_TABLE', $conf_Register_PhpBB[0].'topics_posted');
  define('PhpBB_FORUMSTRACK_TABLE', $conf_Register_PhpBB[0].'forums_track');
}
?>