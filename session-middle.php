<?php
include("includes/rating_functions.php"); 
if($_SESSION['SESS_ACCOUNT_TYPE']=='Musician') 
{ 
$ACOUNT = 'Active Session'; 
} 
elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Contest Judge') 
{ 
$ACOUNT = 'Judge'; 
}
elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Artist') 
{ 
$ACOUNT = 'Enter Session'; 
}

function get_time_difference( $start, $end )
{
    $uts['start']      =    strtotime( $start );
    $uts['end']        =    strtotime( $end );
    if( $uts['start']!==-1 && $uts['end']!==-1 )
    {
        if( $uts['end'] >= $uts['start'] )
        {
            $diff    =    $uts['end'] - $uts['start'];
            if( $days=intval((floor($diff/86400))) )
                $diff = $diff % 86400;
            if( $hours=intval((floor($diff/3600))) )
                $diff = $diff % 3600;
            if( $minutes=intval((floor($diff/60))) )
                $diff = $diff % 60;
            $diff    =    intval( $diff );            
            return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
        }
        else
        {
            trigger_error( "Ending date/time is earlier than the start date/time", E_USER_WARNING );
        }
    }
    else
    {
        trigger_error( "Invalid date/time data detected", E_USER_WARNING );
    }
    return( false );
}

$sql_notes = "SELECT sum(a.No_Of_Package) as notesTotal FROM package_master a LEFT JOIN package_history_master b ON (a.Package_Id=b.Package_Id)
              WHERE a.Status='1' AND b.Status='1' AND b.Member_Account_Id='".$_SESSION['SESS_ID']."'";
$result_notes = mysql_query($sql_notes);
if(mysql_num_rows($result_notes)>0)
{
    $colles_notes = mysql_fetch_array($result_notes);
	$NOTES = $colles_notes['notesTotal'];
	$sql_bank_notes = "SELECT sum(Notes_Value) as bankNotesTotal FROM my_bank WHERE From_Member_Account_Id='".$_SESSION['SESS_ID']."'";
	$result_bank_notes = mysql_query($sql_bank_notes);
	$colles_bank_notes = mysql_fetch_array($result_bank_notes);
	if(mysql_num_rows($result_bank_notes)>0)
	{
	$BANK_NOTES = $colles_bank_notes['bankNotesTotal'];
	}
	else
	{
	$BANK_NOTES = 0;
	}
	$TOTAL_NOTES = $NOTES-$BANK_NOTES;
}
else
{
   $TOTAL_NOTES = 0;
}
					  
$session_validate = "SELECT Member_Account_Id FROM product_master WHERE Status=1 AND Session_End_Date >= CURDATE() GROUP BY Member_Account_Id";
$result_validate = mysql_query($session_validate);
$session_num_validate = mysql_num_rows($result_validate);
$date = date('Y-m-d');
if($_GET['order_by']=='') { $order_by="Product_Id"; } else { $order_by=$_REQUEST['order_by'];}
if($_GET['order_by2']=='') { $order_by2="DESC"; } else { $order_by2=$_REQUEST['order_by2'];}

$column="SELECT Product_Id, Member_Account_Id, Category_Id,	Title,Royalties,Posts,Judges_Vote, Product_Notes, Sound, Type, Image_Name, Short_FIle_Name, Long_FIle_Name, Short_Desc, Long_Desc, Price,	Session_Start_Date, Session_End_Date, DATE_FORMAT(Session_Start_Date,'%m/%d/%Y %h:%i %p') as StartDate, DATE_FORMAT(Session_End_Date,'%m/%d/%Y %h:%i %p') as EndDate, Product_Date, Status, Jack_Pot, Jack_Pot_Status ";

$sql=" FROM product_master  WHERE  1=1 AND Type!=3 AND '$date' between DATE_FORMAT(Session_Start_Date,'%Y-%m-%d') AND DATE_FORMAT(Session_End_Date,'%Y-%m-%d') ";
if($_REQUEST['id']!='')
{
$sql .=" AND Category_Id ='".$_REQUEST['id']."'";	
}
if($_REQUEST['sound']!='')
{
$sql .=" AND Sound = '".$_REQUEST['sound']."'";
}

