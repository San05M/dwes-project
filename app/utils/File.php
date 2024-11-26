<?php
namespace dwes\app\utils;

use dwes\app\exceptions\FileException;

/**
 * Clase para gestionar la subida de archivos al servidor.
 * Proporciona métodos para validar el archivo subido y moverlo a una ubicación específica.
 */
class File
{
    /**
     * @var array $file Contenido del archivo subido al servidor.
     */
    private $file;

    /**
     * @var string $fileName Nombre del archivo subido.
     */
    private $fileName;

    /**
     * Constructor de la clase File.
     * 
     * Inicializa el objeto comprobando si el archivo existe, si no se produjeron errores en la subida 
     * y si el tipo de archivo es admitido.
     * 
     * @param string $fileName Nombre del campo en el formulario que contiene el archivo.
     * @param array $arrTypes Lista de tipos MIME permitidos para el archivo.
     * 
     * @throws FileException Si no se seleccionó un archivo, si hubo errores en la subida 
     *                       o si el tipo de archivo no es válido.
     */
    public function __construct(string $fileName, array $arrTypes)
    {
        $this->file = $_FILES[$fileName]; // $_FILES guarda los datos del archivo subido
        $this->fileName = '';

        if (!isset($this->file)) {
            throw new FileException('Debes seleccionar un fichero');
        }

        if ($this->file['error'] !== UPLOAD_ERR_OK) {
            switch ($this->file['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new FileException('El fichero es demasiado grande');
                case UPLOAD_ERR_PARTIAL:
                    throw new FileException('No se ha podido subir el fichero completo');
                default:
                    throw new FileException('No se ha podido subir el fichero');
            }
        }

        if (in_array($this->file['type'], $arrTypes) === false) {
            throw new FileException('Tipo de fichero no soportado');
        }
    }

    /**
     * Obtiene el nombre del archivo subido.
     * 
     * @return string Nombre del archivo.
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Guarda el archivo subido en una ubicación específica.
     * 
     * Valida si el archivo fue realmente subido a través de un formulario, 
     * comprueba si el archivo ya existe en la ubicación destino, 
     * y si es así, le asigna un nombre único antes de moverlo.
     * 
     * @param string $rutaDestino Ruta destino donde se guardará el archivo subido.
     * 
     * @throws FileException Si el archivo no se subió mediante un formulario o si no se pudo mover 
     *                       el archivo a su destino.
     */
    public function saveUploadFile(string $rutaDestino)
    {
        if (is_uploaded_file($this->file['tmp_name']) === false) {
            throw new FileException('El archivo no ha sido subido mediante un formulario.');
        }

        $this->fileName = $this->file['name'];
        $rutaDestino2 = substr($rutaDestino, 3);
        $ruta = $rutaDestino2 . $this->fileName;

        if (is_file($ruta) === true) {
            $idUnico = time();
            $this->fileName = $idUnico . "_" . $this->fileName;
            $ruta = $rutaDestino . $this->fileName;
        }

        if (move_uploaded_file($this->file['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/' . 'dwes.local/' . $ruta) === false) {
            throw new FileException('No se puede mover el archivo a su destino');
        }
    }
}