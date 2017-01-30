<?php

require(CLASSES_PATH . "/class.ArrayToXml.php");

/**
  @author Steven Mather :steven.mather@news.com.au

  USAGE
 *          
 * 

 * */
class PostData {

    public function __construct($post_array) {
        
        //var_dump($post_array);
        
        $this->post_array                 = $post_array;
        $this->form_name                  = $post_array['form_name'];
        
        //** generate the adwatch_order_number, adwatch_ad_number from the last database insertion id
        $this->adwatch_ad_number          = strtoupper($post_array["adnumber"]);
        $this->form_prefix                = substr($post_array["adnumber"],0,1);
        //** find out whether the form type is marketing or advertising
        $this->form_type                  = $this->get_form_type();
        //** sets the default publication if not entered in the form
        //$this->post_array['default_pub'] = 'Creative Campaign';
        $this->default_pub                = 'Creative Campaign';
        $this->ad_specs                   = '';
        $this->output_directory           = FILES_OUT . "/files_out";
        $this->json_encode                = json_encode($post_array);
        $this->create_json_file           = $this->create_data_file('.js');
        $this->todays_date                = date("d/m/y");
        
        if($this->form_name == 'default') {
            
            $this->config_json_array         = $this->parse_json_file();
            
        } else {
            
            $this->asset_specifics_array = $this->create_asset_specifics_array();
            
        }
        
        
        $this->prod_comments_string      = 'prod comments';//$this->_get_prod_comments();
    }
    
    public function get_section_array() {
        
        $section_array = array();
        
        foreach($this->post_array as $key => $value) {
            
            if(isset($this->config_json_array[$key][0]['section_name'])) {
                
                $section_array[$key] = $this->config_json_array[$key][0]['section_name'];
            
            }
            
        }
        
        return $section_array;
    }
    
    protected function get_form_type() {
        if($this->form_prefix == 'M') {
            $form_type = 'marketing';
        } else {
            $form_type = 'advertising';
        }
        return $form_type;
    }
        
    protected function create_asset_specifics_array() {
        
        $asset_specifics_array = array();
        
        foreach($this->post_array as $key => $value) {
            
            if(strpos($key,'asset_specifics_option')) {
                
                $asset_specifics_array[$key] = $value;
                
            }
            
        }
        
        return $asset_specifics_array;
        
    }


    protected function get_adwatch_adnumber() {
        
        return $this->adwatch_ad_number;
        
    }
    
    protected function get_config_json_array() {
        
        return $this->config_json_array;
        
    }

    /**
     * returns the input name of the form field based on the form_name passed up from the child class
     * the advertising form field input name MUST always be the left argument
     * @param $adveristing input from the advertising form
     * @param $marketing input from the marketing form
     */
    protected function get_input_value($default_input = '', $nxtend_input = '') { 
        
        if($this->form_name == "default") { 
            
            return $default_input;
            
        } 
        else if($this->form_name == "nxtend") { 
        
            return $nxtend_input;
            
        } 
        else if($this->form_name == "XTEND") { 
            
            return $xtend_input;
            
        } 
        else if($this->form_name == "QUICK_BRIEF") { 
            
            return $quick_input;
            
        } 
        else { 
        
            trigger_error("form type not found");
            
        }
    }    
    
    protected function parse_json_file( $config_file = true ) {
        
        if($config_file) {
            
            $json_file_string = file_get_contents(FORMS_PATH . "/" . $this->form_name . "/config.json");
            
        } else {
            
            $json_file_string = file_get_contents(FORMS_PATH . "/" . $this->form_name . "/json/" . $this->adwatch_ad_number . ".js");
            
            //** remove "var json=" from the json string
            $json_file_string = substr($json_file_string, 9);
                        
        }
        
        if (!$json_array = json_decode($json_file_string, true)) {

            echo trigger_error("error:there is a syntax in the json file, please correct and try again");
            
        }

        return $json_array;
    }

    protected function get_materials_output_path() {

        return $this->output_directory . "/uploads";
    }

    protected function get_xml_output_path() {

        return $this->output_directory . "/xml";
    }

    protected function get_log_output_path() {

        return $this->output_directory . "/log";
    }

