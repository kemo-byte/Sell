<?php

	function lang($phrase){

		static $lang = array(

			// navbar links
			"Home_Admin" 	=> "Home",
			"CATEGORIES"	=> "Categories",
			"ITEMS"			=> "Items",
			"MEMBERS"		=> "Members",
			"COMMENTS" 		=> "Comments",
			"STATISTICS"	=> "Statistics",
			"LOGS"			=> "Logs",

			// Dropdown Links
			"PROFILE"		=> "Edit Profile",
			"SETTINGS" 		=> "Settings",
			"OUT" 			=> "Logout",
			"balance"		=> "balance"
		);

		return $lang[$phrase];
	}