<?php

namespace dwes\core;

/**
 * Clase Response para gestionar las respuestas de la aplicación.
 * 
 * Proporciona métodos para renderizar vistas con un diseño (layout) específico y datos dinámicos.
 */
class Response
{
    /**
     * Renderiza una vista con un diseño (layout) y datos opcionales.
     * 
     * Este método permite generar una página HTML combinando el contenido de una vista específica 
     * con un diseño (layout) general. Los datos proporcionados en el array `$data` estarán disponibles 
     * como variables en la vista.
     * 
     * @param string $name Nombre de la vista a renderizar (sin extensión).
     * @param string $layout Nombre del archivo de diseño (layout) a utilizar (sin extensión). 
     *                       Por defecto, se utiliza `layout`.
     * @param array $data Datos dinámicos que se pasarán a la vista como variables. 
     *                    Las claves del array se convierten en nombres de variables en la vista.
     * 
     * @return void
     */
    public static function renderView(string $name, string $layout = 'layout', array $data = [])
    {
        // Creamos variables dinámicas a partir de las claves del array $data
        extract($data); // Convierte las claves del array en nombres de variables
        ob_start(); // Activa el almacenamiento en buffer para capturar la salida de la vista
        require __DIR__ . "/../app/views/$name.view.php"; // Carga el archivo de la vista
        $mainContent = ob_get_clean(); // Recupera y limpia el contenido capturado del buffer
        require __DIR__ . "/../app/views/$layout.view.php"; // Carga el diseño con el contenido principal
    }
}
