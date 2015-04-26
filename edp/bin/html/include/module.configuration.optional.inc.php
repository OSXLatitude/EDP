<?php


		echo "<div id=\"tabs-5\"><span class='graytitle'>Optional</span>";
		echo "<ul class='pageitem'><form name='optionalcheck'>";
			$i=0;
			while ($optdb[$i] != "") {
				//resetting vars
				$id = ""; $name = ""; $arch = ""; $notes = ""; $status = ""; $c = "";
				
				//Getting vars from the optional multidim. array
				$id = $optdb[$i]['id']; $name = $optdb[$i]['name']; $brief = $optdb[$i]['brief']; $ver = $optdb[$i]['version'];
				$owner = $optdb[$i]['owner'];
				
				//Checking wether we are using the optional pack in our model
				$status = isOPTinUse("$id");
				
				//If the status is "yes" we will set $c as checked
				if ($status == "yes") { $c = "checked"; }
				
				echo "<li class='checkbox'><span class='name'>$name - v$ver ($owner) </span><input name='optionalbox' value='$id' type='checkbox' $c onchange=\"updateOPT();\"> </li>  \n";
				$i++;
			}	
			
		echo "</ul><br></form></div>";
		echo "<input type='hidden' name='optionalpacks' id='optionalpacks'>";
		
		
		
		
		function isOPTinUse($id) {
			global $modelID; global $edp_db;
			global $query;
			$stmt = $edp_db->query($query);
			$stmt->execute();
			$bigrow = $stmt->fetchAll(); $row = $bigrow[0];

			$data = $row[optionalpacks];
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

//Init the updateOPT - this will fill a hidden input field with the values from the optional checkboxes
updateOPT();

function updateOPT() {
	var optionalcheck = document.forms["optionalcheck"];
	
	var opList = '';
	for (i = 0; i < optionalcheck.optionalbox.length; i++) {
		if (optionalcheck.optionalbox[i].checked) {
			//add seperator ','
			if(opList != "")
				opList = opList +',';
			var v = optionalcheck.optionalbox[i].value;
			opList = opList+v;
		}
		
	}
	document.getElementById("optionalpacks").value = opList;
	
}	

</script>
