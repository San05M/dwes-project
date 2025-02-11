<?php

namespace dwes\app\entity;

class Imagen implements IEntity
{
    private $id = null;
    private $titulo = "";
    private $descripcion = "";
    private $ruta="";
    private $categoria = "";

    const RUTA_IMAGENES_PORTFOLIO = '/public/images/index/portfolio/';
    const RUTA_IMAGENES_GALERIA = '/public/images/index/gallery/';
    const RUTA_IMAGENES_CLIENTES = '/public/images/clients/';
    const RUTA_IMAGENES_SUBIDAS = '/public/assets/img/galeria/';

    public function __construct($titulo = "", $descripcion = "", $categoria = 1, $ruta = "")
    {
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->categoria = $categoria;
        $this->ruta = $ruta;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'titulo' => $this->getTitulo(),
            'descripcion' => $this->getDescripcion(),
            'categoria' => $this->getCategoria(),
            'ruta' => $this->getRuta()
        ];
    }

    public function getId() { return $this->id; }
    public function geTtitulo() { return $this->titulo; }
    public function getDescripcion() { return $this->descripcion; }
    public function getCategoria() { return $this->categoria; }
    public function setTitulo($titulo): Imagen { $this->titulo = $titulo; return $this; }
    public function setDescripcion($descripcion): Imagen { $this->descripcion = $descripcion; return $this; }
    public function setCategoria($categoria): Imagen { $this->categoria = $categoria; return $this; }
    public function setRuta($ruta): Imagen { $this->ruta = $ruta; return $this; }
    public function getRuta() { return $this->ruta; }   
    public function getUrlPortfolio() { return self::RUTA_IMAGENES_PORTFOLIO . $this->getTitulo(); }
    public function getUrlGaleria() { return self::RUTA_IMAGENES_GALERIA . $this->getTitulo(); }
    public function getUrlClientes() { return self::RUTA_IMAGENES_CLIENTES . $this->getTitulo(); }
    public function getUrlSubidas() { return self::RUTA_IMAGENES_SUBIDAS . $this->getTitulo(); }

    public function __toString()
    {
        return $this->descripcion;
    }
}
