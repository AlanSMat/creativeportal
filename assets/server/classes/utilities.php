<?php 
function dump($array) {
	foreach($array as $key => $value) 
	{
		if(!is_array($array)) 
		{
			echo "Error: supplied value not an array";
			exit;
		}
		echo $key . " " . $value . "<br />";
	}
}

function add_prefix($prefix, $str_match, $post_vars) 
{  
  $form_data = "";
  foreach($post_vars as $key => $value) 
  {
    $key = str_replace("_", "-", $key);
    if (!preg_match("/" . $str_match . "/i", $key)) 
    {      
      $form_data["" . $prefix . "" . $key] = $value;
    }        
  }  
  return $form_data;
}

function remove_prefix($prefix, $post_vars) 
{  
  $form_data = "";
  foreach($post_vars as $key => $value) 
  {
    if (!preg_match("/" . $str_match . "/i", $key)) 
    {      
      $form_data["" . $prefix . "" . $key] = $value;
    } 
  }
  return $form_data;
}

function rt_date($timestamp) 
{	
  return date("d M Y", $timestamp);	
}

function check_isset($id) 
{
  if(isset($id)) 
  {
  	return $id;
  }
  else 
  {
  	return 0;
  }
  	
}

function testit() 
{
  echo "test";
}

class MyTest 
{
	public function __construct() 
	{
	  echo "tewst";
	}  
}
?>