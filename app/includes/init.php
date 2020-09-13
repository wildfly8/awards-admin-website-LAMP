<?php

session_set_cookie_params(null, COOKIE_PATH);
session_start();

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

require_once(__DIR__ . '/../core/App.php');
require_once(__DIR__ . '/../core/Middleware.php');
require_once(__DIR__ . '/../core/Controller.php');
require_once(__DIR__ . '/../core/Model.php');
require_once(__DIR__ . '/../core/View.php');
require_once(__DIR__ . '/../core/Database.php');
require_once(__DIR__ . '/../core/Language.php');
