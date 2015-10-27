<?php
/**
 * The development database settings. These get merged with the global settings.
 */

return array(
	'default' => array(
		'connection'  => array(
			'dsn'        => 'mysql:host=host.db;dbname=todo',
			'username'   => 'dbmaster',
			'password'   => 'tbontb22',
		),
		'profiling' => true,
	),
);
