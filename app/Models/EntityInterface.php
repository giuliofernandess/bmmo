<?php

/**
 * Contrato padrão de CRUD para DAOs do projeto.
 */
interface EntityInterface
{
    /**
     * Cria um novo registro.
     */
    public function create(object $entity): mixed;

    /**
     * Atualiza um registro existente.
     */
    public function edit(object $entity): bool;

    /**
     * Remove um registro pelo identificador.
     */
    public function delete(int $id): bool;

    /**
     * Lista registros com filtros opcionais.
     */
    public function getAll(array $filters = []): array;
}
