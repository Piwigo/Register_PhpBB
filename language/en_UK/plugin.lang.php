<?php
$lang['Tab_Info'] = 'Instructions';
$lang['Tab_Manage'] = 'Step 1 : Plugin configuration';
$lang['Tab_Migration'] = 'Step 2 : Accounts migration';
$lang['Tab_Synchro'] = 'Maintenance : Accounts re-synchronization';

$lang['Title'] = 'Register PhpBB';
$lang['Disclaimer'] = '
  *** To begin, follow this 2 steps ***<br>
  Step 1 : Set plugin with the parameters of PhpBB.<br>
  Step 2 : Migrate user accounts from Piwigo to PhpBB.<br><br>
  After these 2 main steps, the plugin is fully functional and you will not have to return to this pages.<br><br>
  *** For the maintenance of already active connections ***<br>
  Maintenance : Synchronize tables (in case an addition, an update or a user deletion mismatched) allows to update passwords and email addresses and see users intruder (But you should not need to use ).<br><br>
  <div class="warning">WARNING !! For safety, consider making a backup of your database, especially ###_user tables before any action.</div>';

$lang['Config_Title'] = 'Plugin setup';
$lang['Config_Disclaimer'] = '
  Check the settings of your PhpBB installation and correct them if necessary. <br>
  Change, if any, the behavior of the plugin at your convenience.';
$lang['Prefix'] = 'PhpBB Prefix tables :';
$lang['Guest'] = 'Username of the PhpBB Guest user. (If you do not know, leave as is).';
$lang['Details'] = 'Level of detail in reports of operations.';
$lang['Details_true'] = ' --&gt; View all details of the results of operations.';
$lang['Details_false'] = ' --&gt; Shows that most of the results of operations';
$lang['Del_Pt'] = 'Removal of topics and posts when the user is deleted.';
$lang['Del_Pt_true'] = ' --&gt; Delete all';
$lang['Del_Pt_false'] = ' --&gt; Don\'t delete topics and posts';
$lang['Confirm'] = 'Delete confirmation on the administration actions in the audit.';
$lang['Confirm_true'] = ' --&gt; Delete confirmation';
$lang['Confirm_false'] = ' --&gt; Confirmation mandatory before actions in audit';

$lang['save_config'] ='Settings saved';

$lang['Audit_Btn'] = 'Audit';
$lang['Sync_Btn'] = 'Synchronization';
$lang['Sync_Title'] = 'Synchronize accounts from Piwigo to PhpBB';
$lang['Sync_Text'] = '
  <div class="warning">You\'ve already used the plugin to link your Piwigo (plugin update) and / or your PhpBB forum is not empty of users!</div>
  <br> -> This means that your forum owns users.<br><br>
  - Synchronization detect the data by comparing the usernames, passwords (encrypted) and their email address in both tables [PrefixPWG]_user and [PrefixPhpBB]_user.<br>
  - Then update the table of correspondence as well as password and email address for each account from Piwigo to PhpBB except Piwigo Guest and PhpBB Anonymous.<br>
  - Finally indicate mislead orphaned accounts that exist only in one of the 2 ###_user tables.<br>
  <br>
  At the end of the operation, launch an audit and check for possible duplicates users in PhpBB. If so, delete the oldest (sorting PhpBB users according to their date of registration).<br>';
$lang['Sync_Check_Dup'] = '<b>Analyzing tables of user accounts of Piwigo and PhpBB to control duplicates</b>';
$lang['Advise_Check_Dup'] = '<b>Impossible to continue the synchronization if you have duplicates in the User Account of Piwigo or PhpBB.</b><br><br>';
$lang['Sync_Link_Break'] = '<b>Analysis of repairable links between accounts in Piwigo and PhpBB</b>';
$lang['Sync_Link_Bad'] = '<b>Analysis of bad relationships between accounts in Piwigo and PhpBB</b>';
$lang['Sync_DataUser'] = '<b>Analysis of passwords and email addresses between accounts in Piwigo and PhpBB</b>';
$lang['Sync_PWG2PhpBB'] = '<b>Analysis of existing accounts in Piwigo and missing in PhpBB</b>';
$lang['Sync_PhpBB2PWG'] = '<b>Analysis of existing accounts in PhpBB and missing in Piwigo</b>';
$lang['Sync_OK'] = 'Synchronization OK<br><br>';

