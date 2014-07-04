<?php 
session_start();
ob_start();
$sess_id=session_id();
@extract($_GET);
@extract($_POST);
//define('SITE_SUB_PATH', '/mussino.org');
$pageName = basename($_SERVER['PHP_SELF']); 

$rtmpserver = "rtmp://www.mussino.com:1935/webcamrecording";
$session_img_path = "/var/www/vhosts/ip-50-63-189-96.ip.secureserver.net/Mussino.com/session_images/";
$wmspath ="/usr/local/WowzaMediaServer/content/";

if($pageName=='checkout.php')
{
define('SITE_WS_PATH', 'https://'.$_SERVER['HTTP_HOST']);
define('SITE_WS_MPATH', 'http://'.$_SERVER['HTTP_HOST']);
}
else
{
define('SITE_WS_PATH', 'http://'.$_SERVER['HTTP_HOST']);
define('SITE_WS_MPATH', 'http://'.$_SERVER['HTTP_HOST']);
}
global $DB;

	
    $DB["dbName"] =  'mussinodbnew';   
	$DB["host"] = 'mussinodbnew.db.9195406.hostedresource.com'; 
	$DB["user"] = 'mussinodbnew';
	$DB["pass"] = 'Musicsite2011'; 
	$local_mode = false;

   $My_Host="http://".$_SERVER["HTTP_HOST"];
   $My_Host_Dir="";
   $My_Path="";
   $My_DBF[host]=$DB["host"];
   $My_DBF[user]=$DB["user"];
   $My_DBF[passwd]=$DB["pass"];
   $My_DBF[name]=$DB["dbName"];
   $My_DBF[debug]=1;//0-nodebug;1-screen;2-email;
   $debug_sendmail=false;

 
mysql_connect($DB["host"], $DB["user"], $DB["pass"]) or die("<span style='FONT-SIZE:11px; FONT-COLOR: #000000; font-family=tahoma;'><center>An Internal Error has Occured. Please report following error to the webmaster.<br><br>".mysql_error()."'</center>");
mysql_select_db($DB["dbName"]);


$free_general_settings = mysql_query("SELECT * FROM general_setting_master WHERE Gen_Set_Id  ='1'");
$free_general_settings_row = mysql_fetch_array($free_general_settings);
$musician_primary_free_credit = $free_general_settings_row['musician_free_credit'];
$email_notification_settings = $free_general_settings_row['genre_email_notification'];

function executeQuery($sql)
{
	$result = mysql_query($sql) or die("<span style='FONT-SIZE:11px; FONT-COLOR: #000000; font-family=tahoma;'><center>An Internal Error has Occured. Please report following error to the webmaster.<br><br>".$sql."<br><br>".mysql_error()."'</center></FONT>");
	return $result;
} 




function getSingleResult($sql)
{
	$response = "";
	$result = mysql_query($sql) or die("<center>An Internal Error has Occured. Please report following error to the webmaster.<br><br>".$sql."<br><br>".mysql_error()."'</center>");
	if ($line = mysql_fetch_array($result)) 
	{
		$response = $line[0];
	} 
	return $response;
} 

function executeUpdate($sql)
{
	mysql_query($sql) or die("<center>An Internal Error has Occured. Please report following error to the webmaster.<br><br>".$sql."<br><br>".mysql_error()."'</center>");
} 

function sort_arrows($column){
	global $_SERVER;
	return '<A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2'), array($column,'asc')).'"><IMG SRC="images/uparrow.png" WIDTH="9" HEIGHT="7" BORDER="0"></A> <A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2'), array($column,'desc')).'"><IMG SRC="images/downarrow.png" WIDTH="9" HEIGHT="7" BORDER="0"></A>';
}
function sort_arrows1($column){
	global $_SERVER;
	return '<A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2','date','short'), array($column,'asc',$_REQUEST['date'],yes)).'"><IMG SRC="img/uparrow.png" WIDTH="9" HEIGHT="7" BORDER="0"></A> <A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2','date','short'), array($column,'desc',$_REQUEST['date'],yes)).'"><IMG SRC="img/downarrow.png" WIDTH="9" HEIGHT="7" BORDER="0"></A>';
}

function Filter($string)
{
return (trim(stripslashes($string)));
}


function Filter_Add($string)
{
 return addslashes(trim($string));
}


