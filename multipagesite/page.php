<?php
	class page
	{
		var $name;
		var $side;

		public function __construct($name, $side = false)
		{
			$this->name = $name;
			$this->side = $side;
		}
	}
?>