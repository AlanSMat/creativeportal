<?php
class FormElements {
    
    public function __construct($form_name) {
        
	$this->form_name         = $form_name;
	$this->forms_path        = FORMS_PATH . "/" . $form_name;
        $this->config_json_array = $this->_parse_json_file();
		
    }
    
    private function _parse_json_file() {
        
        $json_file = file_get_contents(FORMS_PATH . "/" . $this->form_name . "/config.json");
        if(!$json_array = json_decode($json_file,true)) {
            
            trigger_error("error:there is a syntax in the json file, please correct and try again");
            
        }
        
        return $json_array;
        
    }
	
    public function create_element($section, $inner_box_width = '') {

        $element_type = $this->config_json_array[$section][0]["element_type"];
        
        switch($element_type) {

            case "text" :

                $this->create_input_element($section);

                break;

            case "select" : 

                $this->_create_select($section);

                break;

            case "text-area" : 

                $this->_create_text_area_element($section);

                break;

            case "file" : 

                $this->_create_upload_element($section);

                break;

            case "submit" : 
                
                $this->_create_button($section);

                break;

            case "radio" : 
            case "checkbox" :
                
                $this->_create_chk_rad_element($section);

                break;
        }

    }

    private function _array_to_object($array) {
        
        if (!is_array($array)) {
            
            return $array;
            
        }

        $object = new stdClass();
        
        if (is_array($array) && count($array) > 0) {
            
            foreach ($array as $name => $value) {
                
                $name = strtolower(trim($name));
                
                if (!empty($name)) {
                    
                    $object->$name = $this->_array_to_object($value);
                    //echo $name . ' - ' . $value . '<br />';
                }
            }
            
            return $object;
        }
        else {
            return FALSE;
        }
    }
    
    private function _json_form_element_settings($section) {
        
        $element_settings = array();
        
        if($this->config_json_array[$section][0]['element_type'] == 'radio' || $this->config_json_array[$section][0]['element_type'] == 'checkbox') {
            
            $element_settings['element_name']     = $this->config_json_array[$section][0]['element_name'] . "[]";
            
        } else {
            
            $element_settings['element_name']     = $this->config_json_array[$section][0]['element_name'];
            
        }
            
        $element_settings['element_type']     = $this->config_json_array[$section][0]['element_type'];
        $element_settings['html_title']       = $this->config_json_array[$section][0]['html_title'];
        $element_settings['element_required'] = $this->config_json_array[$section][0]['required'];
	$element_settings['css_class']        = $this->config_json_array[$section][0]['css_class'];
	$element_settings['size']             = $this->config_json_array[$section][0]['size'];
	$element_settings['xml_tag']          = $this->config_json_array[$section][0]['xml_tag'];
        $element_settings['format_settings']  = $this->config_json_array[$section][0]['format_settings'][0];
        $element_settings['element_id']       = $this->config_json_array[$section][0]['id'];
        
        isset($this->config_json_array[$section][0]['readonly']) && $this->config_json_array[$section][0]['readonly'] != '' ? $element_settings['readonly'] = $this->config_json_array[$section][0]['readonly'] : $element_settings['readonly'] = '' ;
        isset($this->config_json_array[$section][0]['onclick']) && $this->config_json_array[$section][0]['onclick'] != '' ? $element_settings['onclick'] = $this->config_json_array[$section][0]['onclick'] : $element_settings['onclick'] = '' ;
        isset($this->config_json_array[$section][0]['css_width']) && $this->config_json_array[$section][0]['css_width'] != '' ? $element_settings['css_width'] = $this->config_json_array[$section][0]['css_width'] : $element_settings['css_width'] = '' ;
        
        return $element_settings;
        
    }
    
    private function _get_css_width($section) {
        
        $json_elm_settings = $this->_json_form_element_settings($section);
        
        if($json_elm_settings['css_width'] != '' ) {
            $css_width = $json_elm_settings['css_width'];
            $css_width = "style=\"width:" . $css_width . "\";";
        } else {
            $css_width = '';
        }
        
        return $css_width;
    }


    public function create_input_element($section) {
        
        $json_elm_settings = $this->_json_form_element_settings($section);
        $onclick = isset($json_elm_settings['onclick']) && $json_elm_settings['onclick'] != '' ? $onclick = $json_elm_settings['onclick'] : $onclick = '' ;
        
        $css_width = $this->_get_css_width($section);
        
        $element_value = '';
        
        if(isset($this->config_json_array[$section][0]["element_value"]) && $this->config_json_array[$section][0]["element_value"] != '') {
            $element_value = $this->config_json_array[$section][0]["element_value"];
        }
        ?>
        
        <div class="inner_box" <?php echo $css_width ?>>
            <div class="html_title"><?php echo $json_elm_settings['html_title'] ?></div>
            <div class="element_spacing, grey_bg"><input <?php $json_elm_settings['readonly'] != '' ? print 'readonly'  : print '' ; ?> type="<?php echo $json_elm_settings['element_type'] ?>" size="<?php echo $json_elm_settings['size'] ?>" name="<?php echo $json_elm_settings['element_name'] ?>" id="<?php echo $json_elm_settings['element_name'] ?>" value="<?php echo $element_value ?>" class="<?php echo $json_elm_settings['css_class'] ?>" <?php $onclick != '' ? print "onclick=\"$onclick\""  : print '' ; ?> /></div>
             <div class="error_message" id="<?php echo $json_elm_settings['element_id'] ?>_error_msg" style="clear:both;display: none;"></div>
             <?php 
            //if(isset($this->config_json_array[$section][0]["text_right"]) && $this->config_json_array[$section][0]["text_right"] != '') {
            ?>
            <div xstyle="padding-top:5px;"><?php //echo $this->config_json_array[$section][0]["text_right"] ?></div>
            <?php 
            //}
            ?>
        </div>
        
        <?php  
    }
    
