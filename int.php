<?php

ini_set("display_errors","on");
error_reporting(E_ALL);



include 'admin/conn.php';
$sessionuser="";
if(isset($_SESSION['user'])){
    $sessionuser=$_SESSION['user'];
}
$tpl="include/template/";
$css="design/css/";
$fun="include/functions/";
$js="design/js/";
$lang="include/langs/";
include $lang."en.php";
include $fun."functions.php";
include $tpl."header.php";

?>