$lang['Audit_PWG_Dup'] = '<b>Audit of Piwigo\'s accounts table</b>';
$lang['Error_PWG_Dup'] = '<b>Error in Piwigo\'s accounts table, there are duplicates:</b> ';
$lang['Advise_PWG_Dup'] = '<b>WARNING! You must make these corrections in Piwigo before continuing<br>use Piwigo\'s user manager to resolve the problem.</b>';

$lang['Audit_PhpBB_Dup'] = '<b>Audit of PhpBB\'s accounts table</b>';
$lang['Error_PhpBB_Dup'] = '<b>Error in PhpBB\'s accounts table, there are duplicates:</b> ';
$lang['Advise_PhpBB_Dup'] = '<b>WARNING! You must make these corrections in PhpBB before continuing<br>use the icons to delete users from PhpBB and resolve the problem.</b>';

$lang['Audit_Link_Break'] = '<b>Audit of repairable links between Piwigo and PhpBB accounts</b>';
$lang['Error_Link_Break'] = '<b>Broken link between Piwigo and PhpBB accounts:</b> ';
$lang['New_Link'] = 'Account linked: ';

$lang['Audit_Link_Bad'] = '<b>Audit of bad links between Piwigo and PhpBB accounts</b>';
$lang['Error_Link_Del'] = '<b>Error in the link table between 2 users:</b> ';
$lang['Link_Del'] = 'Remove of link: ';
$lang['Error_Link_Dead'] = '<b>Error in the link table, dead links:</b> ';
$lang['Link_Dead'] = 'Remove of dead links ';
$lang['Error_Link_Dup'] = '<b>Error in the link table, there are duplicates:</b> ';
$lang['Link_Dup'] = 'Remove of duplicates ';

$lang['Audit_Synchro'] = '<b>Audit of the synchronization of passwords and email addresses between Piwigo and PhpBB accounts</b>';
$lang['Error_Synchro'] = '<b>Bad synchronization of account:</b> ';
$lang['Error_Synchro_Pswd'] = 'on password';
$lang['Error_Synchro_Mail'] = 'on email address';
$lang['Audit_Synchro_OK'] = ' <b>: Data synchronization OK</b>';
$lang['Sync_User'] = 'Account synchronization : ';

$lang['Audit_PWG2PhpBB'] = '<b>Audit of the existing accounts in Piwigo and missing in PhpBB</b>';
$lang['Error_PWG2PhpBB'] = '<b>The Piwigo account not in PhpBB:</b> ';
$lang['Add_User'] = 'Adding in PhpBB of account: ';

$lang['Audit_PhpBB2PWG'] = '<b>Audit of the existing accounts in PhpBB and missing in Piwigo</b>';
$lang['Error_PhpBB2PWG'] = '<b>The PhpBB account not in Piwigo:</b> ';
$lang['Del_User'] = 'Removal from PhpBB of account : ';

$lang['Audit_OK'] = 'Audit OK<br><br>';

$lang['Mig_Btn'] = 'Migration';
$lang['Mig_Title'] = 'Migration of accounts from Piwigo to PhpBB';
$lang['Mig_Text'] = '
  <div class="warning"> USE ONLY IF you have never used the plugin to link Piwigo to PhpBB <u>AND IF</u> your forum is empty of users !!!</b></div><br>
  		--> In this case, your table [PrefixPhpBB]_user of PhpBB must be empty of any account except the 2 accounts guest and administrator, as well as search bots.<br><br>
  - The migration will first remove the links between accounts of Piwigo and PhpBB.<br>
  - Then <b>WILL DELETE ALL PhpBB ACCOUNTS</b> except the 2 accounts guest and administrator.<br>
  <br>
  <div class="warning">WARNING IF YOU HAVE ANY SPECIAL ACCOUNTS IN PhpBB == DO NOT USE THIS FUNCTION !!!</div><br>
  - Finally, the migration will create all Piwigo\'s accounts in PhpBB, except the guest.<br>
  <br>
  If errors occur during operation, correct the cause of the problem and retry the operation of migration (at the time only you can renew the migration).<br>';
