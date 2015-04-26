<?php
		
$action = $_GET['action'];
$url 	= $_GET['url'];
$id 	= $_GET['id'];

?><script> 
    // Reference to the edp javascript core
    var edp = top.edp;
</script><?

if ($action == "goto_hell") {
	echo "If the window does not close automatically you may close it now";
	echo "<script>top.window.close();</script>";
	
	exit;
}

if ($action == "") {
    echo "No action defined.";
    exit;
}

if ($action == "close-edpweb") 	{ echo "<pre>"; close - edpweb(); exit; }


include_once "functions.inc.php";

//
// Ajax Methods to build type, vendor, series and model values 
//

if ($action == "builderVendorValues" || $action == "builderSerieValues" || $action == "builderModelValues" || $action == "builderCPUValues") {

	include_once "edpconfig.inc.php";
	
	global $edpDBase;
	
	switch($action) {
		case "builderVendorValues":
		 	echo $edpDBase->builderGetVendorValues($_GET['type']);
		break;
		
		case "builderSerieValues":
			echo $edpDBase->builderGetSerieValues($_GET['type'], $_GET['vendor']);
		break;
		
		case "builderModelValues":
			echo $edpDBase->builderGetModelValues($_GET['type'], $_GET['vendor'], $_GET['serie']);
		break;
		
		case "builderCPUValues":
			echo $edpDBase->builderGetCPUValues($_GET['type'], $_GET['model']);
		break;
	}
    exit;
}


//
// Non Ajax methods below
//
include_once "header.inc.php";

if ($action == "showUpdateLog")	{ showUpdateLog(); exit ; }

include_once "edpconfig.inc.php";

if ($action == "showCredits") {

	//Fetch data for ID
	$stmt = $edp_db->query("SELECT * FROM credits where id = '$id'");
	$stmt->execute();
	$bigrow = $stmt->fetchAll(); $row = $bigrow[0];

	if ($row[category] == "Apps & Tools")
		echoPageItemTOP("icons/apps/$row[icon]", "$row[name]");
	else
		echoPageItemTOP("icons/big/$row[icon]", "$row[name]");
		
	echo "<div class='pageitem_bottom'>\n";
	echo "<br>";
	echo "<span class='graytitle'>Info</span><br>";
	echo "<ul class='pageitem'>\n";
	echo "<li class='textbox'>\n";
	echo "<p><b>Name:</b> $row[name]</p>\n";
	echo "<p><b>Creator:</b> $row[owner]</p>\n";
	echo "<p><b>E-mail:</b> $row[contactemail]</p><br>\n";
	echo "<p><b>Project/Support Website: </b><a href='$row[infourl]'>Click here to visit</a></p>\n";

	if ($row[donationurl] != "") {
		echo "<p><b>Want to support the creator? </b><a href='$row[donationurl]'><input type='submit' value='Donate'></a></p>";
	}
	
	echo "</li>\n";
	echo "</ul>\n";
	echo "<br>";	
	echo "<span class='graytitle'>About $row[name]</span><br>";
	echo "<ul class='pageitem'>\n";
	echo "<li class='textbox'>\n";
	echo "<p>$row[description]</p>\n";
	echo "</li>\n";
	echo "</ul>\n";
	
	exit;	
}

//
// Log functions
//

if ($action == "showFixLog")			
 { 
	$fixKeyArray 	= explode(',', $_GET['fixInfoKeys']);
	$fixValueArray 	= explode(',', $_GET['fixInfoValues']);
	
	$fixData = Array();
	
	$index = 0;
	foreach($fixKeyArray as $fix) {
		$fixData[$fix] = $fixValueArray[$index];
		$index++;
	}	
	
	// var_dump($fixData);
	showFixLog($fixData);
	exit;
 }
 
if ($action == "showBuildLog")			
 { 
	$modelPath 	= $_GET['modelPath'];
	$dsdt 	= $_GET['dsdt'];
	$ssdt 	= $_GET['ssdt'];
	$theme 	= $_GET['theme'];
	$smbios	= $_GET['smbios'];
	$chame 	= $_GET['chame'];
	
	showBuildLog($modelPath, $dsdt, $ssdt, $theme, $smbios, $chame); exit ;
 }
 
if ($action == "showCustomBuildLog")	{ showCustomBuildLog(); exit ; }
if ($action == "showLoadingLog")		{ showLoadingLog($_GET['type']); exit ; }
if ($action == "showDeleteStatus")		{ showDeleteStatus(); exit ; }
if ($action == "showChameUpdateLog")	
{ 
	$type 	= $_GET['type'];
	$fname 	= $_GET['fname'];
	
	showChameUpdateLog($type, $fname); 
	exit ; 
}

