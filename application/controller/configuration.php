<?php

# configuration controller
$application->get('configuration.json', function() use($configuration, $application) {

	# @important: remove private values
	unset($configuration['facebook']['secret']);

	# render json data
	return $application->json($configuration);
});
