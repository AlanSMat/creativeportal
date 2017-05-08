<?php
require("../../globals.php");

include(INCLUDES_PATH . "/site_header.php");

$json_dir = DOC_ROOT . "/forms/default/json";

function parse_json_file($json_dir, $adnumber) {

    $json_file = file_get_contents($json_dir . "/" . $adnumber . ".js");
    
    $json_data = substr($json_file, 9, strlen($json_file));

    if (!$json_array = json_decode($json_data, true)) {

        echo trigger_error("error:there is a syntax error in the json file, please correct and try again");

    }

    return $json_array;
}

//** json file directory
$dir = new DirectoryIterator(DOC_ROOT . "/forms/default/json");

$files = array();

//** loop through json directory and write file numbers into an array so that it can be sorted
foreach ($dir as $fileinfo) {

    if (!$fileinfo->isDot()) {

        $ad_number = substr($fileinfo->getFilename(), 0, strrpos($fileinfo->getFilename(), $fileinfo->getExtension()) - 1);
        
        if(isset($_POST['search']) && $_POST['search'] != '') {
            
            $file_name = trim($fileinfo->getFilename());
            $file_found = strpos($file_name,trim($_POST['search']));
            
            if($file_found !== false) {
            
                $files[substr($fileinfo->getFilename(),1,strlen($fileinfo->getFilename()))] = $file_name;
                
            }
            
        } else {
            
            $files[substr($fileinfo->getFilename(),1,strlen($fileinfo->getFilename()))] = $fileinfo->getFilename();
            
        }
        
    }
}

//** sort files so that the latest adnumber is at the top
krsort($files);

function get_bg_color($i) {
    ($i % 2) ? $bg_color = "#E7EFF7" : $bg_color = "#cccccc" ;        
    return $bg_color;
}

?>

<style type="text/css">
    
    .lh { float:left; width:200px; clear:both; border:0px solid #000; }
    .search_container { padding: 20px 0px 20px 20px; }
    #search_box { width: 190px; float: left; }
    #search_button { width: 150px; float: left; height: 31px; }
    .table_header { background-color: #0092CB; color:#fff; font-weight: bold; height: 31px; text-align: center; }
    td { height: 31px; text-align: center; color: #000; }
    a { color:#000; }
    
        
</style>
<div class="search_container">
    <form name="search_form" action="links.php" id="search_form" method="post">
        <div id="search_box"><input type="text" name="search" id="search" class="textBox" /></div>
        <div id="search_button"><input type="submit" name="search_button" id="search_button" class="button" value="Search" /></div>
    </form>
</div>    
<div style="padding-top:40px;padding-bottom: 50px">
    <table cellpadding="2" cellspacing="1" border="0" align="center">
        <tr>
            <td width="120" class="table_header">Job Number</td>
            <td width="150" class="table_header">Region</td>
            <td width="150" class="table_header">Publication Date</td>
            <td width="170" class="table_header">Date Entered</td>
            <td width="170" class="table_header">Date Updated</td>
        </tr>
        <?php
        $i = 0;
        
        function get_date_string($date_array) {
            
            $date_array = explode(':',$date_array);
            $date_string = $date_array[0] . ':' . $date_array[1];
            
            return $date_string;
        }
        
        foreach ($files as $key => $value) {
            
            $bg_color = get_bg_color($i);
            $adnumber   = substr($value, 0, strrpos($value,'.'));
            $json_array = parse_json_file($json_dir, $adnumber, 'publication');
            
            ?>
            <tr bgcolor="<?php echo $bg_color ?>">
                <td><a href="<?php echo ROOT_URL ?>/forms/default/index.php?adnumber=<?php print $adnumber ?>"><?php echo $adnumber ?></a></td>
                <td style="text-align: left;padding-left: 10px"><a href="<?php echo ROOT_URL ?>/forms/default/index.php?adnumber=<?php print $adnumber ?>"><?php echo str_replace('_', ' ', $json_array['state']) ?></a></td>
                <td><a href="<?php echo ROOT_URL ?>/forms/default/index.php?adnumber=<?php print $adnumber ?>"><?php echo $json_array['due_date'] ?></a></td>
                <td><a href="<?php echo ROOT_URL ?>/forms/default/index.php?adnumber=<?php print $adnumber ?>"><?php isset($json_array['date_entered']) ? print get_date_string($json_array['date_entered']) : print '' ; ?></a></td>
                <td><a href="<?php echo ROOT_URL ?>/forms/default/index.php?adnumber=<?php print $adnumber ?>"><?php isset($json_array['date_updated']) ? print get_date_string($json_array['date_updated']) : print '' ; ?></a></td>
            </tr>
            <?php
            $i++;
        }
        ?>
    </table>    
</div>
<?php
unset($_POST);
include(INCLUDES_PATH . "/site_footer.php");
?>		
