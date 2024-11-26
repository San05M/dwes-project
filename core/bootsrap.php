<?php

namespace dwes\core;

use dwes\core\Request;
use dwes\core\Router;
use dwes\core\App;
use dwes\app\utils\MyLog;
use dwes\app\exceptions\NotFoundException;

require __DIR__ . '/../vendor/autoload.php';

/**
 * Archivo principal para inicializar la aplicación.
 * 
 * Configura las dependencias principales, carga las rutas, gestiona la sesión, 
 * y prepara los servicios esenciales para que la aplicación funcione correctamente.
 */

// Carga la configuración de la aplicación
$config = require_once __DIR__ . '/../app/config.php';

/**
 * Inicia la sesión del usuario.
 * 
 * Utiliza `session_start()` para habilitar la gestión de sesiones en la aplicación.
 */
session_start();

/**
 * Vincula la configuración de la aplicación al contenedor de servicios.
 * 
 * @see App::bind()
 */
App::bind('config', $config);

/**
 * Carga y configura el enrutador con las rutas definidas en el archivo de configuración.
 * 
 * @see Router::load()
 * @see App::bind()
 */
$router = Router::load(__DIR__ . '/../app/' . $config['routes']['filename']);
App::bind('router', $router);

/**
 * Configura el servicio de logging.
 * 
 * Carga el sistema de logs utilizando la configuración especificada y lo vincula al contenedor de servicios.
 * 
 * @see MyLog::load()
 * @see App::bind()
 */
$logger = MyLog::load(__DIR__ . '/../logs/' . $config['logs']['filename'], $config['logs']['level']);
App::bind('logger', $logger);
