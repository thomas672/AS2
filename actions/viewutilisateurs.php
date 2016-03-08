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

//On recherche les rangs
$rangs = $db->query("
    SELECT * FROM rang
    ORDER BY idrang ASC
")->fetchAll();

//S'il n'y a aucun modules d'inseré
if(empty($rangs)){
    echo "<tr>
            <td></td>
            <td>/</td>
            <td class='centeredTd'><p style=\"color: darkred\">Erreur avec les rangs.</p></td>
            <td>/</td>
        </tr>";
}

//on parcours les rangs
foreach($rangs AS $rang){
    //On affiche la ligne pour indiqué le rang
    echo "<tr>
            <td class='centeredTd checkbox'><strong>$rang->nomrang</strong></td>
            <td><hr></td>
            <td><hr></td>
            <td class='centeredTd' colspan=\"2\">$rang->idrang</td>
        </tr>";
    //On charge les utilisateurs du rang en question
    $users = $db->query("
        SELECT * FROM utilisateurs
        WHERE rang_idrang = $rang->idrang
        ORDER BY nomutilisateurs ASC
    ")->fetchAll();

    if(empty($users)){
        echo "<tr>
            <td></td>
            <td>/</td>
            <td class='centeredTd'><p style=\"color: darkred\">Pas d'utilisateurs.</p></td>
            <td>/</td>
        </tr>";
    }

    //on affiches les utilisateurs
    foreach($users as $user){
        echo "<tr>
            <td class='centeredTd'>$user->idutilisateurs</td>
            <td>$user->nomutilisateurs</td>
            <td>$user->emailutilisateurs</td>
            <td class='centeredTd'><a href='utilisateurs?idDELL=$user->idutilisateurs' alt='Supprimer l\'utilisateur' class='text-color-thirdly'><i class=\"fa fa-user-times fa-2x\"></i></a></td>
            <td class='centeredTd'><a href='' alt='Modifier l\'utilisateur' class='text-color-thirdly'><i class=\"fa fa-wrench fa-2x\"></i></a></td>
        </tr>";
    }
}


//ON supprime en cas de demande de supression
if($_GET && isset($_GET['idDELL'])){
    $idUserDell = $_GET['idDELL'];
    $modules = $db->delete("DELETE FROM utilisateurs WHERE idutilisateurs = $idUserDell");
    header('Location: utilisateurs');
}