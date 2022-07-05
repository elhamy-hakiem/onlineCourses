<?php
ob_start();
session_start();
// Define Directory paths 
define('ROOT',dirname(__FILE__));
define('INCLUDES',ROOT.'/includes');
define('UPLOADS',ROOT.'/uploads');
define('PLUGINS',INCLUDES.'/plugins');

define('ASSETS',ROOT.'/assets');

define('CSS',ASSETS.'/back/css');
define('JS',ASSETS.'/back/js');

require(INCLUDES.'/database/dbConnection.php');
require(INCLUDES.'/database/dbFunctions.php');
require(INCLUDES.'/functions/general.functions.php');


