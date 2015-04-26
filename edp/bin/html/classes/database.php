 <?php

class edpDatabase {
 
	//
	// Get data from database table using ID
	//
	public function getKextpackDataFromID($table, $id) {
		if ($table != "" && $id != "") {
			global $edp_db;
			$stmt = $edp_db->query("SELECT * FROM $table where id = '$id'");
			$stmt->execute(); $result = $stmt->fetchAll(); $kprow = $result[0];
			return $kprow;
		}		
	}

	//
	// Get model data from database using ID
	//
	public function getModelDataFromID($sysType, $modelid) {
		
			global $edp_db;
			
			switch ($sysType) {
			  case "Mobile Workstation":
 			  case "Notebook":
 			  case "Ultrabook":
 			  case "Tablet":
 			  	$query = "SELECT * FROM modelsPortable WHERE type = '$sysType' AND id = '$modelid'";
 			  break;
 			  
 			  case "Desktop":
 			  case "Workstation":
 			  case "AllinOnePC":
 			  	$query = "SELECT * FROM  modelsDesk WHERE type = '$sysType' AND id = '$modelid'";
 			  break;
 			}
 	
			$stmt = $edp_db->query($query);
			$stmt->execute(); $result = $stmt->fetchAll(); 
			$mdata = $result[0]; //get first row
			return $mdata;
    }

	//
	// Get System type values for the models from database
	//	
	public function getSystemTypeValue() {
		global $edp_db;

		$return = '';

		$result = $edp_db->query("SELECT DISTINCT type FROM modelsPortable ORDER BY type");

		foreach($result as $row) {
			$return .= '<option value="' . $row['type'] . '">&nbsp;&nbsp;' . $row['type'] . '</option>';
		}
	
		$result = $edp_db->query("SELECT DISTINCT type FROM modelsDesk ORDER BY type");

		foreach($result as $row) {
			$return .= '<option value="' . $row['type'] . '">&nbsp;&nbsp;' . $row['type'] . '</option>';
		}

		return $return;
	 }

	//
	// Get vendor values from database using ID
	//
	public function builderGetVendorValuebyID($sysType, $modelid) {
		global $edp_db;

		switch ($sysType) {
				  case "Mobile Workstation":
				  case "Notebook":
				  case "Ultrabook":
				  case "Tablet":
					$query = "SELECT DISTINCT vendor FROM modelsPortable WHERE type = '$sysType' AND id = '$modelid'";
				  break;
			  
				  case "Desktop":
				  case "Workstation":
				  case "AllinOnePC":
					$query = "SELECT DISTINCT vendor FROM  modelsDesk WHERE type = '$sysType' AND id = '$modelid'";
				  break;
		}
	
		$stmt = $edp_db->query($query);
		$stmt->execute();
		$bigrow = $stmt->fetchAll(); $mdrow = $bigrow[0];
		return $mdrow[vendor];
	 }

	//
	// Get series values from database using ID
	//
	public function builderGetSeriesValuebyID($sysType, $modelid) {
		global $edp_db;

		switch ($sysType) {
				  case "Mobile Workstation":
				  case "Notebook":
				  case "Ultrabook":
				  case "Tablet":
					$query = "SELECT DISTINCT series FROM modelsPortable WHERE type = '$sysType' AND id = '$modelid'";
				  break;
			  
				  case "Desktop":
				  case "Workstation":
				  case "AllinOnePC":
					$query = "SELECT DISTINCT series FROM  modelsDesk WHERE type = '$sysType' AND id = '$modelid'";
				  break;
		}
	
		$stmt = $edp_db->query($query);
		$stmt->execute();
		$bigrow = $stmt->fetchAll(); $mdrow = $bigrow[0];
		return $mdrow[series];
	 }

	//
	// Get generation values from database using ID
	//
	public function builderGetGenValuebyID($sysType, $modelid) {
		global $edp_db;

		switch ($sysType) {
				  case "Mobile Workstation":
				  case "Notebook":
				  case "Ultrabook":
				  case "Tablet":
					$query = "SELECT DISTINCT generation FROM modelsPortable WHERE type = '$sysType' AND id = '$modelid'";
				  break;
			  
				  case "Desktop":
				  case "Workstation":
				  case "AllinOnePC":
					$query = "SELECT DISTINCT generation FROM  modelsDesk WHERE type = '$sysType' AND id = '$modelid'";
				  break;
		}
	
		$stmt = $edp_db->query($query);
		$stmt->execute();
		$bigrow = $stmt->fetchAll(); $mdrow = $bigrow[0];
		return $mdrow[generation];
	 }

