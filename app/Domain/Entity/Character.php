<?php
declare(strict_types=1);

namespace App\Domain\Entity;

/**
 * @OA\Schema(schema="Character", required={"id", "name", "gender", "height"})
 */
class Character extends AbstractEntity
{
    private $movie;

    /**
     * @OA\Property(type="integer", format="int64", example="1")
     */
    private $id;

    /**
     * @OA\Property(type="string", example="Kevin hart")
     */
    private $name;

    /**
     * @OA\Property(type="string", example="male")
     */
    private $gender;

    /**
     * @OA\Property(type="integer", format="int64", example="176")
     */
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
