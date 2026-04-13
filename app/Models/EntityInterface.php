<?php




interface EntityInterface
{
    


    public function create(object $entity): mixed;

    


    public function edit(object $entity): bool;

    


    public function delete(int $id): bool;

    


    public function getAll(array $filters = []): array;
}