    public function create_section_title($section_title) {
        
        if($this->form_name == 'nxtend') {

            $section_title_hidden_field = str_replace(" ", "_", $section_title );
            $section_title_hidden_field = str_replace(")", "",  $section_title );
            $section_title_hidden_field = str_replace("(", "",  $section_title );
            ?>
            <div class="sub_title_container">
                <input type="hidden" name="section_<?php echo $section_title ?>" />
                <div class="section_title"><?php echo str_replace("_", " ", $section_title ) ?></div>
                <div><img src="<?php echo NXTEND_IMAGES_URL ?>/arrow.gif" alt="" /></div>
            </div>
            <?php 
        }
        
    }

    public function create_sub_title($sub_title) {
        
        $sub_title_hidden_field = str_replace(" ", "_", $sub_title );
        $sub_title_hidden_field = str_replace(")", "", $sub_title_hidden_field );
        $sub_title_hidden_field = str_replace("(", "", $sub_title_hidden_field );
        
        if($this->form_name == 'nxtend') {
            
            ?>
            <div class="sub_title_container" style="padding-top:40px;">
                <input class="textBox" type="hidden" name="st_<?php echo $sub_title_hidden_field ?>" id="st_<?php echo $sub_title_hidden_field ?>" />
                <div class="sub_title"><?php echo str_replace("_", " ", $sub_title ) ?></div>
                <div class="hr_spacing">
                    <hr />
                </div>
            </div>
            <?php 
            
        } elseif($this->form_name == 'default') {
            
            ?>
            <div class="sub_title_container">
                <input type="hidden" name="st_<?php echo $sub_title_hidden_field ?>" value="" id="st_<?php echo $sub_title_hidden_field ?>" />
                <div class="sub_title"><?php echo $sub_title ?></div>
                <div class="hr_spacing">
                    <hr />
                </div>
            </div>

        <?php
        }
    }
    
    public function create_section($section_title) {
        ?>
        <div class="section_title_container">
            <div class="section_title"><?php echo $section_title ?></div>
            <div class="hr_spacing">
                <hr />
            </div>
            <?php 
            $this->create_element("pos_width");
            $this->create_element("pos_depth");
            $this->create_element("pos_other");
            
            ?>
        </div>
        <?php
    }
    
    private function _create_chk_rad_element($section) {
        
        $json_elm_settings              = $this->_json_form_element_settings($section);
        $json_elm_settings['list_item'] = $this->config_json_array[$section][0]['list_item'][0];
                
        ?>
        <div class="inner_container">
            <div class="inner_box" style="width:<?php echo $json_elm_settings['format_settings']['inner_box_width'] ?>;">
                <!--<div style="padding:3px 0px 10px 0px;">-->
                    <div class="html_title"><?php echo $json_elm_settings['html_title']  ?></div>
                        <?php
                        
                        $i = 0;
                        foreach($this->config_json_array[$section][0]['list_item'][0] as $key => $value) {
                            
                            if(strpos($key,'->')) {
                                
                                $js = explode('->', $key);
                                   
                                $element_id     = trim($js[0]);
                                $set_javascript = trim($js[1]);
                                
                            } else {
                                
                                $element_id = $key;
                                $set_javascript = '';
                                
                            }
                            
                            if($key != 'sub_section' && $key != 'html_title') {     
                                if($value == "Multimedia (Print &amp; Digital)") {
                                    $div_width = "250px" ;
                                } else {
                                    $div_width = $json_elm_settings['format_settings']['element_spacing_width'];
                                }
                                
                            ?>
                                <div class="element_spacing" style="float:left; width:<?php echo $div_width ?>; xborder:1px solid #000;"><input type="<?php echo $json_elm_settings['element_type'] ?>" name="<?php echo $json_elm_settings['element_name'] ?>" <?php $set_javascript != '' ? print $set_javascript  : print '' ; ?> class="<?php echo $json_elm_settings['css_class'] ?>" id="<?php echo $element_id ?>" value="<?php echo $element_id ?>" />&nbsp;&nbsp;<?php echo $value ?>&nbsp;&nbsp;&nbsp;</div>
                            <?php
                            }
                            
                            $i++;
                        }
                        
                        ?>
                <!--</div>-->
                <div class="error_message" id="<?php echo $json_elm_settings['element_id'] ?>_error_msg" style="clear:both; visibility: hidden"></div>
            </div>  
            
        </div>
        <?php
        $set_javascript = '';
    }

