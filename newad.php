<?php
   session_start();
   $pagetitle="Create New Item";
include "int.php";
if(isset($_SESSION['user'])){
$getuser=$con->prepare("SELECT * FROM users WHERE uysername=?");
$getuser->execute(array($sessionuser));
$info=$getuser->fetch();

   // echo $sessionuser;
if($_SERVER['REQUEST_METHOD']=='POST'){
   // echo $_POST["name"]."<br>";
   // echo $_POST["description"]."<br>";
   // echo $_POST["price"]."<br>";
$formerrors=array();
$title=filter_var($_POST['name'],FILTER_SANITIZE_STRING);
$desc=filter_var($_POST['description'],FILTER_SANITIZE_STRING);
$price=filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
$coun=filter_var($_POST['country'],FILTER_SANITIZE_STRING);
$stat=filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
$cat=filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
$tags=filter_var($_POST['tags'],FILTER_SANITIZE_STRING);
// echo $title;
// echo $desc;
// echo $price;
// echo $coun;
// echo $stat;
// echo $cat;
if(strlen($title)<3){
   $formerrors[]="Item Name must be greater than 2";
}
if(strlen($desc)<10){
   $formerrors[]="Item Description must be greater than 9";
}
if(strlen($coun)<2){
   $formerrors[]="Item Country must be greater than 1";
}
if(empty($price)){
   $formerrors[]="Item Price must not be empty";
}
if(empty($stat)){
   $formerrors[]="Item Status must not be empty";
}
if(empty($cat)){
   $formerrors[]="Item Category must not be empty";
}
if(empty($formerror)){
     
           
     
           
     
  $stmt=$con->prepare("INSERT INTO 
  items(name,description,price,adddate,country,status,catid,memberid,tags) 
  VALUES(:zname,:zdes,:zprice,now(),:zcountry,:zstat,:zcat,:zmember,:ztags)");
  $stmt->execute(array(
  "zname" =>$title,
  "zdes" =>$desc,
  "zprice" =>$price,
  "zcountry" =>$coun,
  "zstat" =>$stat,
  "zcat" =>$cat,
  "zmember" => $_SESSION['uid'],
  "ztags" => $tags,
   ));
  // $msg = "<div class ='alert alert-success'>". $stmt->rowCount()."Record inserted </div>";
  // redirect($msg,"back");
 if($stmt){
  $sucmsg= "item added";
 }
}

}


?>
<h1 class="text-center"> <?php echo  $pagetitle;?></h1>
<div class="createads block">
 <div class="container">
   <div class="panel panel-primary">
      <div class="panel-heading"><?php echo $pagetitle;?></div>
         <div class="panel-body">
           <div class="row">
            <div class="col-md-8">
                
           <!-- <h1 class="text-center">
               Add new Item
                   </h1>
      <div class="container item"> -->
        <form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
          <div class="form-group form-group-lg">
            <label class="col-sm-3 control-label">Name</label>
            <div class="col-sm-10 col-md-9">
                <input 
                pattern=".{3,}"
                title="This field requires at least 3 chars"
                type="text" name="name" class="form-control live" 
                  placeholder="Name of the item"
                data-class=".live-title"
                required/>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-3 control-label">Description</label>
            <div class="col-sm-10 col-md-9">
                <input 
                pattern=".{6,}"
                title="This field requires at least 6 chars"
                type="text" name="description" class="form-control live" 
                placeholder="Description of the item"
                data-class=".live-desc"
                required
                />
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-3 control-label">Price</label>
            <div class="col-sm-10 col-md-9">
                <input type="text" name="price" class="form-control live" 
                  placeholder="Price of the item"
                data-class=".live-pri"
                required/>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-3 control-label">Country</label>
            <div class="col-sm-10 col-md-9">
                <input 
                type="text" name="country" class="form-control"   
                placeholder="Country of the item" required/>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-3 control-label">Status</label>
            <div class="col-sm-10 col-md-9">
                <select name="status" required>
                    <option value="0">....</option>
                    <option value="1">New</option>
                    <option value="2">Like New</option>
                    <option value="3">Used</option>
                    <option value="4">Very old</option>
                </select>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-3 control-label">Category</label>
            <div class="col-sm-10 col-md-9">
                <select class ="form-control"name="category" required>
                    <option value="0">....</option>
                    <?php 
                    $all=getall('*','category','','','id');
                   
                    foreach($all as $cat){
                        echo "<option value='".$cat['id']."'>".$cat['name']."</option>";
                    }
                    ?>
                </select>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <label class="col-sm-3 control-label">Tags</label>
            <div class="col-sm-10 col-md-9">
                <input type="text" name="tags" 
                class="form-control" placeholder="Separate Tags with comma (,)"/>
            </div>
          </div>
          <div class="form-group form-group-lg">
            <div class="icol-sm-offset-3 col-sm-9">
                <input type="submit" value="Add Item" class="btn btn-primary btn-sm"/>
            </div>
          </div>
         </form>
       <!-- </div> -->
     

         </div>
         <div class="col-md-4">
           <div class='thumbnail item-box live-preview'>
            <span class='price-tag '>
               $<span class="live-pri">0</span>
            </span>
             <img class='img-responsive' src='img.png' alt=''/>
              <div class='caption'>
                 <h3 class="live-title">mobile</h3>
                   <p class="live-desc">hi </p>
              </div>
            </div>
         </div>
                         
        </div>
        <!-- start login errors -->
        <?php
        if(!empty($formerrors)){
         foreach($formerrors as $er){
            echo "<div class='alert alert-danger'>".$er."</div>";
         }
        }
        if(isset($sucmsg)){
          echo "<div class='alert alert-success'>".$sucmsg."</div>";
      }
        
        ?>

       </div>
      </div>
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