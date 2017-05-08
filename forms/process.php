<?php
include("../globals.php");
include(CLASSES_PATH . '/class.MediaSpectrumBookingsXml.php');

//** looks for the asscii code of special characters and set's them to nothing
function convert_smart_quotes($string) { 
    
    $search = array(chr(34),
                    chr(95),
                    chr(96),
                    chr(123), 
                    chr(125),
                    chr(126),
                    chr(128),
                    chr(136),
                    chr(140),
                    chr(145), 
                    chr(146), 
                    chr(147), 
                    chr(148), 
                    chr(150),
                    chr(151),
                    chr(169)
                    ); 

    $replace = array('',
                     '',
                     '',
                     '', 
                     '',
                     '',
                     '',
                     '',
                     '',
                     '', 
                     '', 
                     '', 
                     '', 
                     '',
                     '',
                     '&copy;'
                    );     
    
        return str_replace($search, $replace, $string); 
    
} 

//$_POST['due_date'] = '';

if($_POST['due_date'] == '') {
    $date = new DateTime('now');
    $date->modify('+1 day');
    $_POST['due_date'] = $date->format('d/m/Y');            
}

//** checks to see if the post variable exists from the string passed
function is_isset($post_string) {
    if(isset($_POST[$post_string])) {
        return $post_string;
    } else {
        return '';
    }
}

$chk_for_special_chars[0] = is_isset('category_marketing_textarea');
$chk_for_special_chars[1] = is_isset('category_advertising_textarea');
$chk_for_special_chars[2] = is_isset('the_job_print_publication_textarea');
$chk_for_special_chars[3] = is_isset('the_job_project_name_text');
$chk_for_special_chars[4] = is_isset('whats_required');

for($i = 0; $i < count($chk_for_special_chars); $i++) {
    $_POST[$chk_for_special_chars[$i]] = convert_smart_quotes($_POST[$chk_for_special_chars[$i]]);
}
        
if(!isset($_POST['adnumber'])) {

    $_POST['adnumber'] = get_adwatch_ad_number($_POST['form_name']);

} else {

    $prefix = strtoupper(substr($_POST['category_radio'][0],0,1)); 
    $adnumber = substr($_POST['adnumber'],1);
    $_POST['adnumber'] = $prefix . $adnumber;

}

$_POST['current_date'] = date('m/d/Y');

//** the nxtend and default forms call 2 different files with a class of the same name
$creative_portal_bookings_xml = new BookingsXmlForMediaSpectrum($_POST);
$creative_portal_bookings_xml->create_xml();

$creative_portal_brief = new CreativeHTMLBrief($_POST);
$creative_portal_brief->create_file(isset($_POST['booking_updated']) ? $send_email = 1  : $send_email = 0 );

if($_SERVER["SERVER_NAME"] == "localhost")  {
    ?>
    <a href="links.php?form_name=<?php echo $_POST['form_name'] ?>">Links</a>
    <?php
} else {
    header("LOCATION: default/thank_you.php?adnumber=" . $_REQUEST['adnumber'] . "");
}
       
?>