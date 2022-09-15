<?php

   session_start();
   $pagetitle="Show Item";
    include "int.php";
    $itemid=isset($_GET["itemid"])&& is_numeric($_GET["itemid"])?intval($_GET["itemid"]) :0;


    $stmt=$con->prepare("SELECT 
                                  items.*
                                  ,category.name as catname
                                  ,users.uysername as membername 
                                  from items
                         INNER JOIN category ON category.id=catid
                         INNER JOIN users ON users.userid=memberid     
                                  
                         WHERE 
                               items.id= ?
                           ANd approve=1 ");

        $stmt->execute(array($itemid));
        $count=$stmt->rowCount();
        if($count>0){
        $item=$stmt->fetch();

?>
<h1 class="text-center"> <?php echo $item['name'];?></h1>
<div class="container">
<div class="row">
   <div class="col-md-3">
   <img class='img-responsive img-thumbnail center-block' src='img.png' alt=''/>
        </div>
        <div class="col-md-9 item-info">
      <h2><?php echo $item['name']?></h2>
      <p><?php echo $item['description']?></p>
      <ul class="list-unstyled">
      <li>
         <i class="fa fa-calendar fa-fw"></i> <span>Added Date</span>: <?php echo $item['adddate']?>
        
      </li>
      <li><i class="fa fa-cart-plus fa-fw"></i> <span>Price</span>: $<?php echo $item['price']?></li>
      <li><i class="fa fa-building fa-fw"></i> <span>Made In</span>: <?php echo $item['country']?></li>
      <li><i class="fa fa-tags fa-fw"></i> <span>Category</span>: <a href="category.php?id=<?php echo $item['catid']?>&name=<?php echo $item['catname']?>"><?php echo $item['catname']?></a></li>
      <li><i class="fa fa-user fa-fw"></i> <span>Added By</span>:<a href="#"> <?php echo $item['membername']?></a></li>
      <li class="tags-items"><i class="fa fa-tag fa-fw"></i> <span>Tags</span>:
   <?php
    $alltags=explode(',',$item['tags']);
    foreach($alltags as $tag){
      $tag=str_replace(" ",'',$tag);
      $lowertag=strtolower($tag);
      if(!empty($tag)){
      echo "<a href='tags.php?name={$lowertag}'>".$tag ."</a>";}
    }
    ?>
          </li>
        </ui>
      </div>
        </div>
        <hr class="custom-hr">
        <!-- start add comment -->
        <?php if(isset($_SESSION['user'])){
         
         ?>
<div class="row">
<div class="col-md-offset-3">
<div class="add-comment">
<h3>Add Your Comment</h3>
<form action="<?php echo $_SERVER['PHP_SELF']."?itemid=".$item["id"];?>" method="POST">
   <textarea name="comment" required></textarea>
   <input class="btn btn-primary"type="submit" value="Add Comment"/>
</form>  
<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
  
   $comment=filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
   $userid=$item['memberid'];
   $itemid=$item['id'];
   if(!empty($comment)){
      $stmt=$con->prepare("INSERT INTO comments(comment,status,adddate,item_id,user_id) 
                           VALUES(:zcomment,0,now(),:zitemid,:zuserid)");
      $stmt->execute(array(
         "zcomment"=>$comment,
         "zitemid"=>$itemid,
         "zuserid"=>$_SESSION['uid']
      ));
      if($stmt){
         echo "<div class='alert alert-success'>Comment added</div>";
      }else{
         echo "<div class='alert alert-danger'>Comment must not be empty</div>";
      }                     
   }
}
?>
        </div>
</div>
</div>
<?php }else{
   echo "<a href='login.php'>Login</a> Or<a href='login.php'> Register</a> To Add Comment";
   }?>
 <!-- end add comment -->
        <hr class="custom-hr">
        <?php
         $stmt=$con->prepare("SELECT 
         comments.* ,users.uysername AS username
        FROM
        comments
        INNER JOIN users on users.userid=comments.user_id
        where item_id=?
        and status=1
         order by id DESC");
$stmt->execute(array($itemid));
$rows=$stmt->fetchAll();

         ?>
       
        
  <?php  foreach($rows as $r){
echo "<div class='comment-box'>";
   echo "<div class='row'>";
    echo "<div class='col-sm-2 text-center'>
    <img class='img-responsive img-thumbnail img-circle center-block' src='img.png' alt=''/>"
    .$r['username'].
    "</div>";
    echo "<div class='col-sm-10'>
    <p class='lead'>".$r['comment']."</p></div>";
   // echo $r['comment'].'<br>';
   // echo $r['adddate'].'<br>';
   // echo $r['username'].'<br>';
   // echo $r['user_id'].'<br>';
   echo "</div></div><hr class='custom-hr'>";

}
?>
        </div>
        </div>
<?php
        }else{
         echo "<div class='container'>";
         echo '<div class="alert alert-danger">There is no such ID Or this item is waiting approval</div>';
         echo "</div>";
        }
// echo "Welcome ".$_SESSION['user'] ;
include $tpl."footer.php";
?>