<?php
	define("auth", true);//define a variable to prevent users from direct going to our files
	include_once 'config/config.php';//include our session start and db connections
	include('vote-system.php');//core file for voting and commenting
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Strict//EN">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<title>Vote Script</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script type="text/javascript" src="js/vote_submit.js"></script>
</head>
<body style="width:964px;background-color:#ffffff;">
	<h1 style="text-align:center;">Vote Script</h1>
	<p>nec, aliquam eget dolor. Vivamus molestie convallis elit, in fermentum massa facilisis at. Pellentesque sed dui 
		lectus. Ut vel erat vehicula arcu scelerisque porttitor eget tristique dolor. Aliquam et elementum velit.<br />
		<?php getItemVotes('221');//show the vote buttons and allow users to comment ?>
	</p>
	<p>egestas. Aenean lorem ante, malesuada quis posuere ac, bibendum id justo. Donec mi nulla, ornare lacinia pellentesque 
		id, lacinia eget libero. Mauris lacinia dapibus tempus. Sed aliquet, justo id semper faucibus, neque massa scelerisque
		odio, eget venenatis urna sem quis neque.<br />
		<?php getItemVotes('t2'); ?>
	</p>
	<p>sapien, in rhoncus est congue ut. Aliquam turpis justo, placerat et scelerisque sed, scelerisque non neque. 
		In imperdiet tellus sed augue mattis egestas. Integer sagittis pellentesque sapien, interdum aliquam sapien 
		vulputate in. Sed fermentum rutrum velit, luctus sollicitudin turpis tincidunt a.<br />
		<?php getItemVotes('t3'); ?>
	</p>
	<p>quam eu pharetra euismod, sem felis rutrum nibh, condimentum volutpat felis nisl eu nisi. Suspendisse lacus 
		odio, eleifend quis porta non, adipiscing ut felis. Quisque fringilla volutpat massa, gravida convallis nunc 
		eleifend vel. <br />
		<?php getItemVotes('t4'); ?>
	</p>
	<p>quam eu pharetra euismod, sem felis rutrum nibh, condimentum volutpat felis nisl eu nisi. Suspendisse lacus 
		odio, eleifend quis porta non, adipiscing ut felis. Quisque fringilla volutpat massa, gravida convallis nunc 
		eleifend vel. <br />
		<?php getItemVotes('t5'); ?>
	</p>
	<p>quam eu pharetra euismod, sem felis rutrum nibh, condimentum volutpat felis nisl eu nisi. Suspendisse lacus 
		odio, eleifend quis porta non, adipiscing ut felis. Quisque fringilla volutpat massa, gravida convallis nunc 
		eleifend vel. <br />
		<?php getItemVotes('t6'); ?>
	</p>
	<p>quam eu pharetra euismod, sem felis rutrum nibh, condimentum volutpat felis nisl eu nisi. Suspendisse lacus 
		odio, eleifend quis porta non, adipiscing ut felis. Quisque fringilla volutpat massa, gravida convallis nunc 
		eleifend vel. <br />
		<?php getItemVotes('t7'); ?>
	</p>
	<p>quam eu pharetra euismod, sem felis rutrum nibh, condimentum volutpat felis nisl eu nisi. Suspendisse lacus 
		odio, eleifend quis porta non, adipiscing ut felis. Quisque fringilla volutpat massa, gravida convallis nunc 
		eleifend vel. <br />
		<?php getItemVotes('t8'); ?>
	</p>
	<p>quam eu pharetra euismod, sem felis rutrum nibh, condimentum volutpat felis nisl eu nisi. Suspendisse lacus 
		odio, eleifend quis porta non, adipiscing ut felis. Quisque fringilla volutpat massa, gravida convallis nunc 
		eleifend vel. <br />
		<?php getItemVotes('t9'); ?>
	</p>
	<p>quam eu pharetra euismod, sem felis rutrum nibh, condimentum volutpat felis nisl eu nisi. Suspendisse lacus 
		odio, eleifend quis porta non, adipiscing ut felis. Quisque fringilla volutpat massa, gravida convallis nunc 
		eleifend vel. <br />
		<?php getItemVotes('t10'); ?>
	</p>
	<p>quam eu pharetra euismod, sem felis rutrum nibh, condimentum volutpat felis nisl eu nisi. Suspendisse lacus 
		odio, eleifend quis porta non, adipiscing ut felis. Quisque fringilla volutpat massa, gravida convallis nunc 
		eleifend vel. <br />
		<?php getItemVotes('t11'); ?>
	</p>
	<p>quam eu pharetra euismod, sem felis rutrum nibh, condimentum volutpat felis nisl eu nisi. Suspendisse lacus 
		odio, eleifend quis porta non, adipiscing ut felis. Quisque fringilla volutpat massa, gravida convallis nunc 
		eleifend vel. <br />
		<?php getItemVotes('t12'); ?>
	</p>
</body>
</html>