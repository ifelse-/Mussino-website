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

$date = date('Y-m-d');
$sql = "SELECT P.Product_Id, P.Member_Account_Id,P.Product_Notes, P.Title,P.Royalties, P.Posts,P.Judges_Vote, P.Category_Id, P.Jack_Pot,P.Sound, P.Type, P.Image_Name, P.Short_FIle_Name, P.Long_FIle_Name, P.Short_Desc, P.Long_Desc, P.Price,	P.Session_Start_Date, P.Session_End_Date, DATE_FORMAT(P.Session_Start_Date,'%m/%d/%Y %h:%i %p') as StartDate, DATE_FORMAT(P.Session_End_Date,'%m/%d/%Y %h:%i %p') as EndDate, P.Product_Date, P.Status 
FROM 
product_master P LEFT JOIN member_account_master M ON (P.Member_Account_Id=M.Member_Account_Id)
LEFT JOIN category_master C ON (P.Category_Id=C.Category_Id)
WHERE P.Status=1  AND M.Status=1 AND ( (now() between P.Session_Start_Date AND P.Session_End_Date))";
if($_REQUEST['q']!='' && $_REQUEST['q']!='Enter Keyword(s)')
{
$sql .=" AND (P.Title LIKE '%".trim($_REQUEST['q'])."%' || M.First_Name LIKE '%".trim($_REQUEST['q'])."%' || M.Last_Name LIKE '%".trim($_REQUEST['q'])."%' || C.Category_Name LIKE '%".trim($_REQUEST['q'])."%')";
}	
if($_REQUEST['pid']!='')
{
$sql .=" AND P.Product_Id = '".$_REQUEST['pid']."'";
}
if($_REQUEST['sound']!='')
{
$sql .=" AND P.Sound = '".$_REQUEST['sound']."'";
}
//echo $sql;
		  
$result = mysql_query($sql);

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
              WHERE a.Status='1' AND b.Member_Account_Id='".$_SESSION['SESS_ID']."'";
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
?>
<link href="css/rating_style.css" rel="stylesheet" type="text/css" media="all">
	<script type="text/javascript" src="js/rating_update.js"></script>	
   
