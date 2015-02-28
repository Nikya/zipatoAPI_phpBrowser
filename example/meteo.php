<h3>Test reading Meteo</h1>

<form action="index.php" >
	<input type="hidden" value="meteo" name="ex"/>

	<label for"uuid">UUID</label>
	<input type="text" name="uuid" id="uuid" required="required" />
	<p style="font-size:0.8em">Put an <b>uuid</b> of a virtual Meteo device.</p>

	<input type="submit" value="Read" name="read"/>
</form>
<hr/>

<?php
	require_once('implementation/MeteoServices.php');

	// If read is asked
	if (isset($_GET['read']) and !empty($_GET['read']) and isset($_GET['uuid']) and !empty($_GET['uuid'])  ) {
		// Get forms params
		$uuid = $_GET['uuid'];

		// Login informations are loaded, from config.ini file, in index.php into $config var
		// Init a Zipato Services
		$meteoServices = new MeteoServices($config['username'], $config['password'], $uuid);

		$rData = $meteoServices->fullRead();
		$fData = print_r($rData, true);

		// Display result
		echo "<h4>Read the Meteo $uuid</h4>";
		echo "<pre>$fData</pre>";

		// Logout and free resources
		$meteoServices->finish();
	}
?>
