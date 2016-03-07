<?php
/**
 * Created by PhpStorm.
 * User: kieff
 * Date: 02/03/2016
 * Time: 21:31
 */

require 'inc/bootstrap.php';
App::needSessionStart();
$db = App::getDatabase();
$userId = $_SESSION['auth']->idutilisateurs;
$modules = $db->query("
  SELECT * FROM modules_has_utilisateurs AS modulesUsr
  LEFT JOIN modules ON modules.idmodules = modulesUsr.modules_idmodules AND modulesUsr.utilisateurs_idutilisateurs = $userId
  LEFT JOIN departements ON ue_formations_departements_iddepartements = departements.iddepartements
")->fetchAll();

//S'il n'y a aucun modules d'inseré
if(empty($modules)){
    echo "<tr>
            <td></td>
            <td>/</td>
            <td class='centeredTd'><p style=\"color: darkred\">Vous n'avez aucun module.</p></td>
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