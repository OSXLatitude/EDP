<?php
   
// Include these class for some functions
  include_once "classes/chamModules.php";
  include_once "classes/svn.php";
  include_once "classes/database.php"; 
    
//------------------> EDPweb functions -----------------------------------------------------------------------------------------------

function checkbox($title, $formname, $status) {
	if ($status == "yes") { $c = "checked"; }
	echo "<li class='checkbox'><span class='name'>$title</span><input name='$formname' type='checkbox' $c/> </li>\n";
}

//Writes out the html for the pageitemtop
function echoPageItemTOP($icon, $text) {
	echo "<div class='pageitem_top'><img src='$icon'><span><b>$text</span></div></b>\n";
}


//<------------------> EDP Functions ----------------------------------------------------------------------------------------------------
    
	function getVersion() {
		global $rootPath, $os_string;

		$path = "".$rootPath."System/Library/CoreServices/SystemVersion";
		$v = exec("defaults read $path ProductVersion");
		$r = '';

		if ($v == "10.6")   { $r="sl"; $os_string = "MacOS X Snow Leopard $v"; }		
		if ($v == "10.6.0") { $r="sl"; $os_string = "MacOS X Snow Leopard $v"; }
		if ($v == "10.6.1") { $r="sl"; $os_string = "MacOS X Snow Leopard $v"; }
		if ($v == "10.6.2") { $r="sl"; $os_string = "MacOS X Snow Leopard $v"; }
		if ($v == "10.6.3") { $r="sl"; $os_string = "MacOS X Snow Leopard $v"; }						
		if ($v == "10.6.4") { $r="sl"; $os_string = "MacOS X Snow Leopard $v"; }
		if ($v == "10.6.5") { $r="sl"; $os_string = "MacOS X Snow Leopard $v"; }
		if ($v == "10.6.6") { $r="sl"; $os_string = "MacOS X Snow Leopard $v"; }
		if ($v == "10.6.7") { $r="sl"; $os_string = "MacOS X Snow Leopard $v"; }
		if ($v == "10.6.8") { $r="sl"; $os_string = "MacOS X Snow Leopard $v"; }
		if ($v == "10.6.9") { $r="sl"; $os_string = "MacOS X Snow Leopard $v"; }
		if ($v == "10.7")   { $r="lion"; $os_string = "MacOS X Lion $v"; }			
		if ($v == "10.7.0") { $r="lion"; $os_string = "MacOS X Lion $v"; }
		if ($v == "10.7.1") { $r="lion"; $os_string = "MacOS X Lion $v"; }
		if ($v == "10.7.2") { $r="lion"; $os_string = "MacOS X Lion $v"; }
		if ($v == "10.7.3") { $r="lion"; $os_string = "MacOS X Lion $v"; }
		if ($v == "10.7.4") { $r="lion"; $os_string = "MacOS X Lion $v"; }
		if ($v == "10.7.5") { $r="lion"; $os_string = "MacOS X Lion $v"; }
		if ($v == "10.7.6") { $r="lion"; $os_string = "MacOS X Lion $v"; }
		if ($v == "10.7.7") { $r="lion"; $os_string = "MacOS X Lion $v"; }
		if ($v == "10.8")   { $r="ml"; $os_string = "OSX Mountain Lion $v"; }
		if ($v == "10.8.0") { $r="ml"; $os_string = "OSX Mountain Lion $v"; }	
		if ($v == "10.8.1") { $r="ml"; $os_string = "OSX Mountain Lion $v"; }	
		if ($v == "10.8.2") { $r="ml"; $os_string = "OSX Mountain Lion $v"; }	
		if ($v == "10.8.3") { $r="ml"; $os_string = "OSX Mountain Lion $v"; }
		if ($v == "10.8.4") { $r="ml"; $os_string = "OSX Mountain Lion $v"; }	
		if ($v == "10.8.5") { $r="ml"; $os_string = "OSX Mountain Lion $v"; }
		if ($v == "10.8.6") { $r="ml"; $os_string = "OSX Mountain Lion $v"; }    	
		if ($v == "10.9") 	{ $r="mav"; $os_string = "OSX Maverick $v"; }	
		if ($v == "10.9.0") { $r="mav"; $os_string = "OSX Maverick $v"; }	
		if ($v == "10.9.1") { $r="mav"; $os_string = "OSX Maverick $v"; }
		if ($v == "10.9.2") { $r="mav"; $os_string = "OSX Maverick $v"; }
		if ($v == "10.9.3") { $r="mav"; $os_string = "OSX Maverick $v"; }	
		if ($v == "10.9.4") { $r="mav"; $os_string = "OSX Maverick $v"; }
		if ($v == "10.9.5") { $r="mav"; $os_string = "OSX Maverick $v"; }
		if ($v == "10.9.6") { $r="mav"; $os_string = "OSX Maverick $v"; }
		if ($v == "10.10") { $r="yos"; $os_string = "OSX Yosemite $v"; }    
		if ($v == "10.10.0") { $r="yos"; $os_string = "OSX Yosemite $v"; }    
		if ($v == "10.10.1") { $r="yos"; $os_string = "OSX Yosemite $v"; }    
		if ($v == "10.10.2") { $r="yos"; $os_string = "OSX Yosemite $v"; }    
		if ($v == "10.10.3") { $r="yos"; $os_string = "OSX Yosemite $v"; }
		if ($v == "10.10.4") { $r="yos"; $os_string = "OSX Yosemite $v"; }
		if ($v == "10.10.5") { $r="yos"; $os_string = "OSX Yosemite $v"; } 
		if ($v == "10.10.6") { $r="yos"; $os_string = "OSX Yosemite $v"; }                            			
		return $r;
	}
	
	function getMacOSXVersion() {
		$path = "/System/Library/CoreServices/SystemVersion";
		$ver = exec("defaults read $path ProductVersion");
		return $ver;
	}

	/*
	 * Writes a $data to $logfile
	 */
	function writeToLog($logfile, $data) {
		file_put_contents($logfile, $data, FILE_APPEND | LOCK_EX);
	}

	/*
	 * replace system_call() .. works with LWS also
	 */
	function system_call($data) {
		passthru("$data");
		echo str_repeat(' ', 254);
		flush();
	}

	function isEmptyDir($dir) {
		if (($files = @scandir("$dir")) && (count($files) > 2)) {
			return "yes";
		} else {
			return "no";
		}
	}

	function UpdateKextVersions($log)
	{		
		//
		// Bump kext version to 1111 for the patched Apple kexts to load patched kexts instead of Vanilla
		//
		
		// Get the names of the files in comma seperated
		$kPList = shell_exec("ls -m /Extra/Extensions.EDPFix/");
		$kPListArray = explode(',', $kPList);
			
		$kPCount = 0;
		
		foreach($kPListArray as $kName) {
		
			$kName = preg_replace('/\s+/', '',$kName); //remove white spaces

			if ($kName != "" && $kName != ".DS_Store") {
		
				system_call("sudo /usr/libexec/PlistBuddy -c \"set :CFBundleVersion 1111\" /Extra/Extensions.EDPFix/$kName/Contents/Info.plist");
				system_call("sudo /usr/libexec/PlistBuddy -c \"set :CFBundleShortVersionString 1111\" /Extra/Extensions.EDPFix/$kName/Contents/Info.plist");
				
				if(file_exists("/Extra/Extensions.EDPFix/$kName/Contents/version.plist"))
				{
					system_call("sudo /usr/libexec/PlistBuddy -c \"set :CFBundleVersion 1111\" /Extra/Extensions.EDPFix/$kName/Contents/version.plist");
					system_call("sudo /usr/libexec/PlistBuddy -c \"set :CFBundleShortVersionString 1111\" /Extra/Extensions.EDPFix/$kName/Contents/version.plist");
				}
				
				$kPCount++;				
			}
		}
		if($kPCount > 0)
			writeToLog("$log", "Updated $kPCount patched kext(s) to version 1111 to load instead of vanilla kext(s)<br>");
	}
	
	function ProcessKextConflicts($log)
	{		
		//
		// Back up and remove the user installed kexts which are same as EDP installed kexts from SLE
		//
		
		$kList = shell_exec("ls -m /Extra/Extensions/");
		$kListArray = explode(',', $kList);
			
		$kCount = 0;
		
		if(!is_dir("/Extra/EDP_Removed_Extensions")) {
			system_call("mkdir /Extra/EDP_Removed_Extensions");
	  	}
	  	
		foreach($kListArray as $kName) {
		
			$kName = preg_replace('/\s+/', '',$kName); //remove white spaces

			if ($kName != "" && $kName != ".DS_Store" && is_dir("/System/Library/Extensions/$kName")) 
			{
				$kCount++;
				system_call("cp -a /System/Library/Extensions/$kName /Extra/EDP_Removed_Extensions");
				system_call("rm -rf /System/Library/Extensions/$kName");
			}
		}
		if($kCount > 0)
			writeToLog("$log", "Removed $kCount kext(s) which conflicts with EDP (back exists in /Extra/EDP_Removed_Extensions)<br>");
	}
	
	function KextsPermissionsAndKernelCacheFix($log, $path) {
		global $workPath;		
		$osxVerStr = getVersion();
		
		switch ($path) {
			case "EE":
			if ($osxVerStr == "yos") { 
				writeToLog("$log", "Running EDP Fix to fix kexts permissions and rebuild caches...<br><br>");
				system_call("sudo sh $workPath/bin/fixMyHackPermCaches.sh >> $log &"); 
			}
			else { 
				writeToLog("$log", "Running EDP Fix legacy to fix kexts permissions and rebuild caches...<br><br>");
				system_call("sudo sh $workPath/bin/fixMyHackPermCachesLegacy.sh >> $log &"); 
			}
			break;
			
			case "SLE":
			if ($osxVerStr == "yos") { 
				writeToLog("$log", "Running EDP Fix to fix kexts permissions and rebuild caches...<br><br>");
				system_call("sudo sh $workPath/bin/fixPermCaches.sh >> $log &"); 
			}
			else { 
				writeToLog("$log", "Running EDP Fix legacy to fix kexts permissions and rebuild caches...<br><br>");
				system_call("sudo sh $workPath/bin/fixPermCachesLegacy.sh >> $log &"); 
			}
			break;
		}
		
	}

   //------> Function to get version from kext
    function getKextVersion($kext) {
    	global $workPath;
    
    	if (!is_dir($kext)) { return "0.00"; }		// If $kext dosent exist we will just return 0.00
    
    	include_once "$workPath/bin/html/libs/PlistParser.inc";
    	$parser = new plistParser();
    	$plist = $parser->parseFile("$kext/Contents/Info.plist");
    	reset($plist);
    
    	while (list($key, $value) = each($plist)) {
        	if ($key == "CFBundleShortVersionString") {
            	return "$value";
            }
        }
    }

    //-----> Copys $kext to /System/Library/Extensions/
    function copyKextToSLE($kext, $frompath) {
    	global $slePath, $workPath;

    	//Create backup folder
    	date_default_timezone_set('UTC');
    	$date = date("d-m-Y");
    	$backupfolder = "/backup/$date";
    	system_call("mkdir /backup");
    	system_call("mkdir $backupfolder");
    	system_call("rm -Rf $backupfolder/*");
    
    	//Do backup
    	echo "Copying old $slePath/$kext to $backupfolder \n";
    	system_call("cp -R $slePath/$kext $backupfolder");

    	//Remove the present kext
    	system_call("rm -R $slePath/$kext");

    	echo "Copying $workPath/$frompath/$kext to $slePath/ \n";
    	system_call("cp -R $workPath/$frompath/$kext $slePath/");

    	system_call("chown -R root:wheel $slePath/$kext");
    	system_call("chmod -R 755 \"$slePath/$kext\"");
    }
    
	//
	// Get Value from Key in SMbios.plist
	//
	include_once __DIR__ . '/vendor/CFPropertyList/CFPropertyList.php';

	function getValueFromSmbios($key, $default = null) {
		global $workPath;

		$file = $workPath . '/smbios.plist';

		if (file_exists($file)) {
			$plist = new CFPropertyList\CFPropertyList($file, CFPropertyList\CFPropertyList::FORMAT_XML);
			$dict  = $plist->toArray();

			if (array_key_exists($key, $dict)) {
				return $dict[$key];
			}
		}

		return $default;
	}
	
	function downloadAndRun($url, $filetype, $filename, $execpath) {
		echo "Making downloads folder in /Downloads and initiating download of $url\n\n";
		system_call("mkdir /downloads; cd /downloads; curl -O $url");
		echo "Mounting $filename... \n\n";
	
		if ($filetype == "dmg") {
			system_call("hdiutil attach /downloads/$filename >/dev/null");
		}
	
		echo "Executing the package installer... \n\n";
		system_call("open $execpath");
	}	
	
