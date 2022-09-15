<?php
ob_start("ob_gzhandler");
session_start();
if(isset($_SESSION['username'])){
    $pagetitle="Dashboard";
    include "int.php";
    // $stmts=$con->prepare("SELECT COUNT(userid) FROM users");
    // $stmts->execute();
    // echo $stmts->fetchColumn();


?>
<div class="container home-stats text-center">
<h1>Dashboard</h1>
 <div class="row">
  <div class="col-md-3">
    <div class="stat st-members">
    <i class="fa fa-users"></i>   
     <div class ="info"> 
        
       Total Members
       <span><a href="member.php"><?php echo countitems('userid','users')?></a></span>
</div>   
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat st-pending">
    <i class="fa fa-user-plus"></i>   
     <div class ="info"> 
        Pending Members
        <span><a href='member.php?action=manage&page=pending'><?php echo check("regstatus","users",0)?></a></span>
     </div>
    
    </div>
    
  </div>
  <div class="col-md-3">
    <div class="stat st-items">
    <i class="fa fa-tag"></i>   
     <div class ="info"> 
      Total Items<span><a href="item.php"><?php echo countitems('id','items')?></a></span>
     </div>
    </div>
    
  </div>
  <div class="col-md-3">
    <div class="stat st-comments">
    <i class="fa fa-comments"></i>   
     <div class ="info"> 
       Total Comments
        <span> <a href="comment.php"><?php echo countitems('id','comments')?></a></span>
     </div>
    </div>
    
  </div>
 </div>
</div>
<div class="container latest">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <?php 
                $lastuser=3;
                $lastitem=3;
                $lastcom=3;

                $thelastuser=getlatest("*","users","userid",$lastuser);
                $thelastitem=getlatest("*","items","id",$lastitem);
                ?>
                <div class="panel-heading">
                    <i class="fa fa-users"></i> Latest <?php echo "$lastuser"?> Registered Users
                    <span class="toggle-info pull-right">
                        <i class="fa fa-plus fa-lg"></i>
                    </span>

                </div>
                <div class="panel-body">
                    <ul class="list-unstyled latest-users">
                     <?php
                     if(!empty($thelastuser)){
                      foreach ($thelastuser as $user){
                       echo "<li>".$user["uysername"].
                       "<a href='member.php?action=edit&userid=".$user['userid']."'><span class='btn btn-success pull-right'><i class='fa fa-edit'></i>Edit
                      ";
                       if($user['regstatus']==0){
                        echo "<a href='member.php?action=activate&userid=".$user["userid"]."' class='btn btn-info pull-right activate'><i class='fa fa-check'></i>Activate</a>";
                       }
                      echo "</span>";
                      echo
                      " </a></li>";
                       }
                    }else{
                        echo "no users to show";
                    }
            
                        ?>
                </div>

            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-tag"></i>Latest <?php echo "$lastitem"?> Items
                    <span class="toggle-info pull-right">
                        <i class="fa fa-plus fa-lg"></i>
                    </span>
                </div>
                <div class="panel-body">
                    <ul class="list-unstyled latest-users">
                     <?php
                     if(!empty($thelastitem)){
                      foreach ($thelastitem as $item){
                       echo "<li>".$item["name"].
                       "<a href='item.php?action=edit&itemid=".$item['id']."'><span class='btn btn-success pull-right'><i class='fa fa-edit'></i>Edit
                      ";
                       if($item['approve']==0){
                        echo "<a href='item.php?action=approve&itemid=".$item["id"]."' class='btn btn-info pull-right activate'><i class='fa fa-check'></i>Approve</a>";
                       }
                      echo "</span>";
                      echo
                      " </a></li>";
                       }
                    }else{
                        echo "there is no record to show";
                    }
            
                        ?>
                </div>

            </div>
        </div>
        
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                
                <div class="panel-heading">
                    <i class="fa fa-comments"></i> Latest <?php echo $lastcom?> Comments
                    <span class="toggle-info pull-right">
                        <i class="fa fa-plus fa-lg"></i>
                    </span>

                </div>
                <div class="panel-body">
                <?php
         $stmt=$con->prepare("SELECT 
                             comments.*,users.uysername AS username
                            FROM
                            comments
                           
                            INNER JOIN users on users.userid=comments.user_id
                            order by id DESC  
                            limit $lastcom");
      $stmt->execute();
      $rows=$stmt->fetchAll();
    
        if(!empty($rows)){
        foreach ($rows as $row){
            ?>
            <div class = "comment-box"> 
                <span class='membern'><?php echo $row['username']?></span> 
                <p class='commentc'><?php echo $row['comment']?></p> 
            </div>
    <?php    
       
        }
    }else{
        echo "there is no comment to show";
    }

      ?>
                    
                </div>

            </div>
        </div>
       
        
    </div>
</div>

<?php
    include $tpl."footer.php";
    // print_r($_SESSION);
    // // echo $_SESSION['ID'];
    // echo"welcome";
    
}else{
    header('Location: index.php');
    exit(); 
}
ob_end_flush();
?>