<h3>Test reading</h1>

<form action="index.php" >
	<input type="hidden" value="read" name="ex"/>

	<label for"uuid">UUID</label>
	<input type="text" name="uuid" id="uuid" required="required"/>
	<p style="font-size:0.8em">Put an <b>uuid</b> of a TEMPERATURE attribut. Use <i>list</i> page to obtain one.</p>

	<input type="submit" value="Read" name="read"/>
</form>
<hr/>

<?php
	require_once('implementation/ExampleServices.php');

	// If read is asked
	if (isset($_GET['read']) and !empty($_GET['read']) and isset($_GET['uuid']) and !empty($_GET['uuid'])  ) {
		// Get forms params
		$uuid = $_GET['uuid'];

		// Login informations are loaded, from config.ini file, in index.php into $config var
		// Init a Zipato Services
		$exampleServices = new ExampleServices($config['username'], $config['password']);

		$rData = $exampleServices->getAttributeValue($uuid);
		$value = $rData->value;
		$timestamp = $rData->timestamp;

		// Display result
		echo "<h4>Read a temperature from $uuid</h4>";
		echo "<p>The temperature is $value &deg. </p>";
		echo "<p>It was measured for the last time $timestamp</p>";

		// Logout and free resources
		$exampleServices->finish();
	}
?>
