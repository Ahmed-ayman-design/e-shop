<?php
function getall($filed,$t,$where=NULL,$and=NULL,$or,$order="DESC"){
    global $con;
    $stm=$con->prepare("SELECT $filed FROM $t $where $and ORDER BY $or $order");
    $stm->execute();
    $all=$stm->fetchAll();
    return $all;
    }

    // function getall($filed,$t,$where=NULL,$and=NULL,$or,$value=NULL,$order="DESC"){
    //     global $con;
    //     $stm=$con->prepare("SELECT $filed FROM $t $where $and ORDER BY $or $order");
    //     $stm->execute(array($value));
    //     $all=$stm->fetchAll();
    //     return $all;
    //     }
// function getcat(){
//     global $con;
//     $stm=$con->prepare("SELECT * FROM category ORDER BY id ASC");
//     $stm->execute();
//     $cats=$stm->fetchAll();
//     return $cats;
//     }
    


    // function getitem($where,$value,$approve = NULL){
    //     global $con;
    //     if($approve == NULL){
    //         $sql = " AND approve=1";
    //     }else{
    //         $sql=NULL;
    //     }
    //     $stm=$con->prepare("SELECT * FROM items where $where=?   $sql  ORDER BY id DESC ");
    //     $stm->execute(array($value));
    //     $items=$stm->fetchAll();
    //     return $items;
    //     }

function checkuserstatus($user){
     global $con;
    $stmt=$con->prepare("SELECT 
                           uysername,regstatus 
                        FROM 
                              users 
                        WHERE 
                           uysername= ?
                        AND 
                           regstatus=0 
                        ");
    $stmt->execute(array($user));
    
    $status = $stmt->rowcount();
    return $status;
}




function check($select,$from,$value){
    global $con;
    $stamt=$con->prepare("SELECT $select FROM $from WHERE $select=?");
    $stamt->execute(array($value));
    $count=$stamt->rowCount();
    return $count;
   
    
    }

















    





function gettitle(){
    global $pagetitle;
    if(isset($pagetitle)){
        echo $pagetitle;
    }else{
        echo "Default";
    }
}

function redirect($msg,$url=null,$seconds=3){
    if($url===null){
        $url="index.php";
    }else{
        if(isset($_SERVER['HTTP_REFERER'])&&$_SERVER['HTTP_REFERER']!==''){
        $url=$_SERVER['HTTP_REFERER'];}else{
            $url="index.php";
        }
    }
    echo $msg;
// echo "<div class='alaert alert-danger'>$msg</div>";
echo "<div class='alaert alert-info'>You will be redirected to $url after $seconds</div>";
header("refresh: $seconds;url=$url");
exit();

}


function countitems($item,$table){
    global $con;
    $stmts=$con->prepare("SELECT COUNT($item) FROM $table");
    $stmts->execute();
    return $stmts->fetchColumn();
}


function getlatest($select,$table,$order,$limit=3){
global $con;
$stm=$con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
$stm->execute();
$rows=$stm->fetchAll();
return $rows;
}

