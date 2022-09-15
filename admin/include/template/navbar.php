<nav class="navbar navbar-inverse navbar-expand-lg bg">
  <div class="container">
    
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand " href="dashboard.php"><?php echo lang("Home Admin")?></a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
     <ul class="nav navbar-nav">
        <li><a href="category.php"><?php echo lang("CATEGORIES")?></a></li>
        <li><a href="item.php"><?php echo lang("ITEMS")?></a></li>
        <li><a href="member.php"><?php echo lang("MEMBERS")?></a></li>
        <li><a href="comment.php"><?php echo lang("COMMENTS")?></a></li>
        <li><a href="#"><?php echo lang("STATISTIC")?></a></li>
        <li><a href="#"><?php echo lang("LOGS")?></a></li>
     </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">

          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ahmed <span></span></a>
          <ul class="dropdown-menu">
            <li><a href="../index.php">Visit The Shop</a></li>
            <li><a href="member.php?action=edit&userid=<?php echo $_SESSION['ID']?>">Edit Profile</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
      </div>
  </div>
</nav>