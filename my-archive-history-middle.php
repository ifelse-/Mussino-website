<?php 
$sql = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);
?>

<div class="content-box-2">
    <div class="cor_1set-5"></div>
    <div class="cor_1set-6"></div>
    <div class="pro-wrapper full">
        <div class="title">
            <div class="title_wrap-1">
                <div class="title_wrap-2">
                    <div class="blue-btn-1"> <span><span><a href="<?=SITE_WS_PATH?>/<?=trim($_SESSION['SESS_ID'])?>/<?=$_SESSION['SESS_FIRST_NAME']?>" >My Profile</a></span></span> </div>
                    &raquo; Archive History </div>
            </div>
        </div>
        <div class="pro-content">
            <form id="frmEditRegistration" name="frmEditRegistration"  method="post" action="">
                <div class="pro-left fl">
                    <div class="user-img"> <a href="<?=SITE_WS_PATH?>/<?=trim($_SESSION['SESS_ID'])?>/<?=$_SESSION['SESS_FIRST_NAME']?>" >
                        <?php if(file_exists("products/user_image/$colles[Photo]") && $colles['Photo']!='') { ?>
                        <img src="products/user_image/<?php echo $colles['Photo']; ?>" border="0" width="100" height="150" />
                        <?php } else { ?>
                        <img src="images/user_big.png" border="0" width="100" height="150" />
                        <?php } ?>
                        </a>
                        <p>
                            <?=$colles['Account_Type']?>
                        </p>
                    </div>
                    <div class="pro-btn_row">
                        <?php include "left-profile.inc.php"; ?>
                    </div>
                </div>
                <div class="pro-right">
                    <div class="form-container">
                        <div class="rgtPannel2 fr">
                            <div class=" history">
                                <h2>ARCHIVE HISTORY POSTS :
                                    <?=mysql_num_rows($colles_history_result)?>
                                </h2>
                                <div class="scroller" style="margin-top:10px;">
                                    <?php 
									function findFilesize($file,$digits = 2) {
									if (is_file($file)) {
									$filePath = $file;
									if (!realpath($filePath)) {
									$filePath = $_SERVER["DOCUMENT_ROOT"].$filePath;
									}
									$fileSize = filesize($filePath);
									$sizes = array("TB","GB","MB","KB","B");
									$total = count($sizes);
									while ($total-- && $fileSize > 1024) {
									$fileSize /= 1024;
									}
									return round($fileSize, $digits)." ".$sizes[$total];
									}
									return false;
									}
							
									$ct=1;
									$k=0;
									while($colles_history_post = mysql_fetch_array($colles_history_result)) 
									{						
									$m_name = Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_history_post[Member_Account_Id]");
									$bgcolor = ($k%2==0? '#ffffff;': '#ffffff;');
									$file_path = 'products/lyrics_file/'.$colles_history_post['Audio_Lyrics_File'];
									?>
                                    <div class="postBlock" style=" padding:0 0 10px 0;background:<?=$bgcolor?>" >
                                        <h3>
                                            <?=stripslashes(Get_Single_Field("product_master","Title","Product_Id","$colles_history_post[Product_Id]"))?>
                                        </h3>
                                        <p style="padding-top:10px;">
                                            <?=stripslashes($colles_history_post['Archive_Content']) ?>
                                        </p>
                                        <p style="padding-top:10px;"> <a href="archive-history-download.php?id=<?=$colles_history_post['Member_Account_Id']?>"> <span>
                                            <?=stripslashes($colles_history_post['Lyrics_Audio_Type']);?>
                                            FILE DOWNLOAD <strong>(
                                            <?=findFilesize($file_path,'2')?>
                                            )</strong></span> </a> </p>
                                        <strong>
                                        <?=ucfirst($m_name)?>
                                        </strong> <span>
                                        <?=$colles_history_post['historyDate'];?>
                                        </span> </div>
                                    <div style="padding:5px 0 0 0;"></div>
                                    <?php
									$ct++;
									$k++;
									}
									?>
                                </div>
                            </div>
                            <?php if(mysql_num_rows($colles_history_result)>0) { ?>
                            <div>
                                <?php include "paging-in.inc.php";  ?>
                            </div>
                            <?php } ?>
							<div class=" history">
                                <h2>ARCHIVE HISTORY RECORDINGS :</h2>
								<div class="unsign_artist_video" id="recordings_vids_cntr_id">
									
								</div>
							</div>
                        </div>
                    </div>
                </div>
                <div class="cl"></div>
            </form>
        </div>
    </div>
    <div class="cor_1set-3"></div>
    <div class="cor_1set-4"></div>
</div>
<div id="inline1" style="width:420px; height:315px;display: none; text-align:center; vertical-align:middle;">
<div id="player" style="float:left; width:420px; height:315px;"></div>
</div>
<form action="" method="post" name="frmtmploader" id="frm_upload_vid_id" style="display:none; height:0px; width:0px; border:none;">
<input type="hidden" name="usr_id" value="<?php echo $_SESSION['SESS_ID'];?>" />
<input type="submit" name="tmpsbmt" style="display:none; height:0px; width:0px; border:none;" />
<input type="hidden" name="page_no" id="page_no_frm_id" value="1" />
<input type="hidden" name="act" id="act_frm_id" value="recorded_vid" />
</form>
<script type="text/javascript" src="player/jquery.fancybox.js"></script>
<link rel="stylesheet" type="text/css" href="player/jquery.fancybox.css?v=2.1.4" media="screen" />
<script type="text/javascript" src="player/flowplayer-3.2.12.min.js"></script>
<script language="javascript">
var lastflv;
function callonloadplayer(flv)
{
	lastflv=flv;
}
function callonpage(pno)
{
	$("#page_no_frm_id").val(pno);	
	loadrecordedmovies();
	return false;
}
loadrecordedmovies();
function loadrecordedmovies()
{
	$("#recordings_vids_cntr_id").html("<img src='images/loading.gif'>");		
	$.post("ajax_back.php", $("#frm_upload_vid_id").serialize(),function(data){
		var splt = data.split("{|*|}");
		$("#recordings_vids_cntr_id").html(splt[1]);

		$('.fancyboxrec').fancybox({
			title:null,
			afterLoad   : function() {
				
				//this.inner.prepend( '<h1>1. My custom title</h1>' );			
					flowplayer("player", "player/flowplayer-3.2.16.swf",{
						clip: {
							url: 'flv:'+lastflv+'.flv',
							scaling: 'fit',
							// configure clip to use hddn as our provider, referring to our rtmp plugin
							provider: 'hddn'
						},
					 
						// streaming plugins are configured under the plugins node
						plugins: {
					 
							// here is our rtmp plugin configuration
							hddn: {
								url: "player/flowplayer.rtmp-3.2.12.swf",
					 
								// netConnectionUrl defines where the streams are found
								netConnectionUrl: '<?php echo $rtmpserver;?>'
							}
						},
						canvas: {
							backgroundGradient: 'none'
						}
					});
				
			}
		});
		
  });
}
</script>