function get_qry_str($over_write_key = array(), $over_write_value= array())
{
	global $_GET;
	$m = $_GET;
	if(is_array($over_write_key)){
		$i=0;
		foreach($over_write_key as $key){
			$m[$key] = $over_write_value[$i];
			$i++;
		}
	}else{
		$m[$over_write_key] = $over_write_value;
	}
	$qry_str = qry_str($m);
	return $qry_str;
} 
function qry_str($arr, $skip = '')
{
	$s = "?";
	$i = 0;
	foreach($arr as $key => $value) {
		if ($key != $skip) {
			if ($i == 0) {
				$s .= "$key=$value";
				$i = 1;
			} else {
				$s .= "&$key=$value";
			} 
		} 
	} 

	return $s;
} 

function ms_stripslashes($text)
{
	if (is_array($text)) {
		$tmp_array = Array();
		foreach($text as $key => $value) {
			$tmp_array[$key] = ms_stripslashes($value);
			//echo($tmp_array[$key]);
		} 
		//ms_print_r($tmp_array);
		return $tmp_array;
	} else {
		return stripslashes(trim($text));
	} 
} 
function html2txtx($document)
{
		$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
					   '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
					   '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
					   '@<![\s\S]*?--[ \t\n\r]*>@'        // Strip multi-line comments including CDATA
						);
		$text = preg_replace($search, '', $document);
		return $text;
}
function ms_stripslashesx($text)
{
		
		$text=stripslashes(trim($text));
		return html2txtx(str_replace("'","’",$text));
	
} 
function seo_filter($text)
{
		
		$text=strtolower(stripslashes(trim($text)));
		$text=str_replace("&","",$text);
		$text=str_replace(" ","_",$text);
		$text=str_replace("__","_",$text);
		$text=str_replace('"',"",$text);
		$text=str_replace("'","",$text);
		
		$text=str_replace("?","",$text);
		return $text;

}

function ms_addslashes($text)
{
	if (is_array($text)) {
		$tmp_array = Array();
		foreach($text as $key => $value) {
			$tmp_array[$key] = ms_addslashes($value);
		} 
		return $tmp_array;
	} else {
		return addslashes(stripslashes(trim($text)));
	} 
} 

