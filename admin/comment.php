<?php
$pagetitle="Comments";
session_start();
if(isset($_SESSION['username'])){
    
    include "int.php";
    $do=isset($_GET['action'])?$_GET['action']:'manage';
    if($do=="manage"){
    //   $hhh="";
    //   if(isset($_GET['page'])&&$_GET['page']=='pending'){
    //     $hhh="AND regstatus=0";
    //   }
      $stmt=$con->prepare("SELECT 
                             comments.*,items.name AS itemname,users.uysername AS username
                            FROM
                            comments
                            INNER JOIN items on items.id=comments.item_id
                            INNER JOIN users on users.userid=comments.user_id
                             order by id DESC");
      $stmt->execute();
      $rows=$stmt->fetchAll();
      if(!empty($rows)){
      ?>
<h1 class="text-center">Manage Comments</h1>
<div class ="container">
  <div class="table-responsive">
    <table class="main-table text-center table table-bordered">
      <tr>
        <td>#ID</td>
        <td>Comment</td>
        <td>Item Name</td>
        <td>User Name</td>
        <td>Added Date</td>
        <td>Control</td>
        
      </tr>
      <?php
      foreach($rows as $row){
        echo "<tr>";
        echo"<td>".$row["id"]."</td>";
         echo"<td>".$row['comment']."</td>";
         echo"<td>".$row["itemname"]."</td>";
         echo"<td>".$row["username"]."</td>";
         echo"<td>".$row["adddate"]."</td>";
         echo"<td>
         <a href='comment.php?action=edit&commentid=".$row["id"]."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
        <a href='comment.php?action=delete&commentid=".$row["id"]."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a> ";
        if($row['status']==0){
          echo "<a href='comment.php?action=approve&commentid=".$row["id"]."' class='btn btn-info activate'><i class='fa fa-check'></i>Approve</a>";
        }
        echo
         "</td>";
         echo "</tr>";
      }
      ?>
          </table>
  </div>
</div>
    <?php
      }else{
        echo "<div class='container'>";
        echo "<div class='nice'>There is no comment to show</div>";
        
       echo "</div>";
      }
    }elseif($do=="edit"){
$com=isset($_GET["commentid"])&& is_numeric($_GET["commentid"])?intval($_GET["commentid"]) :0;

$stmt=$con->prepare("SELECT 
                           *
                        FROM 
                              comments
                        WHERE 
                           id= ?
                         LIMIT 1");
    $stmt->execute(array($_GET["commentid"]));
    $row=$stmt->fetch();
    $count = $stmt->rowcount();
  if($count>0){
    
      ?>
        
      
    
      
      
      <h1 class="text-center">
     Edit Comment
      </h1>
      <div class="container">
        <form class="form-horizontal" action="?action=update" method="POST">
          <input type="hidden" name="comid" value="<?php echo $com ?>"/>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Comment</label>
            <div class="col-sm-10 col-md-4">
            <textarea class="form-control" name="comment"><?php echo $row['comment']?></textarea>
                
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
  echo "<h1 class='text-center'>Update Comment</h1>";
  echo "<div class='container'>";
      if($_SERVER["REQUEST_METHOD"]=="POST"){
       $comid=$_POST["comid"];
       $comment=$_POST["comment"];
       
       $stmt = $con->prepare("UPDATE comments SET comment =? WHERE id=?");
       $stmt->execute(array($comment,$comid));

       $msg="<div class ='alert alert-success'>". $stmt->rowCount()."Record updated </div>";
        redirect($msg,'back',4);
      
      }else{
        $msg= "<div class='alert alert-danger'>sorry</div>";
        redirect($msg);
        
      }
      echo "</div";
}elseif($do=="delete"){
  echo "<h1 class='text-center'>Delete Comment</h1>";
  echo "<div class='container'>";
$comid=isset($_GET["commentid"])&& is_numeric($_GET["commentid"])?intval($_GET["commentid"]) :0;

$stmt=$con->prepare("SELECT 
                           *
                        FROM 
                              comments
                        WHERE 
                           id= ?
                         LIMIT 1");
$chok=check('id','comments',$comid);

  if($chok>0){
    $stmt=$con->prepare("DELETE FROM comments WHERE id=:comid");
    $stmt->bindParam(":comid",$comid);
    $stmt->execute();
    $msg= "<div class ='alert alert-success'>". $stmt->rowCount()."Record Deleted </div>";
    redirect($msg,"back");
  }else{
    $msg= "<div class='alert alert-danger'>this id isnot exist</div>";
    redirect($msg);
  }
  echo "</div"; 
}elseif($do=="approve"){
  echo "<h1 class='text-center'>Approve Comment</h1>";
  echo "<div class='container'>";
$comid=isset($_GET["commentid"])&& is_numeric($_GET["commentid"])?intval($_GET["commentid"]) :0;

$stmt=$con->prepare("SELECT 
                           *
                        FROM 
                              comments 
                        WHERE 
                           id= ?
                         LIMIT 1");
$chok=check('id','comments',$comid);
   
  if($chok>0){
    $stmt=$con->prepare("UPDATE comments SET status=1 WHERE id=?");
    
    $stmt->execute(array($comid));
    $msg= "<div class ='alert alert-success'>". $stmt->rowCount()."Record Approved </div>";
    redirect($msg,"back");
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
