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
        <div class="icon_info" id="icon"><img src="<?php echo IMAGES_URL ?>/nxtend/icon-info.png" width="26" height="26" alt="icon" /></div>
        <div class="front_page_green_info_box" id="info_box">
            <p> News Xtend offers a range of digital marketing solutions that make it easier for your business to enhance it's digital footprint and maximise your digital advertising return.
                Our job is to eliminate the guesswork and build customised local solutions that will deliver leads to your business. </p>
            <p><br />Please select from the below categories that best describes your business type to view relevant example.</p><br /><br />
            For any enquiries, please email <a href="mailTo:newsxtendcreative@news.com.au">newsxtendcreative@news.com.au</a><br /><br />
        </div>
    </div> 
    <div class="divider" style="margin-top:10px;"></div>
    <div class="left_box"><a href="category.php?category=auto" class="button">Auto</a></div>
    <div class="right_box"><a href="category.php?category=education" class="button">Education</a></div>
    <div class="left_box"><a href="category.php?category=hospitality" class="button">Hospitality</a></div>
    <div class="right_box"><a href="category.php?category=online_sales" class="button">Online Sales</a></div>
    <div class="left_box"><a href="category.php?category=premium" class="button">Premium</a></div>
    <div class="right_box"><a href="category.php?category=professional_services" class="button">Professional Services</a></div>
    <div class="left_box"><a href="category.php?category=real_estate" class="button">Real Estate</a></div>
    <div class="right_box"><a href="category.php?category=retail" class="button">Retail</a></div>
    <div class="left_box"><a href="category.php?category=standard" class="button">Standard</a></div>
    <div class="right_box"><a href="category.php?category=targeted_website_traffic" class="button">Targeted Website Traffic</a></div>
    <div class="divider"></div>    
<?php
include(INCLUDES_PATH . "/nxtend_footer.php");
?>