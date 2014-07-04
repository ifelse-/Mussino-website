<div id="ja-mainnav" class="wrap">
  <div class="main">
    <div class="header-nav-container">
      <div class="header-nav">
        <h4 class="no-display">Category Navigation:</h4>
        <ul id="nav" class="clearfix">
          <li id="" class="nav-home first"> <a class="" href="index.php" title="Home"><span>Home</span></a> </li>
          <?php if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist' || $_SESSION['SESS_ACCOUNT_TYPE']=='Musician')	{ ?>
          <li id="" class="level0 nav-1 parent" onmouseover="toggleMenu(this,1)" onmouseout="toggleMenu(this,0)"> <a class="" href="product.php?fg=0"> <span>Post Rhymes</span> </a></li>
          
          
          <li id="" class="level0 nav-3"> <a class="" href="product.php?fg=1"> <span>Post Poetry</span> </a>  </li>
          <?php } else { ?>  
         <li id="" class="level0 nav-1 parent" onmouseover="toggleMenu(this,1)" onmouseout="toggleMenu(this,0)"> <a class="" href="login.php"> <span>Post Rhymes</span> </a></li>
                 
          <li id="" class="level0 nav-3"> <a class="" href="login.php"> <span>Post Poetry</span> </a>  </li>
         
         <?php } ?>
                <li id="" class="level0"> <a class="" href="#" title="Home"><span>Buy Unreleased Music</span></a> </li>
          <li id="" class="level0 last" onmouseout="toggleMenu(this,0)" onmouseover="toggleMenu(this,1)"> <a class="" href="#">
          
          <span>Register as a Contest Judge</span></a>
            <ul class="ja-usertools-color level0">
              <li id="" class="level1 hilite default"><a class="" href="#" style="cursor: pointer;" title="default color" id="ja-tool-defaultcolor" onclick="switchTool('jm_rasite_ja_color','default');return false;">Default&nbsp;Color</a></li>
              <li id="" class="level1 green"><a class="" href="#" style="cursor: pointer;" title="green color" id="ja-tool-greencolor" onclick="switchTool('jm_rasite_ja_color','green');return false;">Green&nbsp;Color</a></li>
              <li id="" class="level1 ocean"><a class="" href="#" style="cursor: pointer;" title="ocean color" id="ja-tool-oceancolor" onclick="switchTool('jm_rasite_ja_color','ocean');return false;">Ocean&nbsp;Color</a></li>
              <li id="" class="level1 orange"><a class="" href="#" style="cursor: pointer;" title="orange color" id="ja-tool-orangecolor" onclick="switchTool('jm_rasite_ja_color','orange');return false;">Orange&nbsp;Color</a></li>
              <li id="" class="level1 purple"><a class="" href="#" style="cursor: pointer;" title="purple color" id="ja-tool-purplecolor" onclick="switchTool('jm_rasite_ja_color','purple');return false;">Purple&nbsp;Color</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>