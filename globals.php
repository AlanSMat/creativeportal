<?php
date_default_timezone_set("Australia/Sydney");
define("SITE_DIR", "creativeportal");

define("DOC_ROOT",$_SERVER['DOCUMENT_ROOT'] . '/' . SITE_DIR . "");
define("ROOT_URL","http://" . $_SERVER["SERVER_NAME"] . "/" . SITE_DIR . "");

define("NXTEND_TITLE",       "News Xtend");
define("MAIN_TITLE",         "Creative Portal");
define("COMPANY",            "News Limited");

define("FORMS_PATH",         DOC_ROOT   . "/forms");
define("FORMS_URL",          ROOT_URL   . "/forms");
define("LINKS_URL",          FORMS_URL  . "/links");
define("FILES_OUT",          DOC_ROOT   . "/files_out");
define("LOGS_OUT",           DOC_ROOT   . "/files_out/logs");
define("MATERIAL_OUT",       DOC_ROOT   . "/files_out/materials");
define("HTML_OUT",           DOC_ROOT   . "/files_out/html");
define("INCLUDES_PATH",      DOC_ROOT   . "/assets/server/includes");
define("SERVER_ASSETS_PATH", DOC_ROOT   . "/assets/server");
define("CLASSES_PATH",       SERVER_ASSETS_PATH . "/classes");
define("LIBS_PATH",          SERVER_ASSETS_PATH . "/libs");
define("HANDLERS_PATH",      DOC_ROOT."/assets/server/handlers");
define("SCRIPTS_URL",        ROOT_URL . "/assets/client/scripts");
define("IMAGES_URL",         ROOT_URL . "/assets/client/images");
define("ADMIN_URL",          ROOT_URL . "/admin");
define("CLIENT_URL",         ROOT_URL . "/assets/client");
define("CSS_URL",            ROOT_URL . "/assets/client/css");
define("XML_URL",            ROOT_URL . "/files_out/xml");
define("SITE_URL",           ROOT_URL . "/site");

include(CLASSES_PATH . "/class.JSONConfig.php");
include(HANDLERS_PATH . "/utils.php");


?>