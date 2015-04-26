<?php

$workPath = "/Extra/EDP";

// Check for Extra/include and model data folders
if(!is_dir("/Extra/include"))
   system("mkdir /Extra/include");
   
if(!is_dir("/Extra/include/Extensions"))
   system("mkdir /Extra/include/Extensions");
   
if(!is_dir("$workPath/model-data"))
   system("mkdir $workPath/model-data");
   
//
// Updating database on app start
//

echo "Updating EDP database, please wait...\n";

// backup and remove db if exists to update
if (file_exists("$workPath/bin/edp.sqlite3")) {
	system("rm -Rf $workPath/bin/backup/edp.sqlite3");
	system("cp $workPath/bin/edp.sqlite3 $workPath/bin/backup/edp.sqlite3");
	system("rm -Rf $workPath/bin/edp.sqlite3");
  }
    	
// download db
system("curl -o $workPath/bin/edp.sqlite3 http://www.osxlatitude.com/dbupdate.php");

// could not download then use backup!
if (!file_exists("$workPath/bin/edp.sqlite3")) {
	echo "Failed to update EDP database, using database from backup...\n";
    system("cp $workPath/bin/backup/edp.sqlite3 $workPath/bin/edp.sqlite3");
}
else {
	echo "Update success.\n";
}

include_once "html/edpconfig.inc.php";
include_once "html/functions.inc.php";

$os_string = "";
$os = getVersion();

// Start EDP
switch($os)
{
	case "sl":
	    system("open http://127.0.0.1:11250/");
	break;
	
	case "lion":
	case "ml":
	case "mav":
	case "yos":
		// EDP app is not being closed automatically after we click close
		// so we manually close this and open again when we launch it
		system("sudo killall EDP"); 
    	system("open $workPath/bin/EDPweb.app");
	break;
}

?>