function date_combo($pre, $selected_date = '', $start_date = '', $start_date_unit = '', $start_date_value = '', $end_date = '', $end_date_unit = '', $end_date_value = '')
{
	global $DEFAULT_START_DATE,	$DEFAULT_END_DATE;

	$cur_date = date("Y-m-d");
	$cur_date_day = substr($cur_date, 8, 2);
	$cur_date_month = substr($cur_date, 5, 2);
	$cur_date_year = substr($cur_date, 0, 4);

	if ($start_date == '') {
		if ($start_date_unit == '' || $start_date_value == '') {
			$start_date = $DEFAULT_START_DATE;
		} else if ($start_date_unit == 'y') {
			//echo "<br> ".mktime (0, 0, 0, 8, 25, 2103)." <br>";
			//echo "<br> ".mktime (0,0,0,12,32,1997)." <br>";
			$tmp_year=$cur_date_year + $start_date_value;
			$start_date = date("Y-m-d", mktime (0, 0, 0, $cur_date_month, $cur_date_day, $tmp_year));
			//echo "<br> $start_date <br>";
		} else if ($start_date_unit == 'm') {
			$start_date = date("Y-m-d", mktime (0, 0, 0, $cur_date_month + $start_date_value, $cur_date_day, $cur_date_year));
		} else if ($start_date_unit == 'd') {
			$start_date = date("Y-m-d", mktime (0, 0, 0, $cur_date_month, $cur_date_day + $start_date_value, $cur_date_year));
		} 
	}
	$start_date_day = substr($start_date, 8, 2);
	$start_date_month = substr($start_date, 5, 2);
	$start_date_year = substr($start_date, 0, 4); 
	// echo("$start_date<BR>");
	if ($end_date == '') {
		if ($end_date_unit == '' || $end_date_value == '') {
			// echo("1");
			$end_date = $DEFAULT_END_DATE;
		} else if ($end_date_unit == 'y') {
			$end_date = date("Y-m-d", mktime (0, 0, 0, $start_date_month, $start_date_day, $start_date_year + $end_date_value));
		} else if ($end_date_unit == 'm') {
			$end_date = date("Y-m-d", mktime (0, 0, 0, $start_date_month + $end_date_value, $start_date_day, $start_date_year));
		} else if ($end_date_unit == 'd') {
			$end_date = date("Y-m-d", mktime (0, 0, 0, $start_date_month, $start_date_day + $end_date_value, $start_date_year));
		} 
	} 
	$end_date_day = substr($end_date, 8, 2);
	$end_date_month = substr($end_date, 5, 2);
	$end_date_year = substr($end_date, 0, 4); 
	// echo("$end_date<BR>");
	if ($selected_date != '') {
		$selected_date_day = substr($selected_date, 8, 2);
		$selected_date_month = substr($selected_date, 5, 2);
		$selected_date_year = substr($selected_date, 0, 4);
	} 
	$arr_month = Array('January' , 'February' , 'March' , 'April' , 'May' , 'June' , 'July' , 'August' , 'September' , 'October' , 'November' , 'December');

	$date_combo .= " <select name='" . $pre . "month'> <option value='0'>Month</option>";
	$i = 0;
	for($i = 0;$i <= 11;$i++) {
		$date_combo .= " <option ";
		if ($i + 1 == $selected_date_month) {
			$date_combo .= " selected ";
		} 
		$date_combo .= " value='" . str_pad($i + 1, 2, "0", STR_PAD_LEFT) . "'>$arr_month[$i]</option>";
	} 

	$date_combo .= "</select>";

	$date_combo .= "<select name='" . $pre . "day'>";
	$date_combo .= "<option value='0'>Date</option>";
	for($i = 1;$i <= 31;$i++) {
		$date_combo .= " <option ";
		if ($i  == $selected_date_day) {
			$date_combo .= " selected ";
		} 
		$date_combo .= " value='" . str_pad($i, 2, "0", STR_PAD_LEFT) . "'>" . str_pad($i, 2, "0", STR_PAD_LEFT) . "</option>";
	} 
	$date_combo .= "</select>";

	$date_combo .= "<select name='" . $pre . "year'>";
	$date_combo .= "<option value='0'>Year</option>";
	for($i = $start_date_year; $i <= $end_date_year; $i++) {
		$date_combo .= " <option ";
		if ($i  == $selected_date_year) {
			$date_combo .= " selected ";
		} 
		$date_combo .= " value='" . str_pad($i, 2, "0", STR_PAD_LEFT) . "'>" . str_pad($i, 2, "0", STR_PAD_LEFT) . "</option>";
	} 
	$date_combo .= "</select>";
	return $date_combo;
} 
function date_char_input_selected($dd_name,$mm_name,$yy_name,$start,$end,$selected)
{
 global $this_class;
 
		  //$month[0]="Month"; 
		  $month[1]="Jan";
		  $month[2]="Feb";
		  $month[3]="Mar";
		  $month[4]="Apr";
		  $month[5]="May"; 
		  $month[6]="Jun"; 
		  $month[7]="Jul";
		  $month[8]="Aug";
		  $month[9]="Sep";
		  $month[10]="Oct";
		  $month[11]="Nov";
		  $month[12]="Dec";
		  
$rdate= explode("-","$selected");
 $dd=$rdate[2];
 $mm=$rdate[1];
 $yy=$rdate[0];
 
				echo "<select name=\"$dd_name\" size=\"1\" class=$this_class>";
				//echo "<option value=\"\" selected>DD</option>";
				for($i=1;$i<32;$i++)
			   {
				if ($dd == $i ) 
				{
					if($i<10) 	echo "<option value=\"0$i\" selected>0$i</option>";
				    else 	echo "<option value=\"$i\" selected>$i</option>";
			    }
				else
				{
				    if($i<10) 	echo "<option value=\"0$i\">0$i</option>";
					else echo "<option value=\"$i\">$i</option>";
			    }
			}
			echo "</select>/";
			// print mm list box
			echo "<select name=\"$mm_name\"    size=\"1\" class=$this_class>";
			for($i=1;$i<13;$i++)
			{
				 if ($mm == $i ) echo "<option value=\"$i\" selected>$month[$i]</option>";
				 else echo "<option value=\"$i\" >$month[$i]</option>";
			}
			echo "</select>/";
			// print yyyy list box
			echo "<select name=\"$yy_name\" size=\"1\" class=$this_class>";
			//echo "<option value=\"\" selected>YEAR</option>";
			for($i=$start;$i<=$end;$i++)
			{
				 if ($yy == $i ) echo "<option value=\"$i\" selected>$i</option>";
				 else echo "<option value=\"$i\" >$i</option>";
			}
			echo"</select>";
			}               
