<?php
declare(strict_types=1);

namespace App\Domain\Entity;

trait Entity
{
    public function __get($property)
    {
    	if (property_exists($this, $property)) {
            return $this->{$property};
        }

        return null;
    }
    
    public function __set($property, $value)
    {
    	if (property_exists($this, $property)) {
            $this->property = $value;
        }
    }
    
    protected function loadData(array $data)
    {
    	foreach ($data as $property => $value) {
    		$this->{$property} = $value;
    	}
    }
}
