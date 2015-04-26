<?php

// Main vars
$workPath 		= "/Extra/EDP";
$svnpackPath 	= "$workPath/svnpacks";
$modelDataPath	= "$workPath/model-data";
$appsPath 		= "$workPath/apps";
$logsPath 		= "$workPath/logs";

$edpversion = "6.0 beta";
$verbose    = "no";	

$eePath     = "/Extra/Extensions";		
$rootPath   = "/";
$slePath    = "/System/Library/Extensions";	
$cachePath  = "/System/Library/Caches/com.apple.kext.caches/Startup";
$incPath    = "/Extra/include";


// SQLite stuff :) which is accessed globally by every php file
$edp_db = new PDO("sqlite:/$workPath/bin/edp.sqlite3");
$edp_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Populate Chameleon boot array
$stmt = $edp_db->query("SELECT * FROM chameBoot order by id");
$stmt->execute(); $chameBootdb = $stmt->fetchAll();

// Populate Audio array
$stmt = $edp_db->query("SELECT * FROM audio order by id");
$stmt->execute(); $audiodb = $stmt->fetchAll();

// Populate Battery array
$stmt = $edp_db->query("SELECT * FROM battery order by id");
$stmt->execute(); $batterydb = $stmt->fetchAll();

// Populate Ethernet array
$stmt = $edp_db->query("SELECT * FROM ethernet order by id");
$stmt->execute(); $landb = $stmt->fetchAll();
$_SESSION['landb'] = $landb;

// Populate Wifi array
$stmt = $edp_db->query("SELECT * FROM wifi order by id");
$stmt->execute(); $wifidb = $stmt->fetchAll();

// Populate PS2 array
$stmt = $edp_db->query("SELECT * FROM ps2 order by id");
$stmt->execute(); $ps2db = $stmt->fetchAll();

// Populate Fakesmc array
$stmt = $edp_db->query("SELECT * FROM fakesmc order by id");
$stmt->execute(); $fakesmcdb = $stmt->fetchAll();

// Populate cpufixes array
$stmt = $edp_db->query("SELECT * FROM pmfixes order by id");
$stmt->execute(); $cpufixdb = $stmt->fetchAll();

// Populate fixes array
$stmt = $edp_db->query("SELECT * FROM sysfixes order by id");
$stmt->execute(); $fixesdb = $stmt->fetchAll();

// Populate Chameleon mods array
$stmt = $edp_db->query("SELECT * FROM chammods order by id");
$stmt->execute(); $chamdb = $stmt->fetchAll();

// Populate Optional packs array
$stmt = $edp_db->query("SELECT * FROM optionalpacks order by id");
$stmt->execute(); $optdb = $stmt->fetchAll();

$localrev 	= exec("cd $workPath/bin; svn info --username osxlatitude-edp-read-only --non-interactive | grep -i \"Last Changed Rev\"");
$localrev 	= str_replace("Last Changed Rev: ", "", $localrev);

// Include general functions and classes
require_once "$workPath/bin/html/functions.inc.php";

// Set timezone to UTC
date_default_timezone_set('UTC');
$date = date("d-m-y H-i");

$hibernatemode = exec("pmset -g | grep hibernatemode");
$hibernatemode = str_replace("hibernatemode", "", $hibernatemode);
$hibernatemode = str_replace(" ", "", $hibernatemode);

// OS version detection
$os_string = "";
$os        = getVersion();
$version   = "Rev: $localrev";

if ($os == "")
{ 
   echo "Unable to detect operating system, edptool has exited"; exit; 
}

?>