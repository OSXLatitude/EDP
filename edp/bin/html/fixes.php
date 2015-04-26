
<?php

	include_once "edpconfig.inc.php";
	include_once "functions.inc.php";

	include_once "header.inc.php";

	/*
	 * load the fix
	 */
 
 	//
 	// get category and id from the get and post methods
 	//
	$action = $_GET['action'];
	if ($action == "") {
		$action = $_POST['action'];
	}
	
	$fixCateg	= $_GET['category'];
	if ($fixCateg == "") {
		$fixCateg = $_POST['category'];
	}	
	
	$type	= $_GET['type'];
	if ($type == "") {
		$type = $_POST['type'];
	}
	
	$id 	= $_GET['id'];
	if ($id == "") {
		$id = $_POST['id'];
	}
	
	// Get info from db
	switch ($fixCateg) {
		case "pm":
			$stmt = $edp_db->query("SELECT * FROM pmfixes where id = '$id'");
		break;
		
		case "sys":
			$stmt = $edp_db->query("SELECT * FROM sysfixes where id = '$id'");
		break;
		
		case "wifi":
			$stmt = $edp_db->query("SELECT * FROM wifi where id = '$id'");
		break;
		
	}
	
	$stmt->execute();
	$bigrow = $stmt->fetchAll(); $row = $bigrow[0];
			
	if ($action == "")
	{
		echo "<form action='fixes.php' method='post'>";

		// Write out the top menu
		echoPageItemTOP("icons/big/$row[icon]", "$row[name]");
		
		?>
		
		<div class="pageitem_bottom">
		<p><b>About:</b></p>
		<?="$row[brief]";?>
		<br>
		<p><b>Descripton:</b></p>
		<?="$row[description]";?>
		<br>
		<p><b>Developer and Version:</b></p>
		<?="$row[owner], v$row[version]";?>
		<br>
		<p><b>Website:</b></p>
		<a href='<?="$row[link]";?>'>Project/Support Link</a>
		
		<?php
			echo "<input type='hidden' name='id' value='$id'>";
			echo "<input type='hidden' name='action' value='$type'>";
			echo "<input type='hidden' name='category' value='$fixCateg'>";
			
			echo "<br><br><ul class='pageitem'>";				
				checkbox("Apply fix to /System/Library/Extensions instead of myHack load?", "fixToSLE", "no");
			echo "</ul></div>";
		
			switch ($row[foldername]) {
				case "EAPDFix":
					echo "<div class='pageitem_bottom'>";
					echo "<p><b>Configure your codec values for the kext plist here:</b></p>";
			
					echo "<p><ul class='pageitem'><li class='select'><select name='spk' id='spk'>";
					echo "<option value='14' selected>&nbsp;&nbsp;Select your speakers node value... (Default kext value: 0x14)</option>\n";
					$nodeID = 1;
					do {
						if ($nodeID < 10)
							echo "<option value='$nodeID' >&nbsp;&nbsp;Speakers Node: 0x0$nodeID</option>";
						else 
							echo "<option value='$nodeID' >&nbsp;&nbsp;Speakers Node: 0x$nodeID</option>";
				
						$nodeID++;
				
					} while ($nodeID <= 21);
					echo "</select><span class='arrow'></span></li></ul>";
			
					echo "<p><ul class='pageitem'><li class='select'><select name='hp' id='hp'>";
					echo "<option value='21' selected>&nbsp;&nbsp;Select your headphones node value... (Default kext value: 0x21)</option>\n";
					$nodeID = 1;
					do {
						if ($nodeID < 10)
							echo "<option value='$nodeID' >&nbsp;&nbsp;Headphones Node: 0x0$nodeID</option>";
						else 
							echo "<option value='$nodeID' >&nbsp;&nbsp;Headphones Node: 0x$nodeID</option>";
				
						$nodeID++;
				
					} while ($nodeID <= 21);
					echo "</select><span class='arrow'></span></li></ul>";
			
					echo "<p><ul class='pageitem'><li class='select'><select name='extmic' id='extmic'>";
					echo "<option value='18' selected>&nbsp;&nbsp;Select your external mic node value... (Default kext value: 0x18)</option>\n";
					$nodeID = 1;
					do {
						if ($nodeID < 10)
							echo "<option value='$nodeID' >&nbsp;&nbsp;External Mic Node: 0x0$nodeID</option>";
						else 
							echo "<option value='$nodeID' >&nbsp;&nbsp;External Mic Node: 0x$nodeID</option>";
				
						$nodeID++;
				
					} while ($nodeID <= 21);
					echo "</select><span class='arrow'></span></li></ul>";
			
					echo "<ul class='pageitem'><li>";
					checkbox("Speakers has EAPD?", "spkFix", "yes");
					checkbox("Headphones has EAPD", "hpFix", "no");
					echo "</li></ul>";
			
					echo "</div>";
				break;
			
				Default:
				break;
			}
			
		?>
		
		
		<ul class="pageitem">
			<li class="button"><input name="Submit input" type="submit" value="Proceed to Install Fix" /></li>
		</ul>

		</form>
		<?php
	}
	elseif ($action == "Install")
	{

		$fixToSLE = $_GET['fixToSLE']; if ($fixToSLE == "") { $fixToSLE = $_POST['fixToSLE']; }
		
		if ($fixToSLE == "on") {
			$fixPath = "/System/Library/Extensions";
		}
		else {
			$fixPath = "/Extra/Extensions";
		}
		
		global $svnLoad;
		
		// Clear logs and scripts
		if(is_dir("$logsPath/fixes")) {
			system_call("rm -rf $logsPath/fixes/*");
		}
		
		switch ($row[foldername]) {
			case "EAPDFix":
				$spkNode = $_GET['spk']; if ($spkNode == "") { $spkNode = $_POST['spk']; } $spkNode = hexdec($spkNode);
				$hpNode = $_GET['hp']; if ($hpNode == "") { $hpNode = $_POST['hp']; } $hpNode = hexdec($hpNode);
				$extMicNode = $_GET['extmic']; if ($extMicNode == "") { $extMicNode = $_POST['extmic']; } $extMicNode = hexdec($extMicNode);
		
				$spkFix = $_GET['spkFix']; if ($spkFix == "") { $spkFix = $_POST['spkFix']; } 
				if ($spkFix == "") { $spkFix = "No"; } else { $spkFix = "Yes"; }
				$hpFix = $_GET['hpFix']; if ($hpFix == "") { $hpFix = $_POST['hpFix']; }
				if ($hpFix == "") { $hpFix = "No"; } else { $hpFix = "Yes"; }
				
				$fixInfoKeys = "id,foldername,name,icon,categ,spk,hp,extMic,spkFix,hpFix,path";
				$fixInfoValues = "$id,$row[foldername],$row[name],$row[icon],Audio,$spkNode,$hpNode,$extMicNode,$spkFix,$hpFix,$fixPath";
				
				// Download fix
				$svnLoad->svnDataLoader("Fixes", "$row[category]", "$row[foldername]");
		
			break;
			
			Default:
				$fixInfoKeys = "id,foldername,name,icon,categ,path";
				$fixInfoValues = "$id,$row[foldername],$row[name],$row[icon],$row[category],$fixPath";
				
				// Download fix
				$svnLoad->svnDataLoader("Fixes", "$row[category]", "$row[foldername]");
			break;
			
		}
		
		// Start installation process by Launching the script which provides the summary of the build process 
		echo "<script> document.location.href = 'workerapp.php?fixInfoKeys=$fixInfoKeys&fixInfoValues=$fixInfoValues&action=showFixLog'; </script>";
		
	}
	elseif ($action == "Patch")
	{
		$fixLogPath = "$logsPath/fixes";
		
		// Clear logs and scripts
		if(is_dir("$fixLogPath")) {
			system_call("rm -rf $fixLogPath/*");
		}
		
		// create log directory if not found
		if(!is_dir("$logsPath")) {
			system_call("mkdir $logsPath");
		}
		if(!is_dir("$fixLogPath")) {
			system_call("mkdir $fixLogPath");
		}
		
		echo "<div class='pageitem_bottom'\">";	
		echo "<ul class='pageitem'>";

		$fixToSLE = $_POST['fixToSLE'];
		
		switch ($row[foldername]) {
		
			case "AppleIntelCPUPowerManagement":
				if ($fixToSLE == "on")
					patchAppleIntelCPUPowerManagement("$fixLogPath/fix.log", "SLE", "yes");
				else
					patchAppleIntelCPUPowerManagement("$fixLogPath/fix.log", "EE", "yes");
			break;
			
			case "BCM4352WiFiPatches":
				if ($fixToSLE == "on")
					patchWiFiBTBCM4352("$fixLogPath/fix.log", "SLE", "yes");
				else
					patchWiFiBTBCM4352("$fixLogPath/fix.log", "EE", "yes");
			break;
			
			case "AR9285AR9287WiFiPatch":
				if ($fixToSLE == "on")
					patchWiFiAR9285AndAR9287("$fixLogPath/fix.log", "SLE", "yes");
				else
					patchWiFiAR9285AndAR9287("$fixLogPath/fix.log", "EE", "yes");
			break;
			
			case "VGA_HDMI_Intel_HD3000_Patch":
				if ($fixToSLE == "on")
					patchAppleIntelSNBGraphicsFB("$fixLogPath/fix.log", "SLE", "yes");
				else
					patchAppleIntelSNBGraphicsFB("$fixLogPath/fix.log", "EE", "yes");
			break;
		}
		
		if (is_file("$fixLogPath/patchSuccess.txt")) {
			echo "<img src=\"icons/big/success.png\" style=\"width:80px;height:80px;position:relative;left:49%;top:50%;margin:15px 0 0 -35px;\">";
			echo "<b><center> Patch finished.</b><br><br><b> You can now reboot the sysem to see the patch in action.</center></b>";
			echo "<br></ul>";
		}
		else {
			echo "<img src=\"icons/big/fail.png\" style=\"width:80px;height:80px;position:relative;left:49%;top:50%;margin:15px 0 0 -35px;\">";
			echo "<b><center> Patch failed.</b><br><br><b> Check the log for the reason.</center></b>";
			echo "<br></ul>";
			
			echo "<b>Log:</b>\n";
			echo "<pre>";
			if(is_file("$fixLogPath/fix.log"))
				include "$fixLogPath/fix.log";
			echo "</pre>";
		}
		echo "</div>";
	}


?>
