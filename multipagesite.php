<?php

	$libDirectory = "/var/www/libs/multipagesite/";
	
	foreach (glob($libDirectory . "*.php") as $filename)
	{
		require_once($filename);
	}
	
?>