<?php

class Xml 
{
  
  public function __construct($file_dir = false, $post_array = false, $out_dir = false) 
  {
    if(!$file_dir) 
    {
      echo "ERROR: File Directory missing"; 
      exit;
    }
    $this->file_dir = $file_dir;
    
    if(!$out_dir) 
    {
      $this->out_dir = $file_dir;
    }
    else 
    {
      $this->out_dir = $out_dir;
    }
    
    $this->post_array = $post_array;
    $this->array_count = 0;
  }  

  private function user_array() 
  {
    $user_array["ADV.Managers"] = "Advertising_Manager";
    $user_array["ADV.Sales"] = "Advertising_Manager";
  }
   
  private function create_element($dom, $parent, $element_name) 
  {
    $element = $dom->createElement($element_name);
    $dom->appendChild($parent); 
    return $dom;   
  }
  
  public function write() 
  {
    $job_role = str_replace(" ", "", $this->post_array["job-role"]);
    $job_title = str_replace(" ", "", $this->post_array["job-title"]);
        
    $file = $job_role . "_" . $this->post_array["login-name"] . "_D"  . date("dmy") . "T"  . date("Gis") . "_UID" . uniqid() . ".xml"; 
        
    $dom = new DOMDocument('1.0','UTF-8');
    
    $AdUserData = $dom->createElement("AdUserData");   
    $dom->appendChild($AdUserData); 

    $xmlns = $dom->createAttribute("xmlns:xsi");
    $AdUserData->appendChild($xmlns);
    
    $xmlns_value = $dom->createTextNode("http://www.w3.org/2001/XMLSchema-instance");
    $xmlns->appendChild($xmlns_value);
    
    $User = $dom->createElement("User");   
    $AdUserData->appendChild($User); 
    
    foreach($this->post_array as $key => $value) 
    {
      if($key != "SystemTranslatorString" && $key != "job-role") 
      {
        //if(($this->post_array["SystemTranslatorString"][$this->array_count] != "")) 
        //{
        if($key == "login-name" || $key == "email-address") 
        {        
          $element = $dom->createElement($key, $value);          
          $doNotUpdate = $dom->createAttribute("doNotUpdate");
          
          $doNotUpdate_value = $dom->createTextNode("1");
          $doNotUpdate->appendChild($doNotUpdate_value);
          
          $element->appendChild($doNotUpdate);
          $User->appendChild($element);
        }
        else 
        {
          $value = trim($value);
          $value = str_replace("&", "&amp;", $value);
          //$value = str_replace("'", "&apos;", $value);
          if(preg_match("/\'/", $value)) 
          {
            $value = preg_replace("/\'/", "&apos;", $value);
            //$value = str_replace("'", "&apos;", $value);
            echo $value . " Matched!" . "<br />";
          }
        //  $value = str_replace("'", "&quot;", $value);
          
          $element = $dom->createElement($key, trim($value));            
          $User->appendChild($element);         
        }
        //}       
      }
      elseif($key == "SystemTranslatorString" && $key != "job-role") 
      {
        $translate_added = false;
        if(isset($this->post_array["SystemTranslatorString"][$this->array_count]) && ($this->post_array["SystemTranslatorString"][$this->array_count] != "")) 
        {
          for($i = 0; $i < count($this->post_array["SystemTranslatorString"]); $i++) 
          {
            if($this->post_array["SystemTranslatorString"][$i] != "") 
            {
              $SystemTranslatorString = $dom->createElement($key, trim($this->post_array["SystemTranslatorString"][$i]));   
              $User->appendChild($SystemTranslatorString);  
            }
          }
          $translate_added = true;
        }
        else 
        { 
          $SystemTranslatorString = $dom->createElement($key, "");   
          $User->appendChild($SystemTranslatorString);
        }
        
        /*else if(!isset($this->post_array["SystemTranslatorString"][$this->array_count])) 
        {
          $SystemTranslatorString = $dom->createElement($key, "");   
          $User->appendChild($SystemTranslatorString);            
        }*/
      }
    }
    
    $job_role_folder = $job_role;
    
    $out_xml = $dom->saveXML();
    $this->create_xml_file($file, $job_role_folder, $out_xml, $translate_added); 
  }
  
