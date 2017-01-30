<?php

function form_select($list, $select_id = "default") {
    
     $form_select_list = CONFIG_OUT . "/" . $list;
	 
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
  //fclose($file_handle);
  ?>