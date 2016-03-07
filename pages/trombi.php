<div class="content">
    <?php
        require 'inc/bootstrap.php';



        $db = App::getDatabase();
        $formations = $db->query("SELECT * FROM `formations`")->fetchAll();
        $groupes = $db->query("SELECT * FROM `groupes`")->fetchAll();
        if(!empty($_GET) AND !empty($_GET['id']) AND !empty($_GET['idforma'])){
            $idGroupe = intval($_GET['id']);
            $idForma = intval($_GET['idforma']);
            $etudiants = $db->query("
                SELECT * FROM `etudiants`, `groupes`, `etudiants_has_groupes` WHERE `groupes_idgroupes` = $idGroupe AND `idgroupes` = $idGroupe AND `formations_idformations` = $idForma AND `etudiants_idetudiants` = `idetudiants`
                ORDER BY etudiants.nometudiants ASC
            ")->fetchAll();
        }else{
            $etudiants = $db->query('
                SELECT *
                FROM etudiants_has_groupes AS groupeEtu
                LEFT JOIN formations ON formations.idformations = groupeEtu.etudiants_formations_idformations
                LEFT JOIN groupes ON groupes.idgroupes = groupeEtu.groupes_idgroupes
                LEFT JOIN etudiants ON etudiants.idetudiants = groupeEtu.etudiants_idetudiants
                ORDER BY formations.idformations, groupes.idgroupes, etudiants.nometudiants ASC
            ')->fetchAll();
        }

        $nomFormation = NULL;
        $nomGroupe = NULL;
        ?>
        <div>
            <form action="trombi" method="get">
                <label for="id">Groupe etudiants :</label>
                <select name="id" id="id">
                    <?php
                    foreach($groupes as $groupe){
                        ?>
                        <option value="<?= $groupe->idgroupes ?>"><?= $groupe->nomgroupes ?></option>
                        <?php
                    }
                    ?>
                </select>
                <br>
                <label for="idforma">Formation etudiants :</label>
                <select name="idforma" id="idforma">
                    <?php
                    foreach($formations as $formation){
                        ?>
                        <option value="<?= $formation->idformations ?>"><?= $formation->nomformations ?></option>
                        <?php
                    }
                    ?>
                </select>
                <input type="submit" value="Rechercher">
            </form>
        </div>
        <?php

        if(!empty($_GET) AND !empty($_GET['id']) AND !empty($_GET['idforma'])){
            foreach($etudiants as $etudiant){
                echo "
                <div class='img-trombi text-center'>
                    <img src='etc/trombi/$etudiant->photourletudiants' alt='$etudiant->prenometudiants $etudiant->nometudiants'><br>
                    <div style='margin-bottom: 10px;'>
                        <strong>$etudiant->prenometudiants</strong><br>
                        <small>$etudiant->nometudiants</small>
                    </div>
                </div>
            ";
            }
        }else{
            foreach($etudiants as $etudiant){
                if($nomFormation != $etudiant->nomformations OR $nomGroupe != $etudiant->nomgroupes){
                    echo '<div class="content" style="clear: both; margin: 20px;">';
                    echo '<hr>';
                    echo '<h4>'.$etudiant->nomformations.' | '.$etudiant->nomgroupes.'</h4>';
                    echo '<hr>';
                    echo '</div>';
                }
                $nomFormation = $etudiant->nomformations;
                $nomGroupe = $etudiant->nomgroupes;

                echo "
                <div class='img-trombi text-center'>
                    <img src='etc/trombi/$etudiant->photourletudiants' alt='$etudiant->prenometudiants $etudiant->nometudiants'><br>
                    <div style='margin-bottom: 10px;'>
                        <strong>$etudiant->prenometudiants</strong><br>
                        <small>$etudiant->nometudiants</small>
                    </div>
                </div>
            ";
            }
        }



    ?>
</div>
