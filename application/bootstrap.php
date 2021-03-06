<?php

if(!defined('CONTEXT')) exit;

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

# load application configuration
$configuration = parse_ini_file('configuration/' . CONTEXT . '.php', TRUE);

# configure error handling
if($configuration['debug']) {
	ini_set('display_errors', 'On');
	error_reporting(E_ALL ^ E_NOTICE);
} else {
	ini_set('display_errors', 'Off');
	error_reporting(0);
}

# configure timezone
date_default_timezone_set($configuration['timezone']);

# load application
$application = new Silex\Application();
$application['debug'] = (boolean)$configuration['debug'];

# register template service
$application->register(new Silex\Provider\TwigServiceProvider, array(
	'twig.path'            => __DIR__ . '/template',
	'twig.options'         => array(
		'debug'            => (boolean)$configuration['debug'],
		'strict_variables' => FALSE,
		'cache'            => __DIR__ . '/../cache'
	)
));

# register facebook sdk
$application->register(new Tobiassjosten\Silex\Provider\FacebookServiceProvider, array(
	'facebook.app_id' => $configuration['facebook']['appId'],
	'facebook.secret' => $configuration['facebook']['secret']
));

# register mobile detect service
$application->register(new Binfo\Silex\MobileDetectServiceProvider);

# load controllers
foreach(glob(__DIR__ . '/controller/*.php') as $path) {
	include($path);
}

# return application
return $application;
