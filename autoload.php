<?php

/* The autoloader */
function zipatoAPI_phpBrowser_autoload($className) {
	$dirname = dirname(__FILE__);

	$corePath = "$dirname/core/$className.php";
	$implPath = "$dirname/implementation/$className.php";

	if (file_exists($corePath)) {
		require_once($corePath);

	} else if (file_exists($implPath)) {
		require_once($implPath);
	}
}

spl_autoload_register('zipatoAPI_phpBrowser_autoload');
