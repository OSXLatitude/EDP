<?php

class chamModules {

	//-----> Copies modules from EDP/modules to /Extra/modules by removing old onces first - it will only copy whatever is defined in $chamModConfig
	public function copyChamModules($chamModConfig) {
		global $workPath;
		$modpathFROM 	= "$workPath/bin/modules";
		$modpathTO 		= "/Extra/modules/";
	
		if(!is_dir("/Extra/modules"));
    			system_call("mkdir /Extra/modules");
    			
		//Cleaning existing modules folder
		system_call("rm -Rf /Extra/modules/*");
	
		//Copying modules
		if ($chamModConfig['ACPICodec'] == "on") 		{ system_call("cp -Rf $modpathFROM/ACPICodec.dylib $modpathTO"); }
		if ($chamModConfig['FileNVRAM'] == "on") 		{ system_call("cp -Rf $modpathFROM/FileNVRAM.dylib $modpathTO"); }
		if ($chamModConfig['KernelPatcher'] == "on") 	{ system_call("cp -Rf $modpathFROM/KernelPatcher.dylib $modpathTO"); }
		if ($chamModConfig['Keylayout'] == "on") 		{ system_call("cp -Rf $modpathFROM/Keylayout.dylib $modpathTO"); }		
		if ($chamModConfig['klibc'] == "on") 			{ system_call("cp -Rf $modpathFROM/klibc.dylib $modpathTO"); }
		if ($chamModConfig['Resolution'] == "on") 		{ system_call("cp -Rf $modpathFROM/Resolution.dylib $modpathTO"); }	
		if ($chamModConfig['Sata'] == "on") 			{ system_call("cp -Rf $modpathFROM/Sata.dylib $modpathTO"); }
		if ($chamModConfig['uClibcxx'] == "on") 		{ system_call("cp -Rf $modpathFROM/uClibcxx.dylib $modpathTO"); }
		if ($chamModConfig['HDAEnabler'] == "on") 		{ system_call("cp -Rf $modpathFROM/HDAEnabler.dylib $modpathTO"); }
			
	}


	//----> Get current configuration from /Extra/modules folder by checking wich files is there
	public function chamModGetConfig() {
		global $workPath;
		$modpath = "/Extra/modules";

		$array = array(
			"ACPICodec" => (is_file("$modpath/ACPICodec.dylib") === TRUE ? "yes" : "no"),
			"FileNVRAM" => (is_file("$modpath/FileNVRAM.dylib") === TRUE ? "yes" : "no"),
			"KernelPatcher" => (is_file("$modpath/KernelPatcher.dylib") === TRUE ? "yes" : "no"),
			"Keylayout" => (is_file("$modpath/Keylayout.dylib") === TRUE ? "yes" : "no"),
			"klibc" => (is_file("$modpath/klibc.dylib") === TRUE ? "yes" : "no"),
			"Resolution" => (is_file("$modpath/Resolution.dylib") === TRUE ? "yes" : "no"),
			"Sata" => (is_file("$modpath/Sata.dylib") === TRUE ? "yes" : "no"),
			"uClibcxx" => (is_file("$modpath/uClibcxx.dylib") === TRUE ? "yes" : "no"),
			"HDAEnabler" => (is_file("$modpath/HDAEnabler.dylib") === TRUE ? "yes" : "no"),
			
		);
		return $array;	
	}	
}


$chamModules = new chamModules();


?> 
