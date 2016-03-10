<?php
/**
 * Created by PhpStorm.
 * User: kieff
 * Date: 02/03/2016
 * Time: 21:31
 */

require ('../inc/bootstrap.php');

$db = App::getDatabase();

if(isset($_GET['nom']) OR isset($_GET['prenom']) OR isset($_GET['dossier'])){
    $nom = $_GET['nom'];
    $prenom = $_GET['prenom'];
    $dossier = intval($_GET['dossier']);
    $data = $db->query("SELECT * FROM `etudiants` WHERE idetudiants LIKE '$dossier%' AND (nometudiants LIKE '$nom%' AND prenometudiants LIKE '$prenom%')")->fetchAll();
    echo json_encode($data);

}