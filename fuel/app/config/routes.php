<?php
return array(
	'_root_'  => 'pages/index',  // The default route
	'_404_'   => 'pages/404',    // The main 404 route
	'page/(:any)' => array('pages/page/$1', 'name' => 'page_any'),
	'login' => 'user/login',
	'register' => 'user/register',
	'logout' => 'user/logout',
	'account' => 'user/account',
	'properties' => 'property/properties',
	'rentals' => 'rental/rentals',
	'property/add' => 'property/add'
);