function time_input_selected($hh_name,$mm_name,$selected)
{
  global $this_class;
 $rdate= explode(":","$selected");
 $hh=$rdate[0];
 $mm=$rdate[1];

 
//				echo "dd=$dd,mm=$mm,yy=$yy";			  
				echo "<select name=\"$hh_name\" size=\"1\" class=$this_class>";
				echo "<option value=\"\" selected>HH</option>";
				for($i=1;$i<24;$i++)
			   {
				if ($hh == $i ) 
				{
					if($i<10) 	echo "<option value=\"0$i\" selected>0$i</option>";
				    else 	echo "<option value=\"$i\" selected>$i</option>";
			}
				else
				{
				    if($i<10) 	echo "<option value=\"0$i\">0$i</option>";
					else echo "<option value=\"$i\">$i</option>";
			    }
			}
			echo "</select>/";
			// print mm list box
			echo "<select name=\"$mm_name\"    size=\"1\" class=$this_class>";
			for($i=0;$i<=60;$i++)
			{
				 if ($mm == $i ) echo "<option value=\"$i\" selected>$month[$i]</option>";
				 else echo "<option value=\"$i\" >$month[$i]</option>";
			}
			echo "</select>/";
}
function get_date_format($date)
{
$date=substr($date,0,10);
$split_array=explode("-",$date);
$date=$split_array['1']."-".$split_array['2']."-".$split_array[0];
return $date;
}

function Get_Single_Field($table,$field,$field_id,$id)
{
$sql_title="select $field from $table where 1 AND $field_id='".$id."' ";
return getSingleResult($sql_title);
}


function Upload_File($field_name,$uploadfile)
{
if (move_uploaded_file($_FILES[$field_name]['tmp_name'], $uploadfile)) {
    return true;
} else {
    return false;
}

}



function is_intval($value) {
     return 1 === preg_match('/^[+]?[0-9]+$/', $value);
}


function is_decimal($value) {
     return 1 === preg_match('/^[+-]?(([0-9]+)|([0-9]*\.[0-9]+|[0-9]+\.[0-9]*)|
(([0-9]+|([0-9]*\.[0-9]+|[0-9]+\.[0-9]*))[eE][+-]?[0-9]+))$/', $value);
}


function Get_Content($id)
{

$Con_Sql="select * from content_master  where id='".$id."'";
$Con_Result=executeQuery($Con_Sql);
$Con_Line=mysql_fetch_array($Con_Result);

$Content_Array[0]=ucwords(ms_stripslashes($Con_Line['con_title']));
$Content_Array[1]=ms_stripslashes($Con_Line['con_detail']);

return $Content_Array;

}

function Meta_Tags($id)
{

$M_Sql="select * from meta_tags  where id='".$id."'";


$M_Result=executeQuery($M_Sql);
$M_Line=mysql_fetch_array($M_Result);

$Meta_Array[0]=ms_stripslashes($M_Line['m_title']);
$Meta_Array[1]=ms_stripslashes($M_Line['m_desc']);
$Meta_Array[2]=ms_stripslashes($M_Line['m_keyword']);

return $Meta_Array;

}


function Is_Valid_User($User,$Access)
{
$check_sql="select $Access from admin_login where 1 AND username='".$User."'";

$check_result=executeQuery($check_sql);
if(mysql_num_rows($check_result)>=1)
{
$line=mysql_fetch_array($check_result);
if($line[0]==0)
{
header("location:access-denied.php");
exit();
}
}
else
{
header("location:access-denied.php");
exit();
}
}

function  Get_Config_Info()
{
		$img_sql="select * from general_settings where 1";
		$img_res=executeQuery($img_sql);
		return mysql_fetch_array($img_res);
}
function protectUserPage()
{
	if($_SESSION['SESS_USER'] =='')
	{
		#$_SESSION['SESS_MSG'] = 'Please login.';
		header("location: register.php");
		exit;
	}
}
function Check_User($username)
{
if(trim($username)==""){return 1;}
$query="select count(*) from buyer where 1 AND username_customer='".$username."'";
$count=getSingleResult($query);
if($count>=1)
{
return $count;
}
else
{
$query="select count(*) from buyer where 1 AND username_customer='".$username."'";
$count=getSingleResult($query);
return $count;
}
}
function Check_Email($email,$username)
{
if(trim($email)==""){return 1;}
$con=""; if($username!=""){ $con=" AND username_customer!='".$username."'"; }
$query="select count(*) from buyer where 1 AND email='".$email."' $con ";
$count=getSingleResult($query);
if($count>=1)
{
$_SESSION['sess_mess'].="Email already exist!<br>";
return $count;
}
else
{
$con=""; if($username!=""){ $con=" AND username_customer!='".$username."'"; }
$query="select count(*) from buyer where 1 AND email='".$email."' $con ";
$count=getSingleResult($query);
if($count>=1)
{
$_SESSION['sess_mess'].="Email already exist!<br>";
}
return $count;
}


}

