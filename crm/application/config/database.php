<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;
// $hostname ='localhost';
// $username ='sunilcha_crm';
// $password ='olCyMDiv(RPI';
// $database ='sunilcha_crm';	

$hostname ='localhost';
$username ='USER_DATABASE_NAME';
$password ='USER_DATABASE_PWSS';
$database ='DATABASE_NAME';	

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => $hostname,
	'username' => $username,
	'password' => $password,
	'database' => $database,
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
