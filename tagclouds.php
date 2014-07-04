<?php 
require_once "config/functions.inc.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Home page</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>

</head>

<body>
<div id="wrapper">
<!-- HEADER -->
<?php include "header.middle.inc.php"; ?>
  <div class="content-container">
    <?php include "header.top.inc.php"; ?>
<!-- TOP SPOTLIGHT 1 -->
<div id="ja-topsl" class="wrap">
  <div class="main">
    <div class="inner">
        <div class="jm-product-list latest clearfix">
			<div class="headInner">
				<h4><span class="first-word"><?=($_GET['cat_id']!='')?Get_Single_Field("category_master","Category_Name","Category_Id","$_REQUEST[cat_id]"):TagClouds;?></span></h4>
     		</div>
            <div class="form-container notes">
			   <style type="text/css">
					.tag_cloud {padding: 5px; text-decoration: none; font-family: verdana; }
					.tag_cloud:link { color: #9FCCF5; }
					.tag_cloud:visited { color: #9FCCF5; }
					.tag_cloud:hover { color: #fff; background: #1E3E64; }
					.tag_cloud:active { color: #9FCCF5; background: #1E3E64; }
				</style> 
				<table width="100%" cellspacing="0" cellpadding="0">
					<?php
					$sqlCloud = "SELECT * FROM tags ORDER BY tag_name";
					$resultCloud = mysql_query($sqlCloud);
					
					if(mysql_num_rows($resultCloud)>0)
					{
					?>
					<tr>
						<td width="90%" valign="top">
							<?php 
							function tag_info() {
							$resultCloudes = mysql_query("SELECT COUNT(*) as tagcount, tag_name FROM tags GROUP BY tag_name ORDER BY RAND(),tagcount DESC LIMIT 0,150");
							while($rowCloudes = mysql_fetch_array($resultCloudes)) {
							
							$arr[$rowCloudes['tag_name']] = $rowCloudes['tagcount'];
							}
							ksort($arr);
							return $arr;
							}
							
							function tag_cloud() {
							
							$min_size = 10;
							$max_size = 20;
							
							$tags = tag_info();
							
							$minimum_count = min(array_values($tags));
							$maximum_count = max(array_values($tags));
							
							$spread = $maximum_count - $minimum_count;
							
							if($spread == 0) {
							$spread = 1;
							}
							
							$cloud_html = '';
							$cloud_tags = array();
							
							foreach ($tags as $tag => $count) {
							$size = $min_size + ($count - $minimum_count)
							* ($max_size - $min_size) / $spread;
							//if($count>6)
						   // {
							$cloud_tags[] = '<a style="font-size: '. floor($size) . 'px'
							. '" class="tag_cloud" href="http://mussino.com/search.php?q=' . str_replace('%20','',$tag)
							. '" title="\'' . str_replace('%20','',$tag) . '\' returned a count of ' . $count . '">'
							. htmlspecialchars(stripslashes(str_replace('%20','',$tag))) . '</a>';
						   // }
							}
							$cloud_html = join("\n", $cloud_tags) . "\n";
							return $cloud_html;
							
							}
							
							?>
							<div id="wrapper">
								<?php 
								if(mysql_num_rows($resultCloud)>0)
								{
								echo tag_cloud(); 
								}
								?>
							</div> 
						</td>
					</tr>
					<?php } ?>
				</table>
            </div>
        </div>  
    </div>
  </div>
</div>


<?php if($_SESSION['SESS_ID']!='') { ?>
<?php include"footer-div.inc.php"; ?>
<?php } ?>
</div>
</div>
<!-- FOOTER -->
<?php include "footer.inc.php"; ?>
<!-- //FOOTER -->

</body>
</html>