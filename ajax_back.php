<?php
require_once "config/functions.inc.php"; 
//require_once "session.inc.php"; 

if($_POST['act'] == 'recorded_vid')
{
	echo "{|*|}";	
	$rcnt = 0;
	if((int)$_POST['usr_id'] > 0)
	{
		$get_recordings = "select nrc.*,cm.Category_Name,cm.Category_Id,pm.Title
		from 	
		new_recording_cam nrc,
		product_master pm,
		category_master cm
		where 
		cm.Category_Id = pm.Category_Id And
		pm.Product_Id = nrc.ses_id And
		nrc.record_user_id='".(int)$_POST['usr_id']."' order by nrc.id desc";
	}elseif($_POST['ses_id'] != ''){
		$get_recordings = "select nrc.*,mam.First_Name,mam.Last_Name from 	
		new_recording_cam nrc,
		`member_account_master` mam
		where 
		mam.Member_Account_Id = nrc.record_user_id and
		nrc.ses_id='".$_POST['ses_id']."' order by nrc.id desc";
	}else{
		$get_recordings = "select nrc.*,mam.First_Name,mam.Last_Name from 	
		new_recording_cam nrc,
		`member_account_master` mam
		where 
		mam.Member_Account_Id = nrc.record_user_id
		order by nrc.id desc";
	}
	$_GET['pageno'] = $_POST['page_no'];
	$getres= new display_navigator_rec($get_recordings,"recording_page.php?".$pagelnk,"paging_links",16);
	
	if($getres->totalRecordFound <= 0)
	{
		echo "<center>No one have recorded on this session yet.</center>";
	}

	while($recordings_row=mysql_fetch_array($getres->result))
	{
		if($rcnt == 0)
			echo "<div class='main_record'>";
		
		if((int)$_POST['usr_id'] > 0)
		{
			if($rcnt%3 == 0 && $rcnt > 0)
			echo "</div><div class='main_record'>";
		}else{
			if($rcnt%4 == 0 && $rcnt > 0)
			echo "</div><div class='main_record'>";	
		}
		
		
		$rcnt++;
		if(!file_exists("session_images/".$recordings_row['flv_name'].".png"))
		{
			$img = "thumb_not_available.jpg";
		}else{
			$img = $recordings_row['flv_name'].".png";
		}
		?>
		<div class="recording_div_main">			
			<div class="record_usr_nm">
				<?php
				if((int)$_POST['usr_id'] > 0)
				{
					?>
					<strong>Session: </strong><a href="<?php echo SITE_WS_MPATH.'/session.php?id='.$recordings_row['Category_Id'];?>"><?php echo $recordings_row['Title'];?></a>
					<?php
				}else{
					?>
					<a href="<?php echo SITE_WS_MPATH.'/'.$recordings_row['record_user_id'].'/'.$recordings_row['First_Name'];?>"><?php echo $recordings_row['First_Name']." ".$recordings_row['Lirst_Name'];?></a>
					<?php
				}
				?>
			</div>
			<div class="recording_div unsigned_vids"> <img class="fancyboxrec record_img" href="#inline1" src="session_images/<?php echo $img;?>" width="200" border="0" onclick="callonloadplayer('<?php echo $recordings_row['flv_name'];?>')">
				<?php
				echo "<div class='rec_song_ttl'>".$recordings_row['song_title']." </div>";				
				?>
			</div>
		</div>
		<?php
	}
	if($getres->totalRecordFound <= 0)
		echo "</div>";
	
	if($getres->hrefpglinks != '')
		echo "<div class='paging_cntr'>".$getres->hrefpglinks."</div>";

	
}

class display_navigator_rec{
	var $result,$totalRecordFound,$hrefpglinks,$allrows,$fired_query;	
	function display_navigator_rec($qry,$pagelink,$hrefcls,$noofpg)
	{
			$query=$qry;   //******* query of the data to be display
			//die;
			$result= mysql_query($query); 
			$totalRecFound = mysql_num_rows($result); 

			$noofpages = $noofpg; // this is the number of records to be display on the screen 
	
			$totalRecords=$totalRecFound;
			$totalPages=ceil($totalRecords/$noofpages);
			$showingpage="";
			
			if((int)$_GET['pageno'] > $totalPages)
			{
				$_GET['pageno']=$totalPages;
			}
			if(!$_GET['pageno'])
			{
				$pageno=1;
				$initlimit=0;
			}else
			{
				$pageno=$_GET['pageno'];
				$initlimit=($pageno*$noofpages)-$noofpages;		
			}
			
			if($pageno>$totalPages){$pageno=1;}
				if($pageno < 6 )
				{
					$startpage = 1;
					if($pageno + 5  >= $totalPages )
						{
							$endpage = $totalPages;
						}	
						else
						{
							$endpage = 10 ;
						}
				}	
			else
				{
					$startpage = $pageno - 5 ;
					if($pageno + 5  > $totalPages )
					{
						$endpage = $totalPages;
					}	
					else
					{
						$endpage = $pageno + 5 ;
					}
					
				}

			for($i=$startpage;$i<=$endpage;$i++)
			{			
				if($i==$pageno && $i==$totalPages)
				{
					$showingpage.="<a class='current' href='' onclick='return false;'>$i</a>";
				}
				else if($i==$pageno)
					$showingpage.="<a class='current' href='' onclick='return false;'>$i</a>";
				else
					$showingpage.="<A style=\"text-decoration:none\" class='".$hrefcls."' href='".$pagelink."&pageno=$i' onclick='return callonpage($i)'>$i</a>";// change link name and give u'r page link
			}
			
			if($totalPages>1)
			{			
				if($pageno=="1")
				{
					$page=$pageno + 1;
					$next="<A style=\"text-decoration:none\" class='".$hrefcls."' href='".$pagelink."&pageno=$page' onclick='return callonpage($page)'>Next</A>";// change link name and give u'r page link
					$prev="";		
				}else if($pageno==$totalPages)
				{
					$page=$pageno - 1;
					$next="";
					$prev="<A style=\"text-decoration:none\" class='".$hrefcls."' href='".$pagelink."&pageno=$page'  onclick='return callonpage($page)'>Previous</A>";// change link name and give u'r page link			
				}else
				{
					$page1=$pageno + 1;
					$page2=$pageno - 1;
					$next="<A style=\"text-decoration:none\" class='".$hrefcls."'href='".$pagelink."&pageno=$page1'  onclick='return callonpage($page1)'>Next</A>";// change link name and give u'r page link
					$prev="<A style=\"text-decoration:none\" class='".$hrefcls."' href='".$pagelink."&pageno=$page2' onclick='return callonpage($page2)'>Previous</A>";// change link name and give u'r page link		
				}
				
			}else
			{
				$next="";
				$prev="";		
			}	
			$query.=" LIMIT $initlimit,$noofpages";
			$result= mysql_query($query);
			$totalRecordFound = mysql_num_rows($result); 
			if($prev == "" && $next =="")
			{$hrefpglinks="";} else {
				$hrefpglinks=$prev. " " .$showingpage." ".$next;
			}
			$this->hrefpglinks=$hrefpglinks;
			$this->result=$result;
			$this->fired_query=$query;			
			$this->totalRecordFound=$totalRecords;
	}
	
}
?>
