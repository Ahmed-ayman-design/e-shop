<?php
$do=isset($_GET['action'])?$_GET['action']:'manage';
// $do='';
// if(isset($_GET['action'])){
//     $do= $_GET['action'];
// }else{
//     $do ='manage';
// }
if($do=="manage"){
   echo "welcome you are in manage page";
   echo '<a href="page.php?action=add">Add new page</a> ';
}elseif($do=="add"){
    echo "welcome you are in add page";
}elseif($do=="insert"){
    echo "welcome you are in insert page";
    
}else{
    echo "error no page";
}
?>