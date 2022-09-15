<?php
$pagetitle="Manage members";
session_start();
if(isset($_SESSION['username'])){
    
    include "int.php";
    $do=isset($_GET['action'])?$_GET['action']:'manage';
    if($do=="manage"){
      $hhh="";
      if(isset($_GET['page'])&&$_GET['page']=='pending'){
        $hhh="AND regstatus=0";
      }
      $stmt=$con->prepare("SELECT * FROM users WHERE groupid!=1 $hhh order by userid DESC");
      $stmt->execute();
      $rows=$stmt->fetchAll();
      if(!empty($rows)){
      ?>
<h1 class="text-center">Manage Member</h1>
<div class ="container">
  <div class="table-responsive">
    <table class="main-table manage-members text-center table table-bordered">
      <tr>
        <td>#ID</td>
        <td>Avatar</td>
        <td>Username</td>
        <td>Email</td>
        <td>Full Name</td>
        <td>Register Date</td>
        <td>Control</td>
        
      </tr>
      <?php
      foreach($rows as $row){
        echo "<tr>";
        echo"<td>".$row["userid"]."</td>";
        echo"<td>";
        if(empty($row['avatar'])){
          echo "<img src='img.png'alt=''/>";
        }else{
        echo "<img src='uploads/avatar/".$row['avatar']."'alt=''/>";}
        echo "</td>";
         echo"<td>".$row['uysername']."</td>";
         echo"<td>".$row["email"]."</td>";
         echo"<td>".$row["fullname"]."</td>";
         echo"<td>".$row["date"]."</td>";
         echo"<td>
         <a href='member.php?action=edit&userid=".$row["userid"]."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
        <a href='member.php?action=delete&userid=".$row["userid"]."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a> ";
        if($row['regstatus']==0){
          echo "<a href='member.php?action=activate&userid=".$row["userid"]."' class='btn btn-info activate'><i class='fa fa-check'></i>Activate</a>";
        }
        echo
         "</td>";
         echo "</tr>";
      }
      ?>
          </table>
  </div>
<a href='member.php?action=add' class="btn btn-primary"><i class="fa fa-plus"></i>New member</a>
</div>
    <?php
      }else{
        echo "<div class='container'>";
         echo "<div class='nice'>There is no record to show</div>";
         echo "<a href='member.php?action=add' class='btn btn-primary'><i class='fa fa-plus'></i>New member</a>";
        echo "</div>";
      }

    }elseif($do=="add"){
echo "welcome to add member page";?>

<h1 class="text-center">
     Add new Member
      </h1>
      <div class="container">
        <form class="form-horizontal" action="?action=insert" method="POST" enctype="multipart/form-data">
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10 col-md-4">
            
                <input type="text" name="username" class="form-control" required="required" autocomplete="off" placeholder="username"/>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10 col-md-4">
                <input type="password" name="password" class="password form-control"required="required" autocomplete="new-password" placeholder="must be hard"/>
            <i class="show-pass fa fa-eye fa-1x"></i>
              </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10 col-md-4">
                <input type="email" name="email" required="required" class="form-control" placeholder="must be valid"/>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Full  Name</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="fullname" placeholder="must be 2" required="required" class="form-control"/>
            </div>
          </div>

          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">User Avatar</label>
            <div class="col-sm-10 col-md-4">
                <input type="file" name="avatar" class="form-control" required="required" />
            </div>
          </div>

          <div class="form-group ">
            <div class="icol-sm-offset-2 col-sm-10">
                <input type="submit" value="Add Member" class="btn btn-primary btn-lg"/>
            </div>
          </div>
         </form>
         </div>
<?php       
}elseif($do=="insert"){
  // echo $_POST["username"].$_POST["password"].$_POST["email"].$_POST["fullname"];
  
 if($_SERVER["REQUEST_METHOD"]=="POST"){
       echo "<h1 class='text-center'>Insert member</h1>";
       echo "<div class='container'>";

      
       
       $avatarname= $_FILES['avatar']['name'];
       $avatarsize=$_FILES['avatar']['size'];
       $avatatmprname=$_FILES['avatar']['tmp_name'];
       $avatartype=$_FILES['avatar']['type'];

       $avatarallowextension=array("jpeg","png","jpg","gif");
       $avaexe=explode ( ".", $avatarname );
       $avaex = strtolower( end ( $avaexe ) );
       
      


       $name=$_POST["username"];
       $email=$_POST["email"];
       $full=$_POST["fullname"];
       $pass=$_POST["password"];
       $formerror=array();
       $hpass=sha1($_POST["password"]);
       
       if(empty($name)){
        $formerror[]="username mustnt be <strong>empty</strong>";
        
       }
       if(empty($full)){
        $formerror[]="fullname mustnt be<strong> empty</strong>";
        
       }
       if(empty($pass)){
        $formerror[]="password mustnt be<strong> empty</strong>";
        
       }
       if(strlen($name)<3){
        $formerror[]="username mustnt be <strong>less than 3</strong>";
        
       }
       if(empty($email)){
        $formerror[]="email mustnt be <strong>empty</strong>";
  
       }
       if(!empty($avatarname)&&!in_array($avaex,$avatarallowextension)){
        $formerror[]="this extension is <strong>not allowed</strong>";
       }
       if(empty($avatarname)){
        $formerror[]="avatar is  <strong>required</strong>";
       }
       if($avatarsize>4194304){
        $formerror[]="avatar can not be larger than  <strong>4 MB</strong>";
       }
       foreach($formerror as $error){
        
        echo "<div class='alert alert-danger'>".$error ."</div>";
       }

       if(empty($formerror)){

$avatars=rand(0,1000000000000).'_'.$avatarname;
move_uploaded_file($avatatmprname,"uploads\avatar\\".$avatars);
      $check=check("uysername","users",$name);
      if($check==1){
        $msg= "<div class='alert alert-danger'>sorry this user is exist</div>";
        redirect($msg,'back');
      }else{

      

       $stmt=$con->prepare("INSERT INTO 
       users(uysername,password,email,fullname,regstatus,date,avatar) 
       VALUES(:zuser,:zpass,:zemail,:zfull,1,now(),:zavatar)");
       $stmt->execute(array(
       "zuser" =>$name,
        "zpass" =>$hpass,
          "zemail" =>$email,
         "zfull" =>$full,
         "zavatar" =>$avatars,
        ));
       
       $msg = "<div class ='alert alert-success'>". $stmt->rowCount()."Record inserted </div>";
       redirect($msg,"back");
      }
    }
      }else{
        echo "<div class='container'>";
        echo "sorry";
        $msg="<div class='alert alert-danger'>you can't browse this page</div>";

        redirect($msg);
        echo "</div>";
      }
      echo "</div";
    }elseif($do=="edit"){
$user=isset($_GET["userid"])&& is_numeric($_GET["userid"])?intval($_GET["userid"]) :0;

$stmt=$con->prepare("SELECT 
                           *
                        FROM 
                              users 
                        WHERE 
                           userid= ?
                         LIMIT 1");
    $stmt->execute(array($_GET["userid"]));
    $row=$stmt->fetch();
    $count = $stmt->rowcount();
  if($count>0){
    // echo $count;
      // if(isset($_GET["userid"])&& is_numeric($_GET["userid"])){

      //   echo intval($_GET["userid"]);
      // }else{
      //   echo 0;
      // }
      ?>
        
      
    
      
      
      <h1 class="text-center">
     Edit Member
      </h1>
      <div class="container">
        <form class="form-horizontal" action="?action=update" method="POST">
          <input type="hidden" name="userid" value="<?php echo $user ?>"/>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10 col-md-4">
            <input type="hidden" name="userid" class="form-control" value ="<?php echo $user?>"autocomplete="off"/>
                <input type="text" name="username" class="form-control" value ="<?php echo $row["uysername"]?>" required="required" autocomplete="off"/>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10 col-md-4">
            <input type="hidden" name="oldpassword" value="<?php echo $row["password"]?>"/>
                <input type="password" name="newpassword" class="form-control"autocomplete="new-password"/>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10 col-md-4">
                <input type="email" name="email"value ="<?php echo $row["email"]?>" required="required" class="form-control" />
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Full  Name</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="fullname"value ="<?php echo $row["fullname"]?>" required="required" class="form-control"/>
            </div>
          </div>
          <div class="form-group ">
            <div class="icol-sm-offset-2 col-sm-10">
                <input type="submit" value="save" class="btn btn-primary btn-lg"/>
            </div>
          </div>
         </form>
         </div>
<?php       
    }else{
      echo "<div class='container'>";
      $tmsg = "<div class ='alert alert-danger'>there is no id </div>";
      redirect($tmsg);
      echo "</div>";
  }

}elseif($do=="update"){
  echo "<h1 class='text-center'>update member</h1>";
  echo "<div class='container'>";
      if($_SERVER["REQUEST_METHOD"]=="POST"){
       $id=$_POST["userid"];
       $name=$_POST["username"];
       $email=$_POST["email"];
       $full=$_POST["fullname"];
       $pass=empty($_POST["newpassword"])?$_POST["oldpassword"]:sha1($_POST["newpassword"]);
       $formerror=array();
       if(empty($name)){
        $formerror[]="<div class='alert alert-danger'>username mustnt be <strong>empty</strong></div>";
        
       }
       if(empty($full)){
        $formerror[]="<div class='alert alert-danger'>fullname mustnt be<strong> empty</strong></div>";
        
       }
       if(strlen($name)<3){
        $formerror[]="<div class='alert alert-danger'>username mustnt be <strong>less than 3</strong></div>";
        
       }
       if(empty($email)){
        $formerror[]="<div class='alert alert-danger'>email mustnt be <strong>empty</strong></div>";
  
       }
       foreach($formerror as $error){
        echo $error;
       }

       if(empty($formerror)){
        $stmt1=$con->prepare("select * from users where uysername=? and userid != ?");
        $stmt1->execute(array($name,$id));
        $cou=$stmt1->rowCount();
        if($cou==1){
          
          $msg="<div class ='alert alert-danger'> sorry this user exit </div>";
          redirect($msg,'back',4);
        }else{
      
          $stmt = $con->prepare("UPDATE users SET uysername =?,email=?,fullname=?,password=? WHERE userid=?");
          $stmt->execute(array($name,$email,$full,$pass,$id));

          $msg="<div class ='alert alert-success'>". $stmt->rowCount()."Record updated </div>";
          redirect($msg,'back',4);
        }
        }
      }else{
        $msg= "<div class='alert alert-danger'>sorry</div>";
        redirect($msg);
        
      }
      echo "</div";
}elseif($do=="delete"){
  echo "<h1 class='text-center'>Delete member</h1>";
  echo "<div class='container'>";
$user=isset($_GET["userid"])&& is_numeric($_GET["userid"])?intval($_GET["userid"]) :0;

$stmt=$con->prepare("SELECT 
                           *
                        FROM 
                              users 
                        WHERE 
                           userid= ?
                         LIMIT 1");
$chok=check('userid','users',$user);
    // $stmt->execute(array($_GET["userid"]));
    // $count = $stmt->rowcount();
    // echo $chok;
  if($chok>0){
    $stmt=$con->prepare("DELETE FROM users WHERE userid=:userid");
    $stmt->bindParam(":userid",$user);
    $stmt->execute();
    $msg= "<div class ='alert alert-success'>". $stmt->rowCount()."Record Deleted </div>";
    redirect($msg);
  }else{
    $msg= "<div class='alert alert-danger'>this id isnot exist</div>";
    redirect($msg);
  }
  echo "</div"; 
}elseif($do=="activate"){
  echo "<h1 class='text-center'>Activate member</h1>";
  echo "<div class='container'>";
$user=isset($_GET["userid"])&& is_numeric($_GET["userid"])?intval($_GET["userid"]) :0;

$stmt=$con->prepare("SELECT 
                           *
                        FROM 
                              users 
                        WHERE 
                           userid= ?
                         LIMIT 1");
$chok=check('userid','users',$user);
    // $stmt->execute(array($_GET["userid"]));
    // $count = $stmt->rowcount();
    // echo $chok;
  if($chok>0){
    $stmt=$con->prepare("UPDATE users SET regstatus=1 WHERE userid=?");
    
    $stmt->execute(array($user));
    $msg= "<div class ='alert alert-success'>". $stmt->rowCount()."Record Activated </div>";
    redirect($msg);
  }else{
    $msg= "<div class='alert alert-danger'>this id isnot exist</div>";
    redirect($msg);
  }
  echo "</div"; 
}

    include $tpl."footer.php";
    
}else{
    header('Location: index.php');
    exit(); 
}

?>
