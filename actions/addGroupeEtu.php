<?php
/**
 * Created by PhpStorm.
 * User: kieff
 * Date: 02/03/2016
 * Time: 21:31
 */

require ('../inc/bootstrap.php');
App::needSessionStart();
$db = App::getDatabase();
//On insert les groupes un par un mais avec AJAX
$dossier = intval($_GET['dossier']);
$dept = intval($_GET['iddepartement']);
$forma = intval($_GET['idformation']);
$groupe = intval($_GET['idgroupe']);

if(isset($_GET['add'])){
    $addGroupe = $db->insert("INSERT INTO `appsense`.`etudiants_has_groupes` (`etudiants_idetudiants`, `etudiants_formations_idformations`, `etudiants_formations_departements_iddepartements`, `groupes_idgroupes`) VALUES ($dossier, $forma, $dept, $groupe);");
}

if(isset($_GET['dell'])){
    $dellGroupe =$db->delete("DELETE FROM `etudiants_has_groupes` WHERE `etudiants_idetudiants` = $dossier AND `etudiants_formations_idformations` = $forma AND `etudiants_formations_departements_iddepartements` = $dept AND `groupes_idgroupes`= $groupe");
}


$data = $db->query("
SELECT * FROM groupes
LEFT JOIN etudiants_has_groupes ON idgroupes = groupes_idgroupes
WHERE etudiants_idetudiants = $dossier")->fetchAll();
echo json_encode($data);