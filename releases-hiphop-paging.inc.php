<?php
if($reccnt_sound_type1!=0){
$pagenum=$reccnt_sound_type1/$pagesize;
$PHP_SELF=$HTTP_SERVER_VARS['PHP_SELF'];
$qry_str=$HTTP_SERVER_VARS['argv'][0];
$m=$_GET;
unset($m['start']);
$qry_str=qry_str($m);

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


<div class="paging">
          <div class="right">
          <ul>
            <li class="title">Pages</li>
            <?php if($start!=0) { ?>
            <li class="prev"><a href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$start-$pagesize?>">previous</a></li>
            <?php } ?>
            <?php
			for($i=$j;$i<$k;$i++)
			{
			if($i==$j)echo " ";
			if(($pagesize*($i))!=$start)
			{
			?>
            <li><a href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$pagesize*($i)?>"><?=$i+1?></a></li>
           	<?php
			}
			else
			{
			?>  
			<li class="active"><?=$i+1?></li>
			<?php
			}
			}
			?>
            <?php if($start+$pagesize < $reccnt_sound_type1){ ?><li class="nxt"><a href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$start+$pagesize?>">Next</a></li><?php } ?>
          </ul>
          <div class="cl"></div>
          </div>
          <div class="cl"></div>
        </div>
<?php } ?>


