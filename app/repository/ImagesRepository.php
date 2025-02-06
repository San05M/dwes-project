<?php
namespace dwes\app\repository;
use dwes\app\entity\Imagen;
use dwes\app\entity\Categoria;
use dwes\app\repository\CategoriasRepository;
use dwes\core\database\QueryBuilder;
class ImagenesRepository extends QueryBuilder
{
    public function __construct(string $table = 'imagenes', string $classEntity = Imagen::class)
    {
        parent::__construct($table, $classEntity);
    }

    public function getCategoria(Imagen $imagenGaleria): Categoria
    {
        $categoriaRepository = new CategoriasRepository();
        return $categoriaRepository->find($imagenGaleria->getCategoria());
    }

    public function guarda(Imagen $imagenGaleria)
    {
        $fnGuardaImagen = function () use ($imagenGaleria) { 
            $categoria = $this->getCategoria($imagenGaleria);
            $categoriaRepository = new CategoriasRepository();
            $categoriaRepository->nuevaImagen($categoria);
            $this->save($imagenGaleria);
        };
        $this->executeTransaction($fnGuardaImagen);
    }
}

// TODO: Revisar la clase de ImagenesRepository. 