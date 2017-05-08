<?php 
/*
 * 2017-02-01 - Browser detection code added to prevent the user accessing the form when using Internet Explorer.
 * 
 *  */
$page_title = "MediaSpectrum form to XML";
include CLASSES_PATH . '/class.FormElements.php';

$form_name = 'default';
$form_elements = new FormElements($form_name);
//** check to see if it's a specific version of Internet Explorer used on News Ltd Windows 7 machines
strpos($_SERVER['HTTP_USER_AGENT'],'Chrome') == '' ? $user_agent = 'IE' : $user_agent = 'Chrome';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title><?php echo $page_title ?></title>
	<meta http-equiv="cache-control" content="max-age=0" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="expires" content="0" />
	<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
	<meta http-equiv="pragma" content="no-cache" />
	<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL ?>/default.css"  media="screen" />    
	<?php 
	if(isset($_REQUEST["adnumber"])) {
	?>
		<script src="<?php echo FORMS_URL ?>/<?php echo $form_name ?>/json/<?php print $_REQUEST["adnumber"] ?>.js"></script>
	<?php 
	}
	?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	
	
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>    
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script src="<?php echo SCRIPTS_URL ?>/jquery/src/core.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="<?php echo SCRIPTS_URL ?>/default.js"></script>
  <script src="<?php echo SCRIPTS_URL ?>/hide_show.js"></script>
</head>
<body style="background-image:url(<?php echo IMAGES_URL ?>/cpbg.png); background-repeat:no-repeat; background-attachment:fixed; background-position: 50% 100%; background-size: cover;">
    <?php 
    if(!isset($is_thank_you_page)) {
    ?>
    <div class="xmainBodyContainer">
    <!--<div class="mainBodyContainer">-->
        <div class="mainPageWidthAndHeight" align="center" style="border:1px solid #000;">   
            <div class="noprint">	  
                <div><img src="<?php echo IMAGES_URL ?>/header.png" xwidth="1024" xheight="50" alt="" /></div>		                 
                <div class="line"><!--  --></div>
                <div class="links_container">
                    <div style="float:left;"></div>
                    <div style="float:right;padding-right: 5px ;"><?php if($user_agent != 'IE') { ?><a href="<?php echo ROOT_URL ?>/forms/default/links.php?links=1">Admin Only</a><?php } ?></div>
                </div>
	    </div>
  	    <div class="contentContainer">
    <?php 
    }
    if($user_agent != 'Chrome') {
        ?>
        <div style="margin: 200px 0px 200px 0px;text-align: center; font-weight: bold; font-size: 18px">
            You are using an unsupported browser to access this form, please use Google Chrome
        </div>
        <?php
        exit;
    }
    ?>
	  
	  