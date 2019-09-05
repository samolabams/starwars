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

     /**
     * @param object $movie
     * @return Character
     */
    public function setMovie(Movie $movie): Character
    {
        $this->movie = $movie;
        return $this;
    }

    /**
     * Get the character movie
     * @return Movie
     */
    public function getMovie(): Movie
    {
        return $this->movie;
    }

    /**
     * @param int $id
     * @return Character
     */
    public function setId(int $id): Character
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the character id
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $name
     * @return Character
     */
    public function setName(string $name): Character
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the character name
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $gender
     * @return Character
     */
    public function setGender(string $gender): Character
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * Get the character gender
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param int $height
     * @return Character
     */
    public function setHeight(int $height): Character
    {
        $this->height = $height;
        return $this;
    }

    /**
     * Get the character height
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

}
