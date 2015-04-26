<?php

		echo "<div id=\"tabs-4\"><span class='graytitle'>Fixes</span>";
		echo "<ul class='pageitem'><form name='fixesCheck'>";
			$i=0;
			while ($fixesdb[$i] != "") {
				//resetting vars
				$id = ""; $name = ""; $desc = ""; $status = ""; $c = "";
				
				//Getting vars from the optional multidim. array
				$id = $fixesdb[$i]['id']; $name = $fixesdb[$i]['name']; $owner = $fixesdb[$i]['owner'];
				
				//Checking wether we are using this in our model
				$status = isFixesInUse("$id");
				
				//If the status is "yes" then we will set $c as checked
				if ($status == "yes") { $c = "checked"; }
				
				echo "<li class='checkbox'><span class='name'>$name ($owner)</span><input name='fixesChkBox' value='$id' type='checkbox' $c onchange=\"updateFixes();\"> </li>  \n";
				$i++;
			}	
			
		echo "</ul><br></form></div>";
		echo "<input type='hidden' name='fixes' id='fixes'>";
		
		
		function isFixesInUse($id) {
			global $modelID; global $edp_db; global $query;
			$stmt = $edp_db->query($query);			
			$stmt->execute();
			$bigrow = $stmt->fetchAll(); $row = $bigrow[0];

			$data = $row[genfixes];
			//If nothing is defined in the modelsdb just return blank
			if ($data == "") { return "no"; }
			
			$array 	= explode(',', $data);
			foreach($array as $opt) {
				if ($opt == $id) { return "yes"; }				
			}
			return "no";
		}
	
?> 

<script>

//Init the updateFixes - this will fill a hidden input field with the values from the checkboxes
updateFixes();

function updateFixes() {
	var fixesCheck = document.forms[0];
	
	var fixesList = '';
	for (i = 0; i < fixesCheck.fixesChkBox.length; i++) {
			
		if (fixesCheck.fixesChkBox[i].checked) {
			//add seperator ','
			if(fixesList != "")
				fixesList = fixesList +',';
			var v = fixesCheck.fixesChkBox[i].value;
			fixesList = fixesList+v;
		}
		
	}
	document.getElementById("fixes").value = fixesList;
	
}	

</script>