<?php
	include_once "../edpconfig.inc.php";
?>

function bootloader() {
	aligndesign();
}
            
function getHeight() {
		if (document.body && document.body.offsetWidth) {
        	h = document.body.offsetHeight;
        }
        if (document.compatMode == 'CSS1Compat' && document.documentElement && document.documentElement.offsetWidth) {
        	h = document.documentElement.offsetHeight;
        }
        if (window.innerWidth && window.innerHeight) {
            h = window.innerHeight;
        }
        return h;
}            

function getWidth() {
		if (document.body && document.body.offsetWidth) {
    		w = document.body.offsetWidth;
        }
        if (document.compatMode == 'CSS1Compat' && document.documentElement && document.documentElement.offsetWidth) {
        	w = document.documentElement.offsetWidth;
        }
        if (window.innerWidth && window.innerHeight) {
        	w = window.innerWidth;
        }
        
        return w;
}

function aligndesign() {
		var h = getHeight();
		var w = getWidth();

        //Calculate and correction of the console_iframe
        var console_iframe_width = w - 266;
        var console_iframe_height = h - 69;
        document.getElementById('console_iframe').style.width = console_iframe_width + 'px';
        document.getElementById('console_iframe').style.height = console_iframe_height + 'px';

        //Calculate and correction of menu dev
        var edpmenu_div_height = h - 68;
        document.getElementById('edpmenu').style.height = edpmenu_div_height + 'px';
        
        //Recalculate the wait layer
        document.getElementById('wait').style.width = w + 'px';
        document.getElementById('wait').style.height = h + 'px';        
}

function load(page) {
	document.location.href = page;
}

function loadModule(page) {
	top.document.getElementById('console_iframe').src = page;
}

function loadPageInConsole(page) {
	top.document.getElementById('console_iframe').src = page;
}

function waitToggle() {
	var obj = top.document.getElementById('wait');
	if (obj.style.display == 'none') { obj.style.display = 'block'; return; }
	if (obj.style.display == 'block') { obj.style.display = 'none'; return; }
}
function loader(action) {
	var sidebar = top.document.getElementById('edpmenu');
	var console = top.document.getElementById('console_iframe');
	if (action == "EDP") 			{ sidebar.src = 'menu.inc.php?i=EDP'; 			console.src = 'showPage.php?i=EDP'; }	
	if (action == "Configuration") 	{ sidebar.src = 'menu.inc.php?i=Configuration'; console.src = 'showPage.php?i=Configuration'; }
	if (action == "Applications") 	{ sidebar.src = 'menu.inc.php?i=Applications'; 	console.src = 'showPage.php?i=Applications'; }
	if (action == "Tools") 			{ sidebar.src = 'menu.inc.php?i=Tools'; 		console.src = 'showPage.php?i=Tools'; }
	if (action == "Fixes") 			{ sidebar.src = 'menu.inc.php?i=Fixes'; 		console.src = 'showPage.php?i=Fixes'; }
	if (action == "Kexts") 			{ sidebar.src = 'menu.inc.php?i=Kexts'; 		console.src = 'showPage.php?i=Kexts'; }
	if (action == "Credits") 		{ sidebar.src = 'menu.inc.php?i=Credits'; 		console.src = 'showPage.php?i=Credits'; }
}



var iWebkit;if(!iWebkit){iWebkit=window.onload=function(){function fullscreen(){var a=document.getElementsByTagName("a");for(var i=0;i<a.length;i++){if(a[i].className.match("noeffect")){}else{a[i].onclick=function(){window.location=this.getAttribute("href");return false}}}}function hideURLbar(){window.scrollTo(0,0.9)}iWebkit.init=function(){fullscreen();hideURLbar()};iWebkit.init()}}


            