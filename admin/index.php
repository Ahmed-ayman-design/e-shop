<?php
$nonav='';
$pagetitle="login";
include "int.php";
session_start();


if(isset($_SESSION['username'])){
    header('Location: dashboard.php');
}

if($_SERVER['REQUEST_METHOD']=="POST"){
    $username=$_POST['user'];
    $password=$_POST['pass'];
    $hashpass=sha1($password);
    
    $stmt=$con->prepare("SELECT 
                           userid,uysername,password 
                        FROM 
                              users 
                        WHERE 
                           uysername= ?
                        AND 
                           password=? 
                        AND 
                           groupid = 1 
                         LIMIT 1");
    $stmt->execute(array($username,$hashpass));
    $row=$stmt->fetch();
    $count = $stmt->rowcount();
    // echo $count;
    if($count>0){
        
        // echo "welcome ".$username;
        $_SESSION['username']=$username;
        $_SESSION['ID']=$row['userid'];
        header('Location: dashboard.php');
        exit();

    }
}

?>

<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
<h4 class="title">Admin login</h4>
    <input class ="form-control" type="text" name="user" placeholder="username" autocomplete="off"/>
    <input class ="form-control" type="password" name="pass" placeholder="password" autocomplete="new-password"/>
    <input class="btn btn-primary btn-block" type="submit"  value="login"/>
</form>
<?php
include $tpl."footer.php";
?>