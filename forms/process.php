<?php
session_start();
include("../globals.php");

switch ($_POST['form_name']) {

    case 'default' :
        
        if(!isset($_POST['adnumber'])) {
            
            $_POST['adnumber'] = get_adwatch_ad_number($_POST['form_name']);
            
        } else {
            
            $prefix = strtoupper(substr($_POST['category_radio'][0],0,1)); 
            $adnumber = substr($_POST['adnumber'],1);
            $_POST['adnumber'] = $prefix . $adnumber;
            
        }
        
        include(CLASSES_PATH . '/class.MediaSpectrumBookingsXml.php');
        
        break;
    
    case 'nxtend' :
        
        if(isset($_POST['job_details_order_number']) && $_POST['job_details_order_number'] != '') {
            
            if(substr($_POST['adnumber'][0],0,1) != 'X') {
        
                //** put an X in front of it for MS searching
                $_POST['adnumber'] = 'X' . $_POST['job_details_order_number'];

            }
        }
        
        include(CLASSES_PATH . '/class.NxtendMediaSpectrumBookingsXml.php');
        break;
    
}

$_POST['current_date'] = date('m/d/Y');

//** the nxtend and default forms call 2 different files with a class of the same name
$creative_portal_bookings_xml = new BookingsXmlForMediaSpectrum($_POST);
$creative_portal_bookings_xml->create_xml();

switch ($_POST['form_name']) {
    
    case 'default' :
        
        $creative_portal_brief = new CreativeHTMLBrief($_POST);
        $creative_portal_brief->create_file(isset($_POST['booking_updated']) ? $send_email = 1  : $send_email = 0 );
        
        if($_SERVER["SERVER_NAME"] == "localhost")  {
            ?>
            <a href="links.php?form_name=<?php echo $_POST['form_name'] ?>">Links</a>
            <?php
        } else {
            header("LOCATION: default/thank_you.php?adnumber=" . $_REQUEST['adnumber'] . "");
        }
        
        break;
    
    case 'nxtend' :
        
        $nxtend_html_brief = new NxtendHTMLBrief($_POST);
        $nxtend_html_brief->create_file();
        
        if($_SESSION['is_ad_update']) {
            $nxtend_landing_page = new NxtendHTMLLandingPage($_POST);
            $_SESSION['proof_url_list'] = $nxtend_landing_page->get_proof_url_list();
            if($_SERVER["SERVER_NAME"] == "localhost") {
            ?>
                <br/><a href="<?php echo ROOT_URL ?>/forms/nxtend/proof.php?adnumber=<?php echo $_POST['adnumber'] ?>">Proof</a><br/>
            <?php
            } else {
                header("location: " . ROOT_URL . "/forms/nxtend/proof.php?adnumber=" . $_POST['adnumber'] . "");
            }
        }
        
        if($_SERVER["SERVER_NAME"] == "localhost")  {
            ?>
            <br/><a href="nxtend/index.php">Nxtend Index</a><br/><br/><br/><br/>
            <?php
            exit;
            
        } else {
            
            header("location: " . ROOT_URL . "/forms/nxtend/thank_you.php?form_name=" . $_POST['form_name'] . "");
            
        }
        
        break;
    
}
?>