    //** sets data for the production-comments tag
    protected function concatanate_production_comments() {
        
        isset($this->config_json_array['first_name'][0]['element_name'])   ? $first_name   = $this->config_json_array['first_name'][0]['element_name']   : $first_name = $this->post_array[$this->get_input_value('','booking_details_first_name')];
        isset($this->config_json_array['last_name'][0]['element_name'])    ? $last_name    = $this->config_json_array['last_name'][0]['element_name']    : $last_name  = $this->post_array[$this->get_input_value('','booking_details_last_name')];
        isset($this->config_json_array['phone'][0]['element_name'])        ? $phone        = $this->config_json_array['phone'][0]['element_name']        : $phone      = $this->post_array[$this->get_input_value('','booking_details_phone')];
        isset($this->config_json_array['email'][0]['element_name'])        ? $phone        = $this->config_json_array['email'][0]['element_name']        : $email      = $this->post_array[$this->get_input_value('','booking_details_email')];
        isset($this->config_json_array['account_name'][0]['element_name']) ? $account_name = $this->config_json_array['account_name'][0]['element_name'] : $account_name = '';
        $project_name = isset($this->post_array["the_job_project_name_text"]) ? $project_name = $this->post_array["the_job_project_name_text"] : $project_name = ''  ;        
        
        
        if(!isset($this->config_json_array['account_name'][0]['element_name']) && $this->form_name == 'default') {
            
            $account_name = substr($this->config_json_array['Name1'], 1, strlen($this->config_json_array['Name1']));
            
        }
        
        $project_name = $this->post_array['the_job_project_name_text'];
        $first_name = $this->post_array['first_name'];
        $last_name = $this->post_array['last_name'];
        
        if($this->form_prefix == 'M') {
            
            $concatanated_production_comments = $project_name . "_" . $first_name . " " . $last_name;
            
        } else {
            
            $advertiser_name = $this->post_array['category_advertising_the_advertiser_advertiser_name_text'];
            $concatanated_production_comments = $advertiser_name . "_" . $first_name . " " . $last_name;
            
        }
        
        

        return $concatanated_production_comments;
    }

    protected function get_match($subject, $match) {

        if (strpos($subject, $match) !== false) {

            return 0;
            
        } else {

            return 1;
        }
    }
    
    protected function get_xml_tag($tag_name) {
        
        foreach($this->get_section_array() as $key => $value) {
            
            if($this->config_json_array[$key][0]['xml_tag'] == $tag_name) {
                
                $this->config_json_array[$key][0]['xml_tag'];
                $tag_value = $this->post_array[$this->config_json_array[$key][0]['element_name']];
                
                break;
            }
            
        }
        
        return $tag_value;
        
    }
    
    //** condenses state into a 3 letter word
    protected function get_state() {
        
        //** input value from form
        $state = trim($this->post_array['state']);
        
        switch($state) {
            
            case 'New South Wales':
                $state = 'NSW';
                break;
            
            case 'Victoria':
                $state = 'VIC';
                break;
            
            case 'VIC_Melbourne':
                $state = 'VIC';
                break;
            
            case 'VIC_Geelong':
                $state = 'VIC';
                break;			
			
            case 'Queensland':
                $state = 'QLD';
                break;

            case 'QLD_Brisbane':
                $state = 'QLD';
                break;
            
            case 'QLD_Townsville':
                $state = 'QLD';
                break;			

            case 'QLD_Cairns':
                $state = 'QLD';
                break;	

            case 'QLD_Gold_Coast':
                $state = 'QLD';
                break;					
			
            case 'South Australia':
                $state = 'SA';
                break;
				
             case 'Tasmania':
                $state = 'TAS';
                break;
            
            case 'Northern Territory':
                $state = 'NT';
                break;
            
            case 'West Australia':
                $state = 'WA';
                break;           
        }
        
        return $state;
        
    }
    
    protected function get_element_value($id) {
        
        $element_name = '';
        
        foreach($this->get_section_array() as $key => $value) {
            
            if($this->config_json_array[$key][0]['id'] == $id) {
                
                $element_name = $this->post_array[$this->config_json_array[$key][0]['element_name']];
                
                break;
            }
            
        }
        
        return $element_name;
        
    }
    
    //** builds the filename for the log file or the html file.
    protected function get_file_name($file_ext) {
        
        switch ($file_ext) {
            
            case '.log' :
                
                $file_name = date("Y_m_d") . '.log';
                
                break;
            
            case '.js' :
                
                $file_name = $this->post_array['adnumber'] . '.js';
                
                break;
            
            default :
                
                $file_name = $this->post_array['adnumber'] . "-D" . date("dmy") . "T" . date("Gis") . $file_ext;
            
        }
        
        return $file_name;
    }
    
