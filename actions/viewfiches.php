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

    $moduleId = intval($_GET['idModule']);

    $data = $db->query("SELECT * FROM `absences` WHERE utilisateurs_idutilisateurs = $userId AND `modules_has_utilisateurs_modules_idmodules` = $moduleId ORDER BY dateabsences DESC LIMIT 0,20")->fetchAll();

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