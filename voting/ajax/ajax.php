<?php
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	define("auth", true);
	include_once '../config/config.php';
	include('../vote-system.php');
	$action = isset($_POST["action"]) ? mysql_real_escape_string($_POST["action"]) : "";//action to check what we are doing
	$action = preg_replace("/[^a-z_]+/", "", $action);
	$item_id = isset($_POST["v_i_id"]) ? mysql_real_escape_string($_POST["v_i_id"]) : "";//vote id
	$item_id = preg_replace("/[^0-9]+/", "", $item_id);
	$error = false;//no errors found at start
	$message = $upvotes = $downvotes = '';//no message to return at start
	//we send json
	header('Content-type: application/json');
	if ($action == "add_vote"){//if we are voting
		$vote_type = isset($_POST["vote_type"]) ? $_POST["vote_type"] : "";//are we Up or Down voting?
		$vote_type = preg_replace("/[^a-z]+/", "", $vote_type);
		if ($vote_type != "" && $item_id != ""){//if vote type and its id is not null
			if (VoteItemExist($item_id)){//if the vote exists
				if (getItemVoteSwitchState($item_id, 0)){
					if (!alreadyVoted($item_id)){//if we havent already voted
						if ($vote_type == "up"){//if we selected to up vote
							UpVoteItem($item_id);//upvote it
							$message .= 'You have up voted this item.';
						}else if ($vote_type == "down"){//otherwise
							DownVoteItem($item_id);//down vote it
							$message .= 'You have down voted this item.';
						}else{
							$error = true;//else if not up or down entered, throw error
							$message .= 'Please select your vote type.';
						}
					}else{
						$time = getVoteItemRevoteTime($item_id);
						if ($time == 0){
							$error = true;
							$message .= 'You have already voted on this item.';
						}else{
							$last_v_time = getLastUserVoteTime($item_id);
							$curr_time = time() - $last_v_time;
							if ($curr_time > $time){
								if ($vote_type == "up"){
									if (getUserVote($item_id) == 1){
										addNewRevote($item_id, "up");
										$message .= 'You have up voted this item.';
									}else{
										$error = true;
										$message .= 'You can only down vote this item.';
									}
								}else if ($vote_type == "down"){
									if (getUserVote($item_id) == 0){
										addNewRevote($item_id, "down");
										$message .= 'You have down voted this item.';
									}else{
										$error = true;
										$message .= 'You can only up vote this item.';
									}
								}else{
									$error = true;//else if not up or down entered, throw error
									$message .= 'Please select your vote type.';
								}
							}else{
								$left = $time - $curr_time;
								$error = true;
								$message .= 'You cant revote for the next '.number_format($left).' seconds';
							}
						}
					}
				}else if (getItemVoteSwitchState($item_id, 1)){
					if (!alreadyVoted($item_id)){//if we havent already voted
						if ($vote_type == "up"){//if we selected to up vote
							UpVoteItem($item_id);//upvote it
							$message .= 'You have up voted this item.';
						}else if ($vote_type == "down"){//otherwise
							DownVoteItem($item_id);//down vote it
							$message .= 'You have down voted this item.';
						}else{
							$error = true;//else if not up or down entered, throw error
							$message .= 'Please select your vote type.';
						}
					}else{;
						if (getUserVote($item_id) == 0){//down voted
							if ($vote_type == "up"){
								$user_ip = ip2long(getUserIP());
								mysql_query("UPDATE votes_done SET vote_type='1' WHERE user_ip='$user_ip' && vote_item_id='$item_id'");
								mysql_query("UPDATE vote_items SET up_votes=up_votes+1, down_votes=down_votes-1 WHERE vote_item_id='$item_id'");
								$message .= 'You have up voted this item.';
							}else{
								$time = getVoteItemRevoteTime($item_id);
								if ($time == 0){
									$error = true;
									$message .= 'You cant double Down vote this item.';
								}else{
									$last_v_time = getLastUserVoteTime($item_id);
									$curr_time = time() - $last_v_time;
									if ($curr_time > $time){
										addNewRevote($item_id, "down");
										$message .= 'You have down voted this item.';
									}else{
										$left = $time - $curr_time;
										$error = true;
										$message .= 'You cant revote for the next '.number_format($left).' seconds';
									}
								}
							}
						}else if (getUserVote($item_id) == 1){//up voted
							if ($vote_type == "down"){
								$user_ip = ip2long(getUserIP());
								mysql_query("UPDATE votes_done SET vote_type='0' WHERE user_ip='$user_ip' && vote_item_id='$item_id'");
								mysql_query("UPDATE vote_items SET up_votes=up_votes-1, down_votes=down_votes+1 WHERE vote_item_id='$item_id'");
								$message .= 'You have down voted this item.';
							}else{
								$time = getVoteItemRevoteTime($item_id);
								if ($time == 0){
									$error = true;
									$message .= 'You cant double Up vote this item.';
								}else{
									$last_v_time = getLastUserVoteTime($item_id);
									$curr_time = time() - $last_v_time;
									if ($curr_time > $time){
										addNewRevote($item_id, "up");
										$message .= 'You have up voted this item.';
									}else{
										$left = $time - $curr_time;
										$error = true;
										$message .= 'You cant revote for the next '.number_format($left).' seconds';
									}
								}
							}
						}else{
							$error = true;
							$message .= 'Please try again later.';
						}
					}
				}else{
					$error = true;
					$message .= 'Please try again later.';
				}
			}else{
				$error = true;
				$message .= 'This item does not exist.';
			}
		}else{
			$error = true;
			$message .= 'Please try again later.';
		}
		$votes = returnItemVotes($item_id);
		$upvotes = $votes["upvotes"];
		$downvotes = $votes["downvotes"];
		$array = array(
			'error' => $error,
			'message' => $message,
			'upvotes' => $upvotes,
			'downvotes' => $downvotes,
		);
		echo json_encode($array);
		return;
	}else if ($action == "add_comment"){//if we are adding a new comment
		$username = isset($_POST["username"]) ? $_POST["username"] : "";//get username
		$email = isset($_POST["email"]) ? $_POST["email"] : "";//get email
		$body = isset($_POST["body"]) ? $_POST["body"] : "";//get body
		$captcha_solve = isset($_POST["captcha_s"]) ? $_POST["captcha_s"] : "";//get captcha entered
		$captcha_solved = isset($_POST["captcha_h"]) ? $_POST["captcha_h"] : "";//get captcha hashed - solved
		$username = trim($username);//remove spaces
		$email = trim($email);
		$body = trim($body);
		$captcha_new = '';
		$req_approval = false;
		if (VoteItemExist($item_id)){
			if (canComment($item_id)){
				if ($username != "" && $email != "" && $body != "" && $captcha_solve != "" && $captcha_solved != ""){//if entered something
					if (md5($captcha_solve) == $captcha_solved){
						if (strlen($username) >= 1 && strlen($username) <= 200){//allowed length of username is 1 and 200
							if(!filter_var($email, FILTER_VALIDATE_EMAIL))//not entered a valid email
							{
								$error = true;
								$message .= 'Please enter a valid email address.';
							}else{//else entered a valid email
								if (strlen($body) >= 1 && strlen($body) <= 5000){//allowed length of body is 1 and 5k
									addVoteComment($username, $email, $body, $item_id);//add the comment
									$body = htmlentities($body, ENT_COMPAT, 'UTF-8');//utf 8 it to show it live to the user
									$username = htmlentities($username, ENT_COMPAT, 'UTF-8');
									if (requireCommentItemApproval($item_id)){
										$message = 'Your comment has been added, however it needs to be approved first.';
										$req_approval = true;
									}else{
										$message .= '
										<div class="comments_list_items">
											'.$body.'
											<div class="comments_list_items_footer">
												<span style="color:#000000;">by</span> '.$username.' <span style="color:#000000;">&bull;</span> 0 seconds ago
											</div>
										</div>
										';
									}
								}else{
									$error = true;
									$message .= 'Your comment body must be between 1 and 5k characters.';
								}
							}
						}else{
							$error = true;
							$message .= 'Your username must be between 1 and 200 characters.';
						}
					}else{
						$error = true;
						$message .= 'Please enter the correct captcha.';
					}
				}else{
					$error = true;
					$message .= 'Please fill in all fields.';
				}
			}else{
				$error = true;
				$Message .= 'You cant comment on this item.';
			}
		}else{
				$error = true;
				$message .= 'This vote item does not exist.';
		}
		$captcha_new = newCaptcha();
		$array = array(
			'error' => $error,
			'message' => $message,
			'captcha_new' => $captcha_new,
			'rq' => $req_approval
		);
		echo json_encode($array);
		return;
	}else if ($action == 'load_comments'){
		//load more comments of this item
		$current_total = isset($_POST["current_total"]) ? $_POST["current_total"] : "";//current total divs
		$current_total = preg_replace("/[^0-9]+/", "", $current_total);
		if ($current_total != "" && $item_id != ""){//if vote type and its id is not null
			if (VoteItemExist($item_id)){//if the vote exists
				$data = getVoteItemComments($item_id, $current_total);
				if ($data != '<div class="vote_items_comments_list"><span class="p_message">This item does not have any comments yet.</span></div>'){
					$message = $data;
				}else $message = 'done';
			}else{
				$error = true;
				$message .= 'This item does not exist.';
			}
		}else{
			$error = true;
			$message .= 'Please try again later.';
		}
		
	}else if ($action == 'load_vote'){
		ob_start();
		getItemVotes($_POST['itmid']);
		$vote_str = ob_get_clean();
		$message = $vote_str;		
	}
	//array to store the object we send back
	$array = array(
		'error' => $error,
		'message' => $message
	);
	//and encode it
	echo json_encode($array);
}else die();
?>