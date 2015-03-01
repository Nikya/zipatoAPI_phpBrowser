<h3>Test Listing</h1>

<h4>Zipato partial hierarchy reminder</h4>
<pre>
	[devices](1)----(n)[endpoints](1)----(n)[attributes]
	                                L----(n)[config]

	One <i>devices</i> contain many
		<i>endpoints</i> who contain many
			<i>attributes</i>
			and <i>config</i>
</pre>

<form action="index.php" >
	<input type="hidden" value="list" name="ex"/>

	<label for"uuid">UUID</label>
	<input type="text" name="uuid" id="uuid"/>
	<p style="font-size:0.8em">Put an <b>uuid</b> to get only sub-elements</p>
	<br/>
	<p style="font-size:0.8em">List all devices or a device detail if uuid is set</p>
	<input type="submit" value="1- Device" name="ListChoice"/>

	<p style="font-size:0.8em">List all endpoints or an endpoint detail if uuid is set</p>
	<input type="submit" value="2- Endpoint" name="ListChoice"/>

	<p style="font-size:0.8em">List all attributs or an attribut detail if uuid is set</p>
	<input type="submit" value="3- Attribut" name="ListChoice"/>
</form>
<hr/>

<?php
	// If a listing action is made
	if (isset($_GET['ListChoice']) and !empty($_GET['ListChoice']) ) {
		// Get the list choice ID
		$listeChoice = $_GET['ListChoice'];
		$listeChoiceId = substr($listeChoice, 0, 1);

		// Get the UUID
		$uuid = $_GET['uuid'];

		// Login informations are loaded, from config.ini file, in index.php into $config var
		// Init a Zipato Services
		$exampleServices = new ExampleServices($config['username'], $config['password']);

		switch ($listeChoiceId) {
			case '1' : // Devices
				$rData = $exampleServices->autogetDevices($uuid);
				break;
			case '2' : // Endpoints
				$rData = $exampleServices->autogetEndpoints($uuid);
				break;
			case '3' : // Attributs
				$rData = $exampleServices->autogetAttributes($uuid);
				break;
			default :
				$rData ="Unknow listing action $listeChoice";
				break;
		}

		// Display Listing result
		$rDataPrinted = print_r($rData, true);
		echo "<h4>Listing result for $listeChoice $uuid</h4><pre>$rDataPrinted</pre>";

		// Logout and free resources
		$exampleServices->finish();

	} else {
		echo "<p>Make a listing choice</p>";
	}
?>
