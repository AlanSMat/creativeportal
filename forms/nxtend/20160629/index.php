<?php
require("../../globals.php");
include CLASSES_PATH . '/' . 'class.NxtendFormElements.php';
//$form_name = substr(strrchr(getcwd(), '\/'), 1, strlen(strrchr(getcwd(), '\/')));
$form_name = 'nxtend';
$form_elements = new FormElements($form_name);
include(INCLUDES_PATH . "/nxtend_header.php");
?>
<style type="text/css">
    
    .form_inputs { float:left }
    .main_image_container { padding: 120px 0px 40px 0px; }
    .main_image { width: 435px; padding:0px 0px 0px 25px;   }
    .lt_blue { color:#588aca }
    .front_page_input_text { float:left;padding-left:108px; }
	.front_page_row { margin-bottom:100px; }
    
</style>
<!--<a href="<?php echo FORMS_URL  ?>/digital/index.php">JSON Files</a>-->
<form id="front_page" name="front_page" action="<?php echo ROOT_URL ?>/forms/nxtend/lookup.php" method="post" enctype="multipart/form-data">
    <div class="main_image_container">
        <div class="front_page_row">
            <div class="main_image">
                <div style="float:left;">
                        <img src="<?php echo IMAGES_URL ?>/nxtend/img-order-no.png" width="395" height="332" alt=""/>
                </div>
            </div>
            <div class="front_page_input_text">
                <div><img src="<?php echo IMAGES_URL ?>/nxtend/txt-welcome.png" width="222" height="47" alt=""/></div><br />
                <div class="order_number_text">Please enter your order number</div>
                <div> 
                        <div style="padding-top:61px;font-family:Tahoma;font-size:16px;margin-bottom:5px;">Order Number</div>
                        <div><input type="text" name="adnumber" id="adnumber" value="" style="width:310px;" class="textBox"  /></div>
                        <div style="padding-top:27px;"><img src="<?php echo IMAGES_URL ?>/nxtend/buttons/btn-find-job.png" data-alt-src="<?php echo IMAGES_URL ?>/nxtend/buttons/btn-find-job-hover.png" width="316" height="40" id="image_form_submit_button" alt=""/></div>
                </div>
            </div><br style="clear:both" />
        </div>
        <div class="general_asset_details_green_info_box_container">
            <div class="icon_info">
                    <img src="<?php echo IMAGES_URL ?>/nxtend/icon-info.png" width="26" height="26" alt="icon" />
            </div>
            <div class="general_asset_details_green_info_box">
                    Digital advertising should deliver a brief message with a call to action or a simple branding message.<br /><br />
                    The content you enter in this section will appear automatically across all assets.  If you need to alter content or add imagery for a specific asset, click 'EDIT' after selecting it in the next section.
            </div>
        </div>
	   
    </div>
    <script type="text/javascript">
        
        //img_over("#image_form_submit_button","btn-find-job-hover.png","btn-find-job.png");
        
        $( "#image_form_submit_button" )
            
            .click(function() {

                $('#front_page').submit();

            })      
        
        //** swaps the image out and back for the tick images as well as the buttons in the General Asset Details Section
        var sourceSwap = function () {

            var $this = $(this);

            var newSource = $this.data('alt-src');    

            $this.data('alt-src', $this.attr('src'));
            $this.attr('src', newSource);
        }

        $(function() {

            $('img[data-alt-src]').each(function() { 

                new Image().src = $(this).data('alt-src'); 
               $(this).css('cursor','pointer');

            }).hover(sourceSwap, sourceSwap); 

        });
        
    </script>
	
</form>
<?php
include(INCLUDES_PATH . "/nxtend_footer.php");
?>