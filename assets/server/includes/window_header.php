<?php 
if(isset($page_title) && $page_title != "QC Issues - Index") 
{
  header('Cache-Control: no-store, no-cache, must-revalidate');
}

if(isset($_REQUEST['type'])) 
{
  $type = $_REQUEST["type"];
}
else 
{
  $type = "desktop";
}

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title><?php isset($page_title) ? print $page_title : print "Untitled" ; ?></title>
  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="pragma" content="no-cache">
  <style type="text/css">
	  #<?php echo $page_id ?> {
		  float:left;
		  padding:2px 0px 2px 0px;
		  width:125px;
		  text-align:center;
		  background-color:#ccc;
		  color:#000;
		  cursor:pointer;
		  border: 1px solid #ccc;
		  xborder-right:0px;			
	  }
		
	  a.remake {
		  color:#0000ff;
		  text-decoration:underline;
		  padding-left:10px;
	  }
	  
    .gradbg 
    {
      background-image:url('images/topgrad.gif');
    }
	  
  </style>  
  <script type="text/javascript" src="<?php echo SCRIPTS_URL ?>/common.js"></script>
  <script type="text/javascript" src="<?php echo SCRIPTS_URL ?>/form_validation.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL ?>/default.css"  media="screen" />    
  <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL ?>/print.css" media="print" />    
</head>
<body>
  <div class="mainBodyContainer">
    <div class="mainPageWidthAndHeight" align="center">   
      <div class="noprint">
	  	<table cellpadding="0" cellspacing="0" border="0" width="100%">
	  	  <tr>
	  	    <td class="bannerbg" align="left"><img src="<?php echo IMAGES_URL ?>/NWNBanner.jpg"width="314" height="35" alt="" /></td>
		  </tr>
		  <tr>
		    <td background="<?php echo IMAGES_URL ?>/topgrad.gif">  	 	  
			  <div class="mainTitle"><b>Chullora Computer Assets</b></div>
			</td>
		  </tr>
		</table>
		<div class="navTopContainer">
		  <div class="navItemTop" id="close" style="border-right:1px outset #ccc;float:left;" onMouseOut="this.className='navItemTop'" onMouseOver="this.className='navItemOverTop'" onClick="window.close()">Close</div>
		  <div class="clear">&nbsp;</div>
	    </div><!-- end navTopContainer -->
	  </div><!-- end noprint -->   