<?php
include_once "functions.inc.php";
include_once "edpconfig.inc.php";

include "header.inc.php";

// our classes 
global $edpDBase;
		
// Get the values from the javascript link 
$sysType	= $_GET['type'];	if ($sysType == "") { $sysType 	= $_POST['type']; }
$modelID 	= $_GET['modelID'];	if ($modelID == "") { $modelID 	= $_POST['modelID']; }
$cpuID 		= $_GET['cpuID'];	if ($cpuID == "")	{ $cpuID 	= $_POST['cpuID']; }
$action 	= $_GET['action']; 	if ($action == "") 	{ $action 	= $_POST['action']; }
	
$buildLogPath = "$logsPath/build";


//-------------------------> Do build page starts here
if ($action == 'dobuild') {	
	echo "<span class='console'>";

	if ($modelID == "") { echo "modelID is empty"; exit; }

	// Generate a multi dim. array used during the build process
	global $modeldb;

	$modeldb = array(
		//This one have to be empty, its used for when we do custom builds...
		array( 	
			'name' 			     => $_POST['name'], 
			'desc' 			     => $_POST['desc'],
			'useEDPExtensions' 	=> $_POST['useEDPExtensions'], 		
			'useEDPDSDT' 		=> $_POST['useEDPDSDT'],			
			'useEDPSSDT' 		=> $_POST['useEDPSSDT'],			
			'useEDPSMBIOS' 		=> $_POST['useEDPSMBIOS'], 			
			'useEDPCHAM' 		=> $_POST['useEDPCHAM'], 
			'useEDPTheme' 		=> $_POST['useEDPTheme'], 
			'useIncExtensions' 	=> $_POST['useIncExtensions'], 		
			'useIncDSDT' 		=> $_POST['useIncDSDT'],			
			'useIncSSDT' 		=> $_POST['useIncSSDT'],			
			'useIncSMBIOS' 		=> $_POST['useIncSMBIOS'], 			
			'useIncCHAM' 		=> $_POST['useIncCHAM'], 
			'useIncTheme' 		=> $_POST['useIncTheme'],            		
			'ps2pack' 		     => $_POST['ps2pack'],
			'batterypack'		 => $_POST['batterypack'],
			'ethernet'		     => $_POST['ethernet'],
			'wifipack'		     => $_POST['wifipack'],
			'audiopack'		     => $_POST['audiopack'],                    		                      		                      		
			'fakesmc'			 => $_POST['fakesmc'],
			'nullcpupwr'			 => $_POST['nullcpupwr'],
			'applecpupwr'			 => $_POST['applecpupwr'],
			'sleepenabler'			 => $_POST['sleepenabler'],
			'emupstates'			 => $_POST['emupstates'],
			'voodootsc'			 => $_POST['voodootsc'],
			'noturbo'			 => $_POST['noturbo'],
			'ACPICodec' 		 => $_POST['ChamModuleACPICodec'],
			'FileNVRAM' 		 => $_POST['ChamModuleFileNVRAM'],
			'KernelPatcher' 	 => $_POST['ChamModuleKernelPatcher'],
			'Keylayout' 		 => $_POST['ChamModulekeylayout'],
			'klibc' 			 => $_POST['ChamModuleklibc'],
			'Resolution'         => $_POST['ChamModuleResolution'],
			'Sata' 			     => $_POST['ChamModuleSata'],
			'uClibcxx' 		     => $_POST['ChamModuleuClibcxx'],
			'HDAEnabler' 		 => $_POST['ChamHDAEnabler'],
			'customCham' 		 => $_POST['customCham'],
			'chameBootID' 		 => $_POST['chameBootID'],
			'fixes' 		     => $_POST['fixes'],
			'optionalpacks'	     => $_POST['optionalpacks']                    		 
		),
	);

		// our classes
		global $chamModules; 
		global $svnLoad; 
		
		global $workPath, $svnpackPath, $os; 
		global $modelName;
	
		
		// For log time
		date_default_timezone_set("UTC");
		$date = date("d-m-y H-i");
	
		system_call("echo '<br>*** System build logging started on: $date UTC Time ***' >> $buildLogPath/build.log");
		
		//
		// Create directories for build
		//
    		
    	if(!is_dir("$svnpackPath"))
    		system_call("mkdir $svnpackPath");
    		
    	if(!is_dir("$logsPath"))
    		system_call("mkdir $logsPath");
    		
    	if(!is_dir("$buildLogPath"))
    		system_call("mkdir $buildLogPath");
    		
		if(!is_dir("$buildLogPath/dLoadScripts"))
			system_call("mkdir $buildLogPath/dLoadScripts");

		if(!is_dir("$logsPath/fixes"))
    		system_call("mkdir $logsPath/fixes");
		
		if(!is_dir("/Extra/Extensions.EDPFix")) {
			system_call("mkdir /Extra/Extensions.EDPFix");
	  	}
	  	else {
	  		system_call("rm -rf /Extra/Extensions.EDPFix/*");
	  	}
		
		writeToLog("$buildLogPath/build.log", "<br> Cleaning up last build...<br>");

		system_call("rm -Rf /Extra/Extensions/*");
			
			
		//
		// Step 1 : Create the folder path and download the model data 
		//
		writeToLog("$buildLogPath/build.log", "<br><b>Step 1) Prepare essential files download:</b><br>");

		writeToLog("$buildLogPath/build.log", " Preparing myhack...</b><br>");
		
		myHackCheck();
			
		global $modelNamePath;
		$modelRowID = 0;
		$modelName = $modeldb[$modelRowID]["name"];
		$ven = $edpDBase->builderGetVendorValuebyID($sysType, $modelID);
		$gen = $edpDBase->builderGetGenValuebyID($sysType, $modelID);
		
		
		// use old method if there are is no generation column in db 
		if($gen == "") {
		
			$modelNamePath = "$modelName";

			if(!is_dir("$workPath/model-data/$modelName/"))
				system("mkdir $workPath/model-data/$modelName");
				
			// system_call("svn --non-interactive --username osxlatitude-edp-read-only list http://osxlatitude-edp.googlecode.com/svn/model-data/$modelName/common >> $buildLogPath/build.log 2>&1");
			
			$svnLoad->PrepareEssentialFilesDownload("$modelName");
		}
		else {
		
			$modelNamePath = "$ven/$gen/$modelName";
			
			if(!is_dir("$workPath/model-data/$ven"))
				system("mkdir $workPath/model-data/$ven");
			
			if(!is_dir("$workPath/model-data/$ven/$gen"))
				system("mkdir $workPath/model-data/$ven/$gen");
			
			if(!is_dir("$workPath/model-data/$modelNamePath/"))
				system("mkdir $workPath/model-data/$modelNamePath");
			
			// system_call("svn --non-interactive --username osxlatitude-edp-read-only list http://osxlatitude-edp.googlecode.com/svn/model-data/$modelNamePath/common >> $buildLogPath/build.log 2>&1");
			
			//
			// We use the new method "loadModelEssentialFiles" for the models and 
			// old method "$svnLoad->svnModeldata" for the old models which is not updated for the new DB to fetch files
			//
		
			$svnLoad->PrepareEssentialFilesDownload("");
			
			// Fetch SSDT files needed for the choosen model
			
			if ($cpuID != "EDP")
			{
				$svnLoad->PrepareSSDTFilesDownload($sysType, $cpuID);
			}		
		}
		
		writeToLog("$buildLogPath/build.log", " Preparing essential files for the model $modelName...</b><br>");

		//
		// Create a script file if we need to copy custom Theme from Extra/include
		//
		if($modeldb[$modelRowID]['useIncTheme'] == "on")
		{
			writeToLog("$logsPath/build/dLoadScripts/CopyCustomTheme.sh", "");
		}
		if($modeldb[$modelRowID]["useEDPSMBIOS"] == "on")
			$smbios = "yes";
		
		if($modeldb[$modelRowID]["useEDPCHAM"] == "on")
			$chame = "yes";
		
		if($modeldb[$modelRowID]["useEDPDSDT"] == "on")
			$dsdt = "yes";
		
		if($modeldb[$modelRowID]["useEDPSSDT"] == "on")
			$ssdt = "yes";
		
		if($modeldb[$modelRowID]['useEDPTheme'] == "on")
			$theme = "yes";
		
		// Launch the script which provides the summary of the build process 
		echo "<script> document.location.href = 'workerapp.php?action=showBuildLog&modelPath=$modelNamePath&smbios=$smbios&chame=$chame&dsdt=$dsdt&ssdt=$ssdt&theme=$theme'; </script>";
		
		//
		// Step 2 : Preparing  kext packs
		//
		writeToLog("$buildLogPath/build.log", "<br><b>Step 2) Prepare Kext packs for the system hardware:</b><br>");
		PrepareEDPKextpacks();	
			
		//  prepare for bootloader update
		$bootID = $modeldb[$modelRowID]['chameBootID'];
		if($bootID != "") {		
			$stmt = $edp_db->query("SELECT * FROM chameBoot where id = '$bootID'");
			$stmt->execute(); $cbootDB = $stmt->fetchAll(); $chameRow = $cbootDB[0];
		
			if($chameRow['type'] == "Enoch") {
				writeToLog("$buildLogPath/build.log", " Updating enoch bootloader...<br>");
				$svnLoad->PrepareKextpackDownload("Bootloader", "EnochBoot", $chameRow['foldername']);
			} 
			else {
				writeToLog("$buildLogPath/build.log", " Updating standard bootloader...<br>");
				$svnLoad->PrepareKextpackDownload("Bootloader", "StandardBoot", $chameRow['foldername']);
			}			
		}
				
		//
		// Step 3 : Preparing/Applying Fixes and chameleon modules
		//	
		writeToLog("$buildLogPath/build.log", "<br><b>Step 3) Apply and prepare fixes for system:</b><br>");
		applyFixes();
		
		writeToLog("$buildLogPath/build.log", " Copying selected chameleon modules...</b><br>");
		$chamModules->copyChamModules($modeldb[$modelRowID]);
		
		//
		// Step 4 : Start the download of prepared files for download
		//	
		writeToLog("$buildLogPath/build.log", "<br><b>Step 3) Start the download of prepared files:</b><br>");
		writeToLog("$buildLogPath/build.log", "<br>");

		// Get all the files in comma seperated way
		$dListInfo = shell_exec("ls -m $buildLogPath/dLoadScripts/");
		$dScriptsArray = explode(',', $dListInfo);
		
		if(!is_dir("$buildLogPath/dLoadStatus")) {
			system_call("mkdir $buildLogPath/dLoadStatus");
		}
			
		foreach($dScriptsArray as $dScript) {
			$dScript = preg_replace('/\s+/', '',$dScript); //remove white spaces in name
			
			if ($dScript != "")
			{
				system_call("sh $buildLogPath/dLoadScripts/$dScript >> $buildLogPath/internetCheckLog.log &");
			}
		}	
			
}

