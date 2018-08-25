<?php

	foreach (glob(__DIR__ . "/multipagesite/*.php") as $filename)
	{
		require_once($filename);
	}
	
?>