<?php
class Imagen
{
    private $id;
    private $nombre;
    private $descripcion;
    private $categoria;

    const RUTA_IMAGENES_PORTFOLIO = '/public/img/index';
    const RUTA_IMAGENES_SOCIOS = '/public/img/socios';
    const RUTA_IMAGENES_CONTACTO = '/public/img/contacto/';

    function setNombre($nombre): Imagen
    {
        $this->nombre = $nombre;
        return $this;
    }
    function getNombre(): ?string
    {
        return $this->nombre;
    }
    public function __construct($nombre = "", $descripcion = "", $categoria = 0)
    {
        $this->id = null;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->categoria = $categoria;
    }

    function setDescripcion($descripcion): Imagen
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    function setCategoria($categoria): Imagen
    {
        $this->categoria = $categoria;
        return $this;
    }

    function getCategoria(): ?int
    {
        return $this->categoria;
    }

    function getId(): ?int
    {
        return $this->id;
    }

    function getUrlIndex(): ?string
    {
        return self::RUTA_IMAGENES_PORTFOLIO . $this->getNombre();
    }

    function getUrlSocios(): ?string
    {
        return self::RUTA_IMAGENES_SOCIOS . $this->getNombre();
    }

    function getUrlContacto(): ?string
    {
        return self::RUTA_IMAGENES_CONTACTO . $this->getNombre();
    }

    public function __toString(): string
    {
        return $this->getDescripcion();
    }
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
            'descripcion' => $this->getDescripcion()
        ];
    }
}
