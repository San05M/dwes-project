<?php

namespace dwes\core;

use dwes\app\exceptions\NotFoundException;

/**
 * Clase Router para gestionar las rutas de la aplicación.
 * Permite definir rutas GET y POST, asociarlas a controladores y acciones, 
 * y dirigir las peticiones al controlador correspondiente.
 */
class Router
{
    /**
     * @var array $routes Almacena las rutas definidas para los métodos GET y POST.
     */
    private $routes;

    /**
     * Constructor privado de la clase Router.
     * 
     * Inicializa la estructura de almacenamiento de rutas para GET y POST.
     */
    private function __construct()
    {
        $this->routes = [
            'GET' => [],
            'POST' => []
        ];
    }

    /**
     * Carga un archivo de configuración de rutas y devuelve una instancia de Router.
     * 
     * @param string $file Ruta al archivo de configuración de rutas.
     * @return Router Instancia de Router con las rutas cargadas.
     */
    public static function load(string $file): Router
    {
        $router = new Router();
        require $file;
        return $router;
    }

    /**
     * Define un conjunto de rutas para la aplicación.
     * 
     * @param array $routes Array de rutas asociadas a controladores.
     */
    public function define(array $routes): void
    {
        $this->routes = $routes;
    }

    /**
     * Registra una ruta GET con su controlador correspondiente.
     * 
     * @param string $uri URI de la ruta.
     * @param string $controller Controlador y acción en formato `Controlador@acción`.
     */
    public function get(string $uri, string $controller): void
    {
        $this->routes['GET'][$uri] = $controller;
    }

    /**
     * Registra una ruta POST con su controlador correspondiente.
     * 
     * @param string $uri URI de la ruta.
     * @param string $controller Controlador y acción en formato `Controlador@acción`.
     */
    public function post(string $uri, string $controller): void
    {
        $this->routes['POST'][$uri] = $controller;
    }

    /**
     * Llama a la acción de un controlador específico con parámetros.
     * 
     * @param string $controller Nombre del controlador.
     * @param string $action Acción (método) del controlador.
     * @param array $parameters Parámetros a pasar al método.
     * 
     * @return bool Devuelve true si la acción se ejecutó correctamente.
     * @throws NotFoundException Si el controlador o la acción no existen.
     */
    private function callAction(string $controller, string $action, array $parameters): bool
    {
        try {
            $controller = App::get('config')['project']['namespace'] . '\\app\\controllers\\' . $controller;
            $objController = new $controller();

            if (!method_exists($objController, $action)) {
                throw new NotFoundException("El controlador $controller no responde al action $action");
            }

            call_user_func_array([$objController, $action], $parameters);
            return true;
        } catch (\TypeError $typeError) {
            return false;
        }
    }

    /**
     * Direcciona una petición a la ruta y controlador correspondientes.
     * 
     * @param string $uri URI de la petición.
     * @param string $method Método HTTP (GET o POST).
     * 
     * @throws NotFoundException Si no se encuentra una ruta definida para la URI.
     */
    public function direct(string $uri, string $method): void
    {
        foreach ($this->routes[$method] as $route => $controller) {
            $urlRule = $this->prepareRoute($route);

            if (preg_match($urlRule, $uri, $matches) === 1) {
                $parameters = $this->getParametersRoute($route, $matches);
                list($controller, $action) = explode('@', $controller);

                if ($this->callAction($controller, $action, $parameters) === true) {
                    return;
                }
            }
        }

        throw new NotFoundException("No se ha definido una ruta para la URI solicitada");
    }

    /**
     * Prepara una ruta para usar en expresiones regulares.
     * 
     * @param string $route Ruta definida en la aplicación.
     * @return string Ruta transformada en formato de expresión regular.
     */
    private function prepareRoute(string $route): string
    {
        $urlRule = preg_replace('/:([^\/]+)/', '(?<\1>[^/]+)', $route);
        $urlRule = str_replace('/', '\/', $urlRule);
        return '/^' . $urlRule . '\/*$/s';
    }

    /**
     * Obtiene los parámetros de una ruta a partir de las coincidencias.
     * 
     * @param string $route Ruta definida en la aplicación.
     * @param array $matches Coincidencias obtenidas mediante la expresión regular.
     * 
     * @return array Parámetros extraídos de la ruta.
     */
    private function getParametersRoute(string $route, array $matches)
    {
        preg_match_all('/:([^\/]+)/', $route, $parameterNames);
        $parameterNames = array_flip($parameterNames[1]);
        return array_intersect_key($matches, $parameterNames);
    }

    /**
     * Redirige la petición a otra ruta.
     * 
     * @param string $path Ruta destino.
     */
    public function redirect(string $path)
    {
        header('location: /' . $path);
    }
}
