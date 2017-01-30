<?php

function output_form_select($list, $select_id = "default") {

     $form_select_list = CONFIG_OUT . "/common/" . $list;
	 
	 ?>
	 
	 <select name="<?php print $select_id ?>" id="<?php print $select_id ?>">
	     <option value=""> -- select -- </option>
	     <?php
            if($file_handle = fopen($form_select_list,"r")) {

                 while( !feof($file_handle) ) {
                        $line = fgets($file_handle);
                        ?>
                        <option value="<?php print trim(str_replace(' ','_',$line)) ?>"><?php echo trim($line) ?></option>
                        <?php 
            } 
		
	} else {
				
		echo 'file does not exist';
		
	}
	?>
	</select>
	<?php
	 
}

function dump($array) {
    
    foreach($array as $key => $value) {
        
        echo $key . ' - ' . $value . '<br />';
        
        if(is_array($value)) {
            
           dump($value); 
            
        }
    }
}

//** generates an adnumber for MediaSpectrum
function get_adwatch_ad_number($form_name) {
    
    $adnumber_file = FILES_OUT . '/adnumber/adnumber.txt';
    
    //** get the adnumber from the file
    $adnumber = file_get_contents ( $adnumber_file );
    
    //** mofify the adnumber and write it back into the file.
    $new_ad_number = $adnumber + 1;
    
    //** write the new number back into the file
    file_put_contents($adnumber_file, $new_ad_number);
    
    switch ($form_name) {
        
        case 'default' :
            
            $prefix = strtoupper(substr($_POST['category_radio'][0],0,1)); 
            $_POST['form_prefix'] = $prefix;
            
            break;
        
        case 'nxtend' :
            
            //** prefix not being used when the adnumber is returned SM
            $prefix = 'X'; 
            $_POST['form_prefix'] = $prefix;
            
            break;
        
    }
    
    //** prefix not being used when the adnumber is returned SM
    return $prefix . $adnumber;
    //return $adnumber;
    
}

function get_img_title_array() {

    $img_titles['as_mob_stat_proof_url_txt']         = 'Mobile Banner';
    $img_titles['as_mrec_stat_proof_url_txt']        = 'Medium Rectangle';
    $img_titles['as_leaderboard_stat_proof_url_txt'] = 'Leaderboard';
    $img_titles['as_mob_anim_proof_url_txt']         = 'Mobile Banner';
    $img_titles['as_mrec_anim_proof_url_txt']        = 'Medium Rectangle';
    $img_titles['as_leaderboard_anim_proof_url_txt'] = 'Leaderboard';
    $img_titles['as_landing_page_proof_url_txt']     = 'Landing Page';
    $img_titles['as_bespoke_proof_url_txt']          = 'Bespoke';
    return $img_titles;
    
}  

function check_if_url_exists($url) {
    if (!$fp = curl_init($url)) return false;
    return true;
}

?>