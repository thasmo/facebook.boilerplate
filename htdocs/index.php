<?php

# define the application context
define('CONTEXT', 'development');

# run the application
$application = require('../application/bootstrap.php');
$application->run();