//<------------------> Patches  ----------------------------------------------------------------------------------------------------	
	/*
	 * Patch AHCI
	 * @see http://www.insanelymac.com/forum/topic/280062-waiting-for-root-device-when-kernel-cache-used-only-with-some-disks-fix/page__st__60#entry1851722
	 */
	function patchAHCI() {
		global $workPath, $slePath;
		
       	writeToLog("$workPath/logs/build/build.log", " Patching AHCI.kext to waiting for root device problem in ML<br>");

		system_call("cp -a $slePath/IOAHCIFamily.kext /Extra/Extensions.EDPFix/");
		system_call("cp -a $slePath/IOAHCIFamily.kext/Contents/PlugIns/. /Extra/Extensions.EDPFix/");
		system_call("rm -rf /Extra/Extensions.EDPFix/IOAHCIFamily.kext/Contents/PlugIns");
		
		// system_call("cp -R $slePath/IOAHCIFamily.kext /Extra/Extensions");
		// system_call("perl $workPath/bin/fixes/patch-ahci-mlion.pl >> $workPath/logs/build/build.log");
		
		UpdateKextVersions("$workPath/logs/build/build.log");
	}

	/*
	 * Patch VGA and HDMI for Intel HD3000 GPU
	 */
	function patchAppleIntelSNBGraphicsFB($log, $pathToPatch, $genCache) {

		global $slePath, $workPath;
	
		writeToLog("$workPath/logs/build/build.log", " Patching AppleIntelSNBGraphicsFB.kext for VGA and HDMI in Intel HD3000...<br>");

		if(!is_dir("/System/Library/Extensions/AppleIntelSNBGraphicsFB.kext")) {
				writeToLog("$log", "  AppleIntelSNBGraphicsFB.kext not found for patching<br>");
				system_call("cd $workPath/logs/fixes; touch patchFail.txt;");
				return;
	  	}
	  	
		switch ($pathToPatch)
		{
			case "SLE":			
			system_call('sudo perl -pi -e \'s|\x01\x02\x04\x00\x10\x07\x00\x00\x10\x07\x00\x00\x05\x03\x00\x00\x02\x00\x00\x00\x30\x00\x00\x00\x02\x05\x00\x00\x00\x04\x00\x00\x07\x00\x00\x00\x03\x04\x00\x00\x00\x04\x00\x00\x09\x00\x00\x00\x04\x06\x00\x00\x00\x04\x00\x00\x09\x00\x00\x00|\x01\x02\x03\x00\x10\x07\x00\x00\x10\x07\x00\x00\x05\x03\x00\x00\x02\x00\x00\x00\x30\x00\x00\x00\x06\x02\x00\x00\x00\x01\x00\x00\x07\x00\x00\x00\x03\x04\x00\x00\x00\x08\x00\x00\x06\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00|g\' /System/Library/Extensions/AppleIntelSNBGraphicsFB.kext/Contents/MacOS/AppleIntelSNBGraphicsFB');
			
			if ($genCache == "yes") {
				// system_call("sudo touch /System/Library/Extensions/ >> $log &");
				KextsPermissionsAndKernelCacheFix($log, "SLE");
			}
			break;
			
			case "EE":	
			system_call("cp -a $slePath/AppleIntelSNBGraphicsFB.kext /Extra/Extensions.EDPFix/");
			system_call("cp -a $slePath/AppleIntelSNBGraphicsFB.kext/Contents/PlugIns/. /Extra/Extensions.EDPFix/");
			system_call("rm -rf /Extra/Extensions.EDPFix/AppleIntelSNBGraphicsFB.kext/Contents/PlugIns");
				
			system_call('sudo perl -pi -e \'s|\x01\x02\x04\x00\x10\x07\x00\x00\x10\x07\x00\x00\x05\x03\x00\x00\x02\x00\x00\x00\x30\x00\x00\x00\x02\x05\x00\x00\x00\x04\x00\x00\x07\x00\x00\x00\x03\x04\x00\x00\x00\x04\x00\x00\x09\x00\x00\x00\x04\x06\x00\x00\x00\x04\x00\x00\x09\x00\x00\x00|\x01\x02\x03\x00\x10\x07\x00\x00\x10\x07\x00\x00\x05\x03\x00\x00\x02\x00\x00\x00\x30\x00\x00\x00\x06\x02\x00\x00\x00\x01\x00\x00\x07\x00\x00\x00\x03\x04\x00\x00\x00\x08\x00\x00\x06\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00|g\' /Extra/Extensions.EDPFix/AppleIntelSNBGraphicsFB.kext/Contents/MacOS/AppleIntelSNBGraphicsFB');
			
			UpdateKextVersions("$workPath/logs/build/build.log");
			
			if ($genCache == "yes") {
				myHackCheck();
				KextsPermissionsAndKernelCacheFix($log, "EE");
				// system_call("sudo myfix -q -t / >> $log &");
			}
			break;
		}
		
		writeToLog("$log", "  AppleIntelSNBGraphicsFB.kext patched successfullly for Intel HD3000 VGA and HDMI<br>");
		system_call("touch $workPath/logs/fixes/patchSuccess.txt;");
	}

	/*
	 * Patch AppleIntelCPUPowerxxx for Native Speedstep and Power managment
	 */
	function patchAppleIntelCPUPowerManagement($log, $pathToPatch, $genCache) {
		global $slePath, $workPath;
			
        writeToLog("$workPath/logs/build/build.log", " Patching AppleIntelCPUPowerManagement.kext...<br>");
		
		if(!is_dir("/System/Library/Extensions/AppleIntelCPUPowerManagement.kext")) {
				writeToLog("$log", "  AppleIntelCPUPowerManagement.kext not found for patching<br>");
				system_call("cd $workPath/logs/fixes; touch patchFail.txt;");
				return;
	  	}
	  	
		/*
		 * Note: Using the variables for the path in hex patch doesn't work, so we have to provide the full path
		 */
		switch ($pathToPatch)
		{
			case "SLE":	
			// Remove NullCPUxxx
			if (is_dir("/System/Library/Extensions/NullCPUPowerManagement.kext"))
			{
				writeToLog("$log", "  NullCPUPowerManagement.kext found, removing...<br>");
				system_call("rm -rf /System/Library/Extensions/NullCPUPowerManagement.kext");
			}
				
			// system_call('sudo perl -pi -e \'s|\xE2\x00\x00\x00\x0F\x30|\xE2\x00\x00\x00\x90\x90|g\' /System/Library/Extensions/AppleIntelCPUPowerManagement.kext/Contents/MacOS/AppleIntelCPUPowerManagement');
			// system_call('sudo perl -pi -e \'s|\xE2\x00\x00\x00\x48\x89\xF2\x0F\x30|\xE2\x00\x00\x00\x48\x89\xF2\x90\x90|g\' /System/Library/Extensions/AppleIntelCPUPowerManagement.kext/Contents/MacOS/AppleIntelCPUPowerManagement');
			
			system_call("cd /Extra/EDP/bin/fixes/AICPMPatch; sudo perl AICPMPatch.pl /System/Library/Extensions/AppleIntelCPUPowerManagement.kext/Contents/MacOS/AppleIntelCPUPowerManagement --patch");

			// touch for kernel cache
			if ($genCache == "yes") {
				KextsPermissionsAndKernelCacheFix($log, "SLE");
				// system_call("sudo touch /System/Library/Extensions/ >> $log &");
			}
			break;
			
			case "EE":
			// Remove NullCPUxxx
			if (is_dir("/System/Library/Extensions/NullCPUPowerManagement.kext"))
			{
				writeToLog("$log", "  NullCPUPowerManagement.kext found, removing...<br>");
				system_call("rm -rf /System/Library/Extensions/NullCPUPowerManagement.kext");
			}
					
			system_call("cp -a $slePath/AppleIntelCPUPowerManagement.kext /Extra/Extensions.EDPFix/");
			system_call("cp -a $slePath/AppleIntelCPUPowerManagement.kext/Contents/PlugIns/. /Extra/Extensions.EDPFix/");
			system_call("rm -rf /Extra/Extensions.EDPFix/AppleIntelCPUPowerManagement.kext/Contents/PlugIns");
			
			system_call("cd /Extra/EDP/bin/fixes/AICPMPatch; sudo perl AICPMPatch.pl /Extra/Extensions.EDPFix/AppleIntelCPUPowerManagement.kext/Contents/MacOS/AppleIntelCPUPowerManagement --patch");

			// system_call('sudo perl -pi -e \'s|\xE2\x00\x00\x00\x0F\x30|\xE2\x00\x00\x00\x90\x90|g\' /Extra/Extensions.EDPFix/AppleIntelCPUPowerManagement.kext/Contents/MacOS/AppleIntelCPUPowerManagement');
			// system_call('sudo perl -pi -e \'s|\xE2\x00\x00\x00\x48\x89\xF2\x0F\x30|\xE2\x00\x00\x00\x48\x89\xF2\x90\x90|g\' /Extra/Extensions.EDPFix/AppleIntelCPUPowerManagement.kext/Contents/MacOS/AppleIntelCPUPowerManagement');

			UpdateKextVersions("$workPath/logs/build/build.log");
			
			if ($genCache == "yes") {
				myHackCheck();
				KextsPermissionsAndKernelCacheFix($log, "EE");
				// system_call("sudo myfix -q -t / >> $log &");
			}
			break;
		}
		
		writeToLog("$log", "  AppleIntelCPUPowerManagement.kext patched successfullly<br>");
		system_call("touch $workPath/logs/fixes/patchSuccess.txt;");
	}


	/*
	 * WiFI and Bluetooth kext Patches
	 */
	//<-----------------------------------------------------------------------------------------------------------------------------------

	/*
	 * Patch AirPortAtheros40.kext for the card AR5B95/AR5B195 from Lion onwards
	 */
	function patchWiFiAR9285AndAR9287($log, $pathToPatch, $genCache) {
		global $slePath, $workPath;
		
		writeToLog("$log", " Applying AR9285/AR9287 WiFi kext patch for AR5B195/AR5B95 and AR5B197...<br>");

		if (!file_exists("$slePath/IO80211Family.kext/Contents/PlugIns/AirPortAtheros40.kext/Contents/Info.plist")) {
			writeToLog("$log", "  IO80211Family.kext/Contents/PlugIns/AirPortAtheros40.kext kext not found<br>");
			system_call("cd $workPath/logs/fixes; touch patchFail.txt;");
			return;
		}
		
		switch ($pathToPatch)
		{
			case "SLE":			
			// Kext patch
			system_call("sudo /usr/libexec/PlistBuddy -c \"add IOKitPersonalities:Atheros\ Wireless\ LAN\ PCI:IONameMatch:0 string \"pci168c,2b\"\" $slePath/IO80211Family.kext/Contents/PlugIns/AirPortAtheros40.kext/Contents/Info.plist");
			system_call("sudo /usr/libexec/PlistBuddy -c \"add IOKitPersonalities:Atheros\ Wireless\ LAN\ PCI:IONameMatch:0 string \"pci168c,2e\"\" $slePath/IO80211Family.kext/Contents/PlugIns/AirPortAtheros40.kext/Contents/Info.plist");
			
			// touch for kernel cache
			if ($genCache == "yes") {
				KextsPermissionsAndKernelCacheFix($log, "SLE");
				// system_call("sudo touch /System/Library/Extensions/ >> $log &");
			}
			break;
			
			case "EE":					
			system_call("cp -a $slePath/IO80211Family.kext /Extra/Extensions.EDPFix/");
			system_call("cp -a $slePath/IO80211Family.kext/Contents/PlugIns/. /Extra/Extensions.EDPFix/");
			system_call("rm -rf /Extra/Extensions.EDPFix/IO80211Family.kext/Contents/PlugIns");
			
			// Kext patch
			system_call("sudo /usr/libexec/PlistBuddy -c \"add IOKitPersonalities:Atheros\ Wireless\ LAN\ PCI:IONameMatch:0 string \"pci168c,2b\"\" /Extra/Extensions.EDPFix/IO80211Family.kext/Contents/PlugIns/AirPortAtheros40.kext/Contents/Info.plist");
			system_call("sudo /usr/libexec/PlistBuddy -c \"add IOKitPersonalities:Atheros\ Wireless\ LAN\ PCI:IONameMatch:0 string \"pci168c,2e\"\" /Extra/Extensions.EDPFix/IO80211Family.kext/Contents/PlugIns/AirPortAtheros40.kext/Contents/Info.plist");
			
			UpdateKextVersions("$workPath/logs/build/build.log");
			
			if ($genCache == "yes") {
				myHackCheck();
				KextsPermissionsAndKernelCacheFix($log, "EE");
				// system_call("sudo myfix -q -t / >> $log &");
			}
			break;
		} 
		
		writeToLog("$log", "  WiFi kext patched successfullly for AR9285/AR9287 card <br>");
		system_call("touch $workPath/logs/fixes/patchSuccess.txt;");
	}

	/*
	 * Patch AirPortBrcm4360.kext for the card BCM94352HMB from Mountain Lion 10.8.5 onwards
	 */
	function patchWiFiBTBCM4352($log, $pathToPatch, $genCache) {
		global $slePath, $workPath;
		
		writeToLog("$log", " Applying WiFi patches for BCM4352 card...<br>");

		if (!file_exists("$slePath/IO80211Family.kext/Contents/PlugIns/AirPortBrcm4360.kext/Contents/Info.plist")) {
			writeToLog("$log", "  IO80211Family.kext/Contents/PlugIns/AirPortBrcm4360.kext kext not found<br>");
			system_call("cd $workPath/logs/fixes; touch patchFail.txt;");
			return;
		}
		switch ($pathToPatch)
		{
			case "SLE":			
			// Binary patches
			system_call('sudo perl -pi -e \'s|\x01\x58\x54|\x01\x55\x53|g\' /System/Library/Extensions/IO80211Family.kext/Contents/PlugIns/AirPortBrcm4360.kext/Contents/MacOS/AirPortBrcm4360'); // region code change to US
			system_call('sudo perl -pi -e \'s|\x6B\x10\x00\x00\x75|\x6B\x10\x00\x00\x74|g\' /System/Library/Extensions/IO80211Family.kext/Contents/PlugIns/AirPortBrcm4360.kext/Contents/MacOS/AirPortBrcm4360'); // skipping binary checks of apple device id to work Appple card
			system_call('sudo perl -pi -e \'s|\x6B\x10\x00\x00\x0F\x85|\x6B\x10\x00\x00\x0F\x84|g\' /System/Library/Extensions/IO80211Family.kext/Contents/PlugIns/AirPortBrcm4360.kext/Contents/MacOS/AirPortBrcm4360'); // skipping binary checks of apple device id to work Appple card
			
			// Kext patch
			system_call("sudo /usr/libexec/PlistBuddy -c \"add IOKitPersonalities:Broadcom\ 802.11\ PCI:IONameMatch:0 string \"pci14e4,43b1\"\" /System/Library/Extensions/IO80211Family.kext/Contents/PlugIns/AirPortBrcm4360.kext/Contents/Info.plist");   
		
			// touch for kernel cache
			if ($genCache == "yes") {
				KextsPermissionsAndKernelCacheFix($log, "SLE");
				// system_call("sudo touch /System/Library/Extensions/ >> $log &");
			}
			break;
			
			case "EE":		
			system_call("cp -a $slePath/IO80211Family.kext /Extra/Extensions.EDPFix/");
			system_call("cp -a $slePath/IO80211Family.kext/Contents/PlugIns/. /Extra/Extensions.EDPFix/");
			system_call("rm -rf /Extra/Extensions.EDPFix/IO80211Family.kext/Contents/PlugIns");
			
			// Binary patches
			system_call('sudo perl -pi -e \'s|\x01\x58\x54|\x01\x55\x53|g\' /Extra/Extensions.EDPFix/IO80211Family.kext/Contents/PlugIns/AirPortBrcm4360.kext/Contents/MacOS/AirPortBrcm4360'); // region code change to US
			system_call('sudo perl -pi -e \'s|\x6B\x10\x00\x00\x75|\x6B\x10\x00\x00\x74|g\' /Extra/Extensions.EDPFix/IO80211Family.kext/Contents/PlugIns/AirPortBrcm4360.kext/Contents/MacOS/AirPortBrcm4360'); // skipping binary checks of apple device id to work Appple card
			system_call('sudo perl -pi -e \'s|\x6B\x10\x00\x00\x0F\x85|\x6B\x10\x00\x00\x0F\x84|g\' /Extra/Extensions.EDPFix/IO80211Family.kext/Contents/PlugIns/AirPortBrcm4360.kext/Contents/MacOS/AirPortBrcm4360'); // skipping binary checks of apple device id to work Appple card
			
			// Kext patch
			system_call("sudo /usr/libexec/PlistBuddy -c \"add IOKitPersonalities:Broadcom\ 802.11\ PCI:IONameMatch:0 string \"pci14e4,43b1\"\" /Extra/Extensions.EDPFix/IO80211Family.kext/Contents/PlugIns/AirPortBrcm4360.kext/Contents/Info.plist");   
			
			UpdateKextVersions("$workPath/logs/build/build.log");
			
			if ($genCache == "yes") {
				myHackCheck();
				KextsPermissionsAndKernelCacheFix($log, "EE");
				// system_call("sudo myfix -q -t / >> $log &");
			}
			break;
		} 
		
		writeToLog("$log", "  WiFi kext/binary patched successfullly for BCM4352 card<br>");
		system_call("touch $workPath/logs/fixes/patchSuccess.txt;");
	}


