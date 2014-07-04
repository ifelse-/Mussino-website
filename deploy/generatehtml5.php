<?php

function readXml($xmlFeed, $type) {
    $i = 0;
    if ($type == 'xml') {
    $xml = simplexml_load_file($xmlFeed);
    }
    $fout = '';
    $tw = ($xml->settings->totalWidth) - 275;
    $th = ($xml->settings->totalHeight);
    $fout.='<div class="videogallery-con" style="width:' . $tw . 'px; height:' . $th . 'px;"><div class="preloader"></div>
';
    $fout.='<div id="vg1" class="videogallery" style="width:' . $tw . 'px; height:' . $th . 'px;">
';
    foreach ($xml->children() as $child) {
        if ($child->getName() == 'item') {
            if ($child->type != 'video' && $child->type != 'youtube'){
                continue;
            }
            $fout.='<div class="vplayer-tobe" ';
            if($child->title!=''){
                $fout.='data-videoTitle="'.$child->title.'" ';
            }
            $fout.=' data-description="';
            if($child->thumb!=''){
                $fout.='<img src='.$child->thumb.' class=\'imgblock\'/>';
            }else{
                if ($child->type == 'youtube') {
                    $fout.='{ytthumb}';
                }
            }
            if($child->title!=''){
                $fout.='<div class=\'the-title\'>'.$child->title.'</div>';
            }
            if($child->menuDescription!=''){
                $fout.=''.$child->menuDescription.'';
            }
            $fout.='" ';
            if ($child->type == 'video') {
                $fout.='data-sourcemp4="'.$child->source.'" ';
                if($child->html5sourceogg!=''){
                     $fout.='data-sourceogg="'.$child->html5sourceogg.'" ';
                }
            }
            if ($child->type == 'youtube') {
                $fout.='data-type="youtube" ';
                $fout.='data-src="'.$child->source.'" ';
            }
            $fout.='>';
            if($child->description!=''){
                $fout.='<div class="videoDescription">'.$child->description.'</div>';
            }
            $fout.='</div>
';
        }
    }
    $fout.='
</div>';
    $fout.='
</div>';
    $fout.='
<script>
var videoplayersettings = {
autoplay : "off",
videoWidth : 500,
videoHeight : 300,
constrols_out_opacity : 0.9,
constrols_normal_opacity : 0.9,
design_scrubbarWidth:-201
}
jQuery(document).ready(function(){
if (jQuery.browser.safari && document.readyState != "complete"){
setTimeout( arguments.callee, 120 );
return;
}
$("#vg1").vGallery({
menuSpace:0,
randomise:"off",
autoplay :"off",
autoplayNext : "on",
menuitem_width:275,
menuitem_height:76,
menuitem_space:1,
menu_position:"right",
transition_type:"slideup",
design_skin: "skin_default",
videoplayersettings : videoplayersettings
})	
})
</script>';
    echo $fout;
}
//readXml('xml/gallery.xml', 'xml');