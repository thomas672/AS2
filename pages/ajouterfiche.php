<?php
require 'inc/bootstrap.php';
App::needSessionStart();
$db = App::getDatabase();
$userId = $_SESSION['auth']->idutilisateurs;
?>

<?php

if(isset($_POST['changeGroupeAbs'])){
    var_dump($_POST);
}
?>
<div class="content" xmlns="http://www.w3.org/1999/html">
    <h1>Ajouter une fiche d'absence(s) : </h1>
    <p>
        Bonjour, <?= $_SESSION['auth']->nomutilisateurs ?> nous sommes le <?php setlocale(LC_TIME, 'fra_fra'); echo strftime('%d %B %Y');?> il est : <?= date('H:i') ?> !<br>
        Veuillez entrer les informations du cours et cliquer sur les étudiants absents. Toute modification(s) sera possible même après l'enregistrement.
    </p>
    <form action="ajouterfiche2" method="post">
        <div class="input">
            <label for="changeModulesAbsence">Module</label>
            <select name="changeModulesAbsence" id="changeModulesAbsence">
                <option value=""> </option>
                <?php
                $ueSelects = $db->query("
						SELECT * FROM modules_has_utilisateurs
						LEFT JOIN `ue` ON `idue` = `modules_ue_idue`
						WHERE `utilisateurs_idutilisateurs` = $userId
						GROUP BY `nomue` ORDER BY `idue` ASC
					")->fetchAll();

                foreach($ueSelects AS $ueSelect){
                    echo "<optgroup label='$ueSelect->nomue'>";
                    $modules = $db->query("
							SELECT * FROM modules_has_utilisateurs
							LEFT JOIN `modules` ON `idmodules` = `modules_idmodules`
							WHERE `modules_ue_idue` = $ueSelect->idue AND `utilisateurs_idutilisateurs` = $userId
						");

                    foreach($modules AS $module){
                        echo "<option value='$module->idmodules'>$module->nommodules</option>";
                    }

                    echo "</optgroup>";
                }
                ?>
            </select>
        </div>

        <div class="input">
            <label for="duree">Durée</label>
            <select name="duree" id="duree">
                <option value="1">1 heure</option>
                <option value="2" selected>2 heures</option>
                <option value="3">3 heures</option>
                <option value="4">4 heures</option>
            </select>
        </div>


        <div class="hidden" id="hiddenFormDept">
            <div class="input">
                <label for="departement">Departement</label>
                <select name="departement" id="departement" disabled>

                </select>
                <input type="hidden" value="" name="">
            </div>

            <div class="input">
                <label for="formation">Formation</label>
                <select name="formation" id="formation" disabled>

                </select>
            </div>

            <input type="hidden" value="" name="departementId" id="departementId">
            <input type="hidden" value="" name="formationId" id="formationId">
        </div>

        <div class="input">
            <label for="changeGroupeAbs">Groupe</label>
            <select name="changeGroupeAbs" id="changeGroupeAbs" disabled>
                <option value="">Choisir un groupe...</option>
                <?php
                $groupes = $db->query("SELECT * FROM groupes ORDER BY idgroupes ASC")->fetchAll();
                foreach($groupes as $groupe){
                    echo "<option value='$groupe->idgroupes'>$groupe->nomgroupes</option>";
                }
                ?>
            </select>
        </div>

        <div id="trombi" class="trombi">


        </div>

        <div class="hidden" id="hiddenSignature">
            <button type="submit" class="btn"><i class="fa fa-pencil-square-o"></i> SIGNER ET ENREGISTRER</button>
        </div>
    </form>
</div>