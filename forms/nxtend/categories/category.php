<?php //
require("../../../globals.php");
include CLASSES_PATH . '/' . 'class.NxtendFormElements.php';
//$form_name = substr(strrchr(getcwd(), '\/'), 1, strlen(strrchr(getcwd(), '\/')));
$form_name = 'nxtend';
$header_right_image = 'categories.png';
$form_elements = new FormElements($form_name);
include(INCLUDES_PATH . "/nxtend_header.php");
?>
<style type="text/css">
    
    .form_inputs { float:left }
    .main_image_container { padding: 10px 0px 40px 0px; }
    .main_image { width: 435px; padding:0px 0px 0px 25px;   }
    .lt_blue { color:#588aca }
    .front_page_input_text { float:left;padding-left:108px; }
    .front_page_row { margin-bottom:100px; }
    #container { height:120px; xborder:1px #000 solid; }
    #icon { xborder:1px solid #000; }
    #info_box { width: 850px; padding:0px 10px 10px 10px; text-align: center; }
    #button_container { margin:auto;width:620px; }
    #back_btn { text-align: right; padding-right:20px; }
    
</style>
    <div class="front_page_green_info_box_container" id="container">
        <div class="icon_info" id="icon"><img src="<?php echo IMAGES_URL ?>/nxtend/icon-info.png" width="26" height="26" alt="icon" /></div>
        <div class="front_page_green_info_box" id="info_box">
            <p> News Xtend offers a range of digital marketing solutions that make it easier for your business to enhance it's digital footprint and maximise your digital advertising return.
                Our job is to eliminate the guesswork and build customised local solutions that will deliver leads to your business. </p>
            <p><br />Please select from the below categories that best describes your business type to view relevant example.</p><br /><br />
            For any enquiries, please email <a href="mailTo:newsxtendcreative@news.com.au">newsxtendcreative@news.com.au</a><br /><br />
        </div>
    </div> 
    <?php 
        $categories["auto"]                     = array("foot_traffic","form_submissions","phone_calls");
        $categories["education"]                = array("brand_awareness","form_submissions","phone_calls");
        $categories["hospitality"]              = array("foot_traffic","phone_calls");
        $categories["online_sales"]             = array("online_sales");        
        $categories["premium"]                  = array("form_submissions_premium_competition","form_submissions_premium_shared_entry");
        $categories["professional_services"]    = array("form_submissions","phone_calls");
        $categories["real_estate"]              = array("foot_traffic","form_submissions","phone_calls");
        $categories["retail"]                   = array("brand_awareness","foot_traffic");
        $categories["standard"]                 = array("foot_traffic","form_submissions","phone_calls");
        $categories["targeted_website_traffic"] = array("targeted_website_traffic");
        ?>
        <div id="button_container">
            <?php
            foreach($categories[$_REQUEST['category']] as $sub_category) {
                ?>
                    <div class="divider"></div>    
                    <div><a href="bonsai.php?category=<?php echo $_REQUEST['category'] ?>&sub_category=<?php echo $sub_category ?>"><img src="<?php echo ROOT_URL ?>/assets/client/images/nxtend/categories/category/<?php echo $sub_category ?>.png" alt="" /></a></div>
                    <div class="divider"></div>
                <?php
            }
            ?>
        </div>
        <div>            
            <div id="back_btn"><a href="index.php"><img src="<?php echo ROOT_URL ?>/assets/client/images/nxtend/categories/back_btn.png" alt="" /></a></div>    
            <div class="divider"></div>
        </div>
<?php
include(INCLUDES_PATH . "/nxtend_footer.php");
?>