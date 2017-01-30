function img_swap_click(ad_type) {
    
    var btn_dir          = "../../assets/client/images/nxtend/buttons";
    var btn_out          = "btn-" + ad_type + "-active.png";
    var btn_over         = "btn-" + ad_type + "-hover.png";
    var class_active     = "img_gad_" + ad_type + "_active";
    var class_hover      = "img_gad_" + ad_type + "_hover";
    var id               = "#general_asset_details_" + ad_type;
    var alt_id           = "";    
    var alt_class_active = "";
    var alt_class_hover  = "";
    
    if(ad_type == 'animated') {
        alt_id           = "#general_asset_details_static"; 
        alt_class_active = "img_gad_static_active";
        alt_class_hover  = "img_gad_static_hover";
    } else {
        alt_id           = "#general_asset_details_animated"; 
        alt_class_active = "img_gad_animated_active";
        alt_class_hover  = "img_gad_animated_hover";        
    }
    
    $(id)
            
        .mouseover(function() {
                
            $(this).attr('src', btn_dir + '/' + btn_out);
            $(this).css('cursor','pointer');

        })

        .mouseleave(function() {

            $(this).attr('src',btn_dir + '/' + btn_over);
            $(this).css('cursor','pointer');

        })

        .click(function() {

            if ($(this).hasClass(class_hover)) {

                $(this).removeClass(class_hover).addClass(class_active);
                $(alt_id).removeClass(alt_class_active);

            } else {

                $(this).removeClass(class_active).addClass(class_hover);
                $(alt_id).removeClass(alt_class_hover);

            }

        });
        
}

function tick_img_swap_click(ad_type) {
    
    var btn_dir          = "../../assets/client/images/nxtend/buttons";
    var btn_out          = "btn-" + ad_type + "-active.png";
    var btn_over         = "btn-" + ad_type + "-hover.png";
    var class_active     = "img_gad_" + ad_type + "_active";
    var class_hover      = "img_gad_" + ad_type + "_hover";
    var id               = "#general_asset_details_" + ad_type;
    var alt_id           = "";    
    var alt_class_active = "";
    var alt_class_hover  = "";
    
    if(ad_type == 'animated') {
        alt_id           = "#general_asset_details_static"; 
        alt_class_active = "img_gad_static_active";
        alt_class_hover  = "img_gad_static_hover";
    } else {
        alt_id           = "#general_asset_details_animated"; 
        alt_class_active = "img_gad_animated_active";
        alt_class_hover  = "img_gad_animated_hover";        
    }
    
    $(id)
            
        .mouseover(function() {
                
            $(this).attr('src', btn_dir + '/' + btn_out);
            $(this).css('cursor','pointer');

        })

        .mouseleave(function() {

            $(this).attr('src',btn_dir + '/' + btn_over);
            $(this).css('cursor','pointer');

        })

        .click(function() {

            if ($(this).hasClass(class_hover)) {

                $(this).removeClass(class_hover).addClass(class_active);
                $(alt_id).removeClass(alt_class_active);

            } else {

                $(this).removeClass(class_active).addClass(class_hover);
                $(alt_id).removeClass(alt_class_hover);

            }

        });
        
}

                function populate(frm, data) {

                    $.each(data, function(key, value){

                            if(value !== '' && value !== '0') {

                                switch(key) {

                                    case 'st_Marketing_Department' :

                                        var elements = document.getElementById("the_job_print_container").visibility = 'visible';
                                        console.log(elements);
                                        $('.marketing_department').show();

                                        break;
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