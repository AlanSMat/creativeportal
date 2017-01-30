<?php 
$staticLink = null;
define("ROW_AS_ARRAY", 0); 
define("ROW_AS_OBJECT", 1); 
$default_method = ROW_AS_OBJECT;

class MySQL 
{
	public function __construct() 
	{
	
	}
	
	public function get_link() 
	{
		global $static_link; 

		if ($static_link) 
				return $static_link; 
		else 
				$this->report_error(); 
	}
	
	public function connect($db, $host, $user, $pass) 
	{
		global $static_link;
		 				 
		if(!$this->link = mysql_connect($host, $user, $pass)) 
		{			
			$this->report_error(); 
		} 
		
		if(!mysql_select_db($db, $this->link)) 
		{				
			$this->report_error();				
		} 
		else 
		{
			$this->db = $db;			
		} 
		
		$static_link = $this->link;		
	}
	
	/* 
	 * void report_error() 
	 */ 
	protected function report_error() 
	{
		echo "MySQL Error " . mysql_errno($this->link) . ": " . mysql_error($this->link);			 
		exit; 
	} 
	
}

class Query extends MySQL 
{
	public $result;
	
	public function __construct($query = false) 
	{	 
		$this->connect();
		$this->result = null;
		
		if($query) 
		{
			$this->query = $query;
			$this->result = $this->result($query);		
		}		
	}
	
	public function connect() 	
	{
		MySQL::connect(DATABASE, HOST, USERNAME, PASSWORD);
	}
	
	public function result($query) 
	{
	  /*
	   * IF NOT EXISTS (SELECT * FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_NAME = ‘TEST’ AND COLUMN_NAME = ‘TEST_DATE’)
BEGIN
   ALTER TABLE TEST ADD TEST_DATE DATETIME
END

	   * */			
		if($result = mysql_query($query, $this->link)) 
		{ 			
			if(preg_match("/^insert/", strtolower($query)))
			{ 
				return mysql_insert_id();
			} 
			elseif(preg_match("/^select/", strtolower($query)))
			{ 
				return $result;
			} 
			else
			{ 
				return;
			} 
		} 
		else 	
		{				
			MySQL::report_error(); 
		}
	}
	
	public function num_rows($result = false)
	{
		if(!$result) 
		{
			return mysql_num_rows($this->result);
		}
		else 		
		{
			return mysql_num_rows($result);
		}
	}

	public function next($method = -1) 
	{ 
			global $default_method; 
			if($method == -1) 
					$method = $default_method; 

			if($method == ROW_AS_OBJECT) 
					return $this->fetch_object_row(); 
			elseif($method == ROW_AS_ARRAY) 
					return $this->fetch_array_row(); 
	} 

	/* 
	 * object _fetch_object_row() 
	 */ 
	public function fetch_object_row() 
	{ 
			if(!($row = mysql_fetch_object($this->result))) 
					return false; 
			else 
					return $row; 
	} 

	/* 
	 * array _fetch_array_row() 
	 */ 
	public function fetch_array_row() 
	{ 
			if(!($row = mysql_fetch_array($this->result))) 
					return false; 
			else 
					return $row; 
	} 
	
	public function fetch_row_assoc() 
	{
	  $row = mysql_fetch_assoc($this->result);
	  $a = array();

		for ($i = 0; $i < mysql_num_fields($this->result); $i++) 
		{		
			$meta = mysql_fetch_field($this->result, $i); 
			$a["$meta->name"] = $row["$meta->name"];
		}
				
		if(count($a) > 0) 
		{
		  return $a;
		}
		else 
		{
		  echo "Error: empty fetch_row_assoc array";
		}
	}
	
	public function row_register_session($session_name) 
	{
		$session_name = $this->fetch_row_assoc();
		session_register("session_name");
	}
	 
	public function fetch_objects() 
	{ 
			$obj = Array(); 
			while($val = @mysql_fetch_object($this->result)) 
			{ 
					$obj[] = $val; 
			} 
			return $obj; 
	} 

	public function fetch_arrays() 
	{ 
			$arr = Array(); 
			while($val = @mysql_fetch_array($this->result)) 
			{ 
					$arr[] = $val; 
			} 
			return $arr; 
	} 
    
	public function num_fields() 
	{
	  return mysql_num_fields($this->result); 
	}
	