if ($action == "showAppsLog")		
{ 
	$icon 		 	= $_GET['icon'];
	$foldername		= $_GET['foldername'];
	$name		 	= $_GET['name'];
	showAppsLog($id, $foldername, $name, $icon); 
	exit ; 
}

if ($action == "showKextsLog")			
 { 	
	$kInfoKeyArray 	= explode(',', $_GET['kInfoKeys']);
	$kInfoKeyValueArray = explode(',', $_GET['kInfoValues']);
	
	$InstallData = Array();
	
	$index = 0;
	foreach($kInfoKeyArray as $kInfo) {
		$InstallData[$kInfo] = $kInfoKeyValueArray[$index];
		$index++;
	}	
	
	// var_dump($InstallData);
	showKextsLog($InstallData);
	exit;
 }
 
function showBuildLog($modelPath, $dsdt, $ssdt, $theme, $smbios, $chame) {
	global $workPath, $svnpackPath, $date;
	$buildLogPath = "$workPath/logs/build";

	echoPageItemTOP("icons/big/activity.png", "System configuration build log");
	echo "<body onload=\"JavaScript:timedRefresh(5000);\">";	
	echo "<div class='pageitem_bottom'\">";	
	
	// Show build logs	
	if(is_file("$buildLogPath/build.log"))
		include "$buildLogPath/build.log";
		
	if(is_file("$buildLogPath/myFix.log"))
		include "$buildLogPath/myFix.log";
	
	// Check the file download status
	if(is_dir("$buildLogPath/dLoadStatus")) {
		$fcount = shell_exec("cd $buildLogPath/dLoadStatus; ls | wc -l");
	}
	if ($fcount > 0)
		echo "<b>Files left to download/update : $fcount</b><br>";
		
	//
	// Run Step 5 to 7 after the prepared files are downloaded
	//
	if ($fcount == 0 && is_dir("$buildLogPath/dLoadStatus") && !is_file("$buildLogPath/Run_myFix.txt"))
	{
		
		writeToLog("$buildLogPath/build.log", "<br><b>All Files downloaded/updated.</b><br>");
		
		//
		// Step 5 : Copy essentials like dsdt, ssdt and plists 
		//
		writeToLog("$buildLogPath/build.log", "<br><b>Step 5) Copy essential files downloaded:</b><br>");

		copyEssentials($modelPath, $dsdt, $ssdt, $theme, $smbios, $chame);
		
		//
		// Step 6 : Copying custom files from /Extra/include
		//
		writeToLog("$buildLogPath/build.log", "<br><b>Step 6) Copy user provided files from /Extra/include:</b><br>");
		
		copyCustomFiles();
		
		//
		// Step 7 : Applying last minute fixes and generating caches
		//
		writeToLog("$buildLogPath/build.log", "<br><b>Step 7) Apply last minute fixes:</b><br>");
		
		// Clear NVRAM
		writeToLog("$buildLogPath/build.log", " Clearing boot-args in NVRAM...<br>");
		system_call("nvram -d boot-args");
		
		// Remove SVN version
		writeToLog("$buildLogPath/build.log", " Removing version control of kexts in /Extra/Extensions<br>");
   		system_call("rm -Rf `find -f path /Extra/Extensions -type d -name .svn`");
		
		// Back up and Remove kexts which conflicts with EDP
		ProcessKextConflicts("$buildLogPath/build.log");
		
		writeToLog("$buildLogPath/build.log", " Calling EDP Fix/myFix to fix permissions and rebuild caches...<br>");
		
		// End build log and create a lastbuild log
		system_call("echo '<br>*** System build logging ended on: $date UTC Time ***<br>' >> $buildLogPath/build.log");
		system_call("cp $buildLogPath/build.log $workPath/logs/lastbuild.log ");
		
		// Append current build log to the builds log 
		$fileContents = file_get_contents("$buildLogPath/build.log");
		file_put_contents("$workPath/logs/build.log", $fileContents, FILE_APPEND | LOCK_EX);
						
		// Create run_myFix text file to start myFix process
		writeToLog("$buildLogPath/Run_myFix.txt", "");
	}
	
	echo "<script type=\"text/JavaScript\"> function timedRefresh(timeoutPeriod) { logVar = setTimeout(\"location.reload(true);\",timeoutPeriod); } function stopRefresh() { clearTimeout(logVar); } </script>\n";
	echo "</div>";
}