    protected function upload_file() {
        
        $file_upload = 0;
        
        if(isset($_FILES['file_upload'])) {
            
            $target_path = MATERIAL_OUT . '/';
            $file_name = $this->post_array['adnumber'] . '-' . $this->sanitize_file_name($_FILES['file_upload']['name']);
            
            $target_path = $target_path . $file_name; 
            
            if(move_uploaded_file($_FILES['file_upload']['tmp_name'], $target_path)) {

                $log_message = "INFO: The file " . $this->sanitize_file_name( $_FILES['file_upload']['name'] ) . " for adnumber " . $this->post_array['adnumber'] . " has been uploaded successfully";
                $this->create_data_file('.log', $log_message);
                
                $file_upload = 1;
                                
            } else {
                
                if($this->sanitize_file_name( $_FILES['file_upload']['name'] ) != "") {
                 
                    $file_upload = 0;
                    
                }
            }
            return $_FILES['file_upload']['name'];
        } else {
            return '';
        }
        
    }

    protected function sanitize_file_name ($str = '') {
        
        $str = strip_tags($str); 
        $str = preg_replace('/[\r\n\t ]+/', ' ', $str);
        $str = preg_replace('/[\"\*\/\:\<\>\?\'\|]+/', ' ', $str);
        $str = strtolower($str);
        $str = html_entity_decode( $str, ENT_QUOTES, "utf-8" );
        $str = htmlentities($str, ENT_QUOTES, "utf-8");
        $str = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $str);
        $str = str_replace(' ', '-', $str);
        $str = rawurlencode($str);
        $str = str_replace('%', '-', $str);
        return $str;
        
    }
    
    //** creates .html,.log or .xml physical files for MediaSpectrum.
    protected function create_data_file($file_ext, $file_contents = '') {
        
        $file_name = $this->get_file_name($file_ext);
        
        switch ($file_ext) {

            case '.html' :
                
                $file = fopen(MATERIAL_OUT . "/" . $file_name, 'a');
                $file_contents = $this->create_html();
                $this->create_data_file('.log', 'INFO: ' . $this->adwatch_ad_number . '.html created');
                
                break;

            case '.js' :

                $file = fopen(FORMS_PATH . "/default/json/" . $file_name, 'w');
                $file_contents = "var json=" . $this->json_encode;
                $this->create_data_file('.log', 'INFO: ' . $this->adwatch_ad_number . '.js created');
                
                break;

            case '.log' :
                
                $file_name = $this->get_file_name($file_ext);
                
                $file = LOGS_OUT . '/' . $file_name;
                
                $date_time = date('Y-m-d H:i:s');
                
                if (!file_exists($file)) {
                    
                    $file = fopen($file, 'a');
                    $file_contents = $date_time . ' ' . $file_contents . "\r\n";
                    
                } else {

                    $file = fopen($file, 'a');
                    $file_contents = $date_time . ' ' . $file_contents . "\r\n";
                    
                }

                break;
        }
        
        if ($file_ext != '.xml') {

            if (fwrite($file, $file_contents)) {
                
                fclose($file);
                
            }
        }
    }
}

//*************************** end PARENT class ****************************************************

class BookingsXmlForMediaSpectrum extends PostData {

    public function __construct($post_array = false) {
		
        $this->wp_content_dir = 'uploads';
        $this->db_insert = 1;
        $this->post_array = $post_array;        
        
        if (!$post_array) {

            trigger_error("missing BookingsXMLForMediaSpectrum class argument");
        }

        //** formid's 4 = Advertising Form 
        //            5 = Marketing Form
        //            9 = Xtend Form
        //            3 = Quick Brief Form
        else if (isset($post_array['form_name'])) {

            parent::__construct($post_array, $post_array['form_name']);

            $this->output_dir = parent::get_xml_output_path();
            $this->AdWatchInfo_data = $this->AdWatchInfo_data();
            
            $this->section_array = parent::get_section_array();
                        
        } else {

            trigger_error("form_name not found");
        }
    }

