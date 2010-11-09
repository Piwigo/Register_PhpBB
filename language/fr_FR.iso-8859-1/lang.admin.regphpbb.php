<?php
// +-----------------------------------------------------------------------+
// | PhpWebGallery - a PHP based picture gallery                           |
// | Copyright (C) 2002-2003 Pierrick LE GALL - pierrick@phpwebgallery.net |
// | Copyright (C) 2003-2007 PhpWebGallery Team - http://phpwebgallery.net |
// +-----------------------------------------------------------------------+
//$lang_info['language_name'] = 'Français';
//$lang_info['country'] = 'France';
//$lang_info['charset'] = 'iso-8859-1';
//$lang_info['direction'] = 'ltr';
//$lang_info['code'] = 'fr';
global $lang;
$lang['Title'] = 'Register PhpBB';
$lang['Howto'] = 'Ce plugin permet d\'enregistrer automatiquement un utilisateur, s\'inscrivant sur PWG, dans un forum PhpBB. Il est basé sur le Mod Register_PhpBB réalisé par Flipflip que je remercie, ici, d\'avoir initialisé le projet. Remerciement spécial à Rub (PWG Team) pour son aide précieuse.';
$lang['Install_Disclaimer']='Attention ! Après l\'activation complète de ce plugin, toutes les manipulations d\'administration des utilisateurs (ajout manuel, suppression, modification) des deux scripts (PWG et PhpBB) devront être réalisées à travers l\'interface d\'administration de PWG. Il est conseillé de désactiver l\'inscription de PhpBB mais ce n\'est pas obligatoire. Les deux scripts peuvent continuer à fonctionner indépendemment mais les utilisateurs s\'inscivant sur le forum n\'auront pas de compte valide pour accéder à votre galerie. Au contraire, un utilisateur qui s\'inscrit sur la galerie devient automatiquement membre du forum... C\'est le but avoué de ce plugin ;-)';
$lang['Update']='Procédure pour mise à jour';
$lang['Update_Disclaimer']='<u>Uniquement pour ceux qui utilisaient la version Mod de ce plugin</u>, voici les étapes pour mettre à jour :<br/><ol><li>Supprimez tout le code ajouté au source de PWG (se reporter au fichier d\'install accompagnant le Mod) afin de revenir à une situation avant application du Mod.</li><li>Supprimez la table PLUGIN_REGISTER_PHPBB_ID_USER de la base de donnée. Cette table est créée par l\'installation du plugin, doit être vide et ne sera pas utilisée.</li><li>Renommez la table MOD_REGISTER_PHPBB_ID_USER en PLUGIN_REGISTER_PHPBB_ID_USER</li><li>Vérifiez, corrigez et activez les paramètres de comportement du plugin => <u>Rendez vous à l\'étape 1 - NE FAITES PAS LA MIGRATION DE l\'ETAPE 2 !</u></li><li>La resynchronisation est optionnelle. Elle remettra à plat la table de correspondance.</li></ol>';
$lang['Install_Disclaimer2']='Dans un premier temps, il faut configurer les paramètres de fonctionnement du plugin vis à vis de PhpBB puis copier les comptes utilisateurs présents dans PWG vers PhpBB. Une troisième fonction est disponible afin de resynchroniser les tables dans le cas où un ajout ou une suppression d\'utilisateur s\'est mal déroulée. Mais vous ne devriez pas avoir à l\'utiliser.<br/><br/>A l\'issue des 2 étapes principales, le plugin sera pleinement fonctionnel et vous n\'aurez plus à revenir sur cette page.';
$lang['Step1_Title'] = 'Etape 1 : Configuration du plugin';
$lang['Step1_Disclaimer'] = 'Vérifiez les paramètres relatifs à votre installation de PhpBB et corrigez les au besoin. Modifiez, le cas échéant, le comportement du plugin à votre convenance. Enfin, n\'oubliez pas de passer l\'activation du plugin à 1 avant d\'enregistrer vos paramètres !';
$lang['PluginActivation']='Activer ou Désactiver l\'enregistrement dans PhpBB<br/>
0 --&gt; Désactivé (pas d\'ajout automatique des utilisateurs dans PhpBB)<br/>
1 --&gt; Activé<br/>';
$lang['Phpbb_Prefix']='Préfixe des tables de PhpBB :';
$lang['Phpbb_Admin']='Nom d\'utilisateur de l\'administrateur de PWG. <b><u>Doit être identique à celui de PhpBB</u></b> :';
$lang['Phpbb_Timezone']='Zone de temps (de -12 à 14) :';
$lang['Phpbb_Language']='Langue (French, English) :';
$lang['Phpbb_Style']='Id du style du forum (1 par défaut) :';
$lang['Phpbb_Del_Pt']='Suppression des topics et posts de l\'utilisateur lorsqu\'il est supprimé.<br/>
0 --&gt; Supprimer tout<br/>
1 --&gt; Ne supprime pas les posts et les topics<br/>';
$lang['Step2_Btn']='Migration';
$lang['Step2_Title']='Etape 2 : Migration des comptes PWG vers PhpBB / Resynchronisation des comptes';
$lang['Step2_Text']='Deux cas de figure se présentent ici : <br/><br/><u>1) Vous n\'avez jamais utilisé le Mod Register_PhpBB et encore moins le plugin du même nom</u> -> Dans ce cas, votre table #_users de PhpBB doit être vide de tout compte. Vous pouvez alors cliquez <b>UNE FOIS</b> sur le bouton "Migration". Si des erreurs se produisent pendant l\'opération, videz les tables [PhpBB]_users et [PWG]_plugin_register_PhpBB_id_user (via PhpMyAdmin par exemple), corrigez la cause du problème et recommencez l\'opération de migration (à ce moment là seulement vous pouvez recliquer sur le bouton "Migration").';
$lang['Step22_Text']='<b>NE JAMAIS EFFECTUER CETTE OPERATION PLUS D\'UNE FOIS DE SUITE</b> !';
$lang['Step3_Btn']='Resynch';
$lang['Step3_Text']='<u>2) Vous avez déjà utilisé le Mod / plugin (mise à jour d\'une version précédentes de PWG vers l\'actuelle)</u> -> Ceci signifie que vous disposez déjà d\'une table de correspondance des Id entre PWG et PhpBB. Le script de re synchronisation détectera les données présentes en comparant les noms des utilisateurs et leur adresse email dans les deux tables #_users (PWG et PhpBB) et mettra à jour cette table de correspondance. A l\'issue de l\'opération, veuillez vérifier la présence de doublons éventuels dans les utilisateurs de PhpBB. Si cela est le cas, il faut supprimer les plus anciens (tri des utilisateurs PhpBB selon leur date d\'incription).<br/><br/>';
?>
