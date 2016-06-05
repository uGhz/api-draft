<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

// Ajout d'un chargeur pour les classes "biusante/api".
function loadClass($className) {
	$fileName = '';
	$namespace = '';

	// Sets the include path as the "src" directory
	$includePath = __DIR__ . DIRECTORY_SEPARATOR . join(DIRECTORY_SEPARATOR, array("..", "src", "classes"));;

	if (false !== ($lastNsPos = strripos($className, '\\'))) {
		$namespace = substr($className, 0, $lastNsPos);
		$className = substr($className, $lastNsPos + 1);
		$fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
	}
	$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
	$fullFileName = $includePath . DIRECTORY_SEPARATOR . $fileName;

	if (file_exists($fullFileName)) {
		require $fullFileName;
	} else {
		echo 'Class "'.$className.'" does not exist.';
	}
}
spl_autoload_register('loadClass'); // Registers the autoloader
// Fin de l'ajout du chargeur de classes.


session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();