    protected function get_ad_loc_info() {
        
        $ad_data = array();

        $ad_count = 1;
        $ad_width     = '210';
        $phy_ad_width = '210';
        $ad_height    = '297';
        
        $the_job_radio_checked = isset($this->post_array['the_job_radio']) ? $the_job_radio_checked = $this->post_array['the_job_radio'] : $the_job_radio_checked = '' ;
        $job_selected = 0;
        
        $json_array = parent::get_config_json_array();

        if(is_array($the_job_radio_checked)) {
            
            //** loop through 3 radio buttons under the "The Job" category "Print", "Digital / Multimedia"
            foreach($the_job_radio_checked as $job_type) {
                
                if ($job_type == 'print' || $job_type == 'print_digital') {
                    
                    if(isset($this->post_array['the_job_print_radio'])) {
                        
                        $print_job_checked = $this->post_array['the_job_print_radio'];
                        
                        //** loop through the print options checkbox fields
                        foreach ($print_job_checked as $print_job) {

                            switch ($print_job){

                                case 'the_job_print_ad_sizes_radio' : 
                                    
                                    $ad_sizes_checked = $this->post_array['the_job_print_ad_sizes_checkbox'];
                                    
                                    foreach($ad_sizes_checked as $ad_size) {

                                        $ad_data[$ad_count]  = $this->_generate_ad_data_array($this->adwatch_ad_number . '-' . $ad_count, 
                                                                                                                               $ad_width, 
                                                                                                                               $phy_ad_width, 
                                                                                                                               $ad_height, 
                                                                                                                               $job_type, 
                                                                                                                               $ad_size);

                                        $ad_count++;

                                    }
                                    
                                    break;

                                case 'the_job_print_flyer_radio' : 

                                    $ad_data[$ad_count]  = $this->_generate_ad_data_array($this->adwatch_ad_number . '-' . $ad_count, 
                                                                                                                           $ad_width, 
                                                                                                                           $phy_ad_width, 
                                                                                                                           $ad_height, 
                                                                                                                           $job_type, 
                                                                                                                           'Flyer');

                                    $ad_count++;
                                    
                                    break;

                                case 'the_job_print_pos_radio' :

                                    $ad_data[$ad_count]  = $this->_generate_ad_data_array($this->adwatch_ad_number . '-' . $ad_count, 
                                                                                                                           $ad_width, 
                                                                                                                           $phy_ad_width, 
                                                                                                                           $ad_height, 
                                                                                                                           $job_type, 
                                                                                                                           'POS');

                                    $ad_count++;
                                    
                                    break;

                                case 'the_job_print_presentation_radio' :
									
                                    $ad_data[$ad_count]  = $this->_generate_ad_data_array($this->adwatch_ad_number . '-' . $ad_count, 
                                                                                                                           $ad_width, 
                                                                                                                           $phy_ad_width, 
                                                                                                                           $ad_height, 
                                                                                                                           $job_type, 
                                                                                                                           'Presentation');

                                    $ad_count++;
                                    
                                    break;

                                case 'the_job_print_project_radio' :
									
                                    $ad_data[$ad_count]  = $this->_generate_ad_data_array($this->adwatch_ad_number . '-' . $ad_count, 
                                                                                                                           $ad_width, 
                                                                                                                           $phy_ad_width, 
                                                                                                                           $ad_height, 
                                                                                                                           $job_type, 
                                                                                                                           'Project');

                                    $ad_count++;
                                    
                                    break;
									
                                case 'the_job_print_other_radio' :

                                    $ad_data[$ad_count]  = $this->_generate_ad_data_array($this->adwatch_ad_number . '-' . $ad_count, 
                                                                                                                           $ad_width, 
                                                                                                                           $phy_ad_width, 
                                                                                                                           $ad_height, 
                                                                                                                           $job_type, 
                                                                                                                           'Other');

                                    $ad_count++;

                                    break;
                                
                                case 'the_job_print_ad_note_radio' :

                                    $ad_data[$ad_count]  = $this->_generate_ad_data_array($this->adwatch_ad_number . '-' . $ad_count, 
                                                                                                                           $ad_width, 
                                                                                                                           $phy_ad_width, 
                                                                                                                           $ad_height, 
                                                                                                                           $job_type, 
                                                                                                                           'Ad Note');

                                    $ad_count++;

                                    break;                                
                                
                                case 'the_job_print_creative_shape_radio' :

                                    $ad_data[$ad_count]  = $this->_generate_ad_data_array($this->adwatch_ad_number . '-' . $ad_count, 
                                                                                                                           $ad_width, 
                                                                                                                           $phy_ad_width, 
                                                                                                                           $ad_height, 
                                                                                                                           $job_type, 
                                                                                                                           'Creative Shape');

                                    $ad_count++;

                                    break;                                

                                case 'the_job_print_wrap_radio' :

                                    $ad_data[$ad_count]  = $this->_generate_ad_data_array($this->adwatch_ad_number . '-' . $ad_count, 
                                                                                                                           $ad_width, 
                                                                                                                           $phy_ad_width, 
                                                                                                                           $ad_height, 
                                                                                                                           $job_type, 
                                                                                                                           'Wrap');

                                    $ad_count++;

                                    break;
                                
                                case 'the_job_print_invitation_radio' :

                                    $ad_data[$ad_count]  = $this->_generate_ad_data_array($this->adwatch_ad_number . '-' . $ad_count, 
                                                                                                                           $ad_width, 
                                                                                                                           $phy_ad_width, 
                                                                                                                           $ad_height, 
                                                                                                                           $job_type, 
                                                                                                                           'Invitation');

                                    $ad_count++;

                                    break;                                
                                
                            }
                        }
                        $job_selected = 1;
                    } //** end if the job print
                } //** if job print or multimedia
                
                if(isset($this->post_array['the_job_digital_mobile_desktop_radio'])) {
                    
                    if($job_type == 'digital' || $job_type == 'print_digital') {
                        
                        if(isset($this->post_array['the_job_digital_mobile_checkbox'])) {
                            
                            $digital_jobs_selected = $this->post_array['the_job_digital_mobile_checkbox'];
                            $list_item             = $this->config_json_array['the_job_digital_mobile_checkbox'][0]['list_item'][0];
                            
                        } else if(isset($this->post_array['the_job_digital_desktop_checkbox'])) {
                            
                            $digital_jobs_selected = $this->post_array['the_job_digital_desktop_checkbox'];
                            $list_item             = $this->config_json_array['the_job_digital_desktop_checkbox'][0]['list_item'][0];
                            
                        } else if(isset($this->post_array['the_job_digital_desktop_and_mobile_checkbox'])) {
                            
                            $digital_jobs_selected = $this->post_array['the_job_digital_desktop_and_mobile_checkbox'];
                            $list_item             = $this->config_json_array['the_job_digital_desktop_and_mobile_checkbox'][0]['list_item'][0];                            
                            
                        }
                        
                        $selected_items_array  = $this->parse_out_onclick($list_item);
                        
                        foreach ($digital_jobs_selected as $digital_job_selected) {
                            
                            $ad_data[$ad_count++]  = $this->_generate_ad_data_array($this->adwatch_ad_number . '-' . $ad_count, 
                                                                                                                     $ad_width, 
                                                                                                                     $phy_ad_width, 
                                                                                                                     $ad_height, 
                                                                                                                     $job_type, 
                                                                                                                     $selected_items_array[$digital_job_selected]);
                        }
                    }
                    $job_selected = 1;
                }
                /*
                if(isset($this->post_array['the_job_digital_desktop_and_mobile_checkbox'])) {
                    
                    echo 'got here';
                        
                    if($job_type == 'digital' || $job_type == 'print_digital') {

                        $digital_jobs_selected = $this->post_array['the_job_digital_desktop_and_mobile_checkbox'];
                        $list_item             = $this->config_json_array['the_job_digital_desktop_and_mobile_checkbox'][0]['list_item'][0];
                        
                        $selected_items_array  = $this->parse_out_onclick($list_item);
                        
                        foreach ($digital_jobs_selected as $digital_job_selected) {
                            
                            $ad_data[$ad_count++]  = $this->_generate_ad_data_array($this->adwatch_ad_number . '-' . $ad_count, 
                                                                                                                     $ad_width, 
                                                                                                                     $phy_ad_width, 
                                                                                                                     $ad_height, 
                                                                                                                     $job_type, 
                                                                                                                     $selected_items_array[$digital_job_selected]);
                        }
                    }
                    $job_selected = 1;
                }*/
                
                //** default entry in case print and digital are not selected
                if($job_selected == 0) {
                        
                        $ad_data[$ad_count]  = $this->_generate_ad_data_array($this->adwatch_ad_number . '-' . $ad_count, 
                                                                                                               210, 
                                                                                                               210, 
                                                                                                               297, 
                                                                                                               $job_type, 
                                                                                                               'Other');
                }
            } //** end for each
        } //** end if the job radio checked
        return $ad_data;
    }
    