function showLoadingLog($type) {
	global $workPath;	
	$buildLogPath = "$workPath/logs/build";
		
	//
	// Load custom build log
	//
	if ($type == "custom") {
		
		//
		// Reload side menu
		//
		if (is_file("$buildLogPath/deleteAction.txt"))
		{
			echo "<script> top.document.getElementById('edpmenu').src ='menu.inc.php?i=Configuration'; </script>";
		}

		//
		// Quick/Full Fix
		//
		elseif (!is_file("$buildLogPath/myFix.log")) 
		{
			echo "<div class='pageitem_bottom'\">";	

			writeToLog("$buildLogPath/myFix.log", "<br><br><b>* * * * * * * * * * * *  Status of kexts permissions fix and caches rebuild process * * * * * * * * * * * *</b><br><pre>");

			// Run quick myFix to rebuild cache and fix permissions
			if(is_file("$buildLogPath/quickFix.txt")) {
				writeToLog("$buildLogPath/myFix.log", "Running quick myFix to fix kexts permissions and rebuild caches...<br><br>");
				shell_exec("sudo myfix -q -t / >> $buildLogPath/myFix.log &");
			}
			// EDP Fix
			else if(is_file("$buildLogPath/EDPFix.txt")) {
				writeToLog("$buildLogPath/myFix.log", "Running EDP Fix to fix kexts permissions and rebuild caches...<br><br>");
				myHackCheck();
		    	KextsPermissionsAndKernelCacheFix("$buildLogPath/myFix.log", "EE");
			}
			// Full Fix
			else {
				writeToLog("$buildLogPath/myFix.log", "Running full myFix to fix kexts permissions and rebuild caches...<br><br>");
		    	shell_exec("sudo myfix -t / >> $buildLogPath/myFix.log &");
			}
			
			echo "<img src=\"icons/big/success.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
			echo "<b><center> Process Finished.<br><br>Please wait... until the process on the right side finish fixing kexts permissions and rebuilding caches.</b><br><br><b> You can then reboot your system (or) close this app.</center></b>";
			echo "</div>";
		}
		
	}
	//
	// Load system build log
	//
	else 
	{
		// Check the file download status
		if(is_dir("$buildLogPath/dLoadStatus")) {
			$fcount = shell_exec("cd $buildLogPath/dLoadStatus; ls | wc -l");
		}
	
		//
		// build log
		//
		if ($fcount == "" || $fcount > 0 || !is_file("$buildLogPath/Run_myFix.txt")) {
			echo "<div class='pageitem_bottom'\">";	
			echo "<body onload=\"JavaScript:timedRefresh(8000);\">";
			echo "<center><b>After starting the build process, please wait for few minutes while we download the files needed for your model.</b> [which will take approx 5 to 15 minutes depending on your internet speed] <br><br><b>Shortly you will be redirected to the build process log which will show the status of the build.</center></b>";
			echo "<img src=\"icons/big/loading.gif\" style=\"width:200px;height:30px;position:relative;left:50%;top:50%;margin:15px 0 0 -100px;\">";
		
			if ($fcount > 0)
				echo "<br><b> Files left to download/update : $fcount</b><br>";
		
			echo "<script type=\"text/JavaScript\"> function timedRefresh(timeoutPeriod) { logVar = setTimeout(\"location.reload(true);\",timeoutPeriod); } function stopRefresh() { clearTimeout(logVar); } </script>\n";
			echo "</div>";
		}
		else {
			//
			// myFix log
			//
			if ($fcount == 0 && is_file("$buildLogPath/Run_myFix.txt") && !is_file("$buildLogPath/myFix.log"))
			{
				writeToLog("$buildLogPath/myFix.log", "<br><br><b>* * * * * * * * * * * *  Status of kexts permissions fix and caches rebuild process * * * * * * * * * * * *</b><br><pre>");
				
				// writeToLog("$buildLogPath/myFix.log", "Running myFix to fix kexts permissions and rebuild caches...<br><br>");
				// shell_exec("sudo myfix -q -t / >> $buildLogPath/myFix.log &");
				myHackCheck();
				KextsPermissionsAndKernelCacheFix("$buildLogPath/myFix.log", "EE");
			}
			echo "<div class='pageitem_bottom'\">";	
			echo "<img src=\"icons/big/success.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
			echo "<b><center> Build Finished.<br><br>Please wait... until the process on the right side to finish fixing kexts permissions and rebuilding caches.</b><br><br><b> You can then reboot your system (or) close this app.</center></b>";
			echo "</div>";
		}	
	}
	
}


