<?php
$lang['Tab_Info'] = 'Instructions';
$lang['Tab_Manage'] = 'Etape 1 : Configuration du plugin';
$lang['Tab_Migration'] = 'Etape 2 : Migration des comptes';
$lang['Tab_Synchro'] = 'Maintenance : Resynchronisation des comptes';

$lang['Title'] = 'Register PhpBB';
$lang['Disclaimer'] = '
  *** Pour débuter, 2 étapes à suivre ***<br>
  1ère étape : Configurer les paramètres du plugin avec les paramètres de PhpBB.<br>
  2ème étape : Migrer les comptes utilisateurs de Piwigo vers PhpBB.<br><br>
  A l\'issue des 2 étapes principales, le plugin sera pleinement fonctionnel et vous n\'aurez plus à revenir sur cette page.<br><br>
  *** Pour maintenir les liaisons déjà actives ***<br>
  Maintenance : Synchroniser les tables (dans le cas où un ajout, une mise à jour ou une suppression d\'utilisateur s\'est mal déroulée) permet de remettre à jour mots de passe et adresses email et voir les utilisateurs intrus (Mais vous ne devriez pas avoir à l\'utiliser).<br><br>
  <div class="warning">Pensez faire une sauvegarde de votre base et spécialement de vos tables ###_USERS avant toutes actions par mesure de sécurité.</div>';

$lang['Config_Title'] = 'Configuration du plugin';
$lang['Config_Disclaimer'] = '
  Vérifiez les paramètres relatifs à votre installation de PhpBB et corrigez les au besoin.<br>
  Modifiez, le cas échéant, le comportement du plugin à votre convenance.';
$lang['Prefix'] = 'Préfixe des tables de PhpBB :';
$lang['Guest'] = 'Nom d\'utilisateur de l\'invité de PhpBB (Si vous ne savez pas, laissez tel quel).';
$lang['Details'] = 'Niveau de détails dans les rapports d\'opérations.';
$lang['Details_true'] = ' --&gt; Afficher tous les détails des résultats sur les opérations.';
$lang['Details_false'] = ' --&gt; N\'affiche que l\'essentiel des résultats sur les opérations';
$lang['Del_Pt'] = 'Suppression des topics et posts de l\'utilisateur lorsqu\'il est supprimé.';
$lang['Del_Pt_true'] = ' --&gt; Supprime tout';
$lang['Del_Pt_false'] = ' --&gt; Ne supprime pas les posts et les topics';
$lang['Confirm'] = 'Suppression des confirmations sur les actions d\'administration dans l\'audit.';
$lang['Confirm_true'] = ' --&gt; Supprime les confirmations';
$lang['Confirm_false'] = ' --&gt; Confirmation obligatoire avant action dans l\'audit';

$lang['save_config'] ='Configuration enregistrée.';

$lang['Audit_Btn'] = 'Audit';
$lang['Sync_Btn'] = 'Synchronisation';
$lang['Sync_Title'] = 'Synchronisation des comptes Piwigo vers PhpBB';
$lang['Sync_Text'] = '
  <div class="warning">Vous avez déjà utilisé le plugin pour lier votre Piwigo (mise à jour du plugin) et/ou votre forum PhpBB n\'est pas vide d\'utilisateurs !!!</div><br>
  <br> -> Ceci signifie que votre forum posséde des utilisateurs.<br><br>
  - La synchronisation détectera les données présentes en comparant les noms des utilisateurs, leur mot de passe (crypté) et leur adresse email dans les deux tables [PrefixPWG]_users et [PrefixPhpBB]_users.<br>
  - Puis mettra à jour cette table de correspondance ainsi que le mot de passe et l\'adresse email de chaque compte depuis Piwigo vers PhpBB sauf Piwigo Guest et PhpBB Anonymous.<br>
  - Enfin indiquera en erreur les comptes orphelins qui n\'existent que dans l\'une des 2 tables ###_USERS.<br>
  <br>
  A l\'issue de l\'opération lancez un AUDIT et veuillez vérifier la présence de doublons éventuels dans les utilisateurs de PhpBB, si c\'est le cas, il faut supprimer les plus anciens (tri des utilisateurs PhpBB selon leur date d\'incription).<br>';
$lang['Sync_Check_Dup'] = '<b>Analyse des tables des comptes utilisateurs de Piwigo et PhpBB pour contrôler les doublons</b>';
$lang['Advise_Check_Dup'] = '<b>IMPOSSIBLE de continuer la synchronisation si vous avez des doublons dans les comptes utilisateurs de Piwigo ou PhpBB.</b><br><br>';
$lang['Sync_Link_Break'] = '<b>Analyse des liens réparables entre les comptes Piwigo et PhpBB</b>';
$lang['Sync_Link_Bad'] = '<b>Analyse des mauvais liens entre les comptes Piwigo et PhpBB</b>';
$lang['Sync_DataUser'] = '<b>Analyse des mots de passe et des adresses emails entre les comptes Piwigo et PhpBB</b>';
$lang['Sync_PWG2PhpBB'] = '<b>Analyse des comptes existants dans Piwigo et manquants dans PhpBB</b>';
$lang['Sync_PhpBB2PWG'] = '<b>Analyse des comptes existants dans PhpBB et manquants dans Piwigo</b>';
$lang['Sync_OK'] = 'Synchronisation OK<br><br>';

$lang['Audit_PWG_Dup'] = '<b>Audit de la table des comptes de Piwigo</b>';
$lang['Error_PWG_Dup'] = '<b>Erreur dans la table des comptes Piwigo, il y a des doublons :</b> ';
$lang['Advise_PWG_Dup'] = '<b>ATTENTION ! Vous devez faire ces corrections dans Piwigo avant de continuer<br>utilisez le gestionnaires d\'utilisateurs de Piwigo pour régler le problème.</b>';

$lang['Audit_PhpBB_Dup'] = '<b>Audit de la table des comptes PhpBB</b>';
$lang['Error_PhpBB_Dup'] = '<b>Erreur dans la table des comptes PhpBB, il y a des doublons :</b> ';
$lang['Advise_PhpBB_Dup'] = '<b>ATTENTION Vous devez faire ces corrections dans PhpBB avant de continuer<br>utilisez les icones pour supprimer les utilisateurs de PhpBB et régler le problème.</b>';

$lang['Audit_Link_Break'] = '<b>Audit des liens réparables entre les comptes Piwigo et PhpBB</b>';
$lang['Error_Link_Break'] = '<b>Lien brisé entre les comptes Piwigo et PhpBB :</b> ';
$lang['New_Link'] = 'Liaison du compte : ';

$lang['Audit_Link_Bad'] = '<b>Audit des mauvais liens entre les comptes Piwigo et PhpBB</b>';
$lang['Error_Link_Del'] = '<b>Erreur dans la table de lien entre les 2 utilisateurs :</b> ';
$lang['Link_Del'] = 'Suppression du lien : ';
$lang['Error_Link_Dead'] = '<b>Erreur dans la table de lien, des liens morts existent :</b> ';
$lang['Link_Dead'] = 'Suppression du liens morts ';
$lang['Error_Link_Dup'] = '<b>Erreur dans la table de lien, il y a des doublons :</b> ';
$lang['Link_Dup'] = 'Suppression des liens dupliqués ';

$lang['Audit_Synchro'] = '<b>Audit de la synchronisation des mots de passe et des adresses emails entre les comptes Piwigo et PhpBB</b>';
$lang['Error_Synchro'] = '<b>Mauvaise synchronisation du compte :</b> ';
$lang['Error_Synchro_Pswd'] = 'pour le mot de passe';
$lang['Error_Synchro_Mail'] = 'pour l\'adresse email';
$lang['Audit_Synchro_OK'] = ' <b>: Synchro des données OK</b>';
$lang['Sync_User'] = 'Synchronisation du compte : ';

$lang['Audit_PWG2PhpBB'] = '<b>Audit des comptes existants dans Piwigo et manquants dans PhpBB</b>';
$lang['Error_PWG2PhpBB'] = '<b>Le compte Piwigo n\'existe pas dans PhpBB :</b> ';
$lang['Add_User'] = 'Ajout dans PhpBB du compte : ';

$lang['Audit_PhpBB2PWG'] = '<b>Audit des comptes existants dans PhpBB et manquants dans Piwigo</b>';
$lang['Error_PhpBB2PWG'] = '<b>Le compte PhpBB n\'existe pas dans Piwigo :</b> ';
$lang['Del_User'] = 'Suppression de PhpBB du compte : ';

$lang['Audit_OK'] = 'Audit OK<br><br>';

$lang['Mig_Btn'] = 'Migration';
$lang['Mig_Title'] = 'Migration des comptes de Piwigo vers PhpBB';
$lang['Mig_Text'] = '
  <div class="warning"> A N\'UTILISER QUE SI vous n\'avez jamais utilisé le plugin pour lier Piwigo à PhpBB <u>ET SI</u> votre forum est vide d\'utilisateurs !!!</div><br>
  		--> Dans ce cas, votre table [PrefixPhpBB]_users de PhpBB doit être vide de tout compte sauf les 2 comptes d\'invité et d\'administrateur.<br><br>
  - La migration va d\'abord supprimer les liens des comptes entre Piwigo et PhpBB.<br>
  - Puis <b>SUPPRIMERA TOUS LES COMPTES PhpBB</b> sauf les 2 comptes d\'invité et d\'administrateur, ainsi que ceux des robots de recherche.<br>
  <br>
  <div class="warning">ATTENTION SI VOUS AVEZ DES COMPTES PARTICULIERS DANS PhpBB == NE SURTOUT PAS UTILISER CETTE FONCTION !!!</div><br>
  - Enfin la migration va créer tout les comptes de Piwigo dans PhpBB sauf l\'invité.<br>
  <br>
  Si des erreurs se produisent pendant l\'opération, corrigez la cause du problème et recommencez l\'opération de migration (à ce moment là seulement vous pouvez renouveller la migration).<br>';
$lang['Mig_Disclaimer'] = '<div class="warning"> NE JAMAIS EFFECTUER DE MIGRATION POUR METTRE A JOUR !!!</div>';
$lang['Mig_Start'] = '<b>Migration des comptes Piwigo vers PhpBB</b>';
$lang['Mig_Del_Link'] = '<b>Suppression des liens entre les comptes Piwigo et PhpBB</b>';
$lang['Mig_Del_AllUsers'] = '<b>Suppression des comptes PhpBB</b>';
$lang['Mig_Del_User'] = '<b>Suppression du compte :</b> ';
$lang['Mig_Add_AllUsers'] = '<b>Transfert des comptes Piwigo</b>';
$lang['Mig_Add_User'] = '<b>Transfert du compte :</b> ';
$lang['Mig_End'] = '<b>Migration finie !</b>';
$lang['Title_Tab'] = 'Register_PhpBB - Version: ';


// --------- Starting below: New or revised $lang ---- from version 2.3.0
$lang['No_Reg_advise'] = '
  Pour une meilleur intégration, il est conseillé d\'apporter les modifications suivantes à votre forum PhpBB (<b>Attention! Ces modifications disparaitront en cas de mise à jour du forum</b>):
<br><br>
  <b>* Modifier le fichier</b> : [RacineDePhpBB]/ucp.php en cherchant la ligne suivante :
  <div class="mod">case \'sendpassword\':</div>
  <b>et remplacez les 2 lignes qui suivent (jusqu\'à break) par :</b>
  <div class="info">redirect(\'http://[VotreracinedePiwigo]/password.php\', false, true);</div>
  <br><br>
  <b>* De même juste en dessous</b> : Cherchez la ligne suivante :
  <div class="mod">case \'register\':</div>
  <b>et remplacez les 7 lignes qui suivent (jusqu\'à break) par :</b>
  <div class="info">redirect(\'http://[VotreracinedePiwigo]/register.php\', false, true);</div>
  <br><br>
  <b>* Dans le panneau de configuration</b> : allez dans les permissions des groupes et changez la ligne "Peut modifier son mot de passe" à <b>Non</b>.
  <br>';
$lang['About_Reg'] = 'A propos de l\'enregistrement d\'utilisateur sur le forum PhpBB';
$lang['Bridge_UAM'] = 'Validation d\'accès au forum via le plugin UserAdvManager (UAM): Activez ici le pont entre les deux plugins qui vous permettra d\'interdir l\'accès à votre forum PhpBB tant que l\'utilisateur n\'a pas validé son inscription à la galerie (la fonction correspondante doit être active sur UAM).';
$lang['Bridge_UAM_true'] = ' --> Pont Register_PhpBB / UAM activé';
$lang['Bridge_UAM_false'] = ' --> Pont Register_PhpBB / UAM désactivé (par défaut)';
$lang['PhpBB_Group'] = 'Précisez ici le nom du <b>groupe PhpBB</b> dans lequel les utilisateurs validés doivent se trouver (à créer au préalable dans PhpBB). Par défaut rentrez "REGISTERED" (Utilisateurs enregistrés). Pour plus d\'infos, voir à la fin de cette page.';
$lang['About_Bridge'] = 'A propos du pont Register_PhpBB / UAM';
$lang['UAM_Bridge_advice'] = 'Le plugin UserAdvManager permet de forcer les nouveaux inscrits à valider leur inscription avant de leur permettre d\'accéder à la totalité de la galerie. L\'utilisation conjointe de ce plugin avec Register_PhpBB permet de faire de même sur le forum lié: Ils ne pourront pas poster tant qu\'ils n\'auront pas validé leur inscription à la galerie.<br>
Voici la procédure générale à appliquer:
<br><br>
- Plusieurs groupes sont créés par défaut lors de la création de votre forum. Deux d\'entre eux se nomment "Nouveaux utilisateurs enregistrés" et "Utilisateurs enregistrés". Le premier groupe dispose d\'autorisations très limitées qui sont ajustables dans le panneau de configuration. C\'est dans ce groupe que les utilisateurs non validés sont envoyés dans le cas où le pont est actif. Dans le cas contraire, les utilisateurs sont assignés par défaut au second groupe, qui dispose de droits beaucoup plus larges, modifiables également.<br>
- Vous pouvez choisir de créer un nouveau groupe pour vos utilisateurs validés, ou bien vous contenter de celui "Utilisateurs enregistrés" et en modifier certains paramètres.<br>
- Il vous suffit ensuite de rentrer ci-dessus le nom de groupe choisi pour les utilisateurs validés : "REGISTERED" si vous gardez celui créé au début ou "Membres" ou "VIP"... si vous avez créé votre propre groupe. La syntaxe doit être identique à celle rentrée dans PhpBB lors de la création du groupe (majuscules, minuscules...).<br>
<br><br>
<b class="mod"><u>Notes importantes:</u></b>
<br><br>
Si vous n\'avez jamais utilisé Register_PhpBB, la phase de migration des comptes de votre galerie Piwigo vers votre forum PhpBB ne tiendra pas compte de l\'état validé ou non de vos inscrits au moment du lancement de la phase de migration.';
// --------- End: New or revised $lang ---- from version 2.3.0

// --------- Starting below: New or revised $lang ---- from version 2.3.3
$lang['Admin'] = 'Nom d\'utilisateur de l\'administrateur de Piwigo. <b style="color: red">Le nom de l\'administrateur de PhpBB doit être identique !</b>';
$lang['error_config_admin1'] = 'ERREUR : Le nom du compte administrateur de Piwigo est incorrect !';
$lang['error_config_admin2'] = 'ERREUR : Le nom du compte administrateur de PhpBB est différent de celui de Piwigo ! Vérifiez la configuration de votre forum PhpBB et nommez le compte administrateur de la même manière que celui de Piwigo.';
$lang['error_config_guest'] = 'ERREUR : Le nom du compte visiteur (guest) de PhpBB est incorrect !';
// --------- End: New or revised $lang ---- from version 2.3.3
?>