<?php

/**
 * Contrato padrão de CRUD para DAOs do projeto.
 */
interface EntityInterface
{
    /**
     * Cria um novo registro.
     */
    public function create(array $data): mixed;

    /**
     * Atualiza um registro existente.
     */
    public function edit(array $data): bool;

    /**
     * Remove um registro pelo identificador.
     */
    public function delete(int $id): bool;

    /**
     * Lista registros com filtros opcionais.
     */
    public function getAll(...$filters): array;
}
