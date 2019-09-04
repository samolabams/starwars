<?php

namespace App\Domain\Repository;

interface RepositoryInterface
{
    public function getById(int $id): ?\stdClass;
    public function persist($entity): int;
}