  private function make_dir($folder_path) 
  {
    if(!is_dir($folder_path)) 
    {
      mkdir($folder_path);
    }
  }
  
  private function create_xml_file($file, $job_role_folder, $out_xml, $translate_added) 
  {
    if($translate_added) 
    {
      $folder_path = "" . $this->out_dir . "/" . $job_role_folder . "";
      $this->make_dir($folder_path);
    }
    
    
    $xml = new DOMDocument();
    $xml->preserveWhiteSpace = false;
    $xml->formatOutput = true;
    $xml->loadXML($out_xml);
    $out_xml = $xml->saveXML(); 
    
    $file = fopen(DOC_ROOT . "/" . $folder_path . "/" . $file . "", "w") or die("can't open file");
    fwrite($file, $out_xml);
    fclose($file);
         
  }
  
  public function change_node_value($node_name = false, $node_value = false, $files_to_process = false) 
  {
    if(!$node_name) 
    {
      echo "ERROR: xml node name missing";
      exit;
    }

    if(!$node_value) 
    {
      echo "ERROR: xml node value missing";
      exit;
    }
    
    $files_array = $this->create_files_array($files_to_process);
          
    if(!$files_to_process) 
    {
      $files_to_process = count($files_array); 
    }
    
    $doc = new DOMDocument();

    $node_prefix = "";
    
    for($i = 0; $i < count($files_array); $i++) 
    {
      if (substr($files_array[$i], 0, 1) != ".") // don't list hidden files
      {
        switch(substr($files_array[$i], 0, 4)) 
        {
          case "Book":
            $node_prefix = "NMBS";
            break;
          case "CNG ":
            $node_prefix = "CybC";
            break;
          case "NWN ":
            $node_prefix = "CybN";
            break;  
          default:
            $node_prefix = "CybN";
            break;
        }
        
        $file_in = $this->file_dir . "/" . $files_array[$i]; 
        $doc->load($file_in);
                   
        $file_out = $node_prefix . $node_value . ".xml";

        $booking_node = $doc->getElementsByTagName($node_name[0]);
        $booking_node->item(0)->nodeValue = $node_prefix . $node_value;

        $booking_node = $doc->getElementsByTagName($node_name[1]);
        $booking_node->item(0)->nodeValue = $node_value;
        
        $this->create_file($file_out, $doc->saveXML());
        $node_value = $node_value + 1;
        
        //unlink($file_in);        
      }
    }
    
    setcookie("order_number", $node_value, time()+3600);
  }
  
  private function create_files_array() 
  {     
    // open this directory 
    $dir = opendir($this->file_dir);
    
    // get each entry
    while($entry_name = readdir($dir)) {
    	$dir_array[] = $entry_name;
    }
    
    return $dir_array;
    
  }
  
  private function write_into_batch_file($xml_file_name) 
  {
    $sftp_string = "cd /opt/mediaspectrum/Pre-Proc/xml/" . $this->post_array["job-function"] . "\n";
    $sftp_string .= "mput xml/AD*.xml\n";    
    $sftp_string .= "bye \n";
    $sftp_string .= "cd \Inetput\wwwroot\msuserform\xml\ \n";
    $sftp_string .= "del Ad*.xml";

    $sftp_file = fopen(DOC_ROOT . "/sftp_login.txt", "w") or die("can't open file");
    fwrite($sftp_file, $sftp_string);
    fclose($sftp_file);
    //$this->upload();        
  }
    
  private function upload() 
  {
    $computername = "10.68.92.5";
    $ip = gethostbyname($computername);
    exec("psftp mediaspec@10.68.11.73 -pw news -b sftp_login.txt", $output);
    print_r($output);
    
    //$command = "c:\Inetpub\wwwroot\msuserform\psftp.exe psftp mediaspec@10.68.11.73 -pw news -b sftp_login.txt";
    //exec($command);
    
    //$exec = exec("runpsftp.cmd");
  }
  
}

?>