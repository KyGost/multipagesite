<?php
	
	function encapsulate($tag, $content = "", $attributes = array())
	{
		$innerAttributes = "";
		foreach ($attributes as $attribute => $value)
		{
			$innerAttributes .= " " . $attribute . "='" . $value . "'";
		}
		$HTML = "";
		$HTML .= "<" . $tag . $innerAttributes . ">";
		$HTML .= $content;
		$HTML .= "</" . $tag . ">";
		return $HTML;
	}
?>