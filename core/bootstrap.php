<?php

namespace dwes\core;

use dwes\core\Router;
use dwes\core\App;
use dwes\app\utils\MyLog;
use dwes\app\repository\UsuarioRepository;

require __DIR__ . '/../vendor/autoload.php';

$config = require_once __DIR__ . '/../app/config.php';
session_start();
App::bind('config', $config);
$router = Router::load(__DIR__ . '/../app/' . $config['routes']['filename']);
App::bind('router', $router);
$logger = MyLog::load(__DIR__ . '/../logs/' . $config['logs']['filename'], $config['logs']['level']);
if (isset($_SESSION['loguedUser'])) 
$appUser = App::getRepository(UsuarioRepository::class)->find($_SESSION['loguedUser']);
else
$appUser = null;
App::bind('appUser', $appUser);