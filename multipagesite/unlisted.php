<?php
	require_once("clickable.php");

	class unlistedPage extends clickablePage
	{
		public function __construct($name, $URL, $HTML = "", $do = null)
		{
			parent::__construct($name, $URL, $HTML, $do, false);
		}
	}
?>