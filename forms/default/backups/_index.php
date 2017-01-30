<?php
require("../../globals.php");
include(INCLUDES_PATH . "/site_header.php");

?>
<!--<a href="<?php echo FORMS_URL  ?>/digital/index.php">JSON Files</a>-->
<form id="<?php echo $form_name ?>" name="<?php echo $form_name ?>" action="<?php echo ROOT_URL ?>/forms/process.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="form_name" id="form_name" value="<?php echo $form_name ?>" />
        <style type="text/css">
            .advertising_department{ width: 700px; margin: auto; }
            .button { border:1px solid #000; font-size:14px; cursor:pointer; clear:both; padding: 5px 0px 5px 0px; width:180px; }
            .button:hover { border:1px solid #000; font-size:14px; cursor:pointer; clear:both; background-color:#fff; padding: 5px 0px 5px 0px; width:180px; }
            .digital_elements{ width: 700px; margin: auto; }
            .element_spacing { padding:0px 0px 10px 0px; }
            .first_lvl_section { width: 700px;margin: auto;}
            .footer_text { clear: both; padding: 10px 0px 10px 0px }
            form input[type=text] { padding: 5px 0px 4px 3px; }
            form input[type=select] { padding: 5px 0px 4px 3px; }
            .grey_bg { xbackground-color: #f0f0f0; }
            hr { border-color: #0082DA ; }
            .hr_spacing { padding: 0px 0px 10px 0px; }
            .html_title { padding:10px 0px 4px 0px; xborder: 1px solid #000 }
            .inner_container { border:0px solid #000; width:700px; margin: auto; background:rgba(255,255,255,0.5);}
            .inner_box { padding:3px 0px 10px 0px; display: inline-block; border: 0px solid #000; position: relative; margin: 1%; width:49%;  float:left; margin:0; background:#7f7f7f; background:rgba(255,255,255,0.5); } 
            .marketing_department{ width:700px; margin:auto; }
            .outer_container { border:0px solid #000; width:700px; margin: auto}     
            .print_elements { width: 700px; margin: auto; }
            .second_lvl_section {}
            .section_title { padding: 10px 0px 0px 0px; font-size: 16px }
            .sub_title { padding: 10px 0px 0px 0px; font-size: 18px; }
            /* sub title spacing */
            .sub_title_container { clear: both; padding: 10px 0px 0px 0px }
            .third_lvl_section {}
        </style>
     
        <div class="first_lvl_section" id="brief_submission_container">
           
           <div class="your_details">
           <?php
           if (isset($_REQUEST["adnumber"])) { //** its an update
           ?>
               <input type="hidden" name="date_updated" value="<?php echo date("d/m/y H:i:s") ?>" />
               <input type="hidden" name="adnumber" value="<?php echo $_REQUEST["adnumber"]; ?>" />
               <?php
               if(isset($_REQUEST["adnumber"])) {
               ?>
                   <input type="hidden" name="booking_updated" value="1" />
               <?php
               }
               ?>
               <input type="hidden" name="date_entered" value="" />
               <div style="padding-top: 10px"><b>Job Number: </b><?php echo $_REQUEST['adnumber'] ?></div>
           <?php 
           } else {
           ?>    
               <input type="hidden" name="date_entered" value="<?php echo date("d/m/y H:i:s") ?>" />
           <?php 
           }
           //** Brief Submission
           $form_elements->create_sub_title("Your Details");
           $form_elements->create_element("first_name");
           $form_elements->create_element("last_name");
           $form_elements->create_element("phone");
           $form_elements->create_element("email");
           $form_elements->create_element("state");
            ?>
            </div>
        </div>
        <div class="first_lvl_section" id="category_container">
            <div class="category">
            <?php
            //** Category section
            $form_elements->create_sub_title("Category");
            $form_elements->create_element("category_radio");           
            ?>
            </div>
        </div>
        <div class="marketing_department">
            <?php
            $form_elements->create_sub_title("Marketing Department");
            $form_elements->create_element("category_marketing_radio");
            ?>
            <br style="clear : both" />
            <?php
            $form_elements->create_element("category_marketing_textarea");   
            
            //** Type section
            $form_elements->create_sub_title("Campaign Division");
            $form_elements->create_element("category_marketing_campaign_division_radio");    
            ?>
        </div>
        <div class="advertising_department">
             <?php
            $form_elements->create_sub_title("Advertising Department");
            $form_elements->create_element("category_advertising_checkbox");
            //$form_elements->create_element("category_advertising_checkbox");
            ?>
            <br style="clear : both" />    
            <?php
            $form_elements->create_element("category_advertising_textarea");   
            
            //** Category sectioncategory_advertising_the_advertiser
            $form_elements->create_sub_title("Client Details");
            $form_elements->create_element("category_advertising_the_advertiser_advertiser_name_text");
            $form_elements->create_element("category_advertising_the_advertiser_opportunity_name_text");           
            $form_elements->create_element("category_advertising_the_advertiser_product_service_text");
            $form_elements->create_element("category_advertising_the_advertiser_website_text");
            ?>
                <div>
                <?php
                $form_elements->create_element("category_advertising_the_advertiser_is_this_a_checkbox");
                ?>
                </div><br style="clear:both" />
            <?php
            $form_elements->create_element("category_advertising_the_advertiser_ad_campaign_value_text");
            $form_elements->create_element("category_advertising_the_advertiser_potential_text");
            ?>
        </div>
        <div class="first_lvl_section" id="the_job_container">
            <?php
            //** Project Details section
            $form_elements->create_sub_title("The Job");
            $form_elements->create_element("the_job_project_name_text");
            $form_elements->create_element("the_job_radio");        
            $form_elements->create_element("the_job_is_live_job");
            ?>
            <div class="first_lvl_section" id="proof_date_container">
            <?php
            $form_elements->create_element("proof_date");
            ?>
            </div>
            <?php 
            $form_elements->create_element("due_date");
            ?>
        </div>
        <div class="print_elements" id="the_job_print_container">            
        <?php
        //** Print section
        $form_elements->create_sub_title("Print");
        $form_elements->create_element("the_job_print_radio");
        ?>        
        <br style="clear:both" />
        <?php
        $form_elements->create_element("the_job_print_publication_textarea");           
        $form_elements->create_element("the_job_print_bleed_radio");
        ?>
        </div>
        <div class="print_elements" id="the_job_print_ad_sizes_container">
        <?php
        $form_elements->create_sub_title("Ad Sizes");
        $form_elements->create_element("the_job_print_ad_sizes_checkbox");            
         ?>
        </div>
        <div class="print_elements" id="the_job_print_flyer_container">
        <?php
        //** Print flyer section
        $form_elements->create_sub_title("Flyer");            
        $form_elements->create_element("the_job_print_flyer_width_text");    
        $form_elements->create_element("the_job_print_flyer_depth_text"); 
        ?>
        </div>
        <div class="print_elements" id="the_job_print_pos_container">
        <?php
        //** Print POS section
        $form_elements->create_sub_title("POS");            
        $form_elements->create_element("the_job_print_pos_checkbox");    
         ?>
        </div>
        <div class="print_elements" id="the_job_print_presentation_container">
        <?php
        //$form_elements->create_element("print_presentation");
        ?>
        </div>
        <div class="print_elements" id="the_job_print_project_container">
        <?php
        //$form_elements->create_element("the_job_print_ad_sizes_xx");
        ?>
        </div>
        <div class="digital_elements">
            <?php
            //** Digital section
            $form_elements->create_sub_title("Digital");       
            $form_elements->create_element("the_job_digital_mobile_desktop_radio");
            ?>
            <div class="digital_element_category_container" id="the_job_digital_mobile_checkbox_container">
            <?php 
            $form_elements->create_element("the_job_digital_mobile_checkbox");
            ?>
            </div> 
            <div class="digital_element_category_container" id="the_job_digital_desktop_checkbox_container">
            <?php 
            $form_elements->create_element("the_job_digital_desktop_checkbox");
            ?>
            </div> 
            <div class="digital_element_category_container" id="the_job_digital_desktop_and_mobile_checkbox_container">
            <?php
            $form_elements->create_element("the_job_digital_desktop_and_mobile_checkbox");
            ?>
            </div>          
            <br style="clear:both" />
            <div class="digital_element_category" id="the_job_digital_campaign_booking_details_container">
                <div><b>Campaign Booking Details</b></div>
                <div>Please note: Live digital bookings require a PDF copy of the IO booking before building will commence</div>
            </div>
            <?php
            //$form_elements->create_element("the_job_digital_textarea");           
            ?>
        </div>
        <div class="first_lvl_section" id="creative_details_container">                
        <?php 
        $form_elements->create_sub_title("Creative Details");
        ?>
        </div>
        <div class="first_lvl_section">                
            <div id="type_of_request_container">
            <?php 
            $form_elements->create_element("type_of_request");
            ?>
            </div>
        <?php
        $form_elements->create_element("whats_required");    
        ?>
        </div>
        <div class="first_lvl_section" id="file_upload_container">                
        <?php
        $form_elements->create_sub_title("File Upload");            
        $form_elements->create_element("file_upload");
        ?>
        </div>
        <div class="first_lvl_section" id="network Location">                
            <div style="clear:both;width:400px;">Please zip all files together named with the job number and client name / project name and upload to the relevant drive</div>
        </div>
        <div class="first_lvl_section" id="brief_submission_container">
            <p class='footer_text'><b>QLD</b></p><br style="clear:both" />
            <p>T:Drive ('QNPtransfer01')</p>

            <p class='footer_text'><b>NSW</b></p><br style="clear:both" />
            <p>\\nwnshsfs02a\Transfer\To_Creative</p>

            <p class='footer_text'><b>VIC</b></p><br style="clear:both" />
            <p>\\ldrhpfs4\All Users\NEWS AUSTRALIA VIC SHARE\Premedia Creative.</p>
            <p class='footer_text'><b>SA</b></p><br style="clear:both" />
            <p>\\advadlgraphic\Graphics Transfers\PreMedia Transfer</p>
            <p class='footer_text'><br />Note: Access to the the relevant drives is gained via IT</p>
        </div>
        <div class="first_lvl_section" id="submit_button_container">     
        <input type="hidden" name="is_live_job_selected" id="is_live_job_selected" value="0" />
        <?php
        $form_elements->create_sub_title("");            
        $form_elements->create_element("submit");
        ?>                
        </div>
	<script type="text/javascript">

            $(document).ready(function() {
                
                hide_all();
                
                $('#due_date').bind("cut copy paste",function(e) {
                    e.preventDefault();
                });
                
                $('#proof_date').bind("cut copy paste",function(e) {
                    e.preventDefault();
                });
                
                //binds to onchange event of your input field
                $('#file_upload').bind('change', function() {
                    
                    if(this.files[0].size > 15098019) {
                        $('#file_upload_error_msg').show();
                        $('#file_upload').val('');
                    } else {
                        $('#file_upload_error_msg').hide();
                    }
                });
            });

            function hide_all() {
                
                $('.marketing_department').hide();
                $('.advertising_department').hide();
                $('.digital_elements').hide();
                $("#the_job_print_container").hide();
                $("#the_job_print_ad_sizes_container").hide();
                $("#the_job_print_flyer_container").hide();
                $("#the_job_print_pos_container").hide();
                $("#the_job_digital_container").hide();
                $(".digital_element_category_container").hide();
                $("#proof_date_container").hide();
                $("#the_job_digital_campaign_booking_details_container").hide();
                $("#the_job_digital_mobile_checkbox_container").hide();
                $("#the_job_digital_desktop_checkbox_container").hide();
                $("#the_job_digital_desktop_and_mobile_checkbox_container").hide();
            }
            
            //** div id and checkbox id passed
            function hide_show_container(container_id, element_id) {
                
                $( element_id ).attr('click', function() {
                    
                    if($( element_id ).prop( "checked" ) == true) {
                        
                        console.log(element_id);
                        
                        if((container_id.indexOf('the_job_print') != -1) || (element_id.indexOf('the_job_print') != -1)) {
                            $( '.print_elements' ).hide();
                            clear_inputs('print');
                            $( '#the_job_print_container' ).show();
                        }
                        
                        if((container_id.indexOf('the_job_digital') != -1) || (element_id.indexOf('the_job_digital') != -1)) {
                            
                            $( '.digital_element_category_container' ).hide();
                            //clear_inputs('digital');
                            
                        }                        
                        
                        $( container_id ).show();
                        
                    } else {
                        
                        $( container_id ).hide();
                        clear_inputs('print');
                        
                    }
                    
                });
                
            }
            
            function clear_inputs(str_search) {
                
                //** loop through all inputs with the textBox class (all elements have the textBox class)
                //** clear any previously selected elements
                $('#<?php echo $form_name ?> :input').each(function(i, obj) {
                    
                    var element_name = this.name.toLowerCase();
                    
                    
                    /*if(str_search == 'the_job_digital_mobile_desktop_radio') {
                        console.log(str_search);
                    }*/
                    
                    //console.log(element_name.indexOf(str_search));
                    
                    if(element_name.indexOf(str_search) >= 0) {
                        
                        switch(this.type) {

                            case 'checkbox' :

                                $("input[name*='" + element_name + "']").prop('checked',false);

                                break;

                           case 'text' :
                           case 'select' :
                           case 'textarea' :

                               $("input[name*='" + element_name + "']").val('');

                                break;

                        }
                    }
                });
            }
            
            //** TODO: need to find a better way to do hide show.
            function show_container(container_id) {
                
                switch(container_id) {

                    case "#category_marketing_container" :
                        
                        //$('.element_spacing').show();
                        $('.marketing_department').show();
                        $('.advertising_department').hide();
                        $('#type_of_request_container').hide();
                        
                        //** this sets a hidden field so that it can be picked up later on by the php code and set as a header.
                        $('#st_Marketing_Department').val('1');
                        $('#st_Campaign_Division').val('1');
                        $('#st_Advertising_Department').val('0');
                        $('#st_Client_Details').val('0');
                        
                        clear_inputs('advertising');
                        
                        break;

                    case "#category_advertising_container" :
                        
                        $('.marketing_department').hide();
                        $('.advertising_department').show();
                        $('#type_of_request_container').show();
                        
                        //** this sets a hidden field so that it can be picked up later on by the php code and set as a header.
                        $('#st_Advertising_Department').val('1');
                        $('#st_Client_Details').val('1');
                        $('#st_Marketing_Department').val('0');
                        $('#st_Campaign_Division').val('0');
                        
                        clear_inputs('marketing');
                        
                        break;

                    case "print_only" :
                        
                        $("#the_job_print_container").show();
                        $(".digital_elements").hide();
                        $("#the_job_digital_container").hide();
                        
                        $('#st_The_Job').val('print');
                        $('#st_Print').val('1');
                        $('#st_Digital').val('0');
                        
                        clear_inputs('digital');
                        
                        break;
                            
                    case "digital_only" :
                        
                        $(".print_elements").hide();
                        $(".digital_elements").show();
                        $("input[name='the_job_print_ad_sizes_container[]']:checkbox").prop('checked',false);
                        
                        $('#st_The_Job').val('digital');
                        $('#st_Digital').val('1');
                        $('#st_Print').val('0');
                        
                        clear_inputs('print');
                        
                        break;
                        
                    case "print_and_digital" :
                        
                        $("#the_job_print_container").show();
                        $(".digital_elements").show();
                        $('#st_Digital').val('1');
                        $('#st_Print').val('0');
                        
                        $('#st_The_Job').val('print_and_digital');
                        
                        clear_inputs('print');
                        clear_inputs('digital');
                        
                        break;
                    
                     case "#the_job_is_live_job" :
                        
                        $('#proof_date_container').show();
                        //$("#the_job_digital_campaign_booking_details_container").show();
                        
                        $('#is_live_job_selected').val('1');
                        
                        break;                   
                    
                     case "#the_job_digital_campaign_booking_details_container" :
                        
                        $("#the_job_digital_campaign_booking_details_container").show();
                        //$("#the_job_digital_campaign_booking_details_container").show();
                        
                        $('#is_live_job_selected').val('1');
                        
                        break;                       
                    
                     case "#the_job_digital_mobile_checkbox_container" :
                        
                        $("#the_job_digital_desktop_checkbox_container").hide();
                        $("#the_job_digital_desktop_and_mobile_checkbox_container").hide();
                        $("#the_job_digital_campaign_booking_details_container").hide();
                        $("#the_job_digital_mobile_checkbox_container").show();
                        
                        clear_inputs('the_job_digital_desktop_checkbox');
                        clear_inputs('the_job_digital_desktop_and_mobile_checkbox');
                        
                        break;                     

                     case "#the_job_digital_desktop_checkbox_container" :
                        $("#the_job_digital_mobile_checkbox_container").hide();
                        $("#the_job_digital_desktop_and_mobile_checkbox_container").hide();                        
                        $("#the_job_digital_campaign_booking_details_container").hide();
                        $("#the_job_digital_desktop_checkbox_container").show();
                        
                        clear_inputs('the_job_digital_mobile_checkbox');
                        clear_inputs('the_job_digital_desktop_and_mobile_checkbox');
                        
                        break;  

                     case "#the_job_digital_desktop_and_mobile_checkbox_container" :
                        
                        $("#the_job_digital_mobile_checkbox_container").hide();
                        $("#the_job_digital_desktop_checkbox_container").hide();
                        $("#the_job_digital_campaign_booking_details_container").hide();
                        $("#the_job_digital_desktop_and_mobile_checkbox_container").show();
                        
                        clear_inputs('the_job_digital_mobile_checkbox');
                        clear_inputs('the_job_digital_desktop_checkbox');
                                                
                        break;  

                    default :
                        
                        $(container_id).show();

               }
       
            }
            
            /*function hide_container(container_id) {
                
                switch(container_id) {
                    
                    case "#the_job_is_live_job" :
                        
                        $('#is_live_job_selected').val('0');
                        $('#proof_date_container').hide();
                        $('#the_job_digital_campaign_booking_details_container').hide();
                        
                        break;
                    
                    default : 
                        
                        $(container_id).hide();
                    
                }
            }*/
            
            //** date picker
            $(function() {

                    var pickerOpts = {
                            dateFormat: "dd/mm/yy",
                            minDate: 0

                    }
                    
                    $('#due_date').datepicker(pickerOpts);
                    $('#proof_date').datepicker(pickerOpts);
                    //$('#publication_date').datepicker(pickerOpts);

            });
            
            /** this function is used for form validation, it can be passed 1 or 2 arguements
             * @arg[0] the element that is checked
             * @arg[1] the element id 
            **/
            function chkbox_rad_required() {
                var checked = false;
                for(var i = 0; i < arguments.length; i++ ) {
                   //console.log(arguments[i]);
                    if($(arguments[0]).is(":checked")) {
                        checked = true;
                    } else {
                        checked = false;
                        break
                    }
                }
                return checked;
            }
            
            $(document).ready(function() {
                
                $('#st_Your_Details').val('1');
                $('#st_Category').val('1');
                
                $('#<?php echo $form_name ?>').validate({ // initialize the plugin
					
                    rules: {

                        first_name: {
                                required: true,
                                email: false
                        },
                        last_name: {
                                required: true,
                                minlength: 2
                        },
                        phone: {
                                required: true,
                                number: true
                        },
                        email: {
                                required: true,
                                email: true
                        },
                        state: {
                                required: true
                        },
                        due_date: {
                                required: true
                        },
                        category_advertising_the_advertiser_advertiser_name_text: {
                                required: true
                        },
                        /*category_advertising_the_advertiser_opportunity_name_text: {
                                required: true
                        },*/
                        category_advertising_the_advertiser_product_service_text: {
                                required: true
                        },
                        category_advertising_the_advertiser_website_text: {
                                required: true
                        },
                        category_advertising_the_advertiser_ad_campaign_value_text: {
                                required: true
                        },
                        /*category_advertising_the_advertiser_potential_text: {
                                required: true
                        },*/
                        'category_advertising_the_advertiser_is_this_a_checkbox[]': {
                                required: true
                        },                        
                        the_job_project_name_text : {
                                required: true
                            },
                        the_job_print_publication_textarea : {
                                required: true
                            },                           
                        'the_job_radio[]': {
                                required: true
                            },
                        'is_live_job[]': {
                                required: true
                            },
                        'proof_date': {
                            required: function() {
                                chkbox_rad_required('#yes','#the_job_is_live_job');
                            } 
                        },                            
                        'the_job_print_radio[]': {
                            required: function() {
                                chkbox_rad_required('#print','#print_and_digital');
                            }    
                        },
                        'the_job_print_ad_sizes_checkbox[]' : {
                            required: function() {
                                chkbox_rad_required('#the_job_print_ad_sizes_checkbox');
                            }
                        },
                        'the_job_print_flyer_width_text' : {
                            required: function() {
                                chkbox_rad_required('#the_job_print_flyer_checkbox');
                            }
                        },
                        'the_job_print_flyer_depth_text' : {
                            required: function() {
                                chkbox_rad_required('#the_job_print_flyer_checkbox');
                            }
                        },
                        'the_job_print_pos_checkbox[]' : {
                            required: function() {
                                chkbox_rad_required('#the_job_print_pos_checkbox');
                            }
                        },
                        'the_job_digital_checkbox[]': {                            
                            required: function() {                                
                                chkbox_rad_required('#the_job_digital','#the_job_digital_mobile_desktop_radio');
                            }   
                        },
                        'the_job_digital_mobile_desktop_radio[]' : {
                            required: function() {                                
                                chkbox_rad_required('#digital','#the_job_digital_mobile_desktop_radio');
                            } 
                        },
                        'the_job_digital_desktop_and_mobile_checkbox[]' : {
                            required: function() {
                                chkbox_rad_required('#the_job_digital_desktop_and_mobile_checkbox');
                            } 
                        },                        
                        'the_job_digital_campaign_booking_details_textarea' : {
                            required: function() {
                                chkbox_rad_required('#leaderboard','#half_page','#roadblock','#cube','#side_skins','#mobile',"#lumberjacks",'#mrec','#spot_expander');
                            }
                        },
                        'type_of_request[]' : {
                            required: true
                        }                        
                    },
                    errorPlacement: function( label, element ) {
                        
                        switch(element.attr( "name" )) {                               
                            case 'the_job_radio[]' : 
                                $("#the_job_radio_error_msg").css('visibility','visible');
                                $("#the_job_radio_error_msg").append( label );
                                break;
                            case 'is_live_job[]' : 
                                $("#is_live_job_error_msg").css('visibility','visible');
                                $("#is_live_job_error_msg").append( label );
                                break;    
                            case 'the_job_print_radio[]' :
                                $("#the_job_print_radio_error_msg").css('visibility','visible');
                                $("#the_job_print_radio_error_msg").append( label );
                                break; 
                            case 'the_job_print_ad_sizes_checkbox[]' :
                                $("#the_job_print_ad_sizes_checkbox_error_msg").css('visibility','visible');
                                $("#the_job_print_ad_sizes_checkbox_error_msg").append( label );                                
                                break;
                             case 'the_job_print_pos_checkbox[]' :
                                $("#the_job_print_pos_checkbox_error_msg").css('visibility','visible');
                                $("#the_job_print_pos_checkbox_error_msg").append( label );                                
                                break;   
                            case 'the_job_digital_mobile_desktop_radio[]' :
                                $("#the_job_digital_mobile_desktop_radio_error_msg").css('visibility','visible');
                                $("#the_job_digital_mobile_desktop_radio_error_msg").append( label );
                                break;
                             case 'the_job_digital_desktop_and_mobile_checkbox[]' :
                                $("#the_job_digital_desktop_and_mobile_checkbox_error_msg").css('visibility','visible');
                                $("#the_job_digital_desktop_and_mobile_checkbox_error_msg").append( label );
                                break;   
                             case 'type_of_request[]' :
                                $("#type_of_request_error_msg").css('visibility','visible');
                                $("#type_of_request_error_msg").append( label );
                                break;                                  
                            default :
                                label.insertAfter( element );
                        }
                    },
                });
                
                <?php
                if (isset($_REQUEST["adnumber"])) {
                ?>
                    populate("#<?php echo $form_name ?>",json);
                <?php
                }
                ?>
                
            });
	    
            jQuery.extend(jQuery.validator.messages, {
                    required: "<div style='color:red'>  This field is required.</div>",
                    remote: "Please fix this field.",
                    email: "<div style='color:red'>Please enter a valid email address.</div>",
                    phone: "<div style='color:red'>Please enter a valid phone number, include area code</div>",
                    last_name: "<div style='color:red'>Please enter at least 2 characters</div>"
                    /*url: "Please enter a valid URL.",
                    date: "Please enter a valid date.",
                    dateISO: "Please enter a valid date (ISO).",
                    number: "Please enter a valid number.",
                    digits: "Please enter only digits.",
                    creditcard: "Please enter a valid credit card number.",
                    equalTo: "Please enter the same value again.",
                    accept: "Please enter a value with a valid extension.",
                    maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
                    minlength: jQuery.validator.format("Please enter at least {0} characters."),
                    rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
                    range: jQuery.validator.format("Please enter a value between {0} and {1}."),
                    max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
                    min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")*/
            });
            
            /*
             * 
                $('.marketing_department').hide();
                $('.advertising_department').hide();
                $('.digital_elements').hide();
                $("#the_job_print_container").hide();
                $("#the_job_print_ad_sizes_container").hide();
                $("#the_job_print_flyer_container").hide();
                $("#the_job_print_pos_container").hide();
                $("#the_job_digital_container").hide();
             */
            
            <?php
            if (isset($_REQUEST["adnumber"])) {
            ?>
            
            function isCheckbox (element) {
                return element instanceof HTMLInputElement 
                       && element.getAttribute('type') == 'checkbox'
            }
            <?php
	}
	?>
	//** date picker
	$(function() {

		var pickerOpts = {
                    dateFormat: "dd/mm/yy"
		}

		$('#press_date').datepicker(pickerOpts);
		$('#pub_date').datepicker(pickerOpts);

	});
            
	</script>
	<div style="padding:0px 0px 20px 0px;"></div>
</form>
<?php
include(INCLUDES_PATH . "/site_footer.php");
?>