function showCustomBuildLog() {
	$workPath = "/Extra/EDP";	
	$buildLogPath = "$workPath/logs/build";
	
	echoPageItemTOP("icons/big/activity.png", "Custom build log");
	echo "<body onload=\"JavaScript:refreshLog(5000);\">";	
	echo "<div class='pageitem_bottom'\">";	

	// Show build logs	
	if(is_file("$buildLogPath/build.log"))
		include "$buildLogPath/build.log";
	
	if(is_file("$buildLogPath/myFix.log"))
		include "$buildLogPath/myFix.log";
	
	echo "<script type=\"text/JavaScript\"> function refreshLog(timeoutPeriod) { logVar = setTimeout(\"location.reload(true);\",timeoutPeriod); } function stopRefresh() { clearTimeout(logVar); } </script>\n";
	echo "</div>";
}

function showDeleteStatus() {
	echo "<div class='pageitem_bottom'\">";
	echo "<ul class='pageitem'>";	
	echo "<img src=\"icons/big/success.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
	echo "<b><center> File(s) deleted successfully.</center></b>";
	echo "</ul></div>";
}

function showChameUpdateLog($type, $fname) {
	global $workPath, $svnpackPath;
	$updLogPath = "$workPath/logs/update";

	echoPageItemTOP("icons/big/chame.png", "Chameleon bootloader Update");
	echo "<body onload=\"JavaScript:timedRefresh(8000);\">";	

	echo "<div class='pageitem_bottom'\">";	
			
	if (is_file("$updLogPath/Success_$fname.txt") || is_file("$updLogPath/Fail_$fname.txt"))
	{
			echo "<ul class='pageitem'>";
			if (file_exists("$updLogPath/Success_$fname.txt")) {
							
				// Replace boot file at root
				system_call("cp -f $svnpackPath/Bootloader/$type/$fname/boot /");

				echo "<img src=\"icons/big/success.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
				echo "<b><center> Update success.</b><br><br><b> You can see the changes in action from your next boot.</center></b>";
				echo "<br></ul>";
				
			}
			else {
				echo "<img src=\"icons/big/fail.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
				echo "<b><center> Update failed.</b><br><br><b> Check the log for the reason.</center></b>";
				echo "<br></ul>";
				
				echo "<b>Update Log:</b>\n";
				echo "<pre>";
				if(is_file("$updLogPath/update.log"))
					include "$updLogPath/update.log";
				echo "</pre>";
				
			}					
			echo "</div>";
	}
	else 
	{
		echo "<center><b>Please wait for few minutes while we download the update... which will take approx 1 to 10 minutes depending on your internet speed</b></center>";
		echo "<img src=\"icons/big/loading.gif\" style=\"width:200px;height:30px;position:relative;left:50%;top:50%;margin:15px 0 0 -100px;\">";
		
		echo "<script type=\"text/JavaScript\"> function timedRefresh(timeoutPeriod) { logVar = setTimeout(\"location.reload(true);\",timeoutPeriod); } function stopRefresh() { clearTimeout(logVar); } </script>\n";
		echo "</div>";
	}

}
		
