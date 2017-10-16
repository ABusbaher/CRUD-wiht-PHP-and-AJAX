<?php

$GLOBALS['config'] = array(
	'DB' => array(
		'host' => '127.0.0.1',
		'user' => 'root',
		'password' => '',
		'db_name' => 'komitent_baza',
        'db_charset' => 'UTF-8'
	)
    //,
	//'session' => array()
);
define ('SITE_ROOT', realpath(dirname(__FILE__)));
spl_autoload_register(function($className){
	require_once "classes/{$className}.class.php";
});