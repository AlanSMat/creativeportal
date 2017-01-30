<?php
session_start();
require("../../globals.php");

include(INCLUDES_PATH . "/site_header.php");
?>

<?php
$json_dir = DOC_ROOT . "/forms/" . $_REQUEST['form_name'] . "/json";

$dir = new DirectoryIterator(DOC_ROOT . "/forms/" . $_REQUEST['form_name'] . "/json");
?>
<div style="padding:100px 2px 0px 250px;font-size:16px; xborder: 1px solid #000;width:300px;xborder:1px solid #000;margin:auto">
<?php
foreach ($dir as $fileinfo) {

    if (!$fileinfo->isDot()) {

        $ad_number = substr($fileinfo->getFilename(), 0, strrpos($fileinfo->getFilename(), $fileinfo->getExtension()) - 1);
        ?>
            <div style="float: left;width:100px"><a href="<?php echo ROOT_URL ?>/index.php?adnumber=<?php print $ad_number ?>"><?php echo $fileinfo->getFilename() ?></a></div>
            <div style="float:left"><?php ?></div><br />
            <?php
    }
}
?>
</div>
<?php
include(INCLUDES_PATH . "/site_footer.php");
?>		
