<?php

		echo "<div id=\"tabs-3\"><span class='graytitle'>Chameleon bootloader configuration</span>";
		echo "<ul class='pageitem'>";				
		echo "<span class='arrow'></span><li class='select'><select name='chameBootID' id='chameBootID'>";
		echo "<option value='' selected>&nbsp;&nbsp;Select version here if you want to update bootloader...</option>\n";
			
			$i = 0;
			while ($chameBootdb[$i] != "") {
				//resetting vars
				$id = ""; $version = ""; $notes = ""; $type = ""; $os_support = "";
				
				//Getting vars from the optional multidim. array
				$id = $chameBootdb[$i]['id']; $type = $chameBootdb[$i]['type']; 
				$version = $chameBootdb[$i]['version'];  $notes = $chameBootdb[$i]['notes'];
				$os_support = $chameBootdb[$i]['os_support'];
				
				echo "<option value='$id' >&nbsp;&nbsp;$type v$version $os_support </option>\n";
					
				$i++;
			}
			
		echo "</select>span class='arrow'></span></li>";
		checkbox("Use custom chameleon (if you have, copy boot file to '/Extra/include')?", "customCham", "no");	
		echo "</ul><br>";
		
		echo "<span class='graytitle'>Modules</span>";
		echo "<ul class='pageitem'>";
			$i=0;
			while ($chamdb[$i] != "") {
				//resetting vars
				$id = ""; $name = ""; $desc = ""; $status = ""; $c = "";
				
				//Getting vars from the optional multidim. array
				$id = $chamdb[$i]['id']; $uid = $chamdb[$i]['edpname']; $desc = $chamdb[$i]['description'];
				
				//Checking wether we are using this in our model
				$status = isChamModsInUse("$id");
				
				checkbox("$desc", "$uid", "$status");
				
				$i++;
			}	
			
		echo "</ul><br></div>";
		
		
		function isChamModsInUse($id) {
			global $modelID; global $edp_db;
			global $query;
			$stmt = $edp_db->query($query);
			$stmt->execute();
			$result = $stmt->fetchAll();

			$data = $result[0]['chameMods'];
			//If nothing is defined in the models db just return blank
			if ($data == "") { return "no"; }
			
			$array 	= explode(',', $data);
			foreach($array as $opt) {
				if ($opt == $id) { return "yes"; }				
			}
			return "no";
		}
	
?> 
