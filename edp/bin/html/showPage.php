
<?php
	$i = $_GET['i'];
	if ($i == "") {
		$i = $_POST['i'];
	}
	
	// For logs
	date_default_timezone_set("UTC");
	$date = date("d-m-y H-i");

	include_once "edpconfig.inc.php";
	include_once "header.inc.php";

	/*
 	 * load the page of the selected main menu
 	 */
 	 
	switch ($i) {
		case "EDP":
			include_once "libs/Highchart.php";
			//----------------------------------------------------------------------------> Highchart stuff....... //
			$vendors = array();
			$total = 0;
			$dTotal = 0;
			$nbTotal = 0;

			// Get Notebooks data from db
			$nbookData = $edp_db->query("SELECT vendor, COUNT(*) AS count FROM modelsPortable WHERE generation !='' GROUP BY vendor ORDER BY count DESC");

			// Loop the result and add it to $vendors
			foreach($nbookData as $row) {
				$tmp = $row;
				unset($tmp[0], $tmp[1]);
				$vendors[] = $tmp;
				$total += $row['count'];
				$nbTotal += $row['count'];
			}

			// Calculate the percentage per vendor
			foreach($vendors as $i => $vendor) {
			if($total != 0) {
				$c = round(($vendor['count']/$total)*100, 1);
				$vendors[$i]['share'] = round($c, 0);
			} 
			else {
				$vendors[$i]['share'] = 0;
			  }
			}

			// Get Desktops data from db
			$deskData = $edp_db->query("SELECT vendor, COUNT(*) AS count FROM modelsDesk WHERE generation !='' GROUP BY vendor ORDER BY count DESC");

			// Loop the result and add it to $vendors
			foreach($deskData as $row) {
				$tmp = $row;
				unset($tmp[0], $tmp[1]);
				$vendors[] = $tmp;
				$total += $row['count'];
				$dTotal += $row['count'];
			}

			// Calculate the percentage per vendor
			foreach($vendors as $i => $vendor) {
			if($total != 0) {
				$c = round(($vendor['count']/$total)*100, 1);
				$vendors[$i]['share'] = round($c, 0);
			} 
			else {
				$vendors[$i]['share'] = 0;
				}
			}

			/*
			echo count($vendors);

			$nbDet['vendor'] = "Notebooks";
			$nbDet['count'] = $nbTotal;
			$vendors[] = $nbDet;

			$c = round(($nbTotal/$total)*100, 1);
			$vendors[count($vendors) - 1]['share'] = round($c, 0);
			*/

			$chart = new Highchart();

			$chart->chart->renderTo = "container";
			$chart->chart->plotBackgroundColor = '#FFFFFF';
			$chart->chart->plotBorderWidth = '0px';
			$chart->chart->plotShadow = false;
			$chart->title->text = "We currently have $total systems in EDP (Notebooks : $nbTotal, Desktops : $dTotal)";

			$chart->tooltip->formatter = new HighchartJsExpr("function() {
		    return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage) +' %';}");

			$chart->plotOptions->pie->allowPointSelect = 1;
			$chart->plotOptions->pie->cursor = "pointer";
			$chart->plotOptions->pie->dataLabels->enabled = 1;
			$chart->plotOptions->pie->dataLabels->color = "#000000";
			$chart->plotOptions->pie->dataLabels->connectorColor = "#000000";

			$chart->plotOptions->pie->dataLabels->formatter = new HighchartJsExpr("function() {
		    return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage) +' %'; }");

			// Make the array for the chart
			$vendor_chart_data = array();
			foreach($vendors as $vendor) {
				$vendor_chart_data[] = array(
				'name' => $vendor['vendor'],
				'y' => $vendor['share'],
				'sliced' => $vendor['vendor'] == "Dell" ? TRUE : FALSE,
				);
			}
			$vendor_chart = array(
			'type' => "pie",
			'name' => "Vendor share",
			'data' => $vendor_chart_data,
			);

			$chart->series[] = $vendor_chart;

			foreach ($chart->getScripts() as $script) {
				echo '<script type="text/javascript" src="' . $script . '"></script>';
			}

			//<---------------------------------- Highchart stuff end... //

			echoPageItemTOP("icons/big/edp.png", "Welcome to EDP");
			echo "<div class='pageitem_bottom'>\n";
			echo "EDP is a unique control panel for your hackintosh that makes it easy to maintain and configure your system. Its internal database contains 'best practice' schematics for many systems - this makes it easy to choose the right configuration.</p>";
			
			echo "<div id='container'></div>";
			
			?>
			<script type="text/javascript">

			<?php
     			echo $chart->render("chart1");
			?>
    
 		   // Hack: Modify color of pie chart border   
 			$(document).ready(function() {
 			$( "rect" ).each(function( index ) {
  				if($(this).attr("fill")=="#FFFFFF") { 
	 				 $(this).attr("fill", "#FFFFFF");
  	 		 		}
				});
 			});
 			</script>
 			
 			<?php
 			
		break;
		
		case "Configuration":
			echoPageItemTOP("icons/big/config.png", "Configuration");
			echo "<div class='pageitem_bottom'>";
			echo "Build your model using EDP which provides combination of kexts, dsdt, plists needed to boot your system and allows you to configure.";
			echo "</div>";
		break;
		
		case "Applications":
			echoPageItemTOP("icons/big/apps.png", "Applications");
			echo "<div class='pageitem_bottom'>";
			echo "In this section you can find some of the most used hackintosh applications.<br>";
			echo "Know a good application that we should include? Shoot an email to <a href='mailto:lsb@osxlatitude.com'>lsb@osxlatitude.com</a>";
			echo "</div>";
		break;
		
		case "Tools":
			echoPageItemTOP("icons/big/tools.png", "Tools");
			echo "<div class='pageitem_bottom'>";
			echo "Having the right tool for the situation is always part of the problem. We have collected some of the best tools out there.<br>";
			echo "Know a good tool that we should include? Shoot an email to <a href='mailto:lsb@osxlatitude.com'>lsb@osxlatitude.com</a>";
			echo "</div>";
		break;
		
		case "Fixes":
			echoPageItemTOP("icons/big/terminal.png", "Fixes - The solution to the problem!");
			echo "<div class='pageitem_bottom'>";
			echo "This section contains solution for the most common Hackintosh problems.<br>";
			echo "Know a fix that we should include? Shoot an email to <a href='mailto:lsb@osxlatitude.com'>lsb@osxlatitude.com</a>";
			echo "</div>";
		break;
		
		case "Kexts":
			echoPageItemTOP("icons/big/kext.png", "Kexts");
			echo "<div class='pageitem_bottom'>";
			echo "This section contains kexts developed and patched by the Hackintosh community.<br>";
			echo "Know a kext that we should include? Shoot an email to <a href='mailto:lsb@osxlatitude.com'>lsb@osxlatitude.com</a>";
			echo "</div>";
		break;
		
		case "Credits":
			echoPageItemTOP("icons/big/credits.png", "Credits");
			echo "<div class='pageitem_bottom'>";
			echo "You can see all of the names of the people who contributed their files to EDP in this section.<br>";

			echo "<h1>Thank you!!!!</h1>";
			echo "<h2> .. to all of you that made EDP happened.</h2>";
			echo "<br>";

			echo "EDP is not just made by the team of OSXLatitude, it's made by a lot of people who have provided their files to EDP after spending hundreds of hours to make some working and help many others.";
			echo "<br><br>";
			echo "<b>Help us out....</b><br>";
			echo "Got something that you made which can help others (or) have any queries regarding EDP? Send an email to <a href='mailto:lsb@osxlatitude.com'>lsb@osxlatitude.com</a> and we will put your files on EDP.";
			echo "</div>";
		break;
		
		case "Changelog":
			echoPageItemTOP("icons/big/activity.png", "Changelog for EDP...");
   			 echo "<div class='pageitem_bottom'>";
    
    		$url = "http://pipes.yahoo.com/pipes/pipe.run?_id=fcf8f5975800dd5f04a86cdcdcef7c4d&_render=rss";
    		$xml = new SimpleXmlElement(file_get_contents($url));

    		foreach ($xml->channel->item as $item) {
    		    echo '<ul class="pageitem"><li class="textbox">';
    		    echo '<span class="header">' . $item->title . '</span>';
  		    	echo '<p>' . trim($item->description) . '</p><br/>';
    		    echo '<p>Commited on: ' . date('l jS \of F Y h:i:s A', strtotime($item->pubDate)) . '</p></li></ul>';
  			  }
   			echo "</div>";
			
		break;
		
		case "Update":
		
			$updLogPath = "$logsPath/update";

			// Clear logs and scripts
			if(is_dir("$updLogPath")) {
				system_call("rm -rf $updLogPath/*");
			}
			
			// create log directory if not found
			if(!is_dir("$logsPath")) {
				system_call("mkdir $logsPath");
			}
			if(!is_dir("$updLogPath")) {
				system_call("mkdir $updLogPath");
			}
			
			// Start installation process by Launching the script which provides the summary of the build process 
			echo "<script> document.location.href = 'workerapp.php?action=showUpdateLog#myfix'; </script>";
		
			echoPageItemTOP("icons/big/update.png", "Update");
			echo "<div class='pageitem_bottom'\">";	
			echo "<center><b>Please wait for few minutes while we download the updates... which will take approx 1 to 10 minutes depending on your internet speed</b></center>";
			echo "<img src=\"icons/big/loading.gif\" style=\"width:200px;height:30px;position:relative;left:50%;top:50%;margin:15px 0 0 -100px;\">";
			
			system_call("echo '*** Logging started on: $date UTC Time ***<br>' >> $updLogPath/update.log");
			system_call("sudo sh $workPath/bin/update.sh >> $updLogPath/update.log &");

			echo "</div>";
			
		break;
		
		case "UpdateDB":
		
			$updLogPath = "$logsPath/update";

			// Clear logs and scripts
			if(is_dir("$updLogPath")) {
				system_call("rm -rf $updLogPath/*");
			}
			
			// create log directory if not found
			if(!is_dir("$logsPath")) {
				system_call("mkdir $logsPath");
			}
			if(!is_dir("$updLogPath")) {
				system_call("mkdir $updLogPath");
			}
			
			// Start installation process by Launching the script which provides the summary of the build process 
			echo "<script> document.location.href = 'workerapp.php?action=showUpdateLog#myfix'; </script>";
		
			echoPageItemTOP("icons/big/update.png", "Update");
			echo "<div class='pageitem_bottom'\">";	
			echo "<center><b>Please wait for few minutes while we download the database... which will take approx 1 to 5 minutes depending on your internet speed</b></center>";
			echo "<img src=\"icons/big/loading.gif\" style=\"width:200px;height:30px;position:relative;left:50%;top:50%;margin:15px 0 0 -100px;\">";
			
			system_call("echo '<br>*** Logging started on: $date UTC Time ***<br>' >> $updLogPath/update.log");
			system_call("sudo sh $workPath/bin/updateDB.sh >> $updLogPath/update.log &");

			echo "</div>";
			
		break;
		
		case "BuildLogs":
			echoPageItemTOP("icons/big/activity.png", "Build Log");
   			echo "<div class='pageitem_bottom'>";
    		
    		if (!file_exists("$logsPath/build.log")) {
    				echo "<img src=\"icons/big/info.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
    				echo "<b><center> There is no log available.</center></b>";
    				echo "</ul>";
    		} 
    		else {
    			echo "<pre>";
				if(is_file("$logsPath/build.log"))
					include "$logsPath/build.log";
				echo "</pre>";
    		}
    					
   			echo "</div>";
			
		break;
		
		case "UpdateLogs":
			echoPageItemTOP("icons/big/activity.png", "Update Log");
   			echo "<div class='pageitem_bottom'>";
    		
    		if (!file_exists("$logsPath/update.log")) {
    				echo "<img src=\"icons/big/info.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
    				echo "<b><center> There is no log available.</center></b>";
    				echo "</ul>";
    		} 
    		else {
    			echo "<pre>";
				if(is_file("$logsPath/update.log"))
					include "$logsPath/update.log";
				echo "</pre>";
    		}
			
   			echo "</div>";
			
		break;
		
		case "LastBuildLog":
			echoPageItemTOP("icons/big/activity.png", "Last Build Log");
   			echo "<div class='pageitem_bottom'>";
    		
    		if (!file_exists("$logsPath/lastbuild.log")) {
    				echo "<img src=\"icons/big/info.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
    				echo "<b><center> There is no log available.</center></b>";
    				echo "</ul>";
    		} 
    		else {
    			echo "<pre>";
				if(is_file("$logsPath/lastbuild.log"))
					include "$logsPath/lastbuild.log";
				echo "</pre>";
    		}
			
   			echo "</div>";
			
		break;
		
		case "LastUpdateLog":
			echoPageItemTOP("icons/big/activity.png", "Last Update Log");
   			echo "<div class='pageitem_bottom'>";
    		
    		if (!file_exists("$logsPath/lastupdate.log")) {
    				echo "<img src=\"icons/big/info.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
    				echo "<b><center> There is no log available.</center></b>";
    				echo "</ul>";
    		} 
    		else {
    			echo "<pre>";
				if(is_file("$logsPath/lastupdate.log"))
					include "$logsPath/lastupdate.log";
				echo "</pre>";
    		}
    		
   			echo "</div>";
			
		break;
		
		case "ClearLogs":
			echoPageItemTOP("icons/big/trash.png", "Clear Logs");
   			echo "<div class='pageitem_bottom'>";
    		
    		$action = $_POST['action'];
    		if ($action == "") {
    			echo "<form action='showPage.php' method='post'>";
			
				echo "<input type='hidden' name='i' value='ClearLogs'>";
				echo "<input type='hidden' name='action' value='removeLogs'>";
			
				echo '<ul class="pageitem">';
				checkbox("Clear Builds Log?", "rmBuildLog", "no");
				checkbox("Clear Last Build Log?", "rmLBuildLog", "no");
				checkbox("Clear Updates Log?", "rmUpdateLog", "no");
				checkbox("Clear Last Update Log?", "rmLUpdateLog", "no");
				echo '</ul>';
				
				echo '<ul class="pageitem">';
				echo '<li class="button"><input name="Submit input" type="submit" value="Clear" /></li>';
				echo '</ul>';
				echo "</form>";
    		}
    		else {
    			
    			$selectedToClear = "no"; 
    			
    			$rmBuildLog = $_POST['rmBuildLog']; 
    			if ($rmBuildLog == "on") { system_call("rm -f $logsPath/build.log");  system_call("rm -rf $logsPath/build/*"); $selectedToClear = "yes"; }
    			
    			$rmLBuildLog = $_POST['rmLBuildLog']; 
    			if ($rmLBuildLog == "on") { system_call("rm -f $logsPath/lastbuild.log"); $selectedToClear = "yes";  }
    			
    			$rmUpdateLog = $_POST['rmUpdateLog']; 
    			if ($rmUpdateLog == "on") { system_call("rm -f $logsPath/update.log"); system_call("rm -rf $logsPath/update/*"); $selectedToClear = "yes"; }
    			
    			$rmLUpdateLog = $_POST['rmLUpdateLog']; 
    			if ($rmLUpdateLog == "on") { system_call("rm -f $logsPath/lastupdate.log"); $selectedToClear = "yes"; }
    			
    			if ($selectedToClear == "yes") {
    				echo "<img src=\"icons/big/success.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
					echo "<b><center> Log(s) Cleared.</center></b>";
    			}
    			else {
    				echo "<img src=\"icons/big/warning.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
    				echo "<b><center> Not selected any logs to clear.</center></b>";
    			}
    			
    		}			
   			echo "</div>";
		
		break;
		
		case "DownloadedApps":
			echoPageItemTOP("icons/big/apps.png", "Downloaded application data by EDP");
   			echo "<div class='pageitem_bottom'>";

   			// Get all the files/folders anme in comma seperated way
			$appslinfo = shell_exec("ls -m $appsPath/");
			$appsArray = explode(',', $appslinfo);
				
   			$action = $_POST['action'];
    		if ($action == "") {
   				echo "<p align=\"justify\"> EDP keeps the downloaded apps during build for subsequent builds, so they will be updated instead of downloading completely. But, if you wish to save some space (or) want to remove the files you don't need can be done here by deleting them.</p>";
   				echo "<p><b>Download folder path: $workPath/apps </p>";
   				
    			echo "<form action='showPage.php' method='post'>";
			
				echo "<input type='hidden' name='i' value='DownloadedApps'>";
				echo "<input type='hidden' name='action' value='removeApps'>";
			
				echo "<ul class='pageitem'>";
				
				$appID = 0;
				foreach($appsArray as $appCategName) {
					
					$appCategName = preg_replace('/\s+/', '',$appCategName); //remove white spaces
					
					if ($appCategName != "" && $appName != ".DS_Store") {
				
						$appinfo = shell_exec("ls -m $appsPath/$appCategName");
						$appNameArray = explode(',', $appinfo);
					
						foreach($appNameArray as $appName) {
						
							$appName = preg_replace('/\s+/', '',$appName); //remove white spaces
							
							if ($appName != "" && $appName != ".DS_Store") 
							{
								checkbox("$appName", $appID, "yes");
								$appID++;
							}
						}						
					}
				}
				
				if ($appID == 0) {
    				echo "<img src=\"icons/big/info.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
    				echo "<b><center> No Application data downloaded by EDP available.</center></b>";
    				echo "</ul>";
    			}
    			else {
    				echo "</ul>";
				
					echo '<ul class="pageitem">';
					echo '<li class="button"><input name="Submit input" type="submit" value="Delete selected Apps" /></li>';
					echo '</ul>';
    			}
				
				echo "</form>";
    		}
    		else {
    		
				$appID = 0;
    			foreach($appsArray as $appCategName) {
				
					$appCategName = preg_replace('/\s+/', '',$appCategName); //remove white spaces

					if ($appCategName != "" && $appName != ".DS_Store") {
				
						$appinfo = shell_exec("ls -m $appsPath/$appCategName");
						$appNameArray = explode(',', $appinfo);
					
						foreach($appNameArray as $appName) {
							
							$appName = preg_replace('/\s+/', '',$appName); //remove white spaces

							if ($appName != "" && $appName != ".DS_Store") 
							{
								if($_POST[$appID] == "on") {
									system_call("rm -rf $appsPath/$appCategName/$appName");	
								}
								$appID++;
							}							
						}						
					}
				}
    			
    			if ($appID > 0) {
    				echo "<img src=\"icons/big/success.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
					echo "<b><center> Application data deleted.</center></b>";
    			}
    			else {
    				echo "<img src=\"icons/big/warning.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
    				echo "<b><center> There is no Application data to delete (Either not selected to delete (or) nothing downloaded).</center></b>";
    			}
    		}			
    		echo "</div>";
		
		break;
		
		case "DownloadedKextPacks":
			echoPageItemTOP("icons/big/kext.png", "Downloaded Kext Packs data by EDP");
   			echo "<div class='pageitem_bottom'>";
   			
   			// Get all the files/folders anme in comma seperated way
			$kplinfo = shell_exec("ls -m $workPath/kextPacks/");
			$kpArray = explode(',', $kplinfo);
				
   			$action = $_POST['action'];
    		if ($action == "") {
   				echo "<p align=\"justify\"> EDP keeps the downloaded kext packs during build for subsequent builds, so they will be updated instead of downloading completely. But, if you wish to save some space (or) want to remove the files you don't need can be done here by deleting them.</p>";
   				echo "<p><b>Download folder path: $workPath/svnpacks </p>";
   				
    			echo "<form action='showPage.php' method='post'>";
			
				echo "<input type='hidden' name='i' value='DownloadedKextPacks'>";
				echo "<input type='hidden' name='action' value='removeKPack'>";
			
				echo "<ul class='pageitem'>";
				
				$kpID = 0;
				foreach($kpArray as $kpName) {
				
					$kpName = preg_replace('/\s+/', '',$kpName); //remove white spaces

					if ($kpName != "" && $kpName != ".DS_Store") {
				
						checkbox("$kpName", $kpID, "yes");
						
						$kpID++;				
					}
				}
		
				if ($kpID == 0) {
    				echo "<img src=\"icons/big/info.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
    				echo "<b><center> No Kext packs data downloaded by EDP available.</center></b>";
    				echo "</ul>";
    			}
    			else {
					echo "</ul>";
				
					echo '<ul class="pageitem">';
					echo '<li class="button"><input name="Submit input" type="submit" value="Delete selected Packs" /></li>';
					echo '</ul>';
				}
				echo "</form>";
    		}
    		else {
    		
    			$kpID = 0;
				foreach($kpArray as $kpName) {
				
					$kpName = preg_replace('/\s+/', '',$kpName); //remove white spaces

					if ($kpName != "" && $kpName != ".DS_Store") {
				
						if($_POST[$kpID] == "on") {
							system_call("rm -rf $workPath/kextPacks/$kpName");	
						}
						
						$kpID++;				
					}
				}				
    			
    			if ($kpID > 0) {
    				echo "<img src=\"icons/big/success.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
					echo "<b><center> Kext pack data deleted.</center></b>";
    			}
    			else {
    				echo "<img src=\"icons/big/warning.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
    				echo "<b><center> There is no Kext pack data to delete (Either not selected to delete (or) nothing downloaded).</center></b>";
    			}    			
    		}			
    		echo "</div>";
		
		break;
		
		case "DownloadedModelData":
			echoPageItemTOP("icons/big/files.png", "Downloaded model data by EDP");
   			echo "<div class='pageitem_bottom'>";

   			// Get all the files/folders anme in comma seperated way
			$vinfo = shell_exec("ls -m $workPath/model-data/");
			$vArray = explode(',', $vinfo);
			
			$mID = 0;
			
   			$action = $_POST['action'];
    		if ($action == "") {
   				echo "<p align=\"justify\"> EDP keeps the downloaded model data during build for subsequent builds, so they will be updated instead of downloading completely. But, if you wish to save some space (or) want to remove the files you don't need can be done here by deleting them.</p>";
   				echo "<p><b>Download folder path: $workPath/model-data </p>";
   				
    			echo "<form action='showPage.php' method='post'>";
			
				echo "<input type='hidden' name='i' value='DownloadedModelData'>";
				echo "<input type='hidden' name='action' value='removeMdata'>";
			
				echo "<ul class='pageitem'>";
				
				foreach($vArray as $vName) // Vendor Name
				{
					$vName = preg_replace('/\s+/', '',$vName); //remove white spaces

					if ($vName != "" && $vName != ".DS_Store") {
				
						$ginfo = shell_exec("ls -m $workPath/model-data/$vName/");
						$gArray = explode(',', $ginfo);
						
						foreach($gArray as $gName) // Generation Name
						{
							$gName = preg_replace('/\s+/', '',$gName); //remove white spaces

							if ($gName != "" && $gName != ".DS_Store") {
				
								$minfo = shell_exec("ls -m $workPath/model-data/$vName/$gName/");
								$mArray = explode(',', $minfo);
						
								foreach($mArray as $mName) // Model Name
								{
									$mName = preg_replace('/\s+/', '',$mName); //remove white spaces

									if ($mName != "" && $mName != ".DS_Store") {
				
										checkbox("$mName", $mID, "yes");
						
										$mID++;				
									}
								}				
							}
						}				
					}
				}
		
				if ($mID == 0) {
    				echo "<img src=\"icons/big/info.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
    				echo "<b><center> No model data downloaded by EDP available.</center></b>";
    				echo "</ul>";
    			}
    			else {
					echo "</ul>";
				
					echo '<ul class="pageitem">';
					echo '<li class="button"><input name="Submit input" type="submit" value="Delete selected model data" /></li>';
					echo '</ul>';
				}
				echo "</form>";
    		}
    		else {
    		
    			foreach($vArray as $vName) // Vendor Name
				{
					$vName = preg_replace('/\s+/', '',$vName); //remove white spaces

					if ($vName != "" && $vName != ".DS_Store") {
				
						$ginfo = shell_exec("ls -m $workPath/model-data/$vName/");
						$gArray = explode(',', $ginfo);
						
						foreach($gArray as $gName) // Generation Name
						{
							$gName = preg_replace('/\s+/', '',$gName); //remove white spaces

							if ($gName != "" && $gName != ".DS_Store") {
				
								$minfo = shell_exec("ls -m $workPath/model-data/$vName/$gName/");
								$mArray = explode(',', $minfo);
						
								foreach($mArray as $mName) // Model Name
								{
									$mName = preg_replace('/\s+/', '',$mName); //remove white spaces

									if ($mName != "" && $mName != ".DS_Store") {
										
										if($_POST[$mID] == "on") {
											system_call("rm -rf $workPath/model-data/$vName/$gName/$mName");
										}
										$mID++;				
									}
								}				
							}
						}				
					}
				}				
    			
    			if ($mID > 0) {
    				echo "<img src=\"icons/big/success.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
					echo "<b><center> Model data deleted.</center></b>";
    			}
    			else {
    				echo "<img src=\"icons/big/warning.png\" style=\"width:80px;height:80px;position:relative;left:50%;top:50%;margin:15px 0 0 -35px;\">";
    				echo "<b><center> There is no model data to delete (Either not selected to delete (or) nothing downloaded).</center></b>";
    			}    			
    		}			
    		echo "</div>";
		
		break;
		
	}

?>
