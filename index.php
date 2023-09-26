<?php
// Start a new or resume an existing session.
session_start();

// Include the router.php file, which likely contains code for routing requests.
include 'router/router.php';

// Define a constant named 'SITE_ROOT' that holds the absolute path to the current file's directory.
define ('SITE_ROOT', realpath(dirname(__FILE__)));
