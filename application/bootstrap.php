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
$application['debug'] = (boolean)$configuration['debug'];

# register template service
$application->register(new Silex\Provider\TwigServiceProvider, array(
	'twig.path'            => __DIR__ . '/../application/template',
	'twig.options'         => array(
		'debug'            => (boolean)$configuration['debug'],
		'strict_variables' => FALSE,
		'cache'            => __DIR__ . '/../application/cache',
	),
));

# register facebook sdk
$application->register(new Tobiassjosten\Silex\Provider\FacebookServiceProvider(), array(
	'facebook.app_id' => $configuration['facebook']['appId'],
	'facebook.secret' => $configuration['facebook']['secret']
));

# before request dispatching
$application->before(function() use($configuration, $application) {

	# get signed request
	$signedRequest = $application['facebook']->getSignedRequest();

});

# after controller execution
$application->after(function($request, $response) use ($configuration, $application) {

});

# after response delivery
$application->finish(function(Request $request, Response $response) use ($configuration, $application) {

});

# configuration controller
$application->get('configuration.json', function() use($configuration, $application) {

	# @important: remove private values
	unset($configuration['facebook']['secret']);
	unset($configuration['tracking']);

	# render json data
	return $application->json($configuration);
});

# index controller
$application->match('/', function() use($configuration, $application) {

	# get signed request
	$signedRequest = $application['facebook']->getSignedRequest();

	# template context
	$context = new stdClass;
	$context->title = $configuration['application']['title'];
	$context->trackingKey = $configuration['tracking']['key'];
	$context->user = $signedRequest['user'];

	# render template
	return $application['twig']->render('index.html', (array)$context);
});

# run application
$application->run();
