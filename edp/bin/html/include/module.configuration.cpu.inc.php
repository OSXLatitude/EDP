<?php
		echo "<div id=\"tabs-2\"><span class='graytitle'>CPU & Power</span>";
		echo "<ul class='pageitem'>";
			$i=0;
			while ($cpufixdb[$i] != "") {
				//resetting vars
				$id = ""; $name = ""; $desc = ""; $status = "";
				
				//Getting vars from the optional multidim. array
				$id = $cpufixdb[$i]['id']; $name = $cpufixdb[$i]['name']; $uid = $cpufixdb[$i]['edpid'];
				
				//Checking wether we are using this in our model
				$status = isCPUFixInUse("$id");
				
				checkbox("$name", "$uid", "$status");	
				
				$i++;
			}	
			
		echo "</ul><br></div>";
		
		function isCPUFixInUse($id) {
			global $modelID; global $edp_db; global $query;
			$stmt = $edp_db->query($query);
			$stmt->execute();
			$result = $stmt->fetchAll();

			$data = $result[0]['pmfixes'];
			//If nothing is defined in the models db just return blank
			if ($data == "") { return "no"; }
			
			$array 	= explode(',', $data);
			foreach($array as $opt) {
				if ($opt == $id) { return "yes"; }				
			}
			return "no";
		}
		
?> 
