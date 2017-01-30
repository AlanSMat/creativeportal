 /* 
    $('.marketing_department').hide();
    $('.advertising_department').hide();
    $('.digital_elements').hide();
    $("#the_job_print_container").hide();
    $("#the_job_print_ad_sizes_container").hide();
    $("#the_job_print_flyer_container").hide();
    $("#the_job_print_pos_container").hide();
    $("#the_job_digital_container").hide();
    $("#the_job_multimedia_container").hide();
 */

function populate(frm, data) {
    
    var print_selected = false;
    clear_inputs('print');
    $.each(data, function(key, value){
            
            if(value !== '' && value !== '0') {
                
                //console.log(key + ' ' + value);
                
                if(key === 'the_job_radio') {
                    
                    key = value[0];
                    
                }
                
                switch(key) {
                    
                    case 'st_Marketing_Department' :
                        
                        show_container("#category_marketing_container");

                        break;
                        
                    case 'st_Advertising_Department' :
                        
                        show_container("#category_advertising_container");
                        
                        break;
                        
                    case 'multimedia' :
                        
                        show_container("#the_job_multimedia_container");
                        
                        break;   
                    
                    case 'print' :
                        
                        show_container("#the_job_print_container")
                        print_selected = true;
                        
                        break;
                                            
                    case 'digital' :
                        
                        show_container("#the_job_digital_container");
                        
                        break;     
                }
                
                if( print_selected ) {
                    
                    switch(key) {
                        case 'the_job_print_ad_sizes_checkbox' :
                            $("#the_job_print_ad_sizes_container").show();
                            break;
                        case 'the_job_print_flyer_width_text' :
                            $("#the_job_print_flyer_container").show();
                            break;
                        case 'the_job_print_pos_checkbox' :
                            $("#the_job_print_pos_container").show();
                            break;                        
                    }
                    
                }

            }
            var $ctrl = $('[name='+key+']', frm);

            if ($.isArray(value)) {

                    for (i = 0; i < value.length; i++) {

                        if($('#' + value[i]).is(':checkbox') || $('#' + value[i]).is(':radio')) {

                            document.getElementById(value[i]).checked = true;    

                        }

                    }
            } 

            switch($ctrl.attr("type")) {  
                    case "text" :   
                    case "hidden" : 
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