    /*protected function get_digital_type_selected() {
        
        switch ()
        
    }*/


    protected function parse_out_onclick($list_item) {
        $parsed_array = array();
        //** parse out the onclick event from the config.json file
        foreach($list_item as $key => $value) {  
            if(strpos($key, '->')) {
                $job_selected = explode('->',$key);
                $parsed_array[trim($job_selected[0])] = $value;
            } else {
                $parsed_array[trim($key)] = $value;
            }
        }
        return $parsed_array;
    }
    
    private function _get_ms_run_date() {
        	
        if(isset($this->post_array['proof_date']) && $this->post_array['proof_date'] != '') {
            $run_date = trim($this->post_array['proof_date']);
        } else {
            $run_date = trim($this->post_array['due_date']);
        }
        
        if(strpos($run_date, '-')) {
            $date_array = explode('-',$run_date);
        } else if(strpos($run_date, '/')) {
            $date_array = explode('/',$run_date);
        } else {
            parent::create_data_file('.log','ERROR: incorrect date entered ' . $run_date . ' for adnumber ' . parent::get_adwatch_adnumber());
            return $run_date;
        }
        
        if(strlen($date_array[2]) == 2) {
            $date_array[2] = '20' . $date_array[2];
        }
        
        $run_date = str_pad($date_array[1],2,'0',STR_PAD_LEFT) . str_pad( $date_array[0],2,'0',STR_PAD_LEFT) . $date_array[2];

        return $run_date;
        
    }
    
