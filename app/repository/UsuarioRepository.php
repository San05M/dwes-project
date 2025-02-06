<?php
namespace dwes\app\repository;

use dwes\core\database\QueryBuilder;
use dwes\app\entity\Usuario;

class UsuarioRepository extends QueryBuilder
{
    public function __construct(string $tabla = 'usuarios', string $classEntity = Usuario::class)
    {
        parent::__construct($tabla, $classEntity);
    }

    public function guarda(Usuario $usuario): Usuario
    {
        $fnGuardaUsuario = function () use ($usuario) {
            $this->save($usuario);
        };
        $this->executeTransaction($fnGuardaUsuario);

        return $usuario;
    }
}