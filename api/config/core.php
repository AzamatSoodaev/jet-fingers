<?php

require_once __DIR__.'/database.php';

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'jet_fingers');

$db = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);