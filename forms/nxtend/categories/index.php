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
    
</style>
    <div class="front_page_green_info_box_container" id="container">
        <div class="icon_info" id="icon"><img src="<?php echo IMAGES_URL ?>/icon-info.png" width="26" height="26" alt="icon" /></div>
        <div class="front_page_green_info_box" id="info_box">
            <p> News Xtend offers a range of digital marketing solutions that make it easier for your business to enhance it's digital footprint and maximise your digital advertising return.
                Our job is to eliminate the guesswork and build customised local solutions that will deliver leads to your business. </p>
            <p><br />Please select from the below categories that best describes your business type to view relevant example.</p><br /><br />
            For any enquiries, please email <a href="mailTo:newsxtendcreative@news.com.au">newsxtendcreative@news.com.au</a><br /><br />
        </div>
    </div> 
    <div class="divider"></div>
    <div class="left_box"><a href="category.php?category=auto"><img src="<?php echo IMAGES_URL ?>/categories/auto.png" alt="Auto" /></a></div>
    <div class="right_box"><a href="category.php?category=education"><img src="<?php echo IMAGES_URL ?>/categories/education.png" alt="Education" /></a></div>
    <div class="divider"></div>
    <div class="left_box"><a href="category.php?category=hospitality"><img src="<?php echo IMAGES_URL ?>/categories/hospitality.png" alt="Hospitality" /></a></div>
    <div class="right_box"><a href="category.php?category=online_sales"><img src="<?php echo IMAGES_URL ?>/categories/online_sales.png" alt="Online Sales" /></a></div>
    <div class="divider"></div>
    <div class="left_box"><a href="category.php?category=premium"><img src="<?php echo IMAGES_URL ?>/categories/premium.png" alt="Premium" /></a></div>
    <div class="right_box"><a href="category.php?category=professional_services"><img src="<?php echo IMAGES_URL ?>/nxtend/categories/professional_services.png" alt="Professional Services" /></a></div>
    <div class="divider"></div>    
    <div class="left_box"><a href="category.php?category=real_estate"><img src="<?php echo IMAGES_URL ?>/categories/real_estate.png" alt="Real Estate" /></a></div>
    <div class="right_box"><a href="category.php?category=retail"><img src="<?php echo IMAGES_URL ?>/categories/retail.png" alt="Retail" /></a></div>
    <div class="divider"></div>    
    <div class="left_box"><a href="category.php?category=standard"><img src="<?php echo IMAGES_URL ?>/categories/standard.png" alt="Standard" /></a></div>
    <div class="right_box"><a href="category.php?category=targeted_website_traffic"><img src="<?php echo IMAGES_URL ?>/categories/targeted_website_traffic.png" alt="Targeted Website" /></a></div>
    <div class="divider"></div>    
<?php
include(INCLUDES_PATH . "/nxtend_footer.php");
?>