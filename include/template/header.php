
<! DOCTTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title> <?php gettitle()?></title>
        <link rel="stylesheet" href= "<?php echo $css?>bootstrap.min.css"/>
        <link rel="stylesheet" href="<?php echo $css?>all.min.css"/>
        <link rel="stylesheet" href="<?php echo $css?>front.css"/>
        <link rel="stylesheet" href="<?php echo $css?>jquery-ui.css"/>
        <link rel="stylesheet" href="<?php echo $css?>jquery.selectBoxIt.css"/>
        <link rel="https://code.jquery.com/jquery-1.12.1.js" integrity="sha256-VuhDpmsr9xiKwvTIHfYWCIQ84US9WqZsLfR4P7qF6O8=" crossorigin="anonymous"/>
        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
</head>
<body>
  <div class="upperbar">
    <div class="container">
      <?php
      
   
      if(isset($_SESSION['user'])){?>
      <img class="my-img img-thumbnail img-circle" src='img.png' alt=''/>
      <div class="btn-group text-right my-info ">
      
<span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
  <?php echo $sessionuser ?>
  <span class="caret"></span>
  </span>
  <ul class="dropdown-menu">
<li><a href="profile.php">My Profile</a></li>
<li><a href="newad.php">New Item</a></li>
<li><a href="profile.php#my-ads">My Items</a></li>
<li><a href="logout.php">Logout</a></li>
  </ui>


      </div>
      <?php
          // echo "welcome " .$sessionuser ."<br>";
          // echo "<a href='profile.php'>My Profile</a>";
          // echo " - <a href='newad.php'>New Item</a>";
          // echo " - <a href='logout.php'>Logout</a>"; 
        if (checkuserstatus($sessionuser)==1){ 
        echo " your membership need to activiate by admin";
        }
      }else{
      ?>
    <a href="login.php">
      <span class="pull-right">
        Login/Signup
      </span>
    </a>
  <?php }?>
   </div>
  </div>
  
  
<nav class="navbar navbar-inverse navbar-expand-lg bg">
  <div class="container">
    
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand " href="index.php">Home</a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
     <ul class="nav navbar-nav navbar-right">
        <?php

          $cat=getall('*','category','WHERE parent=0','','id','ASC');
          foreach ($cat as $c){
          echo "<li><a href='category.php?id=".$c["id"]."&name=".str_replace(' ','-',$c['name'])."'>".$c["name"]."</a></li>";
                         }
        ?>
     </ul>
      
    </div>
      </div>
  </div>
</nav>