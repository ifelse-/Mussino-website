<?php $pageName = basename($_SERVER['PHP_SELF']);?>
    <div class="page-top">
      <div class="page-top_col-1 fl">
        <h1><a href="#">Your Administration Area</a></h1>
      </div>
      <div class="page-top_col-2 fr">
        <ul>
         <li><img src="images/admin.png" border="0" align="absmiddle" /> <span class="bold-1">(<?=$_SESSION["FIRST_NAME"].' '.$_SESSION["LAST_NAME"]?>)</span></li>
          <li class="small-links">Last Visited <span class="bold-1"><?=$_SESSION["LAST_VISITED"]?></span><br /><a href="logout.php"><img src="images/tm_logout.png" border="0" /><br />Log out</a></li>
          <li class="small-links"></li>
        </ul>
      </div>
      <div class="cl"></div>
    </div>
    <div class="top-navigation">
      <ul>
        <li <?php if($pageName=='dashboard.php') { ?> class="top-nav-selected" <?php } ?>><a href="dashboard.php"><span><span>Dashboard</span></span></a></li>
        <li <?php if($pageName=='admin-profile.php') { ?> class="top-nav-selected" <?php } ?>><a href="admin-profile.php"><span><span>Admin Password</span></span></a></li>
        
      </ul>
    </div>
