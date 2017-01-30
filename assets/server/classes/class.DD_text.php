<?php
/*class DD_Get_Details 
{
  public function __construct($row) 
  {
    $this->row = $row;
  }
  
  protected function dd_details() 
  {
          
  }  
}*/
class DD_text //extends DD_Get_Details 
{ 
  public function __construct($row) 
  {
    $this->row = $row;
  }

  public function dd_item($db_table, $db_id, $dd_id) 
  {
    $q = "SELECT * FROM " . $db_table . " WHERE " . $db_id . "='" . $dd_id . "'";

    $query = new Query($q);
    
    if($query->num_rows() < 1) 
    {
    	return "";
    }
    else 
    {    	
    	return $row = $query->next();
    }
  }
}

?>