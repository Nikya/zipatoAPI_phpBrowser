<h3>Test Switch</h1>

<form action="index.php" >
	<input type="hidden" value="switch" name="ex"/>

	<input type="text" name="uuid" id="uuid" required="required"/>
	<p style="font-size:0.8em">Put an <b>uuid</b> of a On/off attribut. Use <i>list</i> page to obtain one.</p>

	<input type="submit" value="On" name="switch"/>
	<input type="submit" value="Off" name="switch"/>
</form>
<hr/>

<?php
	require_once('implementation/ExampleServices.php');

	// If switch is asked
	if (isset($_GET['switch']) and !empty($_GET['switch']) and isset($_GET['uuid']) and !empty($_GET['uuid'])) {
		// Get forms params
		$uuid = $_GET['uuid'];
		$switch = $_GET['switch'];

		// Login informations are loaded, from config.ini file, in index.php into $config var
		// Init a Zipato Services
		$exampleServices = new ExampleServices($config['username'], $config['password']);

		if (strcasecmp('ON', $switch) == 0)
			$rData = $exampleServices->switchTo($uuid, true);
		else
			$rData = $exampleServices->switchTo($uuid, false);

		// Display result
		echo "<h4>Switch $switch for $uuid</h4>";
		$rDataPrinted = print_r($rData);
		echo "<pre>$rDataPrinted</pre>";

		// Logout and free resources
		$exampleServices->finish();
	}
	?>
