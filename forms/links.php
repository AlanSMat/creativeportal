<?php
require("../globals.php");

include(INCLUDES_PATH . "/site_header.php");

$json_dir = DOC_ROOT . "/forms/" . $_REQUEST['form_name'] . "/json";

function parse_json_file($json_dir, $adnumber) {

    $json_file = file_get_contents($json_dir . "/" . $adnumber . ".js");
    
    $json_data = substr($json_file, 9, strlen($json_file));

    if (!$json_array = json_decode($json_data, true)) {

        echo trigger_error("error:there is a syntax error in the json file, please correct and try again");

    }

    return $json_array;
}

//parse_json_file($json_dir, 'test');

//echo date('m/d/Y');

$dir = new DirectoryIterator(DOC_ROOT . "/forms/" . $_REQUEST['form_name'] . "/json");

$files = array();
foreach ($dir as $fileinfo) {

    if (!$fileinfo->isDot()) {

        $ad_number = substr($fileinfo->getFilename(), 0, strrpos($fileinfo->getFilename(), $fileinfo->getExtension()) - 1);
        $files[substr($fileinfo->getFilename(),1,strlen($fileinfo->getFilename()))] = $fileinfo->getFilename();
    }
}
krsort($files);
?>

<style type="text/css">
    
    .lh { float:left; width:200px; clear:both; border:0px solid #000; }
    
</style>
<div style="padding-top:40px;">
    <table cellpadding="2" cellspacing="1" border="0" align="center">
        <tr>
            <td width="120">Job Number</td>
            <td width="120">Publication Date</td>
            <td width="170">Date Entered</td>
            <td width="170">Date Updated</td>
        </tr>
        <?php
        foreach ($files as $key => $value) {

            //if (!$fileinfo->isDot()) {

                $adnumber = substr($value, 0, strrpos($value,'.'));
                $json_array = parse_json_file($json_dir, $adnumber, 'publication');
                
                ?>
                <tr>
                    <td><a href="<?php echo ROOT_URL ?>/forms/default/index.php?adnumber=<?php print $adnumber ?>"><?php echo $adnumber ?></a></td>
                    <td><a href="<?php echo ROOT_URL ?>/forms/default/index.php?adnumber=<?php print $adnumber ?>"><?php echo $json_array['due_date'] ?></a></td>
                    <td><a href="<?php echo ROOT_URL ?>/forms/default/index.php?adnumber=<?php print $adnumber ?>"><?php isset($json_array['date_entered']) ? print $json_array['date_entered'] : print '' ; ?></a></td>
                    <td><a href="<?php echo ROOT_URL ?>/forms/default/index.php?adnumber=<?php print $adnumber ?>"><?php isset($json_array['date_updated']) ? print $json_array['date_updated'] : print '' ; ?></a></td>
                </tr>
                <?php

        //    }
        }
        ?>
    </table>    
</div>
<?php

include(INCLUDES_PATH . "/site_footer.php");
?>		
