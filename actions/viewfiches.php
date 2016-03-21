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
$userId = $_SESSION['auth']->idutilisateurs;

//On recup les fiches absences du module choisi par l'utilisateur
if(isset($_GET['idModuleFic'])){

    $moduleId = intval($_GET['idModuleFic']);

    $data = $db->query("SELECT * FROM `absences` WHERE idutilisateurs_utilisateurs = $userId AND `idmodules_absences` = $moduleId ORDER BY dateabsences DESC LIMIT 0,20")->fetchAll();

    echo json_encode($data);

}

//On les info du module choisi par l'utilisateur
if(isset($_GET['idModuleAbs'])){

    $moduleId = intval($_GET['idModuleAbs']);

    $data = $db->query("
        SELECT * FROM `modules`
        LEFT JOIN formations ON `idformations` = `ue_formations_idformations`
        LEFT JOIN departements ON `iddepartements` = `ue_formations_departements_iddepartements`
        WHERE `idmodules` = $moduleId
    ")->fetch();

    echo json_encode($data);

}

if(isset($_GET['idGroupes']) AND isset($_GET['idDepartements']) AND isset($_GET['idFormations'])){

    $groupeId = intval($_GET['idGroupes']);
    $formationId = intval($_GET['idDepartements']);
    $departementId = intval($_GET['idFormations']);

    $data = $db->query("
        SELECT * FROM `etudiants`
        LEFT JOIN `etudiants_has_groupes` ON `idetudiants` = `etudiants_idetudiants`
        WHERE `etudiants_formations_idformations` = $formationId AND `etudiants_formations_departements_iddepartements` = $departementId AND `groupes_idgroupes` = $groupeId
        GROUP BY `idetudiants`
    ")->fetchAll();

    echo json_encode($data);

}

//On modifie l'excuse de l'etudiant depuis la page de la fiche (showfiche)

if(isset($_GET['idEtudiant_excuse']) AND isset($_GET['idAbsence']) AND isset($_GET['valExcuse'])){
    $valeurExcuse = intval($_GET['valExcuse']);
    $idEtu = intval($_GET['idEtudiant_excuse']);
    $idAbs = intval($_GET['idAbsence']);
    $changeExc = $db->update("UPDATE `appsense`.`absences_has_etudiants` SET `excuse` = '$valeurExcuse' WHERE `idetudiants_etudiant` = $idEtu AND `idAbsence_absence` = $idAbs");
    echo json_encode($changeExc);
}