//<----------------------------> EDP Build functions ---------------------------------------------------------------------------------------------------

/*
 * Essential file copy like dsdt, ssdt and plists
 */
function copyEssentials($modelNamePath, $dsdt, $ssdt, $theme, $smbios, $chame) {
   
    $os = getVersion();

	$workPath = "/Extra/EDP";
	$extrapath = "/Extra";
	$modelDirPath = "$workPath/model-data/$modelNamePath";
	
    writeToLog("$workPath/logs/build/build.log", " Checking for DSDT, SSDT and System Plist files... will be overwritten if exists<br>");
    
    if (shell_exec("cd $modelDirPath/common; ls | wc -l") > 0 && 
         (!is_dir("$modelDirPath/cpu") || shell_exec("cd $modelDirPath/cpu; ls | wc -l") > 0)) 
    {
		writeToLog("$workPath/logs/build/build.log", " Found Essential files downloaded from SVN, Copying...</b><br>");
	}
	else {
		writeToLog("$workPath/logs/build/build.log", " Essential files not downloaded from SVN (either not found or no internet)</b><br>");
		return;
	}
		
	//
    // use EDP SMBIos?
    //
    if($smbios == "yes")
    {
    	$file1 = "$modelDirPath/common/SMBios.plist"; 
    	$file1Alt = "$modelDirPath/common/smbios.plist"; 
    	
    	// Copy file from common folder if exists
    	if(file_exists($file1)) {
    		system_call("cp -f $file1 $extrapath"); 
   			writeToLog("$workPath/logs/build/build.log", "  Common SMBios.plist found, Copying to $extrapath<br>");
    	}
    	elseif(file_exists($file1Alt)) {
    		system_call("cp -f $file1Alt $extrapath"); 
   			writeToLog("$workPath/logs/build/build.log", "  Common SMBios.plist found, Copying to $extrapath<br>");
    	}
    	
    	$file2 = "$modelDirPath/$os/SMBios.plist"; 
    	$file2Alt = "$modelDirPath/$os/smbios.plist"; 
    	
    	// Copy file from os folder if exists
    	if(file_exists($file2)) {
    		system_call("cp -f $file2 $extrapath");
   			writeToLog("$workPath/logs/build/build.log", "  OSX specific SMBios.plist found, Copying to $extrapath <br>");
    	}
    	elseif(file_exists($file2Alt)) {
    		system_call("cp -f $file2Alt $extrapath");
   			writeToLog("$workPath/logs/build/build.log", "  OSX specific SMBios.plist found, Copying to $extrapath <br>");
    	}
    	
    } else {
    	writeToLog("$workPath/logs/build/build.log", "  Skipping SMBios.plist file from EDP on user request<br>");
    }
    
    //
    // use EDP org.chameleon.Boot.plist?
    //
    if($chame == "yes")
    {
    	$file1 = "$modelDirPath/common/org.chameleon.Boot.plist"; 

    	// Copy file from common folder if exists
    	if(file_exists($file1)) {
    		system_call("cp -f $file1 $extrapath"); 
   	  		writeToLog("$workPath/logs/build/build.log", "  Common org.chameleon.Boot.plist found, Copying to $extrapath<br>");
    	}
    	
	    $file2 = "$modelDirPath/$os/org.chameleon.Boot.plist"; 

    	// Copy file from os folder if exists
    	if(file_exists($file2)) {
    		system_call("cp -f $file2 $extrapath");
   	    	writeToLog("$workPath/logs/build/build.log", "  OS specific org.chameleon.Boot.plist found, Copying to $extrapath<br>");
    	}
    	
    	// set UseKernelCache to Yes from org.chameleon.Boot.plist
		system("sudo /usr/libexec/PlistBuddy -c \"set UseKernelCache Yes\" $extrapath/org.chameleon.Boot.plist");
		
		//
		// Add kext-dev-mode flag for Yosemite in for common org.chameleon.Boot.plist
		//
		if($os == "yos" && file_exists($file1) && !file_exists($file2)) {
			system("sudo /usr/libexec/PlistBuddy -c \"delete Kernel\ Flags\" $extrapath/org.chameleon.Boot.plist"); 
			system("sudo /usr/libexec/PlistBuddy -c \"add Kernel\ Flags string kext-dev-mode=1\" $extrapath/org.chameleon.Boot.plist"); 
		}
   	 	
    } else {
    	writeToLog("$workPath/logs/build/build.log", "  Skipping org.chameleon.Boot.plist file from EDP on user request<br>");
    }
    
    //
    // use EDP DSDT?
    //
    if($dsdt == "yes")
    {
    	$file1 = "$modelDirPath/common/DSDT.aml"; 
    	$file1Alt = "$modelDirPath/common/dsdt.aml"; 

    	// Copy file from common folder if exists
    	if(file_exists($file1)) {
    		system_call("cp -f $file1 $extrapath");
    		writeToLog("$workPath/logs/build/build.log", "  Common dsdt found, Copying to $extrapath<br>");
    	}
    	elseif(file_exists($file1Alt)) {
    		system_call("cp -f $file1Alt $extrapath");
    		writeToLog("$workPath/logs/build/build.log", "  Common dsdt found, Copying to $extrapath<br>");
    	}
    	
    	$file2 = "$modelDirPath/$os/DSDT.aml"; 
    	$file2Alt = "$modelDirPath/$os/dsdt.aml"; 
    	
    	// Copy file from os folder if exists
    	if(file_exists($file2)) {
    		system_call("cp -f $file2 $extrapath");
    		writeToLog("$workPath/logs/build/build.log", "  OS specific dsdt found, Copying to $extrapath<br>");
    	}
    	elseif(file_exists($file2Alt)) {
    		system_call("cp -f $file2Alt $extrapath");
    		writeToLog("$workPath/logs/build/build.log", "  OS specific dsdt found, Copying to $extrapath<br>");
    	}
    	
    } else {
    	writeToLog("$workPath/logs/build/build.log", "  Skipping DSDT file from EDP on user request<br>");
    }						
	
	//
	// use EDP SSDT?
	//
    if($ssdt == "yes")
    {
    
      // Fins path for SSDT files
      if (is_dir("$modelDirPath/cpu") && shell_exec("cd $modelDirPath/cpu; ls | wc -l") > 0) {
      	$ssdtFilesPath = "$modelDirPath/cpu";
      }
      else {
      	$ssdtFilesPath = "$modelDirPath/common";
      }
      
      if (file_exists("$extrapath/SSDT.aml")) { system_call("rm $extrapath/SSDT.aml"); }
      $file = "$ssdtFilesPath/SSDT.aml";
  	  if (file_exists($file)) 
       { 
    		writeToLog("$workPath/logs/build/build.log", "  SSDT files found, Copying to $extrapath<br>");
    		system_call("cp -f $file $extrapath");
    		
    		// set DropSSDT to Yes from org.chameleon.Boot.plist
			system("sudo /usr/libexec/PlistBuddy -c \"set DropSSDT Yes\" $extrapath/org.chameleon.Boot.plist"); 
   		}
   		
    	if (file_exists("$extrapath/SSDT-1.aml")) { system_call("rm $extrapath/SSDT-1.aml"); }
   		$file = "$ssdtFilesPath/SSDT-1.aml"; if (file_exists($file)) { 
   			system_call("cp -f $file $extrapath"); 
    	}
    	
    	if (file_exists("$extrapath/SSDT-2.aml")) { system_call("rm $extrapath/SSDT-2.aml"); }
    	$file = "$ssdtFilesPath/SSDT-2.aml"; if (file_exists($file)) { 
    		system_call("cp -f $file $extrapath"); 
    	}
    	
    	if (file_exists("$extrapath/SSDT-3.aml")) { system_call("rm $extrapath/SSDT-3.aml"); }
    	$file = "$ssdtFilesPath/SSDT-3.aml"; if (file_exists($file)) { 
    		system_call("cp -f $file $extrapath"); 
    	}

    	if (file_exists("$extrapath/SSDT-4.aml")) { system_call("rm $extrapath/SSDT-4.aml"); } 
    	$file = "$ssdtFilesPath/SSDT-4.aml"; if (file_exists($file)) {
    		system_call("cp -f $file $extrapath"); 
    	}
    	
    	if (file_exists("$extrapath/SSDT-5.aml")) { system_call("rm $extrapath/SSDT-5.aml"); } 
    	$file = "$ssdtFilesPath/SSDT-5.aml"; if (file_exists($file)) {
    		system_call("cp -f $file $extrapath"); 
    	}	
    }  
    else {
    	writeToLog("$workPath/logs/build/build.log", "  Skipping SSDT files from EDP on user request<br>");
    }
    
    //
    // Copy Themes folder to Extra
    //
    if($theme == "yes")
    {
    	writeToLog("$workPath/logs/build/build.log", "  Copying Themes folder to /Extra...<br>");
		if (!is_dir("/Extra/Themes")) {
			system_call("mkdir /Extra/Themes");
		 }
		 else {
		 	system_call("rm -rf /Extra/Themes/*");
		 }
	 
		if(is_dir("$modelDirPath/common/Themes")) {
			system_call("cp -a $modelDirPath/common/Themes/. /Extra/Themes");
		}
		// Standard theme folder
		else {
			system_call("cp -a $workPath/bin/Themes/. /Extra/Themes");
		}
    }
    else {
    	writeToLog("$workPath/logs/build/build.log", "  Skipping Themes from EDP on user request<br>");
    }
    
}

 /*
  * Function to check if myhack.kext exists in ale, 
  * and if it dosen't for some weird reason... copy it there...
  */
 	function myHackCheck() {
  	  	global $workPath, $slePath;

		 // copy kext to workPath
		 system_call("cp -R \"$workPath/bin/myHack/myHack.kext\" $workPath");
			
		 // Remove svn versioning
		 system_call("rm -Rf `find -f path \"$workPath/myHack.kext\" -type d -name .svn`");
	
		 // copy kext to sle
		 if (!is_dir("$slePath/myHack.kext")) {	
			system_call("cp -R \"$workPath/bin/myHack/myHack.kext\" $slePath");
		 }
  
		 if (!is_file("/usr/sbin/")) {
			system_call("cp \"$workPath/bin/myHack/myfix\" /usr/sbin/myfix; chmod 777 /usr/sbin/myfix");
		 }
	}
	 