function showAppsLog($id, $foldername, $name, $icon) {
	global $workPath, $svnpackPath, $edp_db;
		
	echoPageItemTOP("icons/apps/$icon", "$name");
	echo "<body onload=\"JavaScript:timedRefresh(8000);\">";	

	echo "<div class='pageitem_bottom'\">";	
		
	$appsLogPath = "$workPath/logs/apps";
	
	if (is_file("$appsLogPath/Success_$foldername.txt") || is_file("$appsLogPath/Fail_$foldername.txt"))
	{
			// Get info from db
			$stmt = $edp_db->query("SELECT * FROM appsdata where id = '$id'");
			$stmt->execute();
			$rows = $stmt->fetchAll();
			$row = $rows[0];
			
			//
			// Install the downloaded app
			//
			echo "<ul class='pageitem'>";
			if (file_exists("$appsLogPath/Success_$foldername.txt")) {
			
				$appPath = "$workPath/apps/$row[menu]/$row[foldername]";
				
				if ($row[foldername] == "CamTwist") {
					system_call("rm -rf /Library/QuickTime/CamTwist.component");
					system_call("rm -rf /Applications/$row[foldername]");
					
					system_call("cd $appPath; rm -rf CamTwist.component; rm -rf CamTwist; unzip -X -qq $row[foldername].zip");
						
					system_call("cp -R $appPath/CamTwist.component /Library/QuickTime/");
					system_call("cp -a $appPath/CamTwist/. /Applications/CamTwist/");
				}
				else {
					system_call("rm -rf /Applications/$row[foldername].app");
					system_call("cd $appPath; unzip -X -qq $row[foldername].zip -d /Applications");
				}		
				
				echo "<img src=\"icons/big/success.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
				echo "<b><center> Installation finished.</b><br><br><b> You can find this from Applications list.</center></b>";
				echo "<br></ul>";
			}
			else {
				echo "<img src=\"icons/big/fail.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
				echo "<b><center> Installation failed.</b><br><br><b> Check the log for the reason.</center></b>";
				echo "<br></ul>";
				
				echo "<b>Log:</b>\n";
				echo "<pre>";
				if(is_file("$appsLogPath/appInstall.log"))
					include "$appsLogPath/appInstall.log";
				echo "</pre>";
			}					
			echo "</div>";
			exit;
	}
	else 
	{
		echo "<center><b>Please wait for few minutes while we download and install the app... which will take approx 1 to 10 minutes depending on your internet speed.</b></center>";
		echo "<img src=\"icons/big/loading.gif\" style=\"width:200px;height:30px;position:relative;left:50%;top:50%;margin:15px 0 0 -100px;\">";
	}
	
	echo "<script type=\"text/JavaScript\"> function timedRefresh(timeoutPeriod) { logVar = setTimeout(\"location.reload(true);\",timeoutPeriod); } function stopRefresh() { clearTimeout(logVar); } </script>\n";
	echo "</div>";
}

