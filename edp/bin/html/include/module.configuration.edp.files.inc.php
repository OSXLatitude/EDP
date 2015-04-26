<?php

echo "<div id=\"tabs-1\">";
echo "<span class='graytitle'>Files Found in /Extra/Extensions</span>";
echo "<ul class='pageitem'>";


//Get all the kexts name in comma seperated way
			$elinfo = shell_exec("ls -m /Extra/Extensions/");
    		$ekarray = explode(',', $elinfo);
				
			$euid = 0;
			foreach($ekarray as $ekfname) {
				
				if ($ekfname != "") {
					$ekname = explode('.', $ekfname);
					
					// add if it has kext extension
					// ekname[0] has kext name and ekname[1] has extension
					$ekname = preg_replace('/\s+/', '',$ekname); //remove white spaces
						
					if($ekname[1] == "kext\n" || $ekname[1] == "kext")
						checkbox("$ekfname", $euid, "yes");
						
					$euid++;	
				}
			}
		
		echo "</ul>";
		echo "<span class='graytitle'>Files Found in /Extra</span>";
		echo "<ul class='pageitem'>";
		
		if(file_exists("/Extra/DSDT.aml")) { checkbox("DSDT", "edsdt", "yes"); $euid++; }
		
		if(file_exists("/Extra/org.chameleon.Boot.plist")) { checkbox("org.chameleon.Boot.plist", "eboot", "yes"); $euid++; }

		if(file_exists("/Extra/SMBios.plist")) { checkbox("SMBios.plist", "esmbios", "yes"); $euid++; }
		
		if(file_exists("/Extra/SSDT.aml")) { checkbox("SSDT", "essdt", "yes"); $euid++; }

		if(file_exists("/Extra/SSDT-1.aml")) { checkbox("SSDT-1", "essdt1", "yes"); $euid++; }

		if(file_exists("/Extra/SSDT-2.aml")) { checkbox("SSDT-2", "essdt2", "yes"); $euid++; }

		if(file_exists("/Extra/SSDT-3.aml")) { checkbox("SSDT-3", "essdt3", "yes"); $euid++;}

		if(file_exists("/Extra/SSDT-4.aml")) { checkbox("SSDT-4", "essdt4", "yes"); $euid++;}
		
		echo "</ul>";
		
	echo "<span class='graytitle'>Which operation you would like to do?</span>";
	
	echo "<ul class='pageitem'><li class='select'>";
	echo "<select id=\"eopchoice\" name=\"eopchoice\">";
	echo "<option value=\"enone\">&nbsp;&nbsp;None</option>";
 	echo "<option value=\"ebuild\">&nbsp;&nbsp;Uninstall selected files from system</option>";
 	echo "<option value=\"edelonly\">&nbsp;&nbsp;Remove unselected files from /Extra/Extensions</option>";

	echo "</select></li></ul>";
	echo "<br></div>";

?>

