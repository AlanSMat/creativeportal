<?php 
header("LOCATION : http://premwebprod01/nxtend/forms/index.php");
$page_title = NXTEND_TITLE;
define('NXTEND_IMAGES_URL', IMAGES_URL.'/nxtend');
define('NXTEND_JSON_URL', FORMS_URL .'/nxtend/json');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <title><?php echo $page_title ?></title>
  <meta http-equiv="cache-control" content="no-cache" />
  <meta http-equiv="pragma" content="no-cache" />
  <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL ?>/nxtend.css"  media="screen" />    
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
  <script src="<?php echo SCRIPTS_URL ?>/hide_show.js"></script>
  <script src="<?php echo SCRIPTS_URL ?>/common.js"></script>
  <style type="text/css">
      body { background-image: url("<?php echo IMAGES_URL ?>/nxtend/bg_dots.gif"); repeat:repeat;}	
  </style>
  <?php 
  if(isset($_REQUEST['adnumber'])) {
  ?>
      <script src="<?php echo NXTEND_JSON_URL ?>/<?php echo $_REQUEST['adnumber'] ?>.js"></script>
  <?php
  }
  ?>
</head>
<body>
    <div class="mainBodyContainer">
        <div style="background-image:url(<?php echo NXTEND_IMAGES_URL ?>/bg.jpg); background-repeat:no-repeat; width:1280px;margin:auto;margin-top:58px;background-color:#000;">
            <div class="title_box">
                <div class="title_left_image"><a href="index.php" border="0" /><img src="<?php echo NXTEND_IMAGES_URL ?>/news-xtend.png" width="227" height="61" alt="" /></a></div>		 
                <div class="title_right_image"><img src="<?php echo NXTEND_IMAGES_URL ?>/txt-request-job.png" width="230" height="31" alt="" /></div>		 
            </div>
            <div class="content">
                <div class="page_container">          
      
      
	  