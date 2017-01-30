<?php //
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
                        <div><input type="text" name="adnumber" maxlength="8" id="adnumber" value="" style="width:310px;" class="textBox"  /></div>
                        <div style="padding-top:27px;">
                            <img src="<?php echo IMAGES_URL ?>/nxtend/buttons/btn-find-job.png" data-alt-src="<?php echo IMAGES_URL ?>/nxtend/buttons/btn-find-job-hover.png" width="316" height="40" id="image_form_submit_button" alt=""/>
                            <span style="padding:0px 0px 50px 5px;"><a href="search.php" id="xsearch"><img src="<?php echo IMAGES_URL ?>/nxtend/search-icon.gif" width="20" height="27" id="search"></a></span>
                        </div>
                        
                </div>
            </div><br style="clear:both" />
        </div>
        <div class="front_page_green_info_box_container">
            <div class="icon_info">
                    <img src="<?php echo IMAGES_URL ?>/nxtend/icon-info.png" width="26" height="26" alt="icon" />
            </div>
            <div class="front_page_green_info_box">
                    Digital advertising should deliver a brief message with a call to action or a simple branding message.<br /><br />
                    The content you enter in this section will appear automatically across all assets.  If you need to alter content or add imagery for a specific asset, click 'EDIT' after selecting it in the next section.<br /><br />
                    Ad Point Booking ID is a 6-digit number that is made up of all numbers. 
                    If you do not have an Ad Point Booking ID please leave this space blank!
                    For more than one campaign under the same Ad point number please include a Capital Letter straight after the 6-digit number ie 999999A, 999999B. There must be no spaces in the number and there must be no special characters e.g. 9999 9A and 999(9)9A are not valid numbers.<br /><br />
                    For any enquiries, please email <a href="mailTo:newsxtendcreative@news.com.au">newsxtendcreative@news.com.au</a>
            </div>
        </div>
    </div>
    <?php 
    /*function loop_thru_files($folder = "json") {
        
        $dir = new DirectoryIterator(DOC_ROOT . "/forms/nxtend/" . $folder . "");
        $date = new DateTime();
        
        foreach ($dir as $fileinfo) {

            if (!$fileinfo->isDot()) {

                
                $file_name = substr($fileinfo->getFilename(), 0, strrpos($fileinfo->getFilename(),'.'));
                echo $file_name;

            }
        }   
        
    }*/
    
    ?>    
    
    <script type="text/javascript">
        
        function previous_booking() {
            
            previous_booking[0] = 'TestBooking';
            
        }
        
        $('#search').click(function(){
            window.open('search.php', 'Search');
            return false;
          });
        
        function is_num(str) {
            
            if(str.length > 1) {
				var valid_num = true
                for (var i = 0; i < str.length; i++) {
                    if(isNaN(str[i]) || str[i] == ' '){						
			valid_num = false;
                        break;
					}
                }
                return valid_num
            } else {
                if(isNaN(str)) {
                    return false;
                } else {
                    return true;
                }
            }
        }
	
        function is_postfix_valid(str){
            return !/[~`!#$%()\'\^&*+=\-\[\]\\';,/{}|\\":<>\?]/g.test(str);
        }
        
        function check_valid_number(adnumber) {
            
            var adnumber_length = adnumber.length;
            var prefix = adnumber.substring(0,1);
            var postfix = adnumber.substring((adnumber_length - 1));
            var body = adnumber.substring(1,(adnumber_length - 1))
            var prefix_ok = false;
            var postfix_ok = false;
            var body_ok = false;
			
            if(is_num(prefix) || prefix == "X") {
                prefix_ok = true;
            } else {
                alert("The first character of the Order Number \"" + prefix + "\" must be a number or an X");
            }

            if(is_num(body)) {
                body_ok = true;
            } else {
                alert("Other than the first and last characters, the Order Number must only contain numbers and there must be no spaces.");
            }	
			
			//alert(postfix);
			
            if(is_num(postfix) || is_postfix_valid(postfix)) {
                postfix_ok = true;
            } else {
                alert("The last character of the Order Number \"" + postfix + "\" must be a number or an a letter");
            }
            
            /*if(adnumber_length !== 8) {
                alert("The Order Number must contain 8 characters");
                return false
            }*/
            
            if(prefix_ok == true && body_ok == true && postfix_ok == true) {
                return true;
            }
			
            return false;
        }
        
        $( "#image_form_submit_button" )
            
            .click(function() {
                
                if( check_valid_number($("#adnumber").val()) == true ) {
		
                    $('#front_page').submit();
        
                }
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