---------------------------------------------------------------------------------------------------------------------------------------------
 Info about the different classes
---------------------------------------------------------------------------------------------------------------------------------------------
 
 
### Builder class - edp.builder.php
------------------------------------------------------------------------------
 
 	$builder->copyOptinalKextPack(<id>);			- 	Copies a Optional kextpack from /Extra/storage/kextpacks to /Extra/Extensions based on the ID, the ID is a reference in the db
 														It will not return any values after completing nor does it do any checking as to if the kext was copied
 														
 	$builder->EDPdoBuild();							-	Handles the pre-defined build process step by step, should only be called when we are sure that the global var $modelID is fully populated  	




### chameleon modules class - chameleon.modules.php
------------------------------------------------------------------------------
 	
 	$chamModules->copyChamModules($chamModConfig)	-	Copies modules from storage/modules to /Extra/modules by removing old onces first - it will only copy whatever is defined in $chamModConfig
 														$chamModConfig have to be defined as an array with the correct values
 														
 	$chamModules->chamModGetConfig();				-	Returns a array of the current configuration from /Extra/modules folder of loaded chameleon modules by checking wich files exists												
 	

 	
### EDP Class - edp.php    			-	Generel functions used in EDP
------------------------------------------------------------------------------
 	
 	$edp->update()									-	Updates EDP from SVN and downloads a new database
 	$edp->writeToLog($logfile, $data)				-	Writes a $data to $logfile
 	
 	
 	
### NVram Class - nvram.php    		-	Functions to manage NVram
------------------------------------------------------------------------------
 	
 	$nvram->clear();									-	Clears NVram
 	
 	
### kexts Class - nvram.php    		-	Functions to manage and work with kexts
------------------------------------------------------------------------------
 	
 	$kexts->getKextVersion($kext);					-	Returns version of $kext
 	$kexts->copyKextToSLE($kext, $frompath);		-	Copys $kext to /System/Library/Extensions/, kext must be located in $frompath - we will also make a backup into /backup
 	 	
 	