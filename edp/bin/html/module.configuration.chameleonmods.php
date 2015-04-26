<?php
	include_once "edpconfig.inc.php";

	// Write out the header
	include "header.inc.php";
	
	// Fetch the show type
	$showtype 	= $_GET['showtype']; if (!$showtype) { $showtype = $_POST['showtype']; }
	$action 	= $_POST['action'];

	//
	// Take the action based on request
	//
	switch ($action) {
		case "updateModules":
			$chamModConfig = array(
				"ACPICodec" => $_POST['ChamModuleACPICodec'],
				"FileNVRAM" => $_POST['ChamModuleFileNVRAM'],     	
				"KernelPatcher" => $_POST['ChamModuleKernelPatcher'],
				"Keylayout" => $_POST['ChamModulekeylayout'],
				"klibc" => $_POST['ChamModuleklibc'],	
				"Resolution" => $_POST['ChamModuleResolution'],
				"Sata" => $_POST['ChamModuleSata'],	
				"uClibcxx" => $_POST['ChamModuleuClibcxx'],
				"HDAEnabler" => $_POST['ChamHDAEnabler'],
			);

			$chamModules->copyChamModules($chamModConfig);
			$chamModConfig = "";
			
			echo "<div class='pageitem_bottom'>\n";
			echo "<ul class='pageitem'>";
			echo "<img src=\"icons/big/success.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
			echo "<b><center> Saved changes.</b><br><br><b> You can see the changes in action from your next boot.</center></b>";
			echo "<br></ul></div>";
			exit;
		break;
		
		case "updateBootloader":
			$chameID 	= $_POST['chameID'];
			
			if ($_POST['customBootUpd'] == "on") {
				
				if (file_exists("$incPath/boot")) {
					system_call("cp -f $incPath/boot /");
					echo "<div class='pageitem_bottom'>\n";
					echo "<ul class='pageitem'>";
					echo "<img src=\"icons/big/sucess.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
					echo "<b><center> Update success.</b><br><br><b> You can see the changes in action from your next boot.</center></b>";
					echo "<br></ul></div>";
				}
				else {
					echo "<div class='pageitem_bottom'>\n";
					echo "<ul class='pageitem'>";
					echo "<img src=\"icons/big/warning.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
					echo "<b><center> File not found.</b><br><br><b> Copy your bootloader file to $incPath and try again.</center></b>";
					echo "<br></ul></div>";
				}
			}
			elseif ($chameID  != "") {
			
				// Clear log and scripts
				if (is_dir("$logsPath/update")) {
					system_call("rm -rf $logsPath/update/*");
				}
				
				// Create local directory if not found
				if (!is_dir("$svnpackPath")) {
					system_call("mkdir $svnpackPath");
				}
				if (!is_dir("$svnpackPath/Bootloader")) {
					system_call("mkdir $svnpackPath/Bootloader");
				}
			
				$type = $chameBootdb[$chameID]['type'];
				$fname = $chameBootdb[$chameID]['foldername'];
				
				// Download the bootloader
				if ($type == "Enoch") {
					$svnLoad->svnDataLoader("Update", "Bootloader/EnochBoot", $fname);
				}
				else {
					$svnLoad->svnDataLoader("Update", "Bootloader/StandardBoot", $fname);
				}
			
				// Start installation process by Launching the script which provides the summary of the build process 
				echo "<script> document.location.href = 'workerapp.php?type=$type&fname=$fname&action=showChameUpdateLog'; </script>";
				
			}
			else {
				echo "<div class='pageitem_bottom'>\n";
				echo "<ul class='pageitem'>";
				echo "<img src=\"icons/big/warning.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
				echo "<b><center> Nothing selected.</b><br><br><b> Please select your bootloader update options and try again.</center></b>";
				echo "<br></ul></div>";
			}
			exit;
		break;
		
	}
	

	//
	// Draw the webpage based on request
	//
	switch ($showtype) {
		case "list":
		
			// Get the current config
			$chamModConfig = $chamModules->chamModGetConfig();
	
			// Write out the top menu
			echoPageItemTOP("icons/big/chame.png", "Chameleon modules");
			echo "<div class='pageitem_bottom'>\n";
			echo "<br>Use this to configure the modules you want to be used by chameleon.<br><br>";
	
			// Write out the form header
			echo "<form action='module.configuration.chameleonmods.php' method='post'>\n";
			
			// Write out the config
			echo "<ul class='pageitem'>";
			$result = $edp_db->query("SELECT * FROM chammods order by name");
			foreach($result as $row) {
				$name = "$row[name]";
				checkbox("$name: $row[description]", "$row[edpname]", $chamModConfig[$name]);
			}
			echo "</ul><br>";
			
			echo "</div>";
			echo "<input type='hidden' name='action' value='updateModules'>";
			echo "<ul class='pageitem'>\n";
			echo "<li class='button'><input name='Submit input' type='submit' value='Save changes' /></li>\n";
			echo "</ul></form>\n";
		break;
	
		case "boot":
		
			// Write out the top menu
			echoPageItemTOP("icons/big/chame.png", "Chameleon bootloader");
			echo "<div class='pageitem_bottom'>\n";
			echo "<br>Use this to update chameleon booloader.<br><br>";
	
			// Write out the form header
			echo "<form action='module.configuration.chameleonmods.php' method='post'>\n";
			echo "<ul class='pageitem'>";				
			echo "<span class='arrow'></span><li class='select'><select name='chameID' id='chameID'>";
			echo "<option value='' selected>&nbsp;&nbsp;Select version here if you want to update bootloader...</option>\n";
			
				$i = 0;
				while ($chameBootdb[$i] != "") {
					//resetting vars
					$id = ""; $version = ""; $notes = ""; $type = ""; $os_support = "";
				
					//Getting vars from the optional multidim. array
					$id = $chameBootdb[$i]['id']; $type = $chameBootdb[$i]['type']; 
					$version = $chameBootdb[$i]['version'];  $notes = $chameBootdb[$i]['notes'];
					$os_support = $chameBootdb[$i]['os_support'];
				
					echo "<option value='$i' >&nbsp;&nbsp;$type v$version $os_support </option>\n";
					
					$i++;
				}
			
			echo "</select>span class='arrow'></span></li>";
			checkbox("Use custom chameleon (if you have, copy boot file to '/Extra/include')?", "customBootUpd", "no");	
			echo "</ul><br>";
			echo "</div>";
			
			echo "<input type='hidden' name='action'   value='updateBootloader'>";
			// echo "<input type='hidden' name='showtype' value='boot'>";

			echo "<ul class='pageitem'>\n";
			echo "<li class='button'><input name='Submit input' type='submit' value='Update' /></li>\n";
			echo "</ul></form>\n";
		break;
		
		Default:
			// Write out the config for build process modules tab
			echo "<ul class='pageitem'>";
				$result = $edp_db->query("SELECT * FROM chammods order by name");
				foreach($result as $row) {
					$name = "$row[name]";
					checkbox("$name: $row[description]", "$row[edpname]", $chamModConfig[$name]);
				}
			echo "</ul><br>";
		break;
	}

?>

