<?php
include("../../globals.php");

function find_file() {
    
    //$folders_array['xml']  = '.xml';
    $folders_array['json'] = '.js';
    
    if(substr($_POST['adnumber'][0],0,1) == 'X') {
        
        //** strip off the X
        $_POST['adnumber'] = substr($_POST['adnumber'],'1', strlen($_POST['adnumber']));
        
    }
    
    foreach($folders_array as $folder => $extension) {
        
        $dir = new DirectoryIterator(DOC_ROOT . "/forms/nxtend/" . $folder . "");
        
        foreach ($dir as $fileinfo) {

            if (!$fileinfo->isDot()) {
                                
                $file = $_POST['adnumber'] . $extension;
                
                if($fileinfo->getFilename() == trim($file)) { 
                    
                    return $file;
                    
                    break;
                }
                
            }
        }
    }
}

function sanitize_file_name ($str = '') {

    //** get the extension
    $ext = substr($str, strrpos($str, '.'), strlen($str));

    if(strlen($str) > 20) {

        $str = substr($str, 0, 20);

        //** put the extension back onto the parsed string
        $str = $str . $ext;

    }

    $str = strip_tags($str); 
    $str = preg_replace('/[\r\n\t ]+/', ' ', $str);
    $str = preg_replace('/[\"\*\/\:\<\>\?\'\|]+/', ' ', $str);
    //$str = strtolower($str);
    $str = html_entity_decode( $str, ENT_QUOTES, "utf-8" );
    $str = htmlentities($str, ENT_QUOTES, "utf-8");
    $str = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $str);
    $str = str_replace(' ', '', $str);
    $str = rawurlencode($str);
    $str = str_replace('%', '', $str);

    return $str;

}

$file = find_file();

if($file != '') {
    
    $request_string = '?adnumber=' . $_POST['adnumber'];
    
} else if($_POST['adnumber'] != "" && $file == "") {

    $request_string = '?new_adnumber=' . sanitize_file_name($_POST['adnumber']);
    
} else {
    
    //$adnumber = get_adwatch_ad_number('nxtend');
    $request_string = '?new_adnumber=';
    
}

header("location: " . ROOT_URL . "/forms/nxtend/form.php" . $request_string . "");
?>