function showFixLog($fixData) {
	global $workPath, $svnpackPath, $edp_db;
		
	echoPageItemTOP("icons/big/$fixData[icon]", "$fixData[name]");
	echo "<body onload=\"JavaScript:timedRefresh(8000);\">";	

	echo "<div class='pageitem_bottom'\">";	
	
	$fixLogPath = "$workPath/logs/fixes";
	
	
	if (is_file("$fixLogPath/Success_$fixData[foldername].txt") || is_file("$fixLogPath/Fail_$fixData[foldername].txt"))
	{
			// Get info from db
			$stmt = $edp_db->query("SELECT * FROM fixesdata where id = '$fixData[id]'");
			$stmt->execute();
			$rows = $stmt->fetchAll();
			$row = $rows[0];
			
			//
			// Install the downloaded fix
			//
			echo "<ul class='pageitem'>";
			if (file_exists("$fixLogPath/Success_$fixData[foldername].txt")) {
							
				switch($fixData[foldername]) {
				
					case "EAPDFix": // Apply plist config and install kext to SLE or EE
						$fixPath = "$svnpackPath/$fixData[categ]/$fixData[foldername]";
						system_call("sudo /usr/libexec/PlistBuddy -c \"set IOKitPersonalities:EAPDFix:CodecValues:Speakers $fixData[spk]\" $fixPath/EAPDFix.kext/Contents/Info.plist >> $fixLogPath/fixInstall.log");
						system_call("sudo /usr/libexec/PlistBuddy -c \"set IOKitPersonalities:EAPDFix:CodecValues:Headphones $fixData[hp]\" $fixPath/EAPDFix.kext/Contents/Info.plist >> $fixLogPath/fixInstall.log");
						system_call("sudo /usr/libexec/PlistBuddy -c \"set IOKitPersonalities:EAPDFix:CodecValues:ExternalMic $fixData[extMic]\" $fixPath/EAPDFix.kext/Contents/Info.plist >> $fixLogPath/fixInstall.log");
						system_call("sudo /usr/libexec/PlistBuddy -c \"set IOKitPersonalities:EAPDFix:CodecValues:SpkHasEAPD $fixData[spkFix]\" $fixPath/EAPDFix.kext/Contents/Info.plist >> $fixLogPath/fixInstall.log");
						system_call("sudo /usr/libexec/PlistBuddy -c \"set IOKitPersonalities:EAPDFix:CodecValues:HpHasEAPD $fixData[hpFix]\" $fixPath/EAPDFix.kext/Contents/Info.plist >> $fixLogPath/fixInstall.log");
						system_call("rm -rf $fixData[path]/EAPDFix.kext");
						system_call("cp -rf $fixPath/EAPDFix.kext $fixData[path]/");
					
						if ($fixData[path] == "/Extra/Extensions") {
							myHackCheck();
							ProcessKextConflicts("$fixLogPath/myFix.log");
							KextsPermissionsAndKernelCacheFix("$fixLogPath/myFix.log", "EE");
							// system_call("sudo myfix -q -t / >> $fixLogPath/myFix.log &");
						}
						else {
							myHackCheck();
							ProcessKextConflicts("$fixLogPath/myFix.log");
							KextsPermissionsAndKernelCacheFix("$fixLogPath/myFix.log", "SLE");
						}
					break;
					
					Default:
						//
						// kext packs
						//
						$fixPath = "$svnpackPath/$fixData[categ]/$fixData[foldername]";
						system_call("cp -rf $fixPath/* $fixData[path]/"); // Copy kext to SLE (or) E/E
					
						// Generate cache
						if ($fixData[path] == "/Extra/Extensions") {
							myHackCheck();
							ProcessKextConflicts("$fixLogPath/fixInstall.log");
							KextsPermissionsAndKernelCacheFix("$fixLogPath/fixInstall.log", "EE");
							// system_call("sudo myfix -q -t / >> $fixLogPath/myFix.log &");
						}
						else {
							// system_call("sudo chown -R root:wheel /System/Library/Extensions/");
							// system_call("sudo touch /System/Library/Extensions/");
							myHackCheck();
							ProcessKextConflicts("$fixLogPath/fixInstall.log");
							KextsPermissionsAndKernelCacheFix("$fixLogPath/fixInstall.log", "SLE");
						}
					break;
					
				}
								
				echo "<img src=\"icons/big/success.png\" style=\"width:80px;height:80px;position:relative;left:49%;top:50%;margin:15px 0 0 -35px;\">";
				echo "<b><center> Fix finished.</b><br><br><b> You can see the changes in action from your next boot.</center></b>";
				echo "<br></ul>";
			}
			else {
				echo "<img src=\"icons/big/fail.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
				echo "<b><center> Fix failed.</b><br><br><b> Check the log for the reason.</center></b>";
				echo "<br></ul>";
				
				echo "<b>Log:</b>\n";
				echo "<pre>";
				if(is_file("$fixLogPath/fixInstall.log"))
					include "$fixLogPath/fixInstall.log";
				echo "</pre>";
			}					
			echo "</div>";
			exit;
	}
	else 
	{
		echo "<center><b>Please wait for few minutes while we apply fix... which will take approx 1 to 10 minutes if it requires internet which depends on your speed.</b></center>";
		echo "<img src=\"icons/big/loading.gif\" style=\"width:200px;height:30px;position:relative;left:50%;top:50%;margin:15px 0 0 -100px;\">";
	}
	
	echo "<script type=\"text/JavaScript\"> function timedRefresh(timeoutPeriod) { logVar = setTimeout(\"location.reload(true);\",timeoutPeriod); } function stopRefresh() { clearTimeout(logVar); } </script>\n";
	echo "</div>";
}

