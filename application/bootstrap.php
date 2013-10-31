<?php

if(!defined('CONTEXT')) exit;

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

# load application configuration
$configuration = parse_ini_file(__DIR__ . '/../application/configuration/' . CONTEXT . '.php', TRUE);

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
$application['debug'] = TRUE;

# register template service
$application->register(new Silex\Provider\TwigServiceProvider, array(
	'twig.path'            => __DIR__ . '/../application/template',
	'twig.options'         => array(
		'debug'            => TRUE,
		'auto_reload'      => TRUE,
		'strict_variables' => TRUE,
		'cache'            => __DIR__ . '/../application/cache',
	),
));

# before request dispatching
$application->before(function ($request) use ($configuration, $application) {

});

# configuration controller
$application->get('configuration.json', function() use ($configuration, $application) {

	# @important: remove secret token
	unset($configuration['facebook']['secret']);

	# render json data
	return $application->json($configuration);
});

# index controller
$application->get('/', function() use ($configuration, $application) {

	# template context
	$context = new stdClass;

	# set application title
	$context->title = $configuration['application']['title'];

	# set tracking key
	$context->trackingKey = $configuration['tracking']['key'];

	# your code goes here

	# render template
	return $application['twig']->render('index.html', (array)$context);
});

# after controller execution
$application->after(function($request, $response) use ($configuration, $application) {

});

# after response delivery
$application->finish(function($request, $response) use ($configuration, $application) {

});

# run application
$application->run();
