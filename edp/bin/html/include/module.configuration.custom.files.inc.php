<?php
echo "<div id=\"tabs-0\">";
echo "<span class='graytitle'>Files Found in /Extra/include/Extensions</span>";
echo "<ul class='pageitem'>";
//Get all the kexts name in comma seperated way
		$clinfo = shell_exec("ls -m /Extra/include/Extensions/");
    	$ckarray = explode(',', $clinfo);

		$cuid = 100;
		foreach($ckarray as $ckfname) {
				
				if ($ckfname != "") {
					$ckname = explode('.', $ckfname);
					
					// add if it has kext extension
					// ckname[0] has kext name and ckname[1] has extension
					$ckname = preg_replace('/\s+/', '',$ckname); //remove white spaces
						
					if($ckname[1] == "kext\n" || $ckname[1] == "kext")
						checkbox("$ckfname", $cuid, "yes");
						
					$cuid++;	
				}
			}
			
echo "</ul>";
echo "<span class='graytitle'>Files Found in /Extra/include</span>";
echo "<ul class='pageitem'>";

	if(file_exists("/Extra/include/DSDT.aml")) {
			echo "<li class='checkbox'><span class='name'>DSDT.aml </span><input name='dsdt' id='dsdt' type='checkbox' checked   > </li>  \n";
			$cuid++;
		}
		if(file_exists("/Extra/include/org.chameleon.Boot.plist")) {
			echo "<li class='checkbox'><span class='name'>org.chameleon.Boot.plist </span><input name='boot' id='boot' type='checkbox' checked   > </li>  \n";
			$cuid++;
		}
		if(file_exists("/Extra/include/SMBios.plist")) {
			echo "<li class='checkbox'><span class='name'>SMBios.plist </span><input name='smbios' id='smbios' type='checkbox' checked   > </li>  \n";
			$cuid++;
		}
		if(file_exists("/Extra/include/SSDT.aml")) {
			echo "<li class='checkbox'><span class='name'>SSDT.aml </span><input name='ssdt' id='ssdt' type='checkbox' checked   > </li>  \n";
			$cuid++;
		}
		if(file_exists("/Extra/include/SSDT-1.aml")) {
			echo "<li class='checkbox'><span class='name'>SSDT-1.aml </span><input name='ssdt1'  id='ssdt1' type='checkbox' checked   > </li>  \n";
			$cuid++;
		}
		if(file_exists("/Extra/include/SSDT-2.aml")) {
			echo "<li class='checkbox'><span class='name'>SSDT-2.aml </span><input name='ssdt2'  id='ssdt2' type='checkbox' checked   > </li>  \n";
			$cuid++;
		}
		if(file_exists("/Extra/include/SSDT-3.aml")) {
			echo "<li class='checkbox'><span class='name'>SSDT-3.aml </span><input name='ssdt3' id='ssdt3'  type='checkbox' checked   > </li>  \n";
			$cuid++;
		}
		if(file_exists("/Extra/include/SSDT-4.aml")) {
			echo "<li class='checkbox'><span class='name'>SSDT-4.aml </span><input name='ssdt4' id='ssdt4' type='checkbox' checked   > </li>  \n";
			$cuid++;
		}
echo "</ul>";
		if($cuid > 0)
			echo "<div id='delbtn-div-bottom' style=\"display: none;\"><ul class='pageitem'><li class='button'><input name='Submit delete' id='delbtn' type='submit' value='Delete unchecked files!' /></li></ul></div>\n";
	
	echo "<span class='graytitle'>Which operation you would like to do?</span>";
	echo "<ul class='pageitem'><li class='select'>";
	echo "<select id=\"copchoice\" name=\"copchoice\">";
	echo "<option value=\"cnone\">&nbsp;&nbsp;None</option>";
 	echo "<option value=\"cbuild\">&nbsp;&nbsp;Install selected files into System</option>";
 	echo "<option value=\"cdelonly\">&nbsp;&nbsp;Remove unselected files from /Extra/include</option>";
 	echo "<option value=\"cfixcache\">&nbsp;&nbsp;Quick fix to fix permssions and generate cache </option>";
 	echo "<option value=\"cfullfix\">&nbsp;&nbsp;Full fix to fix permisions and generate cache (takes more time)</option>";

	echo "</select></li></ul>";
 
echo "<br></div>";

?>
