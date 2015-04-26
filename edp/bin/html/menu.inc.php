<?php
	$i = $_GET['i'];
	include_once "edpconfig.inc.php";
	if (!$i) { $i = "EDP"; }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link href="css/sidebar.css" rel="stylesheet" media="screen" type="text/css" />
</head>
<body background="images/sidebar_bg.png">


<script>
	function mover(obj) {
		obj.style.color = '#476A83';
	}
	function mout(obj) {
		obj.style.color = '#000000';
	}
</script>
	

<script>
    function loadURL(page) {
	    top.document.getElementById('console_iframe').src = page;
    }
</script>


<?php

	//
	// Credits menu
	//
	if ($i == "Credits") {
		$creditCateg = $edp_db->query("SELECT * FROM credits order by category");
		foreach($creditCateg as $row) {
			if ($row[category] != $last && $row[status] == "active") { 
				echo "<div id='title' class='edpmenu_title_text' style='margin-top: 10px;'>&nbsp;&nbsp;$row[category]</div>";
				echo "<table id='menu' class='edpmenu_menuoption' border='0' width='100%' cellpadding='0' style='border-collapse: collapse'>\n";
				
				$crditName = $edp_db->query("SELECT * FROM credits where category = '$row[category]' order by name");
				foreach($crditName as $nameRow) {
					addMenuItem("loadURL('workerapp.php?action=showCredits&id=$nameRow[id]');", "icons/sidebar/user.png", "$nameRow[name] <i>by $nameRow[owner]</i>");
				}
				echo "</table>";
			}
			$last = $row[category];
		}
		exit;	
	}

	//
	// Side menus
	// 
	switch ($i) {
		case "Applications":
		case "Tools":
			//
			// Fetch and add menu items that have a category defined 
			//
			generateMenu("SELECT * FROM appsdata", "where category = '$i' order by menu");

		break;
	
		case "EDP":
		case "Configuration":
			//
			// Fetch and add menu items that have a category defined 
			//
			generateMenu("SELECT * FROM edpdata", "where category = '$i' order by menu");
			
		break;
	
		case "Fixes":
			//
			// Fetch and add menu items for pmfixes 
			//
			generateMenu("SELECT * FROM pmfixes", "order by menu");
			
			//
			// Fetch and add menu items for sysfixes 
			//
			generateMenu("SELECT * FROM sysfixes", "order by menu");
			
			//
			// Fetch and add menu items for wifi 
			//
			generateMenu("SELECT * FROM wifi", "order by menu");

		break;
		
		case "Kexts":
			//
			// Fetch and add menu items for audio 
			//

			echo "<div id='title' class='edpmenu_title_text'  style='margin-top: 10px;'>&nbsp;&nbsp;Audio</div>";
			echo "<table id='menu' class='edpmenu_menuoption' border='0' width='100%' cellpadding='0' style='border-collapse: collapse'>\n";
			echo "<tr onclick=\"loadURL('kexts.php?category=audio&id=4');\" style='cursor: hand'>";
			echo "	<td width='20' height='28'></td>\n";
			echo "	<td width='24' height='28'><img alt='list' src='icons/sidebar/kext.png' width='18px' height='18px'/></td>\n";
			echo "	<td><span class='edpmenu_menuoption_text' onmouseover='mover(this)' onmouseout='mout(this)'>VoodooHDA</span></td>";
			echo "</tr>\n";
			echo "</table>";
			
			//
			// Fetch and add menu items for battery 
			//
			generateMenu("SELECT * FROM battery", "order by menu");
			
			//
			// Fetch and add menu items for fakesmc 
			//
			generateMenu("SELECT * FROM fakesmc", "order by menu");
			
			//
			// Fetch and add menu items for ethernet 
			//
			generateMenu("SELECT * FROM ethernet", "order by menu");
			
			//
			// Fetch and add menu items for ps2 
			//
			generateMenu("SELECT * FROM ps2", "order by menu");
			
			//
			// Fetch and add menu items for optionalpacks 
			//
			generateMenu("SELECT * FROM optionalpacks", "order by menu");

		break;
	
	}	

	//
	// Generate menu
	//
	function generateMenu($query, $conditional) {
		//
		// Add menu items 
		//
		global $edp_db;
		$categData = $edp_db->query("$query $conditional");
		foreach($categData as $row) {
			if ($row[menu] != $last) { 
				echo "<div id='title' class='edpmenu_title_text'  style='margin-top: 10px;'>&nbsp;&nbsp;$row[menu]</div>";
				generateMenuItems("$query", "$row[menu]", "$row[category]");
			}
			$last = $row[menu];
		}
	}
	
	//
	// Generate menu items
	//
	function generateMenuItems($query, $menu, $category) {
		global $edp_db;
		echo "<table id='menu' class='edpmenu_menuoption' border='0' width='100%' cellpadding='0' style='border-collapse: collapse'>\n";
	
		$menuData = $edp_db->query("$query where menu = '$menu' order by name");
		foreach($menuData as $row) {
			if ($row[status] == "active") {
				//
				// Check if the type is redirect (meaning it will go thru showresource php) or direct instead
				//
				
				// choose icon
				if ($row[category] == "Applications") { $icon = "icons/sidebar/apps.png"; } 
				elseif ($row[category] == "Tools") { $icon = "icons/sidebar/tools.png"; } 
				else { $icon = "icons/sidebar/$row[icon]"; }
				
				// direct load
				if ($row[access] == "direct") { addMenuItem("loadURL('$row[action]');", "$icon", "$row[name]"); }
			
				// redirecting the resource with category and id info in the link
				else { addMenuItem("loadURL('showresource.php?category=$category&id=$row[id]');", "$icon", "$row[name]"); }
			}
		}
		echo "</table>";
	}	

	//
	// Add menu items
	//
	function addMenuItem($action, $icon, $title) {
		echo "<tr onclick=\"$action\" style='cursor: hand'>";
		echo "	<td width='20' height='28'></td>\n";
		echo "	<td width='24' height='28'><img alt='list' src='$icon' width='18px' height='18px'/></td>\n";
		echo "	<td><span class='edpmenu_menuoption_text' onmouseover='mover(this)' onmouseout='mout(this)'>$title</span></td>";
		echo "</tr>\n";
	}

?>
		
</body>