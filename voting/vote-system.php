<?php
//include the required files
include_once 'config/config.php';

$username = isset($_POST["username"]) ? $_POST["username"] : "";//username when logging in as admin
$password = isset($_POST["password"]) ? $_POST["password"] : "";//password when logging in as admin
$admin_login = isset($_POST["admin_login"]) ? $_POST["admin_login"] : "";//login button
$action = isset($_GET["action"]) ? $_GET["action"] : "view_votes";//action _GET variable to determine what the admin does, trim it and escape it first
$item_id = isset($_GET["item_id"]) ? mysql_real_escape_string(trim($_GET["item_id"])) : "";//item id _GET variable, gets the item we are trying to delete or delete its comment, trim it and escape it first
$comment_id = isset($_GET["comment_id"]) ? mysql_real_escape_string(trim($_GET["comment_id"])) : "";//comment _GET variable, gets the comment id we are trying to delete, trim it and escape it first
$code_name = isset($_POST["code_name"]) ? $_POST["code_name"] : "";//vote name used to show it
$add_vote_btn = isset($_POST["add_vote_btn"]) ? $_POST["add_vote_btn"] : "";//button when adding a new vote
$theme_selected = isset($_POST["theme_prev_list"]) ? mysql_real_escape_string($_POST["theme_prev_list"]) : 0;//theme id we selected for this item
$page = isset($_GET["page"]) ? mysql_real_escape_string($_GET["page"]) : 1;//page id
$order = isset($_GET["order"]) ? mysql_real_escape_string($_GET["order"]) : "date";//order value
$can_change_votes = isset($_POST["can_change_votes"]) ? $_POST["can_change_votes"] : "";//if the user can change their current vote
$time_to_revote = isset($_POST["time_to_revote"]) ? $_POST["time_to_revote"] : "";//time between votes on a particular vote item
$can_users_comment = isset($_POST["can_users_comment"]) ? $_POST["can_users_comment"] : "";//allow users to comment?
$approve_users_comments = isset($_POST["approve_users_comments"]) ? $_POST["approve_users_comments"] : "";//if useres are allowed to comment, approve the posted comments before they appear or not

//settings array for the admin
$settings = array(
	'admin_account' => array(
		'username' => md5('admin'),//set here your username
		'password' => md5('admin')//and your password
	),
	'vote_themes' => array(//themes IDs
		1,
		2,
		3,
		4,
		5,
		6,
		7,
		8,
		9,
		10,
		11,
		12,
		13,
		14,
		15
	),
	'votes_per_page' => 15,
	'comments_per_page' => 15,
	'recent_votes_per_page' => 15
);

//if we are direct accessing this file then are trying to log in as admin
//or checking around...?
if (!defined("auth")){
	//get admin log in form
	getAdminLoginForm();
}

/* Gets the admin login form
 * Logs in the admin if knows the username and password
 * if not logged in it will keep showing the login box
*/
function getAdminLoginForm(){
	global $settings, $username;
	include_once 'config/config.php';
	?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Strict//EN">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<title>Vote System | Admin Page</title>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
	<body <?php if (loggedin()) { echo 'style="background-color:#FFFFFF;"'; } ?>>
		<?php if (!loggedin()) {//if not logged in show the login panel ?>
			<div id="admin_login_container">
				<h2>Admin Login</h2>
				Username:admin &bull; Password: admin<br />(default settings)<br /><br />
				<form action="" method="post">
				<label>Username</label><input type="text" name="username" value="<?php echo $username; ?>" /><br />
				<label>Password</label><input type="password" name="password" /><br />
				<input type="submit" name="admin_login" value="Log in" /><br />
				</form>
				<span class="red"><?php loginAdmin(); ?></span>
			</div>
		<?php }else{
			showAdminPage();//else get admin page
		} ?>
	</body>
	</html>
	<?php
}

/* Gets the admin login form
 * Logs in the admin if knows the username and password
 * if not logged in it will keep showing the login box
*/
function showAdminPage(){
	global $action;
	include_once 'config/config.php';
	$statistics = getStatistics();
	?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Strict//EN">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<title>Vote System | Admin Page</title>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/vote_submit.js"></script>
	</head>
	<body>
		<div id="admin_header">
			<label class="admin_header_logo"><a href="">Admin Panel</a></label>
			<span class="admin_header_message">
				Welcome back, Admin!<br />
				<span style="float:right;"><a href="?action=logout">Logout</a></span>
			</span>
		</div>
		<div id="admin_navigation">
			<ul>
				<li>
					<a href="?action=view_votes" <?php if ($action == 'view_votes') { echo 'style="color:#2B2B2B;border-bottom:3px solid #00B800;"'; } ?>>View Votes & Comments</a>
				</li>
				<li>
					<a href="?action=recent_votes" <?php if ($action == 'recent_votes') { echo 'style="color:#2B2B2B;border-bottom:3px solid #00B800;"'; } ?>>Recent Votes</a>
				</li>
				<li>
					<a href="?action=view_stats" <?php if ($action == 'view_stats') { echo 'style="color:#2B2B2B;border-bottom:3px solid #00B800;"'; } ?>>View Statistics</a>
				</li>
				<li>
					<a href="?action=add_vote" <?php if ($action == 'add_vote') { echo 'style="color:#2B2B2B;border-bottom:3px solid #00B800;border-right:0;"'; }else echo 'style="border-right:0;"'; ?>>Add new Vote</a>
				</li>
			</ul>
		</div>
		<div class="admin_content_data">
			<?php getPage($action);//get admin  ?>
		</div>
	</body>
	</html>
	<?php
}

//Logs in the admin
function loginAdmin(){
	global $settings, $username, $password, $admin_login;
	if ($admin_login){//if pressed the admin button
		//check if i have entered the correct details
		if (md5($username) == $settings["admin_account"]["username"] && md5($password) == $settings["admin_account"]["password"]){
			//set session and redirect
			$_SESSION["loggedin"] = 1;
			header('Location: vote-system.php');
		}else
			echo 'Wrong username or password.';
	}
}

//check if logged in, returns BOOL
function loggedin(){
	if (isset($_SESSION["loggedin"])){
		return true;
	}else return false;
}

/* @param item_id - INT - item id we are trying to check if it exists
 * returns BOOL
*/
function VoteItemExist($item_id){
	$q = mysql_query("SELECT * FROM vote_items WHERE vote_item_id='$item_id'");
	$nrows = mysql_num_rows($q);
	if ($nrows){
		return true;
	}else return false;
}

function canComment($item_id){
	$q = mysql_query("SELECT can_comment FROM vote_items WHERE vote_item_id='$item_id'");
	$nrows = mysql_num_rows($q);
	if ($nrows){
		return true;
	}else return false;
}

//return the items votes
function returnItemVotes($item_id){
	$q = mysql_query("SELECT up_votes, down_votes FROM vote_items WHERE vote_item_id='$item_id'");
	$rows = mysql_fetch_array($q);
	$data = array(
		'upvotes' => $rows[0],
		'downvotes' => $rows[1]
	);
	return $data;
}

/* @param item_id INT - item id to upvote
 * Updates the current up votes of the item_id and inserts a new vote of the current user
*/
function UpVoteItem($item_id){
	$user_ip = ip2long(getUserIP());//get user IP
	//update the up votes count of this item
	mysql_query("UPDATE vote_items SET up_votes=up_votes+1 WHERE vote_item_id='$item_id'");
	//insert user so we wont allow for duplicate votes within this IP
	$date = date("Y-m-d H:i:s");
	mysql_query("INSERT INTO votes_done VALUES ('', '$item_id', '1', '$user_ip', '$date')");
}

function getLastUserVoteTime($item_id){
	$user_ip = ip2long(getUserIP());//get user IP
	$q = mysql_query("SELECT date FROM votes_done WHERE user_ip='$user_ip' && vote_item_id='$item_id'");
	$rows = mysql_fetch_array($q);
	$time = $rows[0];
	$time = strtotime($time);
	return $time;
}

function addNewRevote($item_id, $type){
	$user_ip = ip2long(getUserIP());//get user IP
	//delete current vote
	mysql_query("DELETE FROM votes_done WHERE user_ip='$user_ip' && vote_item_id='$item_id'");
	//add new vote
	if ($type == "up"){
		UpVoteItem($item_id);
	}else if ($type == "down"){
		DownVoteItem($item_id);
	}
}