<div class="content-box-2">
        <div class="cor_1set-5"></div>
        <div class="cor_1set-6"></div>
        
        <div class="pro-wrapper fl">
          <div class="title">
            <div class="title_wrap-1">
              <div class="title_wrap-2">
                <div class="blue-btn-1">
                  <span><span><?=($_GET['cat_id']!='')?Get_Single_Field("category_master","Category_Name","Category_Id","$_REQUEST[cat_id]"):'New Sessions';?></span></span>
                </div>
              </div>
            </div>
          </div>
          <?php
		 
		  $k=0;
		  $t=1;
		  $ct=0; 
			if(mysql_num_rows($result)>0)
			{
			while($colles = mysql_fetch_array($result))
			{
			$class=($k%2==0)?'grid-row even':'grid-row odd';
			$class2=($k%2==0)?'ja-dot even':'ja-dot odd';
			
			$sqlAudioCount = "SELECT COUNT(*) AS CtotalAudio FROM lyrics_post_audio_master WHERE Product_Id='".$colles['Product_Id']."' AND Lyrics_Audio_Type='AUDIO' AND Status=1";
			$resAudioCount = mysql_query($sqlAudioCount);
			$collesAudioCount = mysql_fetch_array($resAudioCount);
			$sqlVideoCount = "SELECT COUNT(*) AS CtotalVideo FROM lyrics_post_audio_master WHERE Product_Id='".$colles['Product_Id']."' AND Lyrics_Audio_Type='VIDEO' AND Status=1";
			$resVideoCount = mysql_query($sqlVideoCount);
			$collesVideoCount = mysql_fetch_array($resVideoCount);
			$sqlTextCount = "SELECT COUNT(*) AS CtotalText FROM lyrics_post_master WHERE Product_Id='".$colles['Product_Id']."' AND Status=1";
			$resTextCount = mysql_query($sqlTextCount);
			$collesTextCount = mysql_fetch_array($resTextCount);
			
			$totalPosts = $collesAudioCount['CtotalAudio'] + $collesVideoCount['CtotalVideo'] + $collesTextCount['CtotalText'];
			
			$sqlCat ="SELECT Category_Name FROM category_master WHERE Category_Id ='".$colles['Category_Id']."'";
			$resultCat = mysql_query($sqlCat);
			$collesCat=mysql_fetch_array($resultCat);
			$collesCat['Category_Name'];
						
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
                      <a title="<?=stripslashes($colles['Title'])?>" href="product-detail.php?id=<?=$colles['Product_Id']?>"> 
						<?php if(file_exists("products/product_image/$colles[Image_Name]") && $colles['Image_Name']!='') { ?>
                        <img src="products/product_image/<?php echo $colles['Image_Name']; ?>" border="0" width="100" height="100" alt="<?=stripslashes($colles['Title'])?>"/>
                        <?php } else { ?>
                        <img src="images/no-image.gif" border="0" width="100" height="100" alt="<?=stripslashes($colles['Title'])?>"/>
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
                        <div class="caption-1"><?=Get_Single_Field("member_account_master","Account_Type","Member_Account_Id","$colles[Member_Account_Id]")?></div>
                        <div class="detail-1">
						<a href="<?=SITE_WS_PATH?>/<?=trim($colles['Member_Account_Id'])?>/<?=ucfirst(stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles[Member_Account_Id]")))?>" ><?=stripslashes(ucfirst(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles[Member_Account_Id]")))?></a></div>
                        <div class="cl"></div>
                      </li>
                      <?php if($colles['Type']!='3') { ?>
                      <li>
                        <div class="caption-1">Sound</div>
                        <div class="detail-1"><a href="session.php?sound=<?=$colles['Sound']?>"><?=Get_Single_Field("sound_type_master","Sound_Type_Name","Sound_Type_Id","$colles[Sound]")?></a></div>
                        <div class="cl"></div>
                      </li>
                      <li>
                        <div class="caption-1">Notes</div>
                        <div class="detail-1"><?=$colles['Product_Notes'];?></div>
                        <div class="cl"></div>
                      </li>
                      <?php } ?>
                      <li>
                        <div class="caption-1">Genres</div>
                        <div class="detail-1"><a title="<?=stripslashes(Get_Single_Field("category_master","Category_Name","Category_Id","$colles[Category_Id]"))?>" href="session.php?id=<?=$colles['Category_Id']?>"><?=stripslashes(Get_Single_Field("category_master","Category_Name","Category_Id","$colles[Category_Id]"))?></a></div>
                        <div class="cl"></div>
                      </li>
                      <?php if($colles['Type']!='3') { ?>
                      <li>
                        <div class="caption-1">Post</div>
                        <div class="detail-1"><?=$totalPosts+$colles['Posts'];?></div>
                        <div class="cl"></div>
                      </li>
                      <?php } else { ?>
                      <li>
                        <div class="caption-1">Details</div>
                        <div class="detail-1"><?=stripslashes(substr($colles['Short_Desc'],0,50))?> <?php if(strlen($colles['Short_Desc'])>50) { echo '...'; }?></div>
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
					location.replace('index.php');
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
					
					$("#variousReview<?=$t?>").fancybox({
						'overlayShow'	: true,
						'transitionIn'	: 'elastic',
						'transitionOut'	: 'elastic'	});
						
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
                                            <li><input class="button" name="buttonSubmit" type="button" value="Review" onclick="ajaxSubmitReview<?=$t?>('<?=$colles['Product_Id']?>');" onkeypress="if(event.keyCode==13) {return ajaxSubmitReview<?=$t?>('<?=$colles['Product_Id']?>');}"></li>
                                        </ul>
                                    </li>
                                </ul>
                            </form>
                                </div>
                            </div>
                       </div>
                    </div>
                    
                    <div class="vote"><? echo pullRating($colles['Product_Id'],false,true,true); ?></div>
                    <div class="rating">
                     <!-- Rating-->
                    </div>
                  </div>
                  <div class="cl"></div>
                  <div class="jackpot">
                    <?php $TOTAL_ROYALTIES = ($colles['Product_Notes']*$totalPosts)+$colles['Royalties']; ?>
                  
                   <?php if($colles['Type']!='3') { ?> <img src="<?=SITE_WS_PATH?>/images/moneyBag.jpg" width="25" style="margin-top:-4px; position: absolute;" /><span><span style="margin-left:30px;">Royalties: $<?=$TOTAL_ROYALTIES?></span></span> <?php } else { ?> <span><span>$<?=trim($colles['Price'])?></span></span><?php } ?>
                  </div>
                  <?php if($colles['Type']!='3') { ?>
                  <div class="time">
					
                  	<img src="<?=SITE_WS_PATH?>/images/timer.jpg" width="27" style="margin-top:-3px; position: absolute;" /> <span style="margin-left:30px; color:#09C"><strong>Time Left:</strong></span> 
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
					
					
                    TargetDate<?=$t?> = "<?=$colles['EndDate'];?>";
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
                    document.write("<span id='cntdwn<?=$t?>' style='background-color:" + backcolor<?=$t?> + 
                    "; color:" + forecolor<?=$t?> + "'></span>");
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
            
             <?php 
			if($colles['Type']!='3') 
			{ // s 1.0 
			
			?>
						
            <div class="blue-btn-03">
            <a href="preview-player.php?id=<?=$colles['Product_Id']?>" title="<?=stripslashes($colles['Title'])?>" rel="gb_page_center[640, 360]" class="global-box"><img src="images/playbtn_sm.png" />&nbsp;Play</a>
            </div>
			<?php 
			}
			?>
			
            
            
             <?php 
			if($colles['Type']!='3') 
			{ // s 1.0 
			$ctime= date("Y-m-d h:i:s");
			$stime= $colles['Session_Start_Date'];
			$etime= $colles['Session_End_Date'];
			$diff=@get_time_difference( $stime, $etime );
			$cdiff=@get_time_difference( $ctime, $etime );
			if(($diff['days']<=0 && $diff['hours']<=0 && $diff['minutes']<=0 && $diff['seconds']<=0) || ($cdiff['days']<=0 && $cdiff['hours']<=0 && $cdiff['minutes']<=0 && $cdiff['seconds']<=0))
			{ // s 1.1
			?>
			<div class="blue-btn-2 change"><a href="javascript:void(0);">Enter </a></div>
			<?php
			}
			else
			{
			?>
			<?php if($_SESSION['SESS_ID']=='') { // I 2.0?>
			<div class="blue-btn-04 change"><a href="login.php" > Enter Session </a></div>
			<?php } else { // EI 2.0 ?>
			
					<?php //if($session_num_validate>=2) { /// 3333333 ?>
					  <?php
					 $sql_bank_artist = "SELECT * FROM my_bank WHERE Product_Id='".$colles['Product_Id']."' AND Account_Type LIKE '%Artist%'";
					 $result_bank_artist = mysql_query($sql_bank_artist);
					 ?>
					
					<?php if($TOTAL_NOTES>=$colles['Product_Notes'] || $_SESSION['SESS_ACCOUNT_TYPE']=='Contest Judge') { 
					//if( $_SESSION['SESS_ACCOUNT_TYPE']=='Contest Judge') {
					?>
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
					function ajaxEnterSession<?=$t?>(toid,fromid,pid,type,value){
					
					document.getElementById('view_enter_session<?=$t?>').innerHTML ='<img src="images/loading.gif" alt="" />';
					
					httpobj.open('get',"ajax_enter_session.php?toid="+toid+"&fromid="+fromid+"&pid="+pid+"&type="+type+"&value="+value);
					httpobj.onreadystatechange	= handleEnterSessionResponse<?=$t?>;
					httpobj.send("");
					
					}
					
					function handleEnterSessionResponse<?=$t?>(){
					
					if(httpobj.readyState==4){
					var text = httpobj.responseText;
					document.getElementById('view_enter_session<?=$t?>').innerHTML = text;
					
						document.getElementById('view_enter_session<?=$t?>').style.display = 'block';
						var sharedLoader = document.getElementById('view_enter_session<?=$t?>'); //div auto hide made by vishwas just chill
						var timeoutLoader = window.setTimeout(function(){sharedLoader.style.display = 'none';}, 2000);
					}
					}
					</script>
                    
					<span id="view_enter_session<?=$t?>" align="center" style="background-color:#FFE6F2;"></span>
					
					                   
                  <?php if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist') { ?>
                  <div class="blue-btn-04 change"><a href="create-session.php?id=<?=$colles['Product_Id']?>" > <?=$ACOUNT?> </a></div>
                  <?php  } elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Contest Judge') { ?>
                  <?php # mysql_num_rows($result_bank_artist)>=2 && ?>
                  <?php if($colles['Judges_Vote']==0) { ?>
                  <div class="blue-btn-04 change"><a href="contest-juge-history.php?id=<?=$colles['Product_Id']?>" > <?=$ACOUNT?> </a></div>
                  <?php } else { ?>
                  <div class="blue-btn-04 change"><a href="javascript:void(0);" onmouseover="Tip('Private session judges can\'t enter')" onmouseout="UnTip()"><?=$ACOUNT?></a></div>
                  <?php } ?>
                  <?php  } elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Musician') { ?>
                   <div class="blue-btn-04 change"><a href="javascript:void(0);" onmouseover="Tip('Musician Member Can Not Enter Active Session')" onmouseout="UnTip()"> <?=$ACOUNT?> </a></div>
                  <?php } ?>
					
					<?php } else { ?>
					<div class="blue-btn-04 change"><a href="javascript:void(0);" onmouseover="Tip('You Have Less Notes For Enter Session')" onmouseout="UnTip()" ><?=$ACOUNT?>  </a></div>
					<?php } ?>
					
					
					<?php // } else { //// 333333 ?>
					<!--<div class="blue-btn-2 change"><a href="javascript:void(0);" onmouseover="Tip('Atleast Two Active Session')" onmouseout="UnTip()" > <?=$ACOUNT?></a></div>-->
					<?php  // } ?>
					
				<?php } // End EI 2.0 ?>
			
				<?php } // e 1.1 ?>
			 
				<?php } else { ?>
				<!--<div class="blue-btn-2 change"><a href="buy-unreleased-music-to-cart.php?id=<?=$colles['Product_Id']?>" > Buy </a></div>-->
				<?php } // e 1.0 ?> 
            
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
					
					$("#variousReport<?=$t?>").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});
						
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
            <div class="cl"></div>
          </div>
          </div>
           <?php
				$k++;
				$t++;
				$ct++;
				if($ct==2)
				{
				echo'<div class="cl"></div>';
				$ct=0;
				}
				}
				}
				else
				{
				echo'<div style="padding:50px 0 50px 280px; font-size:14px; color:#0099FF;"> No record(s)</div>';
				}
				?>          
          
          
        </div>
        <div class="right-col fr">
          <div class="right-col_wrapper">
            <div class="title">
              <div class="gray-btn-1">
                <span><span>Popular</span></span>
              </div>
              Tags
            </div>
            <div class="content">
              <?php
				$sqlCloud = "SELECT * FROM tags ORDER BY tag_name";
				$resultCloud = mysql_query($sqlCloud);
				
				if(mysql_num_rows($resultCloud)>0)
				{
				?>
                <ul class="tags-list">
					<style type="text/css">
					.tag_cloud {padding: 5px; text-decoration: none; font-family: verdana; }
					.tag_cloud:link { color: #9FCCF5; }
					.tag_cloud:visited { color: #9FCCF5; }
					.tag_cloud:hover { color: #fff; background: #1E3E64; }
					.tag_cloud:active { color: #9FCCF5; background: #1E3E64; }
					</style>
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
					
					$cloud_tags[] = '<li><a style="font-size: '. floor($size) . 'px'
					. '" class="tag_cloud" href="http://www.mussino.com/search.php?q=' . str_replace('%20','',$tag)
					. '" title="\'' . str_replace('%20','',$tag) . '\' returned a count of ' . $count . '">'
					. htmlspecialchars(stripslashes(str_replace('%20','',$tag))) . '</a></li>';
				   
					}
					$cloud_html = join("\n", $cloud_tags) . "\n";
					return $cloud_html;
					
					}
					
					?>
					<div>
					<?php 
					if(mysql_num_rows($resultCloud)>0)
					{
					echo tag_cloud(); 
					}
					?>
					</div>
				</ul>
				<?php } ?>
                <div class="actions"> <a href="tagclouds.php">View All Tags</a> </div>
            </div>
          </div>
          <div class="right-col_wrapper">
            <div class="title">
              <div class="gray-btn-1">
                <span><span>Invite Friends</span></span>
              </div>
            </div>
            <div class="content">
              <a id="variousTellaFriend" href="#requestTellaFriend">To invite friends click here</a>
              <div style="display: none;">
                            <div id="requestTellaFriend" style="width:450px;height:350px;">
                                <div style="padding: 5px 0 0 100px;">
                                <form id="frmTellaFriend" name="frmTellaFriend"  method="post" action="">
                                <ul>
                                    
                                    
                                    <li>
                                        <ul class="login">
                                            <li><h1>Invite Your Friends</h1></li>
                                            <li></li>
                                        </ul>
                                    </li>
                                    
                                    <li  id="tell_a_friend_id" style="padding: 5px 0 5px 0;"></li>
                                    
                                    <li>
                                        <ul class="login">
                                            <li>Email ID</li>
                                            <li><input type="text" name="Email" size="30" class="input-text" onkeypress="if(event.keyCode==13) {return tellaFriendRequest();}" /></li>
                                        </ul>
                                    </li>
                                    
                                    
                                    <li>
                                        <ul class="login">
                                            <li>Message</li>
                                            <li><textarea name="Message" cols="40" rows="6" onkeypress="if(event.keyCode==13) {return tellaFriendRequest();}"></textarea></li>
                                        </ul>
                                    </li>
                                    
                                    
                                   
                                    
                                    
                                    <li>
                                        <ul class="login">
                                            <li>&nbsp;</li>
                                            <li><input class="button" name="buttonSubmit" type="button" value="Submit" onclick="return tellaFriendRequest();" onkeypress="if(event.keyCode==13) {return tellaFriendRequest();}"></li>
                                        </ul>
                                    </li>
                                </ul>
                            </form>
                                </div>
                            </div>
                       </div>
            </div>
          </div>
          <div class="right-col_wrapper">
            <div class="title">
              <div class="gray-btn-1">
                <span><span>Sign Up for Our Newsletter</span></span>
              </div>
            </div>
            <div class="content">
            <form action="" method="post" id="frmNewsletter" name="frmNewsletter">
            <div class="block-content">
              <div id="view_newsletter"></div>
              <div>
                <strong>Name</strong> <input name="Name" id="newsletter" title="Sign up for our newsletter"  type="text" class="input-text" onkeypress="if(event.keyCode==13) {return ajaxNewsLetter();}">
              </div>
              <div style="margin-top:5px;">
                <strong>Email</strong>&nbsp;<input name="Email" id="newsletter" title="Sign up for our newsletter"  type="text" class="input-text" onkeypress="if(event.keyCode==13) {return ajaxNewsLetter();}">
              </div>
              <div class="actions">
                <input type="button" name="submit" value="Subscribe" class="button" onclick="return ajaxNewsLetter();" onkeypress="if(event.keyCode==13) {return ajaxNewsLetter();}">
              </div>
            </div>
          </form>
            </div>
          </div>
          
          
          <script type="text/javascript">
			//<![CDATA[
				function validatePollAnswerIsSelected()
				{
					var options = $$('input.poll_vote');
					for( i in options ) {
						if( options[i].checked == true ) {
							return true;
						}
					}
					return false;
				}
			//]]>
		</script>
          <div class="right-col_wrapper">
            <div class="title">
              <div class="gray-btn-1">
                <span><span>Community</span></span> 
              </div>
              Poll
            </div>
            <div class="content">
              <?php include"poll-view.php";?>
            </div>
          </div>
           <div class="paypal-logo"> <a href="#" title="Additional Options" onclick="javascript:window.open('#'); return false;"><img src="images/bnr_nowAccepting_150x60.gif" alt="Additional Options"></a> </div>
        </div>
        <div class="cl"></div>
        
        <div class="cor_1set-3"></div>
        <div class="cor_1set-4"></div>
      </div>