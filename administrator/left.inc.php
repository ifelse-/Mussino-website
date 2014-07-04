<?php
$pageName = basename($_SERVER['PHP_SELF']);
$left_sql="select * from member_account_master where  Member_Account_Id ='".$_SESSION["ID"]."'";
$left_result=executeQuery($left_sql);
$left_line=mysql_fetch_array($left_result);
?>

<ul>
  
  <?php if($left_line['Account_Type']=='ADMIN') { ?>
  <li class="<?=($pageName=='country-list.php' || $pageName=='country.php')?'left-nav-selected':''?>"><a href="country-list.php"><span>Country Management </span></a></li>
  <li class="<?=($pageName=='state-list.php' || $pageName=='state.php')?'left-nav-selected':''?>"><a href="state-list.php"><span>State Management </span></a></li>
  <li class="<?=($pageName=='city-list.php' || $pageName=='city.php')?'left-nav-selected':''?>"><a href="city-list.php"><span>City Management </span></a></li>
  <li class="<?=($pageName=='category-list.php' || $pageName=='category.php')?'left-nav-selected':''?>"><a href="category-list.php"><span>Categories Management </span></a></li>
  <li class="<?=($pageName=='product-list.php' || $pageName=='product.php' )?'left-nav-selected':''?>"><a href="product-list.php"><span>Session Products </span></a></li>
  <li class="<?=($pageName=='unreleased-product-list.php' || $pageName=='unreleased-product.php' )?'left-nav-selected':''?>"><a href="unreleased-product-list.php"><span>Unreleased Products </span></a></li>
  <li class="<?=($pageName=='store-product-list.php' || $pageName=='store-product.php' )?'left-nav-selected':''?>"><a href="store-product-list.php"><span>Music Store Products </span></a></li>
  <li class="<?=($pageName=='winners-list.php' || $pageName=='compose.php' )?'left-nav-selected':''?>"><a href="winners-list.php"><span>Winners Management</span></a></li>
  <li class="<?=($pageName=='winners.php' )?'left-nav-selected':''?>"><a href="winners.php"><span>Session Winners History</span></a></li>
  <li class="<?=($pageName=='notes-history.php')?'left-nav-selected':''?>"><a href="notes-history.php"><span>Notes History</span></a></li>
  <li class="<?=($pageName=='unreleased-history.php')?'left-nav-selected':''?>"><a href="unreleased-history.php"><span>Unreleased Music History</span></a></li>
  <li class="<?=($pageName=='store-history.php')?'left-nav-selected':''?>"><a href="store-history.php"><span>Music Store History</span></a></li>
  <li class="<?=($pageName=='sound-type-list.php' || $pageName=='sound-type.php')?'left-nav-selected':''?>"><a href="sound-type-list.php"><span>Sound Type Management </span></a></li>
  <!--<li class="<?=($pageName=='type-list.php' || $pageName=='type.php')?'left-nav-selected':''?>"><a href="type-list.php"><span>Type Management </span></a></li>-->
  <li class="<?=($pageName=='package-list.php' || $pageName=='package.php')?'left-nav-selected':''?>"><a href="package-list.php"><span>Package Management </span></a></li>
  <li class="<?=($pageName=='membership-upgrade-list.php' || $pageName=='membership-upgrade.php')?'left-nav-selected':''?>"><a href="membership-upgrade-list.php"><span>Membership Upgrade Musician</span></a></li>
  <li class="<?=($pageName=='membership-artist-upgrade-list.php' || $pageName=='membership-artist-upgrade.php')?'left-nav-selected':''?>"><a href="membership-artist-upgrade-list.php"><span>Membership Upgrade Artist</span></a></li>
  <li class="<?=($pageName=='advertise-plan-list.php' || $pageName=='advertise-plan.php')?'left-nav-selected':''?>"><a href="advertise-plan-list.php"><span>Advertise Plan Management </span></a></li>
  <li class="<?=($pageName=='general-setting.php')?'left-nav-selected':''?>"><a href="general-setting.php"><span>General Settings </span></a></li>
  <li class="<?=($pageName=='tax-setting.php')?'left-nav-selected':''?>"><a href="tax-setting.php"><span>Tax Percentage Settings </span></a></li>
  <li class="<?=($pageName=='member-list.php' || $pageName=='member.php')?'left-nav-selected':''?>"><a href="member-list.php"><span>Members Management</span></a></li>
  <li class="<?=($pageName=='news-list.php' || $pageName=='news.php')?'left-nav-selected':''?>"><a href="news-list.php"><span>News Management</span></a></li>
  <li class="<?=($pageName=='newsletter-list.php' || $pageName=='newsletter.php' || $pageName=='newsletter-mail.php')?'left-nav-selected':''?>"><a href="newsletter-list.php"><span>Newsletters Management</span></a></li>
  
 
  <li class="<?=($pageName=='agent-list.php' || $pageName=='agent.php' || $pageName=='commision.php')?'left-nav-selected':''?>"><a href="agent-list.php"><span>Agent Management </span></a></li>
  
  <li class="<?=($pageName=='video-list.php' || $pageName=='video.php' )?'left-nav-selected':''?>"><a href="video-list.php"><span>Index Video Management </span></a></li>
  <li class="<?=($pageName=='default-video-list.php' || $pageName=='default-video.php' )?'left-nav-selected':''?>"><a href="default-video-list.php"><span>Default Video Management </span></a></li>
  <li class="<?=($pageName=='content-list.php')?'left-nav-selected':''?>"><a href="content-list.php"><span>Content Management</span></a></li>
  <li class="<?=($pageName=='source-list.php' || $pageName=='source.php')?'left-nav-selected':''?>"><a href="source-list.php"><span>Source Link Management</span></a></li>
  <li class="<?=($pageName=='support-center.php')?'left-nav-selected':''?>"><a href="support-center.php"><span>Support Center Management</span></a></li>
  
  <li class="<?=($pageName=='question-list.php' || $pageName=='question.php')?'left-nav-selected':''?>"><a href="question-list.php"><span>Poll Management</span></a></li>
  <li class="<?=($pageName=='reason-list.php' || $pageName=='reason.php')?'left-nav-selected':''?>"><a href="reason-list.php"><span>Reason Management </span></a></li>
  <!--<li class="<?=($pageName=='upgrade-membership.php')?'left-nav-selected':''?>"><a href="upgrade-membership.php"><span>Upgrade Membership</span></a></li>-->
  <li class="<?=($pageName=='notebook-msg.php')?'left-nav-selected':''?>"><a href="notebook-msg.php"><span>Notebook MSG Management</span></a></li>
  <?php } ?>
  
</ul>



