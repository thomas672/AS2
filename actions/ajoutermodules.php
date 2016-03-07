<?php
/**
 * Created by PhpStorm.
 * User: kieff
 * Date: 02/03/2016
 * Time: 21:31
 */

$userId = $_SESSION['auth']->idutilisateurs;

if(isset($_GET['code'])){
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
        $modules = $db->delete("DELETE FROM modules_has_utilisateurs WHERE utilisateurs_idutilisateurs = $userId AND modules_idmodules = $k");
    }
}