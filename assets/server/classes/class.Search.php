<?php

class Search {

	public function __construct( $table = "", $post_vars = "", $order_by = "", $limit_from = "", $max_results = "" ) {
		
		$this->error_check($table);		
		$this->error_check($post_vars);		
		
		if($limit_from != "") {		
			$this->error_check($max_results);					
		}
		
		$this->table         = $table;
		$this->post_vars     = $post_vars;
		$this->prefix        = substr_replace($this->table, "" , 3);
		$this->order_by      = $order_by;
		$this->limit_from    = $limit_from;
		$this->max_results   = $max_results;
		$this->filtered_vars = $this->filter_vars();
		$this->search_string = $this->search_string();
		
	}

	private function error_check($var) 
	{
    	if($var == "") {			
    		echo "ERROR: missing argument";					
    		exit;
    	}	
	}
	
	private function filter_vars() {
							
		foreach($this->post_vars as $key => $value) {		
			if ( ereg( $this->prefix, $key )) {				
				if($value != "") {				
					$table_data[$key] = $value;						
				}			
			}				
		}	
		
		return $table_data;
		
	}
	
	private function display_filtered_vars() 
	{		
		foreach( $this->filtered_vars as $key => $value ) 
		{			
			echo $key . " " . $value . "<br>";			
		}
		
	}
	
	private function search_string() 
	{
		$i = 1;
		
		foreach( $this->filtered_vars as $key => $value ) 
		{					
			if( $i == 1 ) 
			{
			  if(ereg("operator", $key) || ereg("publication", $key) || ereg("edition", $key) || ereg("errortype", $key)) 
			  {				
				$search_string = "WHERE " . $key . " = '" . $value . "' ";
			  }
			  else 
			  {
			    $search_string = "WHERE " . $key . " LIKE '%" . $value . "%' ";
			  }					
			} 
			elseif( $i > 1) 
			{					
			  
			  if(ereg("operator", $key) || ereg("publication", $key) || ereg("edition", $key) || ereg("errortype", $key)) 
			  {				
				$search_string .= "AND " . $key . " = '" . $value . "' ";
			  }
			  else 
			  {
			    $search_string .= "AND " . $key . " LIKE '%" . $value . "%' ";
			  }				
			} 			
										
		  $i++;
		}
		
		if($this->order_by != "") 
		{
			$search_string .= "ORDER BY " . $this->order_by . " DESC ";
		}
	
		if($this->limit_from != "") {
			$search_string .= "LIMIT " . $this->limit_from . ", " . $this->max_results . " ";
		}
		
		return $search_string;
	
	}
	
	public function search_results() 
	{	  
	  $query = new Query("SELECT * FROM " . $this->table . " " . $this->search_string . "");
	  return $query;	
	}
	
	function expired_date() {
	
		return $expired_date = strtotime('last month');
	
	}
	
}


?>