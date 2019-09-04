<?php
declare(strict_types=1);

namespace App\Domain\Entity;

class Character extends AbstractEntity
{
    private $movie;
    private $id;
    private $name;
    private $gender;
    private $height;

    public function setMovie(Movie $movie): Character
    {
        $this->movie = $movie;
        return $this;
    }

    public function getMovie(): Movie
    {
        return $this->movie;
    }

    public function setId(int $id): Character
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): Character
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setGender(string $gender): Character
    {
        $this->gender = $gender;
        return $this;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setHeight(int $height): Character
    {
        $this->height = $height;
        return $this;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

}
