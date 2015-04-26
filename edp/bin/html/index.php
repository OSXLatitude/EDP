<?php

$i = (isset($_GET['i'])) ? $_GET['i'] : "";

include "header.inc.php";

global $edpmode;
$edpmode = "web";
            
?>
	<script type="text/javascript"></script>
    <body onload="bootloader();" onresize="aligndesign();" background="images/console_bg.png">
    	

	<table border="0" width="100%" cellpadding="0" style="border-collapse: collapse" background="images/topmenu-bg.png" height="69">
            <tr style="vertical-align: bottom;"  class="topbarmenu" align="center" style='cursor: hand'>
            	<td width="80" onclick="loader('EDP')"><img src="icons/big/edp.png" width="38"></td>
                            	
                <td width="80" onclick="loader('Configuration')"><img src="icons/big/config.png" width="40"></td>

				<td width="80" onclick="loader('Applications')"><img src="icons/big/apps.png" width="40"></td>
                <td width="80" onclick="loader('Tools')"><img src="icons/big/tools.png" width="40"></td>
                <td width="80" onclick="loader('Fixes')"><img src="icons/big/terminal.png" width="40"></td>
                <td width="80" onclick="loader('Kexts')"><img src="icons/big/kext.png" width="40"></td>

                <td>&nbsp;</td>
                <td width="80"><a href="http://www.osxlatitude.com/edp/documentation/" target="_blank"><img src="icons/big/guide.png" width="40"></a></td>
            	<td width="80"><a href="http://forum.osxlatitude.com/index.php?/forum/6-feedback/" target="_blank"><img src="icons/big/feedback.png" width="40"></a></td>
                <td width="80"><a href="http://forum.osxlatitude.com/index.php?/forum/9-issues-and-bugs/" target="_blank"><img src="icons/big/issues.png" width="40"></a></td>
                <td width="80" onclick="loader('Credits');"><img src="icons/big/credits.png" width="40"></td>    
                <td width="80"><a href='<?= "$donateurl"; ?>' target='_blank'><img src="icons/big/paypal.png" width="40"></a></td>
            </tr>
            <tr class="topbarmenu" align="center" style='cursor: hand'>
            	<td>EDP</td>      	
                <td>Config</td>
                <td>Applications</td>
                <td>Tools</td> 
                <td>Fixes</td>
                <td>Kexts</td>
                <td>&nbsp;</td>
                <td>EDP Guide</td>
                <td>Feedback</td>
                <td>Issues</td>
                <td>Credits</td>
                <td>Donate</td>
            </tr>
        </table>

		<iframe id="edpmenu" 		name="edpmenu" 			class="edpmenu" 	   marginwidth="0" marginheight="0" border="0" frameborder="0" height="80%" src="menu.inc.php?i=<?= "$i"; ?>"></iframe>

        <iframe id="console_iframe" name="console_iframe" 	class="console_iframe" marginwidth="0" marginheight="0" border="0" frameborder="0" src="showPage.php?i=EDP"></iframe>

    </body>
</html>