$sql1="SELECT count(*) as total ".$sql;
$sql=$column.$sql;
$sql.=" order by $order_by $order_by2 ";
$sql.=" limit $start, $pagesize";
#echo $sql;
$result=executequery($sql);
$reccnt=getSingleResult($sql1);

?>
<link href="css/rating_style.css" rel="stylesheet" type="text/css" media="all">
<script type="text/javascript" src="js/rating_update.js"></script>
<div id="page-wrapper">
  <div class="layoutArea">
    <div class="contentArea">
    <div class="content-box-2 white">
        <div class="cor_1set-7"></div>
        <div class="cor_1set-8"></div>
        <div class="black-btn" id="view_songs"></div>
        <div class="pro-wrapper">
          <h2><?=($_GET['id']!='')?Get_Single_Field("category_master","Category_Name","Category_Id","$_REQUEST[id]"):'';?><!--: <span>Hardcore</span>--></h2>
          <p>Mussino.com allows you to collaborate with other musicians anywhere in the world. Here you will find tons of active sessions available for you to enter. Search through session guide to find a session that suites your interest. Once you start participating in sessions you will be able to track progress in your profile control panel.</p>
         
         <?php if($reccnt>15) { ?>
          <div>
            <?php require_once("paging.inc.php"); ?>
          </div>
          <?php } ?>
          <?php
		  $t=1;
		  if(mysql_num_rows($result)>0)
		  {
		  while($colles_sound_type1 = mysql_fetch_array($result))
		  {
		    
			$sqlAudioCount = "SELECT COUNT(*) AS CtotalAudio FROM lyrics_post_audio_master WHERE Product_Id='".$colles_sound_type1['Product_Id']."' AND Lyrics_Audio_Type='AUDIO' AND Status=1";
			$resAudioCount = mysql_query($sqlAudioCount);
			$collesAudioCount = mysql_fetch_array($resAudioCount);
			$sqlVideoCount = "SELECT COUNT(*) AS CtotalVideo FROM lyrics_post_audio_master WHERE Product_Id='".$colles_sound_type1['Product_Id']."' AND Lyrics_Audio_Type='VIDEO' AND Status=1";
			$resVideoCount = mysql_query($sqlVideoCount);
			$collesVideoCount = mysql_fetch_array($resVideoCount);
			$sqlTextCount = "SELECT COUNT(*) AS CtotalText FROM lyrics_post_master WHERE Product_Id='".$colles_sound_type1['Product_Id']."' AND Status=1";
			$resTextCount = mysql_query($sqlTextCount);
			$collesTextCount = mysql_fetch_array($resTextCount);
			
			$totalPosts = $collesAudioCount['CtotalAudio'] + $collesVideoCount['CtotalVideo'] + $collesTextCount['CtotalText'];
			
		  ?>
         <div class="pro-box_wrapper">
        <div class="pro-box">
          <div class="cor_2set-1"></div>
          <div class="cor_2set-2"></div>
          <div class="pro-box_wrap-1">
            <div class="pro-box_wrap-2">
              <div class="pro-box_wrap-3">
                <div class="pro-img-row">
                  <div class="pro-img">
                  <a href="product-detail.php?id=<?=$colles_sound_type1['Product_Id']?>" title="<?=stripslashes($colles_sound_type1['Title'])?>">
                  <?php if(file_exists("products/product_image/$colles_sound_type1[Image_Name]") && $colles_sound_type1['Image_Name']!='') { ?>
                 <img src="products/product_image/<?php echo $colles_sound_type1['Image_Name']; ?>" border="0"  alt="<?=stripslashes($colles_sound_type1['Title'])?>" width="100" height="100"/>
                 <?php } else { ?>
                 <img src="images/no-image.gif" border="0"  alt="<?=stripslashes($colles_sound_type1['Title'])?>" width="100" height="100"/>
                 <?php } ?> 
                 </a> 
                  </div>
                  <?php if($_SESSION['SESS_ACCOUNT_TYPE']=='Contest Judge') { // I 2.0?>
                    <!--<div class="thumbs">-->
                    <script language="javascript">
                    function createObject(){
                    if(window.XMLHttpRequest){
                    var obj	= new XMLHttpRequest();
                    }else{
                    var obj	= new ActiveXObject('Microsoft.XMLHTTP');
                    }
                    return obj;
                    }
                    var httpobj	= createObject();
                    function ajaxThumpsRating<?=$t?>(toid,fromid,pid,type,value){
                    
                    document.getElementById('view_thumps_rating<?=$t?>').innerHTML ='<img src="images/loading.gif" alt="" />';
                    
                    httpobj.open('get',"ajax_thumps-reting.php?toid="+toid+"&fromid="+fromid+"&pid="+pid+"&type="+type+"&value="+value);
                    httpobj.onreadystatechange	= handleThumpsRatingResponse<?=$t?>;
                    httpobj.send("");
                    }
                    function handleThumpsRatingResponse<?=$t?>()
                    {
                    if(httpobj.readyState==4){
                    var text = httpobj.responseText;
                    document.getElementById('view_thumps_rating<?=$t?>').innerHTML = text;
                    
                    document.getElementById('view_thumps_rating<?=$t?>').style.display = 'block';
                    var sharedLoader1 = document.getElementById('view_thumps_rating<?=$t?>'); //div auto hide made by vishwas just chill
                    var timeoutLoader1 = window.setTimeout(function(){sharedLoader1.style.display = 'none';}, 2000);
                    }
                    }
                    </script>
                    <div id="view_thumps_rating<?=$t?>"></div>
                    <div class="thumbs" style="float:right; padding: 5px 0 2px 5px;" align="center">
                    <a href="javascript:void(0);" onclick="ajaxThumpsRating<?=$t?>('<?=$colles['Member_Account_Id']?>','<?=$_SESSION['SESS_ID']?>','<?=$colles['Product_Id']?>','<?=$_SESSION['SESS_ACCOUNT_TYPE']?>','-1')"><img src="images/notuseful.jpg" alt="Down"  /></a>
                   <span style="padding: 0 0 0 5px;"></span>
                    <a href="javascript:void(0);" onclick="ajaxThumpsRating<?=$t?>('<?=$colles['Member_Account_Id']?>','<?=$_SESSION['SESS_ID']?>','<?=$colles['Product_Id']?>','<?=$_SESSION['SESS_ACCOUNT_TYPE']?>','1')"><img src="images/useful.jpg" alt="Up"  /></a>
                    
                    </div>
                    
                    <?php } else { ?>
                    <div class="thumbs" style="float:right; padding: 5px 0 2px 5px;" align="center">
                    
                    <a href="javascript:void(0);" onmouseover="Tip('Only Contest Judge Member Thumps Down Vote')" onmouseout="UnTip()"><img src="images/notuseful.jpg" alt="Down"  /></a>               <span style="padding: 0 0 0 5px;"></span>
                    <a href="javascript:void(0);" onmouseover="Tip('Only Contest Judge Member Thumps Up Vote')" onmouseout="UnTip()"><img src="images/useful.jpg" alt="Up"  /> </a>
                    
                    </div>
                    <?php } ?>
                </div>
                <div class="pro-info">
                    <ul>
                      <li>
                        <div class="caption-1">Musician</div>
                        <div class="detail-1"><a href="<?=SITE_WS_PATH?>/<?=trim($colles_sound_type1['Member_Account_Id'])?>/<?=ucfirst(stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_sound_type1[Member_Account_Id]")))?>" >
						
                        
                        <?=substr(ucfirst(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_sound_type1[Member_Account_Id]")),0,12)?>
                          <?php if(strlen(ms_stripslashes(ucfirst(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_sound_type1[Member_Account_Id]"))))>=12){ echo ".."; }?>
                        
                        </a></div>
                        <div class="cl"></div>
                      </li>
                      <li>
                      <div class="caption-1">Sound</div>
                      <div class="detail-1"><a href="session.php?sound=<?=$colles_sound_type1['Sound']?>"><?=Get_Single_Field("sound_type_master","Sound_Type_Name","Sound_Type_Id","$colles_sound_type1[Sound]")?></a></div>
                      <div class="cl"></div>
                    </li>
                    <li>
                        <div class="caption-1" style="color:#F30">Credits</div>
                        <div class="detail-1"><strong style="color:#F30"><?=$colles_sound_type1['Product_Notes'];?></strong></div>
                        <div class="cl"></div>
                    </li>
                      <li>
                        <div class="caption-1">Genres</div>
                        <div class="detail-1"><a title="<?=stripslashes(Get_Single_Field("category_master","Category_Name","Category_Id","$colles_sound_type1[Category_Id]"))?>" href="session.php?id=<?=$colles_sound_type1['Category_Id']?>"><?=stripslashes(Get_Single_Field("category_master","Category_Name","Category_Id","$colles_sound_type1[Category_Id]"))?></a></div>
                        <div class="cl"></div>
                      </li>
                      <?php if($colles_sound_type1['Type']!='3') { ?>
                      <li>
                        <div class="caption-1">Songwriters</div>
                        <div class="detail-1"><?=$totalPosts+$colles_sound_type1['Posts'];?></div>
                        <div class="cl"></div>
                      </li>
                      <?php } else { ?>
                      <li>
                        <div class="caption-1">Details</div>
                        <div class="detail-1"><?=stripslashes(substr($colles_sound_type1['Short_Desc'],0,50))?> <?php if(strlen($colles_sound_type1['Short_Desc'])>50) { echo '...'; }?></div>
                        <div class="cl"></div>
                      </li>
                      <?php } ?>
                    </ul>
                    <script language="javascript">
					function createObject(){
					  if(window.XMLHttpRequest){
						var obj	= new XMLHttpRequest();
					  }else{
						var obj	= new ActiveXObject('Microsoft.XMLHTTP');
					  }
					 return obj;
					}
					
					var httpobj	= createObject();
					function ajaxSubmitReview<?=$t?>(pid){

					var dd = document.getElementById('Review_Desc<?=$t?>').value;
					
					httpobj.open('get',"ajax_submit_review.php?dd="+dd+"&pid="+pid);
					httpobj.onreadystatechange	= handleSubmitReviewResponse<?=$t?>;
					httpobj.send("");
					
					}
					
					function handleSubmitReviewResponse<?=$t?>(){
					
					if(httpobj.readyState==4){
					var text = httpobj.responseText;
					if(text=='Please Enter Review')
					{
					document.getElementById('show_review<?=$t?>').innerHTML = text;
					}
					else
					{
					location.replace('<?=$urls?>');
					}
					
					}
					}
					function showStuff(id) {
						document.getElementById(id).style.display = 'block';
						
					}
					function hideStuff(id) {
						document.getElementById(id).style.display = 'none';
					}
					$(document).ready(function(){
					try{
					$("#variousReview<?=$t?>").fancybox({
						'overlayShow'	: true,
						'transitionIn'	: 'elastic',
						'transitionOut'	: 'elastic'	});
					}catch(e)	{}
			         });
					 
				</script>
					<?php
                    $sql_review = "SELECT count(*) as totalReview FROM review_master WHERE Product_Id='".$colles['Product_Id']."' ";
                    $result_review = mysql_query($sql_review);
                    $colles_review = mysql_fetch_array($result_review);
                    ?>
                    <div class="review"><a href="javascript:void(0);" ><?=$colles_review['totalReview'];?> Review(s)</a> | <a id="variousReview<?=$t?>" href="#requestReview<?=$t?>">Add Your Review</a>
                                    
                    
                    
                    <div style="display: none;">
                            <div id="requestReview<?=$t?>" style="width:450px;height:250px;">
                                <div style="padding: 5px 0 0 100px;" >
                                <form id="frmReview" name="frmReview"  method="post" action="">
                                <ul>
                                    
                                    <li>
                                        <ul class="login">
                                            <li><h1>Give Your Review</h1></li>
                                            <li></li>
                                        </ul>
                                    </li>
                                    
                                    <li  id="show_review<?=$t?>" style="padding: 5px 0 5px 0; color:#FF0000;"></li>
                                    
                                    
                                    <li>
                                        <ul class="login">
                                            <li></li>
                                            <li><textarea name="Review_Desc<?=$t?>" id="Review_Desc<?=$t?>" cols="40" rows="6"></textarea></li>
                                        </ul>
                                    </li>
                                    
                                    <li>
                                        <ul class="login">
                                            <li>&nbsp;</li>
                                            <li><input class="button" name="buttonSubmit" type="button" value="Review" onclick="ajaxSubmitReview<?=$t?>('<?=$colles_sound_type1['Product_Id']?>');" onkeypress="if(event.keyCode==13) {return ajaxSubmitReview<?=$t?>('<?=$colles_sound_type1['Product_Id']?>');}"></li>
                                        </ul>
                                    </li>
                                </ul>
                            </form>
                                </div>
                            </div>
                       </div>
                    </div>
                    
                    <div class="vote"><?php echo pullRating($colles_sound_type1['Product_Id'],false,true,true); ?></div>
                    <div class="rating">
                     <!-- Rating-->
                    </div>
                  </div>
                  <div class="cl"></div>
                  <div class="jackpot">
                    <?php $TOTAL_ROYALTIES = ($colles_sound_type1['Product_Notes']*$totalPosts)+$colles_sound_type1['Royalties']; ?>
                  
                   <?php if($colles_sound_type1['Price']!='3') { ?> <img src="<?=SITE_WS_PATH?>/images/moneyBag.jpg" width="25" style="margin-top:-4px; position: absolute;" /><span><span style="margin-left:30px;">Royalties: $<?=$TOTAL_ROYALTIES;?></span></span> <?php } else { ?> <span><span>$<?=trim($colles_sound_type1['Price'])?></span></span><?php } ?>
                  </div>
                  <?php if($colles_sound_type1['Type']!='3') { ?>
                  <div class="time">
					
                  	<img src="<?=SITE_WS_PATH?>/images/timer.jpg" width="27" style="margin-top:-1px; position: absolute;" /> 
					<script language="JavaScript">
					// This short script gets the date/time from the server and prints it
					var deltaD = (servertimeOBJ.getTime())-(new Date().getTime());
					var clientDate = new Date();
					var serverdate = new Date(clientDate.getTime()+deltaD);
					// At this point serverdate can be used for all date/time references in the rest of the script.
					// The math above corrects its value for the the client's local time offset.
					var hours=serverdate.getHours();
					var minutes=serverdate.getMinutes();
					var seconds=serverdate.getSeconds();
					var dn="AM";
					if (hours>=12){dn="PM";}
					if (hours>12){hours=hours-12;}
					if (hours==0){hours=12;}
					if (minutes<=9){minutes="0"+minutes;}
					var cdate=hours+":"+minutes+" "+dn;
					//document.write(cdate);
					
					///alert(serverdate);
					
					
                    TargetDate<?=$t?> = "<?=$colles_sound_type1['EndDate'];?>";
                    BackColor<?=$t?> = "#FFFFFF";
                    ForeColor<?=$t?> = "";
                    CountActive<?=$t?> = true;
                    CountStepper<?=$t?> = -1;
                    LeadingZero<?=$t?> = true;
                    DisplayFormat<?=$t?> = "%%D%% Days, %%H%% : %%M%% : %%S%% ";
                    FinishMessage<?=$t?> = "Close";
                    
                    function calcage<?=$t?>(secs<?=$t?>, num1<?=$t?>, num2<?=$t?>) {
                    s<?=$t?> = ((Math.floor(secs<?=$t?>/num1<?=$t?>))%num2<?=$t?>).toString();
                    if (LeadingZero<?=$t?> && s<?=$t?>.length < 2)
                    s<?=$t?> = "0" + s<?=$t?>;
                    return "<b>" + s<?=$t?> + "</b>";
                    }
                    
                    function CountBack<?=$t?>(secs<?=$t?>) {
                    if (secs<?=$t?> < 0) {
                    document.getElementById("cntdwn<?=$t?>").innerHTML = FinishMessage<?=$t?>;
                    
                    return;
                    }
                    DisplayStr<?=$t?> = DisplayFormat<?=$t?>.replace(/%%D%%/g, calcage<?=$t?>(secs<?=$t?>,86400,100000));
                    DisplayStr<?=$t?> = DisplayStr<?=$t?>.replace(/%%H%%/g, calcage<?=$t?>(secs<?=$t?>,3600,24));
                    DisplayStr<?=$t?> = DisplayStr<?=$t?>.replace(/%%M%%/g, calcage<?=$t?>(secs<?=$t?>,60,60));
                    DisplayStr<?=$t?> = DisplayStr<?=$t?>.replace(/%%S%%/g, calcage<?=$t?>(secs<?=$t?>,1,60));
                    
                    document.getElementById("cntdwn<?=$t?>").innerHTML = DisplayStr<?=$t?>;
                    if (CountActive<?=$t?>)
                    setTimeout("CountBack<?=$t?>(" + (secs<?=$t?>+CountStepper<?=$t?>) + ")", SetTimeOutPeriod<?=$t?>);
                    }
                    
                    function putspan<?=$t?>(backcolor<?=$t?>, forecolor<?=$t?>) {
                    document.write("<span class='timerStyle' id='cntdwn<?=$t?>' style='background-color:" + backcolor<?=$t?> + 
                    "; color:" + forecolor<?=$t?> + "'></span><p class='counterTxt'><strong>Time left on this session enter now</strong></p>");
                    }
                    
                    if (typeof(BackColor<?=$t?>)=="undefined")
                    BackColor<?=$t?> = "white";
                    if (typeof(ForeColor<?=$t?>)=="undefined")
                    ForeColor<?=$t?>= "black";
                    if (typeof(TargetDate<?=$t?>)=="undefined")
                    TargetDate<?=$t?> = "12/31/2020 5:00 AM";
                    if (typeof(StartDate<?=$t?>)=="undefined")
                    //StartDate<?=$t?> = new Date();
					StartDate<?=$t?> = new Date(clientDate.getTime()+deltaD);
                    if (typeof(DisplayFormat<?=$t?>)=="undefined")
                    DisplayFormat<?=$t?> = "%%D%% Days, %%H%% Hours, %%M%% Minutes, %%S%% Seconds.";
                    if (typeof(CountActive<?=$t?>)=="undefined")
                    CountActive<?=$t?> = true;
                    if (typeof(FinishMessage<?=$t?>)=="undefined")
                    FinishMessage<?=$t?> = "";
                    if (typeof(CountStepper<?=$t?>)!="number")
                    CountStepper<?=$t?> = -1;
                    if (typeof(LeadingZero<?=$t?>)=="undefined")
                    LeadingZero<?=$t?> = true;
                    
                    CountStepper<?=$t?> = Math.ceil(CountStepper<?=$t?>);
                    if (CountStepper<?=$t?> == 0)
                    CountActive<?=$t?> = false;
                    var SetTimeOutPeriod<?=$t?> = (Math.abs(CountStepper<?=$t?>)-1)*1000 + 990;
                    putspan<?=$t?>(BackColor<?=$t?>, ForeColor<?=$t?>);
                    var dthen<?=$t?> = new Date(TargetDate<?=$t?>);
                   // var dnow<?=$t?> = new Date();
					//alert(dnow<?=$t?>);
					var dnow<?=$t?> = new Date(clientDate.getTime()+deltaD);
					//alert(dnow<?=$t?>-dnow2<?=$t?>);
                    if(CountStepper<?=$t?>>0)
                    ddiff<?=$t?> = new Date(dnow<?=$t?>-dthen<?=$t?>);
                    else
                    ddiff<?=$t?> = new Date(dthen<?=$t?>-dnow<?=$t?>);
                    gsecs<?=$t?> = Math.floor(ddiff<?=$t?>.valueOf()/1000);
                    CountBack<?=$t?>(gsecs<?=$t?>);
                    </script>
                   
                  </div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="cor_2set-3"></div>
            <div class="cor_2set-4"></div>
          </div>
        <div class="btn-row">
        
         <div class="blue-btn-03"> 
	     <a href="preview-player.php?id=<?=$colles_sound_type1['Product_Id']?>" title="<?=stripslashes($colles_sound_type1['Title'])?>" rel="gb_page_center[640, 28]" class="global-box"><img src="images/playbtn_sm.png" />&nbsp; Play</a>
         </div>
         
                 <?php if($_SESSION['SESS_ID']=='') { ?>
			     <div class="blue-btn-04 change"><a href="login.php" > Enter Session </a></div>
			     <?php } else {  ?>
				<?php
                $sql_bank_artist = "SELECT * FROM my_bank WHERE Product_Id='".$colles_sound_type1['Product_Id']."' AND Account_Type LIKE '%Artist%'";
                $result_bank_artist = mysql_query($sql_bank_artist);
                ?>
                 <?php if($TOTAL_NOTES>=$colles_sound_type1['Product_Notes'] || $_SESSION['SESS_ACCOUNT_TYPE']=='Contest Judge') { ?>
                  <?php if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist') { ?>
                  <div class="blue-btn-04 change"> <a href="create-session.php?id=<?=$colles_sound_type1['Product_Id']?>"><?=$ACOUNT?></a></div>
                  <?php  } elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Contest Judge') { ?>
                  <?php # mysql_num_rows($result_bank_artist)>=2 &&?>
                  <?php if( $colles_sound_type1['Judges_Vote']==0) { ?>
                  <div class="blue-btn-04 change"> <a href="contest-juge-history.php?id=<?=$colles_sound_type1['Product_Id']?>" > <?=$ACOUNT?> </a></div>
                  <?php } else { ?>
                  <div class="blue-btn-04 change"><a href="javascript:void(0);" onmouseover="Tip('Private session judges can\'t enter')" onmouseout="UnTip()"><?=$ACOUNT?></a></div>
                  <?php } ?>
                  <?php  } elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Musician') { ?>
                   <div class="blue-btn-04 change"><a href="javascript:void(0);" onmouseover="Tip('Musician Member Can Not Enter Active Session')" onmouseout="UnTip()"><?=$ACOUNT?></a></div>
                  <?php } ?>
                  <?php } else { ?>
                   <div class="blue-btn-04 change">
                   <a href="javascript:void(0);" onmouseover="Tip('You need <?=$colles_sound_type1['Product_Notes'];?> credits to enter this session')" onmouseout="UnTip()" ><?=$ACOUNT?></a>
                   </div>
			  <?php } }?>
         
        <div class="blue-btn-03">
        
        <script language="javascript">
        
        function reportRequest<?=$t?>(){ 
        
        document.getElementById('report_id<?=$t?>').innerHTML ='<img src="images/loading.gif" alt="" />';
        
        
        var Artist_Name = document.getElementById('Artist_Name<?=$t?>').value; 
        var Musician_Name = document.getElementById('Musician_Name<?=$t?>').value;
        var Sound_Title = document.getElementById('Sound_Title<?=$t?>').value; 
        var Details = document.getElementById('Details<?=$t?>').value;
        
        
        httpobj.open('get',"ajax-report.php?Artist_Name="+Artist_Name+"&Musician_Name="+Musician_Name+"&Sound_Title="+Sound_Title+"&Details="+Details);
        httpobj.onreadystatechange	= handleReportResponse<?=$t?>;
        httpobj.send("");
        
        }
        function handleReportResponse<?=$t?>(){
        
        if(httpobj.readyState==4)
        {
        var text = httpobj.responseText;
        
        document.getElementById('report_id<?=$t?>').innerHTML = text;
        
        }
        }
        $(document).ready(function(){
        try{
        $("#variousReport<?=$t?>").fancybox({
        'overlayShow'	: true,
        'transitionIn'	: 'elastic',
        'transitionOut'	: 'elastic'
        });
        }catch(e){}
        });
        
        </script>
         <?php if($_SESSION['SESS_ID']=='') { ?>
		  <a href="login.php" >Report</a>
         <?php } else { ?>
         <a id="variousReport<?=$t?>" href="#requestReport<?=$t?>">Report</a>
            <div style="display: none;">
            <div id="requestReport<?=$t?>" style="width:450px;height:420px;">
            <div style="padding: 5px 0 0 100px;">
            <form id="frmReport" name="frmReport"  method="post" action="">
            <ul>
            
            
            <li>
            <ul class="login">
            <li><h1>Report</h1></li>
            <li></li>
            </ul>
            </li>
            
            <li  id="report_id<?=$t?>" style="padding: 5px 0 5px 0;"></li>
            
            <li>
            <ul class="login">
            <li>Artist Name </li>
            <li><input type="text" name="Artist_Name" id="Artist_Name<?=$t?>" size="30" class="input-text" onkeypress="if(event.keyCode==13) {return reportRequest<?=$t?>();}" /></li>
            </ul>
            </li>
            
            <li>
            <ul class="login">
            <li>Musician Name </li>
            <li><input type="text" name="Musician_Name" id="Musician_Name<?=$t?>" size="30" class="input-text" onkeypress="if(event.keyCode==13) {return reportRequest<?=$t?>();}" /></li>
            </ul>
            </li>
            
            
            
            <li>
            <ul class="login">
            <li>Sound Title </li>
            <li><input type="text" name="Sound_Title" id="Sound_Title<?=$t?>" size="30" class="input-text" onkeypress="if(event.keyCode==13) {return reportRequest<?=$t?>();}" /></li>
            </ul>
            </li>
            
            
            <li>
            <ul class="login">
            <li>Details</li>
            <li><textarea name="Details" id="Details<?=$t?>" cols="40" rows="6" onkeypress="if(event.keyCode==13) {return reportRequest<?=$t?>();}"></textarea></li>
            </ul>
            </li>
            
            
            <li>
            <ul class="login">
            <li>&nbsp;</li>
            <li><input class="button" name="buttonSubmit" type="button" value="Submit" onclick="return reportRequest<?=$t?>();" onkeypress="if(event.keyCode==13) {return reportRequest<?=$t?>();}"></li>
            </ul>
            </li>
            </ul>
            </form>
            </div>
            </div>
            </div>
         <?php } ?>
        </div>
        <?php #} ?>
        <!--<div class="blue-btn-2 change"><a href="javascript:void(0);">Enter </a></div>-->
      <div class="cl"></div>
    </div>
  		</div>
         <?php
		 $t++;
		 }
		 }
		 else
		 {
		 echo "<div style='
		 background-image: url(images/bgblueBtn.png);
    background-repeat: no-repeat;
    color: #FFFFFF;
    font-size: 20px;
    font-weight: bold;
    height: 50px;
    margin: 0 auto;
    padding:19px 24px 0 33px;
    width: 206px;
		 '><a style='
		 color:#fff;' href='http://mussino.com/product.php?membership='>Create New Session</a></div>";
		 }
		 ?>
         
     
         
              <?php /*?> <h2 style="width:248px; margin:0 auto; font-size:16px; text-align:center;">No current <?=($_GET["id"]!="")?Get_Single_Field("category_master","Category_Name","Category_Id","$_REQUEST[id]"):"";?> sessions. <a href="http://mussino.com/session.php">See all sessions</a></h2><?php */?>
          
                
        <div class="cl"></div>
        </div>
       
        <div class="cor_1set-3"></div>
        <div class="cor_1set-4"></div>
      </div>
      
       
    </div>
  </div>
</div>
<script src="<?=SITE_WS_PATH?>/script/jquery-ui-1.10.4.custom.js"></script>
<link href="<?=SITE_WS_PATH?>/greybox/gb_styles.css" rel="stylesheet" type="text/css" media="all" />