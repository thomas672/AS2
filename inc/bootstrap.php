<?php


//Permet de mettre en place un autoload qui charge automatiquement les classes dont on a besoins
spl_autoload_register('app_autoload');
function app_autoload($class){
  if(file_exists('../class/'.$class.'.php')){
    require('../class/'.$class.'.php');
  }
  else{
    require('class/'.$class.'.php');
  }
}