function Country_Dropdown($country_code)
{
$country_sql="select * from country where 1 AND parent_id=0  order by country_name ASC ";
$country_res=executeQuery($country_sql);
$dropdown='<select name="country_code" class="black_text">';
$dropdown.='<option value="">Select Country</option>';
while($country_line=mysql_fetch_array($country_res))
{

if($country_code==$country_line['country_code'])
{
$dropdown.='<option value="'.$country_line['country_code'].'" selected="selected" >'.$country_line['country_name'].'</option>';
}
else
{
$dropdown.='<option value="'.$country_line['country_code'].'" />'.$country_line['country_name'].'</option>';
}
}
$dropdown.="</select>";

return $dropdown;
}

function made_in_dropdown($made_in)
{
$country_sql="select * from country where 1 AND parent_id=0  order by country_name ASC ";
$country_res=executeQuery($country_sql);
$dropdown='<select name="made_in" class="black_text">';
$dropdown.='<option value="">Select Country</option>';
while($country_line=mysql_fetch_array($country_res))
{

if($made_in==$country_line['country_code'])
{
$dropdown.='<option value="'.$country_line['country_code'].'" selected="selected" >'.$country_line['country_name'].'</option>';
}
else
{
$dropdown.='<option value="'.$country_line['country_code'].'" />'.$country_line['country_name'].'</option>';
}
}
$dropdown.="</select>";

return $dropdown;
}

function Ajax_Country_Dropdown($country_code)
{
$country_sql="select * from country where 1 AND parent_id=0 order by country_name ASC ";
$country_res=executeQuery($country_sql);
$dropdown='<select name="country_code" onchange="get_state();" class="black_text">';
$dropdown.='<option value="">Select Country</option>';
while($country_line=mysql_fetch_array($country_res))
{

if($country_code==$country_line['c_id'])
{
$dropdown.='<option value="'.$country_line['c_id'].'" selected="selected" >'.$country_line['country_name'].'</option>';
}
else
{
$dropdown.='<option value="'.$country_line['c_id'].'" />'.$country_line['country_name'].'</option>';
}
}
$dropdown.="</select>";

return $dropdown;
}


function Seller_Dropdown($username_seller)
{
$seller_sql="select * from sellers where 1 order by username_seller ASC ";
$seller_res=executeQuery($seller_sql);
$dropdown='<select name="username_seller" class="black_text">';
$dropdown.='<option value="">Select Seller</option>';
while($seller_line=mysql_fetch_array($seller_res))
{

if($username_seller==$seller_line['username_seller'])
{
$dropdown.='<option value="'.$seller_line['username_seller'].'" selected="selected" >'.$seller_line['username_seller'].'</option>';
}
else
{
$dropdown.='<option value="'.$seller_line['username_seller'].'" />'.$seller_line['username_seller'].'</option>';
}
}
$dropdown.="</select>";

return $dropdown;
}


function Category_Dropdown($category_code)
{
$cate_sql="select * from category where 1 AND primary_category_code=0 order by category_name ASC ";
$cate_res=executeQuery($cate_sql);
$dropdown='<select name="category_code" class="black_text">';
$dropdown.='<option value="">Select Category</option>';
while($cate_line=mysql_fetch_array($cate_res))
{

if($category_code==$cate_line['category_code'])
{
$dropdown.='<option value="'.$cate_line['category_code'].'" selected="selected" >'.$cate_line['category_name'].'</option>';
}
else
{
$dropdown.='<option value="'.$cate_line['category_code'].'" />'.$cate_line['category_name'].'</option>';
}
}
$dropdown.="</select>";

return $dropdown;
}


function category_tree($category_code)
{
$category_path=getSingleResult("select category_path from category where 1 AND category_code='".$category_code."'");
$cate_sql="select category_code,category_name,primary_category_code from category where 1 AND category_code IN (".str_replace("/",",",$category_path).") order by category_code ASC ";
$cate_res=executeQuery($cate_sql);
$path_return="";
while($cate_line=mysql_fetch_array($cate_res))
{
$path_return.=' > <a href="sub-category-list.php?primary_category_code='.$cate_line['category_code'].'" class="lin1">'.ms_stripslashes($cate_line['category_name']).'</a>';
}
return $path_return;
}


function product_category_tree($category_code,$file_name)
{
$category_path=getSingleResult("select category_path from category where 1 AND category_code='".$category_code."'");
$cate_sql="select category_code,category_name,primary_category_code from category where 1 AND category_code IN (".str_replace("/",",",$category_path).") order by category_code ASC ";
$cate_res=executeQuery($cate_sql);
$path_return="";
while($cate_line=mysql_fetch_array($cate_res))
{
$path_return.='&gt;&gt;<a href="'.$file_name.'?category_code='.$cate_line['category_code'].'&c='.seo_filter("$cate_line[category_name]").'" class="sidehdr_lnk">'.ms_stripslashes($cate_line['category_name']).'</a>';
}
return $path_return;
}