    //** if the job category is marketing or advertising get the publication_placement field
    protected function get_publication_placement($job_type) {
        
        if($this->get_form_type() == 'marketing') {
            
            $list_item             = $this->config_json_array['category_marketing_campaign_division_radio'][0]['list_item'][0];
            
            if(isset($this->post_array['category_marketing_campaign_division_radio'][0]) && $this->post_array['category_marketing_campaign_division_radio'][0] != '') {
                
                $publication_placement = $list_item[$this->post_array['category_marketing_campaign_division_radio'][0]];
            
            } else {
                
                $publication_placement = '';
                
            }
            
        } else {
            
            $list_item             = $this->config_json_array['type_of_request'][0]['list_item'][0];            
            $publication_placement = $list_item[$this->post_array['type_of_request'][0]];
                        
        }
        return $publication_placement;
    }
    
    protected function get_press_section() {
        
        switch($this->post_array['the_job_radio'][0]) {
            
            case 'print' :
                $press_section = 'Print';
                break;
            case 'digital' :
                $press_section = 'Digital';
                break;
            case 'print_digital' :
                $press_section = 'Print,Digital';
                break;
            
        }
        
        return $press_section;
        
    }
    
    //** generates the xml data between the <ad> tags of the bookings xml
    private function _generate_ad_data_array($ad_number, $ad_width, $phy_ad_width, $ad_height, $job_category, $job_type, $named_ad_size = 'Other') {

        $sort_text = '';
        
        //** restrict the sort-text tag to 40 characters, the field-width in the database is 40 chars, bookings will fail if the length is not restricted.
        if (strlen($sort_text) > 40) {
            
            substr($sort_text, 0, 39);
            
        }

        $publication_placement = $this->get_publication_placement($job_type);
        
        $ad_loc_info = array('sort-text'             => $this->todays_date, 
                             'publication'           => $this->default_pub,
                             'publication-placement' => $publication_placement,
                             'publication-position'  => $job_type, 
                             'pressSection'          => $this->get_press_section(),
                             'rundates'              => array(
                             'date'                  => $this->_get_ms_run_date()
                                                        )
        );
        
        return $ad_loc_info;
    }

    protected function config_array_vars($xml_tag) {
        
        if($this->form_name != 'nxtend') {
        
            if (substr($this->config_json_array[$xml_tag], 0, 1) == '#') {

                $xml_string = substr($this->config_json_array[$xml_tag], 1, strlen($this->config_json_array[$xml_tag]));

            } else {

                $xml_string = '';

            }
        
        } else {
        
            $xml_string = '';
            
        }
        
        return $xml_string;
    }

    /*  function AdWatchInfo_data returns a multiple array that stores the xml data from which the bookings xml file is created

     */
    
    protected function AdWatchInfo_data() {
        
        if(isset($this->post_array['is_update'])) {
            
            $ad_update = 'Critical Change';
            
        } else {
            
            $ad_update = 'Active';
            
        }
        
        $AdWatchData = array('AdWatchInfo'
            => array('Customer'
                => array('Name1'       => $this->config_array_vars('Name1'),
                         'Address'     => array('Addr1' => '',
                         'City'        => '',
                         'Postal-Code' => '',
                         'State'       => $this->get_state(),//$this->get_xml_tag('State'),
                    ),
                    
                    'Type' => $this->config_array_vars('Type'),
                    'IsCompany' => '1',
                    'account-number' => 'T9999999',
                    
                ),
                
                'adwatch-order-number' => $this->adwatch_ad_number,
                'order-source'         => $this->config_array_vars('order-source'),
                'Ad' => array('adwatch-ad-number' => $this->adwatch_ad_number,
                'external-ad-number'   => '',
                'ad-width'             => '210',
                'phy-ad-width'         => '210',
                'ad-height'            => '297',
                'named-ad-size'        => '',
                'color'                => 'Process',
                'color-comments'       => 'color-comments',
                'production-comments'  => $this->concatanate_production_comments(),
                'ad-type'              => 'Creative Material',
                'AdLocInfo'            => $this->get_ad_loc_info(),
                'production-method'    => 'Creative' . substr($this->post_array['state'],0,3),
                'pickup-number'        => array('@value' => '',
                                                '@attributes' => array('doNotUpdate' => 'true')),
                ),
                
                'ad-sold-by'    => $this->config_array_vars('ad-sold-by'),
                'ad-entered-by' => $this->config_array_vars('ad-entered-by'),
                'order-status'  => $this->config_array_vars('order-status')
                
            ),
            
        );
        
        return $AdWatchData;
        
    }
    
