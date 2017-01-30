<?php
require(CLASSES_PATH . "/class.ArrayToXml.php");

/**
  @author Steven Mather :steven.mather@news.com.au

  USAGE

 *          @_POST        = form post variables
 *          @form_name      = the id of the form to take the inputs from
 *          @db_insert_id = database insert id
 * 
  $creative_portal_bookings_xml = new BookingsXmlForMediaSpectrum($_POST, $xml_output_directory, $form_name, $entry_id, WP_CONTENT_DIR);
 *          $creative_portal_bookings_xml->xml_create();

 * */
class PostData {

    public function __construct($post_array) {

        $this->post_array                  = $post_array;
        $this->form_name                   = $post_array['form_name'];
        $this->adwatch_ad_number           = $post_array["adnumber"];
        //** sets the default publication if not entered in the form
        $this->post_array['default_pub']   = 'News Xtend';
        $this->ad_specs                    = '';
        $this->output_directory            = FILES_OUT . "/files_out";
        $this->json_encode                 = json_encode($post_array);
        $this->create_json_file            = $this->create_data_file('.js');
        $this->prod_comments_string        = $this->get_prod_comments();
        $this->get_asset_specifics_options = $this->get_options_selected();
        
    }
    
    protected function get_adwatch_adnumber() {
        
        return $this->adwatch_ad_number;
        
    }
    
    protected function get_prod_comments() {
        
        $prod_comments = '';
        $prod_comments .= 'Live Date: ';
        $prod_comments .= $this->post_array['job_details_due_date_live'] . ' ';
        $prod_comments .= $this->post_array['your_details_first_name'] . ' ';
        $prod_comments .= $this->post_array['your_details_last_name'] . ' ';
        $prod_comments .= '|' .$this->post_array['your_details_phone'];
        $prod_comments .= '[' . $this->post_array['your_details_email'] . '] ';
        
        return $prod_comments;
        
    }
    