//-------------------------> Here starts the Vendor and model selector - but only if $action is empty

if ($action == "") {
		
	//
	// Clear build log files
	//
	
	if(!is_dir("$buildLogPath"))
		system_call("mkdir $buildLogPath");
	else {
		system_call("rm -rf $buildLogPath/*");
	}	
		
	// Write out the top menu
	echoPageItemTOP("icons/big/config.png", "Select a model your wish to configure for:");

	echo "<div class='pageitem_bottom'>\n";
	echo "EDP internal database contains 'best practice' configuration for the systems - this makes it easy to to choose the right configuration. However, you always have the option to ajust the configuration before doing a build. <br><br>Doing a build means that EDP will copy a combination of kexts, dsdt, plists, fixes and patches needed to boot your system.";

	include "header.inc.php";
	
	echo "<p><span class='graytitle'></span><ul class='pageitem'><li class='select'>";

	echo "<select name='type' id='type'>";
	
	if ($sysType == "") { echo "<option value='' selected>&nbsp;&nbsp;Select system type...</option>\n"; } else { echo "<option value='' selected>&nbsp;&nbsp;Select system type...</option>\n"; }

	echo $edpDBase->getSystemTypeValue();
	
	echo "</select><span class='arrow'></span> </li>";

	echo "<li id='vendor-container' class='select hidden'><td><select id='vendor' name='vendor'>";

	echo "</select><span class='arrow'></span> </li>";	

	echo "<li id='serie-container' class='select hidden'><td><select id='serie' name='serie'>";

	echo "</select><span class='arrow'></span> </li>";					

	echo "<li id='model-container' class='select hidden'><td><select id='model' name='model'>";

	echo "</select><span class='arrow'></span> </li>";

	echo "<li id='cpu-container' class='select hidden'><td><select id='cpu' name='cpu'>";

	echo "</select><span class='arrow'></span> </li></ul>";
	
	echo '<div id="continue-container" class="hidden">';
	
	echo "<p><B><center>After clicking 'Continue' EDP will let you to config your machine.<br></p><br>";
	echo "<ul class='pageitem'><li class='button'><input name='OK' type='button' value='Continue...' onclick='doConfirm();' /></li></ul></p>";
	echo '</div>';

	?>

	<style>
		.hidden {
			display: none;
		}
	</style>
	<script>
		jQuery('#type').change(function() {
			var type = jQuery('#type option:selected').val();

			console.log('Selected type: ' + type);

			if (type == '') {
				jQuery('#vendor-container, #serie-container, #model-container, #cpu-container, #continue-container').addClass('hidden');
				return;
			}

			jQuery.get('workerapp.php', { action: 'builderVendorValues', type: type }, function(data) {
				jQuery('#vendor').empty().append(data).val('');
				jQuery('#vendor-container').removeClass('hidden');
				jQuery('#serie-container, #model-container, #cpu-container, #continue-container').addClass('hidden');
			});
		});
		
		jQuery('#vendor').change(function() {
			var type = jQuery('#type option:selected').val();
			var vendor = jQuery('#vendor option:selected').val();

			console.log('Selected vendor: ' + vendor);

			if (type == '' || vendor == '') {
				jQuery('#serie-container, #model-container, #cpu-container, #continue-container').addClass('hidden');
				return;
			}

			jQuery.get('workerapp.php', { action: 'builderSerieValues', type: type, vendor: vendor }, function(data) {
				jQuery('#serie').empty().append(data).val('');
				jQuery('#serie-container').removeClass('hidden');
				jQuery('#model-container, #cpu-container, #continue-container').addClass('hidden');
			});
		});

		jQuery('#serie').change(function() {
			var type = jQuery('#type option:selected').val();
			var vendor = jQuery('#vendor option:selected').val();
			var serie  = jQuery('#serie option:selected').val();

			console.log('Selected serie: ' + serie);

			if (type == '' || vendor == '' || serie == '') {
				jQuery('#model-container, #cpu-container, #continue-container').addClass('hidden');
				return;
			}

			jQuery.get('workerapp.php', { action: 'builderModelValues', type: type, vendor: vendor, serie: serie }, function(data) {
				jQuery('#model').empty().append(data);
				jQuery('#model-container').removeClass('hidden');
				jQuery('#cpu-container, #continue-container').addClass('hidden');
			});
		});

		jQuery('#model').change(function() {
			var type = jQuery('#type option:selected').val();
			var vendor = jQuery('#vendor option:selected').val();
			var serie  = jQuery('#serie option:selected').val();
			var model  = jQuery('#model option:selected').val();

			console.log('Selected model: ' + model);

			if (type == '' || vendor == '' || serie == '' || model == '') {
				jQuery('#cpu-container, #continue-container').addClass('hidden');
				return;
			}

			jQuery.get('workerapp.php', { action: 'builderCPUValues', type: type, model: model }, function(data) {
				jQuery('#cpu').empty().append(data);
				jQuery('#cpu-container').removeClass('hidden');
				jQuery('#continue-container').addClass('hidden');
			});
		});
		
		jQuery('#cpu').change(function() {
			var type = jQuery('#type option:selected').val();
			var vendor = jQuery('#vendor option:selected').val();
			var serie  = jQuery('#serie option:selected').val();
			var model  = jQuery('#model option:selected').val();
			var cpu  = jQuery('#cpu option:selected').val();
			
			console.log('Selected cpu: ' + cpu);

			if (type == '' || vendor == '' || serie == '' || model == '' || cpu == '') {
				jQuery('#continue-container').addClass('hidden');
				return;
			}

			jQuery('#continue-container').removeClass('hidden');
		});
	</script>				

	<?php }

