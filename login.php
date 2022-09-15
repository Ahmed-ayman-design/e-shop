<?php
ob_start();
$pagetitle="login";
session_start();
if(isset($_SESSION['user'])){
    header('Location: index.php');

}
include "int.php";


if($_SERVER['REQUEST_METHOD']=="POST"){
    if(isset($_POST['login'])){
    $user=$_POST['username'];
    $pass=$_POST['password'];
    $hashpass=sha1($pass);
    echo $user. " " .$pass;
    
    $stmt=$con->prepare("SELECT 
                          userid, uysername,password 
                        FROM 
                              users 
                        WHERE 
                           uysername= ?
                        AND 
                           password=? 
                        ");
    $stmt->execute(array($user,$hashpass));
    $get=$stmt->fetch();
    $count = $stmt->rowcount();
    // echo $count;
    if($count>0){
        
        // echo "welcome ".$username;
        $_SESSION['user']=$user;
        $_SESSION['uid']=$get['userid'];
        header('Location: index.php');
        exit();

    }
}else{
    $formerror=[];
    $username=$_POST['username'];
    $pass=$_POST['password'];
    $passa2=$_POST['password2'];
    $email=$_POST['email'];
    if(isset($username)){
        $fuser=filter_var($username, FILTER_SANITIZE_STRING);
        if(strlen($fuser)<3){
            $formerror[]="username must be larger than 2 char";
        }

    }

    if(isset( $pass)&&isset( $passa2)){

        if(empty( $pass)){
            $formerror[]="Sorry Password can not be empty";
           }
       $pass1= sha1( $pass);
       $pass2=sha1( $passa2);
       if($pass1!==$pass2){
        $formerror[]="Sorry Password is not match";
       }
       

    }
    if(isset( $email)){
        $fuser=filter_var( $email, FILTER_SANITIZE_EMAIL);
        if(filter_var($fuser,FILTER_VALIDATE_EMAIL) !=True){
            $formerror[]="This Email is not valid";
        }

    }
    
    if(empty($formerror)){

        $check=check("uysername","users",$username);
        if($check==1){
            $formerror[]="sorry this user is exist";
        //   $msg= "<div class='alert alert-danger'>sorry this user is exist</div>";
          
        }else{
  
        
  
         $stmt=$con->prepare("INSERT INTO users(uysername,password,email,regstatus,date) VALUES(:zuser,:zpass,:zemail,0,now())");
         $stmt->execute(array(
         "zuser" =>$username,
          "zpass" =>$pass1,
            "zemail" =>$email,
        
          ));
         $sucmsg="Congrats you are now resgister user";
        //  $msg = "<div class ='alert alert-success'>". $stmt->rowCount()."Record inserted </div>";
        //  redirect($msg,"back");
        }
      }
}
}

?>

<div class="container loginp">
   
    <h1 class="text-center"> <span class="active" data-class="form-log">Login</span> | <span  data-class="form-sign">Signup</span></h1>
    
    <form class="form-log" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <div class="input-container">
        <input class="form-control"type="text" name="username" autocomplete="off" placeholder="Type your username" />
    </div>
    <div class="input-container">
        <input class="form-control"type="password" name="password" autocomplete="new-password" placeholder="Type your password" required/>
        
    </div>
        <input class="btn btn-primary btn-block" name="login" type="submit" value="Login"/>
    </form>
     <!-- /////////////////////////////////////////////////////////////////////////////////////////// -->


    <form class="form-sign" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <div class="input-container">
        <input 
        pattern=".{3,9}"
        title="Username must be betwwen 3 and 9 chars"
        class="form-control"
        type="text" 
        name="username" 
        autocomplete="off" 
        placeholder="Type your username"
        required/>
</div>
<div class="input-container">
        <input 
        minlenght="3"
        class="form-control"
        type="password" 
        name="password" 
        autocomplete="new-password"
        placeholder="Type your password"
        required/>
       
    </div>
<div class="input-container">     
   <input 
   minlenght="3"
   class="form-control"
   type="password" 
   name="password2" 
   autocomplete="new-password" 
   placeholder="Type a password again"
   required/>
  
</div>        
<div class="input-container">
   <input 
   class="form-control"
   type="email" 
   name="email" 
   placeholder="Type your valid email"
   required/>
  
</div>       
   <input class="btn btn-success btn-block"name="sigup" type="submit" value="Signup"/>
    </form>

<div class="container text-center ">
    If you are Admin <a href="admin/">Login from here</a> 
</div>    
<div class="theerrors text-center">
   
<?php
if(!empty($formerror)){
    echo " <div class='msg'>";
    foreach($formerror as $er){
        echo $er."<br>";
    } 
    echo "</div>";
}
if(isset($sucmsg)){
    echo "<div class='msg success'>".$sucmsg."</div>";
}
?>
</div>
</div>
</div>


<?php
include $tpl."footer.php";
ob_end_flush();
?>