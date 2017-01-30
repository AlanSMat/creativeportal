<?php

class upload_file {
	
	public function __construct($fileid = "", $files_array = "", $upload_dir = "", $file_name = "") {
      $this->fileid       = $fileid;
	  $this->files_array  = $files_array;
	  $this->upload_dir   = $upload_dir;
	  $this->file_name    = $file_name;
	  //$this->file_list    = $this->_file_list();	
	  //$this->file_details = $this->_file_details();
	  dump($files_array);		
	}
	
	public function upload() {	
	  // specify where the csv file will be uploaded to
	  $this->upload_dir = DOC_ROOT . "/" . $this->upload_dir;
			
	  $upload_file = $this->upload_dir . "/" . $this->files_array['name'];

	  echo $this->files_array['name'];
	  
	  if(!move_uploaded_file($this->files_array['tmp_name'], $upload_file)) {
		
	    return false;
			
	  } else {
			
		//$file_details['im_filename']  = $this->files_array['name'];
		//$file_details['im_imagename'] = $this->file_name;
			
	    if($this->fileid != "") {

	      return true;
				
	    } else {
			
		  
				
	    }
			
		  return true;
			
    }		
  }
}

?>