//<-------------------- Here stops the vendor and model selector		

//--------------------> Here starts the build confirmation page 
//Check if $action was set via GET or POST - if it is set, we asume that we are going to confirm the build
	if ($action == "confirm") {		
		
		// Fetch standard model info needed for the configuration of the choosen model to build
		switch ($sysType) {
			  case "Mobile Workstation":
 			  case "Notebook":
 			  case "Ultrabook":
 			  case "Tablet":
 			  	$query = "SELECT * FROM modelsPortable where id = '$modelID'";
 			  	$cquery = "SELECT * FROM compatNB where model_id = '$modelID'";
 			  break;
 			  
 			  case "Desktop":
 			  case "Workstation":
 			  case "AllinOnePC":
 			  	$query = "SELECT * FROM modelsDesk where id = '$modelID'";
 			  	$cquery = "SELECT * FROM compatDesk where model_id = '$modelID'";
 			  break;
 		}
		$stmt = $edp_db->query($query);
		$stmt->execute(); $bigrow = $stmt->fetchAll(); $mdrow = $bigrow[0];

		// Load the tabs
		echo "<script> $(function() { $( \"#tabs\" ).tabs(); }); </script>\n";
		
		echo "<form action='module.configuration.predefined.php' method='post'>";
		echoPageItemTOP("http://www.osxlatitude.com/wp-content/themes/osxlatitude/img/edp-models/$mdrow[vendor]/$mdrow[generation]/$mdrow[name].png", "$mdrow[desc]");
		
		//Show the tabs bar ?>
		<div id="tabs">
			<div id="menutabs">
				<ul>
					<li><a href="#tabs-0">Overview</a></li>
					<li><a href="#tabs-1">Kext / Drivers</a></li>
					<li><a href="#tabs-2">CPU & Power</a></li>
					<li><a href="#tabs-3">Chameleon</a></li>
					<li><a href="#tabs-4">Fixes</a></li>
					<li><a href="#tabs-5">Optional</a></li>
				</ul>
			</div>
			<?php

			echo "<div class='pageitem_bottom'><br>\n";

			// Include tabs
			include "include/module.configuration.overview.inc.php";
			include "include/module.configuration.kexts.inc.php";
			include "include/module.configuration.cpu.inc.php";
			include "include/module.configuration.chameleon.inc.php";		
			include "include/module.configuration.fixes.inc.php";
			include "include/module.configuration.optional.inc.php";		

			// set model vars in hidden input to read back during build
			echo "<input type='hidden' name='action' value='dobuild'>";
			echo "<input type='hidden' name='modelID' value='$modelID'>";
			echo "<input type='hidden' name='cpuID' value='$cpuID'>";
			echo "<input type='hidden' name='type' value='$mdrow[type]'>";
			echo "<input type='hidden' name='name' value='$mdrow[name]'>";
			echo "<input type='hidden' name='desc' value='$mdrow[desc]'>";

			echo "</div><br>";
			echo "<ul class='pageitem'><li class='button'><input name='Submit input' type='submit' value='Do build!' onclick='clearLoadingScreen();' /></li></ul><br><br>\n";
			echo "</form>";		

		}
	//<------------------------------ Here ends the model confirmation page
		?>

		<script>
		function clearLoadingScreen() {
			// top.document.getElementById('edpmenu').src ='menu.inc.php?i=Configuration';
			// top.document.getElementById('edpmenu').src ='workerapp.php?action=showLoadingLog#myfix';
		}
		function doConfirm() {
			var t = document.getElementById("type");
			var type = t.options[t.selectedIndex].value;

			var m = document.getElementById("model");
			var id = m.options[m.selectedIndex].value;
			
			var c = document.getElementById("cpu");
			var cpuID = c.options[c.selectedIndex].value;
			
			if (model == "") { alert('Please select a model before continuing..'); return; }
			document.location.href = 'module.configuration.predefined.php?type='+type+'&modelID='+id+'&cpuID='+cpuID+'&action=confirm';		
			top.document.getElementById('edpmenu').src ='workerapp.php?action=showLoadingLog#myfix';
		}
		function showType() {
			var a = document.getElementById("vendor");
			var vendor = a.options[a.selectedIndex].value;	
			var b = document.getElementById("serie");
			var serie = b.options[b.selectedIndex].value;
			document.location.href = 'module.configuration.predefined.php?vendor='+vendor+'&serie='+serie+'';
		}
		function showSerie() {
			var a = document.getElementById("vendor");
			var vendor = a.options[a.selectedIndex].value;	
			document.location.href = 'module.configuration.predefined.php?vendor='+vendor+'';			
		}
		</script>

	</body>

	</html>
