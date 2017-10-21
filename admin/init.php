<?php

     include 'connect.php';
$tpl  = "includes/templates/";
$lang = "includes/languages/";
$func = "includes/functions/";
$css  = "layout/css/";
$js   = "layout/js/";


     include $lang . "english.php";
     include $func . "function.php";
     include $tpl  . "header.php";
     

     if(!isset($noNavBar)){include $tpl.'navbar.php';}

