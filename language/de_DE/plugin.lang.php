<?php
$lang['Tab_Info'] = 'Anleitung';
$lang['Tab_Manage'] = 'Schritt 1 : Pluginkonfiguration';
$lang['Tab_Migration'] = 'Step 2 : Kontenmigration';
$lang['Tab_Synchro'] = 'Wartung : Kontensynchronisierung';

$lang['Title'] = 'Register PhpBB';
$lang['Disclaimer'] = '
  *** Befolgen Sie bitte die folgenden zwei Schritte, um zu beginnen ***<br>
  Step 1 : Konfigurieren Sie den Plugin für den Zugriff auf PhpBB.<br>
  Step 2 : Migrieren Sie die Benutzerkonten von Piwigo nach PhpBB.<br><br>
  Wenn dies erfolgt ist arbeitet der Plugin voll funktionstüchtig und Sie müssen diese Seiten nicht mehr aufsuchen.<br><br>
  *** Für die Wartung bereits bestehender Verbindungen ***<br>
  Wartung: : Tabellensynchronisation (im Fall des Hinzufügens, Aktualisierens oder Löschens eines Users) erlaubt Ihnen, Passwörter und e-mail Adressen auf den neuesten Stand zu bringen und unerwünschte User zu erkennen (Dies sollten Sie jedoch im Normalfall nicht benötigen).<br><br>
  <div class="warning">Warnung !! Aus Sicherheitsgründen sollten Sie ein Backup Ihrer Datenbank anfertigen (Speziell die ###_user Tabellen).</div>';

$lang['Config_Title'] = 'Pluginkonfiguration';
$lang['Config_Disclaimer'] = '
  Überprüfen Sie die Einstellungen ihrer PhpBB Installation und korrigieren Sie sie gegebenenfalls. <br>
  Passen Sie das Verhalten des Plugins nach Ihren Wünschen an.';
$lang['Prefix'] = 'PhpBB Tabellenpräfix :';
$lang['Guest'] = 'Benutzername des PhpBB Gast-benutzers (Wenn Sie nicht wissen, änderte sich nichts).';
$lang['Details'] = 'Detailgrad der generierten Reports.';
$lang['Details_true'] = ' --&gt; Alle Ergebnisdetails anzeigen.';
$lang['Details_false'] = ' --&gt; Nur die wichtigsten Details der Ergebnisse anzeigen';
$lang['Del_Pt'] = 'Löschen von Themen und Beiträgen, wenn ein Benutzer gelöscht wird.';
$lang['Del_Pt_true'] = ' --&gt; Alle Löschen';
$lang['Del_Pt_false'] = ' --&gt; Themen und Beiträge nicht löschen';
$lang['Confirm'] = 'Bestätigung zum Löschen im Audit durch einen Administrator.';
$lang['Confirm_true'] = ' --&gt; Bestätigung unterdrücken';
$lang['Confirm_false'] = ' --&gt; Bestätigung erforderlich bevor Aktionen im Audit durchgeführt werden';

$lang['save_config'] ='Einstellungen gespeichert';

$lang['Audit_Btn'] = 'Audit';
$lang['Sync_Btn'] = 'Synchronisierung';
$lang['Sync_Title'] = 'Kontensynchronisierung von Piwigo nach PhpBB';
$lang['Sync_Text'] = '
  <div class="warning">Sie haben diesen Plugin bereits benutzt, um Piwigo mit PhpBB zu verbinden und/oder Ihr PhpBB Forum besitzt bereits Benutzerkonten!</div>
  <br> -> Das bedeutet, dass in Ihrem Forum bereits Benutzerkonten angelegt sind.<br><br>
  - Die Synchronisierung extrahiert die Daten durch Vergleichen der Benutzernamen und deren Passwörter (verschlüsselt) und e-mail Adressen in den beiden Tabellen [PrefixPWG]_user and [PrefixPhpBB]_user.<br>
  - Anschliessend müssen Sie diese Daten fuer jedes Benutzerkonto von Piwigo nach PhpBB in die entsprechende Tabelle übertragen (außer für die Benutzer Piwigo Gast und PhpBB Anonym).<br>
  - Danach müssen Sie die Benutzerkonten finden, die nur in einer der beiden ###_user Tabellen vorhanden sind.<br>
  <br>
  Abschliessend starten Sie einen Audit und suchen nach doppelt vorhandenen Benutzerkonten in PhpBB. Sollten Sie einen ausfindig machen, dann löschen Sie den Ältesten, indemSie die PhpBB Benutzerkonten nach dem Datum der Registrierung sortieren.<br>';
$lang['Sync_Check_Dup'] = '<b>Analyse der Tabellen für Benutzerkonten von Piwigo und PhpBB, um Duplikate ausfindig zu machen.</b>';
$lang['Advise_Check_Dup'] = '<b>Die Synchronisierung kann nicht fortgesetzt werden, wenn Sie doppelt vorhanden Benutzerkonten in Piwigo und PhpBB haben.</b><br><br>';
$lang['Sync_Link_Break'] = '<b>Analyse von reparierbaren Links von Benutzerkonten in Piwigo und PhpBB</b>';
$lang['Sync_Link_Bad'] = '<b>Analyse von falschen Beziehungen von Benutzerkonten in Piwigo und PhpBB</b>';
$lang['Sync_DataUser'] = '<b>Analyse von Passwörtern und e-mail Adressen von Benutzerkonten in Piwigo und PhpBB</b>';
$lang['Sync_PWG2PhpBB'] = '<b>Analyse von bestehenden Benutzerkonten in Piwigo und fehlenden Benutzerkonten in PhpBB</b>';
$lang['Sync_PhpBB2PWG'] = '<b>Analyse von bestehenden Benutzerkonten in PhpBB und fehlenden Benutzerkonten in Piwogo</b>';
$lang['Sync_OK'] = 'Synchronisierung OK<br><br>';

$lang['Audit_PWG_Dup'] = '<b>Audit der Kontentabelle von Piwigo</b>';
$lang['Error_PWG_Dup'] = '<b>Fehler in Piwigos Kontentabelle - Duplikate gefunden:</b> ';
$lang['Advise_PWG_Dup'] = '<b>WARNUNG! Sie müssen diese Änderungen in Piwigo vornehmen bevor sie fortfahren<br>Benutzen Sie Piwigos Benutzerverwaltung, um das Problem zu beheben.</b>';

$lang['Audit_PhpBB_Dup'] = '<b>Audit der Kontentabelle von PhpBB</b>';
$lang['Error_PhpBB_Dup'] = '<b>Fehler in PhpBBs Kontentabelle - Duplikate gefunden:</b> ';
$lang['Advise_PhpBB_Dup'] = '<b>WARNUNG! Sie müssen diese Änderungen in PhpBB vornehmen bevor sie fortfahren<br>Benutzen Sie die Icons, um die Benutzerkonten in PhpBB zu löschen und damit das Problem zu beheben.</b>';

$lang['Audit_Link_Break'] = '<b>Audit von reparierbaren Links von Benutzerkonten in Piwigo und PhpBB</b>';
$lang['Error_Link_Break'] = '<b>Fehlerhafter Link von Benutzerkonten in Piwigo und PhpBB:</b> ';
$lang['New_Link'] = 'Verbundene Benutzerkonten: ';

$lang['Audit_Link_Bad'] = '<b>Audit von fehlerhaften Links von Benutzerkonten in Piwigo und PhpBB</b>';
$lang['Error_Link_Del'] = '<b>Fehler in der Linktabelle zwischen zwei Benutzerkonten:</b> ';
$lang['Link_Del'] = 'Link löschen: ';
$lang['Error_Link_Dead'] = '<b>Fehler in der Linktabelle, tote Links:</b> ';
$lang['Link_Dead'] = 'Tote Links löschen ';
$lang['Error_Link_Dup'] = '<b>Fehler in der Linktabelle, Duplikate gefunden:</b> ';
$lang['Link_Dup'] = 'Duplikate löschen ';

$lang['Audit_Synchro'] = '<b>Audit der Synchronisierung von Passwörtern und e-mail Adressen von Benutzerkonten in Piwigo und PhpBB</b>';
$lang['Error_Synchro'] = '<b>Fehlerhafte Synchronisierung des Benutzerkontos:</b> ';
$lang['Error_Synchro_Pswd'] = 'mit dem Passwort';
$lang['Error_Synchro_Mail'] = 'mit der e-mail Adresse';
$lang['Audit_Synchro_OK'] = ' <b>: Datensynchronisierung OK</b>';
$lang['Sync_User'] = 'Kontensynchronisierung : ';

$lang['Audit_PWG2PhpBB'] = '<b>Audit von vorhandenen Benutzerkonten in Piwigo und fehlenden Benutzerkonten in PhpBB</b>';
$lang['Error_PWG2PhpBB'] = '<b>In PhpBB nicht vorhandene Piwigo Benutzerkonten:</b> ';
$lang['Add_User'] = 'Benutzerkonto in PhpBB hinzufügen: ';

$lang['Audit_PhpBB2PWG'] = '<b>Audit von vorhandenen Benutzerkonten in PhpBB und fehlenden Benutzerkonten in Piwigo</b>';
$lang['Error_PhpBB2PWG'] = '<b>In Piwigo nicht vorhandene PhpBB Benutzerkonten:</b> ';
$lang['Del_User'] = 'Benutzerkonto in PhpBB löschen: ';

$lang['Audit_OK'] = 'Audit OK<br><br>';

$lang['Mig_Btn'] = 'Migration';
$lang['Mig_Title'] = 'Migration von Benutzerkonten von Piwigo nach PhpBB';
$lang['Mig_Text'] = '
  <div class="warning"> NUR BENUTZEN wenn Sie diesen Plugin noch nie benutzt haben, um Piwigo mit PhpBB zu verbinden <u>UND</u> wenn es in Ihrem Forum keine Benutzerkonten gibt !!!</b></div><br>
  		--> In diesem Fall dürfen in der Tabelle [PrefixPhpBB]_user von PhpBB keine Benutzerkonten außer Gast und Administrator vorhanden sein.<br><br>
  - Die Migration wird als Erstes alle Links zwischen Benutzerkonten in Piwigo und PhpBB entfernen.<br>
  - Dann <b>WERDEN ALL PhpBB BENUTZERKONTEN GELÖSCHT</b> (mit Ausnahme der Konten Gast und Administrator, sowie Such-Roboter).<br>
  <br>
  <div class="warning">WARNUNG SOLLTEN SIE SPEZIELLE BENUTZERKONTEN IN PhpBB HABEN == BENUTZEN SIE AUF KEINEN FALL DIESE FUNKTION !!!</div><br>
  - Abschließend werden alle Piwigo Benutzerkonten bis auf Gast in PhpBB angelegt.<br>
  <br>
  Sollten Fehler auftreten müssen Sie die Ursachen beheben und die Migration erneut starten.<br>';
$lang['Mig_Disclaimer'] = '<div class="warning"> FÜHREN SIE NIEMALS EINE MIGRATION ALS UPDATE DURCH !!!</div>';
$lang['Mig_Start'] = '<b>Migration von Benutzerkonten von Piwigo nach PhpBB</b>';
$lang['Mig_Del_Link'] = '<b>Links zwischen Benutzerkonten von Piwigo und PhpBB löschen</b>';
$lang['Mig_Del_AllUsers'] = '<b>PhpBB Benutzerkonten löschen</b>';
$lang['Mig_Del_User'] = '<b>Benutzerkonto löschen:</b> ';
$lang['Mig_Add_AllUsers'] = '<b>Benutzerkonten von Piwigo werden übertragen</b>';
$lang['Mig_Add_User'] = '<b>Übertragenes Benutzerkonto:</b> ';
$lang['Mig_End'] = '<b>Migration abgeschlossen !</b>';
$lang['Title_Tab'] = 'Register_PhpBB - Version: ';

// --------- Starting below: New or revised $lang ---- from version 2.3.0
/*TODO*/$lang['No_Reg_advise'] = '
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
/*TODO*/$lang['About_Reg'] = 'About the registration of users on the forum PhpBB';
/*TODO*/$lang['Bridge_UAM'] = 'Access validation to the forum via UserAdvManager (UAM) plugin: Turn the bridge on between the two plugins that will allow you to prohibit the access to your PhpBB forum until the user has not validated its registration in the gallery (the function must be active on UAM).';
/*TODO*/$lang['Bridge_UAM_true'] = ' --> Enable bridge Register_PhpBB / UAM';
/*TODO*/$lang['Bridge_UAM_false'] = ' --> Disable bridge Register_PhpBB / UAM (default)';
/*TODO*/$lang['PhpBB_Group'] = 'Specify the name of <b>PhpBB\' group</b> in which validated users must be (to be created in advance in PhpBB). By default, type "REGISTERED" (registered users). For more information, see end of this page.';
/*TODO*/$lang['About_Bridge'] = 'About Register_PhpBB / UAM bridge';
/*TODO*/$lang['UAM_Bridge_advice'] = 'The UserAdvManager plugin allows forcing new registrants to confirm their registration before allowing them to access the entire gallery. The joint use of this plugin with Register_PhpBB can do the same on the forum linked: Registrants can not post until they have validated their registration in the gallery. <br>
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
/*TODO*/$lang['Admin'] = 'Piwigo\'s administrator username. <b style="color: red">The username of PhpBB\'s administrator account has to be the same!</b>';
/*TODO*/$lang['error_config_admin1'] = 'ERROR : Piwigo\'s admin username is wrong!';
/*TODO*/$lang['error_config_admin2'] = 'ERROR : The name of the PhpBB\'s administrator account is different from that of Piwigo ! Check the configuration of your PhpBB forum and rename the administrator account in the same name as that of Piwigo.';
/*TODO*/$lang['error_config_guest'] = 'ERROR : The name of the PhpBB\'s guest account is wrong!';
// --------- End: New or revised $lang ---- from version 2.3.3
?>