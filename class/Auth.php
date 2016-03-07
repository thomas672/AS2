<?php
/**
 * Created by PhpStorm.
 * User: kieff
 * Date: 02/03/2016
 * Time: 21:13
 */
class Auth{

    static function loggedOnly(){
        if(session_status() == PHP_SESSION_NONE){
            //On lance session start pour stocké des variables de session
            session_start();
        }
        if(!isset($_SESSION['auth'])){
            header('Location: index');
            exit();
        }
    }
}