/* @param item_id INT - item id to downvote
 * Updates the current down votes of the item_id and inserts a new vote of the current user
*/
function DownVoteItem($item_id){
	$user_ip = ip2long(getUserIP());//get user ip
	//update current down votes of this item
	mysql_query("UPDATE vote_items SET down_votes=down_votes+1 WHERE vote_item_id='$item_id'");
	//record this user for duplicate votes on this Ip
	$date = date("Y-m-d H:i:s");
	mysql_query("INSERT INTO votes_done VALUES ('', '$item_id', '0', '$user_ip', '$date')");
}

/* @param item_id INT - item id to check if the user has already voted
 * returns BOOl
*/
function alreadyVoted($item_id){
	$user_ip = ip2long(getUserIP());
	$q = mysql_query("SELECT * FROM votes_done WHERE user_ip='$user_ip' && vote_item_id='$item_id'");
	$nrows = mysql_num_rows($q);
	if ($nrows){
		return true;
	}else return false;
}

/* @param item_id INT - gets the user Vote as VARCHAR
 * returns Up if vote is 1 and Down if vote is 0
*/
function getUserVote($item_id){
	$user_ip = ip2long(getUserIP());
	$q = mysql_query("SELECT vote_type FROM votes_done WHERE user_ip='$user_ip' && vote_item_id='$item_id'");
	$rows = mysql_fetch_array($q);
	$type = $rows[0];
	return $type;
}

/* @param item_name VARCHAR
 * gets the Vote id from the item name
*/
function getVoteId($item_name){
	$q = mysql_query("SELECT vote_item_id FROM vote_items WHERE item_name='$item_name'");
	$nrows = mysql_fetch_array($q);
	return $nrows[0];
}

//gets user IP
function getUserIP(){
	if(isset($_SERVER["REMOTE_ADDR"])){
		$ip=$_SERVER["REMOTE_ADDR"];
	}else if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
		$ip=$_SERVER["HTTP_X_FORWARDED_FOR"];
	}else if (isset($_SERVER["HTTP_CLIENT_IP"])){
		$ip=$_SERVER["HTTP_CLIENT_IP"];
	}
	return $ip;
}

