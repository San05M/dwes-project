<?php

namespace dwes\core;

/**
 * Clase Request para gestionar las solicitudes HTTP.
 * 
 * Proporciona métodos para obtener la URI solicitada y el método HTTP de la petición.
 */
class Request
{
    /**
     * Obtiene la URI de la solicitud actual.
     * 
     * Este método devuelve la URI solicitada por el cliente, eliminando cualquier barra 
     * inicial o final para obtener un formato limpio. Utiliza `$_SERVER['REQUEST_URI']` 
     * para acceder a la información de la solicitud.
     * 
     * @return string URI solicitada sin barras iniciales o finales.
     */
    public static function uri()
    {
        return trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    }

    /**
     * Obtiene el método HTTP de la solicitud actual.
     * 
     * Devuelve el método HTTP utilizado en la solicitud, como GET, POST, PUT o DELETE. 
     * Utiliza `$_SERVER['REQUEST_METHOD']` para acceder al método de la solicitud.
     * 
     * @return string Método HTTP de la solicitud.
     */
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
