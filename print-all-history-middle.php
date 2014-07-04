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
              <div class="blue-btn-1"> <span><span><a href="javascript:window.print();" >Print All</a></span></span> </div>
             
            </div>
          </div>
        </div>
        <div class="pro-content">
        <form id="frmEditRegistration" name="frmEditRegistration"  method="post" action="">
          <div class="pro-left fl">
            <div class="user-img">
            
            </div>
            <div class="pro-btn_row">
                             
            </div>
          </div>
          <div class="pro-right">
             <div class="form-container">
              <div class="rgtPannel2 fr">
         
           <div class=" history">
          <h2></h2>
          <div class="scroller" style="margin-top:10px;">
            <?php
					$ct=1;
					$k=0;
					while($colles_history_post = mysql_fetch_array($colles_history_result)) 
					{		
					?>
                    
              <div class="postBlock" style=" padding:0 0 10px 0;background:<?=$bgcolor?>" >
              <h3><?=stripslashes(Get_Single_Field("product_master","Title","Product_Id","$colles_history_post[Product_Id]"))?> </h3>
              <p>
               <?=stripslashes($colles_history_post['Lyrics']);?>
              </p>
              <strong>
              
              </strong> <span>
              <?=get_date_format($colles_history_post['Lyrics_Date']);?>
              </span>
              
            </div>
            <div style="padding:5px 0 0 0;"></div>
            
            <?php
			$ct++;
			$k++;
			}
			?>
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
