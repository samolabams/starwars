<?php
declare(strict_types=1);

namespace App\Domain\Services;

abstract class AbstractService
{
    /**
     * Extract id from url
     * @param string $url
     * @return int
     */
    protected function extractIdFromUrl(string $url): int
    {
        $urlParts = explode('/', $url);
        $urlParts = array_filter($urlParts, function($part) {
            return !empty(trim($part));
        });

        return (int) array_pop($urlParts);
    }
}