function Mail_Content($id)
{
$mail_sql="select * from mail_template where 1 AND id='".$id."'";
$mail_res=executeQuery($mail_sql);
return mysql_fetch_array($mail_res);

}

 
function Send_Mail($to,$subject,$message,$from)
{
/* To send HTML mail, you can set the Content-type header. */ 
$headers  = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

/* additional headers */ 
$headers .= "To: $to \r\n"; 
$headers .= "From: Wholesale-connect.com <$from>\r\n"; 

/* and now mail it */ 
//echo "$to, $subject, $message, $headers ";
//die();

//mail($to, $subject, $message, $headers); 

}
 
 
 function Manufacture_Dropdown($manufacture,$seller)
{
if($seller!="")
{
$query="select * from manufactures where 1 AND sellers='".$seller."' order by manufacture ASC ";
}
else
{
$query="select * from manufactures where 1 order by manufacture ASC ";
}
//echo $query;
$res=executeQuery($query);
$dropdown='<select name="manufacture" class="black_text">';
$dropdown.='<option value="">Select Manufacturer</option>';
while($row=mysql_fetch_array($res))
{

if($manufacture==$row['m_id'])
{
$dropdown.='<option value="'.$row['m_id'].'" selected="selected" >'.$row['manufacture'].'</option>';
}
else
{
$dropdown.='<option value="'.$row['m_id'].'" />'.$row['manufacture'].'</option>';
}
}
$dropdown.="</select>";

return $dropdown;
}


 function Category_Dropdown_Box($category_code)
{
$query="select * from category where 1 order by category_name ASC ";
$res=executeQuery($query);
$dropdown='<select name="category_code" class="black_text">';
$dropdown.='<option value="">Select Category</option>';
while($row=mysql_fetch_array($res))
{
if($category_code==$row['category_code'])
{
$dropdown.='<option value="'.$row['category_code'].'" selected="selected" >'.$row['category_name'].'</option>';
}
else
{
$dropdown.='<option value="'.$row['category_code'].'">'.ms_stripslashes($row['category_name']).'</option>';
}

 

}
$dropdown.="</select>";

return $dropdown;
}


function Get_Email($username)
{
if(trim($username)==""){return 1;}
$query="select email from buyer where 1 AND username_customer='".$username."'";
$count=getSingleResult($query);
if(strlen($count)>=1)
{
return $count;
}
else
{
$query="select email from sellers where 1 AND username_seller='".$username."'";
$count=getSingleResult($query);
return $count;
}
 }



