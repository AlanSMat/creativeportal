<?php
require("../globals.php");
include(INCLUDES_PATH . "/nxtend_header.php");

function parse_json_file($ad_number) {
    
    $json_dir = DOC_ROOT . "/forms/json";
    $json_file = file_get_contents($json_dir . "/" . $ad_number . ".js");    
    $json_data = substr($json_file, 9, strlen($json_file));
    
    if (!$json_array = json_decode($json_data, true)) {
        echo trigger_error("error:there is a syntax error in the json file, please correct and try again");
    }

    return $json_array;
}

function get_bg_color($i) {
    ($i % 2) ? $bg_color = "#E7EFF7" : $bg_color = "#F0FCFB" ;        
    return $bg_color;
}

$dir = new DirectoryIterator(DOC_ROOT . "/forms/json");
$files_array = array();

//** loop through files in the json directory and create and array so that it can be sorted
foreach ($dir as $file) {

    $ad_number = substr($file, 0, strrpos($file->getFilename(), '.js'));
    
    if (!$file->isDot() && (strlen($ad_number) > 3)) {
        
        if(isset($_POST['search']) && $_POST['search'] != '') {
            
            if(strtoupper(substr($_POST['search'],0,1)) == 'X') {
                $_POST['search'] = substr($_POST['search'],1);
            }
            
            $json_array = parse_json_file($ad_number);        
            $file_found = strpos($ad_number,trim($_POST['search']));
            if($file_found !== false) {
                $files_array[$ad_number] = $file->getMTime();
            }
        } else {
            $json_array = parse_json_file($ad_number);        
            $files_array[$ad_number] = $file->getMTime();
        }        
    }
    
}

//** array sorted by job_details_due_date_live high to low
arsort($files_array);
?>
<style type="text/css">
    .outer_window_container{ padding: 20px 20px 20px 20px; margin:auto; }
    .search_header{ font-weight: bold; }
    .blue_bg { background-color: #588ACA; }
    .header_title { color: white; font-size: 16px; }
    .lh { float:left; width:200px; clear:both; border:0px solid #000; }
    .search_container { padding: 20px 0px 40px 20px; }
    #search_box { width: 200px; float: left; }
    #search_button_container { width: 150px; float: left; height: 31px; }
    #search_button { width: 150px; float: left; height: 38px; cursor: pointer; }
    .table_header { background-color: #588ACA; color:#fff; font-weight: bold; height: 31px; text-align: center; }
    td { height: 31px; text-align: center; color: #000; }
</style>
<div class="outer_window_container">
    <div class="search_container">
        <form name="search_form" action="search.php" id="search_form" method="post">
            <div id="search_box"><input type="text" name="search" id="search" class="textBox" /></div>
            <div id="search_button_container"><input type="submit" name="search_button" id="search_button" class="button" value="Search" /></div>
        </form><br />
        <div style="padding-top:3px;">Enter adnumber or partial adnumber</div>
    </div><br style="clear:both" /> 
    <table cellpadding="10" cellspacing="1" border="0" align="center">
        <tr>
            <td width="120" class="table_header">Order Number</td>
            <td width="550" class="table_header">Business Name</td>
            <td width="120" class="table_header">Due Date Live</td>
            <!--<td width="120">Date Submitted</td>-->
        </tr>
        <?php
        $i = 0;
        foreach($files_array as $ad_number => $strtotime) {
            $json_array = parse_json_file($ad_number);
            $bg_color = get_bg_color($i);
            ?>
            <tr bgcolor="<?php echo $bg_color ?>">
                <td style="text-align:left;padding-left: 35px;"><a href="<?php echo ROOT_URL ?>/forms/form.php?adnumber=<?php print $ad_number ?>&search_adnumber=1">X<?php print $ad_number ?></a></td>
                <td style="text-align: left;"><a href="<?php echo ROOT_URL ?>/forms/form.php?adnumber=<?php print $ad_number ?>&search_adnumber=1"><?php echo $json_array['job_details_business_name'] ?></a></td>
                <td><a href="<?php echo ROOT_URL ?>/forms/form.php?adnumber=<?php print $ad_number ?>&search_adnumber=1"><?php echo $json_array['job_details_due_date_live'] ?></a></td>
                <!--<td><a href="<?php echo ROOT_URL ?>/forms/form.php?adnumber=<?php print $ad_number ?>&search_adnumber=1"><?php echo date("d/m/Y H",$strtotime) ?></a></td>-->
            </tr>
            <?php
            $i++;
        }        
        ?>
    </table>    
</div>
<?php
include(INCLUDES_PATH . "/nxtend_footer.php");
?>