function showKextsLog($InstallData) {
	global $workPath, $svnpackPath, $edp_db;
		
	if ($InstallData[categ] != "Ethernet")
		echoPageItemTOP("icons/big/$InstallData[icon]", "$InstallData[name]");
	else
		echoPageItemTOP("icons/big/$InstallData[icon]", "$InstallData[foldername]");
	
	echo "<body onload=\"JavaScript:timedRefresh(8000);\">";	

	echo "<div class='pageitem_bottom'\">";	
		
	$buildLogPath = "$workPath/logs/build";
	
	if (is_file("$buildLogPath/Success_$InstallData[foldername].txt") || is_file("$buildLogPath/Fail_$InstallData[foldername].txt"))
	{
			//
			// Install the downloaded kext
			//
			if (file_exists("$buildLogPath/Success_$InstallData[foldername].txt")) {
				
				// Download kext
				switch ($InstallData[categ]) {
					
					case "PS2Touchpad":
						// Remove installed kexts which might cause problems
						if (is_dir("$InstallData[path]/VoodooPS2Controller.kext"))  {
							system_call("rm -rf $InstallData[path]/VoodooPS2Controller.kext");
						}
						if (is_dir("$InstallData[path]/ApplePS2Controller.kext"))  {
							system_call("rm -rf $InstallData[path]/ApplePS2Controller.kext");
						}
						if (is_dir("$InstallData[path]/AppleACPIPS2Nub.kext"))  {
							system_call("rm -rf $InstallData[path]/AppleACPIPS2Nub.kext");
						}
						if (is_dir("$InstallData[path]/ApplePS2ElanTouchpad.kext"))  {
							system_call("rm -rf $InstallData[path]/ApplePS2ElanTouchpad.kext");
						}
						
						$kPath = "$svnpackPath/$InstallData[categ]/$InstallData[foldername]";
					break;
					
					case "Audio":
						$kPath = "$svnpackPath/$InstallData[categ]/$InstallData[foldername]";
						
						// Copy prefpane and settings loader
						if (is_file("$buildLogPath/Success_Settings.txt") || is_file("$buildLogPath/Fail_Settings.txt")) {
					    	system_call("cp -rf $svnpackPath/$InstallData[categ]/Settings/VoodooHdaSettingsLoader.app /Applications/; cp -f $svnpackPath/$InstallData[categ]/Settings/com.restore.voodooHDASettings.plist /Library/LaunchAgents/; cp -rf $svnpackPath/$InstallData[categ]/Settings/VoodooHDA.prefPane /Library/PreferencePanes/;");
					    }
					    // Check back (waiting for VoodooHDA Settings SVN download to finish)
					    else {
					    	echo "<center><b>Please wait for few minutes while we download and install the kext... which will take approx 1 to 10 minutes depending on your internet speed.</b></center>";
							echo "<img src=\"icons/big/loading.gif\" style=\"width:200px;height:30px;position:relative;left:50%;top:50%;margin:15px 0 0 -100px;\">";
							echo "<script type=\"text/JavaScript\"> function timedRefresh(timeoutPeriod) { logVar = setTimeout(\"location.reload(true);\",timeoutPeriod); } function stopRefresh() { clearTimeout(logVar); } </script>\n";
							echo "</div>";
							return;
					    }
					break;
					
					case "USB":
						// Generic XHCI USB3.0
						if($InstallData[id] == "5") {
							// Choose new version 
							if(getMacOSXVersion() >= "10.8.5")
								$kPath = "$svnpackPath/$InstallData[categ]/GenericXHCIUSB3_New";
				
							// Choose old version
							else if(getMacOSXVersion() < "10.8.5")
								$kPath = "$svnpackPath/$InstallData[categ]/$InstallData[foldername]";
						}
						else
							$kPath = "$svnpackPath/$InstallData[categ]/$InstallData[foldername]";

					break;
			
					case "Ethernet":
						// New Realtek kext
						if($InstallData[id] == "11") {
				
							// Choose 10.8+ version 
							if(getMacOSXVersion() >= "10.8")
								$kPath = "$svnpackPath/$InstallData[categ]/$InstallData[name]/RealtekRTL8111";
					
							// Choose Lion version
							else if(getMacOSXVersion() == "10.7")
								$kPath = "$svnpackPath/$InstallData[categ]/$InstallData[name]/RealtekRTL8111_Lion";
						}
						else
							$kPath = "$svnpackPath/$InstallData[categ]/$InstallData[name]/$InstallData[foldername]";

					break;
					
					Default:
						$kPath = "$svnpackPath/$InstallData[categ]/$InstallData[foldername]";
					break;
		
				}	
				
				system_call("cp -rf $kPath/*.kext $InstallData[path]/");
				
				if ($InstallData[path] == "/Extra/Extensions") {
					myHackCheck();
					ProcessKextConflicts("$buildLogPath/kextInstall.log");
					KextsPermissionsAndKernelCacheFix("$buildLogPath/kextInstall.log", "EE");
					// system_call("sudo myfix -q -t / >> $buildLogPath/myFix.log &");
				}
				else {
					myHackCheck();
					ProcessKextConflicts("$buildLogPath/kextInstall.log");
					KextsPermissionsAndKernelCacheFix("$buildLogPath/kextInstall.log", "SLE");
				}
				
				echo "<ul class='pageitem'>";
				echo "<img src=\"icons/big/success.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
				echo "<b><center> Installation finished.</b><br><br><b> You can see the changes in action from your next boot.</center></b>";
				echo "<br></ul>";
			}
			else {
				echo "<ul class='pageitem'>";
				echo "<img src=\"icons/big/fail.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
				echo "<b><center> Installation failed.</b><br><br><b> Check the log for the reason.</center></b>";
				echo "<br></ul>";
				
				echo "<b>Log:</b>\n";
				echo "<pre>";
				if(is_file("$buildLogPath/kextInstall.log"))
					include "$buildLogPath/kextInstall.log";
				echo "</pre>";
			}					
			echo "</div>";
			exit;
	}
	else 
	{
		echo "<center><b>Please wait for few minutes while we download and install the kext... which will take approx 1 to 10 minutes depending on your internet speed.</b></center>";
		echo "<img src=\"icons/big/loading.gif\" style=\"width:200px;height:30px;position:relative;left:50%;top:50%;margin:15px 0 0 -100px;\">";
	}
	
	echo "<script type=\"text/JavaScript\"> function timedRefresh(timeoutPeriod) { logVar = setTimeout(\"location.reload(true);\",timeoutPeriod); } function stopRefresh() { clearTimeout(logVar); } </script>\n";
	echo "</div>";
}

