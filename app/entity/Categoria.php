<?php
namespace dwes\app\entity;
use dwes\app\entity\IEntity;

class Categoria implements IEntity
{
    private $id = null;
    private $nombre = "";
    private $numImagenes = 0;

    public function __construct($nombre = "", $numImagenes = 0)
    {
        $this->nombre = $nombre;
        $this->numImagenes = $numImagenes;
    }

    public function getId() { return $this->id; }
    public function getNombre(){ return $this->nombre; }
    public function getNumImagenes() { return $this->numImagenes; }
    public function setNombre($nombre): Categoria { $this->nombre = $nombre; return $this; }
    public function setNumImagenes($numImagenes): Categoria { $this->numImagenes = $numImagenes; return $this; }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
            'numImagenes' => $this->getNumImagenes()
        ];
    }

    public function __toString(): string
    {
        return $this->getNombre();
    }
}