/*
 * Copy EDP Kexts copy for build
 */
 function PrepareEDPKextpacks()
 {
 	//Get vars from config.inc.php
    global $workPath, $svnpackPath, $rootPath, $slePath, $modelNamePath, $eePath;
    global $ps2db, $audiodb, $wifidb, $cpufixdb, $batterydb, $landb, $fakesmcdb;
    global $modeldb, $modelRowID;
    global $os;
    
    //Get our class(s)
    global $builder;
	global $svnLoad;

	// model path
	$modelDirPath = "$workPath/model-data/$modelNamePath";
	
    // Use EDP Kexts?
    if($modeldb[$modelRowID]['useEDPExtensions'] == "on")
    {
    	//
    	// copying PS2 kexts from kextpacks
    	//
    	$ps2id = $modeldb[$modelRowID]['ps2pack'];
    
    	if ($ps2id != "" && $ps2id != "no")
        {
    		$fname = $ps2db[$ps2id]["foldername"];
    		
    		// remove installed kexts before
			if (is_dir("/Extra/Extensions/VoodooPS2Controller.kext"))  {
				system_call("rm -rf /Extra/Extensions/VoodooPS2Controller.kext");
			}
			if (is_dir("/Extra/Extensions/ApplePS2Controller.kext"))  {
				system_call("rm -rf /Extra/Extensions/ApplePS2Controller.kext");
			}
			if (is_dir("/Extra/Extensions/AppleACPIPS2Nub.kext"))  {
				system_call("rm -rf /Extra/Extensions/AppleACPIPS2Nub.kext");
			}
			if (is_dir("/Extra/Extensions/ApplePS2ElanTouchpad.kext"))  {
				system_call("rm -rf /Extra/Extensions/ApplePS2ElanTouchpad.kext");
			}
						
    		// remove voodooPS2 files if its installed before for non-voodoo install
    		if($ps2id != "2" && $ps2id != "5" && $ps2id != "6")
    		{
        		if(is_dir("/Library/PreferencePanes/VoodooPS2.prefpane")) {system_call("rm -rf /Library/PreferencePanes/VoodooPS2.prefpane");}
        		if(file_exists("/usr/bin/VoodooPS2Daemon")) {system_call("rm -rf /usr/bin/VoodooPS2Daemon");}
        		if(file_exists("/Library/LaunchDaemons/org.rehabman.voodoo.driver.Daemon.plist")) {system_call("rm -rf /Library/LaunchDaemons/org.rehabman.voodoo.driver.Daemon.plist");}
        		if(is_dir("/Library/PreferencePanes/VoodooPS2synapticsPane.prefPane")) {system_call("rm -rf /Library/PreferencePanes/VoodooPS2synapticsPane.prefPane");}
    		}
    	
        	if ($fname != "") { 
        	    writeToLog("$workPath/logs/build/build.log", " Preparing to download Touchpad kext $fname...<br>");
        	    
        	    if(!is_dir("$svnpackPath/PS2Touchpad"))
    				system_call("mkdir $svnpackPath/PS2Touchpad");
    				
    			$svnLoad->PrepareKextpackDownload("PS2Touchpad", "$fname", "$fname");
    		}
		 } 
		// Reset vars
		$name = "";
		$fname = "";
		
		
		//
    	// copying Wifi/BT kexts from kextpacks / patch WiFi/BT Kexts
    	//
    	if ($modeldb[$modelRowID]['wifipack'] != "" && $modeldb[$modelRowID]['wifipack'] != "no") 
    	{
        	$wifid = $modeldb[$modelRowID]['wifipack'];
        	$name = $wifidb[$wifid]['name'];
        	$fname = $wifidb[$wifid]['foldername'];
        	
        	if ($name != "") {
        	    		
    		switch($wifid) {
    			case 0:    			
    				writeToLog("$workPath/logs/build/build.log", " Patching WiFi kext for $name...<br>");
    				patchWiFiAR9285AndAR9287("$workPath/logs/build/build.log","EE", "no");
    			break;
    			
    			case 1:
    			    writeToLog("$workPath/logs/build/build.log", " Patching WiFi kext for $name...<br>");

    				if(getMacOSXVersion() >= "10.8.5")
    					patchWiFiBTBCM4352("$workPath/logs/build/build.log","EE", "no");
    				else
    					writeToLog("$workPath/logs/build/build.log", "  OSX version is not supported for WiFi, need OSX 10.8.5 or later<br>");
    			break;
    			
    			case 2:
    				writeToLog("$workPath/logs/build/build.log", " Preparing to download rollback WiFi kext $fname...<br>");
    					
    				if(!is_dir("$svnpackPath/Wireless"))
    					system_call("mkdir $svnpackPath/Wireless");
    				
    				$svnLoad->PrepareKextpackDownload("Wireless", "$fname", "$fname");
    			break;
    		}
    		
    		// Load Bluetooth kext for AR3011 and BCM4352
    		if($wifid < "3")
    			{
    				writeToLog("$workPath/logs/build/build.log", " Preparing to download Bluetooth kext $fname...<br>");
        	    
        	    	 if(!is_dir("$svnpackPath/Wireless"))
    					system_call("mkdir $svnpackPath/Wireless");
    					
    				 $svnLoad->PrepareKextpackDownload("Wireless", "BluetoothFWUploader", "BluetoothFWUploader.kext");
    			}
    		}
		}
		// Reset vars
		$name = "";
		$fname = "";    

		 //
   		 // copying fakesmc kexts from kextpacks
   		 //
    	
    	if ($modeldb[$modelRowID]['fakesmc'] != "" && $modeldb[$modelRowID]['fakesmc'] != "no")
    	 {   
    		$fakesmcid = $modeldb[$modelRowID]['fakesmc'];
    		$fname = $fakesmcdb[$fakesmcid]['foldername'];
    		$name = $fakesmcdb[$fakesmcid]['name']; 
    		
    		if ($fname != "") {
    			writeToLog("$workPath/logs/build/build.log", " Preparing to download FakeSMC kext $fname...<br>");
        	    
        	    if(!is_dir("$svnpackPath/FakeSMC"))
    				system_call("mkdir $svnpackPath/FakeSMC");
    					
    			$svnLoad->PrepareKextpackDownload("FakeSMC", "$fname", "$name");
    		}
     	}
		// Reset vars
		$name = "";
		$fname = "";	
    	
    	
    	//
    	// copying audio kexts
    	//
    	if ($modeldb[$modelRowID]['audiopack'] != "" && $modeldb[$modelRowID]['audiopack'] != "no")
        {
        
        	$audioid = $modeldb[$modelRowID]['audiopack'];
    		$fname = $audiodb[$audioid]['foldername']; 
    		$name = $audiodb[$audioid]['name']; 
       			
       		// Remove HDA Enabler
       		if (is_dir("$slePath/HDAEnabler.kext")) { system_call("rm -Rf $slePath/HDAEnabler.kext"); }

   			//
			// Check for AppleHDA		
			//
			$usingAppleHDA = "";
			switch ($audioid) {
					case "sl":    				
					case "lion":    				
					case "ml":    				
					case "mav":    				
					case "yos":
					
						global $modelID, $edp_db;
						global $os, $sysType;
				
						switch ($sysType) {
						  case "Mobile Workstation":
						  case "Notebook":
						  case "Ultrabook":
						  case "Tablet":
							$applehda = $edp_db->query("SELECT * FROM applehdaNB WHERE model_id = '$modelID'");
						  break;
		  
						  case "Desktop":
						  case "Workstation":
						  case "AllinOnePC":
							$applehda = $edp_db->query("SELECT * FROM applehdaDesk WHERE model_id = '$modelID'");
						  break;
						}
						
						foreach($applehda as $row) {
						
							$aID = explode(',', $row[$audioid]);
						
							if (getVersion() >= $aID[1]) {
								writeToLog("$workPath/logs/build/build.log", " Preparing to download Audio kext patched $audioid AppleHDA...<br>");

								if(!is_dir("$modelDirPath/applehda"))
									system_call("mkdir $modelDirPath/applehda");
				
								$svnLoad->PrepareKextpackDownload("Extensions", "audiocommon", "$modelNamePath/applehda");
								$svnLoad->PrepareKextpackDownload("Extensions", "audio$audioid", "$modelNamePath/applehda");
								$usingAppleHDA = "yes";
							}
							else 
							{
								writeToLog("$workPath/logs/build/build.log", " Chosen Patched AppleHDA is not supported in this OSX version, using latest VoodooHDA instead<br>");
							}
						}
					case "no":
						//
						// Remove voodooHDA related files if installed before
						//
						if (is_dir("$slePath/VoodooHDA.kext")) { system_call("rm -Rf $slePath/VoodooHDA.kext"); }
						if (is_dir("$slePath/AppleHDADisabler.kext")) { system_call("rm -Rf $slePath/AppleHDADisabler.kext"); }

						if(is_dir("/Applications/VoodooHdaSettingsLoader.app")) {system_call("rm -rf /Applications/VoodooHdaSettingsLoader.app");}
						if(file_exists("/Library/LaunchAgents/com.restore.voodooHDASettings.plist")) {system_call("rm -rf /Library/LaunchAgents/com.restore.voodooHDASettings.plist");}
						if(is_dir("/Library/PreferencePanes/VoodooHDA.prefPane")) {system_call("rm -rf /Library/PreferencePanes/VoodooHDA.prefPane");}
					break;
				}
    		
    		//
    		// Check for VoodooHDA
    		//
        	if ($fname != "" && $usingAppleHDA == "") {
    			        
    		    writeToLog("$workPath/logs/build/build.log", " Preparing to download Audio kext $fname...<br>");

    			if(!is_dir("$svnpackPath/Audio"))
    				system_call("mkdir $svnpackPath/Audio");
    					    
        		$svnLoad->PrepareKextpackDownload("Audio", "$fname", "$name");
        		
        		// Copy Prefpane and Settings loader
        		$svnLoad->PrepareKextpackDownload("Audio", "Settings", "AudioSettings");
        	} 
        	
   	 	}
   	 	// Reset vars
		$name = "";
		$fname = "";
	
		//
		// copying ethernet kexts from kextpacks
		//
    	if ($modeldb[$modelRowID]['ethernet'] != "" && $modeldb[$modelRowID]['ethernet'] != "no")
    	 {
        	$lanid = $modeldb[$modelRowID]['ethernet'];
        	$name = $landb[$lanid]['name'];
        	$fname = $landb[$lanid]['foldername'];
        	
        	if ($fname != "") {
        		
        		writeToLog("$workPath/logs/build/build.log", " Preparing to download Ethernet kext $name...<br>");
        	    
    			if(!is_dir("$svnpackPath/Ethernet"))
    				system_call("mkdir $svnpackPath/Ethernet");
    			
    			// Category folder
    			if(!is_dir("$svnpackPath/Ethernet/$fname"))
    				system_call("mkdir $svnpackPath/Ethernet/$fname");
    		
    			// New Realtek kext
    			if($lanid == "11") {
				
					// Choose 10.8+ version 
					if(getMacOSXVersion() >= "10.8")
						$svnLoad->PrepareKextpackDownload("Ethernet", "$fname", "RealtekRTL8111");
					
					// Choose Lion version
					else if(getMacOSXVersion() == "10.7")
						$svnLoad->PrepareKextpackDownload("Ethernet", "$fname", "RealtekRTL8111_Lion");
    			}
    			else
    				$svnLoad->PrepareKextpackDownload("Ethernet", "$fname", "$name");   
     	  	}	
		}
		// Reset vars
		$name = "";
		$fname = "";
		
	 //	
	 // copying battery kexts from kextpacks
	 //
   	 if ($modeldb[$modelRowID]['batterypack'] != "" && $modeldb[$modelRowID]['batterypack'] != "no") 
   	 {
        $battid = $modeldb[$modelRowID]['batterypack'];
        $fname = $batterydb[$battid]['foldername'];
        $name = $batterydb[$battid]['name'];
        
        if ($fname != "") {
        		writeToLog("$workPath/logs/build/build.log", " Preparing to download Battery kext $name...<br>");
        	    
        	    if(!is_dir("$svnpackPath/Battery"))
    				system_call("mkdir $svnpackPath/Battery");
    				
    			$svnLoad->PrepareKextpackDownload("Battery", "$fname", "$name");  
    		}
	   }
		// Reset vars
		$name = "";
		$fname = "";
    } 
    else {
    	writeToLog("$workPath/logs/build/build.log", " Skipping Standard Kexts from EDP on user request<br>");
    }
    
    //
    // Copy selected optional kexts
    //
    $data = $modeldb[$modelRowID]['optionalpacks'];
    $array 	= explode(',', $data);
    global $edpDBase;
    
    foreach($array as $id) {
    	$opdata = $edpDBase->getKextpackDataFromID("optionalpacks", $id);
        $categ = $opdata[category];
        $fname = $opdata[foldername];
        $name = $opdata[name];
        
         if ($fname != "") { 
         
         	writeToLog("$workPath/logs/build/build.log", " Preparing to download Optional pack $name...<br>");

    		if(!is_dir("$svnpackPath/$categ"))
    			system_call("mkdir $svnpackPath/$categ");
    		
    		// Generic XHCI USB3.0
    		if($id == "5") {
				// Choose new version 
				if(getMacOSXVersion() >= "10.8.5")
					$svnLoad->PrepareKextpackDownload("$categ", "GenericXHCIUSB3_New", "$name");
				
				// Choose old version
				else if(getMacOSXVersion() < "10.8.5")
					$svnLoad->PrepareKextpackDownload("$categ", "$fname", "$name");
    		}
    		else	
    			$svnLoad->PrepareKextpackDownload("$categ", "$fname", "$name");
    	 }
      }
    	// Reset vars
		$name = "";
		$fname = "";
		
	writeToLog("$workPath/logs/build/build.log", " Preparing to download Standard kexts... <br>");

	//
    // Standard kexts
    //
    if(!is_dir("$workPath/svnpacks/Standard"));
    	system_call("mkdir $workPath/svnpacks/Standard");
    	
    $svnLoad->PrepareKextpackDownload("Standard", "common", "Standard common");

    $svnLoad->PrepareKextpackDownload("Standard", "$os", "Standard $os");
    
    writeToLog("$workPath/logs/build/build.log", " Preparing to download Model specific kexts... <br>");

    //
	// From Model data (Extensions folder)
	//
	$svnLoad->PrepareKextpackDownload("Extensions", "kextscommon", "$modelNamePath/Extensions");
	$svnLoad->PrepareKextpackDownload("Extensions", "kexts$os", "$modelNamePath/Extensions");
	
    // From Model data (Common and $os folder used before, have to remove this when all the models updated to new Extensions folder)
    if(is_dir("$modelDirPath/common/Extensions"))
    {
    	writeToLog("$workPath/logs/build/build.log", "  Copying kexts from model common folder to $eePath<br>");
    	$tf = "$modelDirPath/common/Extensions";
    	system_call("cp -a $tf/. $eePath/");
    }
    if(is_dir("$modelDirPath/$os/Extensions"))
    {
    	writeToLog("$workPath/logs/build/build.log", "  Copying kexts from model $os folder to $eePath<br>");
    	$tf = "$modelDirPath/$os/Extensions";
    	system_call("cp -a $tf/. $eePath/");
    }
    
    //
    // Download custom kernel from EDP
    //
    	  	
    $svnLoad->PrepareKextpackDownload("Kernel", "kernel$os", "$modelNamePath/Kernel");
    
	
    //
    // Create a script file if we need to copy kexts from Extra/include/Extensions
    //
    if($modeldb[$modelRowID]["useIncExtensions"] == "on")
    {
    	writeToLog("$workPath/logs/build/dLoadScripts/CopyCustomKexts.sh", "");
    } 
    
 }
 
