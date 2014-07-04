<div class="content-box-1">
        <div class="cor_1set-1"></div>
        <div class="cor_1set-2"></div>
        <div class="player-box fl">
          
          <?php  if(strtolower($ext)=='mp3' || strtolower($ext)=='wma' || strtolower($ext)=='wav') { ?>
          <div class="player" id="flashAlternativeContent">
          <script type="text/javascript" src="src/swfobject.js"></script>
          <script type="text/javascript">
			var flashvars = {};
			var params = {};
			var attributes = {};
			attributes.id = "oxylusflash";
			params.allowFullScreen = "true";
			params.allowScriptAccess = "always";
			params.bgColor = "#101010";
			
			// set here below the path to resolve all the relative paths in the video player if you want to store it in a different folder
			params.base = "";
			
			// specify here the path to the xml file (default is "xml/video_config.xml")
			flashvars.settingsXmlPath = "settings.xml";
			flashvars.contentXmlPath = "content.xml";
			
			// change here below the width and height of the player. It must match the width and height you have set in the xml file
			var embedWidth = "640";
			var embedHeight = "360";
			
			swfobject.embedSWF("player.swf", "flashAlternativeContent", embedWidth, embedHeight, "9.0.0", "js/expressInstall.swf", flashvars, params, attributes);
		</script>
        <!-- end of EMBED CODE -->
            <a href="http://www.adobe.com/go/getflashplayer">
				<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
			</a>
          </div>
          <?php  } else { ?>
          <div class="player">
          <script type="text/javascript">
AC_FL_RunContent( 'codebase','http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0','width','640','height','360','src','pro_video_player1.2.2','quality','high','bgcolor','#000000','wmode','transparent','allowscriptaccess','sameDomain','allowfullscreen','true','pluginspage','http://www.macromedia.com/go/getflashplayer','flashvars','xmlPath=video.xml','movie','pro_video_player1.2.2' ); //end AC code
</script><noscript><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="640" height="360">
          <param name="allowScriptAccess" value="sameDomain" />
          <param name="allowFullScreen" value="true" />
          <param name="movie" value="pro_video_player1.2.2.swf" />
          <param name="quality" value="high" />
          <param name="wmode" value="transparent">
          <param name="bgcolor" value="#000000" />
          <param name="flashvars" value="xmlPath=video.xml">
          <embed src="pro_video_player1.2.2.swf" width="640" height="360" quality="high" bgcolor="#000000"  name="wmode" value="transparent" allowScriptAccess="sameDomain" allowFullScreen="true" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="xmlPath=video.xml" />          
        </object></noscript>
    
          </div>
          <?php }  ?>
          <div class="member">
            <div class="member_wrap"><?php if($_SESSION['SESS_EMAIL']=='') { ?>
            <a id="variousInviteFriends" href="#inviteFriends"><input type="image" name="tell_a_frnd" src="images/spacer.gif" class="frnd_btn"/></a>
            
			<h1 class="rfExample renderedFont">Become a member today</h1> 
              
                    <div style="display: none;">
                            <div id="inviteFriends" style="width:600px;height:455px;">
                                <div style="padding: 5px 0 0 100px;">
                                <form id="frmInviteFriend" name="frmInviteFriend" method="post" action="">
                                <ul>
                                
                                
                                <li>
                                        <ul class="login">
                                            <li><h1>Tell a Friend</h1></li>
                                            <li></li>
                                        </ul>
                                 </li>
                                    
                                    <li  id="invite_friend_id" style="padding: 5px 0 5px 0;"></li>
                                    
                                    <li>
                                        <ul class="login">
                                            <li>Friend Name </li>
                                            <li><input type="text" name="Name" size="30" class="input-text" onkeypress="if(event.keyCode==13) {return InviteFriendRequest();}" /></li>
                                        </ul>
                                    </li>
                                    
                                    <li>
                                        <ul class="login">
                                            <li>Friend Email ID </li>
                                            <li><input type="text" name="Email" size="30" class="input-text" onkeypress="if(event.keyCode==13) {return InviteFriendRequest();}" /></li>
                                        </ul>
                                    </li>
                                    
                                    <li>
                                        <ul class="login">
                                            <li>Email Message</li>
                                            <li><textarea name="Message" cols="57" rows="6" onkeypress="if(event.keyCode==13) {return InviteFriendRequest();}"></textarea></li>
                                        </ul>
                                    </li>
                                    
                                    
                                    
                                    <li>
                                        <ul class="login">
                                            <li>Type the code shown</li>
                                            <li><input type="text" name="security_code" class="input-text" id="security_code" size="30" onkeypress="if(event.keyCode==13) {return InviteFriendRequest();}"></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul class="login">
                                            <li>&nbsp;</li>
                                            <li><img src="php_captcha.php?hash=<?php echo $hash; ?>&width=130&height=37&characters=8" alt="captcha" name="captchaImage" id="captcha5"/></li>
                                        </ul>
                                    </li>
                                    
                                     <div class="gray-btn-1">
                                        <span>
                                          <span><a href="javascript:void(0);"  id="captcha-refresh5">Refresh</a></span>
                                        </span>
                                     </div>
                                    <li>
                                        <ul class="login">
                                            <li>&nbsp;</li>
                                            <li><input class="button" name="buttonSubmit" type="button" value="Submit" onclick="return InviteFriendRequest();" onkeypress="if(event.keyCode==13) {return InviteFriendRequest();}"></li>
                                        </ul>
                                    </li>
                                </ul>
                            </form>
                                </div>
                            </div>
                       </div></span>
            <?php } else { ?>
            <p><?=$_SESSION['SESS_FIRST_NAME'].' '.$_SESSION['SESS_LAST_NAME']?> would you like to</p> <span><a id="variousInviteFriends" href="#inviteFriends"><input src="images/spacer.gif" type="image" name="tell_a_frnd" class="frnd_btn"/></a></span>
            <br /><br />
             <div style="height:100px;">
              <img src="images/underplayerad.jpg" />
              </div>
              
              
             
             
              
                    <div style="display: none;">
                            <div id="inviteFriends" style="width:600px;height:455px;">
                                <div style="padding: 5px 0 0 100px;">
                                <form id="frmInviteFriend" name="frmInviteFriend" method="post" action="">
                                <ul>
                                
                                
                                <li>
                                        <ul class="login">
                                            <li><h1>Tell a Friend</h1></li>
                                            <li></li>
                                        </ul>
                                    </li>
                                    
                                    <li  id="invite_friend_id" style="padding: 5px 0 5px 0;"></li>
                                    
                                    <li>
                                        <ul class="login">
                                            <li>Friend Name </li>
                                            <li><input type="text" name="Name" size="30" class="input-text" onkeypress="if(event.keyCode==13) {return InviteFriendRequest();}" /></li>
                                        </ul>
                                    </li>
                                    
                                    <li>
                                        <ul class="login">
                                            <li>Friend Email ID </li>
                                            <li><input type="text" name="Email" size="30" class="input-text" onkeypress="if(event.keyCode==13) {return InviteFriendRequest();}" /></li>
                                        </ul>
                                    </li>
                                    
                                    <li>
                                        <ul class="login">
                                            <li>Email Message</span></li>
                                            <li><textarea name="Message" cols="57" rows="6" onkeypress="if(event.keyCode==13) {return InviteFriendRequest();}"></textarea></li>
                                        </ul>
                                    </li>
                                    
                                    
                                    
                                    <li>
                                        <ul class="login">
                                            <li>Type the code shown</li>
                                            <li><input type="text" name="security_code" class="input-text" id="security_code" size="30" onkeypress="if(event.keyCode==13) {return InviteFriendRequest();}"></li>
                                        </ul>
                                    </li>
                                    
                                    
                                    <li>
                                        <ul class="login">
                                            <li>&nbsp;</li>
                                            <li><img src="php_captcha.php?hash=<?php echo $hash; ?>&width=130&height=37&characters=8" alt="captcha" name="captchaImage" id="captcha4"/></li>
                                        </ul>
                                    </li>
                                    
                                     <div class="gray-btn-1">
                                        <span>
                                          <span><a href="javascript:void(0);"  id="captcha-refresh4">Refresh</a></span>
                                        </span>
                                     </div>
                                    
                                    
                                    
                                    
                                    <li>
                                        <ul class="login">
                                            <li>&nbsp;</li>
                                            <li><input class="button" name="buttonSubmit" type="button" value="Submit" onclick="return InviteFriendRequest();" onkeypress="if(event.keyCode==13) {return InviteFriendRequest();}"></li>
                                        </ul>
                                    </li>
                                </ul>
                            </form>
                                </div>
                            </div>
                       </div></span>
            <?php } ?>
            <div class="cl"></div></div>
          </div>
          <div class="option-box">
            <?php if($_SESSION['SESS_EMAIL']=='') { ?>
            <ul>
              <li class="main-row1">
                <a id="variousMusicianRegister" class="globalTxtSpace" href="#requestMusicianRegister"><span class="h5">Musician <span>Signup</span></span><br />                
                Become a member and start uploading music today.
                </a>
                <div style="display: none;">
                            <div id="requestMusicianRegister" style="width:350px;height:602px;">
                            
                            <!-- LEFT -->
                            <div class="fl">
                                <div style="padding: 5px 0 0 20px;">
                                <form id="frmMusicianRegistration" name="frmMusicianRegistration"  method="post" action="">
                                <ul>
                                    
                                    
                                    <li>
                                        <ul class="login">
                                            <li><img src="http://www.mussino.com/images/piano.png" align="top" width="38"/> <h2 class="rfExample renderedFont"> Musician Signup</h2></li>
                                            <span class="signupTxt">in less than 60 seconds.</span>
                                            </li>
                                            <li></li>
                                        </ul>
                                    </li>
                                    
                                    <li><div  id="view_musician_registration_result" style="padding: 5px 0 5px 0;"></div></li>
                                    
                                    <li>
                                        <ul class="login">
                                            <li><strong>Email Address</strong></li>
                                            <li>
                                           
                                            <input type="text" name="Email" size="30" class="input-text lgform" onkeypress="if(event.keyCode==13) {return registration_musician_request_result('Musician');}" />
                                         
                                            
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul class="login">
                                            <li><strong>Password</strong></li>
                                            <li>
                                            
                                            <input type="password" name="Password" size="30"  class="input-text lgform" onkeypress="if(event.keyCode==13) {return registration_musician_request_result('Musician');}"/>
                                            
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul class="login">
                                            <li><strong>Confirm Password</strong></li>
                                            <li>
                                            
                                            <input type="password" name="ConfirmPassword" size="30"  class="input-text lgform" onkeypress="if(event.keyCode==13) {return registration_musician_request_result('Musician');}"/>
                                            
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul class="login">
                                            <li><strong>Stage Name</strong></li>
                                            <li>
                                            
                                            <input type="text" name="First_Name" size="30" class="input-text lgform" onkeypress="if(event.keyCode==13) {return registration_musician_request_result('Musician');}" />
                                            
                                            </li>
                                        </ul>
                                    </li>
                                    
                                  
                                   
                                    <li>
                                        <ul class="login">
                                            <li><strong>Type the code shown</strong></li>
                                            <li>
                                            
                                            <input type="text" name="security_code" class="input-text lgform" id="security_code" size="30" onkeypress="if(event.keyCode==13) {return registration_musician_request_result('Musician');}">
                                            
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul class="login">
                                           
                                            <li><img src="php_captcha.php?hash=<?php echo $hash; ?>&width=130&height=37&characters=8" alt="captcha" name="captchaImage" id="captcha3"/></li>
                                        </ul>
                                    </li>
                                    
                              
                                        <span class="colorlink1"><a href="javascript:void(0);"  id="captcha-refresh3"> <img src="images/refresh.png" width="31" align="absbottom" /> Refresh</a></span>
                                     
                                     <li>
                                      <div class="caption-2">&nbsp;</div>
                                      <p>&nbsp;</p>
                                       <p>&nbsp;</p>
                                      <div  class="termsTxt">
                                      
                                       
                                       <label class="ignore">
                          <input name="terms" type="checkbox" value="1" /><span> By clicking Sign up free, you agree to Mussino.com <br /><a href="main-page.php?id=5" target="_blank">terms of service</a> and <a href="main-page.php?id=14" target="_blank">privacy policy</a>. </span>
                        </label>
                                       
                                       
                                       
                                       <br />
                                    
                                      </div>
                                      <div class="cl"></div>
                                      
                                    </li>
                                     
                                    <li>
                                        <ul class="login">
                                            <li>&nbsp;</li>
                                            <li><input class="button" name="buttonSubmit" type="button" value="Let me in NOW!" onclick="return registration_musician_request_result('Musician');" onkeypress="if(event.keyCode==13) {return registration_musician_request_result('Musician');}"></li>
                                        </ul>
                                    </li>
                                </ul>
                            </form>
                                </div>
                                </div>
                                <!-- / Left -->
                                
                                <!-- Right -->
                                <div class="fl w150">
                                <!--<div class="pdf_Info">
                               <img src="images/pdf_icon.png" />
                               
                               <span><img src="images/smCheck.png" align="absbottom" class="pdfChecks"/>&nbsp;&nbsp;<a href="">How it works</a></span>
                               <br />
                               <span><img src="images/smCheck.png" align="absbottom" class="pdfChecks"/>&nbsp;&nbsp;<a href="">Sample Clearance</a></span>
                               <br />
                               <span><img src="images/smCheck.png" align="absbottom" class="pdfChecks"/>&nbsp;&nbsp;<a href="">Music Copyright</a></span>
                               <br /><br />
                              <span style=" color:#999;"> <strong>Note:</strong> You can also find this information in your control panel. </span>
                            
                              
                               </div>-->
                                </div>
                                <!--/ Right -->
                            </div>
                       </div>
              </li>
              <li class="main-row2">
                <a id="variousSongwriterSignup" class="globalTxtSpace" href="#requestSongwriterSignup"><span class="h5">Songwriter <span>Signup</span></span><br />                
                Become a member and start posting lyrics today.</a>
                <div style="display: none;">
                            <div id="requestSongwriterSignup" style="width:350px;height:602px;">
                            
                            <!-- LEFT -->
                            <div class="fl">
                                <div style="padding: 5px 0 0 20px;">
                                <form id="frmSongwriterRegistration" name="frmSongwriterRegistration"  method="post" action="">
                                <ul>
                                    
                                    
                                    <li>
                                        <ul class="login">
                                            <li><img src="http://www.mussino.com/images/notebook.png" align="top"/><h2 class="rfExample renderedFont">Songwriter Signup</h2><br />
                                            <span class="signupTxt">in less than 60 seconds.</span>
                                            </li>
                                            <li></li>
                                        </ul>
                                    </li>
                                    
                                    <li  id="view_songwriter_registration_result" style="padding: 5px 0 5px 0;"></li>
                                    
                                    <li>
                                        <ul class="login">
                                            <li><strong>Email Address</strong></li>
                                            <li>
                                            
                                            <input type="text" name="Email" size="30" class="input-text lgform" onkeypress="if(event.keyCode==13) {return registration_songwriter_request_result('Artist');}" />
                                            
                                            
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul class="login">
                                            <li><strong>Password</strong></li>
                                            <li>
                                            
                                            <input type="password" name="Password" size="30"  class="input-text lgform" onkeypress="if(event.keyCode==13) {return registration_songwriter_request_result('Artist');}"/>
                                            
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul class="login">
                                            <li><strong>Confirm Password</strong></li>
                                            <li>
                                            
                                            <input type="password" name="ConfirmPassword" size="30"  class="input-text lgform" onkeypress="if(event.keyCode==13) {return registration_songwriter_request_result('Artist');}"/>
                                            
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul class="login">
                                            <li><strong>Stage Name</strong></li>
                                            <li>
                                            
                                            <input type="text" name="First_Name" size="30" class="input-text lgform" onkeypress="if(event.keyCode==13) {return registration_songwriter_request_result('Artist');}" />
                                            
                                            </li>
                                        </ul>
                                    </li>
                                    
                                 
                                   
                                    <li>
                                        <ul class="login">
                                            <li><strong>Type the code shown</strong></li>
                                            <li>
                                            
                                            <input type="text" name="security_code" class="input-text lgform" id="security_code" size="30" onkeypress="if(event.keyCode==13) {return registration_songwriter_request_result('Artist');}">
                                            
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul class="login">
                                         
                                            <li><img src="php_captcha.php?hash=<?php echo $hash; ?>&width=130&height=37&characters=8" alt="captcha" name="captchaImage" id="captcha2"/></li>
                                        </ul>
                                    </li>
                                    
                                    
                                      <span class="colorlink1"><a href="javascript:void(0);"  id="captcha-refresh2"> <img src="images/refresh.png" width="31" align="absbottom" /> Refresh</a></span>
                                     
                                     <li>
                                      <div class="caption-2">&nbsp;</div>
                                      <p>&nbsp;</p>
                                       <p>&nbsp;</p>
                                      <div class="termsTxt">
                                   <label class="ignore">
                          <input name="terms" type="checkbox" value="1" /><span> By clicking Sign up free, you agree to Mussino.com <br /><a href="main-page.php?id=5" target="_blank">terms of service</a> and <a href="main-page.php?id=14" target="_blank">privacy policy</a>. </span>
                        </label>
                                       <br />
                                    
                                      </div>
                                      <div class="cl"></div>
                                      
                                    </li>
                                     
                                    <li>
                                        <ul class="login">
                                            <li>&nbsp;</li>
                                            <li><input class="button" name="buttonSubmit" type="button" value="Let me in NOW!" onclick="return registration_songwriter_request_result('Artist');" onkeypress="if(event.keyCode==13) {return registration_songwriter_request_result('Artist');}"></li>
                                        </ul>
                                    </li>
                                </ul>
                            </form>
                                </div>
                                </div>
                                <!-- / Left -->
                                
                                <!-- Right -->
                                <div class="fl w150">
                               <!--<div class="pdf_Info">
                               <img src="images/pdf_icon.png" />
                               
                               <span><img src="images/smCheck.png" align="absbottom" class="pdfChecks"/>&nbsp;&nbsp;<a href="">How it works</a></span>
                               <br />
                               <span><img src="images/smCheck.png" align="absbottom" class="pdfChecks"/>&nbsp;&nbsp;<a href="">Sample Clearance</a></span>
                               <br />
                               <span><img src="images/smCheck.png" align="absbottom" class="pdfChecks"/>&nbsp;&nbsp;<a href="">Music Copyright</a></span>
                               <br /><br />
                              <span style=" color:#999;"> <strong>Note:</strong> You can also find this information in your control panel. </span>
                            
                              
                               </div>-->
                                </div>
                                <!--/ Right -->
                            </div>
                       </div>
              </li>
              <li class="main-row3">
                <a id="variousJudgeSignup" class="globalTxtSpace" href="#requestJudgeSignup"><span class="h5">Judge <span>Signup</span></span><br />                
                Become a member and start judging contests</a>
                <div style="display: none;">
                
                            <div id="requestJudgeSignup" style="width:350px;height:602px;">
                            
                            <!-- LEFT -->
                            <div class="fl">
                                <div style="padding: 5px 0 0 20px;">
                                <form id="frmJudgeRegistration" name="frmJudgeRegistration"  method="post" action="">
                                <ul>
                                    
                                    
                                    <li>
                                        <ul class="login">
                                            <li><img src="http://www.mussino.com/images/usersjudge.png" align="top"/> <h2 class="rfExample renderedFont">Judge | Fans Signup</h2><br />
                                            <span class="signupTxt">in less than 60 seconds.</span>
                                            </li>
                                            <li></li>
                                        </ul>
                                    </li>
                                    
                                    <li  id="view_judge_registration_result" style="padding: 5px 0 5px 0;"></li>
                                    
                                    <li>
                                        <ul class="login">
                                            <li><strong>Email Address</strong></li>
                                            <li>
                                            
                                            <input type="text" name="Email" size="30" class="input-text lgform" onKeyPress="if(event.keyCode==13) {return registration_judge_request_result('Contest Judge');}" />
                                            
                                            
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul class="login">
                                            <li><strong>Password</strong></li>
                                            <li>
                                            
                                            <input type="password" name="Password" size="30"  class="input-text lgform" onKeyPress="if(event.keyCode==13) {return registration_judge_request_result('Contest Judge');}"/>
                                            
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul class="login">
                                            <li><strong>Confirm Password</strong></li>
                                            <li>
                                            
                                            <input type="password" name="ConfirmPassword" size="30"  class="input-text lgform" onKeyPress="if(event.keyCode==13) {return registration_judge_request_result('Contest Judge');}"/>
                                            
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul class="login">
                                            <li><strong>Stage Name</strong></li>
                                            <li>
                                            
                                            <input type="text" name="First_Name" size="30" class="input-text lgform" onKeyPress="if(event.keyCode==13) {return registration_judge_request_result('Contest Judge');}" />
                                            
                                            </li>
                                        </ul>
                                    </li>
                                    
                                  
                                   
                                    <li>
                                        <ul class="login">
                                            <li><strong>Type the code shown</strong></li>
                                            <li>
                                            
                                            <input type="text" name="security_code" class="input-text lgform" id="security_code" size="30" onKeyPress="if(event.keyCode==13) {return registration_judge_request_result('Contest Judge');}">
                                            
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul class="login">
                                           
                                            <li><img src="php_captcha.php?hash=<?php echo $hash; ?>&width=130&height=37&characters=8" alt="captcha" name="captchaImage" id="captcha1"/></li>
                                        </ul>
                                    </li>
                                    
                                    
                                      <span class="colorlink1"><a href="javascript:void(0);"  id="captcha-refresh1"> <img src="images/refresh.png" width="31" align="absbottom" /> Refresh</a></span>
                                     
                                     <li>
                                      <div class="caption-2">&nbsp;</div>
                                      <p>&nbsp;</p>
                                       <p>&nbsp;</p>
                                      <div class="termsTxt">
                                 <label class="ignore">
                          <input name="terms" type="checkbox" value="1" /><span> By clicking Sign up free, you agree to Mussino.com <br /><a href="main-page.php?id=5" target="_blank">terms of service</a> and <a href="main-page.php?id=14" target="_blank">privacy policy</a>. </span>
                        </label>
                                       <br />
                                    
                                      </div>
                                      <div class="cl"></div>
                                      
                                    </li>
                                     
                                    <li>
                                        <ul class="login">
                                            <li>&nbsp;</li>
                                            <li><input class="button" name="buttonSubmit" type="button" value="Let me in NOW!" onClick="return registration_judge_request_result('Contest Judge');" onKeyPress="if(event.keyCode==13) {return registration_judge_request_result('Contest Judge');}"></li>
                                        </ul>
                                    </li>
                                </ul>
                            </form>
                                </div>
                                </div>
                                <!-- / Left -->
                                
                                <!-- Right -->
                                <div class="fl w150">
                               <!--<div class="pdf_Info">
                               <img src="images/pdf_icon.png" />
                               
                               <span><img src="images/smCheck.png" align="absbottom" class="pdfChecks"/>&nbsp;&nbsp;<a href="">How it works</a></span>
                               <br />
                               <span><img src="images/smCheck.png" align="absbottom" class="pdfChecks"/>&nbsp;&nbsp;<a href="">Sample Clearance</a></span>
                               <br />
                               <span><img src="images/smCheck.png" align="absbottom" class="pdfChecks"/>&nbsp;&nbsp;<a href="">Music Copyright</a></span>
                               <br /><br />
                              <span style=" color:#999;"> <strong>Note:</strong> You can also find this information in your control panel. </span>
                            
                              
                               </div>-->
                                </div>
                                <!--/ Right -->
                            </div>
                </div>
              </li>
            </ul>
            <?php } ?>
            <div class="cl"></div>
          </div>
        </div>
        <div class="player-rit-box fr">
          <?php /*?><div class="player-rit">
            <ul>
            <?php 
			$sql_jackpot = "SELECT * FROM royality  WHERE 1=1 ORDER BY rand() LIMIT 0, 4";
			$result_jackpot = mysql_query($sql_jackpot);
			if(mysql_num_rows($result_jackpot)>0)
			{
			while($colles_jackpot = mysql_fetch_array($result_jackpot))
			{
						
			
			$sqlAudioCount = "SELECT COUNT(*) AS CtotalAudio FROM lyrics_post_audio_master WHERE Member_Account_Id='".$colles_jackpot['Artist_Id']."' AND Lyrics_Audio_Type='AUDIO' AND Status=1";
			$resAudioCount = mysql_query($sqlAudioCount);
			$collesAudioCount = mysql_fetch_array($resAudioCount);
			$sqlVideoCount = "SELECT COUNT(*) AS CtotalVideo FROM lyrics_post_audio_master WHERE Member_Account_Id='".$colles_jackpot['Artist_Id']."' AND Lyrics_Audio_Type='VIDEO' AND Status=1";
			$resVideoCount = mysql_query($sqlVideoCount);
			$collesVideoCount = mysql_fetch_array($resVideoCount);
			$sqlTextCount = "SELECT COUNT(*) AS CtotalText FROM lyrics_post_master WHERE Member_Account_Id='".$colles_jackpot['Artist_Id']."' AND Status=1";
			$resTextCount = mysql_query($sqlTextCount);
			$collesTextCount = mysql_fetch_array($resTextCount);
			$totalPosts = $collesAudioCount['CtotalAudio'] + $collesVideoCount['CtotalVideo'] + $collesTextCount['CtotalText'];
			
			$img = Get_Single_Field("member_account_master","Photo","Member_Account_Id","$colles_jackpot[Artist_Id]");
			$postRoyal = Get_Single_Field("product_master","Royalties","Product_Id","$colles_jackpot[Product_Id]"); # made 07-13-2012
			$postPosts = Get_Single_Field("product_master","Posts","Product_Id","$colles_jackpot[Product_Id]"); # made 07-13-2012
			?>
              <li>
                <div class="img">
                <a href="<?=SITE_WS_PATH?>/<?=trim($colles_jackpot['Artist_Id'])?>/<?=ucfirst(stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_jackpot[Artist_Id]")))?>" >
				<?php if(file_exists("products/user_image/$colles_jackpot[Photo]") && $img!='') { ?>
                <img src="products/user_image/<?php echo $img; ?>" border="0" width="60" height="60"  />
                <?php } else { ?>
                <img src="images/user_big.png" border="0" width="60" height="60" />
                <?php } ?>
                </a>
                </div>
                <div class="info">
                  <h4><?=Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_jackpot[Artist_Id]").' '.Get_Single_Field("member_account_master","Last_Name","Member_Account_Id","$colles_jackpot[Artist_Id]")?></h4>
                  <p>Royalties: <span>$<? printf('%1.2f',$colles_jackpot['Artist_Amount']+$postRoyal);?></span></p> <!-- # made 07-13-2012 -->
                  <p>Posts: <span><?=$totalPosts+$postPosts?></span></p> <!-- # made 07-13-2012 -->
                </div>
                <div class="cl"></div>
              </li>
              <?php } } else { ?>
                <li style="padding: 80px 0 0 110px; font-weight: bold; font-size:16px; color:#47C0EA;">
					No Result
				</li>	
			<?php } ?>	
            </ul>
  </div><?php */?>
          <div class="cl"></div>
          
       
        <div class="mussinoBarCode">
        
        <a href="http://www.mussino.com/registration.php"><img src="images/contestbanner.jpg" width="300" /></a>
        <br /> <br /> 
           <a href="/registration.php"><img src="images/vimeoad.png" /></a>
           </div>
      
    
          
          <div class="cl"></div>
        </div>
        <div class="cl"></div>
        
        <div class="cor_1set-3"></div>
        <div class="cor_1set-4"></div>
      </div>