<?php
include 'conn.php';
$tpl="include/template/";
$css="design/css/";
$fun="include/functions/";
$js="design/js/";
$lang="include/langs/";
include $lang."en.php";
include $fun."functions.php";
include $tpl."header.php";

if(!isset($nonav)){

    include $tpl."navbar.php";
    
}
echo "ahmed ";