    private function _create_select($section) {
        
        $json_elm_settings = $this->_json_form_element_settings($section);
        
        //** path to the text file containing the publication names        
        $form_select_list = FORMS_PATH . "/select_lists/" . $this->config_json_array[$section][0]['data_file'];
        $css_width = $this->_get_css_width($section);
        
        ?>
        <div class="inner_container">
            <div class="inner_box" <?php echo $css_width ?>>
                <div class="html_title"><?php echo $json_elm_settings['html_title'] ?></div>
                <div class="element_spacing">
                    <select name="<?php print $json_elm_settings['element_name'] ?>" id="<?php print $json_elm_settings['element_name'] ?>">
                        <option value=""> -- select -- </option>
                        <?php
                        if($file_handle = fopen($form_select_list,"r")) {

                            while( !feof($file_handle) ) {
                                
                                $line = fgets($file_handle);
                                $option_value = trim(str_replace(' ','_',$line));
                                
                                if(strpos($option_value,'_-_')) {
                                    
                                    $option_value = str_replace('-_','',$option_value);
                                }
                                
                                ?>
                                <option value="<?php print $option_value ?>"><?php echo trim($line) ?></option>
                                <?php 
                                
                            } 

                        } else {

                            echo 'file does not exist';

                        }
                ?>
                    </select>
                </div>
            </div>
        </div>
        <?php
    }
	
    private function _create_text_area_element($section) {
        
       $json_elm_settings = $this->_json_form_element_settings($section);
        ?>   
        <div class="inner_container">
            <div class="inner_box">
                <div class="html_title"><?php echo $json_elm_settings['html_title'] ?></div>
                <div class="element_spacing">
                    <span><textarea name="<?php echo $json_elm_settings['element_name'] ?>" id="<?php echo $json_elm_settings['element_name'] ?>" rows="<?php echo $this->config_json_array[$section][0]['rows'] ?>" cols="<?php echo $this->config_json_array[$section][0]['cols'] ?>" class="<?php echo $json_elm_settings['css_class'] ?>"></textarea></span>
                </div>
            </div>
        </div><br style="clear: both" />
        <?php  
    }

    private function _create_upload_element($section) {
        
       $json_elm_settings = $this->_json_form_element_settings($section);
        ?>   
        <div class="inner_container">
            <div class="inner_box" style="width:<?php echo $json_elm_settings['format_settings']['inner_box_width'] ?>;">
                <div class="html_title"><?php echo $json_elm_settings['html_title'] ?></div>
                <div class="element_spacing">
                    <span><input type="file" name="<?php echo $json_elm_settings['element_name'] ?>" id="<?php echo $json_elm_settings['element_name'] ?>" class="<?php echo $json_elm_settings['css_class'] ?>" /></span>
                    <div class="error_message" id="file_upload_error_msg" style="display:none;color:red;">File size is larger that 5MB, please use transfer drive</div>
                </div>
            </div>
        </div><br style="clear: both" />
        <?php  
    }
    
    /*private function _create_upload_element($section, $javascript = '') {
	
	$element_settings = $this->_array_to_object($this->config_json_array[$section][0]);
        
	?>
        <div class="inner_container">
            <div class="inner_box">
                <div class="html_title"><?php echo $json_elm_settings['html_title'] ?></div>
                <div class="element_spacing">
                    <span><input type="file" name="<?php echo $json_elm_settings['element_name'] ?>" id="<?php echo $json_elm_settings['element_name'] ?>" class="<?php echo $json_elm_settings['css_class'] ?>" /></span>
                </div>      
            </div>
        </div>
    <?php
    }*/

    public function get_sub_dirs() {
        ?>
        <a href="<?php echo FORMS_URL ?>/links.php?form_name=default\">Entries</a> >
        <?php
        foreach(glob(FORMS_PATH . "/", GLOB_ONLYDIR) as $image) {
            $form_name = substr(strrchr($image, '/'), 1, strlen(strrchr($image, '\/')));
            if($form_name != 'select_lists') {
                ?>
                <a href="<?php echo FORMS_URL ?>/<?php echo $form_name ?>/index.php"><?php echo $form_name ?></a> 
                <?php
            }
        }
    }
	
    private function _create_button($section, $javascript = '') {
	
        $element_type     = $this->config_json_array[$section][0]["element_type"];
        $html_title       = $this->config_json_array[$section][0]["html_title"];
	$css_class        = $this->config_json_array[$section][0]["css_class"];
	?>
        <div class="row">
            <div class="buttonContainer">
                <span class="buttonSpacing"><input type="<?php echo $element_type ?>" value="<?php echo $html_title ?>" class="<?php echo $css_class ?>" /></span>
            </div>
        </div>
        <div style="padding:0px 0px 20px 0px;"></div>
	<?php
    }
	
}
?>