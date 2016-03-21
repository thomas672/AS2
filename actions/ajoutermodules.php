<?php
/**
 * Created by PhpStorm.
 * User: kieff
 * Date: 02/03/2016
 * Time: 21:31
 */

$userId = $_SESSION['auth']->idutilisateurs;
$userRang = $_SESSION['auth']->rang_idrang;
if(!empty($_GET['code']) AND !empty($_GET['nom'])) {
    $codemodule = $_GET['code'];
    $nommodule = $_GET['nom'];
    $modules = $db->query("
        SELECT * FROM modules
        LEFT JOIN departements ON iddepartements = ue_formations_departements_iddepartements
        WHERE codemodules LIKE '%$codemodule%' AND
              nommodules LIKE '%$nommodule%'
    ")->fetchAll();
}
else if(!empty($_GET['nom'])) {
    $nommodule = $_GET['nom'];
    $modules = $db->query("
        SELECT * FROM modules
        LEFT JOIN departements ON iddepartements = ue_formations_departements_iddepartements
        WHERE nommodules LIKE '%$nommodule%'
    ")->fetchAll();
}
else if(!empty($_GET['code'])){
    $codemodule = $_GET['code'];
    $modules = $db->query("
        SELECT * FROM modules
        LEFT JOIN departements ON iddepartements = ue_formations_departements_iddepartements
        WHERE codemodules LIKE '%$codemodule%'
    ")->fetchAll();
}
else if(!empty($_GET['ue']) AND !empty($_GET['dpt'])){
    $departement = intval($_GET['dpt']);
    $ue = intval($_GET['ue']);
    $codemodule = $_GET['code'];
    $nommodule = $_GET['nom'];
    $modules = $db->query("
    SELECT * FROM modules
    LEFT JOIN departements ON iddepartements = ue_formations_departements_iddepartements
    WHERE ue_formations_departements_iddepartements LIKE '%$departement%' AND
          ue_idue LIKE '%$ue%' AND
          codemodules LIKE '%$codemodule%' AND
          nommodules LIKE '%$nommodule%'
")->fetchAll();
}
else{
    $modules = $db->query("
      SELECT * FROM modules
      LEFT JOIN departements ON iddepartements = ue_formations_departements_iddepartements
    ")->fetchAll();
}


//S'il n'y a aucun modules d'inseré
if(empty($modules)){
    echo "<tr>
            <td></td>
            <td>/</td>
            <td class='centeredTd'><p style=\"color: darkred\">Il n'y a aucun module.</p></td>
            <td>/</td>
        </tr>";
}

//on affiches les TD des modules
foreach($modules as $module){
        echo "<tr>
            <td class='centeredTd checkbox'><input type='checkbox' name='idMod[]' value='$module->idmodules'></td>
            <td>$module->codemodules</td>
            <td>$module->nommodules</td>
            <td>$module->nomdepartements</td>
        </tr>";
}

//ON supprime en cas de demande de supression
if($_POST && isset($_POST['idMod'])){
    foreach($_POST['idMod'] AS $k){
        $modulesInfo = $db->query("
          SELECT * FROM modules WHERE idmodules = $k
        ")->fetch();

        $modulemultipl = $db->query("SELECT COUNT(*) AS nbr FROM `modules_has_utilisateurs` WHERE `utilisateurs_idutilisateurs` = $userId AND `modules_idmodules` = $modulesInfo->idmodules")->fetch();

        if($modulemultipl->nbr == 0){
            $addmodule = $db->insert("
                INSERT INTO modules_has_utilisateurs (modules_idmodules, modules_ue_idue, modules_ue_formations_idformations, modules_ue_formations_departements_iddepartements, utilisateurs_idutilisateurs, utilisateurs_rang_idrang)
                VALUES ($modulesInfo->idmodules, $modulesInfo->ue_idue, $modulesInfo->ue_formations_idformations, $modulesInfo->ue_formations_departements_iddepartements, $userId, $userRang)
            ");
        }
    }
    header('Location: mesmodules');
}