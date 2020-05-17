<?php

define("ROOT", __DIR__."/..");

define("CONTROLLER_PATH", ROOT. "/controllers/");
define("MODEL_PATH", ROOT. "/models/");
define("VIEW_PATH", ROOT. "/views/");
define("LIB_PATH", ROOT. "/lib/");

if (!session_id()) {
    ini_set('session.use_only_cookies', 'Off');
    ini_set('session.use_cookies', 'On');
    ini_set('session.use_trans_sid', 'Off');
    ini_set('session.cookie_httponly', 'On');

    if (isset($_COOKIE[session_name()]) && !preg_match('/^[a-zA-Z0-9,\-]{22,52}$/', $_COOKIE[session_name()])) {
        exit('Error: Invalid session ID!');
    }

    session_set_cookie_params(0, '/');
    session_start();
}

require_once("../lib/db.php");
require_once("../route.php");
require_once MODEL_PATH. 'Model.php';
require_once VIEW_PATH. 'View.php';
require_once CONTROLLER_PATH. 'Controller.php';
//require_once LIB_PATH. 'User.php';
require_once LIB_PATH. 'pagination.php';
require_once LIB_PATH. 'function.php';


Routing::buildRoute();