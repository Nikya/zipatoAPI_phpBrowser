<h3>Test reading Meteo</h1>

<form action="index.php" >
	<input type="hidden" value="meteo" name="ex"/>

	<input type="submit" value="List" name="list"/>
	<p style="font-size:0.8em">Get the list of all virtual Meteo device.</p>
	<br/>

	<label for"uuid">UUID</label>
	<input type="text" name="uuid" id="uuid" />
	<p style="font-size:0.8em">Put an <b>uuid</b> of a virtual Meteo device.</p>

	<input type="submit" value="Read" name="read"/>
</form>
<hr/>

<?php
	// If listing is asked
	if (isset($_GET['list']) and !empty($_GET['list'])) {
		// Login informations are loaded, from config.ini file, in index.php into $config var
		// Init a Zipato Services
		$meteoServices = new MeteoServices($config['username'], $config['password']);

		$rData = $meteoServices->listMeteo();
		$fData = print_r($rData, true);

		// Display result
		echo "<h4>List of available Meteo</h4>";
		echo "<pre>$fData</pre>";

		// Logout and free resources
		$meteoServices->finish();
	}

	// If read is asked
	if (isset($_GET['read']) and !empty($_GET['read']) and isset($_GET['uuid']) and !empty($_GET['uuid'])  ) {
		// Get forms params
		$uuid = $_GET['uuid'];

		// Login informations are loaded, from config.ini file, in index.php into $config var
		// Init a Zipato Services
		$meteoServices = new MeteoServices($config['username'], $config['password']);

		$rData = $meteoServices->setUuid($uuid);
		$rData = $meteoServices->fullRead();
		$fData = print_r($rData, true);

		// Display result
		echo "<h4>Read the Meteo $uuid</h4>";
		echo "<pre>$fData</pre>";

		// Logout and free resources
		$meteoServices->finish();
	}
?>
