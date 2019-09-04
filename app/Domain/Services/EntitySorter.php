<?php
declare(strict_types=1);

namespace App\Domain\Services;

class EntitySorter
{
    public function sort(array $entities, $property): array
    {
        $property = strtolower($property);

        if (starts_with($property, '-')) {
            $this->sortDescending($entities, $this->removeSortSignFromProperty($property));
        } else {
            $this->sortAscending($entities, $this->removeSortSignFromProperty($property));
        }

        return $entities;
    }

    private function sortAscending(array &$entities, $property): void
    {
        usort($entities, function($entityA, $entityB) use ($property) {
            return $entityA->{$property} <=> $entityB->{$property};
        });
    }

    private function sortDescending(array &$entities, $property): void
    {
        usort($entities, function($entityA, $entityB) use ($property) {
            return $entityB->{$property} <=> $entityA->{$property};
        });
    }

    private function removeSortSignFromProperty(string $property): string
    {
        return trim(str_replace(['-', '+'], ['',''], $property));
    }
}
