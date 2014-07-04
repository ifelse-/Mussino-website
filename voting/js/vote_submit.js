var WWW = "/voting/";//with trailing slash - full url path to the script
//remove the background color of vote items list
function removeBackgroundColor(){
	$(".vote_items_edit_list").css("background-color", "#f0f0f0");
}
//background color of vote items list
function setBackgroundColor(me){
	me.parent().css("background-color", "#DCE38A");
}
//when we vote, get our current vote state(up or down button)
function changeButtonState(theme_id, me, vote_type){
	var btn_state;
	if (vote_type == "up"){
		btn_state = 'voted_up';
	}else
		btn_state = 'voted_down';
	
	if (theme_id >= 1 && theme_id <= 14){
		if (vote_type == "up"){
			me.parents("#item_vote_container").find(".vote_up_style"+theme_id+"_btn").addClass(btn_state+theme_id);
			me.parents("#item_vote_container").find(".vote_down_style"+theme_id+"_btn").removeClass('voted_down'+theme_id);
		}else{
			me.parents("#item_vote_container").find(".vote_up_style"+theme_id+"_btn").removeClass('voted_up'+theme_id);
			me.parents("#item_vote_container").find(".vote_down_style"+theme_id+"_btn").addClass(btn_state+theme_id);
		}
	}else if (theme_id == 0){
		if (vote_type == "up"){
			me.parents("#item_vote_container").find(".item_vote_up_btn").addClass(btn_state+theme_id);
			me.parents("#item_vote_container").find(".item_vote_down_btn").removeClass('voted_down0');
		}else{
			me.parents("#item_vote_container").find(".item_vote_up_btn").removeClass('voted_up0');
			me.parents("#item_vote_container").find(".item_vote_down_btn").addClass(btn_state+theme_id);
		}
	}
}
function showVotingLoadingBar(me){
	me.parents("#item_vote_container").find(".upv_counter").html('<img src="'+WWW+'images/v_loading.gif" alt="loading..." />');
	me.parents("#item_vote_container").find(".downv_counter").html('<img src="'+WWW+'images/v_loading.gif" alt="loading..." />');
}
function hideVotingLoadingBar(me, upvotes, downvotes){
	me.parents("#item_vote_container").find(".upv_counter").html("+"+upvotes);
	me.parents("#item_vote_container").find(".downv_counter").html("-"+downvotes);
}
$(document).ready(function(){
callonvotload();
});
function callonvotload()
{
	//vote up and down buttons
	$(".item_vote_up_btn, .item_vote_down_btn, .vote_up_style1_btn, .vote_down_style1_btn, .vote_up_style2_btn, .vote_down_style2_btn, .vote_up_style3_btn, .vote_down_style3_btn, .vote_up_style4_btn, .vote_down_style4_btn, .vote_up_style5_btn, .vote_down_style5_btn, .vote_up_style6_btn, .vote_down_style6_btn, .vote_up_style7_btn, .vote_down_style7_btn, .vote_up_style8_btn, .vote_down_style8_btn, .vote_up_style9_btn, .vote_down_style9_btn, .vote_up_style10_btn, .vote_down_style10_btn, .vote_up_style11_btn, .vote_down_style11_btn, .vote_up_style12_btn, .vote_up_style13_btn, .vote_down_style13_btn, .vote_up_style14_btn, .vote_down_style14_btn").click(function(){
		//are we up or down voting
		var vote_type = $(this).attr("id");
		var theme_id = $(this).attr("rel");
		
		//vote id
		var v_i_id = $(this).parent().find("#v_i_id").val();

		if (v_i_id == undefined)
			return false;
		var me = $(this);
		showVotingLoadingBar(me);
  		$.ajax({
			type: "POST",
			url: WWW+"ajax/ajax.php",
			dataType: 'json',
			data: {
				vote_type: vote_type,
				v_i_id: v_i_id,
				action: 'add_vote'
			},
			success: function(data){
				//if error is found, alert the message
				hideVotingLoadingBar(me, data.upvotes, data.downvotes);
				if (data.error == true){
					alert(data.message);
				}else{//else
					var total_left = data.upvotes*1 + data.downvotes*1;
					
					var percentage_left = 0;
					if (total_left != 0){
						percentage_left = (data.upvotes/total_left);						
						percentage_left = percentage_left*100;
						percentage_left = parseInt(percentage_left);
					}
					$(".map_votes_percent").html(percentage_left+"%");
					if (vote_type == "up" || vote_type == "down"){
						if (theme_id == 14){
							var total = data.upvotes*1 + data.downvotes*1;
							var percentage = 0;
							if (total != 0){
								percentage = (data.upvotes/total);
								percentage = percentage*100;
								percentage = parseInt(percentage);
							}
							me.parents("#item_vote_container").find(".upv_counter").html("+"+percentage+"%");
						}else
							me.parents("#item_vote_container").find(".upv_counter").html("+"+data.upvotes);
						me.parents("#item_vote_container").find(".downv_counter").html("-"+data.downvotes);
						if (theme_id == 13 || theme_id == 14){
							var total = data.upvotes*1 + data.downvotes*1;
							me.parents("#item_vote_container").find(".t"+theme_id+"_total_votes").html(total);
						}
						changeButtonState(theme_id, me, vote_type);
					}
				}
			}
		});
	});
	$(".view_item_delete, .delete_comment_btn").click(function(){
		if (confirm("Are you sure you want to delete this item?")){
			return true;
		}else return false;
	});
	//if we select another theme from the preview list , show it and hide the previous
	$(".theme_prev_list").change(function(){
		var name = $(this).find("option:selected").attr("name");
		if (name != undefined){
			$(".themes_preview").hide();
			$(this).parent().find(".theme_p_"+name).show();
		}
	});
	//adding a new comment
	$(".add_comment_btn").click(function(){
		var v_i_id = $(this).parent().find("#reply_vote_item_id").val();//vote id
		var username = $(this).parent().find("#reply_username");//username
		var email = $(this).parent().find("#reply_email");//email
		var body = $(this).parent().find("#reply_body");//body
		var captcha_s = $(this).parent().find("#captcha_s");
		var captcha_h = $(this).parent().find("#captcha_h");
		var me = $(this);
  		$.ajax({
			type: "POST",
			url: WWW+"ajax/ajax.php",
			dataType: 'json',
			data: {
				username: username.val(),
				email: email.val(),
				body: body.val(),
				captcha_s: captcha_s.val(),
				captcha_h: captcha_h.val(),
				v_i_id: v_i_id,
				action: 'add_comment'
			},
			success: function(data){
				me.parent().parent().find(".captcha_content").html(data.captcha_new);
				if (data.error == true){//if errors show them
					$(".a_p_message").html(data.message).css("display", "inline-block");
				}else{
					username.val('');//remove my username from the input
					email.val('');//also my email
					body.val('');//and my comment body
					if (data.rq == false){
						//show the comment
						$(data.message).hide().prependTo(me.parents(".comments_popup_body").find(".vote_items_comments_list")).fadeIn("slow");
					}else{
						$(".a_p_message").html(data.message).css("display", "inline-block");
					}
				}
			}
		});
	});
	//clicking on a vote item container, remove the bg from the others
	//and show the current one
	$(".vote_items_edit_list").click(function(){
		removeBackgroundColor();
		$(this).css("background-color", "#DCE38A");
	});
	//load more comments of this vote
	$(".get_more_comments").click(function(){
		var v_i_id = $(this).parent().find("#v_i_id").val();
		var total_divs = 0;
		$(this).prev().find(".comments_list_items").each(function() {
			total_divs++;
		});
		var me = $(this);
  		$.ajax({
			type: "POST",
			url: WWW+"ajax/ajax.php",
			dataType: 'json',
			data: {
				action: 'load_comments',
				current_total: total_divs,
				v_i_id: v_i_id
			},
			success: function(data){
				//if we still have results to show, append them
				if (data.message != 'done'){
					me.prev().append(data.message);
				}else me.remove();//else remove the button since we are done
			}
		});
	});
	//show or hide the vote
	$(".view_votes_toggle").live('click', function(){
		removeBackgroundColor();
		setBackgroundColor($(this));
		if ($(this).parent().prev().is(":visible")){//if visible
			$(this).parent().prev().fadeOut("fast");//hide it
		}else{
			$(this).parent().prev().fadeIn("fast");//show it
		}
		return false;
	});
	//show comments popup
	$(".current_marker_info .view_votes_comments_toggle").click(function(){

		e.preventDefault();
		$(".add_comment_container").hide();
		$(".a_p_message").html('');
		$(".a_p_message").hide();
		$(".comments_popup_window_main_container").each(function(){
			if ($(this).is(":visible")){
				$(this).fadeOut("fast");
			}
		});
		if ($(this).parent().parent().next().is(":visible")){//if visible
			$(this).parent().parent().next().fadeOut("fast");//hide it
		}else{
			$(this).parent().parent().next().fadeIn("fast");//show it
		}
		return false;
	});
	//close the popup window
	$(".popup_close_button").click(function(){
		$(this).parents(".comments_popup_window_main_container").fadeOut("fast");
	});
	//dont close the popup when clicking on it
	$(".comments_popup_window_main_container").click(function(e){
		e.stopPropagation();
	});
	//toggle the comment form
	$(".toggle_comment_form").click(function(e){
		e.preventDefault();
		if ($(this).next().next().is(":visible")){
			$(this).next().next().hide();
		}else{
			$(this).next().next().css("display", "inline-block");
		}
		return false;
	});
	//toggle the vote statistics
	$(".view_item_statistics").click(function(){
		removeBackgroundColor();
		setBackgroundColor($(this));
		if ($(this).parent().find(".vote_items_edit_statistics").is(":visible")){
			$(this).parent().find(".vote_items_edit_statistics").hide();
		}else
			$(this).parent().find(".vote_items_edit_statistics").show();
		return false;
	});
	//toggle the vote comments
	$(".view_item_comments").click(function(){
		removeBackgroundColor();
		setBackgroundColor($(this));
		if ($(this).parent().find(".vote_items_edit_comments").is(":visible")){
			$(this).parent().find(".vote_items_edit_comments").hide();
		}else
			$(this).parent().find(".vote_items_edit_comments").show();
		return false;
	});
	//toggle the vote votes
	$(".view_item_votes").click(function(){
		removeBackgroundColor();
		setBackgroundColor($(this));
		if ($(this).parent().find(".vote_items_edit_votes").is(":visible")){
			$(this).parent().find(".vote_items_edit_votes").hide();
		}else
			$(this).parent().find(".vote_items_edit_votes").show();
		return false;
	});
	//edit the vote
	$(".edit_item_vote").click(function(){
		removeBackgroundColor();
		setBackgroundColor($(this));
		if ($(this).parent().find(".vote_items_edit_vote_s").is(":visible")){
			$(this).parent().find(".vote_items_edit_vote_s").hide();
		}else
			$(this).parent().find(".vote_items_edit_vote_s").show();
		return false;
	});
}