//
// Special case in Update function for workPath due to reload of App forces DB reload
//

function showUpdateLog() {
	
	$workPath = "/Extra/EDP"; // can't use global path (using makes update to break)

	// For log time
	date_default_timezone_set("UTC");
	$date = date("d-m-y H-i");
	
	$updLogPath = "$workPath/logs/update";

	if(is_file("$updLogPath/updateFinish.log")) {
		system_call("mv $updLogPath/updateFinish.log $workPath/logs/lastupdate.log ");
		system("sudo killall EDP"); 
    	system("open $workPath/bin/EDPweb.app");
    	exit;
	}
				
	echoPageItemTOP("icons/big/update.png", "EDP Update");
	echo "<body onload=\"JavaScript:timedRefresh(8000);\">";	

	echo "<div class='pageitem_bottom'\">";	
			
	if (is_file("$updLogPath/Updsuccess.txt") || is_file("$updLogPath/Updfail.txt"))
	{
			echo "<ul class='pageitem'>";
			if (file_exists("$updLogPath/Updsuccess.txt")) {
							
				echo "<img src=\"icons/big/success.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
				echo "<b><center> Update success.</b><br><br><b> Please wait 10 sec... the App will reload for the new changes to take effect.</center></b>";
				echo "<br></ul>";
				
				system_call("echo '<br>*** Logging ended on: $date UTC Time ***<br>' >> $updLogPath/update.log");
				system_call("mv $updLogPath/update.log $updLogPath/updateFinish.log ");

				echo "<b>Update Log:</b>\n";
				echo "<pre>";
				if(is_file("$updLogPath/updateFinish.log"))
					include "$updLogPath/updateFinish.log";
				echo "</pre>";
				
				// Append current update log to the updates log 
				$fileContents = file_get_contents("$updLogPath/updateFinish.log");
				file_put_contents("$workPath/logs/update.log", $fileContents, FILE_APPEND | LOCK_EX);
				
				echo "<body onload=\"JavaScript:timedRefresh(8000);\">";
				echo "<script type=\"text/JavaScript\"> function timedRefresh(timeoutPeriod) { logVar = setTimeout(\"location.reload(true);\", timeoutPeriod); } </script>\n";
			}
			else {
				echo "<img src=\"icons/big/fail.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
				echo "<b><center> Update failed.</b><br><br><b> Check the log for the reason.</center></b>";
				echo "<br></ul>";
				
				echo "<b>Update Log:</b>\n";
				echo "<pre>";
				if(is_file("$updLogPath/update.log"))
					include "$updLogPath/update.log";
				echo "</pre>";
				
				system_call("echo '<br>*** Logging ended on: $date UTC Time ***<br>' >> $updLogPath/update.log");
				system_call("mv $updLogPath/update.log $workPath/logs/lastupdate.log ");
				
				// Append current update log to the updates log 
				$fileContents = file_get_contents("$workPath/logs/lastupdate.log");
				file_put_contents("$workPath/logs/update.log", $fileContents, FILE_APPEND | LOCK_EX);
			}					
			echo "</div>";
	}
	else 
	{
		echo "<center><b>Please wait for few minutes while we download the updates... which will take approx 1 to 10 minutes depending on your internet speed</b></center>";
		echo "<img src=\"icons/big/loading.gif\" style=\"width:200px;height:30px;position:relative;left:50%;top:50%;margin:15px 0 0 -100px;\">";
		
		echo "<script type=\"text/JavaScript\"> function timedRefresh(timeoutPeriod) { logVar = setTimeout(\"location.reload(true);\",timeoutPeriod); } function stopRefresh() { clearTimeout(logVar); } </script>\n";
		echo "</div>";
	}

}

?>