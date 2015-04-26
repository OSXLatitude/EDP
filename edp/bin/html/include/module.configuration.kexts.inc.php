<?php
		echo "<div id=\"tabs-1\">\n";
		echo "<span class='graytitle'>Kernel Extentions (kexts / drivers)</span>\n";
		echo "<ul class='pageitem'>";

		//
		// Show dropdown for FakeSMC kexts
		//
		$fakesmc = $edp_db->query("SELECT * FROM fakesmc");
		echo "<li class='select'><select name='fakesmc'>";
		
		foreach($fakesmc as $row) {
			$sel = ""; if ("$mdrow[fakesmc]" == "$row[id]") { $sel = "SELECTED"; }
			echo "<option value='$row[id]' $sel>&nbsp;FakeSMC: v$row[version] - $row[name]</option>\n";
		}
		
		echo "</select><span class='arrow'></span> </li>";

				
		//
		// Show dropdown for PS2 kexts
		//
		$ps2 = $edp_db->query("SELECT * FROM ps2");
		echo "<li class='select'><select name='ps2pack'>";
		
		$using = "";
		foreach($ps2 as $row) {
			$sel =""; if ("$mdrow[ps2]" == "$row[id]") { $sel = "SELECTED"; $using = "yes"; }
			echo "<option value='$row[id]' $sel>&nbsp; PS2: $row[name] v$row[version] by $row[owner]</option>\n";
		}
		
		if ($using == "")
			echo "<option value='no' SELECTED>&nbsp; PS2: None selected</option>\n"; 
			
		echo "<option value='no'>&nbsp; PS2: Don't load</option>\n";
		echo "</select><span class='arrow'></span> </li>";
			
			
		//
		// Show dropdown for Audio kexts
		//			
		echo "<li class='select'>";
		echo "<select name='audiopack'>\n";		
		
		$using = "";
		// Check for AppleHDA		
		if ($mdrow[audio] == "builtin") {
			global $os;
			
			switch ($sysType) {
			  case "Mobile Workstation":
			  case "Notebook":
			  case "Ultrabook":
			  case "Tablet":
				$applehda = $edp_db->query("SELECT * FROM applehdaNB WHERE model_id = '$mdrow[id]'");
			  break;
		  
			  case "Desktop":
			  case "Workstation":
			  case "AllinOnePC":
				$applehda = $edp_db->query("SELECT * FROM applehdaDesk WHERE model_id = '$mdrow[id]'");
			  break;
			}
		
			switch ($os) {
				case "sl":    				
				case "lion":    				
				case "ml":    				
				case "mav":    				
				case "yos":
					foreach($applehda as $row) {
						
						if ($row['sl'] != "no")
						{
							$aID = explode(',', $row['sl']);
						
							if (getVersion() >= $aID[1]) {
								echo "<option value='sl' SELECTED>&nbsp; Audio: SL Patched AppleHDA v$aID[0]</option>\n";
								$using = "yes";
							}
						}
						
						if ($row['lion'] != "no")
						{
							$aID = explode(',', $row['lion']);

							if (getVersion() >= $aID[1]) {
								echo "<option value='lion' SELECTED>&nbsp; Audio: Lion Patched AppleHDA v$aID[0]</option>\n";
								$using = "yes";
							}
						}
						
						if ($row['ml'] != "no")
						{
							$aID = explode(',', $row['ml']);
							
							if (getVersion() >= $aID[1]) {
								echo "<option value='ml' SELECTED>&nbsp; Audio: ML Patched AppleHDA v$aID[0]</option>\n";
								$using = "yes";
							}
						}
						
						if ($row['mav'] != "no")
						{
							$aID = explode(',', $row['mav']);
							
							if (getVersion() >= $aID[1]) {
								echo "<option value='mav' SELECTED>&nbsp; Audio: Mavericks Patched AppleHDA v$aID[0]</option>\n";
								$using = "yes";
							}
						}
						
						if ($row['yos'] != "no")
						{
							$aID = explode(',', $row['yos']);
							
							if (getVersion() >= $aID[1]) {
								echo "<option value='yos' SELECTED>&nbsp; Audio: Yosemite Patched AppleHDA v$aID[0]</option>\n";
								$using = "yes";
							}
						}
					}
				break;
			}
		}
		// Check for VoodooDHA
		$voodoodHDA = $edp_db->query("SELECT * FROM audio");
		foreach($voodoodHDA as $row) {
			$sel = ""; 
			if ("$mdrow[audio]" == "$row[id]") { $sel = "SELECTED"; $using = "yes"; }
			echo "<option value='$row[id]' $sel>&nbsp; Audio: $row[name] v$row[version] </option>\n";
		}	
		
		if ($using == "")
			echo "<option value='no' SELECTED>&nbsp; Audio: None selected</option>\n"; 
			
		echo "<option value='no'>&nbsp; Audio: Don't load</option>\n";			
		echo "</select><span class='arrow'></span> </li>\n";


		//
		// Show dropdown for Ethernet (lan) Kexts
		//
		$lan = $edp_db->query("SELECT * FROM ethernet");
		echo "<li class='select'><select name='ethernet'>\n";
		
		$using = "";
		foreach($lan as $row) {
			$sel = ""; if ("$mdrow[ethernet]" == "$row[id]") { $sel = "SELECTED"; $using = "yes"; }
			echo "<option value='$row[id]' $sel>&nbsp; Ethernet: $row[name] v$row[version] by $row[owner]</option>\n";
		}			
		
		if ($using == "")
			echo "<option value='no' SELECTED>&nbsp; Ethernet: None selected</option>\n";
		
		echo "<option value='no'>&nbsp; Ethernet: Don't load</option>\n";	
		echo "</select><span class='arrow'></span> </li>\n";
			

		//
		// Show dropdown for WiFi Kexts
		//
		$wifi = $edp_db->query("SELECT * FROM wifi");
		echo "<li class='select'><select name='wifipack'>\n";
		
		$using = "";
		foreach($wifi as $row) {
			$s=""; if ("$mdrow[wifi]" == "$row[id]") { $s = "SELECTED"; $using = "yes"; }
			echo "<option value='$row[id]' $s>&nbsp; WiFi: $row[name] </option>\n";
		}
		
		if ($using == "")
			echo "<option value='no' SELECTED>&nbsp; WiFi: None selected</option>\n";
		
		echo "<option value='no'>&nbsp; WiFi: Don't load</option>\n";		
		echo "</select><span class='arrow'></span> </li>\n";
			

		//						
		// Show dropdown for Battery kexts
		//
		$bat = $edp_db->query("SELECT * FROM battery");
		echo "<li class='select'><select name='batterypack'>\n";
		
		$using = "";
		foreach($bat as $row) {
			$sel = ""; if ("$mdrow[battery]" == "$row[id]") { $sel = "SELECTED"; $using = "yes"; }
			echo "<option value='$row[id]' $sel>&nbsp; Battery: $row[name] v$row[version] by $row[owner] </option>\n";
		}			
		
		if ($using == "")
			echo "<option value='no' SELECTED>&nbsp; Battery: None selected</option>\n";
		
		echo "<option value='no'>&nbsp; Battery: Don't load</option>\n";		
		echo "</select><span class='arrow'></span> </li>\n";
			
			
		echo "</ul><br></div>";
?> 