function Multiple_Category_Dropdown($category_code,$category_status)
{

if(count($category_code)==0){ $category_code[]=0; }

if($category_status="") { $con=" AND category_status='".$category_status."' "; }
$cate_sql="select * from category where 1 AND primary_category_code=0 $con order by category_name ASC ";
$cate_res=executeQuery($cate_sql);
$dropdown='';
$dropdown='<select name="category_code[]" class="black_text" id="multi_1" multiple size="6">';
#$dropdown.='<option value="">Select Category</option>';
while($cate_line=mysql_fetch_array($cate_res))
{
$sel_con="";
if (in_array($cate_line['category_code'],$category_code)) { $sel_con=' selected="selected" ';}

$dropdown.='<option value="'.$cate_line['category_code'].'" '.$sel_con.' />'.$cate_line['category_name'].'</option>';



$l2sql="select * from category where 1 AND primary_category_code='".$cate_line['category_code']."' $con order by category_name ASC ";
$l2res=executeQuery($l2sql);
if(mysql_num_rows($l2res)==0){ continue; }
while($l2line=mysql_fetch_array($l2res))
{
$sel_con="";
if (in_array($l2line['category_code'],$category_code)) { $sel_con=' selected="selected" ';}
 $dropdown.='<option value="'.$l2line['category_code'].'" '.$sel_con.' />'.$cate_line['category_name'].'/'.$l2line['category_name'].'</option>'; 


$l3sql="select * from category where 1 AND primary_category_code='".$l2line['category_code']."' $con order by category_name ASC ";
$l3res=executeQuery($l3sql);
if(mysql_num_rows($l3res)==0){ continue; }
while($l3line=mysql_fetch_array($l3res))
{
$sel_con="";
if (in_array($l3line['category_code'],$category_code)) { $sel_con=' selected="selected" ';}
 $dropdown.='<option value="'.$l3line['category_code'].'" '.$sel_con.' />'.$cate_line['category_name'].'/'.$l2line['category_name'].'/'.$l3line['category_name'].'</option>'; 

$l4sql="select * from category where 1 AND primary_category_code='".$l3line['category_code']."' $con order by category_name ASC ";
$l4res=executeQuery($l4sql);
if(mysql_num_rows($l4res)==0){ continue; }
while($l4line=mysql_fetch_array($l4res))
{
$sel_con="";
if (in_array($l4line['category_code'],$category_code)) { $sel_con=' selected="selected" ';}
 $dropdown.='<option value="'.$l4line['category_code'].'" '.$sel_con.' />'.$cate_line['category_name'].'/'.$l2line['category_name'].'/'.$l3line['category_name'].'/'.$l4line['category_name'].'</option>';

$l5sql="select * from category where 1 AND primary_category_code='".$l4line['category_code']."' $con order by category_name ASC ";
$l5res=executeQuery($l5sql);
if(mysql_num_rows($l5res)==0){ continue; }
while($l5line=mysql_fetch_array($l5res))
{
$sel_con="";
if (in_array($l5line['category_code'],$category_code)) { $sel_con=' selected="selected" ';}
 $dropdown.='<option value="'.$l5line['category_code'].'" '.$sel_con.' />'.$cate_line['category_name'].'/'.$l2line['category_name'].'/'.$l3line['category_name'].'/'.$l4line['category_name'].'/'.$l5line['category_name'].'</option>'; 

$l6sql="select * from category where 1 AND primary_category_code='".$l5line['category_code']."' $con order by category_name ASC ";
$l6res=executeQuery($l6sql);
if(mysql_num_rows($l6res)==0){ continue; }
while($l6line=mysql_fetch_array($l6res))
{
$sel_con="";
if (in_array($l6line['category_code'],$category_code)) { $sel_con=' selected="selected" ';}
 $dropdown.='<option value="'.$l6line['category_code'].'" '.$sel_con.' />'.$cate_line['category_name'].'/'.$l2line['category_name'].'/'.$l3line['category_name'].'/'.$l4line['category_name'].'/'.$l5line['category_name'].'/'.$l6line['category_name'].'</option>'; 

}
$l7sql="select * from category where 1 AND primary_category_code='".$l6line['category_code']."' $con order by category_name ASC ";
$l7res=executeQuery($l7sql);
if(mysql_num_rows($l7res)==0){ continue; }
while($l7line=mysql_fetch_array($l6res))
{
$sel_con="";
if (in_array($l7line['category_code'],$category_code)) { $sel_con=' selected="selected" '; }
 $dropdown.='<option value="'.$l7line['category_code'].'" '.$sel_con.' />'.$cate_line['category_name'].'/'.$l2line['category_name'].'/'.$l3line['category_name'].'/'.$l4line['category_name'].'/'.$l5line['category_name'].'/'.$l6line['category_name'].'/'.$l7line['category_name'].'</option>'; 

}
}
}
}
}




}

$dropdown.="</select>";

return $dropdown;
}


function add_newsletter($email,$name,$status,$type)
{
$query="select count(*) from newsletter_users where 1 AND email='".$email."'";
$count=getSingleResult($query);
if($count==0)
{
$sql="INSERT INTO newsletter_users (email,name,status,user_type) VALUES ('".$email."','".$name."','".$status."','".$type."') ";
executeQuery($sql);
}


}

function update_newsletter($email,$status)
{
$sql="UPDATE newsletter_users  SET status='".$status."' where 1 AND email='".$email."' ";
executeQuery($sql);

}

function category_count_plus($parent_id)
{
$con_check=1;

while($con_check!=0)
{
$queryp="select primary_category_code,category_code from category where 1 AND category_code='".$parent_id."' ";
$resp=executeQuery($queryp);
$rowp=mysql_fetch_array($resp);
$con_check=mysql_num_rows($resp);
if($con_check>=1)
{
 executeQuery("update category set grand_total = grand_total + 1 where 1 AND category_code='".$parent_id."'"); 
}
$parent_id=$rowp['primary_category_code'];
}
}

function category_count_minus($parent_id)
{
$con_check=1;

while($con_check!=0)
{
$queryp="select primary_category_code,category_code from category where 1 AND category_code='".$parent_id."' ";
$resp=executeQuery($queryp);
$rowp=mysql_fetch_array($resp);
$con_check=mysql_num_rows($resp);
if($con_check>=1)
{
 executeQuery("update category set grand_total = grand_total - 1 where 1 AND category_code='".$parent_id."' AND grand_total!=0"); 
}
$parent_id=$rowp['primary_category_code'];
}



}



