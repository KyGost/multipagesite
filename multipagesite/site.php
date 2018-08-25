<?php
	class site
	{
		// Site config
		public $preURL = "?page=";
		public $moreBody = "";
		public $moreHead = "";
		//// URL of home
		public $homePage = "";
		public $page404 = "";
		//// Server location of CSS file
		public $CSS = __DIR__ . "/default.css"; 

		private $pages;
		private $currentPage;
		private $footer;

		private $dropdownCSS = "";

		public function __construct($pages, $footer = "")
		{
			$this->pages = $pages;
			$this->footer = $footer;

			foreach ($pages as $page)
			{
				if ($page instanceOf clickablePage && $page->URL == $_GET['page'])
				{
					$this->currentPage = $page;
					break;
				}
				elseif ($page instanceOf dropdownPage)
				{
					foreach ($page->items as $item)
					{
						if ($item instanceOf clickablePage && $item->URL == $_GET['page'])
						{
							$this->currentPage = $item;
							break;
						}
					}
				}
			}

			if (!is_null($this->currentPage->do))
			{
				$do = $this->currentPage->do;
				$this->moreBody .= $do();
			}
		}

		public function showSite()
		{
			$this->handleErrors();
			echo $this->pageGenerate();
		}

		private function pageGenerate()
		{
				$footer = !empty($this->footer) ? $this->footerGenerate() : "";
				$body = encapsulate("BODY", $this->navbarGenerate($this->pages) . $this->currentPage->HTML . $this->moreBody . $footer);
					$title = encapsulate("TITLE", $this->currentPage->name);
					$style = encapsulate("STYLE", file_get_contents($this->CSS));
				$head = encapsulate("HEAD", $title . $style . $this->dropdownCSS . $this->moreHead);
			$page = encapsulate("HTML", $head . $body);
			return $page;
		}

		private function footerGenerate()
		{
			return encapsulate("DIV", $this->footer, array("id" => "footer"));
		}

		private function navbarGenerate($pages, $fullNavbar = true)
		{
			$navbar = "";
			foreach ($pages as $page)
			{
				$navbarPortion = "";
				$classes = array();

				if ($page->side)
				{
					array_push($classes, "side");
				}
				
				if ($page instanceOf unlistedPage) continue;
				if ($page instanceOf dropdownPage)
				{
					array_push($classes, $page->name);

					$this->addDropdownCSS($page->name);

					$navbarPortion = encapsulate(
						"DIV",
						$this->navbarInnerPortion($page, $classes) .
						encapsulate(
							"DIV",
							$this->navbarGenerate($page->items, false),
							array("class" => $page->name . "dropdown")
						),
						array("class" => $page->name)
					);
				}
				elseif ($page instanceOf unclickablePage)
				{
					array_push($classes, "unclickable");
					$navbarPortion = $this->navbarInnerPortion($page, $classes);
				}

				if ($page instanceOf clickablePage)
				{
					if ($page->name == $this->currentPage->name) array_push($classes, "active");
					$navbarPortion = encapsulate("A", $this->navbarInnerPortion($page, $classes), array("href" => $this->preURL . $page->URL));
				}
				$navbar .= $navbarPortion;
			}
			return $fullNavbar ? encapsulate("DIV", encapsulate("UL", $navbar, array("id" => "navbar"))) : $navbar;
		}

		private function navbarInnerPortion($page, $classes, $attributes = array())
		{
			$classlist = "";
				foreach ($classes as $class)
				{
					$classlist .= $class . " ";
				}
			$attributes["class"] = $classlist;
			return encapsulate("LI", $page->name, $attributes);
		}

		private function addDropdownCSS($name)
		{
			$this->dropdownCSS .= encapsulate(
				"STYLE",
				"." . $name . "dropdown
				{
					display: none;
					position: absolute;
					box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
					z-index: 1;
					list-style: none;
					overflow: hidden;
					margin: 0;
					padding: 0;
					background: #333333;
				}
				." . $name . "dropdown li
				{
					display: block;
					padding: 14px 16px;
					width: 100%;
					height: 20px !important;
				}
				." . $name . "dropdown li:not(.side)
				{
					float:left;
				}
				." . $name . ":hover ." . $name . "dropdown
				{
					display: inline-block;
				}"
			);
		}

		private function handleErrors()
		{
			if (empty($_GET['page']))
			{
				if (!empty($this->homePage)) header("Location: " . $this->preURL . $this->homePage);
				elseif (!empty($this->page404)) header("Location: " . $this->preURL . $this->page404);
				else die(http_response_code(404));
			}
			if (!($this->currentPage instanceOf clickablePage))
			{
				if (!empty($this->page404)) header("Location: " . $this->preURL . $this->page404);
				else die(http_response_code(404));
			}
		}


		public function moreCSS($CSS)
		{
			$this->$moreHead .= incapsulate("STYLE", $CSS);
		}
	}
?>