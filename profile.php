<?php

   session_start();
   $pagetitle="Profile";
include "int.php";
if(isset($_SESSION['user'])){

   $getuser=$con->prepare("SELECT * FROM users WHERE uysername=?");
$getuser->execute(array($sessionuser));
$info=$getuser->fetch();
$userid=$info['userid'];
   // echo $sessionuser;

?>
<h1 class="text-center"> <?php echo $_SESSION['user'];?> Profile</h1>
<div class="information block">
 <div class="container">
   <div class="panel panel-primary">
      <div class="panel-heading">My Information</div>
         <div class="panel-body">
            <ul class="list-unstyled">
              <li> 
               <i class="fa fa-unlock-alt fa-fw"></i>
               <span>Login Name</span>: 
               <?php echo $info['uysername'];?>

            </li>
              <li>
              <i class="fa fa-envelope fa-fw"></i>
               <span>Email </span>:
               <?php echo $info['email'];?>
            </li>
              <li>
              <i class="fa fa-user fa-fw"></i>
               <span>Full Name</span> : 
               <?php echo $info['fullname'];?>
            </li>
              <li>
              <i class="fa fa-calendar fa-fw"></i>
               <span>Register Date</span>:
               <?php echo $info['date'];?>
            </li>
              <li>
              <i class="fa fa-tags fa-fw"></i>
               <span>Fav Category</span>:
            </li>
            </ul> 
      <a href="#" class="btn btn-default ">Edit Information</a>
      </div>
    </div>
  </div>
 </div>
 <div id="my-ads"class="myads block">
 <div class="container">
   <div class="panel panel-primary">
      <div class="panel-heading">My Items</div>
         <div class="panel-body">
    <?php
    if(!empty(getall('*','items',"WHERE memberid={$userid}",'','id'))){
      echo "<div class='row'>";
          $item=getall('*','items',"WHERE memberid={$userid}",'','id');
          foreach ($item as $c){
          echo "<div class='col-sm-6 col-md-3 '>";
          echo "<div class='thumbnail item-box'>";
          echo "<span class='price-tag'>$".$c['price']."</span>";
          if($c['approve']==0){
            echo "<span class='approvestatus'>Not Approved</span>";
          }
          echo "<img class='img-responsive' src='img.png' alt=''/>";
          echo "<div class='caption'>";
          echo "<h3><a href='item.php?itemid=".$c['id']."'>".$c['name']."</a></h3>";
          echo "<p>".$c['description']."</p>";
          echo "<div class='date'>".$c['adddate']."</div>";
          echo "</div></div></div>";
                         }
                echo "</div>";         
               }else{
                  echo "Sorry there's no ads to show ,Create <a href='newad.php'> New Ads</a>";
               }
        ?>
        


      </div>
    </div>
  </div>
 </div>
 <div class="mycomments block">
 <div class="container">
   <div class="panel panel-primary">
      <div class="panel-heading">Latest Comments</div>
         <div class="panel-body">
            <?php

            $mycomment= getall('comment','comments',"WHERE user_id={$userid}",'','id');
      
if(!empty($mycomment)){
foreach($mycomment as $r){
   echo "<p>".$r['comment']."</p>";
}
}else{
   echo 'There\'s no comments';
}
?>
      </div>
    </div>
  </div>
 </div>
<?php
}else{
   header('location:login.php');
   exit();
}
echo "Welcome ".$_SESSION['user'] ;
include $tpl."footer.php";
?>