/*
 * Fixes
 */
function applyFixes() {
	//Get vars from config.inc.php
    global $workPath, $rootPath, $slePath, $modelNamePath, $os, $eePath;
    global $sysType, $modeldb, $modelRowID, $modelID;
	global $edpDBase;
	global $cpufixdb;

	// model path
	$modelDirPath = "$workPath/model-data/$modelNamePath";
	
	//Get our class(s)
	global $svnLoad;
	
	//kextpack svn path
	$svnpackPath = "$workPath/svnpacks";
	
    writeToLog("$workPath/logs/build/build.log", " Applying fixes and patches...... <br>");
	
	//
	// Apply power management related fixes 
	//
    $mdata = $edpDBase->getModelDataFromID($sysType, $modelID);
    $array 	= explode(',', $mdata['pmfixes']);
    
    $i = 0; // iterating through all the id's
	while ($cpufixdb[$i] != "") {
	    // Get foldername from ID
        $cpufixdata = $edpDBase->getKextpackDataFromID("pmfixes", "$i");
        $foldername = $cpufixdata[foldername];
        $name = $cpufixdata[edpid];
        
        // Checking if we need to patch AppleIntelCPUPowerManagement.kext
        if(($modeldb[$modelRowID]['applecpupwr'] == "on") && $i == "1") {
        	patchAppleIntelCPUPowerManagement("$workPath/logs/build/build.log","EE", "no");
        }
        else if(($modeldb[$modelRowID]['emupstates'] == "on") && $i == "3") {
        	
        	$svnLoad->PrepareKextpackDownload("PowerMgmt", "VoodooPState", "$foldername"); 
        }
        else if ($foldername != "" && $modeldb[$modelRowID][$cpufixdata[edpid]] == "on") { 

    		if(!is_dir("$svnpackPath/PowerMgmt"))
    			system_call("mkdir $svnpackPath/PowerMgmt");
    		
    		$svnLoad->PrepareKextpackDownload("PowerMgmt", "$foldername", "$foldername");
    		
    		 //remove PStateMenu if installed before
    		 if (file_exists("/Library/LaunchAgents/PStateMenu.plist")) { system_call("rm -rf /Library/LaunchAgents/PStateMenu.plist"); }
    	}
    	$i++;
	}

	// Reset vars
	$name = "";
	$fname = "";
		
	//
 	// Apply Generic fixes
 	//
    $data = $modeldb[$modelRowID]['fixes'];
    $array 	= explode(',', $data);
    
    foreach($array as $id) {
	    //Getting names from ID
	    $fixdata = $edpDBase->getKextpackDataFromID("sysfixes", "$id");
        $categ = $fixdata[category];
        $fname = $fixdata[foldername];
        $name = $fixdata[name];
        
       if($id == "2") {
       		patchAHCI();
       }
       else if($id == "8") {
        	patchAppleIntelSNBGraphicsFB("$workPath/logs/build/build.log","EE", "no");
        }
       else if ($fname != "") { 

			if($id == "1") {
       			writeToLog("$workPath/logs/build/build.log", " Applying ACPI fix for Battery read and Coolbook...<br>");
       		}
       		else if($id == "5") {
       			writeToLog("$workPath/logs/build/build.log", " Preparing to download patched IOATAFamily fix for IDE disks...<br>");
       		}
       		else if($id == "9") {
       			writeToLog("$workPath/logs/build/build.log", " Preparing to download $name fix for Apple store access...<br>");
       		}
       		else {
       		 	writeToLog("$workPath/logs/build/build.log", " Preparing to download $name fix...<br>");
       		}
       		
    		if(!is_dir("$svnpackPath/$categ"))
    			system_call("mkdir $svnpackPath/$categ");
    		
    		$svnLoad->PrepareKextpackDownload("$categ", "$fname", "$name");
    	}
	}
    	
    // Reset vars
	$name = "";
	$fname = "";
} 
 
