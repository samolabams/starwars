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
    public function sort(array $entities, string $property, ?string $dir): array
    {
        if (is_null($dir) || $dir === 'asc') {
            $this->sortAscending($entities, $property);
        } else if ($dir === 'desc') {
            $this->sortDescending($entities, $property);
        }

        return $entities;
    }

    /**
     * Sort array of entities in ascending order based on the given property
     * @param array $entities
     * @param string $property
     * @return array
     */
    private function sortAscending(array &$entities, string $property): void
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
    private function sortDescending(array &$entities, string $property): void
    {
        usort($entities, function($entityA, $entityB) use ($property) {
            return $entityB->{$property} <=> $entityA->{$property};
        });
    }

}
