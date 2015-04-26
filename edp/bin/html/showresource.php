
<?php

	include_once "edpconfig.inc.php";
	include_once "functions.inc.php";

	include_once "header.inc.php";

	/*
	 * load the page of the selected side menu
	 */
 
 	//
 	// get category and id from the get and post methods
 	//
	$action = $_GET['action'];
	if ($action == "") {
		$action = $_POST['action'];
	}
	
	$categ	= $_GET['category'];
	if ($categ == "") {
		$categ = $_POST['category'];
	}	
	
	$id 	= $_GET['id'];
	if ($id == "") {
		$id = $_POST['id'];
	}

	switch ($categ) {
		case "Applications":
		case "Tools":
			$query = "SELECT * FROM appsdata";
			$buttonValue = "Proceed to Install/Update";
		break;
	
		case "EDP":
			$buttonValue = "Proceed to Install/Update";
		case "Configuration":
			$query = "SELECT * FROM edpdata";
		break;
	}

	// Get info from db
	$stmt = $edp_db->query("$query where id = '$id'");
	$stmt->execute();
	$bigrow = $stmt->fetchAll(); $row = $bigrow[0];
			
	if ($action == "")
	{
	
		if ($categ == "Applications" || $categ == "Tools")
		{
			$action = "Install";
			// Write out the top menu
			echoPageItemTOP("icons/apps/$row[icon]", "$row[name]");
		}
		else {
			// Write out the top menu
			echoPageItemTOP("icons/big/$row[icon]", "$row[name]");
		}
		
		echo "<form action='$row[action]' method='post'>";
			
		?>
		
		<div class="pageitem_bottom">
		<p><b>About:</b></p>
		<?="$row[brief]";?>
		<br>
		<p><b>Descripton:</b></p>
		<?="$row[description]";?>
		<br>
		<?php 
			
			if($categ != "EDP" && $categ != "Configuration") {
				echo "<p><b>Developer and Version:</b></p>";
				echo "$row[owner], v$row[version]";
				echo "<br>";
			}
		?>
		<p><b>Website:</b></p>
		<a href='<?="$row[link]";?>'>Project/Support Link</a>
		</div>
		<ul class="pageitem">
			<li class="button"><input name="Submit input" type="submit" value="<?=$buttonValue?>" /></li>
		</ul>
		
		<?php
			echo "<input type='hidden' name='id' value='$id'>";
			echo "<input type='hidden' name='action' value='$action'>";
			echo "<input type='hidden' name='category' value='$categ'>";
		?>

		</form>
		<?php
	}
	elseif ($action == "Install")
	{
		// Start installation process by Launching the script which provides the summary of the build process 
		echo "<script> document.location.href = 'workerapp.php?id=$id&foldername=$row[foldername]&name=$row[name]&icon=$row[icon]&action=showAppsLog'; </script>";
		
		// Clear logs and scripts
		if(is_dir("$logsPath/apps")) {
			system_call("rm -rf $logsPath/apps/*");
		}
		
		global $svnLoad;
		
		// Download app
		$svnLoad->svnDataLoader("AppsTools", "$row[menu]","$row[foldername]");
	}

?>