/*
 * Copying custom kexts 
 */
function copyCustomFiles() {
    //Get vars from config.inc.php
    global $workPath, $rootPath, $slePath, $incPath, $os, $eePath, $modelNamePath;
	global $modeldb, $modelRowID;
	
	// model path
	$modelDirPath = "$workPath/model-data/$modelNamePath";
	
	$extrapath = "/Extra";

	writeToLog("$workPath/logs/build/build.log", " Checking for Custom files from EDP model database... <br>");

	//
    // Check if we need a custom version of chameleon from essential common and $os folders
    //
    if ($modeldb[$modelRowID]['customCham'] == "on") {
        
        $cboot = "$modelDirPath/common/boot";
        $osboot = "$modelDirPath/$os/boot";
        
        if(is_file("$cboot") || is_file("$osboot"))
        {
        	writeToLog("$workPath/logs/build/build.log", "  Custom chameleon found, copied to $rootPath <br>");

        	system_call("rm -f $rootPath/boot");
        	system_call("cp $modelDirPath/common/boot $rootPath");
        	system_call("cp $modelDirPath/$os/boot $rootPath");
        }
    }
    
	//
    // Check if we need a custom made kernel from EDP model kernel folder
    //
    
    if(is_dir("$modelDirPath/kernel/kernel$os")) {
        	
        $ckernel = "$modelDirPath/kernel/kernel$os/custom_kernel";
        if(is_file("$ckernel"))
        {
        	writeToLog("$workPath/logs/build/build.log", "  Custom kernel found, copied to $rootPath <br>");
        	system_call("rm -f $rootPath/custom_kernel");
       		system_call("cp $modelDirPath/kernel/kernel$os/custom_kernel $rootPath");
        }
        $kernelos = "$modelDirPath/kernel/kernel$os/mach_kernel";
        if(is_file("$kernelos"))
        {
        	writeToLog("$workPath/logs/build/build.log", "  Custom mach_kernel found, copied to $rootPath <br>");
        	system_call("rm -f $rootPath/mach_kernel");
       		system_call("cp $modelDirPath/kernel/kernel$os/mach_kernel $rootPath");
        }
    }
    
	writeToLog("$workPath/logs/build/build.log", " Checking for user provided custom files from $incPath... <br>");

	//
    // Copy essentials from /Extra/include if user has
    //

    if (is_file("$incPath/smbios.plist") && $modeldb[$modelRowID]["useIncSMBIOS"] == "on") 				{ 
    	writeToLog("$workPath/logs/build/build.log", "  Custom smbios.plist found, Copied from $incPath to $extrapath<br>");
    	system_call("cp -f $incPath/smbios.plist /Extra"); 
    }
    if (is_file("$incPath/org.chameleon.Boot.plist") && $modeldb[$modelRowID]["useIncCHAM"] == "on") 	{ 
    	writeToLog("$workPath/logs/build/build.log", "  Custom org.chameleon.Boot.plist found, Copied from $incPath to $extrapath<br>");
    	system_call("cp -f $incPath/org.chameleon.Boot.plist /Extra"); 
    }
    if (is_file("$incPath/dsdt.aml") && $modeldb[$modelRowID]["useIncDSDT"] == "on") 					{ 
    	writeToLog("$workPath/logs/build/build.log", "  Custom dsdt file found, Copied from $incPath to $extrapath<br>");
    	system_call("cp -f $incPath/dsdt.aml /Extra"); 
    }
    if($modeldb[$modelRowID]["useIncSSDT"] == "on")
    {
    	if (is_file("$incPath/SSDT.aml")) 					{ 
    		writeToLog("$workPath/logs/build/build.log", "  Custom SSDT files found, Copied from $incPath to $extrapath<br>");
    		system_call("cp -f $incPath/SSDT.aml /Extra"); 
    	}
    	if (is_file("$incPath/SSDT-1.aml")) 				{ system_call("cp -f $incPath/SSDT-1.aml /Extra"); }
    	if (is_file("$incPath/SSDT-2.aml")) 				{ system_call("cp -f $incPath/SSDT-2.aml /Extra"); }
    	if (is_file("$incPath/SSDT-3.aml")) 				{ system_call("cp -f $incPath/SSDT-3.aml /Extra"); }    
    	if (is_file("$incPath/SSDT-4.aml")) 				{ system_call("cp -f $incPath/SSDT-4.aml /Extra"); }
    	if (is_file("$incPath/SSDT-5.aml")) 				{ system_call("cp -f $incPath/SSDT-5.aml /Extra"); }  
    }
    
    //
    // Copy Custom Themes folder from $incpatch to /Extra
    //
    if(is_file("$workPath/logs/build/dLoadScripts/CopyCustomTheme.sh") && shell_exec("cd $incPath/Themes; ls | wc -l") > 0)
    {
    	if (is_dir("$incPath/Themes")) {
			writeToLog("$workPath/logs/build/build.log", "  Custom themes folder found, copied to /Extra<br>");
			system_call("rm -rf /Extra/Themes");
			system_call("mkdir /Extra/Themes");
			system_call("cp -a $incPath/Themes/. /Extra/Themes/");
     	}
    }
     
	//
    // Copying Custom kexts from include if CopyCustomKexts file exists
    //
    if(is_file("$workPath/logs/build/dLoadScripts/CopyCustomKexts.sh") && shell_exec("cd $incPath/Extensions; ls | wc -l") > 0)
    {
    	writeToLog("$workPath/logs/build/build.log", "  Custom kexts found, copied to /Extra<br>");
    	system_call("cp -a $incPath/Extensions/. $eePath/");
    	
    	//If AppleHDA is found in Extra/include then remove VoodooHDA from ee
    	if(file_exists("$incPath/Extensions/AppleHDA.kext")) {
    			if(is_dir("/Applications/VoodooHdaSettingsLoader.app")) {system_call("rm -rf /Applications/VoodooHdaSettingsLoader.app");}
        	 	if(file_exists("/Library/LaunchAgents/com.restore.voodooHDASettings.plist")) {system_call("rm -rf /Library/LaunchAgents/com.restore.voodooHDASettings.plist");}
        	 	if(is_dir("/Library/PreferencePanes/VoodooHDA.prefPane")) {system_call("rm -rf /Library/PreferencePanes/VoodooHDA.prefPane");}
    			system_call("rm -rf $eePath/VoodooHDA.kext");
    			system_call("rm -rf $eePath/AppleHDADisabler.kext");
    			writeToLog("$workPath/logs/build/build.log", "  Found AppleHDA from $incPath, VoodooHDA files will be removed if exists<br>");
   		 }
    } 

}	
	
?>