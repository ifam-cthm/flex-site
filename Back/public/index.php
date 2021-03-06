<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

//require __DIR__ . '/../src/utils/mail/email.php';


//register emIL
require __DIR__ . '/../src/utils/mail/email.php';
// Register cors
require __DIR__ . '/../src/cors.php';
require __DIR__ . '/../src/models/Usuario/routes.php';
require __DIR__ . '/../src/models/Setor/routes.php';
require __DIR__ . '/../src/models/Documentos/routes.php';
require __DIR__ . '/../src/models/Tipos/routes.php';
require __DIR__ . '/../src/models/Ativos/routes.php';

// Run app
$app->run();
