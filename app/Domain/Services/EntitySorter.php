<?php
declare(strict_types=1);

namespace App\Domain\Services;

class EntitySorter
{
    /**
     * Sort array of entities in ascending or descending order based on the given property
     * @param array $entities
     * @param string $property
     * @return array
     */
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

    /**
     * Sort array of entities in ascending order based on the given property
     * @param array $entities
     * @param string $property
     * @return array
     */
    private function sortAscending(array &$entities, $property): void
    {
        usort($entities, function($entityA, $entityB) use ($property) {
            return $entityA->{$property} <=> $entityB->{$property};
        });
    }

    /**
     * Sort array of entities in descending order based on the given property
     * @param array $entities
     * @param string $property
     * @return array
     */
    private function sortDescending(array &$entities, $property): void
    {
        usort($entities, function($entityA, $entityB) use ($property) {
            return $entityB->{$property} <=> $entityA->{$property};
        });
    }

    /**
     * Remove sort sign from property
     * @param string $property
     * @return string
     */
    private function removeSortSignFromProperty(string $property): string
    {
        return trim(str_replace(['-', '+'], ['',''], $property));
    }
}
