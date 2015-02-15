<h1>Zipato API : PHP Browser</h1>

<dl>
	<dt>Based on :</dt>
	<dd><a href="https://my.zipato.com/zipato-web/api/">Zipato Web API v2</a></dd>

	<dt>Author : </dt>
	<dd><a href="https://github.com/Nikya">Nikya</a></dd>

	<dt>Sources : </dt>
	<dd><a href="https://github.com/Nikya/zipatoAPI_phpBrowser">GitHub</a></dd>
</dl>

<h2>Examples :</h2>
<ol>
	<li><a href="index.php?ex=login">Login</a></li>
	<li><a href="index.php?ex=list">List</a></li>
	<li><a href="index.php?ex=read">Read</a></li>
	<li><a href="index.php?ex=switch">Switch</a></li>
</ol>
<hr/>

<?php
	// Common \\

	// Display errors
	ini_set('display_errors',1);
	error_reporting(E_ALL);

	// Load parameters : IP, login, passwords
	$config = parse_ini_file('config.ini', true);

	// Load an example
	if (isset($_GET['ex']))
		require('example/'.$_GET['ex'].'.php');
?>
