<?php

namespace dwes\core\database;

use dwes\app\entity\IEntity;
use dwes\app\exceptions\NotFoundException;
use dwes\app\exceptions\QueryException;
use dwes\core\App;
use PDOException;
use PDO;

abstract class QueryBuilder
{
    private $connection;
    private $tabla;
    private $classEntity;
    public function __construct(string $tabla, string $classEntity)
    {
        $this->connection = App::getConnection();
        $this->tabla = $tabla;
        $this->classEntity = $classEntity;
    }

    public function save(IEntity $entity): void
    {
        try {
            $parametrers = $entity->toArray();
            $sql = sprintf(
                'INSERT INTO %s (%s) VALUES (%s)',
                $this->tabla,
                implode(', ', array_keys($parametrers)),
                ':' . implode(', :', array_keys($parametrers))
            );
            $statement = $this->connection->prepare($sql);
            $statement->execute($parametrers);
            echo "execute";
        } catch (PDOException $exception) {
            throw new QueryException("Error al insertar en la base de datos.");
        }
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM $this->tabla";
        return $this->executeQuery($sql);
    }

    public function find($id): IEntity
    {
        if (gettype($id) == 'string') {
            $sql = "SELECT * FROM $this->tabla WHERE id = \"$id\"";
        } else {
            $sql = "SELECT * FROM $this->tabla WHERE id = $id";
        }
        $result = $this->executeQuery($sql);
        if (empty($result))
            throw new NotFoundException("No se ha encontrado ningún elemento con código $id.");
        return $result[0];
    }

    public function filter(string $plat): ?array
    {
        $sql = "SELECT * FROM $this->tabla WHERE plataforma LIKE \"$plat%\"";
        return $this->executeQuery($sql);
    }

    public function findBy(array $filters): array
    {
        $sql = "SELECT * FROM $this->tabla " . $this->getFilters($filters);
        return $this->executeQuery($sql, $filters);
    }

    public function getFilters(array $filters)
    {
        if (empty($filters)) return '';
        $strFilters = [];
        foreach ($filters as $key => $value)
            $strFilters[] = $key . '=:' . $key;
        return ' WHERE ' . implode(' and ', $strFilters);
    }

    public function findOneBy(array $filters): ?IEntity
    {
        $result = $this->findBy($filters);
        if (count($result) > 0)
            return $result[0];
        return null;
    }

    private function executeQuery(string $sql, array $parameters = []): array
    {
        $pdoStatement = $this->connection->prepare($sql);
        if ($pdoStatement->execute($parameters) === false)
            throw new QueryException("No se puede realizar la solicitud.");
        return $pdoStatement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->classEntity);
    }

    public function executeTransaction(callable $fnExecuteQuerys)
    {
        try {
            $this->connection->beginTransaction();
            $fnExecuteQuerys(); 
            $this->connection->commit();
        } catch (PDOException $pdoException) {
            $this->connection->rollBack();
            throw new QueryException("La operación ha fallado.");
        }
    }

    public function getUpdates(array $parameters)
    {
        $updates = '';
        foreach ($parameters as $key => $value) {
            if ($key !== 'id')
                if ($updates !== '')
                    $updates .= ", ";
            $updates .= $key . '=:' . $key;
        }
        return $updates;
    }
    
    public function update(IEntity $entity): void
    {
        try {
            $parameters = $entity->toArray();
            $sql = sprintf(
                'UPDATE %s SET %s WHERE id=:id',
                $this->tabla,
                $this->getUpdates($parameters)
            );
            $statement = $this->connection->prepare($sql);
            $statement->execute($parameters);
        } catch (PDOException $pdoException) {
            throw new QueryException("No se puede actualizar el elemento. " . $parameters['id']);
        }
    }

    public function delete(IEntity $entity): void
    {
        try {
            $parameters = $entity->toArray();
            $sql = sprintf(
                'DELETE FROM %s WHERE id=:id',
                $this->tabla
            );
            $statement = $this->connection->prepare($sql);
            $statement->execute($parameters);
        } catch (PDOException $pdoException) {
            throw new QueryException("No se puede eliminar el elemento. " . $parameters['id']);
        }
    }
}
