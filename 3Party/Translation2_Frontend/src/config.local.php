<?php
define('INTRAFACE_PATH_INCLUDE', '.' . PATH_SEPARATOR . dirname(__FILE__) . '/../../' . PATH_SEPARATOR . get_include_path());
define('DB_NAME', 'intraface');
define('DB_HOST', 'localhost');
define('DB_PASS', 'klani');
define('DB_USER', 'root');
define('ERROR_LOG', dirname(__FILE__) . '/../../log/error.log'); // exact directory and filename
define('ERROR_LOG_UNIQUE', dirname(__FILE__) . '/../../log/error-unique.log'); // exact directory and filename
