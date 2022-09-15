<?php 
session_start();
include "int.php"; ?>
<div class="container">
    
    <?php
    if(isset($_GET["name"])){
        $tag=$_GET["name"];
       ?>
        <h1 class="text-center"><?php echo $tag ?></h1>
        
    <div class="row">
        <?php
       
          $tagitem=getall("*","items","WHERE tags like '%$tag%'","AND approve=1","id");
          foreach ($tagitem as $c){
          echo "<div class='col-sm-6 col-md-3 '>";
          echo "<div class='thumbnail item-box'>";
          echo "<span class='price-tag'>$".$c['price']."</span>";
          echo "<img class='img-responsive' src='img.png' alt=''/>";
          echo "<div class='caption'>";
          echo "<h3><a href='item.php?itemid=".$c['id']."'>".$c['name']."</a></h3>";
          echo "<p>".$c['description']."</p>";
          echo "<div class='date'>".$c['adddate']."</div>";
          echo "</div></div></div>";
                         }
        }else{
            echo "<div class='alert alert-danger'>You must enter tag name </div>";
        }
        ?>
        </div>
</div>


<?php include $tpl."footer.php"; ?>