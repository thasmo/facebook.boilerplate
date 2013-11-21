<?php

# index controller
$application->match('/', function() use($configuration, $application) {

	# set some initial data
	$signedRequest = $application['facebook']->getSignedRequest();
	$userId = $application['facebook']->getUser();
	$templateContext = new stdClass;

	# define general template objects
	$templateContext->title = $configuration['application']['title'];

	# add signed request to template
	if($signedRequest) {
		$templateContext->signedRequest = $signedRequest;
	}

	# load user
	if($userId) {

		# query user data
		$user = $application['facebook']->api('/me');

		# add user to template
		$templateContext->user = $user;
	}

	# detect mobile
	$templateContext->isMobile = $application['mobile_detect']->isMobile();

	# render template
	return $application['twig']->render('index.html', (array)$templateContext);
})->method('GET|POST');
