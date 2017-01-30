<?php 
$page_title = "MediaSpectrum form to XML";
include CLASSES_PATH . '/class.FormElements.php';

$form_name = 'default';
$form_elements = new FormElements($form_name);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <title><?php echo $page_title ?></title>
  <meta http-equiv="cache-control" content="no-cache" />
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
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="<?php echo SCRIPTS_URL ?>/jquery/src/core.js"></script>
  <script src="<?php echo SCRIPTS_URL ?>/default.js"></script>
</head>
<body style="background-image:url(<?php echo IMAGES_URL ?>/sydney_1.jpg); background-repeat:repeat; background-color:#000000;">
    <div class="mainBodyContainer">
    <!--<div class="mainBodyContainer">-->
        <div class="mainPageWidthAndHeight" align="center" style="border:1px solid #000;">   
            <div class="noprint">	  
                <div><img src="<?php echo IMAGES_URL ?>/header.png" xwidth="1024" xheight="50" alt="" /></div>		                 
                <div class="line"><!--  --></div>
                <div class="links_container">
                    <div style="float:left;"></div>
                    <div style="float:right;padding-right: 5px ;"><a href="<?php echo ROOT_URL ?>/forms/default/links.php?links=1">Admin Only</a></div>
                </div>
	    </div>
  	    <div class="contentContainer">    
	  
	  