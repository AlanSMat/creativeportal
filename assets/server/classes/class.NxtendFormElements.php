<?php
class FormElements {
    
    public function __construct($form_name) {
        
	$this->form_name         = $form_name;
	$this->forms_path        = FORMS_PATH . "/" . $form_name;
    }
    
    public function create_sub_title($sub_title) {
        
        $sub_title_hidden_field = str_replace(" ", "_", $sub_title );
        $sub_title_hidden_field = str_replace(")", "", $sub_title_hidden_field );
        $sub_title_hidden_field = str_replace("(", "", $sub_title_hidden_field );

        ?>
        <div class="sub_title_container" style="padding-top:40px;">
            <input class="textBox" type="hidden" name="st_<?php echo $sub_title_hidden_field ?>" id="st_<?php echo $sub_title_hidden_field ?>" />
            <div class="sub_title"><?php echo str_replace("_", " ", $sub_title ) ?></div>
            <div class="hr_spacing">
                    <hr />
            </div>
        </div>
        <?php 
    }
    
    //** creates a section title with a specific image, images have the width and height
    public function create_section_title($section_title, $title_image, $padding_top, $img_width = "", $img_height = "", $alt = "") {
        
        if($this->form_name == 'nxtend') {
            
            $img_width = '977';
            $img_height = '59';
            $alt = '';
            
            ?>
            <div class="sub_title_container" style="padding-top: <?php echo $padding_top ?>;margin:auto;">
                <input type="hidden" name="section_<?php echo $section_title ?>" />
                <div><img src="<?php echo NXTEND_IMAGES_URL ?>/<?php echo $title_image ?>" width="<?php echo $img_width ?>" height="<?php echo $img_height ?>" alt=""  /></div>
            </div>
            <?php 
        }
        
    }
    
    public function create_asset_specifics_option ($title_text, $size_text = "") {        
        
        if($title_text == 'Medium Rectangle') {
            $title_text = 'mrec';
        }
        
        $mod_title = strtolower( str_replace(" ", "_", $title_text));
        
        $banner_id       = 'asset_specifics_' . $mod_title . '_banner';
        $title_id        = 'asset_specifics_' . $mod_title . '_title';
        $tick_img_id     = 'asset_specifics_' . $mod_title . '_img';
        $container_id    = 'asset_specifics_' . $mod_title . '_container';
        $hidden_field_id = 'repop_' . $mod_title;
        
        ?>
        <div class="asset_specifics_option_container" id="<?php echo $banner_id ?>">
            <div class="asset_specifics_option_heading_bg_grey">
                <div class="asset_specifics_tick_img_container">
                    <img class="tick_img" onclick="toggle_option_selected('1',this,'<?php echo $hidden_field_id ?>')" id="<?php echo $tick_img_id ?>" src="<?php echo NXTEND_IMAGES_URL ?>/buttons/select-asset-unticked.png" data-alt-src="<?php echo NXTEND_IMAGES_URL ?>/buttons/select-asset-ticked.png" data-hover-src="<?php echo NXTEND_IMAGES_URL ?>/buttons/select-asset-hover.png" width="24" height="24" alt=""/>
                </div>
                <div class="asset_specifics_option_heading" id="<?php echo $title_id ?>">
                    <span id="assets_specifics_mrec_html_title"><?php $title_text == 'mrec' ? print 'Medium Rectangle' : print $title_text ;?></span>
                    <span style="color:#9b9b9b;font-size: 14px"><?php echo $size_text ?></span>
                </div>
            </div>
            <?php 
            if(strtolower($title_text) == 'mrec') {
               // echo $tick_img_id;
            ?>
                <input type="hidden" name="<?php echo $hidden_field_id ?>" id="<?php echo $hidden_field_id ?>" value="0" />
                <!--<input type="hidden" name="asset_specifics_option[]" id="asset_specifics_<?php echo strtolower( str_replace(" ", "_", $title)) ?>_animated_hidden" value="0" />-->
            <?php 
            } else {
            ?>
                <input type="hidden" name="<?php echo $hidden_field_id ?>" id="<?php echo $hidden_field_id ?>" value="0" />
            <?php 
            }
            ?>
        </div>
        <?php
    }
}

?>