	public function fetch_fields($id_field) 
	{
	  if($id_field == "") 
	  {
	     echo "ERROR: missing fetch_fields id";
	     exit;
	  } 
	  
	  while($row = $this->next(ROW_AS_ARRAY))
	  {  
  	  for($i = 0; $i < $this->num_fields(); $i++) 
  	  {
  	    $meta = mysql_fetch_field($this->result, $i);
  	    $a[$meta->name][$row[$id_field]] = $row[$meta->name];
  	  }
	  }
	  return $a;
	}
	
	public function insert_record($table_name, $fields) {
	
		$fields = $this->get_table_array($table_name, $fields);
		
		if (is_array($fields)) {		
		
			$column_string = "";
			$value_string  = "";
			
			while(list($key,$value) = each($fields)) 
			{
				$columns[] = $key;
				$values[]  = $value;					
			}
			
			$num_cols = count($columns);
			$num_vals = count($values);
		
			for($i = 0;$i < $num_cols;$i++) 
			{
				$column_string .= $columns[$i];
				if($i < $num_cols-1) 
					$column_string .= ",";
			}
			
			for($i = 0;$i < $num_vals;$i++) 
			{
				$value_string .= "'$values[$i]'";
				if($i < $num_vals-1) 
					$value_string .= ",";
			}
	    
			$insert_string = "INSERT INTO ".$table_name." (".$column_string.") VALUES (".$value_string.")";
			
			//echo $insert_string . "<br />";
			
			return $insert_id = $this->result($insert_string);			
		}
	}	
	
	public function update_record($table_name, $array, $where_clause = false) 
	{
		if(!$where_clause) 
		{
			echo "Error: missing WHERE clause";
			exit;
		}
		
		$update_string = $this->get_update_string($table_name, $array);
		
		$query_string  = "UPDATE " . $table_name . " SET " . $update_string . " " . $where_clause . "";

		$query        = $this->result($query_string);
	}

	private function get_table_array ($table_name,$vars)
	{
		$prefix = substr_replace($table_name,"",3) . "_";
		
		foreach($vars as $key => $value) {
			if (preg_match("/^" . $prefix . "/", $key))
				$table_data[$key] = mysql_escape_string($value);			
		}	
	
		return $table_data;
	}
	
	private function get_update_string($table_name, $vars) 
	{
		$vars = $this->get_table_array($table_name, $vars);		
		
		$update_string = "";
		
		while(list($key,$value) = each($vars)) 
		{			
				if(is_array($value)) {				  
					$x=0;
					while(list($key2,$value2)=each($value)) 
					{
						$val_input .= $value2;
						if($x < count($value)-1) 
						{ 
							$val_input .= ",";$x++; 
						}
					}
					$columns[] = $key;
					$values[]  = $val_input;
					$x         = 0;
					$val_input  = "";
				}
				else 
				{
					$columns[] = $key;
					$values[]  = $value;
				}
		}
	
		$num_cols = count($columns);
		$num_vals = count($values);
		
		for($i=0;$i<$num_cols;$i++) 
		{
			$update_string .= $columns[$i] . "='" . $values[$i] . "'";
	
			if($i<$num_cols-1) 
				$update_string .= ", ";	
		}
		
		return $update_string;
	}

  public function escape_string($array) 
  {
    if(!is_array($array)) { die("ERROR: passed value not an array"); }
  
    foreach($array as $key => $value) 
    {
      $array[$key] = mysql_real_escape_string($value);
    }
    return $array;
  }
	
	public function find_duplicate($table, $field_name, $field_value) 
	{
	  $query_string = "SELECT * FROM " . $table . " WHERE " . $field_name . "='" . $field_value . "'";
	  $query = $this->result($query_string);		

	  if($this->num_rows($query) > 1) 
	  {
	    echo "ERROR: duplcate entry found";
	    exit;
	  }	  
	}
	
	public function save($table, $table_id, $id_value, $post_vars) 
	{
		$query_string = "SELECT * FROM " . $table . " WHERE " . $table_id . "='" . $id_value . "'";
		
		$query = $this->result($query_string);		
		 
		if($this->num_rows($query) < 1)
		{	 
			return $insert_id = $this->insert_record($table, $post_vars);
		}
		else 
		{	
			$this->update_record($table, $post_vars, "WHERE " . $table_id . "='" . $id_value . "'");
			return $id_value;
		}
	}
		
}

?>
