<?php
// +-----------------------------------------------------------------------+
// | PhpWebGallery - a PHP based picture gallery                           |
// | Copyright (C) 2002-2003 Pierrick LE GALL - pierrick@phpwebgallery.net |
// | Copyright (C) 2003-2007 PhpWebGallery Team - http://phpwebgallery.net |
// +-----------------------------------------------------------------------+
//$lang_info['language_name'] = 'English';
//$lang_info['country'] = ''Great Britain';
//$lang_info['charset'] = 'iso-8859-1';
//$lang_info['direction'] = 'ltr';
//$lang_info['code'] = 'en';
global $lang;
$lang['Title'] = 'Register PhpBB';
$lang['Howto'] = 'This plugin permits to record an user, registering on PWG, in a PhpBB forum, automatically. It\'s based on the Mod Register_PhpBB achieved by Flipflip that I thank, here, to have initialized the project. Special thanks to Rub (PWG Team) for his precious help.';
$lang['Install_Disclaimer']='Warning ! After the complete activation of this plugin, all  users administrative manipulations  (manual addition, deletion, modification) for these two scripts (PWG and PhpBB) should be achieved through the admin interface of PWG. It\'s counseled to disactivate the registering of PhpBB but it is not obligatory. The two scripts can continue to function independently but the users who registers on the forum won\'t have a valid account to reach your gallery. On the contrary, an user who registers on the gallery becomes automatically member of the forum... That\'s the confessed goal of this plugin  ;-)';
$lang['Update']='Update process';
$lang['Update_Disclaimer']='<u>Only for those that used the Mod version of this plugin</u>, here are the steps to update :<br/><ol><li>Delete the whole code added to the source of PWG (refer to the Mod installation file)  in order to come back to a situation before application of the Mod.</li><li>Delete the PLUGIN_REGISTER_PHPBB_ID_USER table of the database. This table is created by the installation of the plugin, must be empty and won\'t be used.</li><li>Rename the MOD_REGISTER_PHPBB_ID_USER table in PLUGIN_REGISTER_PHPBB_ID_USER</li><li>Verify, correct and activate the behavior parameters of the plugin => <u>Go to step 1 - DO NOT PROCESS THE STEP 2 MIGRATION FUNCTIONS !</u></li><li>The resynchronisation is optional. It will put back in order table of correspondence.</li></ol>';
$lang['Install_Disclaimer2']='In a first time, it is necessary to set the working parameters of the plugin with PhpBB, then, to copy the  PWG users accounts toward PhpBB. A third function is available in order to resynchronize the tables in the case where one addition or user\'s deletion took place badly. But you should not have to use it.<br/><br/>At the end of the 2 main steps, the plugin will be fully functional and you won\'t have to come back on this page anymore.';
$lang['Step1_Title'] = 'Step 1 : Plugin settings';
$lang['Step1_Disclaimer'] = 'Verify the parameters according to your PhpBB installation and correct them if needed. Modify, if the case arises, the behavior of the plugin to your suitability. Finally, don\'t forget to pass the activation of the plugin to 1 before recording your parameters!';
$lang['PluginActivation']='Activate or Disactivate the registration in PhpBB<br/>
0 --&gt; Disactivate (no automatic addition of the users in PhpBB)<br/>
1 --&gt; Activate<br/>';
$lang['Phpbb_Prefix']='PhpBB tables prefix :';
$lang['Phpbb_Admin']='Username of the PWG administrator. <b><u>Must be identical to the PhpBB adminnistrator username</u></b> :';
$lang['Phpbb_Timezone']='Time zone (de -12 à 14) :';
$lang['Phpbb_Language']='Language (French, English) :';
$lang['Phpbb_Style']='Forum style Id (default value is 1):';
$lang['Phpbb_Del_Pt']='Delete user topics and posts when user is deleted.<br/>
0 --&gt; Delete all<br/>
1 --&gt; Do not delete topics and posts<br/>';
$lang['Step2_Btn']='Migration';
$lang['Step2_Title']='Step 2 : Migration of the PWG accounts toward PhpBB / Re synchronization of the accounts';
$lang['Step2_Text']='Two cases here : <br/><br/><u>1) You never used the Mod Register_PhpBB and even less the same named plugin</u> -> In this case, your PhpBB table #_users must be empty of all account. You can then click <b>ONE TIME</b> on "Migration" button. If some mistakes occur during the operation, empty the tables [PhpBB] _users and [PWG] _plugin_register_PhpBB_id_user (via PhpMyAdmin for example), correct the reason of the problem and restart the operation of migration (to that moment only you can click again on the "Migration" button).';
$lang['Step22_Text']='<b>NEVER RE DO THIS OPERATION MORE THAN ONE TIME</b> !';
$lang['Step3_Btn']='Resynch';
$lang['Step3_Text']='<u>2) You already used the Mod / plugin (update of a previous version of PWG toward the present)</u> -> It means that you already have an ID correspondence table  between PWG and PhpBB. The script of re synchronization will detect the present data while comparing the names of the users and their e-mail address in the two #_users tables (PWG and PhpBB) and will put up to date this table of correspondence. At the end of the operation, please verify the presence of possible duplicated users in PhpBB. If it is the case, it is necessary to suppress the oldest (sorting of the PhpBB users according to their registration date).<br/><br/>';
?>
