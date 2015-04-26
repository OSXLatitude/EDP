
<?php
	include_once "functions.inc.php";
	include "header.inc.php";

	$skippbuild = "";
	
	function deleteEDPFiles()
	{
			//Get all the kexts name in comma seperated way
			$edlinfo = shell_exec("ls -m /Extra/Extensions/");
    		$edkarray = explode(',', $edlinfo);
				
			$peuid = 0;
			foreach($edkarray as $edfkname) {
								
				if ($edfkname != "") {
					
				$edfkname = preg_replace('/\s+/', '',$edfkname); // remove white spaces
				
				if($_POST[$peuid] == "on")
					; //ignore
				else {
					system("rm -rf /Extra/Extensions/$edfkname");
					 //echo $edfkname;
					}
				}
				$peuid++;
				
			}
		
		/*
		$edsdt = $_POST['edsdt']; $eboot = $_POST['eboot']; $esmbios = $_POST['esmbios'];
		$essdt = $_POST['essdt']; $essdt1 = $_POST['essdt1']; $essdt2 = $_POST['essdt2']; $essdt3 = $_POST['essdt3']; $essdt4 = $_POST['essdt4'];
			
		if(file_exists("/Extra/DSDT.aml") && $edsdt != "on") {system("rm -f /Extra/DSDT.aml");}
		
		if(file_exists("/Extra/org.chameleon.Boot.plist") && $eboot != "on") { system("rm -f /Extra/org.chameleon.Boot.plist");}

		if(file_exists("/Extra/SMBios.plist") && $esmbios != "on") { system("rm -f /Extra/SMBios.plist");} 

		if(file_exists("/Extra/SSDT.aml") && $essdt != "on") {  system("rm -f /Extra/SSDT.aml");} 

		if(file_exists("/Extra/SSDT-1.aml") && $essdt1 != "on") { system("rm -f /Extra/SSDT-1.aml");}

		if(file_exists("/Extra/SSDT-2.aml") && $essdt2 != "on") {  system("rm -f /Extra/SSDT-2.aml");}

		if(file_exists("/Extra/SSDT-3.aml") && $essdt3 != "on") {  system("rm -f /Extra/SSDT-3.aml");} 

		if(file_exists("/Extra/SSDT-4.aml") && $essdt4 != "on") { system("rm -f /Extra/SSDT-4.aml");} 
		*/
	}
	
	function deleteUsrIncludeFiles()
	{	
		$dsdt = $_POST['dsdt']; $boot = $_POST['boot']; $smbios = $_POST['smbios'];
		$ssdt = $_POST['ssdt']; $ssdt1 = $_POST['ssdt1']; $ssdt2 = $_POST['ssdt2']; $ssdt3 = $_POST['ssdt3']; $ssdt4 = $_POST['ssdt4'];
	
		//echo "List: $dsdt, $boot, $smbios, $ssdt, $ssdt1, $ssdt2, $ssdt3, $ssdt4,E";
	
			//Get all the kexts name in comma seperated way
			$cdlinfo = shell_exec("ls -m /Extra/include/Extensions/");
    		$cdkarray = explode(',', $cdlinfo);
				
			$pckid = 100;
			
			foreach($cdkarray as $cdfkname) {
								
				if ($cdfkname != "") {
					
				$cdfkname = preg_replace('/\s+/', '',$cdfkname); //remove white spaces
						
				if($_POST[$pckid] == "on")
					;//ignore
				else {
					  system("rm -rf /Extra/include/Extensions/$cdfkname");
					 //echo "DEL:$cdfkname";
					}
			 	}
			 	$pckid++;
			 }
		
			if(file_exists("/Extra/include/DSDT.aml") && $dsdt != "on") { system("rm -f /Extra/include/DSDT.aml"); }  
			
			if(file_exists("/Extra/include/org.chameleon.Boot.plist") && $boot != "on") { system("rm -f /Extra/include/org.chameleon.Boot.plist"); }
			
			if(file_exists("/Extra/include/SMBios.plist") && $smbios != "on") {  system("rm -f /Extra/include/SMBios.plist"); } 
			
			if(file_exists("/Extra/include/SSDT.aml") && $ssdt != "on") {  system("rm -f /Extra/include/SSDT.aml");} 
			
			if(file_exists("/Extra/include/SSDT-1.aml") && $ssdt1 != "on") {  system("rm -f /Extra/include/SSDT-1.aml"); } 
			
			if(file_exists("/Extra/include/SSDT-2.aml") && $ssdt2 != "on") {  system("rm -f /Extra/include/SSDT-2.aml"); } 
			
			if(file_exists("/Extra/include/SSDT-3.aml") && $ssdt3 != "on") {  system("rm -f /Extra/include/SSDT-3.aml"); } 
			
			if(file_exists("/Extra/include/SSDT-4.aml") && $ssdt4 != "on") { system("rm -f /Extra/include/SSDT-4.aml");} 
			
		}

		//
		// Check the action to perform
		//
		$action	= $_POST['action'];
		
		//
		// Process build
		//
		if ($action == "dobuild") {	
		
			$cusoper = $_POST['copchoice'];
			$edpoper = $_POST['eopchoice'];
			
			if($edpoper === "edelonly" || $edpoper == "ebuild")
				deleteEDPFiles();
				
			if($cusoper == "cdelonly")
				deleteUsrIncludeFiles();
				
			if($cusoper == "cbuild" || $edpoper == "ebuild" ||
			   $cusoper == "cfixcache" || $cusoper == "cfullfix")	 
			{
				doCustomBuild();				
			}
			else {
				// Create delete action to load side menu back
				writeToLog("/Extra/EDP/logs/build/deleteAction.txt", "");
				
				// Launch the script which provides the summary of the delete process 
				echo "<script> document.location.href = 'workerapp.php?action=showDeleteStatus'; </script>";
			}
		}
		//
		// Load custom configuration page
		//
		else {
			
			echo "<form action='module.configuration.custom.php' method='post'>";
	
			// Write out the top menu
			echoPageItemTOP("icons/big/config.png", "Custom build configuration");

			echo "<div class='pageitem_bottom'>\n";
			echo "EDP custom configuration allows you to use your existing configuration in /Extra and your custom files included from /Extra/include.<br><br>";
			echo "Copy your custom files like DSDT, SSDT, plists and boot(chameleon bootloader) to /Extra/include and <br> custom Kexts to /Extra/include/Extensions, which can be managed here easily.<br>";
			echo "</div>";
			
			// Load the tabs
			echo "<script> $(function() { $( \"#tabs\" ).tabs(); }); </script>\n";
		
				// Show the tabs bar ?>
				<div id="tabs">
					<div id="menutabs">
						<ul>
							<li><a href="#tabs-0">Custom Files</a></li>
							<li><a href="#tabs-1">EDP Files</a></li>

						</ul>
					</div>
					<?php

					echo "<div class='pageitem_bottom'><br>\n";

					// Include tabs
					include "include/module.configuration.custom.files.inc.php";		
					include "include/module.configuration.edp.files.inc.php";

					echo "<input type='hidden' name='action' value='dobuild'>";
					echo "</div><br>";
			
			echo "<ul class='pageitem'><li class='button'><input name='Submit input' type='submit' value='Do build!' onclick='processmyFix();' /></li></ul><br><br>\n";
		}
		

	//
	// Build Process		
	//
	function doCustomBuild() {

		$workPath = "/Extra/EDP";
		$incPath = "/Extra/include";
		$eePath = "/Extra/Extensions";
	
		$buildLogPath = "$workPath/logs/build";
	
		//
		// Create log directory for build
		//
		
		if(!is_dir("$workPath/logs"))
			system_call("mkdir $workPath/logs");
			
		//
		// Clear build log files
		//
	
		if(!is_dir("$buildLogPath"))
			system_call("mkdir $buildLogPath");
		else {
			system_call("rm -rf $buildLogPath/*");
		}
		
		$cusoper = $_POST['copchoice'];
		$edpoper = $_POST['eopchoice'];
	
		$dsdt = $_POST['dsdt']; $boot = $_POST['boot']; $smbios = $_POST['smbios'];
		$ssdt = $_POST['ssdt']; $ssdt1 = $_POST['ssdt1']; $ssdt2 = $_POST['ssdt2']; $ssdt3 = $_POST['ssdt3']; $ssdt4 = $_POST['ssdt4'];
	
		//
		// check if myhack.kext exists in sle, if it dosent then copy it there...
		//
		myHackCheck();
	
		// writeToLog("$buildLogPath/build.log", "Choice: $cusoper, $edpoper<br>");
	
		if($cusoper == "cfullfix") {

			// Create myFix text file to start myFix process
			writeToLog("$buildLogPath/fullFix.txt", "");
		
			// Launch the script which provides the summary of the build process 
			echo "<script> document.location.href = 'workerapp.php?action=showCustomBuildLog'; </script>";
		}
		else if($cusoper == "cfixcache" || ($edpoper == "ebuild" && $cusoper == "cnone")) {
   
			// Create myFix text file to start myFix process
			writeToLog("$buildLogPath/quickFix.txt", "");
		
			// Launch the script which provides the summary of the build process 
			echo "<script> document.location.href = 'workerapp.php?action=showCustomBuildLog'; </script>";
		}
		
		else if($cusoper != "cnone")
		{
			// For log time
			date_default_timezone_set("UTC");
			$date = date("d-m-y H-i");

			system_call("echo '<br>*** Custom build logging started on: $date UTC Time ***' >> $buildLogPath/build.log");
	
			//
			// Step 1
			//
			writeToLog("$buildLogPath/build.log", "<br><br><b>Step 1) Checking if you have selected any kexts from $incPath... </b><br>");
			
			// Get all the kexts name in comma seperated way
			$cclinfo = shell_exec("ls -m /Extra/include/Extensions/");
			$cckarray = explode(',', $cclinfo);
			
			$pckid = 100;
		
			foreach($cckarray as $ccfkname) {
							
				if ($ccfkname != "") {
				
				$ccfkname = preg_replace('/\s+/', '',$ccfkname); //remove white spaces
				
				if($_POST[$pckid] == "on") {
					  system("cp -R /Extra/include/Extensions/$ccfkname $eePath");
					  writeToLog("$buildLogPath/build.log", "Copying $ccfkname to $eePath<br>");
					}
					else {
						if(is_dir("/Extra/Extensions/$ccfkname")) {
							system("rm -rf /Extra/Extensions/$ccfkname");
							writeToLog("$buildLogPath/build.log", "Removing $ccfkname from $eePath<br>");
						}
					}
				}
				$pckid++;
			 }
	
			//
			// Step 2
			//
			writeToLog("$buildLogPath/build.log", "<br><b>Step 2) Checking if you have essential files DSDT, SSDT and plists from $incPath... </b><br>");
		
			if ($dsdt == "on") {
				writeToLog("$buildLogPath/build.log", "DSDT file found, Copying $incPath/DSDT.aml to /Extra<br>");
				system_call("cp -f /Extra/include/DSDT.aml /Extra");
			} 	
	
			if (is_file("/Extra/include/SSDT.aml") && $ssdt == "on") 					{ 
				writeToLog("$buildLogPath/build.log", "SSDT files(s) found, Copying SSDT.aml file to /Extra<br>");
				system_call("cp -f /Extra/include/SSDT.aml /Extra"); 
			}
			if (is_file("/Extra/include/SSDT-1.aml") && $ssdt1 == "on") 				{ 
				writeToLog("$buildLogPath/build.log", "Copying SSDT-1.aml file to /Extra<br>");
				system_call("cp -f /Extra/include/SSDT-1.aml /Extra"); 
			}
			if (is_file("/Extra/include/SSDT-2.aml") && $ssdt2 == "on") 				{ 
				writeToLog("$buildLogPath/build.log", "Copying SSDT-2.aml file to /Extra<br>");
				system_call("cp -f /Extra/include/SSDT-2.aml /Extra"); 
			}
			if (is_file("/Extra/include/SSDT-3.aml") && $ssdt3 == "on") 				{ 
				writeToLog("$buildLogPath/build.log", "Copying SSDT-3.aml file to /Extra<br>");
				system_call("cp -f /Extra/include/SSDT-3.aml /Extra"); 
			}    
			if (is_file("/Extra/include/SSDT-4.aml") && $ssdt4 == "on") 				{ 
				writeToLog("$buildLogPath/build.log", "Copying SSDT-4.aml file to /Extra<br>");
				system_call("cp -f /Extra/include/SSDT-4.aml /Extra"); 
			}
	
			if ($boot == "on") { 
				writeToLog("$buildLogPath/build.log", "Chameleon plist found, Copying $incPath/org.chameleon.Boot.plist to /Extra<br>");
				system_call("cp -f /Extra/include/org.chameleon.Boot.plist /Extra");
			}	
			if ($smbios == "on")	{
				writeToLog("$buildLogPath/build.log", "SMBios file found, Copying $incPath/SMBios.plist to /Extra<br>"); 
				system_call("cp -f /Extra/include/smbios.plist /Extra");
			}	
		
			//
			// Step 3
			//
			writeToLog("$buildLogPath/build.log", "<br><b>Step 3) Calling myFix to copy kexts and generate kernelcache... </b><br>");
		
			// End build log and create a lastbuild log
			system_call("echo '<br>*** Custom build logging ended on: $date UTC Time ***<br>' >> $buildLogPath/build.log");
			system_call("cp $buildLogPath/build.log $workPath/logs/lastbuild.log ");
		
			// Append current build log to the builds log 
			$fileContents = file_get_contents("$buildLogPath/build.log");
			file_put_contents("$workPath/logs/build.log", $fileContents, FILE_APPEND | LOCK_EX);
		
			// Create myFix text file to start myFix process
			writeToLog("$buildLogPath/quickFix.txt", "");
		
			// Launch the script which provides the summary of the build process 
			echo "<script> document.location.href = 'workerapp.php?action=showCustomBuildLog'; </script>";
  
		  }
	}		
			
?>

	<script>
	function processmyFix() {
		top.document.getElementById('edpmenu').src ='workerapp.php?action=showLoadingLog&type=custom';
	}
	</script>