function Get_Password($email)
{
if(trim($email)==""){return 0;}
$query="select passwd from buyer where 1 AND email='".$email."'";
$count=getSingleResult($query);
if(strlen($count)!=0)
{
return $count;
}
else
{
$query="select passwd from sellers where 1 AND email='".$email."'";
$count=getSingleResult($query);
return $count;
}
}


function message_info($user)
{
if(trim($user)==""){return false;}
$query="select firstname,lastname,company,username_customer,passwd from buyer where 1 AND username_customer='".$user."'";
$res=executeQuery($query);
if(mysql_num_rows($res)>=1)
{
return mysql_fetch_array($res);
}
else
{
$query="select firstname,lastname,company,username_seller,passwd from sellers where 1 AND username_seller='".$user."'";
$res=executeQuery($query);
return mysql_fetch_array($res);
}
}

function Get_Childs($id)
{
$childs_array[]=$id;
$parent_ids=implode(",",$childs_array);
$count_rows=1;
while($count_rows!=0)
{
$sql="select category_code  from  category where 1 AND primary_category_code IN ($parent_ids) ";
$res=executeQuery($sql);
$count_rows=mysql_num_rows($res);
unset($ids);
$ids="";
while($row=mysql_fetch_array($res))
{
$ids[]=$row['category_code'];
$childs_array[]=$row['category_code'];
}
$parent_ids="";
if(count($ids)>=1){ $parent_ids=@implode(",",$ids); }
}

return $childs_array;
}


function Get_Root_Parent($category_code,$parent_id)
{
if($parent_id==0){$loop=0;}else{$loop=1;}
while($loop==1)
{
$pres=executeQuery("select category_code,primary_category_code from category where 1  and category_code='".$parent_id."'");
if(mysql_num_rows($pres)==0)
{
$loop=0;
}
else
{
$pline=mysql_fetch_array($pres);
$parent_id=$pline['primary_category_code'];
$category_code=$pline['category_code'];
if($parent_id==0){$loop=0;}
}
}
return $category_code;
}
/*
function resize_image($resize_width,$resize_height,$temp_path,$target_path)
{
// Create an Image from it so we can do the resize
$src = imagecreatefromjpeg($temp_path);

// Capture the original size of the uploaded image
list($width,$height)=getimagesize($temp_path);

// For our purposes, I have resized the image to be
// 600 pixels wide, and maintain the original aspect
// ratio. This prevents the image from being "stretched"
// or "squashed". If you prefer some max width other than
// 600, simply change the $newwidth variable
$newwidth=$resize_width;
//$newheight=($height/$width)*$resize_width;
$newheight=$resize_height;
$tmp=imagecreatetruecolor($newwidth,$newheight);

// this line actually does the image resizing, copying from the original
// image into the $tmp image
imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

// now write the resized image to disk. I have assumed that you want the
// resized, uploaded image file to reside in the ./images subdirectory.
$filename = $target_path;
imagejpeg($tmp,$filename,100);

imagedestroy($src);
imagedestroy($tmp); // NOTE: PHP will clean up the temp file it created when the request
// has completed.
}
*/
$hostname="http://".$_SERVER['HTTP_HOST'];
$small_image_width=100;
$small_image_height=100;

$big_image_width=300;
$big_image_height=300;

$manu_small_width=70;
$manu_small_height=50;

include("img_functions.php");

function category_path_show($category_code)
{
$category_path=getSingleResult("select category_path from category where 1 AND category_code='".$category_code."'");
$cate_sql="select category_code,category_name from category where 1 AND category_code IN (".str_replace("/",",",$category_path).") order by category_code ASC ";
$cate_res=executeQuery($cate_sql);
$path_return="";
while($cate_line=mysql_fetch_array($cate_res))
{
$path_return.='_'.ms_stripslashes($cate_line['category_name']);
}
$path_return=strtolower(str_replace(" ","_",$path_return));
$path_return=substr($path_return,1);
return $path_return;
}

function csv_category_path($category_code)
{
$category_path=getSingleResult("select category_path from category where 1 AND category_code='".$category_code."'");
$cate_sql="select category_code,category_name from category where 1 AND category_code IN (".str_replace("/",",",$category_path).") order by category_code ASC ";
$cate_res=executeQuery($cate_sql);
$path_return="";
while($cate_line=mysql_fetch_array($cate_res))
{
$path_return.='/'.ms_stripslashes($cate_line['category_name']);
}
$path_return=substr($path_return,1);
return $path_return;
}



///////////////////////////////////////////////Count the products////////////////////////
function Count_Products($id)
{
$childs_array=Get_Childs($id);
$cids=implode(",",$childs_array);
return getSingleResult("select SUM(product_count) from category where 1 AND category_code IN ($cids)  ");

}

?>