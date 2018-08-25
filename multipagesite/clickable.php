<?php
	require_once("page.php");

	class clickablePage extends page
	{
		var $URL;
		var $do;
		var $HTML;

		public function __construct($name, $URL, $HTML = "", $do = null, $side = false)
		{
			parent::__construct($name, $side);
			$this->URL = $URL;
			$this->HTML = $HTML;
			$this->do = $do;
		}
	}
?>