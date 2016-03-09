<?php
/**
 * Created by PhpStorm.
 * User: kieff
 * Date: 02/03/2016
 * Time: 21:31
 */

require 'inc/bootstrap.php';
App::needSessionStart();
if(!empty($_POST) && !empty($_POST['email']) && !empty($_POST['password'])){
    //On crée un tableau pour inseré toutes les erreurs possibles
    $errors = array();
    $email = $_POST['email'];
    $password = $_POST['password'];
    //verification que l'email est correct
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "E-Mail invalide, faute(s) de frappe.";
    }

    //On verifi le mot de passe avec la fonction PASSWORD_VERIFY
    $db = App::getDatabase();
    $emailReq = $db->query('SELECT * FROM utilisateurs WHERE emailutilisateurs = ?', [$email])->fetch();
    if($emailReq == null){
        $errors[] = 'Identifiant ou mot de passe incorrecte';
    }else if(password_verify($password, $emailReq->passwordutilisateurs)){
        //S'il n'y a aucunes erreurs on lance la connexion
        $_SESSION['auth'] = $emailReq;
        $userId = $emailReq->idutilisateurs;
        $userIp = $_SERVER["REMOTE_ADDR"];
        $logAdd = $db->query("INSERT INTO `appsense`.`log_connexion` (`idlog_connexion`, `idutilisateurlog_connexion`, `iplog_connexion`, `datelog_connexion`) VALUES (NULL, '$userId', '$userIp', NOW());");
        header('Location: accueil');
        exit();
    }else{
        $errors[] = "Mot de passe incorrect.";
    }


    if(!empty($errors)){
        echo '<p><ul class="form-error">';
        foreach($errors as $error){
            echo '<li>'.$error.'</li>';
        }
        echo '</ul></p>';
    }
}

if(isset($_SESSION['auth'])){
    header('Location: accueil');
}