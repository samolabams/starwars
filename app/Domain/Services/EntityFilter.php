<?php
declare(strict_types=1);

namespace App\Domain\Services;

class EntityFilter
{
    public function filter(array $entities, string $property, string $value): array
    {
        $property = strtolower($property);
        $value = strtolower($value);

        return array_filter($entities, function($entity) use ($property, $value) {
            return $entity->{$property} === $value;
        });
    }
}
