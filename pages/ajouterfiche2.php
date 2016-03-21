<?php
require 'inc/bootstrap.php';
App::needSessionStart();
$db = App::getDatabase();
//Recup de toutes les données utiles à l'enregistrement de l'absences et des étudiants absents
$userId = $_SESSION['auth']->idutilisateurs;
$groupeId = $_POST['changeGroupeAbs'];
$idModule = $_POST['changeModulesAbsence'];
$idUe = $_POST['changeModulesAbsence'];
$idFormation = $_POST['formationId'];
$idDepartement = $_POST['departementId'];
$duree = $_POST['duree'];
?>

<?php

if(isset($_POST['changeModulesAbsence'])){
    //On ajoute la fiche absence
    $addAbs = $db->insert("INSERT INTO `appsense`.`absences` (`idabsences`,
        `dateabsences`,
        `dureeabsences`,
        `idutilisateurs_utilisateurs`,
        `idmodules_absences`,
        `idue_absences`,
        `idformation_absences`,
        `iddepartement_absences`,
        `idgroupe_absences`)
        VALUES (NULL, CURRENT_TIMESTAMP, '$duree', '$userId', '$idModule', '$idUe', '$idFormation', '$idDepartement', '$groupeId');");

    //On recup le dernier ID pour injecté les eleve absents
    $idABS = $db->lastInsertId();

    foreach($_POST['idEtuAbs'] AS $eleveAbs){
        $addEtu_has_abs = $db->insert("INSERT INTO `appsense`.`absences_has_etudiants` (`id_absences_has_etudiants`, `idAbsence_absence`, `idetudiants_etudiant`, `excuse`) VALUES (NULL, '$idABS', '$eleveAbs', '0')");
    }


}
?>
<div class="content">
    <h1>Ajouter une fiche d'absence(s) : </h1>
    <p>
        Merci, <?= $_SESSION['auth']->nomutilisateurs ?>, votre fiche vient d'être enregister.!<br>
        Vous pouvez modifier cette fiche depuis la rubrique <i>Les fiches</i>.
    </p>
</div>