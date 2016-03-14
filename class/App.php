<?php
/**
 * Created by PhpStorm.
 * User: kieff
 * Date: 02/03/2016
 * Time: 21:13
 */
class App{
    static $db = null;

    //Creation d'un objet static permetant de se connecter à une BDD
    static function getDatabase(){
        self::$db =  new Database('root', '', 'appsense');
        return self::$db;
    }

    //Fonction permetant de lancé session_start() si besoins est
    static function needSessionStart(){
        if(session_status() == PHP_SESSION_NONE){
            //On lance session start pour stocker des variables de session
            session_start();
        }
    }

}