    protected function get_state() {
        
        //** input value from form
        $state = trim($this->post_array['your_details_state']);
        
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
    
    //** gets the options selected by the user from the Asset Specifics section
    protected function get_options_selected() {
        
        $asset_specifics_option = '';
        
        foreach($this->post_array as $key => $value) {
            
            //** look for hidden fields prefixed with 'repop'
            if(substr($key, 0, 6) == 'repop_' && $value != '0') {
                
                $option_name = substr($key, 6, strlen($key));
                
                switch($option_name) {
                    
                    case 'mobile_banner' :
                        
                        $asset_specifics_option['mobile_banner'] = 'Mobile Banner';
                        
                        break;                

                    case 'bespoke'  :

                        $asset_specifics_option['bespoke'] = 'Bespoke';

                        break;                

                    case 'leaderboard' :
                        
                        $asset_specifics_option['leaderboard'] = 'Leaderboard';

                        break;                   

                    case 'landing_page' :

                        $asset_specifics_option['landing_page'] = 'Landing Page';

                        break; 
                    
                    case 'mrec' :
                    
                        $asset_specifics_option['mrec'] = 'Medium Rectangle';
                    
                    break;
                    
                }
            } //** end if
        } //** end foreach
        
        return $asset_specifics_option;
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

    //** generates an adnumber for MediaSpectrum
    protected function get_adwatch_ad_number() {

        $adnumber_file = FILES_OUT . '/adnumber/adnumber.txt';

        //** get the adnumber from the file
        $adnumber = file_get_contents($adnumber_file);

        //** mofify the adnumber and write it back into the file.
        $new_ad_number = $adnumber + 1;

        //** write the new number back into the file
        file_put_contents($adnumber_file, $new_ad_number);

        //** push the adnumber onto the post array
        $this->post_array["adnumber"] = $adnumber;

        return $adnumber;
    }

    protected function get_match($subject, $match) {

        if (strpos($subject, $match) !== false) {

            return 0;
            
        } else {

            return 1;
        }
    }
    
    //** builds the filename for the log file or the html file.
    protected function get_file_name($file_ext, $landing_page = false) {
        
        switch ($file_ext) {
            
            case '.log' :
                
                $file_name = date("Y_m_d") . '.log';
                
                break;
            
            case '.xml' :
                
                $file_name = $this->post_array['adnumber'] . "-D" . date("dmy") . "T" . date("Gis") . $file_ext;
                
            case '.html' :
                
                if(!$landing_page) {
                    $file_name = $this->post_array['adnumber'] . "-D" . date("dmy") . "T" . date("Gis") . $file_ext;
                } else {
                    $file_name = $this->post_array['adnumber'] . $file_ext;
                }
                
                break;
            
            case '.js' :
                
                //** if its a .js file take the 'X' out
                $file_name = substr($this->post_array['adnumber'], 1, strlen($this->post_array['adnumber'])) . $file_ext;
                
                break;
            
            default : 
                
                
                $file_name = $this->post_array['adnumber'] . $file_ext;
                
                break;
            
        }
               
        return $file_name;
        
    }
    
    protected function get_date_array() {

        $today               = getdate();

        $date_array['year']  = $today['year'];
        $date_array['month'] = str_pad($today["mon"],2,"0",STR_PAD_LEFT);
        $date_array['day']   = str_pad($today["mday"],2,"0",STR_PAD_LEFT);
        
        return $date_array;

    }
    
    //** creates .html,.log or .xml physical files for MediaSpectrum.
    protected function create_data_file($file_ext, $file_contents = '', $landing_page = false) {

        $file_name = $this->get_file_name($file_ext, $landing_page);
        
        $date_time = date('Y_m_d') . ' ' . date('H:i:s');
        
        switch ($file_ext) {

            case '.html' :
                
                if(!$landing_page) {
                    $folder = MATERIAL_OUT;
                } else {
                    $folder = HTML_OUT;
                }
                
                $file = fopen($folder . "/" . $file_name, 'w');
                $file_contents = $this->create_html();

                break;

            case '.js' :

                $file = fopen(FORMS_PATH . "/" . $this->form_name . "/json/" . $file_name, 'w');
                $file_contents = "var json=" . $this->json_encode;

                break;

            case '.log' :

                $file = LOGS_OUT . '/' . $file_name;

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
    
    protected function sanitize_file_name ($str = '') {
        
        //** get the extension
        $ext = substr($str, strrpos($str, '.'), strlen($str));
        
	if(strlen($str) > 20) {
            
            $str = substr($str, 0, 20);
            
            //** put the extension back onto the parsed string
            $str = $str . $ext;
            
        }
	
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
    
}

//*************************** end PARENT class ****************************************************

class BookingsXmlForMediaSpectrum extends PostData {

    public function __construct($post_array = false) {

        $this->wp_content_dir = 'uploads';
        $this->db_insert = 1;
        $this->post_array = $post_array;
        $this->form_name = 'marketing';
        
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
                        
        } else {

            trigger_error("form_name not found");
        }
    }
    
    protected function digital_ad_size($ad_type) {
        
        $digital_ad_size['mobile_banner'] = '320 x 50';
        $digital_ad_size['mrec']          = '300 x 250)';
        $digital_ad_size['leaderboard']   = '728 x 90';
        $digital_ad_size['landing_page']  = '1024 x 768';
        $digital_ad_size['bespoke']       = '297 x 210';
        
        return $digital_ad_size[$ad_type];
        
    }


    //** loop through the options selected by the user and generates options for the tags under AdLocInfo
    protected function get_ad_loc_info() {
        
        $ad_data = array();

        $ad_count = 0;

        $job_category = 'digital';
        
        $asset_specifics_option = parent::get_options_selected();
        
       
        
        if (is_array($asset_specifics_option)) {
            
            foreach ($asset_specifics_option as $key => $publication_placement) {
                
                $publication_position = str_replace(' ','',$this->digital_ad_size($key));
                
                $adwatch_ad_number = $this->adwatch_ad_number;
                $ad_width = 210;
                $phy_ad_width = 210;
                $ad_height = 297;
                
                $ad_data[$ad_count++] = $this->_generate_ad_data_array($adwatch_ad_number, 
                                                                       $ad_width, 
                                                                       $phy_ad_width, 
                                                                       $ad_height, 
                                                                       '', 
                                                                       $publication_placement, 
                                                                       $publication_position);
            }
        
            
        //** nothings been selected by the user generate a dummy entry.
        } else {

            $ad_data[0] = $this->_generate_ad_data_array($this->adwatch_ad_number, 210, 210, 297, $job_category, '', '');
            
        }
        return $ad_data;
    }
    
    private function _get_rundate($date_string) {
        
        if($date_string) {
        
            $ms_date = explode('/',$date_string);
        
            $run_date = $ms_date[1] . $ms_date[0] . $ms_date[2];
            
        } else {
        
            $run_date = '';
            
        }    
        return $run_date;
        
    }
    
    //** generates the xml data between the <ad> tags of the bookings xml
    private function _generate_ad_data_array($ad_number, 
                                             $ad_width, 
                                             $phy_ad_width, 
                                             $ad_height, 
                                             $job_category, //** digital / print etc
                                             $publication_placement, //** job type, Mrec / Leaderboard etc.
                                             $publication_position = 'Other' //** named adsize 300x250 / M2x2 etc
                                            ) 
    {
		
        $sort_text = $this->post_array['job_details_business_name'];
        //** restrict the sort-text tag to 40 characters, the field-width in the database is 40 chars, bookings will fail if the length is not restricted.
        if (strlen($sort_text) > 40) {

            $sort_text = substr($sort_text, 0, 39);
        }

        $ad_loc_info = array('sort-text'             => $sort_text, 
                             'publication'           => 'News Xtend',
                             'publication-placement' => $publication_placement,
                             'publication-position'  => $publication_position, 
                             'pressSection'          => 'digital',
                             'rundates'              => array(
                             'date'                  => $this->_get_rundate($this->post_array['job_details_due_date_live'])
                                                        )
        );
        
        return $ad_loc_info;
    }
    
    /*  function AdWatchInfo_data returns a multiple array that stores the xml data from which the bookings xml file is created

     */    
    protected function AdWatchInfo_data() {

        $AdWatchData = array('AdWatchInfo'
            => array('Customer'
                => array('Name1'       => 'NEWS XTEND BRIEF',
                         'Address'     => array('Addr1' => '',
                         'City'        => '',
                         'Postal-Code' => '',
                         'State'       => parent::get_state(),
                    ),
                    
                    'Type' => 'Customer',
                    'IsCompany' => '1',
                    'account-number' => 'T8888888',
                    
                ),
                
                'adwatch-order-number' => $this->adwatch_ad_number,
                'order-source'         => 'News Xtend',
                'Ad' => array('adwatch-ad-number' => $this->adwatch_ad_number,
                'external-ad-number'   => '',
                'ad-width'             => '210',
                'phy-ad-width'         => '210',
                'ad-height'            => '297',
                'named-ad-size'        => '',
                'color'                => 'Process',
                'color-comments'       => '',//$this->get_bleed_bool(),
                'production-comments'  => parent::get_prod_comments(),
                'ad-type'              => 'Digital Display',
                'AdLocInfo'            => $this->get_ad_loc_info(),
                'production-method'    => 'Creative' . parent::get_state($this->post_array['your_details_state']),
                'pickup-number'        => array('@value' => '',
                                                '@attributes' => array('doNotUpdate' => 'true')),
                ),
                
                'ad-sold-by'    => 'NewsXtend',
                'ad-entered-by' => 'NewsXtend',
                'order-status'  => 'Active'
                
            ),
        );
        
        return $AdWatchData;
        
    }
    	
    //** copies files that are uploaded (material) from the forms to an uploads directory so that they can be picked up and moved into MediaSpectrum.
    protected function upload_file_attachment($element_name) {
        
        $target_path = MATERIAL_OUT;
        $file_name = basename( $_FILES[$element_name]['name'] );
		
	$original_file_name = $file_name;
		
	//** sanitise the file name
	$file_name = parent::sanitize_file_name($original_file_name);
		
	$log_message = "INFO: The file name " . $original_file_name . " was sanitised and renamed to " . $file_name . "";
        parent::create_data_file('.log', $log_message);
		
        $target_path = $target_path . '/' . $this->adwatch_ad_number . '-' . $file_name; 

        if(move_uploaded_file($_FILES[$element_name]['tmp_name'], $target_path)) {
            
            $log_message = 'INFO: The file ' . $file_name . ' for adnumber ' . $this->adwatch_ad_number . ' was sucessfully uploaded';
            parent::create_data_file('.log', $log_message);
            
        } else {
            
            $log_message = 'ERROR: The file ' . $file_name . ' for adnumber ' . $this->adwatch_ad_number . ' failed to upload';
            parent::create_data_file('.log', $log_message);
            
        }
    }
    
    public function create_xml() {
        
        $xml_file_name = parent::get_file_name('.xml');

        $xml = Array2XML::createXML('AdWatchData', $this->AdWatchInfo_data);

        if($xml_output = $xml->save(FILES_OUT . "/xml/" . $xml_file_name)) {
            
            $log_message = 'INFO: The xml file ' . $xml_file_name . ' for adnumber ' . $this->adwatch_ad_number . ' was sucessfully created';
            parent::create_data_file('.log', $log_message);
            
        } else {
            
            $log_message = 'ERROR: The xml file ' . $xml_file_name . ' for adnumber ' . $this->adwatch_ad_number . ' could not be created';
            parent::create_data_file('.log', $log_message);
            
        }
        
        if(isset($_FILES)) {
            
            foreach($_FILES as $element_name => $v) {
                
                if(isset($element_name) && $_FILES[$element_name]['name'] != '') {
                    
                    $this->upload_file_attachment($element_name);
                    
                }
            }
        }
            
        if(isset($_FILES) && isset($_FILES['file_upload']['name']) && $_FILES['file_upload']['name'] != '') {
            
            $this->upload_file_attachment();
            
        }
        
        
    }

}

//**************************** End FIRST child class **************************************

class NxtendHTMLBrief extends PostData {

    public function __construct($post_array = false) {
        
        $this->post_array = $post_array;
        
        if($post_array) {
            
            parent::__construct( $post_array );
            
        }
        
    }
    
    private function _ad_type_stat_anim() {
        return $this->post_array['gad_stat_anim'][0] == 'static' ? $ad_type = 'stat' : $ad_type = 'anim';
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
    
    protected function brief_titles($form_section, $cnt = 0) {
        
        //** your details
        $brief_title['your_details'][0]['main_header']                 = '1.Booking Details';
        $brief_title['your_details'][0]['sub_header']                  = 'Your Details';
        $brief_title['your_details'][0]['your_details_first_name']     = 'First Name';
        $brief_title['your_details'][0]['your_details_last_name']      = 'Last Name';
        $brief_title['your_details'][0]['your_details_email']          = 'Email';
        $brief_title['your_details'][0]['your_details_phone']          = 'Phone';
        $brief_title['your_details'][0]['your_details_state']          = 'State';
        $brief_title['job_details'][0]['sub_header']                   = 'Job Details';
        $brief_title['job_details'][0]['job_details_due_date_live']    = 'Due date live';
        $brief_title['job_details'][0]['job_details_business_name']    = 'Business Name';
        $brief_title['job_details'][0]['job_details_business_website'] = 'URL';
        //$brief_title['job_details'][0]['job_details_due_date_proof']   = 'Due date proof';
        
        //** general asset details STATIC
        $brief_title['general_asset_details_stat'][0]['main_header']                = '2.General Asset Details';
        $brief_title['general_asset_details_stat'][0]['gad_stat_heading_intro_txt'] = 'Heading';
        $brief_title['general_asset_details_stat'][0]['gad_stat_url_txt']           = 'Click through URL';
        $brief_title['general_asset_details_stat'][0]['gad_add_comm_ta']            = 'Additional Comments';
        $brief_title['general_asset_details_stat'][0]['gad_utm_stat']               = 'UTM';
        
        //** general asset details ANIMATED
        $brief_title['general_asset_details_anim'][0]['main_header']       = '2.General Asset Details';
        $brief_title['general_asset_details_anim'][0]['gad_anim_frm1_txt'] = 'Frame 1';
        $brief_title['general_asset_details_anim'][0]['gad_anim_frm2_txt'] = 'Frame 2';
        $brief_title['general_asset_details_anim'][0]['gad_anim_frm3_txt'] = 'Frame 3';
        $brief_title['general_asset_details_anim'][0]['gad_anim_url_txt']  = 'Click through URL';
        $brief_title['general_asset_details_anim'][0]['gad_add_comm_ta']   = 'Additional Comments';
        $brief_title['general_asset_details_anim'][0]['gad_utm_anim']      = 'UTM';
        
        //** mobile banner STATIC
        $brief_title['mobile_banner_stat'][$cnt]['sub_header']                    = 'Mobile Banner - Static';
        $brief_title['mobile_banner_stat'][$cnt]['as_mob_stat_heading_intro_txt'] = 'Heading';
        $brief_title['mobile_banner_stat'][$cnt]['as_mob_stat_url_txt']           = 'Click through URL';
        $brief_title['mobile_banner_stat'][$cnt]['as_mob_stat_add_comm_ta']       = 'Additional Comments';
        $brief_title['mobile_banner_stat'][$cnt]['as_mob_stat_add_comm_ta']       = 'Additional Comments';
        $brief_title['mobile_banner_stat'][$cnt]['mob_utm_stat']                  = 'UTM';
        $brief_title['mobile_banner_stat'][$cnt]['as_mob_stat_proof_url_txt']     = 'Mobile Banner URL';
        
        //** mobile banner ANIMATED
        $brief_title['mobile_banner_anim'][$cnt]['sub_header']                = 'Mobile Banner - Animated';
        $brief_title['mobile_banner_anim'][$cnt]['as_mob_anim_frm1_txt']      = 'Frame 1';
        $brief_title['mobile_banner_anim'][$cnt]['as_mob_anim_frm2_txt']      = 'Frame 2';
        $brief_title['mobile_banner_anim'][$cnt]['as_mob_anim_frm3_txt']      = 'Frame 3';
        $brief_title['mobile_banner_anim'][$cnt]['as_mob_anim_url_txt']       = 'Click through URL';
        $brief_title['mobile_banner_anim'][$cnt]['as_mob_anim_add_comm_ta']   = 'Additional Comments';
        $brief_title['mobile_banner_anim'][$cnt]['mob_utm_anim']              = 'UTM';
        $brief_title['mobile_banner_anim'][$cnt]['as_mob_anim_proof_url_txt'] = 'Mobile Banner URL';
        
        //** mrec STATIC
        $brief_title['mrec_stat'][$cnt]['sub_header']                      = 'Medium Rectangle - Static';
        $brief_title['mrec_stat'][$cnt]['as_mrec_stat_heading_intro_txt']  = 'Heading';
        $brief_title['mrec_stat'][$cnt]['as_mrec_stat_url_txt']            = 'Click through URL';
        $brief_title['mrec_stat'][$cnt]['as_mrec_stat_add_comm_ta']        = 'Additional Comments';
        $brief_title['mrec_stat'][$cnt]['mrec_utm_stat']                   = 'UTM';
        $brief_title['mrec_stat'][$cnt]['as_mrec_stat_proof_url_txt']      = 'Medium Rectangle URL';
        
        //** mrec ANIMATED
        $brief_title['mrec_anim'][$cnt]['sub_header']                 = 'Medium Rectangle - Animated';
        $brief_title['mrec_anim'][$cnt]['as_mrec_anim_frm1_txt']      = 'Frame 1';
        $brief_title['mrec_anim'][$cnt]['as_mrec_anim_frm2_txt']      = 'Frame 2';
        $brief_title['mrec_anim'][$cnt]['as_mrec_anim_frm3_txt']      = 'Frame 3';
        $brief_title['mrec_anim'][$cnt]['as_mrec_anim_url_txt']       = 'Click through URL';
        $brief_title['mrec_anim'][$cnt]['as_mrec_anim_add_comm_ta']   = 'Additional Comments';
        $brief_title['mrec_anim'][$cnt]['mrec_utm_anim']              = 'UTM';
        $brief_title['mrec_anim'][$cnt]['as_mrec_anim_proof_url_txt'] = 'Medium Rectangle URL';
        
        //** leaderboard STATIC
        $brief_title['leaderboard_stat'][$cnt]['sub_header']                             = 'Leaderboard - Static';
        $brief_title['leaderboard_stat'][$cnt]['as_leaderboard_stat_heading_intro_txt']  = 'Heading';
        $brief_title['leaderboard_stat'][$cnt]['as_leaderboard_stat_url_txt']            = 'Click through URL';
        $brief_title['leaderboard_stat'][$cnt]['as_leaderboard_stat_add_comm_ta']        = 'Additional Comments';
        $brief_title['leaderboard_stat'][$cnt]['leaderboard_utm_stat']                   = 'UTM';
        $brief_title['leaderboard_stat'][$cnt]['as_leaderboard_stat_proof_url_txt']      = 'Leaderboard URL';
        
        //** leaderboard ANIMATED
        $brief_title['leaderboard_anim'][$cnt]['sub_header']                        = 'Leaderboard - Animated';
        $brief_title['leaderboard_anim'][$cnt]['as_leaderboard_anim_frm1_txt']      = 'Frame 1';
        $brief_title['leaderboard_anim'][$cnt]['as_leaderboard_anim_frm2_txt']      = 'Frame 2';
        $brief_title['leaderboard_anim'][$cnt]['as_leaderboard_anim_frm3_txt']      = 'Frame 3';
        $brief_title['leaderboard_anim'][$cnt]['as_leaderboard_anim_url_txt']       = 'Click through URL';
        $brief_title['leaderboard_anim'][$cnt]['as_leaderboard_anim_add_comm_ta']   = 'Additional Comments';
        $brief_title['leaderboard_anim'][$cnt]['leaderboard_utm_anim']              = 'UTM';
        $brief_title['leaderboard_anim'][$cnt]['as_leaderboard_anim_proof_url_txt'] = 'Leaderboard URL';
        
        //** landing page
        $brief_title['landing_page'][$cnt]['sub_header']                        = 'Landing Page';
        $brief_title['landing_page'][$cnt]['as_landing_page_select']            = 'Template';
        $brief_title['landing_page'][$cnt]['as_landing_page_heading_intro_txt'] = 'Headline';
        $brief_title['landing_page'][$cnt]['as_landing_page_description_ta']    = 'Description';
        $brief_title['landing_page'][$cnt]['as_landing_page_services_ta']       = 'Tags - Pixel Tracking';
        $brief_title['landing_page'][$cnt]['as_landing_page_address_txt']       = 'Address';
        $brief_title['landing_page'][$cnt]['as_landing_page_phone_txt']         = 'Phone';
        $brief_title['landing_page'][$cnt]['as_landing_page_email_txt']         = 'Email';
        $brief_title['landing_page'][$cnt]['as_landing_page_add_comm_ta']       = 'Additional Comments';
        $brief_title['landing_page'][$cnt]['as_landing_page_proof_url_txt']     = 'Landing Page URL';
        
        //** bespoke
        $brief_title['bespoke'][$cnt]['sub_header']               = 'Bespoke';
        $brief_title['bespoke'][$cnt]['as_bespoke_select']        = 'Bespoke Ad Unit';
        $brief_title['bespoke'][$cnt]['as_bespoke_add_comm_ta']   = 'Additional Comments';
        $brief_title['bespoke'][$cnt]['as_bespoke_proof_url_txt'] = 'Bespoke URL';
        
        $section_array = array();
        
        foreach ($brief_title[$form_section][$cnt] as $key) {
            
            array_push($section_array, $brief_title[$form_section][$cnt]);
            
        }
        
        return $section_array;
        
    }
    
    private function _generate_section_details($section, $cnt = 0) {
        
        $main_header_bg = '#6B8FC5';
        $sub_header_bg  = '#EDEEED';
        $sub_font_color = '#848484';
        
        $brief_title = $this->brief_titles($section, $cnt);
        
        $html = '';
        
        foreach ($brief_title[$cnt] as $key => $title) {
            
            if($key == 'main_header') {
                
                $html .= "<tr>";
                $html .=     "<td bgcolor=\"" . $main_header_bg . "\" colspan=\"2\" style=\"padding:5px 0px 5px 5px;\"><font color=\"white\"><b>" . $title . "</b></font></td>";
                $html .= "</tr>";
                
            } else if($key == 'sub_header') {
                
                $html .= "<tr>";
                $html .=     "<td colspan=\"2\" bgcolor=\"" . $sub_header_bg . "\" style=\"padding:5px 0px 5px 5px;\"><font color=\"" . $sub_font_color . "\"><b>" . $title . "</b></font></td>";
                $html .= "</tr>";
                
            } else if (isset($this->post_array[$key])) {
                
                if(strpos($key,"date")) {
                   $this->post_array[$key] = str_replace("/", "-", $this->post_array[$key]);
                }
                
                $html .= "<tr>";
                $html .=     "<td style=\"padding:5px 0px 5px 5px;\">" . $title . "</td>";
                $html .=     "<td style=\"padding:5px 0px 5px 5px;\">" . nl2br($this->post_array[$key]) . "</td>";
                $html .= "</tr>";
            }
        }
        
        return $html;
        
    }

    
    protected function _format_date($date_to_format) {
        
    }
    
    protected function create_html() {
        
        $main_color = '#6B8FC5';
        $sub_color = '#EDEEED';
        $sub_font_color = '#848484';
        
        $html  = "<html><head>";
        $html .= "</head><body style=\"font-family:Arial;\">";
        $html .= "<table align=\"center\" border=\"0\">";
        $html .= "<tr>";
        $html .=     "<td bgcolor=\"" . $main_color . "\" colspan=\"2\" align=\"center\" style=\"padding:5px 0px 5px 5px;\"><font color=\"white\"><b>CREATIVE BRIEF</b></font></td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .=     "<td width=\"195\" style=\"padding:5px 0px 5px 5px;\">Job Number</td>";
        $html .=     "<td width=\"500\" style=\"padding:5px 0px 5px 5px;\">" . $this->post_array['adnumber'] . "</td>";
        $html .= "</tr>";
        
        $options_selected = parent::get_options_selected();
        
        //** is the ad static or animated
        $ad_type = $this->_ad_type_stat_anim();
        
        $html .= $this->_generate_section_details('your_details');
        $html .= $this->_generate_section_details('job_details');
        $html .= $this->_generate_section_details('general_asset_details_' . $ad_type);
        $html .= "<tr bgcolor=\"" . $main_color . "\">";
        $html .=     "<td colspan=\"2\" style=\"padding:5px 0px 5px 5px;\"><font color=\"white\"><b>3.Asset Specifics</b></font></td>";
        $html .= "</tr>";
        
        if(is_array($options_selected)) {
            
            foreach($options_selected as $key => $value) {

                if($key == 'landing_page' || $key == 'bespoke') {
                    $html .= $this->_generate_section_details($key);
                    if($key == 'landing_page') {
                        $html .= "<tr>";
                        $html .=     "<td style=\"padding:5px 0px 5px 5px;\">Domain Name</td>";
                        $html .=     "<td style=\"padding:5px 0px 5px 5px;\">";
                        $html .=         "http://www." . strtolower(substr(str_replace(" ", "", $this->post_array['job_details_business_name']),0,12)) . ".com";
                        $html .=     "</td>";
                        $html .= "</tr>";                        
                    }
                } else {
                    $html .= $this->_generate_section_details($key . '_' . $ad_type);
                }
            }
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
        
        $to = $this->post_array['your_details_email'];
        $from = "newsxtendcreative@news.com.au";
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
    public function create_file($file_ext = false) {
        
        $html = $this->create_html();
        echo $html;
        parent::create_data_file('.html',$html);
                
        $this->_send_email($html);        
        
    }

}
class NxtendHTMLLandingPage extends PostData {

    public function __construct($post_array = false) {
        
        $this->post_array = $post_array;
        
        if($post_array) {
            parent::__construct( $post_array );
            $this->proof_url_list = $this->_set_proof_url_list();
            $this->create_file();
        }
        
    }
    
    public function get_proof_url_list() {
        return $this->proof_url_list;
    }
    
    private function _set_proof_url_list() {
        $proof_url_list = array();
        foreach($this->post_array as $key => $value) {
            if(strpos($key,'proof_url')) {
                if($value != '') {
                    $proof_url_list[$key] = $value;
                }
            }
        }
        return $proof_url_list;
    }
    
    private function _url_exists($url) {
        $headers = @get_headers($url);
        return is_array($headers) ? preg_match('/^HTTP\/\d+\.\d+\s+2\d\d\s+.*$/',$headers[0]) : 'false';
    }
    
    protected function create_html() {
        $html  = "";
        $html .= "<html><head>";
        $html .= "</head><body>";
        
        foreach($this->proof_url_list as $input_file_name => $url) {
            if(!strpos($input_file_name,'landing_page') && $this->_url_exists($url)) {
                $img_title  = get_img_title_array();
                $img_size   = getimagesize($url);
                $img_width  = $img_size[0];
                $img_height = $img_size[1];

                $html .= "<div style='margin:auto;width:" . $img_width . "px;'>";
                $html .= "<div>" . $img_title[$input_file_name] . "</div>";
                $html .= "<div><img src='" . $url . "' width='" . $img_width . "' height='" . $img_height . "' alt='' /></div><br style='clear:both' />";
                $html .= "</div>";
            } else if(strpos($input_file_name,'landing_page')) {
                $html .= "<div>" . $url . "</div>";
            } else {
                $html .= "<div>Invalid URL</div>";
            }
        }
        $html .= "</body></html>";
        return $html;
    }
    
    public function create_file() {
        
        $html = $this->create_html();
        
        //echo $html;
        
        parent::create_data_file('.html',$html,$landing_page = true);
        
    }
    
}
?>