<h3>Test Login</h1>

<?php
	// Login informations are loaded, from config.ini file, in index.php into $config var
	// Display login informations
	$configPrinted = print_r($config, true);
	echo "<h4>Config parameters</h4>";
	echo "<pre>$configPrinted</pre>";

	// Create a browser
	require_once('core/ZipatoBrowser.php');
	$zipatoBrowser = new ZipatoBrowser();

	// Login to Zipato Api
	$rData = $zipatoBrowser->login($config['username'], $config['password']);

	// Display Login result
	$rDataPrinted = print_r($rData, true);
	echo "<h4>Login result</h4>";

	if ($rData->success==1)
		echo '<p style="color:green; font-wright:bold">OK</p>';
	else
		echo '<p style="color:red">KO</p>';

	echo "<pre>$rDataPrinted</pre>";

	// Logout and free resources
	$zipatoBrowser->finish();
