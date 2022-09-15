<?php
ob_start("ob_gzhandler");
session_start();
$pagetitle="Items";
if(isset($_SESSION['username'])){
    
    include "int.php";
    $do=isset($_GET['action'])?$_GET['action']:'manage';
    if($do=="manage"){
      // $hhh="";
      // if(isset($_GET['page'])&&$_GET['page']=='pending'){
      //   $hhh="AND approve=0";
      // }
        echo "welcome to items";
      $stmt=$con->prepare("SELECT items.*
                                  ,category.name as catname
                                  ,users.uysername as membername 
                                  from items
      INNER JOIN category on category.id=catid
      INNER JOIN users on users.userid=memberid
       order by id DESC");
      $stmt->execute();
      $items=$stmt->fetchAll();
      if(!empty($items)){
      ?>
<h1 class="text-center">Manage Items</h1>
<div class ="container">
  <div class="table-responsive">
    <table class="main-table text-center table table-bordered">
      <tr>
        <td>#ID</td>
        <td>Name</td>
        <td>Description</td>
        <td>Price</td>
        <td>Adding Date</td>
        <td>Category</td>
        <td>Username</td>
        <td>Control</td>
        
      </tr>
      <?php
      foreach($items as $row){
        echo "<tr>";
        echo"<td>".$row["id"]."</td>";
         echo"<td>".$row['name']."</td>";
         echo"<td>".$row["description"]."</td>";
         echo"<td>".$row["price"]."</td>";
         echo"<td>".$row["adddate"]."</td>";
         echo"<td>".$row["catname"]."</td>";
         echo"<td>".$row["membername"]."</td>";
         echo"<td>
         <a href='item.php?action=edit&itemid=".$row["id"]."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
        <a href='item.php?action=delete&itemid=".$row["id"]."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a> ";
        if($row['approve']==0){
          echo "<a 
          href='item.php?action=approve&itemid="
          .$row["id"].
          "' class='btn btn-info activate'><i class='fa fa-check'></i>Approve</a>";
        }
        echo
         "</td>";
         echo "</tr>";
      }
      ?>
          </table>
  </div>
<a href='item.php?action=add' class="btn btn-primary"><i class="fa fa-plus"></i>New Item</a>
</div>
    <?php
      }else{
        echo "<div class='container'>";
        echo "<div class='nice'>There is no items to show</div>";
        echo "<a href='item.php?action=add' class='btn btn-primary'><i class='fa fa-plus'></i>New Item</a>";
       echo "</div>";
      }

    }elseif($do=="add"){
        echo "welcome to add page";
        ?>
     
<h1 class="text-center">
     Add new Item
      </h1>
      <div class="container item">
        <form class="form-horizontal" action="?action=insert" method="POST">
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="name" class="form-control" required="required"  
                placeholder="Name of the item"/>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="description" class="form-control" placeholder="Description of the item"/>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Price</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="price" class="form-control" required="required"  placeholder="Price of the item"/>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Country</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="country" class="form-control" required="required"  placeholder="Country of the item"/>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Status</label>
            <div class="col-sm-10 col-md-4">
                <select name="status">
                    <option value="0">....</option>
                    <option value="1">New</option>
                    <option value="2">Like New</option>
                    <option value="3">Used</option>
                    <option value="4">Very old</option>
                </select>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Member</label>
            <div class="col-sm-10 col-md-4">
                <select class ="form-control"name="member">
                    <option value="0">....</option>
                    <?php 
                    $allmem=getall('*','users','','','userid');
                    
                    foreach($allmem as $us){
                        echo "<option value='".$us['userid']."'>".$us['uysername']."</option>";
                    }
                    ?>
                </select>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Category</label>
            <div class="col-sm-10 col-md-4">
                <select class ="form-control"name="category">
                    <option value="0">....</option>
                    <?php
                    $allcata=getall('*','category','where parent=0','','id'); 
                    
                    foreach($allcata as $cat){
                        echo "<option value='".$cat['id']."'>".$cat['name']."</option>";
                        $childcat= getall('*','category',"WHERE parent={$cat['id']}",'','id',"ASC");
                        foreach($childcat as $ccat){
                          echo "<option value='".$ccat['id']."'>----".$ccat['name']."  =>  ".$cat['name']."</option>";

                        }
                    }
                    ?>
                </select>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Tags</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="tags" 
                class="form-control" placeholder="Separate Tags with comma (,)"/>
            </div>
          </div>
          <div class="form-group ">
            <div class="icol-sm-offset-2 col-sm-10">
                <input type="submit" value="Add Item" class="btn btn-primary btn-sm"/>
            </div>
          </div>
         </form>
       </div>
     


    <?php
    }elseif($do=="insert"){
 
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            echo "<h1 class='text-center'>Insert Item</h1>";
            echo "<div class='container'>";
           
            $name=$_POST["name"];
            $des=$_POST["description"];
            $price=$_POST["price"];
            $country=$_POST["country"];
            $status=$_POST["status"];
            $member=$_POST["member"];
            $category=$_POST["category"];
            $tags=$_POST["tags"];
            $formerror=array();
            
            
            if(empty($name)){
             $formerror[]="name mustnt be <strong>empty</strong>";
             
            }
            if(empty($des)){
             $formerror[]="Description mustnt be<strong> empty</strong>";
             
            }
            if(empty($price)){
             $formerror[]="price mustnt be<strong> empty</strong>";
             
            }
            if(empty($country)){
                $formerror[]="country mustnt be<strong> empty</strong>";
                
               }
            if($status==0){
             $formerror[]="must choose <strong>status</strong>";
       
            }
            if($member==0){
                $formerror[]="must choose <strong>member</strong>";
          
               }
            if($category==0){
                $formerror[]="must choose <strong>category</strong>";
          
               }
            foreach($formerror as $error){
             echo "<div class='alert alert-danger'>".$error ."</div>";
            }
     
            if(empty($formerror)){
     
           
     
           
     
            $stmt=$con->prepare("INSERT INTO 
            items(name,description,price,adddate,country,status,catid,memberid,tags) 
            VALUES(:zname,:zdes,:zprice,now(),:zcountry,:zstat,:zcat,:zmember,:ztags)");
            $stmt->execute(array(
            "zname" =>$name,
            "zdes" =>$des,
            "zprice" =>$price,
            "zcountry" =>$country,
            "zstat" =>$status,
            "zcat" =>$category,
            "zmember" => $member,
            "ztags" => $tags
             ));
            $msg = "<div class ='alert alert-success'>". $stmt->rowCount()."Record inserted </div>";
            redirect($msg,"back");
           
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
      $itemid=isset($_GET["itemid"])&& is_numeric($_GET["itemid"])?intval($_GET["itemid"]) :0;


$stmt=$con->prepare("SELECT 
                           *
                        FROM 
                              items 
                        WHERE 
                           id= ?
                        ");
    $stmt->execute(array($_GET["itemid"]));
    $item=$stmt->fetch();
    $count = $stmt->rowcount();
  if($count>0){

      ?>
           
<h1 class="text-center">
     Edit Item
      </h1>
      <div class="container item">
        <form class="form-horizontal" action="?action=update" method="POST">
        <input type="hidden" name="itemid" value="<?php echo $itemid ?>"/>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="name" class="form-control" required="required"  placeholder="Name of the item" value="<?php echo $item['name']?>"/>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="description" class="form-control" placeholder="Description of the item"value="<?php echo $item['description']?>"/>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Price</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="price" class="form-control" required="required"  placeholder="Price of the item"value="<?php echo $item['price']?>"/>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Country</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="country" class="form-control" required="required"  
                placeholder="Country of the item"value="<?php echo $item['country']?>"/>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Status</label>
            <div class="col-sm-10 col-md-4">
                <select name="status">
                   
                    <option value="1" <?php if($item["status"]==1){echo 'selected';}?>>New</option>
                    <option value="2"  <?php if($item["status"]==2){echo 'selected';}?>>Like New</option>
                    <option value="3"  <?php if($item["status"]==3){echo 'selected';}?>>Used</option>
                    <option value="4"  <?php if($item["status"]==4){echo 'selected';}?>>Very old</option>
                </select>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Member</label>
            <div class="col-sm-10 col-md-4">
                <select class ="form-control"name="member">
                  
                    <?php 
                    $stmt=$con->prepare("SELECT * FROM users");
                    $stmt->execute();
                    $user=$stmt->fetchAll();
                    foreach($user as $us){
                        echo "<option value='".$us['userid']."'";
                         if($item["memberid"]==$us['userid']){echo 'selected';}
                        echo ">".$us['uysername']."</option>";
                    }
                    ?>
                </select>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Category</label>
            <div class="col-sm-10 col-md-4">
                <select class ="form-control"name="category">
                   
                    <?php 
                    $stmt2=$con->prepare("SELECT * FROM category");
                    $stmt2->execute();
                    $category=$stmt2->fetchAll();
                    foreach($category as $cat){
                        echo "<option value='".$cat['id']."'";
                        if($item["catid"]==$cat['id']){echo 'selected';}
                        echo ">".$cat['name']."</option>";
                    }
                    ?>
                </select>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Tags</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="tags" 
                class="form-control" placeholder="Separate Tags with comma (,)"
                value='<?php echo $item['tags']?>'/>
            </div>
          </div>
          <div class="form-group ">
            <div class="icol-sm-offset-2 col-sm-10">
                <input type="submit" value="Save Item" class="btn btn-primary btn-sm"/>
            </div>
          </div>
         </form>

         <?php
         $stmt=$con->prepare("SELECT 
                             comments.*,users.uysername AS username
                            FROM
                            comments
                           
                            INNER JOIN users on users.userid=comments.user_id
                            where item_id=? ");
      $stmt->execute(array($itemid));
      $rows=$stmt->fetchAll();
      if(!empty($rows)){
      ?>
<h1 class="text-center">Manage [ <?php echo $item['name']?> ] Comments</h1>

  <div class="table-responsive">
    <table class="main-table text-center table table-bordered">
      <tr>
       
        <td>Comment</td>
        
        <td>User Name</td>
        <td>Added Date</td>
        <td>Control</td>
        
      </tr>
      <?php
      foreach($rows as $row){
        echo "<tr>";
        
         echo"<td>".$row['comment']."</td>";
       
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
   <?php }
   
   ?>
</div>
       </div>
     
 
      
   
<?php       
    }else{
      echo "<div class='container'>";
      $tmsg = "<div class ='alert alert-danger'>there is no id </div>";
      redirect($tmsg);
      echo "</div>";
  }


    }elseif($do=="update"){
      echo "<h1 class='text-center'>Update Item</h1>";
  echo "<div class='container'>";
      if($_SERVER["REQUEST_METHOD"]=="POST"){
       $id=$_POST["itemid"];
       $name=$_POST["name"];
       $des=$_POST["description"];
       $price=$_POST["price"];
       $coun=$_POST["country"];
       $status=$_POST["status"];
       $member=$_POST["member"];
       $cat=$_POST["category"];
       $tags=$_POST["tags"];
       $formerror=array();
            
            
            if(empty($name)){
             $formerror[]="name mustnt be <strong>empty</strong>";
             
            }
            if(empty($des)){
             $formerror[]="Description mustnt be<strong> empty</strong>";
             
            }
            if(empty($price)){
             $formerror[]="price mustnt be<strong> empty</strong>";
             
            }
            if(empty($coun)){
                $formerror[]="country mustnt be<strong> empty</strong>";
                
               }
            if($status==0){
             $formerror[]="must choose <strong>status</strong>";
       
            }
            if($member==0){
                $formerror[]="must choose <strong>member</strong>";
          
               }
            if($cat==0){
                $formerror[]="must choose <strong>category</strong>";
          
               }
            foreach($formerror as $error){
             echo "<div class='alert alert-danger'>".$error ."</div>";
            }
     
       if(empty($formerror)){
       $stmt = $con->prepare("UPDATE 
                                  items 
                              SET 
                                 name =?
                                ,description=?
                                ,price=?
                                ,country=?
                                ,status=?
                                ,catid=?
                                ,memberid=? 
                                ,tags=?   
                              WHERE 
                                 id=?");
       $stmt->execute(array($name,$des,$price,$coun,$status,$cat,$member,$tags,$id));

       $msg="<div class ='alert alert-success'>". $stmt->rowCount()."Record updated </div>";
        redirect($msg,'back',4);
      }
      }else{
        $msg= "<div class='alert alert-danger'>sorry</div>";
        redirect($msg);
        
      }
      echo "</div";

    }elseif($do=="delete"){
      echo "<h1 class='text-center'>Delete Item</h1>";
      echo "<div class='container'>";
    $item=isset($_GET["itemid"])&& is_numeric($_GET["itemid"])?intval($_GET["itemid"]) :0;
    
    $stmt=$con->prepare("SELECT 
                               *
                            FROM 
                                  items 
                            WHERE 
                               id= ?
                             LIMIT 1");
    $chok=check('id','items',$item);
      if($chok>0){
        $stmt=$con->prepare("DELETE FROM items WHERE id=:itemid");
        $stmt->bindParam(":itemid",$item);
        $stmt->execute();
        $msg= "<div class ='alert alert-success'>". $stmt->rowCount()."Record Deleted </div>";
        redirect($msg,"back");
      }else{
        $msg= "<div class='alert alert-danger'>this id isnot exist</div>";
        redirect($msg);
      }
      echo "</div"; 
    }elseif($do=="approve"){
      echo "<h1 class='text-center'>Approve Item</h1>";
      echo "<div class='container'>";
    $item=isset($_GET["itemid"])&& is_numeric($_GET["itemid"])?intval($_GET["itemid"]) :0;
    
    $stmt=$con->prepare("SELECT 
                               *
                            FROM 
                                  items
                            WHERE 
                               id= ?
                             LIMIT 1");
    $chok=check('id','items',$item);
      if($chok>0){
        $stmt=$con->prepare("UPDATE items SET approve=1 WHERE id=?");
        
        $stmt->execute(array($item));
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
ob_end_flush();