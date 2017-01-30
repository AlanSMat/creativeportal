<?php
session_start();
require("../../globals.php");

include(INCLUDES_PATH . "/nxtend_header.php");
?>
<div style="height:600px;padding-top: 40px">
<style type="text/css">
    .proof { margin:auto; }
    .line_spacing { padding: 3px 0px 3px 0px; }
    .red { color:red; }
</style>

<?php 
//** function get_img_title_array() is located in assets->server->handlers->utils.php
$img_titles = get_img_title_array();
isset($_SESSION['proof_url_list']['as_landing_page_proof_url_txt']) && $_SESSION['proof_url_list']['as_landing_page_proof_url_txt'] != '' ? $landing_page_exists = 1 : $landing_page_exists = 0;

/*set_error_handler(function($errno, $errstr, $errfile, $errline, array $errcontext) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }

    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});*/

set_error_handler("warning_handler", E_WARNING);

function warning_handler($errno, $errstr) { 
    //echo 'error';
}

function urlExists($url=NULL) {
        if($url == NULL) return false;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $data = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch); 
        if($httpcode>=200 && $httpcode<300){
                return true;
        } else {
                return false;
        }
}

if(isset($_SESSION['proof_url_list']) && count($_SESSION['proof_url_list']) != 0) {
    foreach($_SESSION['proof_url_list'] as $input_element_name => $url) {        
        if(!strpos($input_element_name,'landing_page') && check_if_url_exists($url)) {
            if(!getimagesize($url)) {
                ?>
                <div style="padding:0px 0px 10px 30px;">
                    <!--<div class="line_spacing, red">Error: the following <u><?php echo $img_titles[$input_element_name]?></u> url is incorrect or the image does not exist</div>
                    <div class="line_spacing"><?php echo $img_titles[$input_element_name]?></div>
                    <div class="line_spacing"><?php echo $url ?></div>
                    <div class="line_spacing"><a href="form.php?adnumber=<?php echo substr($_REQUEST['adnumber'],1) ?>">Click here</a> to correct the link</div>-->
                    <div class="line_spacing"><b><?php echo $img_titles[$input_element_name]?></b></div>
                    <div class="line_spacing"><?php echo $url ?></div>
                    <div class="line_spacing"><a href="<?php echo $url ?>" target="_blank">Click here</a> to view the <?php echo $img_titles[$input_element_name]?> graphic</div>
                </div>
                <?php
            } else {
                $img_size   = getimagesize($url);
                $img_width  = $img_size[0];
                $img_height = $img_size[1];
            ?>
                <div style="width:<?php echo $img_width ?>px;margin:auto;">
                    <div><b><?php echo $img_titles[$input_element_name]?></b></div>
                    <?php $landing_page_exists == 1 ? print "<a href='" . $_SESSION['proof_url_list']['as_landing_page_proof_url_txt'] . "' target='_blank'>" : print ''; ?><div class="proof"><img src="<?php echo $url ?>" width="<?php echo $img_width ?>" height="<?php echo $img_height ?>" border="0" alt=""/><?php $landing_page_exists == 1 ? print '</a>' : print '' ;?></div>
                </div><br style="clear:both" />
            <?php 
            }
        }
    }
    
    if($landing_page_exists) {
    ?>
        <div style="padding:10px 0px 20px 20px;"><a href="<?php echo $_SESSION['proof_url_list']['as_landing_page_proof_url_txt'] ?>" target="_blank">Click here to view Landing Page</a></div>
    <?php
    }
} else {
    header("LOCATION: thank_you.php");
}

/*$browser = new COM("InternetExplorer.Application");
$handle = $browser->HWND;
$browser->Visible = true;
$browser->Navigate("http://studio.bonzai.ad/app/p.htm?4b4e5390");

while ($browser->Busy) {
    com_message_pump(4000);
}
$im = imagegrabwindow($handle, 0);
$browser->Quit();
imagepng($im, "iesnap.png");
imagedestroy($im);*/

//phpinfo();

/*
$browser = new COM("InternetExplorer.Application");
$handle = $browser->HWND;
$browser->Visible = true;
$browser->Navigate("http://www.libgd.org");
*/
/* Still working? */
/*while ($browser->Busy) {
    com_message_pump(4000);
}
$im = imagegrabwindow($handle, 0);
$browser->Quit();
imagepng($im, "iesnap.png");*/
//imagedestroy($im);

/*
$Browser = new COM('InternetExplorer.Application');
$Browserhandle = $Browser->HWND;
$Browser->Visible = true;
$Browser->Fullscreen = true;
$Browser->Navigate('http://www.stackoverflow.com');

while($Browser->Busy){
  com_message_pump(4000);
}

$img = imagegrabwindow($Browserhandle, 0);
$Browser->Quit();
imagepng($img, 'screenshot.png');
*/
//unset($_SESSION['proof_url_list']);
?>
</div>
<?php
include(INCLUDES_PATH . "/nxtend_footer.php");
?>