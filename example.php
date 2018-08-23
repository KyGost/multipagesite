<?php

	require("/var/www/libs/multipagesite.php");

	$menudd = array
	(
		new clickablePage
		(
			"Test", 
			"test",
			"<h1> This is Test </h1>",
			function ()
			{
				echo "test!";
			}
		),
		new clickablePage
		(
			"Test2", 
			"test2", 
			"<h1> This is Test 2 </h1>",
			function ()
			{
				echo "test!";
			}
		),
		new unclickablePage
		(
			"Test3" 
		),
		// TODO: dropdowns within dropdowns
		new dropdownPage
		(
			"Menu",
			array()
		)
	);

	function testFunc()
	{
		echo "test";
	}
	
	$pages = array
	(
		new clickablePage
		(
			"Home", 
			"home", 
			"<h1> This is HOME </h1>",
			"testFunc"
		),
		new clickablePage
		(
			"Place 1 &amp;", 
			"place1", 
			"<h1> | | </h1>"
		),
		new unclickablePage
		(
			"Nope!"
		),
		new unclickablePage
		(
			"Nope!2",
			true
		),
		new dropdownPage
		(
			"Menu",
			$menudd
		),
	);

	// Method 1
	//(new site($pages))->showSite();
	// Method 2
	/* $site = new site($pages);
	$site->showSite(); */

	$site = new site($pages, "Made by Ky");
	// You should set the home page else going to / will result in a 404 error
	$site->homePage = "home";
	// You should set a 404page, this should go to either home or a 404 document
	$site->page404 = $site->homePage;
	// You need to do this in order to actually display the site you have set up
	$site->showSite();
?>