<?php

//Permet de mettre en place un autoload qui charge automatiquement les classes dont on a besoins
spl_autoload_register('app_autoload');

function app_autoload($class){
  require('class/'.$class.'.php');
}