    public function create_xml() {
            
        $xml_file_name = parent::get_file_name('.xml');

        $xml = Array2XML::createXML('AdWatchData', $this->AdWatchInfo_data);

        if($xml_output = $xml->save(FILES_OUT . "/xml/" . $xml_file_name)) {
            
            parent::create_data_file('.log', 'INFO: The XML file ' . $xml_file_name . ' was created successfully');
            
        } else {
            
            parent::create_data_file('.log','ERROR: could not create ' . $xml_file_name);
            
        }
        
    }

}

//**************************** End FIRST child class **************************************


/*
 * Generates bookings xml for MediaSpectrum.

  USAGE

 *          @_POST           = post variables from form
 *          @output_dir      = output folder location for generated xml
 *          @form_name         = the id of the form to take the inputs from
 *          @db_insert_id    = database insert id
 *          @wp_content_dir  = location of directory that images are uploaded to
 *
 *
 * $creative_portal_data_file = new DataFileForMediaSpectrum($_POST, $xml_output_directory, $form_name, $entry_id, WP_CONTENT_DIR);
 * $creative_portal_data_file->create_data_file();

 * */
class CreativeHTMLBrief extends PostData {

    public function __construct($post_array = false) {
        
        $this->post_array = $post_array;
        
        if($post_array) {
            
            parent::__construct( $post_array );
            
        }
        
    }
    
    private function _replace_key($array, $key1, $key2) {
        
        $keys = array_keys($array);
        $index = array_search($key1, $keys);

        if ($index !== false) {
            
            $keys[$index] = $key2;
            $array = array_combine($keys, $array);
            
        }

        return $array;
    }
    
    private function _get_bg_color($i) {
        $bg_color = "#EDEEED";
        ($i % 2) ? $bg_color = "#ffffff" : $bg_color = "#cccccc" ;        
        return $bg_color;
    }