$lang['Mig_Disclaimer'] = '<div class="warning"> NEVER PERFORM MIGRATION FOR UPDATING !!!</div>';
$lang['Mig_Start'] = '<b>Migration of accounts from Piwigo to PhpBB</b>';
$lang['Mig_Del_Link'] = '<b>Deleting links between accounts of Piwigo and PhpBB</b>';
$lang['Mig_Del_AllUsers'] = '<b>Deleting PhpBB accounts</b>';
$lang['Mig_Del_User'] = '<b>Deletion of the account:</b> ';
$lang['Mig_Add_AllUsers'] = '<b>Transferring Piwigo accounts</b>';
$lang['Mig_Add_User'] = '<b>Transfer of account:</b> ';
$lang['Mig_End'] = '<b>Migration done !</b>';
$lang['Title_Tab'] = 'Register_PhpBB - Version: ';

// --------- Starting below: New or revised $lang ---- from version 2.3.0
$lang['No_Reg_advise'] = '
  For better integration, it is advisable to make the following changes to your PhpBB forum (<b>Warning: These changes will disappear when updating the forum</b>):
<br><br>
  <b>* Modify the file</b> : [PhpBBRoot]/ucp.php by searching the following line :
  <div class="mod">case \'sendpassword\':</div>
  <b>and replace the 2 following lines (to break) by :</b>
  <div class="info">redirect(\'http://[PiwigoRoot]/password.php\', false, true);</div>
  <br><br>
  <b>* Modify the same file</b> : Search the following line :
  <div class="mod">case \'register\':</div>
  <b>and replace the 7 following lines (to break) by :</b>
  <div class="info">redirect(\'http://[PiwigoRoot]/register.php\', false, true);</div>
  <br><br>
  * In the <b>Control Panel</b>, go to the permissions of the groups and change the line "Can change password" to <b>No</b>.
  <br>';
$lang['About_Reg'] = 'About the registration of users on the forum PhpBB';
$lang['Bridge_UAM'] = 'Access validation to the forum via UserAdvManager (UAM) plugin: Turn the bridge on between the two plugins that will allow you to prohibit the access to your PhpBB forum until the user has not validated its registration in the gallery (the function must be active on UAM).';
$lang['Bridge_UAM_true'] = ' --> Enable bridge Register_PhpBB / UAM';
$lang['Bridge_UAM_false'] = ' --> Disable bridge Register_PhpBB / UAM (default)';
$lang['PhpBB_Group'] = 'Specify the name of <b>PhpBB\' group</b> in which validated users must be (to be created in advance in PhpBB). By default, type "REGISTERED" (registered users). For more information, see end of this page.';
$lang['About_Bridge'] = 'About Register_PhpBB / UAM bridge';
$lang['UAM_Bridge_advice'] = 'The UserAdvManager plugin allows forcing new registrants to confirm their registration before allowing them to access the entire gallery. The joint use of this plugin with Register_PhpBB can do the same on the forum linked: Registrants can not post until they have validated their registration in the gallery. <br>
Here is the general procedure to apply:
<br><br>
- Several groups are created by default when creating your forum. Two of them are called "New registered users" and "Registered Users". The first group has very limited permissions that are adjustable in the Control Panel. It is in this group that not validated users are sent in the case where the bridge is active. Otherwise, users are assigned by default to the second group, which has more rights, also modifiable. <br>
- You can choose to create a new group for your validated users, or simply use "Registered Users" and change some settings.<br>
- Then simply type above the group name chosen for validated users: "REGISTERED" if you keep the one created at the beginning or "Members" or "VIP" ... if you have created your own group. The syntax should be the same as chosen in phpBB when creating the group (uppercase, lowercase ...).<br>
<br><br>
<b class="mod"><u>Important notes:</u></b>
<br><br>
If you\'ve never used Register_PhpBB, the Piwigo\'s accounts migration phase from your gallery to your PhpBB forum will disregard the state validated or not for the accounts at the launch of the migration phase.';
// --------- End: New or revised $lang ---- from version 2.3.0

// --------- Starting below: New or revised $lang ---- from version 2.3.3
$lang['Admin'] = 'Piwigo\'s administrator username. <b style="color: red">The username of PhpBB\'s administrator account has to be the same!</b>';
$lang['error_config_admin1'] = 'ERROR : Piwigo\'s admin username is wrong!';
$lang['error_config_admin2'] = 'ERROR : The name of the PhpBB\'s administrator account is different from that of Piwigo ! Check the configuration of your PhpBB forum and rename the administrator account in the same name as that of Piwigo.';
$lang['error_config_guest'] = 'ERROR : The name of the PhpBB\'s guest account is wrong!';
// --------- End: New or revised $lang ---- from version 2.3.3
?>