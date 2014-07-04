<?php 
require_once "config/functions.inc.php";
//require_once "session.inc.php"; 
//$pageName = basename($_SERVER['PHP_SELF']);
$start=0;
if(isset($_GET['start'])) $start=$_GET['start'];
$pagesize=5;
if($_GET['order_by']=='') { $order_by="Lyrics_Post_Audio_Id"; } else { $order_by=$_REQUEST['order_by'];}
if($_GET['order_by2']=='') { $order_by2="DESC"; } else { $order_by2=$_REQUEST['order_by2'];}
$column="SELECT *, DATE_FORMAT(Lyrics_Audio_Date,'%m/%d/%Y %h:%i %p') as historyDate ";
$sql=" FROM lyrics_post_audio_master WHERE  Member_Account_Id='".$_SESSION['SESS_ID']."'";

$sql1="SELECT count(*) as total ".$sql;
$sql=$column.$sql;
$sql.=" order by $order_by $order_by2 ";
$sql.=" limit $start, $pagesize";
//echo $sql;
$colles_history_result = executequery($sql);
$reccnt=getSingleResult($sql1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Archive History</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>
</head>

<body>
<div id="wrapper">
<script type="text/javascript" src="<?=SITE_WS_PATH?>/wz_tooltip.js"></script>
<?php include "header.middle.inc.php"; ?>
<div class="content-container">
</div>
</div>
<div class="content-box-2" style="margin:0 auto">
    <div class="cor_1set-5"></div>
    <div class="cor_1set-6"></div>
    <div class="pro-wrapper full">
            <div class="title_wrap-1">
            
		<div class=" history" style="margin:0 auto;">
				<div class="unsign_artist_video" id="recordings_vids_cntr_id">
				</div>
		</div>
		</div>
</div>
</div>
<div id="inline1" style="width:420px; height:315px;display: none; text-align:center; vertical-align:middle;">
<div id="player" style="float:left; width:420px; height:315px;"></div>
</div>
<form action="" method="post" name="frmtmploader" id="frm_upload_vid_id" style="display:none; height:0px; width:0px; border:none;">
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


<?php include "footer.inc.php"; ?>
</body>
</html>