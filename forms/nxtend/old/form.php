<?php
session_start();
require("../../globals.php");
include CLASSES_PATH . '/' . 'class.NxtendFormElements.php';
//$form_name = substr(strrchr(getcwd(), '\/'), 1, strlen(strrchr(getcwd(), '\/')));
$form_name = 'nxtend';
$form_elements = new FormElements($form_name);
if(isset($_REQUEST['search_adnumber'])) {
    $_SESSION['is_ad_update'] = 1;
}
include(INCLUDES_PATH . "/nxtend_header.php");
?>
<style type="text/css">
    /*.gad-anim-swap-active { content:url(<?php echo IMAGES_URL ?>/nxtend/buttons/btn-animated-hover.png);cursor:pointer;}​
    .gad-anim-swap-hover { content:url(<?php echo IMAGES_URL ?>/nxtend/buttons/btn-animated-active.png);cursor:pointer;}*/
    .img_gad_animated_hover { content:url(<?php echo IMAGES_URL ?>/nxtend/buttons/btn-animated-active.png);cursor:pointer;}​
    .img_gad_animated_active { content:url(<?php echo IMAGES_URL ?>/nxtend/buttons/btn-animated-hover.png);cursor:pointer;}
    .img_gad_static_hover { content:url(<?php echo IMAGES_URL ?>/nxtend/buttons/btn-static-active.png);cursor:pointer;}​
    .img_gad_static_active { content:url(<?php echo IMAGES_URL ?>/nxtend/buttons/btn-static-hover.png);cursor:pointer;}
    
    
</style>
<script type="text/javascript">
    
    //** copies values to common inputs throughout the form
    function change_keyup_values(src_obj,array_name) {
	
        var txt_array = new Array();
        
        //** copies url from the booking details section to the elements listed
        if(array_name == 'url') {
            
            txt_array = ['gad_stat_url_txt',
                         'gad_anim_url_txt',
                         'as_mob_stat_url_txt',
                         'as_mob_anim_url_txt',
                         'as_mrec_stat_url_txt',
                         'as_mrec_anim_url_txt',
                         'as_leaderboard_stat_url_txt',
                         'as_leaderboard_anim_url_txt'
                         
                        ]
                        
        } else if(array_name == 'heading_intro_txt') {
            
            txt_array = ['as_mob_stat_heading_intro_txt',
                         'as_mrec_stat_heading_intro_txt',
                         'as_leaderboard_stat_heading_intro_txt'
                        ]           
                        
        //** copies text from the frame 1 in the general asset details section to the elements listed
        } else if(array_name == 'frm1_txt') {
            
            txt_array = ['as_mob_anim_frm1_txt',
                         'as_mrec_anim_frm1_txt',
                         'as_leaderboard_anim_frm1_txt'
                        ]           
        //** copies text from the frame 2 in the general asset details section to the elements listed    
        } else if(array_name == 'frm2_txt') {
            
            txt_array = ['as_mob_anim_frm2_txt',
                         'as_mrec_anim_frm2_txt',
                         'as_leaderboard_anim_frm2_txt'
                        ]           
        //** copies text from the frame 3 in the general asset details section to the elements listed    
        } else if(array_name == 'frm3_txt') {
                        
            txt_array = ['as_mob_anim_frm3_txt',
                         'as_mrec_anim_frm3_txt',
                         'as_leaderboard_anim_frm3_txt'
                        ]           
            
        } else if(array_name == 'add_comments') {
            
            txt_array = ['as_mob_stat_add_comm_ta',
                         'as_mob_anim_add_comm_ta',
                         'as_mrec_stat_add_comm_ta',
                         'as_mrec_anim_add_comm_ta',
                         'as_leaderboard_stat_add_comm_ta',
                         'as_leaderboard_anim_add_comm_ta'
                        ]           
            
        }
        
        
        for(var i = 0; i < txt_array.length; i++) {
            
            $("#" + txt_array[i]).val(src_obj.value);
            
        }	
    }
    
    //** set the various options when static or animated is selected in the General Asset Details section
    function show_gad_container(ad_type) {
        
        if(ad_type == 'animated') {
            
            var hide_ad_type = 'static';
            $('#gad_stat_anim').val('animated');
            
        } else {
            
            var hide_ad_type = 'animated';
            $('#gad_stat_anim').val('static');
        }
        
        $("#general_asset_details_" + hide_ad_type + "_container").hide();    
        $("#general_asset_details_" + ad_type + "_container").toggle();
        $("#general_asset_details_" + ad_type + "").attr("src","<?php echo IMAGES_URL ?>/nxtend/buttons/btn-" + ad_type + "-active.png");
        $("#general_asset_details_" + hide_ad_type + "").attr("src","<?php echo IMAGES_URL ?>/nxtend/buttons/btn-" + hide_ad_type + "-hover.png");
        
    }   
    
    //** ajax call to the server for duplication of options
    function myCall(action) {
            
            var count = $("#" + action + "_count").val();
            var id = "#" + action + "_count";
            count = (+count + 1);
            $(id).val(count);
            var $div = $("<div>", {id: id + "_" + count});
            $(id).append($div);
            
            var request = $.ajax({
                    url: "process.php",
                    data: {action: action, count:count },
                    type: "POST",			
                    dataType: "html"
            });

            request.done(function(msg) {
                    $("#" + action + "_attach_" + count).html(msg);
                    
            });

            request.fail(function(jqXHR, textStatus) {
                    //alert( "Request failed: " + textStatus );
            });
    }
    
    //** sets a hidden field to static or animated so that it can be picked up when the form is posted
    function rt_static_anim_id(id) {

        //** get the mrec type, static or animated from the gad hidden field
        var gad_type = $('#gad_stat_anim').val();

        if(gad_type == 'animated') {

            id = id + '_animated';


        } else { //** if nothing in the hidden field the default is static

            id = id + '_static';

        }
        return id;
    }
    
    function img_hover(img_obj, state) {
        
        img_obj.src = "<?php echo IMAGES_URL ?>/nxtend/buttons/btn-animated-"+ state + ".png";
        
    }
    
    function toggle_option_selected(is_obj, aImg_obj, hidden_field_id) {
        
        if(is_obj === '1') {
            
            var img_id = $('#' + aImg_obj.id);
            
        } else {
            
            var img_id = $('#' + aImg_obj);
            
        }
        
        //** get the image id, the name is used to access other variables
        var id = img_id.attr('id').substring(0,img_id.attr('id').lastIndexOf('_img'));
        
        //** bespoke doesn't have comminality with the general asset details section, so exclude it
        if(id.indexOf('bespoke') != -1) {
            
            //** set the bespoke containter id to open / close with the onclick event
            var container_id = id + '_container'; 

        //** landing page doesn't have comminality with the general asset details section, so exclude it
        } else if(id.indexOf('landing_page') != -1) {
            
            //** set the landing page containter id to open / close with the onclick event
            var container_id = id + '_container'; 

        } else {
            
            //** else need to find out whether its a static or animated option, call function rt_static_anim to determine
            var container_id = rt_static_anim_id(id) + '_container';
            
        }

        $('#' + container_id).toggle();
        
        var alt_src = img_id.data('alt-src'); 

        img_id.data('alt-src', img_id.attr('src'));
        img_id.attr('src', alt_src);
        
        if($('#' + hidden_field_id).val() == 0) {

            $('#' + hidden_field_id).val(aImg_obj.id); 
           
        } else {
            
            //** else set it to 0
            $('#' + hidden_field_id).val('0');  
           
        }
    } 
    