	//
	// Get vendor values from database using system type
	//
	public function builderGetVendorValues($sysType) {
		global $edp_db;

		switch ($sysType) {
			      case "Mobile Workstation":
				  case "Notebook":
				  case "Ultrabook":
				  case "Tablet":
					$query = "SELECT DISTINCT vendor FROM modelsPortable WHERE type = '$sysType'";
				  break;
			  
				  case "Desktop":
				  case "Workstation":
				  case "AllinOnePC":
					$query = "SELECT DISTINCT vendor FROM  modelsDesk WHERE type = '$sysType'";
				  break;
		}
	
		$result = $edp_db->query($query);
		$return = '';

		foreach($result as $row) {
		   $return .= '<option value="' . $row['vendor'] . '">&nbsp;&nbsp;' . $row['vendor'] . '</option>';
		}

		return '<option value="" >&nbsp;&nbsp;Select vendor...</option>' . $return;
	}

	//
	// Get series values from database using system type
	//
	public function builderGetSerieValues($sysType, $vendor) {
		global $edp_db;

		switch ($sysType) {
				  case "Mobile Workstation":
				  case "Notebook":
				  case "Ultrabook":
				  case "Tablet":
					$query = "SELECT DISTINCT vendor, series FROM modelsPortable WHERE type = '$sysType' AND vendor = '$vendor' ORDER BY series";
				  break;
			  
				  case "Desktop":
				  case "Workstation":
				  case "AllinOnePC":
					$query = "SELECT DISTINCT vendor, series FROM  modelsDesk WHERE type = '$sysType' AND vendor = '$vendor' ORDER BY series";
				  break;
		}
	
		$result = $edp_db->query($query);
		$return = '';

		foreach($result as $row) {
			$return .= '<option value="' . $row['series'] . '">&nbsp;&nbsp;' . $row['vendor'] . ' ' . $row['series'] . ' </option>';
		}

		return '<option value="" >&nbsp;&nbsp;Select series...</option>' . $return;
	}

	//
	// Get model data from database using system type
	//
	public function builderGetModelValues($sysType, $vendor, $series, $generation) {
		global $edp_db;

		switch ($sysType) {
				  case "Mobile Workstation":
				  case "Notebook":
				  case "Ultrabook":
				  case "Tablet":
					$query = "SELECT DISTINCT * FROM modelsPortable WHERE type = '$sysType' AND vendor = '$vendor' AND series = '$series' ORDER BY type";
				  break;
			  
				  case "Desktop":
				  case "Workstation":
				  case "AllinOnePC":
					$query = "SELECT DISTINCT * FROM  modelsDesk WHERE type = '$sysType' AND vendor = '$vendor' AND series = '$series' ORDER BY type";
				  break;
		}
	
		$result = $edp_db->query($query);
		$return = '';

		foreach($result as $row) {
			if($row['generation'] != "")
				$return .= '<option value="' . $row['id'] . '">&nbsp;&nbsp;' . $row[desc] . ' (' . $row['generation'] .')  </option>';
			else
				$return .= '<option value="' . $row['id'] . '">&nbsp;&nbsp;' . $row[desc] . ' - STILL WORK IN PROGRESS, USE OUR FORUM FOR SUPPORT </option>';
		}

		return '<option value="" >&nbsp;&nbsp;Select model...</option>' . $return;
	}
	
	//
	// Get model data from database using system type
	//
	public function builderGetCPUValues($sysType, $modelid) {
		global $edp_db;

		switch ($sysType) {
				  case "Mobile Workstation":
				  case "Notebook":
				  case "Ultrabook":
				  case "Tablet":
					$query = "SELECT DISTINCT * FROM modelsPortable WHERE type = '$sysType' AND id = '$modelid' ORDER BY type";
					$cpuquery = "SELECT * FROM cpuNB";
				  break;
			  
				  case "Desktop":
				  case "Workstation":
				  case "AllinOnePC":
					$query = "SELECT DISTINCT * FROM modelsDesk WHERE type = '$sysType' AND id = '$modelid' ORDER BY type";
					$cpuquery = "SELECT * FROM cpuDesk";
				  break;
		}
	
		$result = $edp_db->query($query);
		$return = '';

		$cpuCount = 0;
		foreach($result as $row) {
			if($row['cpu'] != "") {
				
				$data = $row['cpu'];
    			$cpuArray 	= explode(',', $data);
    
    			foreach($cpuArray as $cpuID) {
    				$cpuID = preg_replace('/\s+/', '',$cpuID); //remove white spaces
    				
    				$cpuRes = $edp_db->query("$cpuquery WHERE id = '$cpuID'");

    				foreach($cpuRes as $cpuName) {
    					$return .= '<option value="' . $cpuName['id'] . '">&nbsp;&nbsp;' . $cpuName['name'] . '</option>';
    				}
    			}
				$cpuCount++;
			}
		}
		if ($cpuCount == 0)
			$return .= '<option value="EDP">&nbsp;&nbsp;According to EDP database</option>';
			
		return '<option value="" >&nbsp;&nbsp;Select your CPU model...</option>' . $return;
	}

	public function updateDB() {
		global $workPath;
		
    	echo "\nUpdating database... <br><br>\n";
    	system_call("rm -Rf $workPath/bin/edp.sqlite3");
    	system_call("curl -o $workPath/bin/edp.sqlite3 http://www.osxlatitude.com/dbupdate.php");
    }
}

$edpDBase = new edpDatabase();

?> 
