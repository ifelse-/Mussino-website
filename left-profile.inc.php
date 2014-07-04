<?php 
	if($_SESSION['SESS_ACCOUNT_TYPE']=='Musician')
	{		
		if($pageName!='product-list.php')
		{
			?>
			<div class="music-Btn3"><a href="<?=SITE_WS_PATH?>/product-list.php" title="Sample link"><span>Session History</span></a></div>
			<?php
		}
		if($pageName!='product.php')
		{
			?>
			<div class="music-Btn3"><a href="<?=SITE_WS_PATH?>/product.php" title="Sample link"><span>Create Session</span></a></div>
			<?php 
		} 
		if($pageName!='music-store-list.php') 
		{ 
			?>
			<div class="music-Btn3"><a href="<?=SITE_WS_PATH?>/music-store-list.php" title="Sample link"><span>My Music Store</span></a></div>
			<?php 
		}
		if($pageName!='music-store.php')
		{
			?>
			<div class="music-Btn3"><a href="<?=SITE_WS_PATH?>/music-store.php" title="Sample link"><span>Sell Beats</span></a></div>
			<?php 
		} 
	}
	if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist') 
	{ 
		?>
		<div class="music-Btn3"><a href="<?=SITE_WS_PATH?>/my-history.php" title="Sample link"><span>History</span></a></div>
		<div class="music-Btn3"><a href="<?=SITE_WS_PATH?>/my-archive-history.php" title="Sample link"><span>Archive History</span></a></div>
		<?php
			  if($email_notification_settings == "yes"){
			  ?>
		<div class="music-Btn3"><a href="<?=SITE_WS_PATH?>/genre_mail_setting.php" title="Sample link"><span>Session notification</span></a></div>
		<?php 
		}
		if($pageName=='artist-music-store-list.php' || $pageName=='my-history.php' || $pageName=='my-archive-history.php') 
		{ 
			?>
			<div class="music-Btn3"><a href="<?=SITE_WS_PATH?>/artist-music-store.php" title="Sample link"><span>Create Music Store</span></a></div>
			<?php 
		} 
		if($pageName=='artist-music-store.php' || $pageName=='my-history.php' || $pageName=='my-archive-history.php') 
		{ 
			?>
			<div class="music-Btn3"><a href="<?=SITE_WS_PATH?>/artist-music-store-list.php" title="Sample link"><span>My Music Store</span></a></div>
			<?php 
		} 
	} 
	?> 

<?php if($pageName!='change-image.php') { ?> 
<div class="music-Btn3"><a href="change-image.php" title="Sample link"><span>Change Image</span></a></div>
<?php } ?>
<?php if($pageName!='bg-image.php') { ?> 
<div class="music-Btn3"><a href="bg-image.php" title="Background Image"><span>Bg Image</span></a></div>
<?php } ?>
<?php if($pageName!='edit-profile.php') { ?>
<div class="music-Btn3"><a href="edit-profile.php" title="Sample link"><span>Profile Edit</span></a></div>
<?php } ?>
<?php if($pageName!='change-password.php') { ?>
<div class="music-Btn3"><a href="change-password.php" title="Sample link"><span>New Password</span></a></div>
<?php } ?>