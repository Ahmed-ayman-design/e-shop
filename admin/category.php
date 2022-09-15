<?php
ob_start("ob_gzhandler");
session_start();
$pagetitle="Categories";
if(isset($_SESSION['username'])){
    
    include "int.php";

    $do=isset($_GET['action'])?$_GET['action']:'manage';
    if($do=="manage"){
      $sort='ASC';
      $sort_array=array('ASC','DESC');
      if(isset($_GET['sort'])&& in_array($_GET['sort'],$sort_array)){

        $sort=$_GET['sort'];
      }
$stmt=$con->prepare("SELECT * FROM category WHERE parent=0 ORDER BY `ordering` $sort");
$stmt->execute();
$cat=$stmt->fetchAll();?>
<h1 class="text-center">Manage Categories</h1>
<div class="container category">
  <div class="panel panel-default">
    <div class="panel-heading">
    
    <i class="fa fa-edit"></i> Manage Categories
      <div class="ordering pull-right">
       <i class="fa fa-sort"></i> Ordering : [
        <a class="<?php if($sort=='ASC'){echo 'active';}?>"href="?sort=ASC">ASC </a>|
        <a class="<?php if($sort=='DESC'){echo 'active';}?>"href="?sort=DESC">DESC </a>
        ]
        <i class="fa fa-eye"></i> View :[ 
        <span class="active" data-view="full">Full</span> |
        <span data-view="classic">Classic</span> 
        ]
      </div>
    </div>
    <div class="panel-body">
      <?php foreach ($cat as $c){
        echo "<div class='cat'>";
         echo"<div class='hidden-btn'>";
           echo "<a href='category.php?action=edit&catid=".$c['id']. "'class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";
           echo "<a href='category.php?action=delete&catid=".$c['id']."' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i>Delete</a>";
         echo "</div>";
         echo "<h3>" .$c["name"]."</h3>";
         echo "<div class='full-view'>";
          echo "<p>"; if($c["description"]==""){echo "This Category has no Description"; }else{echo $c["description"];} echo "</p>";
          if($c["visibility"]==1){echo "<span class='vis'><i class='fa fa-eye'></i> Hidden</span>";}
          if($c["allowcomment"]==1){echo "<span class='com'><i class='fa fa-close'></i> Comment disabled</span>";}
          if($c["allowads"]==1){echo "<span class='adv'><i class='fa fa-close'></i> Ads disabled</span>";}
         
         echo "</div>";
          // sub cat
          $cat=getall('*','category',"WHERE parent={$c['id']}",'','id','ASC');
          if(!empty($cat)){echo "<h4 class='child-head'>Sub-Categories</h4>";
          echo "<ul class='list-unstyled child-cat'>";
            foreach ($cat as $ca){
            echo "<li class='child-link'>
            <a href='category.php?action=edit&catid=".$ca['id']. "'>".$ca["name"]."</a>
            <a href='category.php?action=delete&catid=".$ca['id']."' class='show-delete confirm '>Delete</a>
            
            </li>";
                           }
          echo "</ul>";                 
          
          //  end sub cat
         
        }
        echo "</div>";
        
      echo "<hr>";
    }
      ?>
    </div>
  </div>
  <a class="add-cat btn btn-primary" href="category.php?action=add"><i class="fa fa-plus"></i>Add New Category</a>
</div>
<?php

    }elseif($do=="add"){
        echo "welcome to add page";
        ?>
     
<h1 class="text-center">
     Add new Category
      </h1>
      <div class="container">
        <form class="form-horizontal" action="?action=insert" method="POST">
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10 col-md-4">
            
                <input type="text" name="name" class="form-control" required="required" autocomplete="off" placeholder="Name of the category"/>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="description" class="form-control"  placeholder="Descripe the category"/>
            
              </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Ordering</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="ordering" class="form-control" placeholder="Number to arrange the categories"/>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Parent ? </label>
            <div class="col-sm-10 col-md-4">
                <select type="text" name="parent" class="form-control" placeholder="Number to arrange the categories">
    <option value="0">None</option>
    <?php
   $allcat= getall('*','category','WHERE parent=0','','id',"ASC");
   foreach($allcat as $c){
    echo "<option value=".$c['id'].">".$c['name']."</option>";
   }
    ?>
              </select>           
   </div>
          </div>



          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Visible</label>
            <div class="col-sm-10 col-md-4">
                <div >
                 <input id="vis-yes"type="radio" name="visible" value ="0" checked />
                 <label for="vis-yes">Yes</label>
                </div>
                <div >
                 <input id="vis-no"type="radio" name="visible" value ="1"/>
                 <label for="vis-no">No</label>
                </div>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Allow Commenting</label>
            <div class="col-sm-10 col-md-4">
                <div >
                 <input id="com-yes"type="radio" name="comment" value ="0" checked />
                 <label for="com-yes">Yes</label>
                </div>
                <div >
                 <input id="com-no"type="radio" name="comment" value ="1"/>
                 <label for="com-no">No</label>
                </div>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Allow Ads</label>
            <div class="col-sm-10 col-md-4">
                <div >
                 <input id="ads-yes"type="radio" name="ads" value ="0" checked />
                 <label for="ads-yes">Yes</label>
                </div>
                <div >
                 <input id="ads-no"type="radio" name="ads" value ="1"/>
                 <label for="ads-no">No</label>
                </div>
            </div>
          </div>
          <div class="form-group ">
            <div class="icol-sm-offset-2 col-sm-10">
                <input type="submit" value="Add Category" class="btn btn-primary btn-lg"/>
            </div>
          </div>
         </form>
         </div>
     


    <?php
    }elseif($do=="insert"){
 
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            echo "<h1 class='text-center'>Insert Category</h1>";
            echo "<div class='container'>";
           
            $name=$_POST["name"];
            $des=$_POST["description"];
            $order=$_POST["ordering"];
            $parent=$_POST["parent"];
            $vis=$_POST["visible"];
            $comment=$_POST["comment"];
            $ads=$_POST["ads"];
    
     
           $check=check("name","category",$name);
           if($check==1){
             $msg= "<div class='alert alert-danger'>sorry this category is exist</div>";
             redirect($msg,'back');
           }else{
     
           
     
            $stmt=$con->prepare("INSERT INTO category(name,description,parent,ordering,visibility,allowcomment,allowads) VALUES(:zname,:zdes,:zparent,:zorder,:zvis,:zcom,:zads)");
            $stmt->execute(array(
            "zname" =>$name,
             "zdes" =>$des,
             "zparent" =>$parent,
               "zorder" =>$order,
              "zvis" =>$vis,
              "zcom"=>$comment,
              "zads"=>$ads

             ));

            
            $msg = "<div class ='alert alert-success'>". $stmt->rowCount()."Record inserted </div>";
            redirect($msg,"back");
           }
           }else{
             echo "<div class='container'>";
             echo "sorry";
             $msg="<div class='alert alert-danger'>you can't browse this page</div>";
     
             redirect($msg,'back');
             echo "</div>";
           }
           echo "</div";
    }elseif($do=="edit"){
      $catid=isset($_GET["catid"])&& is_numeric($_GET["catid"])?intval($_GET["catid"]) :0;

$stmt=$con->prepare("SELECT 
                           *
                        FROM 
                              category 
                        WHERE 
                           id= ?
                         ");
    $stmt->execute(array($catid));
    $cat=$stmt->fetch();
    $count = $stmt->rowcount();
  if($count>0){
    
      ?>
         
<h1 class="text-center">
     Edit Category
      </h1>
      <div class="container">
        <form class="form-horizontal" action="?action=update" method="POST">
        <input type="hidden" name="catid" class="form-control" value ="<?php echo $catid?>"autocomplete="off"/>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10 col-md-4">
            
                <input type="text" name="name" class="form-control" required="required" placeholder="Name of the category" value="<?php echo $cat['name']?>" />
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="description" class="form-control"  placeholder="Descripe the category" value="<?php echo $cat['description'];?>"/>
            
              </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Ordering</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="ordering" class="form-control" placeholder="Number to arrange the categories" value="<?php echo $cat['ordering'];?>"/>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Parent ?</label>
            <div class="col-sm-10 col-md-4">
                <select type="text" name="parent" class="form-control" placeholder="Number to arrange the categories">
    <option value="0">None</option>
    <?php
   $allcat= getall('*','category','WHERE parent=0','','id',"ASC");
   foreach($allcat as $t){
    echo "<option value='".$t['id']."'";
    if($cat['parent']==$t['id']){echo 'selected';}

    echo ">".$t['name']."</option>";
   }
    ?>
              </select>           
   </div>
          </div>
          
          
          
          
          
          
          
          
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Visible</label>
            <div class="col-sm-10 col-md-4">
                <div >
                 <input id="vis-yes"type="radio" name="visible" value ="0"<?php if($cat['visibility']==0){echo 'checked';}?> />
                 <label for="vis-yes">Yes</label>
                </div>
                <div >
                 <input id="vis-no"type="radio" name="visible" value ="1"<?php if($cat['visibility']==1){echo 'checked';}?>/>
                 <label for="vis-no">No</label>
                </div>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Allow Commenting</label>
            <div class="col-sm-10 col-md-4">
                <div >
                 <input id="com-yes"type="radio" name="comment" value ="0"<?php if($cat['allowcomment']==0){echo 'checked';}?> />
                 <label for="com-yes">Yes</label>
                </div>
                <div >
                 <input id="com-no"type="radio" name="comment" value ="1"<?php if($cat['allowcomment']==1){echo 'checked';}?>/>
                 <label for="com-no">No</label>
                </div>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Allow Ads</label>
            <div class="col-sm-10 col-md-4">
                <div >
                 <input id="ads-yes"type="radio" name="ads" value ="0"<?php if($cat['allowads']==0){echo 'checked';}?> />
                 <label for="ads-yes">Yes</label>
                </div>
                <div >
                 <input id="ads-no"type="radio" name="ads" value ="1"<?php if($cat['allowads']==1){echo 'checked';}?>/>
                 <label for="ads-no">No</label>
                </div>
            </div>
          </div>
          <div class="form-group ">
            <div class="icol-sm-offset-2 col-sm-10">
                <input type="submit" value="Save Category" class="btn btn-primary btn-lg"/>
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
      echo "<h1 class='text-center'>Update Category</h1>";
      echo "<div class='container'>";
          if($_SERVER["REQUEST_METHOD"]=="POST"){
           $id=$_POST["catid"];
           $name=$_POST["name"];
           $des=$_POST["description"];
           $order=$_POST["ordering"];
           $parent=$_POST["parent"];
           $visa=$_POST["visible"];
           $com=$_POST["comment"];
           $ads=$_POST["ads"];
          
    
           $stmt = $con->prepare("UPDATE 
           category 
           SET name =?,description=?,ordering=?,parent=?,visibility=?,allowcomment=?,allowads=? 
           WHERE id=?");
           $stmt->execute(array($name,$des,$order,$parent,$visa,$com,$ads,$id));
    
           $msg="<div class ='alert alert-success'>". $stmt->rowCount()."Record updated </div>";
            redirect($msg,'back',4);
          
          }else{
            $msg= "<div class='alert alert-danger'>sorry</div>";
            redirect($msg);
            
          }
          echo "</div";
    }elseif($do=="delete"){
      echo "<h1 class='text-center'>Delete Category</h1>";
      echo "<div class='container'>";
    $catid=isset($_GET["catid"])&& is_numeric($_GET["catid"])?intval($_GET["catid"]) :0;
    
    $stmt=$con->prepare("SELECT 
                               *
                            FROM 
                                  category 
                            WHERE 
                               id= ?
                             LIMIT 1");
    $chok=check('id','category',$catid);
       
      if($chok>0){
        $stmt=$con->prepare("DELETE FROM category WHERE id=:zid");
        $stmt->bindParam(":zid",$catid);
        $stmt->execute();
        $msg= "<div class ='alert alert-success'>". $stmt->rowCount()."Record Deleted </div>";
        redirect($msg,'back');
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