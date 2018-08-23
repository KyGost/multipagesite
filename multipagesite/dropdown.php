<?php
	require_once("unclickable.php");

	class dropdownPage extends unclickablePage
	{
		var $items;
		public function __construct($name, $items, $side = false)
		{
			parent::__construct($name, $side);
			$this->items = $items;
		}
	}
?>