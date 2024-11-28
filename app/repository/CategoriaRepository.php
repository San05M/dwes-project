<?php
namespace dwes\app\repository;
use dwes\app\entity\Categoria;
use dwes\core\database\QueryBuilder;

class CategoriasRepository extends QueryBuilder
{
    public function __construct(string $table = 'categorias', string $classEntity = Categoria::class)
    {
        parent::__construct($table, $classEntity);
    }

    public function nuevaImagen(Categoria $categoria)
    {
        $categoria->setNumImagenes($categoria->getNumImagenes() + 1);
        $this->update($categoria);
    }
}