//gets global statistic of the votes
//returns total votes items, total votes casted, total up and down votes and total comments
function getStatistics(){
	$q = mysql_query("SELECT *,
					  COUNT(id) AS total_items,
					  SUM(up_votes) AS total_upvotes,
					  SUM(down_votes) AS total_downvotes,
					  SUM(totalComments) AS total_comments
					  FROM vote_items");
	$nrows = mysql_num_rows($q);
	$data = array(
		'total_items' => 0,
		'total_votes' => 0,
		'up_votes_total' => 0,
		'down_votes_total' => 0,
		'total_comments' => 0
	);
	if ($nrows){
		$rows = mysql_fetch_array($q);
		$total_upvotes = $rows["total_upvotes"];
		$total_downvotes = $rows["total_downvotes"];
		$total_votes = $total_upvotes + $total_downvotes;
		$total_comments = $rows["total_comments"];
		$data["total_items"] = $rows["total_items"];
		$data["total_votes"] = $total_votes;
		if ($total_upvotes != "" && $total_downvotes != "" && $total_comments != ""){
			$data["up_votes_total"] = $total_upvotes;
			$data["down_votes_total"] = $total_downvotes;
			$data["total_comments"] = $total_comments;
		}
	}
	return $data;
}

//get the page depending the action $_GET variable and comment id $_GET variable
function getPage($action){
	global $item_id, $comment_id;
	if ($action == "logout"){//logs out the admin
		session_destroy();//end session
		header("Location: vote-system.php");//redirect
	}else if ($action == "add_vote"){//add new vote
		getNewVoteForm();//get the form
	}else if ($action == "view_votes"){//view votes and comments
		getVotesAndComments();//get the votes and comments page
	}else if ($action == "view_stats"){
		getStatisticsPage();
	}else if ($action == "recent_votes"){
		getRecentVoters();
	}else if ($action == "approve"){
		ApproveComment($item_id, $comment_id);
	}else if ($action == "unapprove"){
		UnapproveComment($item_id, $comment_id);
	}else if ($action == "delete"){//delete a vote or comment
		if ($item_id != "" && $comment_id == ""){//delete a vote
			deleteVoteItem($item_id);
		}else if ($comment_id != "" && $item_id != ""){//delete a comment
			deleteComment($comment_id, $item_id);
		}
	}else{
		//404 error
		?>
		<h1 style="font-size:500%;">404 Error - Page not Found</h1>
		<h2>You have either misspelled what you wanted to write in the URL or the link you tried to reach does not exist.<br /><br />Go Back.$@#$@</h2>
		<?php
	}
}

function getItemName($item_id){
	$q = mysql_query("SELECT item_name FROM vote_items WHERE vote_item_id='$item_id'");
	$rows = mysql_fetch_array($q);
	return $rows[0];
}

function getRecentVoters(){
	global $page, $settings;
	$q = "SELECT *
		  FROM votes_done as vd
		  ORDER BY vd.date DESC";
	$total_rows = mysql_num_rows(mysql_query($q));
	
	echo '<h1 style="padding-bottom:8;margin-bottom:8px;border-bottom:1px dashed #333333;">Recent Votes ('.$total_rows.') &raquo;</h1>';
	
	if ($page < 1)
		$page = 1;
	if ($page > $total_rows && $total_rows > 0)
		$page = $total_rows;
	
	$per_page = $settings["recent_votes_per_page"];
	
	$start = $per_page * ($page - 1);
	
	$q .= " LIMIT $start,15";
	
	$q = mysql_query($q);
	$nrows = mysql_num_rows($q);
	
	echo pagination($page, $total_rows, $per_page, 'vote-system.php?action=recent_votes').'<br />';
	
	if ($nrows){
		while ($rows = mysql_fetch_array($q)){
			$user_ip = long2ip($rows["user_ip"]);
			$item_id = $rows["vote_item_id"];
			$vote_type = $rows["vote_type"];
			$prefix = ($vote_type == 0) ? "a" : "an";
			$voted = ($vote_type == 0) ? "Down" : "Up";
			$date = $rows["date"];
			?>
			<div class="adm_voters_container">
				User IP: <strong><?php echo $user_ip; ?></strong> has <strong><?php echo $voted; ?></strong> Voted item name <strong><?php echo getItemName($item_id); ?></strong> &bull; <strong>on</strong> <?php echo $date; ?>
			</div>
			<?php
		}
		echo '<br />'.pagination($page, $total_rows, $per_page, 'vote-system.php?action=recent_votes');
	}else echo '<span class="v_message" style="display:block;">No voters found.</span>';
}

//get statistics page
function getStatisticsPage(){
	$statistics = getStatistics();
	?>
	<div class="adm_statistics_container">
		<h1 style="padding-bottom:8;margin-bottom:8px;border-bottom:1px dashed #333333;">Votes Statistics &raquo;</h1>
		<label>Total Vote Items</label><span><?php echo number_format($statistics["total_items"]); ?></span><br /><br />
		<label>Total Votes</label><span><?php echo number_format($statistics["total_votes"]); ?></span><br /><br />
		<label>Total Up Votes</label><span><?php echo number_format($statistics["up_votes_total"]); ?></span><br /><br />
		<label>Total Down Votes</label><span><?php echo number_format($statistics["down_votes_total"]); ?></span><br /><br />
		<label>Total Comments</label><span><?php echo number_format($statistics["total_comments"]); ?></span><br /><br />
	</div>
	<?php
}

/* @param item_id INT - item id we are trying to delete its vote
 * deleters the vote or returns an error message if vote not found
*/
function deleteVoteItem($item_id){
	if (VoteItemExist($item_id)){
		mysql_query("DELETE FROM vote_items WHERE vote_item_id='$item_id'");
		mysql_query("DELETE FROM votes_done WHERE vote_item_id='$item_id'");
		mysql_query("DELETE FROM votes_comments WHERE vote_item_id='$item_id'");
		header("Location: vote-system.php?action=view_votes");
	}else
		echo 'You cant delete this item.';
}

function getCommentApprovalState($comment_id, $type){
	$q = mysql_query("SELECT approved FROM votes_comments WHERE comment_id='$comment_id'");
	$rows = mysql_fetch_array($q);
	$approved = $rows[0];
	if ($approved == $type){
		return true;
	}else return false;
}

function ApproveComment($item_id, $comment_id){
	if (VoteItemExist($item_id)){
		if (commentExist($comment_id)){
			if (commentIsInItem($comment_id, $item_id)){
				if (getCommentApprovalState($comment_id, 0)){
					mysql_query("UPDATE votes_comments SET approved='1' WHERE approved='0' && comment_id='$comment_id' && vote_item_id='$item_id'");
					header("Location: vote-system.php?action=view_votes");
				}else
					echo 'This comment has already been approved.';
			}else
				echo 'You cant delete this comment.';
		}else
			echo 'You cant delete this comment.';
	}else
		echo 'This item does not exist.';
}

function UnapproveComment($item_id, $comment_id){
	if (VoteItemExist($item_id)){
		if (commentExist($comment_id)){
			if (commentIsInItem($comment_id, $item_id)){
				if (getCommentApprovalState($comment_id, 1)){
					mysql_query("UPDATE votes_comments SET approved='0' WHERE approved='1' && comment_id='$comment_id' && vote_item_id='$item_id'");
					header("Location: vote-system.php?action=view_votes");
				}else
					echo 'This comment has already been unapproved.';
			}else
				echo 'You cant delete this comment.';
		}else
			echo 'You cant delete this comment.';
	}else
		echo 'This item does not exist.';
}

/* @param comment_id INT
 * @param item_id INT
 * deletes the comment
*/
function deleteComment($comment_id, $item_id){
	if (VoteItemExist($item_id)){
		if (commentExist($comment_id)){
			if (commentIsInItem($comment_id, $item_id)){
				mysql_query("DELETE FROM votes_comments WHERE comment_id='$comment_id'");
				mysql_query("UPDATE vote_items SET totalComments=totalComments-1 WHERE vote_item_id='$item_id'");
				header("Location: vote-system.php?action=view_votes");
			}else
				echo 'You cant delete this comment.';
		}else
			echo 'You cant delete this comment.';
	}else
		echo 'This item does not exist.';
}

/* @param comment_id INT
 * @param item_id INT
 * checks if the comment is in the vote(item_id)
 * and returns BOOL
*/
function commentIsInItem($comment_id, $item_id){
	$q = mysql_query("SELECT vote_item_id FROM votes_comments WHERE comment_id='$comment_id'");
	$rows = mysql_fetch_array($q);
	if ($rows[0] == $item_id){
		return true;
	}else return false;
}

/* @param comment_id
 * checks if comment exist and returns BOOL
*/
function commentExist($comment_id){
	$q = mysql_query("SELECT * FROM votes_comments WHERE comment_id='$comment_id'");
	$nrows = mysql_num_rows($q);
	if ($nrows){
		return true;
	}else return false;
}

function getVoteItemRevoteTime($item_id){
	$q = mysql_query("SELECT time_to_revote FROM vote_items WHERE vote_item_id='$item_id'");
	$rows = mysql_fetch_array($q);
	$time = $rows[0];
	return $time;
}

//get the form when adding a new vote
function getNewVoteForm(){
	global $settings, $theme_selected;
	?>
	<h1 style="text-align:center;">Add New Vote to an Item</h1>
	<div class="new_vote_form"><br />
		<form action="" method="post">
			<label>Item code name:</label><input type="text" value="" name="code_name" /><br /><br />
			<fieldset>
				<legend><strong>Optional Vote Settings:</strong></legend>
				<label for="can_change_votes" style="width:auto;margin-right:20px;">Allow users to change their current vote?</label><input type="checkbox" id="can_change_votes" name="can_change_votes" />
				<br /><br />
				<strong>Optional: </strong>After this time users can revote(in seconds)<input type="text" name="time_to_revote" style="float:left;width:98%;margin-top:8px;" value="" />
				<br /><br /><br /><br />
				<label for="can_users_comment" style="width:auto;margin-right:20px;">Allow comments?</label><input type="checkbox" id="can_users_comment" name="can_users_comment" checked="checked" />
				<br /><br />
				<label for="approve_users_comments" style="width:auto;margin-right:20px;">Require comments to be approved before they're posted?</label><input type="checkbox" id="approve_users_comments" name="approve_users_comments" />
			</fieldset>
			<br />
			<label>Vote Theme:</label>
			<select name="theme_prev_list" class="theme_prev_list">
				<?php
				foreach ($settings["vote_themes"] as $val){
					$id = $val-1;
					echo '<option name="'.$id.'" value="'.$id.'"';
					if ($id == $theme_selected)
						echo ' selected="selected"';
					echo '>Theme '.$val.'</option>';
				}
				?>
			</select>
			<br /><br />
			<div style="border:1px dashed #CCC;display:inline-block;float:left;padding:3px;">
			<h2>Theme Preview &raquo;</h2>
			<?php previewThemes($theme_selected); ?></div>
			<input type="submit" name="add_vote_btn" value="Add New" />
		</form>
		<?php
			submitVoteForm();//submit it when pressing the Add New Button
		?>
	</div>
	<?php
}

/* @param code_name VARCHAR
 * returns BOOL if vote name exists
*/
function codeNameExist($code_name){
	$q = mysql_query("SELECT * FROM vote_items WHERE item_name='$code_name'");
	$nrows = mysql_num_rows($q);
	if ($nrows){
		return true;
	}else return false;
}

//generates a random id
//used when adding a new vote or comment to database
//default length is 12
function getRandomId($len=12){
	$id = '';
	for ($i=0;$i<$len;$i++){
		$id .= rand(1,9);
	}
	return $id;
}

//preview the themes
function previewThemes($selected){
	?>
	<div id="item_vote_container">
		<div class="themes_preview theme_p_0" <?php if ($selected == 0){ echo 'style="display:block;"'; }?>>
			<span class="item_vote_up_bubble_count">0</span>
			<span class="item_vote_up_bubble_rarr"></span>
			<div class="item_vote_up_btn">&nbsp;</div>
			&nbsp;
			<div class="item_vote_down_btn">&nbsp;</div>
			<span class="item_vote_down_bubble_larr"></span>
			<span class="item_vote_down_bubble_count">0</span>
		</div>
		<div class="themes_preview theme_p_1" <?php if ($selected == 1){ echo 'style="display:block;"'; }?>>
			<div class="vote_style_outer">
				<div class="vote_up_style1_btn"></div>
				<span class="hor_number_votes"><span class="green">0</span></span>
				<div class="vote_down_style1_btn"></div>
			</div>
		</div>
		<div class="themes_preview theme_p_2" <?php if ($selected == 2){ echo 'style="display:block;"'; }?>>
			<div class="vote_up_style2_btn"></div>&nbsp;&nbsp;I Like&nbsp;(<span class="green">0</span>)<br /><br />
			<div class="vote_down_style2_btn"></div>&nbsp;&nbsp;I Dislike&nbsp;(<span class="red">0</span>)
		</div>
		<div class="themes_preview theme_p_3" <?php if ($selected == 3){ echo 'style="display:block;"'; }?>>
			<div class="v_u_style3_outer"><div class="vote_up_style3_btn"></div>&nbsp; <span class="green">0</span></div>
			<div class="v_d_style3_outer"><div class="vote_down_style3_btn"></div>&nbsp; <span class="red" style="float:right;">0</span></div>
		</div>
		<div class="themes_preview theme_p_4" <?php if ($selected == 4){ echo 'style="display:block;"'; }?>>
			<div class="v_style4_outer"><div class="vote_up_style4_btn"></div>&nbsp;&nbsp;<span class="green">0</span></div><br />
			<div class="v_style4_outer"><div class="vote_down_style4_btn"></div>&nbsp;&nbsp;<span class="red">0</span></div>
		</div>
		<div class="themes_preview theme_p_5" <?php if ($selected == 5){ echo 'style="display:block;"'; }?>>
			<div class="v_u_style5_outer"><div class="vote_up_style5_btn"></div>&nbsp; <span class="green">0</span></div>
			<div class="v_d_style5_outer"><div class="vote_down_style5_btn"></div>&nbsp; <span class="red" style="float:right;">0</span></div>
		</div>
		<div class="themes_preview theme_p_6" <?php if ($selected == 6){ echo 'style="display:block;"'; }?>>
			<div class="theme_style6_outer">
				<div class="v_style6_left">
					<span class="green">0</span>&nbsp;/&nbsp;<span class="red">0</span>
				</div>
				<div class="v_style6_right">
					<div class="vote_up_style6_btn"></div>
					<div class="vote_down_style6_btn"></div>
				</div>
			</div>
		</div>
		<div class="themes_preview theme_p_7" <?php if ($selected == 7){ echo 'style="display:block;"'; }?>>
			<div class="theme_style7_outer">
				<div class="v_style7_right">
					<div class="vote_up_style7_btn"></div><br />
					<div class="vote_down_style7_btn"></div>
				</div>
				<div class="v_style7_left">
					<span class="green">0</span><br /><br />
					<span class="red">0</span>
				</div>
			</div>
		</div>
		<div class="themes_preview theme_p_8" <?php if ($selected == 8){ echo 'style="display:block;"'; }?>>
			<span class="green v_link"><span class="vote_up_style8_btn">Vote Up</span></span> <span class="green">(0)</span></span>&nbsp;/&nbsp;<span class="red v_link"><span class="vote_down_style8_btn">Vote Up</span></span> <span class="red">(0)</span>
		</div>
		<div class="themes_preview theme_p_9" <?php if ($selected == 9){ echo 'style="display:block;"'; }?>>
			<div class="v_style9_left">
				Vote Up <span class="vote_up_style9_btn"></span>
				<hr />
				<span class="green">0</span>
			</div>
			<div class="v_style9_right">
				<span class="vote_down_style9_btn" id="down"></span> Vote Down 
				<hr />
				<span class="red">0</span>
			</div>
		</div>
		<div class="themes_preview theme_p_10" <?php if ($selected == 10){ echo 'style="display:block;"'; }?>>
			<div class="theme_style10_outer">
				<div class="theme_style10_top">
					<span class="green">+0</span><br />
					Votes
				</div>
				<div class="theme_style10_bottom">
					<div class="v_u_style10_btn_outer"><div class="vote_up_style10_btn"></div></div>
					<div class="v_d_style10_btn_outer"><div class="vote_down_style10_btn"></div></div>
				</div>
			</div>
		</div>
		<div class="themes_preview theme_p_11" <?php if ($selected == 11){ echo 'style="display:block;"'; }?>>
			<div class="vote_up_style11_btn"><span class="green">+0</span></div>
			<div class="vote_down_style11_btn"><span class="red">-0</span></div>
		</div>
		<div class="themes_preview theme_p_12" <?php if ($selected == 12){ echo 'style="display:block;"'; }?>>
			<div class="theme_style12_outer"><span class="green">+0</span></div>
			<div class="vote_up_style12_btn">Vote It!</div>
		</div>
		<div class="themes_preview theme_p_13" <?php if ($selected == 13){ echo 'style="display:block;"'; }?>>
			<span class="green">+0</span> out of <span class="t13_total_votes">0</span> like this.<span class="vote_up_style13_btn">I Like</span><span class="vote_down_style13_btn">I Dislike</span>
		</div>
		<div class="themes_preview theme_p_14" <?php if ($selected == 14){ echo 'style="display:block;"'; }?>>
			<span class="green">+0%</span> of <span class="t14_total_votes">0%</span> like this.<span class="vote_up_style14_btn">I Like</span><span class="vote_down_style14_btn">I Dislike</span>
		</div>
	</div>
	<?php
}

/**
 * @param INT theme - the theme of this vote item
 * @param INT item_id - the id of this vote
 * @param BOOL adminPanel - if we are not in admin Panel we show what we have voted
 * @param INT state - button state we are checking(up/down vote)
 * gets the class name of the item we have voted so we can see that we have up or down voted this particular item
*/
function getUserVoteState($theme, $item_id, $adminPanel, $state){
	if ($adminPanel == false){
		if (alreadyVoted($item_id)){
			$vote = getUserVote($item_id);
			if ($vote == $state){
				if ($vote == 1){
					echo 'voted_up'.$theme;
				}else if ($vote == 0){
					echo 'voted_down'.$theme;
				}
			}
		}
	}
}

/**
 * @param INT theme - the theme of this vote
 * @param INT up_votes - total up votes of this item
 * @param INT down_votes - total down votes of this item
 * @param INT vote_item_id - current vote item id
 * @param BOOL adminPanel - indicates if we are editing the vote or not in order to show some extra stuff for the admin
 * Gets the Vote Interface
*/
function getThemeUI($theme, $up_votes, $down_votes, $vote_item_id, $adminPanel=false){
	if ($theme == 0){
		?>
		<div id="item_vote_container">
			<span class="item_vote_up_bubble_count upv_counter">+<?php echo $up_votes; ?></span>
			<span class="item_vote_up_bubble_rarr"></span>
			<div class="item_vote_up_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 1); ?>" id="up" rel="0">&nbsp;</div>
			&nbsp;
			<div class="item_vote_down_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 0); ?>" id="down" rel="0">&nbsp;</div>
			<span class="item_vote_down_bubble_larr"></span>
			<span class="item_vote_down_bubble_count downv_counter">-<?php echo $down_votes; ?></span>
			<input type="hidden" value="<?php echo $vote_item_id; ?>" id="v_i_id" />
		</div>
		<?php
	}else if ($theme == 1){
		?>
		<div id="item_vote_container">
			<div class="vote_style_outer">
				<div class="vote_up_style1_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 1); ?>" id="up" rel="1"></div>
				<span class="hor_number_votes"><span class="green upv_counter">+<?php echo $up_votes; ?></span></span>
				<div class="vote_down_style1_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 0); ?>" id="down" rel="1"></div>
				<input type="hidden" value="<?php echo $vote_item_id; ?>" id="v_i_id" />
			</div>
		</div>
		<?php
	}else if ($theme == 2){
		?>
		<div id="item_vote_container">
			<div class="vote_up_style2_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 1); ?>" id="up" rel="2"></div><div style="float:left;">(<span class="green upv_counter">+<?php echo $up_votes; ?></span>)&nbsp;&nbsp;&nbsp;</div>
			<div class="vote_down_style2_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 0); ?>" id="down" rel="2"></div><div style="float:left;">(<span class="red downv_counter">-<?php echo $down_votes; ?></span>)</div>
			<input type="hidden" value="<?php echo $vote_item_id; ?>" id="v_i_id" />
		</div>
		<?php
	}else if ($theme == 3){
		?>
		<div id="item_vote_container">
			<div class="v_u_style3_outer"><div class="vote_up_style3_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 1); ?>" id="up" rel="3"></div>&nbsp; <span class="green upv_counter">+<?php echo $up_votes; ?></span><input type="hidden" value="<?php echo $vote_item_id; ?>" id="v_i_id" /></div>
			<div class="v_d_style3_outer"><div class="vote_down_style3_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 0); ?>" id="down" rel="3"></div>&nbsp; <span class="red downv_counter" style="float:right;">-<?php echo $down_votes; ?></span><input type="hidden" value="<?php echo $vote_item_id; ?>" id="v_i_id" /></div>
		</div>
		<?php
	}else if ($theme == 4){
		?>
		<div id="item_vote_container">
			<div class="v_style4_outer"><div class="vote_up_style4_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 1); ?>" id="up" rel="4"></div>&nbsp;&nbsp;<span class="green upv_counter">+<?php echo $up_votes; ?></span><input type="hidden" value="<?php echo $vote_item_id; ?>" id="v_i_id" /></div><br />
			<div class="v_style4_outer"><div class="vote_down_style4_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 0); ?>" id="down" rel="4"></div>&nbsp;&nbsp;<span class="red downv_counter">-<?php echo $down_votes; ?></span><input type="hidden" value="<?php echo $vote_item_id; ?>" id="v_i_id" /></div>
		</div>
		<?php
	}else if ($theme == 5){
		?>
		<div id="item_vote_container">
			<div class="v_u_style5_outer"><div class="vote_up_style5_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 1); ?>" id="up" rel="5"></div>&nbsp; <span class="green upv_counter">+<?php echo $up_votes; ?></span><input type="hidden" value="<?php echo $vote_item_id; ?>" id="v_i_id" /></div>
			<div class="v_d_style5_outer"><div class="vote_down_style5_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 0); ?>" id="down" rel="5"></div>&nbsp; <span class="red downv_counter" style="float:right;">-<?php echo $down_votes; ?></span><input type="hidden" value="<?php echo $vote_item_id; ?>" id="v_i_id" /></div>
		</div>
		<?php
	}else if ($theme == 6){
		?>
		<div id="item_vote_container">
			<div class="theme_style6_outer">
				<div class="v_style6_left">
					<span class="green upv_counter">+<?php echo $up_votes; ?></span>&nbsp;/&nbsp;<span class="red downv_counter">-<?php echo $down_votes; ?></span>
				</div>
				<div class="v_style6_right">
					<div class="vote_up_style6_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 1); ?>" id="up" rel="6"></div>
					<div class="vote_down_style6_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 0); ?>" id="down" rel="6"></div>
					<input type="hidden" value="<?php echo $vote_item_id; ?>" id="v_i_id" />
				</div>
			</div>
		</div>
		<?php
	}else if ($theme == 7){
		?>
		<div id="item_vote_container">
			<div class="theme_style7_outer">
				<div class="v_style7_right">
					<div class="vote_up_style7_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 1); ?>" id="up" rel="7"></div><br />
					<div class="vote_down_style7_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 0); ?>" id="down" rel="7"></div>
					<input type="hidden" value="<?php echo $vote_item_id; ?>" id="v_i_id" />
				</div>
				<div class="v_style7_left">
					<span class="green upv_counter" style="margin-top:7px;display:inline-block;">+<?php echo $up_votes; ?></span><br /><br />
					<span class="red downv_counter" style="margin-top:5px;display:inline-block;">-<?php echo $down_votes; ?></span><br />
				</div>
			</div>
		</div>
		<?php
	}else if ($theme == 8){
		?>
		<div id="item_vote_container">
			<span class="v_link">
				<span class="vote_up_style8_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 1); ?>" id="up" rel="8">
					Vote Up
				</span>
				<input type="hidden" value="<?php echo $vote_item_id; ?>" id="v_i_id" />
			</span> 
			(<span class="green upv_counter">+<?php echo $up_votes; ?></span>)
			/
			<span class="v_link">
				<span class="vote_down_style8_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 0); ?>" id="down" rel="8">
					Vote Down
				</span>
				<input type="hidden" value="<?php echo $vote_item_id; ?>" id="v_i_id" />
			</span>
			(<span class="red downv_counter">-<?php echo $down_votes; ?></span>)
		</div>
		<?php
	}else if ($theme == 9){
		?>
		<div id="item_vote_container">
			<div class="v_style9_left">
				Vote Up <span class="vote_up_style9_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 1); ?>" id="up" rel="9"></span>
				<hr />
				<span class="green upv_counter">+<?php echo $up_votes; ?></span>
				<input type="hidden" value="<?php echo $vote_item_id; ?>" id="v_i_id" />
			</div>
			<div class="v_style9_right">
				<span class="vote_down_style9_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 0); ?>" id="down" rel="9"></span> Vote Down 
				<hr />
				<span class="red downv_counter">-<?php echo $down_votes; ?></span>
				<input type="hidden" value="<?php echo $vote_item_id; ?>" id="v_i_id" />
			</div>
		</div>
		<?php
	}else if ($theme == 10){
		?>
		<div id="item_vote_container">
			<div class="theme_style10_outer">
				<div class="theme_style10_top">
					<span class="green upv_counter">+<?php echo $up_votes; ?></span><br />
					Votes
				</div>
				<div class="theme_style10_bottom">
					<div class="v_u_style10_btn_outer"><div class="vote_up_style10_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 1); ?>" id="up" rel="10"></div><input type="hidden" value="<?php echo $vote_item_id; ?>" id="v_i_id" /></div>
					<div class="v_d_style10_btn_outer"><div class="vote_down_style10_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 0); ?>" id="down" rel="10"></div><input type="hidden" value="<?php echo $vote_item_id; ?>" id="v_i_id" /></div>
				</div>
			</div>
		</div>
		<?php
	}else if ($theme == 11){
		?>
		<div id="item_vote_container">
			<div class="vote_up_style11_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 1); ?>" id="up" rel="11"><span class="green upv_counter">+<?php echo $up_votes; ?></span></div>
			<div class="vote_down_style11_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 0); ?>" id="down" rel="11"><span class="red downv_counter">-<?php echo $down_votes; ?></span></div>
			<input type="hidden" value="<?php echo $vote_item_id; ?>" id="v_i_id" />
		</div>
		<?php
	}else if ($theme == 12){
		?>
		<div id="item_vote_container">
			<div class="theme_style12_outer"><span class="green upv_counter">+<?php echo $up_votes; ?></span></div>
			<div class="vote_up_style12_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 1); ?>" id="up" rel="12">Vote It!</div>
			<input type="hidden" value="<?php echo $vote_item_id; ?>" id="v_i_id" />
		</div>
		<?php
	}else if ($theme == 13){
		?>
		<div id="item_vote_container">
			<span class="green upv_counter">+<?php echo $up_votes; ?></span> out of <span class="t13_total_votes"><?php echo $up_votes+$down_votes; ?></span> like this.<span class="vote_up_style13_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 1); ?>" id="up" rel="13">I Like</span><span class="vote_down_style13_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 1); ?>" id="down" rel="13">I Dislike</span>
			<input type="hidden" value="<?php echo $vote_item_id; ?>" id="v_i_id" />
		</div>
		<?php
	}else if ($theme == 14){
		$total = $up_votes+$down_votes;
		$upvotes_percentage = 0;
		if ($total != 0)
			$upvotes_percentage = floor(($up_votes/$total) * 100);
		?>
		<div id="item_vote_container">
			<span class="green upv_counter">+<?php echo $upvotes_percentage; ?>%</span> of <span class="t14_total_votes"><?php echo $total; ?></span> voters like this.<span class="vote_up_style14_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 1); ?>" id="up" rel="14">I Like</span><span class="vote_down_style14_btn <?php getUserVoteState($theme, $vote_item_id, $adminPanel, 1); ?>" id="down" rel="14">I Dislike</span>
			<input type="hidden" value="<?php echo $vote_item_id; ?>" id="v_i_id" />
		</div>
		<?php
	}
}

function getTotalApprovedComments($item_id){
	$q = mysql_query("SELECT * FROM votes_comments WHERE vote_item_id='$item_id' && approved='1'");
	$nrows = mysql_num_rows($q);
	return $nrows;
}

/* @param vote_item_name VARCHAR
 * //gets the interface to vote for the item we have assigned it
*/
function getItemVotes($vote_item_name){
	$vote_item_name = trim($vote_item_name);//remove spaces
	$vote_item_name = mysql_real_escape_string($vote_item_name);//escape it
	$q = mysql_query("SELECT * FROM vote_items WHERE item_name='$vote_item_name'");
	$nrows = mysql_num_rows($q);
	$vote_item_id = 0;//define the total comments and item id
	if ($nrows){
		$rows = mysql_fetch_array($q);
		$vote_item_id = $rows["vote_item_id"];//vote id
		$up_votes = number_format($rows["up_votes"]);//num of up votes
		$down_votes = number_format($rows["down_votes"]);//num of down votes
		$theme = $rows["theme"];
		$can_comment = $rows["can_comment"];
		$totalComments = getTotalApprovedComments($vote_item_id);//total comments of this vote
		echo '<div class="vote_item_outer_container">';
		getThemeUI($theme, $up_votes, $down_votes, $vote_item_id, false);
		echo '<span class="voted_message">';//container to show the toggle votes and show the popup window with votes comments
		if ($can_comment == 1){
			echo ' <a class="view_votes_comments_toggle" href="#" title="Comment"></a>';
		}
		echo '</span></div>';
	}else
		echo '<span class="v_message">There is no vote assigned for this item.</span>';
	if ($nrows > 0 && $can_comment == 1)
		getCommentPopupWindow($vote_item_id, $totalComments);//get comments popup
}

/* @param item_id INT
 * returns total comments of this vote
*/
function getTotalItemComments($item_id){
	$q = mysql_query("SELECT * FROM votes_comments WHERE vote_item_id='$item_id'");
	$nrows = mysql_num_rows($q);
	return $nrows;
}

/* @param item_id INT
 * gets the votes comments
*/
function getAdminVoteItemComments($item_id, $start=0){
	global $settings;
	$html = '';
	$q = "SELECT *
		  FROM votes_comments
		  WHERE vote_item_id='$item_id'
		  ORDER BY date DESC";
	$total_rows = mysql_num_rows(mysql_query($q));
	$html .= '
		<div class="vote_items_comments_list">
		<h2 style="border-bottom:1px solid #CCC;margin-bottom:10px;padding-bottom:5px;">Vote Comments ('.$total_rows.') &raquo;</h2>
	';
	
	$per_page = $settings["comments_per_page"];
	
	if ($start < 0)
		$start = 0;
	if ($start > $total_rows)
		$start = $total_rows;
	
	$q .= " LIMIT $start, $per_page";
	
	$q = mysql_query($q) or die(mysql_error());
	
	$nrows = mysql_num_rows($q);
	if ($nrows){
		while ($rows = mysql_fetch_assoc($q)){
			$username = $rows["username"];//get username of comment
			$username = htmlentities($username, ENT_COMPAT, 'UTF-8');//utf8 it
			$body = $rows["body"];//body of comment
			$body = htmlentities($body, ENT_COMPAT, 'UTF-8');//utf 8 it
			$body = nl2br($body);//add new lines
			$email = $rows["email"];//get email
			$date = $rows["date"];//get date
			$comment_id = $rows["comment_id"];//get comment id
			$vote_item_id = $rows["vote_item_id"];
			$approved = $rows["approved"];
			$html .= '
				<div class="comments_list_items">
					'.$body.'
					<div class="comments_list_items_footer">';
						$html .= '<span style="color:#000000;">by</span> '.$username;
						$html .= ' <b style="color:#000000;">('.$email.')</b> ';
						
						$html .= ' <span style="color:#000000;">&bull; at</span> '.$date;
						$html .= '&nbsp;<a style="text-decoration:none;color:#000000;" href="?action=delete&item_id='.$item_id.'&comment_id='.$comment_id.'" class="delete_comment_btn">Delete</a>';
						if ($approved == 0){
							$html .= '&nbsp;&bull;&nbsp;<a style="text-decoration:none;color:#000000;" href="?action=approve&item_id='.$item_id.'&comment_id='.$comment_id.'" class="a_un_aprove_item">Approve</a>';
						}else
							$html .= '&nbsp;&bull;&nbsp;<a style="text-decoration:none;color:#000000;" href="?action=unapprove&item_id='.$item_id.'&comment_id='.$comment_id.'" class="a_un_aprove_item">Unapprove</a>';
					$html .= '</div>
				</div>';
		}
	}else
		$html .= '<span class="p_message">This item does not have any comments yet.</span>';//nothing found so show a message
	$html .= '</div>';
	return $html;
}

/* @param item_id INT
 * gets the votes comments
*/
function getVoteItemComments($item_id, $start=0){
	global $settings;
	$html = '';
	$q = "SELECT *
		  FROM votes_comments
		  WHERE vote_item_id='$item_id'
		  && approved='1'
		  ORDER BY date DESC";
	$total_rows = mysql_num_rows(mysql_query($q));
	$html .= '<div class="vote_items_comments_list">';
//	if ($edit_mode == 1)
//		$html .= '<h2 style="border-bottom:1px solid #CCC;margin-bottom:10px;padding-bottom:5px;">Vote Comments ('.$total_rows.') &raquo;</h2>';
	
	$per_page = $settings["comments_per_page"];
	
	if ($start < 0)
		$start = 0;
	if ($start > $total_rows)
		$start = $total_rows;
	
	$q .= " LIMIT $start, $per_page";
	
	$q = mysql_query($q) or die(mysql_error());
	
	$nrows = mysql_num_rows($q);
	if ($nrows){
		while ($rows = mysql_fetch_assoc($q)){
			$username = $rows["username"];//get username of comment
			$username = htmlentities($username, ENT_COMPAT, 'UTF-8');//utf8 it
			$body = $rows["body"];//body of comment
			$body = htmlentities($body, ENT_COMPAT, 'UTF-8');//utf 8 it
			$body = nl2br($body);//add new lines
			$email = $rows["email"];//get email
			$date = $rows["date"];//get date
			$comment_id = $rows["comment_id"];//get comment id
			$vote_item_id = $rows["vote_item_id"];
			$html .= '
				<div class="comments_list_items">
					'.$body.'
					<div class="comments_list_items_footer">';
						$html .= '<span style="color:#000000;">by</span> '.$username;
				//		if ($edit_mode == 1){//if we are editing show the user email
				//			$html .= ' <b style="color:#000000;">('.$email.')</b> ';
				//		}
						$html .= ' <span style="color:#000000;">&bull; at</span> '.$date;
				//		if ($edit_mode == 1){//if we are editing show the delete button
				//			$html .= '&nbsp;<a style="text-decoration:none;color:#000000;" href="?action=delete&item_id='.$item_id.'&comment_id='.$comment_id.'" class="delete_comment_btn">Delete</a>';
				//		}
					$html .= '</div>
				</div>';
		}
	}else
		$html .= '<span class="p_message">This item does not have any comments yet.</span>';//nothing found so show a message
	$html .= '</div>';
	return $html;
}

/**
 * @param INT page - current page viewing
 * @param INT total_items - total vote items we have created
 * @param INT per_page - total items to show per page
 * @param VARCHAR append - URL we append to the pagination
 * starts the pagination
*/
function pagination($page, $total_items, $per_page, $append){
		$html = '';
		if ($page == null)
			$page = 1;
		$total_pages = ceil($total_items/$per_page); //get total pages count
 		if ($page > $total_pages)
			$page = $total_pages;
		if ($page <= 0)
			$page = 1;
		if ($total_pages > 1){
			$bg_color = ' style="background-color:#CCCCCC;"';
			$html .= '<span class="pagination_container">';
			if ($page > 1){
				$prev = $page - 1;
				$html .= ' <a href="'.$append.'&page='.$prev.'" class="black_link">Prev</a>';
			}
			if ($total_pages > 5){
				if ($page < 5){
					for ($i=1;$i<=5;$i++){
						if ($i == $page){
							$html .= '<a href="'.$append.'&page='.$i.'" class="p_on black_link"'.$bg_color.'>'.$i.'</a>';
						}else
							$html .= '<a href="'.$append.'&page='.$i.'" class="black_link">'.$i.'</a>';
					}
					$html .= '... <a href="'.$append.'&page='.$total_pages.'" class="black_link">'.$total_pages.'</a>';
				}else{
					$html .= '<a href="'.$append.'&page=1" class="black_link">1</a>';
					$html .= '... ';
					if ($page + 2 < $total_pages){
						for ($i=$page - 2;$i<=$page + 2;$i++){
							if ($i == $page){
								$html .= '<a href="'.$append.'&page='.$i.'" class="p_on black_link"'.$bg_color.'>'.$i.'</a>';
							}else
								$html .= '<a href="'.$append.'&page='.$i.'" class="black_link">'.$i.'</a>';
						}
						$html .= '... ';
						$html .= '<a href="'.$append.'&page='.$total_pages.'" class="black_link">'.$total_pages.'</a>';
					}else{
						$prev_page = $page;
						$min = $total_pages - $page;
						if ($min < 3){
							if ($min == 2){
								$prev_page--;
							}else if ($min == 1){
								$prev_page = $prev_page - 2;
							}else if ($min == 0){
								$prev_page = $prev_page - 3;
							}
						}
						$new_total = $total_pages - $prev_page;
						for ($i=$prev_page;$i<=$total_pages;$i++){
							if ($i == $page){
								$html .= '<a href="'.$append.'&page='.$i.'" class="p_on black_link"'.$bg_color.'>'.$i.'</a>';
							}else
								$html .= '<a href="'.$append.'&page='.$i.'" class="black_link">'.$i.'</a>';
						}
					}
				}
			}else{
				for ($i=1;$i<=$total_pages;$i++){
					if ($i == $page){
						$html .= '<a href="'.$append.'&page='.$i.'" class="p_on black_link"'.$bg_color.'>'.$i.'</a>';
					}else
						$html .= '<a href="'.$append.'&page='.$i.'" class="black_link">'.$i.'</a>';
				}
			}
			if ($page < $total_pages){
				$next = $page + 1;
				$html .= '<a href="'.$append.'&page='.$next.'" class="black_link">Next</a>';
			}
			$html .= '</span>';
		}
		return $html;
}

//get Statistics, Votes and comments of this vote
function getVotesAndComments(){
	global $settings, $page, $order;
	$upd_upvotes = isset($_POST["upd_upvotes"]) ? abs($_POST["upd_upvotes"]) : "";
	$upd_downvotes = isset($_POST["upd_downvotes"]) ? abs($_POST["upd_downvotes"]) : "";
	$vote_id = isset($_POST["vote_id_h"]) ? $_POST["vote_id_h"] : "";
	$upd_theme = isset($_POST["theme_prev_list"]) ? abs($_POST["theme_prev_list"]) : 0;
	$upd_switch_votes = isset($_POST["can_change_votes"]) ? $_POST["can_change_votes"] : "";
	$upd_revote_time = isset($_POST["time_to_revote"]) ? $_POST["time_to_revote"] : "";
	$upd_can_comment = isset($_POST["can_users_comment"]) ? $_POST["can_users_comment"] : "";
	$upd_approve_comments = isset($_POST["approve_users_comments"]) ? $_POST["approve_users_comments"] : "";
	
	//order list names
	$order_list = array(
		'date',
		'up_votes',
		'down_votes',
		'less_comments',
		'most_comments'
	);
	//if order we try is not in the list, set it to date
	if (!in_array($order, $order_list)){
		$order = "date DESC";
	}else{
		//if it is,check for comments order and fix it
		if ($order == "less_comments"){
			$orderby = 'totalComments ASC';
		}else if ($order == "most_comments"){
			$orderby = 'totalComments DESC';
		}else $orderby = $order.' DESC';
	}
	
	//add order to query
	$q = "SELECT * FROM vote_items ORDER BY $orderby";
	$total_votes = mysql_num_rows(mysql_query($q));
	
	//validate page
	if ($page < 1)
		$page = 1;
	if ($page > $total_votes && $total_votes > 0)
		$page = $total_votes;
	
	
	$per_page = $settings["votes_per_page"];
	
	//start of pagination
	$start = $per_page * ($page - 1);
	
	echo '<h1 style="display:inline-block;">Your Votes ('.$total_votes.') &raquo;<span style="float:right;"></span></h1>';
	
	//show pagination
	echo pagination($page, $total_votes, $per_page, 'vote-system.php?action=view_votes&order='.$order);
	?>
	<span class="order_list">
		<ul>
			<li><a href="vote-system.php?action=view_votes&order=date" <?php if ($order == "date") { echo 'class="active_order"'; } ?>>Date</a></li>
			<li><a href="vote-system.php?action=view_votes&order=up_votes" <?php if ($order == "up_votes") { echo 'class="active_order"'; } ?>>Up votes</a></li>
			<li><a href="vote-system.php?action=view_votes&order=down_votes" <?php if ($order == "down_votes") { echo 'class="active_order"'; } ?>>Down votes</a></li>
			<li><a href="vote-system.php?action=view_votes&order=less_comments" <?php if ($order == "less_comments") { echo 'class="active_order"'; } ?>>Comments &uarr;</a></li>
			<li><a href="vote-system.php?action=view_votes&order=most_comments" style="margin-right:5px;" <?php if ($order == "most_comments") { echo 'class="active_order"'; } ?>>Comments &darr;</a></li>
		</ul>
	</span>
	<?php
	
	//add limits
	$q .= " LIMIT $start,$per_page";
	$q = mysql_query($q);
	$nrows = mysql_num_rows($q);
	if ($nrows){
		while ($rows = mysql_fetch_assoc($q)){
			$item_name = $rows["item_name"];
			$vote_item_id = $rows["vote_item_id"];
			$up_votes = $rows["up_votes"];
			$down_votes = $rows["down_votes"];
			$comments = $rows["totalComments"];
			$theme = $rows["theme"];
			$date = $rows["date"];
			$total_votes = $up_votes + $down_votes;
			$upvotes_percentage = $downvotes_percentage = 0;
			$total_comments = $rows["totalComments"];
			
			$switch_votes = $rows["switch_votes"];
			$revote_time = $rows["time_to_revote"];
			$can_comment = $rows["can_comment"];
			$approve_comments = $rows["approve_comments"];
			
			if ($total_votes != 0)
				$upvotes_percentage = floor(($up_votes/$total_votes) * 100);
			if ($total_votes != 0)
				$downvotes_percentage = floor(($down_votes/$total_votes) * 100);
			?>
			<div class="vote_items_edit_list">
				Vote item name: <b><?php echo $item_name; ?></b> &bull; <span class="time">added at <?php echo $date; ?></span><br />
				<a href="#" class="view_item_statistics">View Statistics</a>&nbsp;&bull;
				<a href="#" class="view_item_comments">View Comments</a>&nbsp;&bull;
				<a href="#" class="view_item_votes">View Vote</a>&nbsp;&bull;
				<a href="#" class="edit_item_vote">Edit Vote</a>&nbsp;&bull;
				<a style="text-decoration:none;color:#000000;" href="?action=delete&item_id=<?php echo $vote_item_id; ?>&" class="view_item_delete">Delete</a><br />
				<?php
					if ($vote_item_id == $vote_id)
						updateVoteSettings($upd_upvotes, $upd_downvotes, $upd_theme, $vote_id, $upd_switch_votes, $upd_revote_time, $upd_can_comment, $upd_approve_comments);
				?>
				<div class="vote_items_edit_statistics">
					<h2 style="border-bottom:1px solid #CCC;">Vote Statistics &raquo;</h2>
					<label>Up Votes:</label> <b><?php echo number_format($up_votes); ?></b><label style="color:#525252;font-size:17px;">&nbsp;&raquo;&nbsp;&nbsp;&nbsp;<?php echo $upvotes_percentage; ?>%</label><br />
					<label>Down Votes:</label> <b><?php echo number_format($down_votes); ?></b><label style="color:#525252;font-size:17px;">&nbsp;&raquo;&nbsp;&nbsp;&nbsp;<?php echo $downvotes_percentage; ?>%</label><br />
					<label>Comments:</label> <b><?php echo $comments; ?></b>
				</div>
				<div class="vote_items_edit_comments">
					<?php
					echo getAdminVoteItemComments($vote_item_id);
					if ($total_comments > 15){
						echo '<div class="get_more_comments">Load More</div>';
					}
					?>
					<input type="hidden" value="<?php echo $vote_item_id; ?>" id="v_i_id" />
				</div>
				<div class="vote_items_edit_votes">
					<h2 style="border-bottom:1px solid #CCC;">Vote &raquo;</h2>
					<?php getThemeUI($theme, $up_votes, $down_votes, $vote_item_id, true); ?>
				</div>
				<div class="vote_items_edit_vote_s">
					<h2 style="border-bottom:1px solid #CCC;">Edit Vote &raquo;</h2>
					<form action="" method="post">
						<label>Up Votes:</label><input type="text" name="upd_upvotes" value="<?php echo $up_votes; ?>" /><br />
						<label>Down Votes:</label><input type="text" name="upd_downvotes" value="<?php echo $down_votes; ?>" /><br />
						<fieldset style="width:450px;">
							<legend><strong>Optional Vote Settings:</strong></legend>
							<label for="can_change_votes" style="width:auto;margin-right:20px;">Allow users to change their current vote?</label><input type="checkbox" id="can_change_votes" name="can_change_votes" <?php echo ($switch_votes == 1) ? 'checked="checked"' : ""; ?> />
							<br /><br />
							<strong>Optional: </strong>After this time users can revote(in seconds)<input type="text" name="time_to_revote" style="float:left;width:98%;margin-top:8px;" value="<?php echo $revote_time; ?>" />
							<br /><br /><br /><br />
							<label for="can_users_comment" style="width:auto;margin-right:20px;">Allow comments?</label><input type="checkbox" id="can_users_comment" name="can_users_comment" <?php echo ($can_comment == 1) ? 'checked="checked"' : ""; ?> />
							<br /><br />
							<label for="approve_users_comments" style="width:auto;margin-right:20px;">Require comments to be approved before they're posted?</label><input type="checkbox" id="approve_users_comments" name="approve_users_comments" <?php echo ($approve_comments == 1) ? 'checked="checked"' : ""; ?> />
						</fieldset><br />
						<label>Theme:</label>
						<select name="theme_prev_list" class="theme_prev_list">
							<?php
							foreach ($settings["vote_themes"] as $val){
								$id = $val-1;
								echo '<option name="'.$id.'" value="'.$id.'"';
								if ($id == $theme)
									echo ' selected="selected"';
								echo '>Theme '.$val.'</option>';
							}
							?>
						</select><br /><br />
						<div style="border:1px dashed #333333;display:inline-block;padding:3px;">
						<h2>Theme Preview &raquo;</h2>
						<?php previewThemes($theme); ?></div><br />
						<input type="submit" value="Update" name="submit" />
						<input type="hidden" value="<?php echo $vote_item_id; ?>" name="vote_id_h" />
					</form>
				</div>
			</div>
			<?php
		}
	}else
		echo '<span class="p_message">There are no votes to show yet.</span>';
}

/**
 * @param INT upvotes - vote item total up votes
 * @param INT downvotes - vote item total down votes
 * @param INT upd_thtme - theme of the updated item
 * @param INT vote_id - ID of the vote
 * updates the votes up/down votes and theme
*/
function updateVoteSettings($upvotes, $downvotes, $upd_theme, $vote_id, $switch_votes, $revote_time, $can_comment, $approve_comments){
	global $settings;
	$error = false;
	$message = '';
	if (in_array($upd_theme+1, $settings["vote_themes"])){
		$upvotes = mysql_real_escape_string($upvotes);
		$downvotes = mysql_real_escape_string($downvotes);
		
		$revote_time = abs(preg_replace("/[^0-9]+/", "", $revote_time));
		
		if ($switch_votes == "on"){
			$switch_votes = 1;
		}else $switch_votes = 0;
		
		if ($can_comment == "on"){
			$can_comment = 1;
		}else $can_comment = 0;
		
		if ($approve_comments == "on"){
			$approve_comments = 1;
		}else $approve_comments = 0;
		
		mysql_query("UPDATE
					 vote_items
					 SET
					 up_votes='$upvotes',
					 down_votes='$downvotes',
					 theme='$upd_theme',
					 switch_votes='$switch_votes',
					 time_to_revote='$revote_time',
					 can_comment='$can_comment',
					 approve_comments='$approve_comments'
					 WHERE
					 vote_item_id='$vote_id'");
	}else{
		$error = true;
		$message = 'Please select a valid theme.';
	}
	if ($error == false){
		echo '<span class="p_message">Vote Updated!</span>';
		header("Location: vote-system.php?action=view_votes");
	}else
		echo '<span class="p_message">'.$message.'</span>';
}

function requireCommentItemApproval($item_id){
	$q = mysql_query("SELECT approve_comments FROM vote_items WHERE vote_item_id='$item_id'");
	$rows = mysql_fetch_array($q);
	if ($rows[0] == 0){
		return false;
	}else
		return true;
}

function getItemVoteSwitchState($item_id, $type){
	$q = mysql_query("SELECT switch_votes FROM vote_items WHERE vote_item_id='$item_id'");
	$rows = mysql_fetch_array($q);
	$setting = $rows[0];
	if ($setting == $type){
		return true;
	}else return false;
}

/* @param username VARCHAR
 * @param email TEXT
 * @param body TEXT
 * @param vote_item_id INT vote id
 * adds a comment to this vote
*/
function addVoteComment($username, $email, $body, $vote_item_id){
	$username = mysql_real_escape_string($username);
	$email = mysql_real_escape_string($email);
	$body = mysql_real_escape_string($body);
	$comment_id = getRandomId();
	$flag = false;
	while ($flag == false){//check if the comment id exists
		$q = mysql_query("SELECT * FROM votes_comments WHERE comment_id='$comment_id'");
		$nrows = mysql_num_rows($q);
		if ($nrows){
			$comment_id = getRandomId();
		}else
			$flag = true;
	}
	if ($flag == true){
		if (requireCommentItemApproval($vote_item_id)){
			$approved = 0;
		}else $approved = 1;
		$date = date("Y-m-d H:i:s");
		mysql_query("INSERT INTO votes_comments VALUES ('', '$vote_item_id', '$comment_id', '$username', '$email', '$body', '$approved', '$date')");
		mysql_query("UPDATE vote_items SET totalComments=totalComments+1 WHERE vote_item_id='$vote_item_id'");
	}
}

//get captcha form
function newCaptcha(){
	$random1 = rand(1,9);
	$random2 = rand(1,9);
	$total = md5($random1+$random2);
	$html = '
	<label>How much does <strong>'.$random1.'</strong> and <strong>'.$random2.'</strong> do?</label>
	<input type="text" id="captcha_s" />
	<input type="hidden" value="'.$total.'" id="captcha_h" />';
	return $html;
}

//get comment form of this vote
function getNewCommentForm($item_id){
	?>
	<a href="#" class="toggle_comment_form">Toggle Comment Form</a><br />
	<div class="add_comment_container">
		<h2>Add a Comment</h2>
		<label>Username:</label><input type="text" id="reply_username" /><br />
		<label>Email:</label><input type="text" id="reply_email" /><br /><br />
		<label>Body:</label><textarea id="reply_body"></textarea><br /><br />
		<span class="captcha_content"><?php echo newCaptcha(); ?></span><br /><br />
		<input type="button" value="Add Comment" class="add_comment_btn" /><br /><br />
		<span class="a_p_message"></span><br />
		<input type="hidden" value="<?php echo $item_id; ?>" id="reply_vote_item_id" />
	</div>
	<?php
}

//get the popup window of the votes
function getCommentPopupWindow($item_id, $totalComments){
	?>
	<div class="comments_popup_window_main_container">
		<div class="comments_popup_content">
			<div class="comments_popup_header">
				<?php echo $totalComments; ?> Comments
				<input type="button" value="Close" class="popup_close_button" />
			</div>
			<div class="comments_popup_body">
				<?php
					getNewCommentForm($item_id);
					echo getVoteItemComments($item_id);
					if ($totalComments > 15){
						echo '<div class="get_more_comments">Load More</div>';
					}
				?>
				<input type="hidden" value="<?php echo $item_id; ?>" id="v_i_id" />
			</div>
			<div class="comments_popup_footer">
				<input type="button" value="Close" class="popup_close_button" />
			</div>
		</div>
	</div>
	<?php
}

//submit a new Vote
function submitVoteForm(){
	global $add_vote_btn, $code_name, $theme_selected, $settings, $can_change_votes, $time_to_revote, $can_users_comment, $approve_users_comments;
	$code_name = trim($code_name);
	$code_name = mysql_real_escape_string($code_name);
	$time_to_revote = abs(preg_replace("/[^0-9]+/", "", $time_to_revote));
	if ($add_vote_btn){//if clicked the btn
		echo '<span class="message">';
		if ($code_name != ""){//if the entered name is not null
			if (in_array($theme_selected+1, $settings["vote_themes"])){
				if (!codeNameExist($code_name)){//if the name does not exist
					$pattern = "/[^0-9A-Za-z.-_]/";
					$validator = preg_match($pattern, $code_name);//only 0-9a-zA-Z-_. allowed
					if ($validator == 0){
						$vote_item_id = getRandomId();//add the vote to db
						$flag = false;
						while ($flag == false){
							$q = mysql_query("SELECT * FROM vote_items WHERE vote_item_id='$vote_item_id'");
							$nrows = mysql_num_rows($q);
							if ($nrows){
								$vote_item_id = getRandomId();
							}else
								$flag = true;
						}
						if ($flag == true){
							if ($can_change_votes == "on"){
								$can_change_votes = 1;
							}else $can_change_votes = 0;
							
							if ($can_users_comment == "on"){
								$can_users_comment = 1;
							}else $can_users_comment = 0;
							
							if ($approve_users_comments == "on"){
								$approve_users_comments = 1;
							}else $approve_users_comments = 0;
							$date = date("Y-m-d H:i:s");
							mysql_query("INSERT INTO vote_items VALUES ('', '$vote_item_id', '$code_name', '0', '0', '0', '$theme_selected', '$can_change_votes', '$time_to_revote', '$can_users_comment', '$approve_users_comments', '$date')");//need to check for theme on last zero
							echo 'Vote has been added on the item with the code name: <b>'.$code_name.'</b><br />
								  You can use it by adding the following code on the item:<br /> getItemVotes(\''.$code_name.'\');';
						}
					}else
						echo 'Please use only a-z, A-Z, 0-9, .(dot), _ and -';
				}else
					echo 'This name already exists, if you wish to add this name on this vote, please delete the other one.';
			}else
				echo 'Please select a valid vote theme.';
		}else
			echo 'Please add a name that will represent your vote for the item.';
		echo '</span>';
	}
}

?>