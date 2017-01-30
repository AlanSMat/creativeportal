function hide_all() {
                
                $('.marketing_department').hide();
                $('.advertising_department').hide();
                $('.digital_elements').hide();
                $("#the_job_print_container").hide();
                $("#the_job_print_ad_sizes_container").hide();
                $("#the_job_print_flyer_container").hide();
                $("#the_job_print_pos_container").hide();
                $("#the_job_print_other_textarea_container").hide();
                $("#the_job_digital_container").hide();
                $(".digital_element_category_container").hide();
                $("#existing_job_number_container").hide();
                $("#proof_date_container").hide();
                $("#the_job_digital_campaign_booking_details_container").hide();
                $("#the_job_digital_mobile_checkbox_container").hide();
                $("#the_job_digital_desktop_checkbox_container").hide();
                $("#the_job_digital_desktop_and_mobile_checkbox_container").hide();
                $("#the_job_digital_other_textarea_container").hide();
            }
            
            //** div id and checkbox id passed
            function hide_show_container(container_id, element_id) {
                
                $( element_id ).attr('click', function() {
                    
                    $(container_id).show();
                    
                    if($( element_id ).prop( "checked" ) == true) {
                        
                        if((container_id.indexOf('the_job_print') != -1) || (element_id.indexOf('the_job_print') != -1)) {
                            $( '.print_elements' ).hide();
                            $( '#the_job_print_container' ).show();
                        }
                        
                        if((container_id.indexOf('the_job_digital') != -1) || (element_id.indexOf('the_job_digital') != -1)) {
                            
                            $( '.digital_element_category_container' ).hide();
                            
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
                $('#default :input').each(function(i, obj) {
                    
                    var element_name = this.name.toLowerCase();
                    
                    if(element_name.indexOf(str_search) >= 0) {
                        
                        switch(this.type) {

                            case 'checkbox' :
                            case 'radio' :
                                
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
                        $('#st_Print').val('1');
                        
                        $('#st_The_Job').val('print_and_digital');
                        
                        clear_inputs('print');
                        clear_inputs('digital');
                        
                        break;
                    
                     case "#the_job_is_live_job" :
                        
                        $('#proof_date_container').show();
                        $("#the_job_digital_campaign_booking_details_container").show();
                        
                        $('#is_live_job_selected').val('1');
                        
                        break;                   
                    
                     case "#the_job_digital_campaign_booking_details_container" :
                        
                        $("#the_job_digital_campaign_booking_details_container").show();
                        
                        $('#is_live_job_selected').val('1');
                        
                        break;                       
                    
                     case "#the_job_digital_mobile_checkbox_container" :
                        
                        $("#the_job_digital_desktop_checkbox_container").hide();
                        $("#the_job_digital_desktop_and_mobile_checkbox_container").hide();
                        $("#the_job_digital_campaign_booking_details_container").hide();
                        $("#the_job_digital_other_textarea_container").hide()
                        $("#the_job_digital_mobile_checkbox_container").show();
                        
                        clear_inputs('the_job_digital_desktop_checkbox');
                        clear_inputs('the_job_digital_desktop_and_mobile_checkbox');
                        
                        break;                     

                     case "#the_job_digital_desktop_checkbox_container" :
                        $("#the_job_digital_mobile_checkbox_container").hide();
                        $("#the_job_digital_desktop_and_mobile_checkbox_container").hide();                        
                        $("#the_job_digital_campaign_booking_details_container").hide();
                        $("#the_job_digital_other_textarea_container").hide()
                        $("#the_job_digital_desktop_checkbox_container").show();
                        
                        clear_inputs('the_job_digital_mobile_checkbox');
                        clear_inputs('the_job_digital_desktop_and_mobile_checkbox');
                        
                        break;  

                     case "#the_job_digital_desktop_and_mobile_checkbox_container" :
                        
                        $("#the_job_digital_mobile_checkbox_container").hide();
                        $("#the_job_digital_desktop_checkbox_container").hide();
                        $("#the_job_digital_campaign_booking_details_container").hide();
                        $("#the_job_digital_other_textarea_container").hide()
                        $("#the_job_digital_desktop_and_mobile_checkbox_container").show();
                        
                        clear_inputs('the_job_digital_mobile_checkbox');
                        clear_inputs('the_job_digital_desktop_checkbox');
                                                
                        break;

                    default :
                        
                        $(container_id).show();

               }
       
            }
            
            function hide_container(container_id) {
                
                switch(container_id) {
                    
                    case "#the_job_is_live_job" :
                        
                        $('#is_live_job_selected').val('0');
                        $('#proof_date_container').hide();
                        $('#the_job_digital_campaign_booking_details_container').hide();
                        
                        break;
                    
                    default : 
                        
                        $(container_id).hide();
                    
                }
            }