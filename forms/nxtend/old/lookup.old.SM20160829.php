<?php
include("../../globals.php");

function find_file_match() {
    
    //$folders_array['xml']  = '.xml';
    $folders_array['json'] = '.js';
    
    if(isset($_POST['adnumber']) && $_POST['adnumber'] != '') {
    
        if(substr($_POST['adnumber'][0],0,1) == 'X') {

            //** strip off the X
            $_POST['adnumber'] = substr($_POST['adnumber'],'1', strlen($_POST['adnumber']));
			$_POST['adnumber'] = sanitize_file_name ($_POST['adnumber']);

        } else {
		
			$_POST['adnumber'] = sanitize_file_name ($_POST['adnumber']);
		
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
    } else {
	
        return '';
		
    }
}

function sanitize_file_name ($str = '') {
    
    if(strlen($str) > 16) {

        $str = substr($str, 0, 16);

    }
	
	//$str = preg_replace('/\D/', '', $str);
		
    $str = strip_tags($str); 
    $str = preg_replace('/[\r\n\t ]+/', ' ', $str);
    $str = preg_replace('/[\"\*\/\:\<\>\?\'\|]+/', ' ', $str);
    //$str = strtolower($str);
    $str = html_entity_decode( $str, ENT_QUOTES, "utf-8" );
    $str = htmlentities($str, ENT_QUOTES, "utf-8");
    $str = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $str);
    $str = str_replace(' ', '', $str);
    $str = str_replace('%', '', $str);
    $str = str_replace('(', '', $str);
    $str = str_replace(')', '', $str);
    $str = str_replace(',', '', $str);
    $str = str_replace('$', '', $str);
    $str = str_replace('+', '', $str);
    $str = str_replace('\\', '', $str);
    $str = str_replace('-', '', $str);
    $str = str_replace('!', '', $str);
    $str = str_replace('@', '', $str);
    
    return $str;

}

$found_file_match = find_file_match();

if($found_file_match != '') {
    
    $request_string = '?adnumber=' . sanitize_file_name($_POST['adnumber']);
    
} else if($_POST['adnumber'] != "" && $found_file_match == "") {

    $request_string = '?new_adnumber=' . sanitize_file_name($_POST['adnumber']);
    
} else {
    
    $request_string = '?new_adnumber=';
    
}

header("location: " . ROOT_URL . "/forms/nxtend/form.php" . $request_string . "");
?>
