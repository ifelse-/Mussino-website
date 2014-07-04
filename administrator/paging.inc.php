<?
if($reccnt!=0){
	
$pagenum=$reccnt/$pagesize;

$PHP_SELF=$HTTP_SERVER_VARS['PHP_SELF'];
$qry_str=$HTTP_SERVER_VARS['argv'][0];

$m=$_GET;
unset($m['start']);

$qry_str=qry_str($m);

//echo "$qry_str : $p<br>";

	if($pagenum>40)
	{
		$j=$start/$pagesize;		
		$k=$j+40;
		if($k>$pagenum)
		{
			$k=$pagenum;
		}
	}
	else
	{
		$j=0;
		$k=$pagenum;
	}

?>
<?//="$start : $pagesize : $j : $k"?>
<link href="css/css.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr> 
    <td width="12%" height="40" align="center" >
	<a href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$start-$pagesize?>"  class="lin2" > 
      <?
		if($start!=0)
		{

?>
      <strong>&laquo; Previous </strong></a>&nbsp; 
      <?
		}
?>     </td>
    <td style="color:#333333" width="79%" align="center" height="20">
      <?
			
			for($i=$j;$i<$k;$i++)
			{
				if($i==$j)echo "Page:";
			   if(($pagesize*($i))!=$start)
				  {
	  ?>
      <a href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$pagesize*($i)?>"> 
      <?=$i+1?>
      </a> 
      <?
				  }
	  else{
	  ?>
    <b> 
      <?=$i+1?>
      </b>
      <?
	  }
 }?>    </td>
    <td width="9%" height="20"   align="center" class="h12"> 
      <?
	if($start+$pagesize < $reccnt){
		?>
      &nbsp;&nbsp; <a href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$start+$pagesize?>"  class="lin2">Next 
      &raquo;</a>&nbsp; 
      <?
		}
  ?>    </td>
  </tr>
</table>
<?}
?>
