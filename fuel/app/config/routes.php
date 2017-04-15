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
	'property/add' => 'property/add',
	'property/view/(:num)' => array('property/view/$1', 'name' => 'view_property'),
	'account/edit' => 'user/edit',
	'rent-request/(:num)' => array('rental/rent_request/$1', 'name' => 'rent_request'),
	'user/(:num)' => array('user/view/$1', 'name' => 'view_user'),
	'rental/add' => 'rental/add',
	'search' => 'pages/search'
);
