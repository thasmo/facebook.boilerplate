<?php

# channel file controller
$application->get('channel.html', function() use($configuration, $application) {
	return '<script src="//connect.facebook.net/en_US/all.js"></script>';
});