</script>
<!--<a href="<?php echo FORMS_URL  ?>/digital/index.php">JSON Files</a>-->
<form id="<?php echo $form_name ?>" name="<?php echo $form_name ?>" action="<?php echo ROOT_URL ?>/forms/process.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="form_name" id="form_name" value="<?php echo $form_name ?>" />
	<?php
	if (isset($_REQUEST["adnumber"])) {
            ?>
            <input type="hidden" name="adnumber" value="<?php echo $_REQUEST["adnumber"]; ?>" />
            <?php
        } else if(isset($_REQUEST["new_adnumber"])) {
            ?>
            <input type="hidden" name="adnumber" value="<?php echo $_REQUEST["new_adnumber"]; ?>" />
            <?php            
        }
	?>
            <?php 
            $form_elements->create_section_title("1.Booking Details","booking_details.png", "30px", "977", "59", "booking details");
            $form_elements->create_sub_title("Your Details");
            ?>
            <div class="inner_box" id="your_details_email_container">
                <div class="html_title">Email</div>
                <div><input type="text" name="your_details_email" id="your_details_email" value="" class="textBox"  /></div>
            </div>
            <div class="inner_box" id="your_details_first_name_container">
                <div class="html_title">First Name</div>
                <div><input type="text" name="your_details_first_name" id="your_details_first_name" value="" class="textBox"  /></div>
            </div>
            <div class="inner_box" id="your_details_last_name_container">
                <div class="html_title">Last Name</div>
                <div><input type="text" name="your_details_last_name" id="your_details_last_name" value="" class="textBox"  /></div>
            </div>
            <div class="inner_box" id="your_details_phone_container">
                <div class="html_title">Phone</div>
                <div><input type="text" name="your_details_phone" id="your_details_phone" value="" class="textBox"  /></div>
            </div>
            <div class="inner_box" id="your_details_state_container">
                <div class="html_title">State</div>
                <div>
                    <select name="your_details_state" id="your_details_state">
                        <option value=""> -- select -- </option>
                        <option value="NSW">NSW</option>
                        <option value="NT">NT</option>
                        <option value="QLD_Brisbane">QLD - Brisbane</option>
                        <option value="QLD_Cairns">QLD - Cairns</option>
                        <option value="QLD_Townsville">QLD - Townsville</option>
                        <option value="QLD_Gold_Coast">QLD - Gold Coast</option>
                        <option value="SA">SA</option>
                        <option value="TAS">TAS</option>
                        <option value="VIC_Geelong">VIC - Geelong</option>
                        <option value="VIC_Melbourne">VIC - Melbourne</option>
                        <option value="WA">WA</option>
                    </select>
                </div>
            </div>
            <?php
                $form_elements->create_sub_title("Job Details");
            ?>
            <div class="inner_box" id="job_details_business_name_container">
                <div class="html_title">Business name:</div>
                <div><input type="text" name="job_details_business_name" id="job_details_business_name" value="" class="textBox"  /></div>
            </div>
            <div class="inner_box" id="job_details_business_website_container">
                <div class="html_title">Business website:</div>
                <div><input type="text" name="job_details_business_website" onblur="change_keyup_values(this, 'url')" id="job_details_business_website" value="" class="textBox"  /></div>
            </div>
            <div class="inner_box" id="job_details_due_date_live_container">
                <div class="html_title">Due date - live:</div>
                <div><input type="text" name="job_details_due_date_live" id="job_details_due_date_live" onpaste="return false" value="" class="textBox"  /></div>
            </div>
            <!--<div class="inner_box" id="job_details_due_date_live_container">
                <div class="html_title">Due date - first proof:</div>
                <div><input type="text" name="job_details_due_date_proof" id="job_details_due_date_proof" value="" class="textBox"  /></div>
            </div>-->
            <div class="inner_box" id="job_details_order_number_container">
                <div class="html_title">Order number:</div>
                <?php 
                if(!isset($_REQUEST['adnumber'])) {
                ?>
                <div><input type="text" name="job_details_order_number" id="job_details_order_number" value="<?php echo $_REQUEST['new_adnumber'] ?>" disabled="disabled" class="textBox"  /></div>
                <?php 
                } else if(isset($_REQUEST['adnumber']) && $_REQUEST['adnumber'] !== '') {
                    if(substr($_REQUEST['adnumber'][0],0,1) != 'X') {
                        $_REQUEST['adnumber'] = "X" . $_REQUEST['adnumber'];    
                    }
                ?>
                <input type="hidden" name="job_details_order_number" id="job_details_order_number" value="<?php echo $_REQUEST['adnumber'] ?>" class="textBox"  />
                <div class="order_number"><?php echo $_REQUEST['adnumber'] ?></div>
                <?php
                } 
                ?>
            </div>
            <?php
            //*** general asset details section ***
            $form_elements->create_section_title("2.General Asset Details","general_assets.png", "60px", "977", "59", "general assets");
            ?>    
            <div class="general_asset_details_green_info_box_container">
                <div class="icon_info">
                    <img src="<?php echo IMAGES_URL ?>/nxtend/icon-info.png" width="26" height="26" alt="icon" />
                </div>
                <div class="general_asset_details_green_info_box">
                    Digital advertising should deliver a brief message with a call to action or a simple branding message.<br /><br />
                    The content you enter in this section will appear automatically across all assets.  If you need to alter content or add imagery for a specific asset, click 'EDIT' after selecting it in the next section.<br />
                    For any enquiries, please email <a href="mailTo:For any enquiries, please email newsxtendcreative@news.com.au">newsxtendcreative@news.com.au</a>
                </div>
            </div>    
            <?php
            //** clsss.NxtendFormElements
            $form_elements->create_sub_title("General Information");
            ?>
            <!--gad-anim-swap-active-->
            <div id="general_asset_details_button_container">
                <input type="hidden" name="gad_stat_anim[]" id="gad_stat_anim" value="" />
                <input type="hidden" name="as_stat_anim[]" id="as_stat_anim" value="" />
                <div class="html_title">All assets should be:</div>
                <div>
                    <div class="button_container"><img class="img_gad_static_active" id="general_asset_details_static" onclick="show_gad_container('static')" name="btn-static" src="<?php echo IMAGES_URL ?>/nxtend/buttons/btn-static-hover.png" width="226" height="40" alt=""/></div>
                    <div class="button_container"><img class="img_gad_animated_active" id="general_asset_details_animated" onclick="show_gad_container('animated')" name="btn-animated" src="<?php echo IMAGES_URL ?>/nxtend/buttons/btn-animated-inactive.png" width="226" height="40" alt="" /></div>
                </div>
            </div>
            <div id="general_asset_details_animated_text_container">
                <div id="general_asset_details_animated_text">Animated ads consist of 3 frames that run for 15 seconds max (30 secs looped). This also helps to keep file size under 40KB (as per specs).</div>
            </div>
            <br style="clear:both;" />
            <!-- ******************************** general asset details STATIC  ************************************ -->
            <!-- hide general assets section -->
            <div class="general_asset_details_section" id="general_asset_details_static_container">
                <!-- text / click-through url -->
                <div class="general_asset_details_static_text_box_container" id="general_asset_details_static_heading_intro_text_div">
                    <div>
                        <div class="text_box_title">Text:</div>
                        <div class="grey_text">Approx 6 words</div>
                    </div>
                    <div><input type="text" name="gad_stat_heading_intro_txt" onblur="change_keyup_values(this,'heading_intro_txt')" id="gad_stat_heading_intro_txt" value="" class="general_asset_details_static_text_box"  /></div>
                </div>
                <div class="general_asset_details_static_text_box_container" id="general_asset_details_static_click_through_url_text_div">
                    <div>
                        <div class="text_box_title">Click-through URL (optional):</div>
                        <div><input type="text" name="gad_stat_url_txt" id="gad_stat_url_txt" value="" class="general_asset_details_static_text_box" /></div>
                    </div>                                                                                                                               
                </div>
                <br style="clear:both;" />
                
                <!-- logo / additional files -->
                <div class="general_asset_details_static_text_box_container" id="general_asset_details_static_logo_text_div">
                    <div class="title_image_container">
                        <div class="text_box_title">Logo</div>
                        <div class="logo_image_container"><img src="<?php echo IMAGES_URL ?>/nxtend/icon-img-tooltip.png" width="18" height="18" title="tooltip" class="zip_files_tt" alt=""/></div>
                    </div>
                    <div><input type="file" name="gad_stat_logo_file" id="gad_stat_logo_file" value="No file chosen" class="general_asset_details_static_text_box"  /></div>
                </div>
                <div class="general_asset_details_static_text_box_container" id="general_asset_details_static_additional_files_text_div">
                    <div class="title_image_container">
                        <div class="text_box_title">Additional files (optional):</div>
                        <div class="logo_image_container"><img src="<?php echo IMAGES_URL ?>/nxtend/icon-img-tooltip.png" width="18" height="18" title="tooltip" alt="" class="zip_files_tt" /></div>
                    </div>
                    <div><input type="file" name="gad_stat_add_file" id="gad_stat_add_file" value="" class="general_asset_details_static_text_box" /></div>
                </div>
            </div>
            <!-- ******************************** general asset details ANIMATED  ************************************ -->
            <div class="general_asset_details_section" id="general_asset_details_animated_container" style="margin-top: 45px ;">
                <div class="general_asset_details_animated_inner_box" id="general_asset_details_animated_text_for_frame_1">
                    <div class="html_title">Text for frame 1:</div>
                    <div><input type="text" name="gad_anim_frm1_txt" id="gad_anim_frm1_txt" onblur="change_keyup_values(this,'frm1_txt')" value="" class="general_asset_details_animated_text_box"  /></div>
                </div>
                <div class="general_asset_details_animated_inner_box">
                    <div class="html_title">Text for frame 2:</div>
                    <div><input type="text" size="29" name="gad_anim_frm2_txt" id="gad_anim_frm2_txt" onblur="change_keyup_values(this,'frm2_txt')" value="" class="general_asset_details_animated_text_box"  /></div>
                </div>
                <div class="general_asset_details_animated_inner_box">
                    <div class="html_title">Text for frame 3:</div>
                    <div><input type="text" size="29" name="gad_anim_frm3_txt" id="gad_anim_frm3_txt" onblur="change_keyup_values(this,'frm3_txt')" value="" class="general_asset_details_animated_text_box"  /></div>
                </div>
                
                
                <div class="general_asset_details_animated_inner_box" style="margin-top: 20px">
                    <div class="html_title">Click-through URL (optional):</div>
                    <div><input type="text" name="gad_anim_url_txt" id="gad_anim_url_txt" xonkeyup="change_keyup_values('as_anim_url_txt', this)" class="general_asset_details_animated_text_box"  /></div>
                </div>
                <div class="general_asset_details_animated_inner_box" style="margin-top: 31px;">
                    <div class="title_image_container">
                        <div class="text_box_title">Logo</div>
                        <div class="logo_image_container"><img src="<?php echo IMAGES_URL ?>/nxtend/icon-img-tooltip.png" title="tooltip" class="zip_files_tt" width="18" height="18" alt=""/></div>
                    </div>
                    <div><input type="file" name="gad_anim_logo_file" id="gad_anim_logo_file" value=""  class="general_asset_details_animated_text_box" /></div>
                </div>
                <div class="general_asset_details_animated_inner_box" style="margin-top: 31px;">
                    <div class="title_image_container">
                        <div class="text_box_title">Additional Files</div>
                        <div class="logo_image_container"><img src="<?php echo IMAGES_URL ?>/nxtend/icon-img-tooltip.png" width="18" height="18" title="tooltip" class="zip_files_tt" alt=""/></div>
                    </div>
                    <div><input type="file" name="gad_anim_add_files" id="gad_anim_add_files" value=""  class="general_asset_details_animated_text_box" /></div>
                </div>
            </div>
            <!-- end hide general assets section -->
            <br style="clear: both" />
            <div class="general_asset_details_when_uploading_plea_container">
                <div class="icon_info">
                    <img src="<?php echo IMAGES_URL ?>/nxtend/icon-notification.png" width="26" height="26" alt="icon" />
                </div>
                <div class="general_asset_details_when_uploading_plea">
                    <strong>When uploading, please zip multiple files.</strong> Files can be supplied as layered PDFs, PSDs, AI or separate elements from this format. Please do not supply flattened JPG ad posters/flyers as we can not resize. If specific fonts are required, please supply.
                </div>
            </div>
            <br style="clear: both" />
            <div class="inner_box" id="general_asset_details_additional_comments_container">
                <div class="html_title">Additional comments (optional):</div>
                <div><textarea name="gad_add_comm_ta" onblur="change_keyup_values(this,'add_comments')" id="gad_add_comm_ta" class="gad_text_area"></textarea></div>
            </div>
            <div style="margin-top:140px;" xstyle="border: 1px solid #000">
            <?php 
            //** asset specifics header
            $form_elements->create_section_title("3.Asset Specifics", "hdr-asset-specifics.png", "30px", "977", "59", "booking details");
            ?>
            </div>
            <div style="margin: 50px 30px 30px 30px; width: 300px; font-family: Tahoma; font-size: 16px;">Please select requested assets</div>
            <?php 
            $form_elements->create_asset_specifics_option("Mobile banner","320 x 50px");
            ?>
            <!-- **************************** mobile banner static ***************************************** -->
            <input type="hidden" name="st_Mobile_Banner" id="st_Mobile_Banner" value="Mobile Banner" />
            <div id="asset_specifics_mobile_banner_static_container" class="asset_specifics_section_container">
                <div class="asset_specifics_green_info_box">
                    <div class="icon_info" style="padding-left:10px;">
                        <img src="<?php echo IMAGES_URL ?>/nxtend/icon-info.png" width="26" height="26" alt="icon" />
                    </div>
                    <div class="asset_specifics_inner_info_text">
                        Enter any text alterations or additional files for this asset only
                    </div>
                </div>
                <div class="asset_specifics_inner_box">
                    <div class="html_title">Text:</div>
                    <div><input type="text" name="as_mob_stat_heading_intro_txt" id="as_mob_stat_heading_intro_txt" value="" class="asset_specifics_input_text_half"  /></div>
                </div>
                <div class="asset_specifics_inner_box" xstyle="border:1px solid #000;">
                    <div class="html_title">Click-through URL (optional):</div>
                    <div><input type="text" size="45" name="as_mob_stat_url_txt" id="as_mob_stat_url_txt" value="" class="asset_specifics_input_text_half"  /></div>
                </div>
                <div class="asset_specifics_inner_box">
                    <div class="html_title">Logo:</div>
                    <div><input type="file" name="as_mob_stat_logo_file" id="as_mob_stat_logo_file" class="asset_specifics_input_text_half"  /></div>
                </div>
                <div class="asset_specifics_inner_box">
                    <div class="html_title">Additional files (optional):</div>
                    <div><input type="file" name="as_mob_stat_add_file" id="as_mob_stat_add_file" value="" class="asset_specifics_input_text_half"  /></div>
                </div>
                <div class="asset_specifics_additional_comments" id="asset_specifics_mrec_animated_additional_comments_textarea_div">
                    <div class="html_title">Additional comments:</div>
                    <div><textarea name="as_mob_stat_add_comm_ta" id="as_mob_stat_add_comm_ta" class="asset_specifics_text_area"></textarea></div>
                </div><br style="clear:both" />
                <?php 
                    if($_SESSION['is_ad_update']) {
                    ?>
                        <div class="asset_specifics_inner_box_third">
                            <div class="html_title">Proof URL:</div>
                            <div><input type="text" name="as_mob_stat_proof_url_txt" id="as_mob_stat_proof_url_txt" value="" class="asset_specifics_input_text_full" /></div>
                        </div><br style="clear:both" />
                    <?php 
                    }
                ?>
                <!--<div id="assets_specific_mrec_button_container">
                    <div class="button_container_full"><img src="<?php echo IMAGES_URL ?>/nxtend/buttons/btn-update-asset.png" width="304" height="40" alt="icon" id="asset_specifics_mrec_btn" /></div>
                </div>-->
            </div>
            <!-- **************************** mobile banner animated ***************************************** -->
            <div id="asset_specifics_mobile_banner_animated_container"  class="asset_specifics_section_container">
                <div class="asset_specifics_green_info_box">
                    <div class="icon_info" style="padding-left:10px;">
                        <img src="<?php echo IMAGES_URL ?>/nxtend/icon-info.png" width="26" height="26" alt="icon" />
                    </div>
                    <div class="asset_specifics_inner_info_text">
                        Enter any text alterations or additional files for this asset only
                    </div>
                </div>
                <div class="asset_specifics_inner_box_third">
                    <div class="html_title">Text for frame 1:</div>
                    <div><input type="text" name="as_mob_anim_frm1_txt" id="as_mob_anim_frm1_txt" value="" class="asset_specifics_mrec_animated_input_text_box" /></div>
                </div>
                <div class="asset_specifics_inner_box_third">
                    <div class="html_title">Text for frame 2:</div>
                    <div><input type="text" name="as_mob_anim_frm2_txt" id="as_mob_anim_frm2_txt" value="" class="asset_specifics_mrec_animated_input_text_box" /></div>
                </div>
                <div class="asset_specifics_inner_box_third">
                    <div class="html_title">Text for frame 3:</div>
                    <div><input type="text" name="as_mob_anim_frm3_txt" id="as_mob_anim_frm3_txt" value="" class="asset_specifics_mrec_animated_input_text_box" /></div>
                </div>
                <div class="asset_specifics_inner_box_third">
                    <div class="html_title">Click-through URL (optional):</div>
                    <div><input type="text" name="as_mob_anim_url_txt" id="as_mob_anim_url_txt" value="" class="asset_specifics_mrec_animated_input_text_box" /></div>
                </div>
                <div class="asset_specifics_inner_box_third">
                    <div class="html_title">Upload imagery:</div>
                    <div><input type="file" name="as_mob_img_file" id="as_mob_img_file" value="No file chosen" class="asset_specifics_mrec_animated_input_text_box" /></div>
                </div>
                <div class="asset_specifics_inner_box_third">
                    <div class="html_title">Additional files:</div>
                    <div><input type="file" name="as_mob_anim_add_file" id="as_mob_anim_add_filee" value="No file chosen" class="asset_specifics_animated_input_text_box" /></div>
                </div>
                <div class="asset_specifics_additional_comments" id="asset_specifics_mrec_animated_additional_comments_div">
                    <div class="html_title">Additional comments:</div>
                    <div><textarea name="as_mob_anim_add_comm_ta" id="as_mob_anim_add_comm_ta" class="asset_specifics_text_area"></textarea></div>
                </div><br style="clear:both" />
                <?php 
                if($_SESSION['is_ad_update']) {
                ?>
                    <div class="asset_specifics_inner_box_third">
                        <div class="html_title">Proof URL:</div>
                        <div><input type="text" name="as_mob_anim_proof_url_txt" id="as_mob_anim_proof_url_txt" value="" class="asset_specifics_input_text_full" /></div>
                    </div><br style="clear:both" />
                <?php 
                }
                ?>
                <!--<div id="assets_specific_mrec_button_container">
                    <div class="button_container_full"><img src="<?php echo IMAGES_URL ?>/nxtend/buttons/btn-update-asset.png" width="304" height="40" alt="icon" id="asset_specifics_mrec_btn" /></div>
                </div>-->
            </div>
            <div id="asset_specifics_mrec_static_clone_container">
                <?php
                $form_elements->create_asset_specifics_option("Medium Rectangle","300 x 250px");
                ?>
                <!-- **************************** mrec static ***************************************** -->
                <input type="hidden" name="st_MREC" id="st_MREC" value="Medium Rectangle" />
                <div class="asset_specifics_section_container" id="asset_specifics_mrec_static_container">
                    <div>
                        <div class="asset_specifics_green_info_box">
                            <div class="icon_info" style="padding-left:10px;">
                                <img src="<?php echo IMAGES_URL ?>/nxtend/icon-info.png" width="26" height="26" alt="icon" />
                            </div>
                            <div class="asset_specifics_inner_info_text">
                                Enter any text alterations or additional files for this asset only
                            </div>
                        </div>
                        <div class="asset_specifics_inner_box">
                            <div class="html_title">Text:</div>
                            <div><input type="text" name="as_mrec_stat_heading_intro_txt" id="as_mrec_stat_heading_intro_txt" value="" class="asset_specifics_input_text_half"  /></div>
                        </div>
                        <div class="asset_specifics_inner_box" xstyle="border:1px solid #000;">
                            <div class="html_title">Click-through URL (optional):</div>
                            <div><input type="text" size="45" name="as_mrec_stat_url_txt" id="as_mrec_stat_url_txt" value="" class="asset_specifics_input_text_half"  /></div>
                        </div>
                        <div class="asset_specifics_inner_box">
                            <div class="html_title">Logo:</div>
                            <div><input type="file" name="as_mrec_stat_logo_file" id="as_mrec_stat_logo_file" class="asset_specifics_input_text_half"  /></div>
                        </div>
                        <div class="asset_specifics_inner_box">
                            <div class="html_title">Additional files (optional):</div>
                            <div><input type="file" name="as_mrec_stat_add_file" id="as_mrec_stat_add_file" value="" class="asset_specifics_input_text_half"  /></div>
                        </div>
                        <div class="asset_specifics_additional_comments" id="asset_specifics_mrec_static_additional_comments_textarea_div">
                            <div class="html_title">Additional comments:</div>
                            <div><textarea name="as_mrec_stat_add_comm_ta" id="as_mrec_stat_add_comm_ta" class="asset_specifics_text_area"></textarea></div>
                        </div><br style="clear:both" />
                        <?php 
                            if($_SESSION['is_ad_update']) {
                            ?>
                                <div class="asset_specifics_inner_box_third">
                                    <div class="html_title">Proof URL:</div>
                                    <div><input type="text" name="as_mrec_stat_proof_url_txt" id="as_mrec_stat_proof_url_txt" value="" class="asset_specifics_input_text_full" /></div>
                                </div><br style="clear:both" />
                            <?php 
                            }
                        ?>
                        <!--<div id="assets_specific_mrec_button_container">
                            <div class="button_container_full"><img src="<?php echo IMAGES_URL ?>/nxtend/buttons/btn-update-asset.png" width="304" height="40" alt="icon" id="asset_specifics_mrec_btn" /></div>
                        </div>-->
                    </div>
                </div>
                <!--<div id="assets_specific_mrec_add_another_button_container">
                    <div class="add_another_button_container"><img id="assets_specific_mrec_add_another_button" src="<?php echo IMAGES_URL ?>/nxtend/buttons/btn-add-another-mrec.png" width="977" height="40" alt="icon" id="asset_specifics_mrec_add_another_btn" /></div>
                </div>-->
            </div>
            <!-- **************************** mrec animated ***************************************** -->
            <div class="asset_specifics_section_container" id="asset_specifics_mrec_animated_container">
                <div>
                    <div class="asset_specifics_green_info_box">
                        <div class="icon_info" style="padding-left:10px;">
                            <img src="<?php echo IMAGES_URL ?>/nxtend/icon-info.png" width="26" height="26" alt="icon" />
                        </div>
                        <div class="asset_specifics_inner_info_text">
                            Enter any text alterations or additional files for this asset only
                        </div>
                    </div>
                    <div class="asset_specifics_inner_box_third">
                        <div class="html_title">Text for frame 1:</div>
                        <div><input type="text" name="as_mrec_anim_frm1_txt" id="as_mrec_anim_frm1_txt" value="" class="asset_specifics_mrec_animated_input_text_box" /></div>
                    </div>
                    <div class="asset_specifics_inner_box_third">
                        <div class="html_title">Text for frame 2:</div>
                        <div><input type="text" name="as_mrec_anim_frm2_txt" id="as_mrec_anim_frm2_txt" value="" class="asset_specifics_mrec_animated_input_text_box" /></div>
                    </div>
                    <div class="asset_specifics_inner_box_third">
                        <div class="html_title">Text for frame 3:</div>
                        <div><input type="text" name="as_mrec_anim_frm3_txt" id="as_mrec_anim_frm3_txt" value="" class="asset_specifics_mrec_animated_input_text_box" /></div>
                    </div>
                    <div class="asset_specifics_inner_box_third">
                        <div class="html_title">Click-through URL (optional):</div>
                        <div><input type="text" name="as_mrec_anim_url_txt" id="as_mrec_anim_url_txt" value="" class="asset_specifics_mrec_animated_input_text_box" /></div>
                    </div>
                    <div class="asset_specifics_inner_box_third">
                        <div class="html_title">Upload imagery:</div>
                        <div><input type="file" name="as_mrec_anim_img_file" id="as_mrec_anim_img_file" value="No file chosen" class="asset_specifics_mrec_animated_input_text_box" /></div>
                    </div>
                    <div class="asset_specifics_inner_box_third">
                        <div class="html_title">Additional files:</div>
                        <div><input type="file" name="as_mrec_anim_add_file" id="as_mrec_anim_add_file" value="No file chosen" class="asset_specifics_animated_input_text_box" /></div>
                    </div>
                    <div class="asset_specifics_additional_comments" id="asset_specifics_mrec_animated_additional_comments_div">
                        <div class="html_title">Additional comments:</div>
                        <div><textarea name="as_mrec_anim_add_comm_ta" id="as_mrec_anim_add_comm_ta" class="asset_specifics_text_area"></textarea></div>
                    </div><br style="clear:both" />
                    <?php 
                    if($_SESSION['is_ad_update']) {
                    ?>
                        <div class="asset_specifics_inner_box_third">
                            <div class="html_title">Proof URL:</div>
                            <div><input type="text" name="as_mrec_anim_proof_url_txt" id="as_mrec_anim_proof_url_txt" value="" class="asset_specifics_input_text_full" /></div>
                        </div><br style="clear:both" />
                    <?php 
                    }
                    ?>
                </div>
            </div>
            <?php 
            $form_elements->create_asset_specifics_option("Leaderboard","728 x 90px");
            ?>
            <!-- **************************** leaderboard static ***************************************** -->
            <input type="hidden" name="st_Leaderboard" id="st_Leaderboard" value="Leaderboard" />
            <div class="asset_specifics_section_container" id="asset_specifics_leaderboard_static_container">
                <div id="as_leaderboard_static">
                    <div class="asset_specifics_green_info_box">
                        <div class="icon_info" style="padding-left:10px;">
                            <img src="<?php echo IMAGES_URL ?>/nxtend/icon-info.png" width="26" height="26" alt="icon" />
                        </div>
                        <div class="asset_specifics_inner_info_text">
                            Enter any text alterations or additional files for this asset only
                        </div>
                    </div>
                    <div class="asset_specifics_inner_box">
                        <div class="html_title">Text:</div>
                        <div><input type="text" name="as_leaderboard_stat_heading_intro_txt" id="as_leaderboard_stat_heading_intro_txt" value="" class="asset_specifics_input_text_half"  /></div>
                    </div>
                    <div class="asset_specifics_inner_box" xstyle="border:1px solid #000;">
                        <div class="html_title">Click-through URL (optional):</div>
                        <div><input type="text" size="45" name="as_leaderboard_stat_url_txt" id="as_leaderboard_stat_url_txt" value="" class="asset_specifics_input_text_half"  /></div>
                    </div>
                    <div class="asset_specifics_inner_box">
                        <div class="html_title">Logo:</div>
                        <div><input type="file" name="as_leaderboard_stat_logo_file" id="as_leaderboard_stat_logo_file" class="asset_specifics_input_text_half"  /></div>
                    </div>
                    <div class="asset_specifics_inner_box">
                        <div class="html_title">Additional files (optional):</div>
                        <div><input type="file" name="as_leaderboard_stat_add_file" id="as_leaderboard_stat_add_file" value="" class="asset_specifics_input_text_half"  /></div>
                    </div>
                    <div class="asset_specifics_additional_comments" id="as_leaderboard_add_div">
                        <div class="html_title">Additional comments:</div>
                        <div><textarea name="as_leaderboard_stat_add_comm_ta" id="as_leaderboard_stat_add_comm_ta" class="asset_specifics_text_area"></textarea></div>
                    </div><br style="clear:both" />
                    <?php 
                    if($_SESSION['is_ad_update']) {
                    ?>
                        <div class="asset_specifics_inner_box_third">
                            <div class="html_title">Proof URL:</div>
                            <div><input type="text" name="as_leaderboard_stat_proof_url_txt" id="as_leaderboard_stat_proof_url_txt" value="" class="asset_specifics_input_text_full" /></div>
                        </div><br style="clear:both" />
                    <?php 
                    }
                    ?>                    
                    <!--<div id="assets_specific_mrec_button_container">
                        <div class="button_container_full"><img src="<?php echo IMAGES_URL ?>/nxtend/buttons/btn-update-asset.png" width="304" height="40" alt="icon" id="asset_specifics_mrec_btn" /></div>
                    </div>-->
                </div>
            </div>
                <!-- **************************** leaderboard animated ***************************************** -->
            <div class="asset_specifics_section_container" id="asset_specifics_leaderboard_animated_container">
                <div id="as_leaderboard_anim">
                    <div class="asset_specifics_green_info_box">
                        <div class="icon_info" style="padding-left:10px;">
                            <img src="<?php echo IMAGES_URL ?>/nxtend/icon-info.png" width="26" height="26" alt="icon" />
                        </div>
                        <div class="asset_specifics_inner_info_text">
                            Enter any text alterations or additional files for this asset only
                        </div>
                    </div>
                    <div class="asset_specifics_inner_box_third">
                        <div class="html_title">Text for frame 1:</div>
                        <div><input type="text" name="as_leaderboard_anim_frm1_txt" id="as_leaderboard_anim_frm1_txt" value="" class="asset_specifics_mrec_animated_input_text_box" /></div>
                    </div>
                    <div class="asset_specifics_inner_box_third">
                        <div class="html_title">Text for frame 2:</div>
                        <div><input type="text" name="as_leaderboard_anim_frm2_txt" id="as_leaderboard_anim_frm2_txt" value="" class="asset_specifics_mrec_animated_input_text_box" /></div>
                    </div>
                    <div class="asset_specifics_inner_box_third">
                        <div class="html_title">Text for frame 3:</div>
                        <div><input type="text" name="as_leaderboard_anim_frm3_txt" id="as_leaderboard_anim_frm3_txt" value="" class="asset_specifics_mrec_animated_input_text_box" /></div>
                    </div>
                    <div class="asset_specifics_inner_box_third">
                        <div class="html_title">Click-through URL (optional):</div>
                        <div><input type="text" name="as_leaderboard_anim_url_txt" id="as_leaderboard_anim_url_txt" value="" class="asset_specifics_mrec_animated_input_text_box" /></div>
                    </div>
                    <div class="asset_specifics_inner_box_third">
                        <div class="html_title">Upload imagery:</div>
                        <div><input type="file" name="as_leaderboard_anim_img_file" id="as_leaderboard_anim_img_file" value="No file chosen" class="asset_specifics_mrec_animated_input_text_box" /></div>
                    </div>
                    <div class="asset_specifics_inner_box_third">
                        <div class="html_title">Additional files:</div>
                        <div><input type="file" name="as_leaderboard_anim_add_file" id="as_leaderboard_anim_add_file" value="No file chosen" class="asset_specifics_animated_input_text_box" /></div>
                    </div>
                    <div class="asset_specifics_additional_comments" id="asset_specifics_mrec_animated_additional_comments_div">
                        <div class="html_title">Additional comments:</div>
                        <div><textarea name="as_leaderboard_anim_add_comm_ta" id="as_leaderboard_anim_add_comm_ta" class="asset_specifics_text_area"></textarea></div>
                    </div><br style="clear:both" />
                    <?php 
                    if($_SESSION['is_ad_update']) {
                    ?>
                        <div class="asset_specifics_inner_box">
                            <div class="html_title">Proof URL:</div>
                            <div><input type="text" name="as_leaderboard_anim_proof_url_txt" id="as_leaderboard_anim_proof_url_txt" value="" class="asset_specifics_input_text_full" /></div>
                        </div><br style="clear:both" />
                    <?php 
                    }
                    ?>
                    <!--<div id="assets_specific_mrec_button_container">
                        <div class="button_container_full"><img src="<?php echo IMAGES_URL ?>/nxtend/buttons/btn-update-asset.png" width="304" height="40" alt="icon" id="asset_specifics_mrec_btn" /></div>
                    </div>-->
                </div>
            </div>
            <?php
            $form_elements->create_asset_specifics_option("Landing page");
            ?>
            <!-- **************************** landing page ***************************************** -->
            <input type="hidden" name="st_Landing_Page" id="st_Landing_Page" value="Landing Page" />
            <div class="asset_specifics_section_container" id="asset_specifics_landing_page_container">
                <div>
                    <div class="asset_specifics_green_info_box">
                         <div class="icon_info" style="padding-left:10px;">
                            <img src="<?php echo IMAGES_URL ?>/nxtend/icon-info.png" width="26" height="26" alt="icon" />
                        </div>
                        <div class="asset_specifics_inner_info_text">
                            Enter any text alterations or additional files for this asset only. 
                        </div>
                    </div>
                    <div class="inner_container">
                        <div class="asset_specifics_inner_box">
                            <div class="html_title">Select template:</div>
                            <div>
                                <select name="as_landing_page_select" id="as_landing_page_select" class="asset_specifics_select">
                                    <option value=""> Choose from options </option>
									<option value="Auto: Foot Traffic"> Auto: Foot Traffic </option>
                                    <option value="Auto: Form Submissions"> Auto: Form Submissions </option>
                                    <option value="Auto: Phone Calls"> Auto: Phone Calls </option>
                                    <option value="Education: Brand Awareness"> Education: Brand Awareness </option>
									<option value="Education: Form Submissions"> Education: Form Submissions </option>
                                    <option value="Education: Phone Calls"> Education: Phone Calls </option>
                                    <option value="Hospitality: Foot Traffic"> Hospitality: Foot Traffic </option>
                                    <option value="Hospitality: Phone Calls"> Hospitality: Phone Calls </option>
									<option value="Premium Generic: Click Form"> Premium Generic: Click Form </option>
                                    <option value="Standard Generic: Foot Traffic"> Standard Generic: Foot Traffic </option>
                                    <option value="Premium Generic: Share For Entry"> Premium Generic: Share For Entry </option>
                                    <option value="Professional Services: Form Submissions"> Professional Services: Form Submissions </option>
									<option value="Professional Services: Phone Calls"> Professional Services: Phone Calls </option>
                                    <option value="Real Estate: Foot Traffic"> Real Estate: Foot Traffic </option>
                                    <option value="Real Estate: Form Submissions"> Real Estate: Form Submissions </option>
                                    <option value="Real Estate: Phone Calls"> Real Estate: Phone Calls </option>
									<option value="Retail: Brand Awareness"> Retail: Brand Awareness </option>
                                    <option value="Retail: Foot Traffic"> Retail: Foot Traffic </option>
                                    <option value="Premium Generic: Form Submissions"> Premium Generic: Form Submissions </option>
                                    <option value="Standard Generic: Phone Calls"> Standard Generic: Phone Calls </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="asset_specifics_inner_box">
                        <div class="html_title">Logo:</div>
                        <div><input type="file" name="as_landing_page_logo_file" id="as_landing_page_logo_file" class="asset_specifics_input_text_half" /></div>
                    </div>
                   <!-- ** -->
                    <div class="asset_specifics_inner_box">
                        <div class="html_title">Headline:</div>
                        <div>
                             <div><input type="text" name="as_landing_page_heading_intro_txt" id="as_landing_page_heading_intro_txt" value="" class="asset_specifics_input_text_half"  /></div>
                        </div>
                        <!--<div style="float:left;border: 1px solid #000;width:400px;">x</div><br style="clear:both;" />-->
                    </div>
                    <div class="asset_specifics_inner_box" xstyle="border:1px solid #000;">
                        <div class="html_title">Google Analytics Tracking ID:</div>
                        <div><input type="text" size="45" name="as_landing_page_google_txt" id="as_landing_page_google_txt" value="" class="asset_specifics_input_text_half"  /></div>
                        <!--<div style="float:left;border: 1px solid #000;width:400px;">x</div><br style="clear:both;" />-->
                    </div>
                    <!-- ** -->
                    <!--<div class="asset_specifics_inner_box">
                        <div class="html_title">x</div>
                    </div>
                    <div class="asset_specifics_inner_box" xstyle="border:1px solid #000;">
                        <div class="html_title">x</div>
                    </div>-->
                    <!-- *** -->
                    <div class="asset_specifics_inner_box">
                        <div class="html_title">Body Copy - Subheading/Services:</div>
                        <div><textarea id="as_landing_page_description_ta" name="as_landing_page_description_ta" class="asset_specifics_landing_page_text_area"></textarea></div>
                    </div>
                    <div class="asset_specifics_inner_box" xstyle="border:1px solid #000;">
                        <div class="html_title">Tags - Pixel Tracking:</div>
                        <div><textarea id="as_landing_page_services_ta" name="as_landing_page_services_ta" class="asset_specifics_landing_page_text_area"></textarea></div>
                    </div>
                    <div class="asset_specifics_inner_box">
                        <div class="html_title">Address:</div>
                        <div><input type="text" name="as_landing_page_address_txt" id="as_landing_page_address_txt" value="" class="asset_specifics_input_text_half"  /></div>
                    </div>
                    <div class="asset_specifics_inner_box">
                        <div class="html_title">Phone:</div>
                        <div><input type="text" size="45" name="as_landing_page_phone_txt" id="as_landing_page_phone_txt" value="" class="asset_specifics_input_text_half"  /></div>
                    </div>
                   <div class="asset_specifics_inner_box_third">
                        <div class="html_title">Contact email:</div>
                        <div><input type="text" name="as_landing_page_email_txt" id="as_landing_page_email_txt" value="" class="asset_specifics_input_text_third"  /></div>
                    </div>
                    <div class="asset_specifics_inner_box_third">
                        <div class="html_title">Upload imagery:</div>
                        <div><input type="file" name="as_landing_page_img_file" id="as_landing_page_img_file" value="" class="asset_specifics_file_upload_third" /></div>
                    </div>
                    <div class="asset_specifics_inner_box_third">
                        <div class="html_title">Additional files:</div>
                        <div><input type="file" name="as_landing_page_add_file" id="as_landing_page_add_file" value="" class="asset_specifics_file_upload_third"  /></div>
                    </div><br />
                    <div class="asset_specifics_inner_box" id="">
                        <div class="html_title">Additional comments:</div>
                        <div><textarea name="as_landing_page_add_comm_ta" id="as_landing_page_add_comm_ta" class="asset_specifics_text_area"></textarea></div>
                    </div><br style="clear:both" />
                    <?php 
                    if($_SESSION['is_ad_update']) {
                    ?>
                        <div class="asset_specifics_inner_box">
                            <div class="html_title">Proof URL:</div>
                            <div><input type="text" name="as_landing_page_proof_url_txt" id="as_landing_page_proof_url_txt" value="" class="asset_specifics_input_text_full" /></div>
                        </div><br style="clear:both" />
                    <?php 
                    }
                    ?>                    
                    <!--<div id="assets_specific_mrec_button_container">
                        <div class="button_container_full"><img src="<?php echo IMAGES_URL ?>/nxtend/buttons/btn-update-asset.png" width="304" height="40" alt="icon" id="asset_specifics_mrec_btn" /></div>
                    </div>-->
                </div>
            </div>
            <?php
            $form_elements->create_asset_specifics_option("Bespoke");
            ?>
            <!-- **************************** bespoke ***************************************** -->
            <!--<div class="asset_specifics_option_container" id="asset_specifics_bespoke_banner">
                <div class="asset_specifics_option_heading_bg_grey">
                    <div class="asset_specifics_tick_img_container">
                        <img class="assets_specifics_tick_img" onclick="toggle_option_selected(this,'repop_bespoke')" id="asset_specifics_bespoke_img" src="<?php echo IMAGES_URL ?>/nxtend/select-asset-unticked.png" data-alt-src="<?php echo IMAGES_URL ?>/nxtend/select-asset-ticked.png" width="24" height="24" alt=""/>
                    </div>
                    <div class="asset_specifics_option_heading" id="asset_specifics_bespoke_title">
                        <span id="assets_specifics_mrec_html_title">Bespoke</span>
                        <span style="color:#9b9b9b;font-size: 14px"></span>
                    </div>
                </div>
                <input type="hidden" name="repop_bespoke_hidden" id="repop_bespoke_hidden" value="0" />
            </div>-->
            <input type="hidden" name="st_Bespoke" id="st_Bespoke" value="Bespoke" />
            <div class="asset_specifics_section_container" id="asset_specifics_bespoke_container">
                <div>
                    <div class="asset_specifics_green_info_box" style="padding:8px 8px 20px 8px;">
                        <div class="icon_info" style="padding-left:10px;">
                            <img src="<?php echo IMAGES_URL ?>/nxtend/icon-info.png" width="26" height="26" alt="icon" />
                        </div>
                        <div>
                            You will need to call up to arrange bespoke assets, please select bespoke ad units required and leave any additional comments that may be of use.  Or contact via newsxtendcreative.com.au to arrange. 
                        </div>
                    </div>
                    <div class="inner_container">
                        <div class="asset_specifics_inner_box" style="width:100px;">
                            <div class="html_title">Select bespoke ad unit:</div>
                            <div>
                                <select name="as_bespoke_select" id="as_bespoke_select" class="asset_specifics_select">
                                    <option value=""> Choose from options </option>
                                    <option value="Skyscraper"> Skyscraper </option>
                                    <option value="Half page"> Half page </option>
                                    <option value="Cube execution"> Cube execution </option>
                                    <option value="Other?"> Other? </option>
                                </select>
                            </div>
                        </div>
                    </div><br />
                    <div class="asset_specifics_inner_box" id="asset_specifics_bespoke_additional_comments_div">
                        <div class="html_title">Additional comments:</div>
                        <div><textarea name="as_bespoke_add_comm_ta" id="as_bespoke_anim_add_comm_ta" class="asset_specifics_text_area"></textarea></div>
                    </div><br style="clear:both" />
                    <?php 
                    if($_SESSION['is_ad_update']) {
                    ?>
                        <div class="asset_specifics_inner_box">
                            <div class="html_title">Proof URL:</div>
                            <div><input type="text" name="as_bespoke_proof_url_txt" id="as_bespoke_proof_url_txt" value="" class="asset_specifics_input_text_full" /></div>
                        </div><br style="clear:both" />
                    <?php 
                    }
                    ?> 
                    <!--<div id="assets_specific_mrec_button_container">
                        <div class="button_container_full"><img src="<?php echo IMAGES_URL ?>/nxtend/buttons/btn-update-asset.png" width="304" height="40" alt="icon" id="asset_specifics_mrec_btn" /></div>
                    </div>-->
                </div>
            </div>
            <div id="bespoke_attach_1"></div>
            <div id="bespoke_attach_2"></div>
            <div id="bespoke_attach_3"></div>
            <div id="bespoke_attach_4"></div>
            <div id="bespoke_attach_5"></div>
            <div id="bespoke_attach_6"></div>
            <div class="asset_specifics_button_container">
                <div class="asset_specifics_button_cancel"><img src="<?php echo IMAGES_URL ?>/nxtend/buttons/btn-cancel-request.png" data-alt-src="<?php echo IMAGES_URL ?>/nxtend/buttons/btn-cancel-request-hover.png" id="image_form_reset_button" alt=""/></div>
                <div class="asset_specifics_button_request"><img src="<?php echo IMAGES_URL ?>/nxtend/buttons/btn-request-job.png" data-alt-src="<?php echo IMAGES_URL ?>/nxtend/buttons/btn-request-job-hover.png" alt="" id="image_form_submit_button"/></div>
            </div>
            <input type="hidden" name="bespoke_count"    id="bespoke_count" value="0" />
            <!-- these hidden fields hold the utm values -->
            <input type="hidden" name="gad_utm_stat"         id="gad_utm_stat" value="" />
            <input type="hidden" name="gad_utm_anim"         id="gad_utm_anim" value="" />
            <input type="hidden" name="gad_mob_stat"         id="gad_mob_stat" value="" />
            <input type="hidden" name="gad_mob_anim"         id="gad_mob_anim" value="" />
            <input type="hidden" name="mrec_utm_stat"        id="mrec_utm_stat" value="" />
            <input type="hidden" name="mrec_utm_anim"        id="mrec_utm_anim" value="" />
            <input type="hidden" name="mob_utm_stat"         id="mob_utm_stat" value="" />
            <input type="hidden" name="mob_utm_anim"         id="mob_utm_anim" value="" />
            <input type="hidden" name="leaderboard_utm_stat" id="leaderboard_utm_stat" value="" />
            <input type="hidden" name="leaderboard_utm_anim" id="leaderboard_utm_anim" value="" />
            <input type="hidden" name="asset_specifics_option[]" id="utm_as_mrec_anim_url" value="1" />
            <script type="text/javascript">

            $(document).ready(function() { 
                
                var position = $('#asset_specifics_landing_page_container').offset()
                console.log(position.top)
                console.log(position.left)
                
                $('#test').css({
                    position: "", 
                    marginTop: -200,                    
                    marginLeft: position.left,                    
                    top: position.top,
                    left: position.left
                }).appendTo('body');
                
                img_swap_click("animated");
                img_swap_click("static");

                $( "#image_form_reset_button" ).click(function() { document.getElementById('nxtend').reset(); })
		
                $('.general_asset_details_section').hide();
                $('.asset_specifics_section_container').hide();
                
                $( "#assets_specific_mrec_add_another_button" )
                    
                    //** change the cursor to a hand when img is moused over.
                    .mouseover(function() {

                        $(this).css('cursor','pointer');

                    })
               
                   //** if its a new adnumber show the static container in general asset details
                   <?php
                    if(isset($_REQUEST['new_adnumber'])) {
                    ?>
                        show_gad_container('static');
                        //$('#general_asset_details_static_container').show();
                    <?php
                    }
                    ?>
                
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
                
                function set_utm_hidden_fields(aUrl, aUtm_type) {
                    
                    var utm_str = $('#' + aUrl).val() + "/?utm_source=xtend&utm_medium=" + aUtm_type + "&utm_campaign=News%20Australia";
                    
                    return utm_str;
                    
                }       
                
                $( ".clone_button" )

                    //** change the cursor to a hand when img is moused over.
                    .mouseover(function() {

                        $(this).css('cursor','pointer');
                        
                })
                
                $( "#image_form_submit_button" )

                    //** change the cursor to a hand when img is moused over.
                    .mouseover(function() {

                        $(this).css('cursor','pointer');
                        
                    })

                    .click(function() {
                        
                        var url_array = [
                            ['gad_stat_url_txt',            'gad_utm_stat',        'display'],
                            ['gad_anim_url_txt',            'gad_utm_anim',        'display'],
                            ['as_mob_stat_url_txt',         'mob_utm_stat',        'mobile'],
                            ['as_mob_anim_url_txt',         'mob_utm_anim',        'mobile'],
                            ['as_mrec_stat_url_txt',        'mrec_utm_stat',       'display'],
                            ['as_mrec_anim_url_txt',        'mrec_utm_anim',       'display'],
                            ['as_leaderboard_stat_url_txt', 'leaderboard_utm_stat','display'],
                            ['as_leaderboard_anim_url_txt', 'leaderboard_utm_anim','display']
                        ];
                        
                        for(var i = 0; i < url_array.length; i++) {
                            
                            var form_field_id = url_array[i][0];
                            var utm_field_id  = url_array[i][1];
                            var utm_type      = url_array[i][2]
                            
                            var form_field = document.getElementById(form_field_id);
                            
                            //** adds the utm value from the hidden field if the field is not empty
                            if(form_field.value != '') {
                                
                                var utm_str = set_utm_hidden_fields(form_field_id, utm_type);
                                var utm_field = document.getElementById( utm_field_id )
                                
                                utm_field.value = utm_str;
                                
                            }
                        }
                        
                        $('#nxtend').submit();

                    })    
					
					
					
                //** date picker
                $(function() {

                    var pickerOpts = {
                            dateFormat: "dd/mm/yy"

                    }
                    $('#job_details_due_date_live').datepicker(pickerOpts);
                    $('#job_details_due_date_proof').datepicker(pickerOpts);
                        
                });
                
                $('.zip_files_tt').tooltip({
                    content: "Please zip multiple files",
                    track : true
                });
                
                $('#<?php echo $form_name ?>').validate({ // initialize the plugin

                    rules: {
                        your_details_email: {
                            required: true,
                            email: false
                        },
                        your_details_first_name: {
                            required: true,
                            email: false
                        },
                        your_details_last_name: {
                            required: true,
                            minlength: 2
                        },
                        your_details_phone: {
                            required: true,
                            number: true
                        },
                        your_details_state: {
                            required: true
                        },                        
                        job_details_business_website: {
                            required: false,
                            url: true
                        },
                        job_details_due_date_live: {
                            required: true,
                            email: false
                        },
                        /*job_details_due_date_proof: {
                            required: true,
                            email: false
                        },*/
                        //category_radio[]repop_landing_page
                        //as_landing_page_heading_intro_txt
                        //as_landing_page_select : {
                            
                          //      required : $('#repop_landing_page').val() != '',//"#print:checked";
                                
                        //}
                        /*'the_job_digital_checkbox[]': {
                            
                                required: "#digital:checked"
                            }, */
                    }
                });
                
                function isCheckbox (element) {
                    return element instanceof HTMLInputElement && element.getAttribute('type') == 'checkbox'
                }
                
                //** populates input fields from the json file generated when the booking was submitted
                function populate(frm, data) {
                    
                    //** loop through input fields in the form
                    $.each(data, function(key, value) {  
                        
                        var $ctrl = $('[name='+key+']', frm);
                        
                        if ($.isArray(value)) {
                            
                            for (i = 0; i < value.length; i++) {
                                
                                if(value[i].indexOf('asset_specifics') != -1) {
                                    
                                    var asset_specifics_id = value[i].substring(0, value[i].lastIndexOf('_'))
                                    
                                    //** sets the tick images that have been previously selected
                                    $('#' + asset_specifics_id + '_img').attr('src',sourceSwap);
                                    
                                } else if(key == 'gad_stat_anim') {
                                    
                                    show_gad_container(value);
                                    
                                }   
                            } 
                        } 
                        
                        if(key.indexOf('repop') != -1 && value !== '0') {
                            
                            toggle_option_selected('0',value, value)
                            
                        }

                        switch($ctrl.attr("type")) {  
                                case "text" :   
                                case "hidden":  
                                        $ctrl.val(value);
                                        break;   
                                case "radio" : 
                                case "checkbox" :   
                                        $ctrl.each(function() {
                                        if($(this).attr('value') == value) {  $(this).attr("checked",value); } });   
                                        break;  
                                default:
                                        $ctrl.val(value); 

                        }  
                    });  
                }

            <?php
            if (isset($_REQUEST["adnumber"])) {
                ?>
                populate("#<?php echo $form_name ?>",json);
                <?php
            }
            ?>
            
        });//** end isready
		
	</script>
</form>
<?php
include(INCLUDES_PATH . "/nxtend_footer.php");
?>