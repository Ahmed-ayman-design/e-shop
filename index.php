<?php
ob_start();
   session_start();
   $pagetitle="Homepage";
include "int.php";
?>
<div class="container">
    <!-- <h1 class="text-center"><?php echo str_replace('-',' ',$_GET['name']) ?></h1> -->
    <div class="row">
    <?php
    $all=getall('*','items','WHERE approve=1','','id');
         //  $item=getitem('catid',$_GET['id']);
          foreach ($all as $c){
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
        ?>
        </div>
</div>
<?php
include $tpl."footer.php";
ob_end_flush();
?>