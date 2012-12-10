<?php
/*
 * Database Configuration
 */

// Name of the database connection used throughout Splinter
define('SPLINTER_DB', 'splinter_sqlite');

// Connection parameters
 $connection = array(
	'driver'   => 'sqlite',
	'database' => 'splinter',
	'prefix'   => '',
);

////////////////////////////////////
// Shouldn't need to edit this stuff

$connections = Config::get('database.connections');

$connections[SPLINTER_DB] = $connection;

Config::set('database.connections', $connections);