    protected function create_html() {
        
        $html  = "<html><head>";
        $html .= "<style>body, table, tr, td, p, span { font-family: Arial; font-size: 16px; padding:5px; } </style>";
        $html .= "</head><body style=\"background-color:#EDEEED;\">";
        $html .= "<table align='center' width='700' cellpadding='3' bgcolor='#ffffff'>";
        $html .= "<tr>";
        $html .=     "<td colspan=\"2\" style=\"background-color:#0092CB; color:#ffffff; text-align:center; padding:10px 0px 10px 0px;\"><b>CREATIVE SERVICES BRIEF</b></td>";
        $html .= "</tr>";
        $html .= "<tr>";        
        $html .= "<td width='350'><b>Job Number: </b></td>";
        $html .= "<td width='350'>" . parent::get_adwatch_adnumber() . "</td>";
        $html .= "</tr>";
        
        $json_array = parent::get_config_json_array();
        
        $i = 0;
        $j = 1;        
        foreach ($this->post_array as $key => $value) {
            
            //** this bit of code is parses the onclick out of the array
            if(isset($json_array[$key][0]['list_item'][0])) {
                
                foreach($json_array[$key][0]['list_item'][0] as $a_key => $a_value) {
                    
                    //** look for the onclick event in the json file
                    if(strpos($a_key,'->')) {
                                
                        $js = explode('->', $a_key);
                        
                        $element_id = trim($js[0]);
                        $javascript = trim($js[1]);
                        
                        //** parse out the onclick event out and put the key into the array
                        $json_array[$key][0]['list_item'][0] = $this->_replace_key($json_array[$key][0]['list_item'][0], $a_key, trim($js[0]));

                    }
                }
            } //** end parse out onclick
            
            if(!is_array($value)) {
                
                if($value != '' || substr($key, 0, 3) == 'st_') {
                    
                    //** The job
                    if($value == 'digital' || $value == 'print') {
                        
                        $this->post_array[$key] = '1';
                        
                    }
                    
                    //** this is for a sub title
                    if(substr($key, 0, 3) == 'st_' && $this->post_array[$key] == '1') {
                        
                        $sub_title = str_replace('st_', '', $key);
                        $sub_title = str_replace("_", " ", $sub_title);
                        
                        $html .= "<tr>";
                        $html .=     "<td colspan=\"2\" style=\"background-color:#0092CB; color:#ffffff; padding:10px 0px 10px 10px;\"><b>" . $sub_title . "</b></td>";
                        $html .= "</tr>";

                    } else { //** else its not a sub title

                        if(isset($json_array[$key][0]['html_title'])) {

                            $title = $json_array[$key][0]['html_title'];

                        } else {

                            $title = '';

                        }
                        
                        $bg_color = $this->_get_bg_color($i);
                        
                        if($title != '') {
                            
                            $html .= "<tr>";
                            $html .=     "<td bgcolor=\"" . $bg_color . "\"><b>" . $title .   "</b></td>";
                            $html .=     "<td bgcolor=\"" . $bg_color . "\">" . nl2br($value) . "</td>";
                            $html .= "</tr>";
                        
                        }
                    }
                }
                
                $i++;
                
            } else { //** if the value is an array its a checkbox or radio field
                
                $check_bg_color = 1;
                
                foreach($value as $k => $v) {
                    
                    if(isset($json_array[$key][0]['list_item'][0][$v])) {
                        
                        $check_box_bg_color = $this->_get_bg_color($j);
                        
                        if($bg_color == $check_box_bg_color && $check_bg_color == 1) {                           
                            $check_bg_color = 0;
                            $check_box_bg_color = $this->_get_bg_color($j++);
                        }
                        
                        $checkbox_title = $json_array[$key][0]['list_item'][0][$v];
                        
                        /*if(isset($json_array[$key][0]['list_item'][0]['html_title'])) {
                            echo $json_array[$key][0]['list_item'][0]['html_title'] . '<br />';
                        }*/
                        
                        //** special stuff for bleed
                        if(isset($json_array[$key][0]['list_item'][0]['html_title']) && $json_array[$key][0]['list_item'][0]['html_title'] == 'Bleed') {
                            
                            $checkbox_title = $json_array[$key][0]['list_item'][0]['html_title'];
                            $checkbox_value = $json_array[$key][0]['list_item'][0][$v];
                        
                        } else if(isset($json_array[$key][0]['list_item'][0]['html_title']) && $json_array[$key][0]['list_item'][0]['html_title'] == 'Addition to a Recent Request?') {
                            
                            $checkbox_title = $json_array[$key][0]['list_item'][0]['html_title'];
                            $checkbox_value = $json_array[$key][0]['list_item'][0][$v];
                        
                        //** special stuff for Is this a live job?    
                        } else if(isset($json_array[$key][0]['list_item'][0]['html_title']) && $json_array[$key][0]['list_item'][0]['html_title'] == 'Is this a live job?') {
                            
                            $checkbox_title = $json_array[$key][0]['list_item'][0]['html_title'];
                            $checkbox_value = $json_array[$key][0]['list_item'][0][$v];
                            
                        } else {
                            
                            $checkbox_value = 'Yes';
                            
                        }
                        
                        $html .= "<tr>";
                        $html .=     "<td style=\"background-color:" . $check_box_bg_color . ";\"><b>" . $checkbox_title . "</b></td>";
                        $html .=     "<td style=\"background-color:" . $check_box_bg_color . ";\">" . $checkbox_value . "</td>";
                        $html .= "</tr>";
                                               
                    } else {
                        
                        $html .= "<tr>";
                        $html .=     "<td style=\"background-color:" . $check_box_bg_color . ";\"><b>" . $k . "</b></td>";
                        $html .=     "<td style=\"background-color:" . $check_box_bg_color . ";\">" . $v . "</td>";
                        $html .= "</tr>";
                        
                        
                    }
                    $j++;
                }
                
            }
        }
        
        if(isset($_FILES['file_upload']) && $_FILES['file_upload']['name'] != '') {
            $html .= "<tr>";
            $html .= "<td><b>File Attachment</b></td>";
            $html .= "<td>" . $_FILES['file_upload']['name'] . "</td>";
            $html .= "</tr>";
        }
        
        $html .= "</table>";
        $html .= "</body></html>";
        
        return $html;
        
    }

    private function get_html_headers($to, $from) {

        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Additional headers
        $headers .= "To: " . $to . "" . "\r\n";
        $headers .= "From: " . $from . "" . "\r\n";

        return $headers;
    }
    
    private function _send_email($html) {
        
        $to = $this->post_array['email'];
        $from = "admininstrator@news.com.au";
        $subject = parent::get_adwatch_adnumber() . " - Creative Portal";
        
        if(mail($to, $subject, $html, $this->get_html_headers($to, $from))) {
            
            $log_message = 'INFO: email successfully sent to ' . $to;
            
            parent::create_data_file('.log', $log_message);
            
        } else {
            
            $log_message = 'ERROR: email could not be sent';
            
            parent::create_data_file('.log', $log_message);
            
        }
        
    }    

    //** pulls all the data in and writes out the html file
    public function create_file($booking_updated = false) {
                
        $html = $this->create_html();
                
        parent::create_data_file('.html',$html);
        
        if(isset($_FILES)) {
            parent::upload_file();
        }
        
        if(!$booking_updated) {
            
            $this->_send_email($html);    
            
        }
        
        if($_SERVER["SERVER_NAME"] == "localhost")  {            
            ?>
            <a href="default/index.php">index</a>
            <a href="default/links.php">Links</a>
            <?php
            var_dump($_POST);
            echo $html;
            exit;
            
        }
    }
}
?>