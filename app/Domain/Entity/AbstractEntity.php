<?php
declare(strict_types=1);

namespace App\Domain\Entity;

abstract class AbstractEntity
{
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            $property = ucfirst($property);
            $property_getter = 'get'.$property;

            return $this->{$property_getter}();
        }
    }
}
