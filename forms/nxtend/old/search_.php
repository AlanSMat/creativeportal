<?php
require("../../globals.php");
include(INCLUDES_PATH . "/nxtend_header.php");

$json_dir = DOC_ROOT . "/forms/nxtend/json";

function parse_json_file($json_dir, $adnumber) {
    
    $json_file = file_get_contents($json_dir . "/" . $adnumber . ".js");
    $json_data = substr($json_file, 9, strlen($json_file));
    
    if (!$json_array = json_decode($json_data, true)) {
        echo trigger_error("error:there is a syntax error in the json file, please correct and try again");
    }

    return $json_array;
}

//parse_json_file($json_dir, 'test');

$files = new DirectoryIterator(DOC_ROOT . "/forms/nxtend/json");
$files_array = array();
?>
<style type="text/css">
    .outer_window_container{ padding: 10px 20px 20px 20px; margin:auto; width: 800px }
    .search_header{ font-weight: bold; }
</style>
<div class="outer_window_container">
    <table cellpadding="2" cellspacing="1" border="0" align="center">
        <tr>
            <td width="120">Order Number</td>
            <td width="320">Business Name</td>
            <td width="120">Due Date Live</td>
        </tr>
        <?php
        while($files->valid()) {
            $key = $files->getCTime();
            $data = $files->getFilename();
            $files_array[$key] = $data;
            $files->next();
        }
        
        rsort($files_array);
        $count = 0;
        foreach ($files_array as $key) {
            
            $ad_number = substr($key, 0, strrpos($key, '.js'));
            
            //echo $ad_number .  '<br />';
            
            if (strlen($ad_number) > 3) {

                
                $json_array = parse_json_file($json_dir, $ad_number, 'publication');
                ?>
                <tr>
                    <td><a href="<?php echo ROOT_URL ?>/forms/nxtend/form.php?adnumber=<?php print $ad_number ?>&search_adnumber=1"><?php print $ad_number ?></a></td>
                    <td><a href="<?php echo ROOT_URL ?>/forms/nxtend/form.php?adnumber=<?php print $ad_number ?>&search_adnumber=1"><?php echo $json_array['job_details_business_name'] ?></a></td>
                    <td><a href="<?php echo ROOT_URL ?>/forms/nxtend/form.php?adnumber=<?php print $ad_number ?>&search_adnumber=1"><?php echo $json_array['job_details_due_date_live'] ?></a></td>
                </tr>
                <?php
                $count++;
            }
            if($count >= 50) {
                break;
            }
        }
        ?>
    </table>    
</div>
<?php
include(INCLUDES_PATH . "/nxtend_footer.php");
?>