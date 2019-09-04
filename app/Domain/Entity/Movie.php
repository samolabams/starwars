<?php
declare(strict_types=1);

namespace App\Domain\Entity;

/**
 * @OA\Schema(schema="Movie", required={"id", "title", "openingCrawl", "numberOfComments"})
 */
class Movie extends AbstractEntity
{
    /**
     * @OA\Property(type="integer", format="int64", example="1")
     */
    private $id;

    /**
     * @OA\Property(type="string", example="A new hope")
     * @var string
     */
    private $title;

    /**
     * @OA\Property(type="string", example="It is a period of civil war.\r\nRebel spaceships...")
     * @var string
     */
    private $openingCrawl;

    /**
     * @OA\Property(type="integer", format="int64", example="2")
     */
    private $numberOfComments;

    private $charactersLinks = array();

    public function setId(int $id): Movie
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setTitle(string $title): Movie
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setOpeningCrawl(string $openingCrawl): Movie
    {
        $this->openingCrawl = $openingCrawl;
        return $this;
    }

    public function getOpeningCrawl(): string
    {
        return $this->openingCrawl;
    }

    public function setNumberOfComments(int $numberOfComments): Movie
    {
        $this->numberOfComments = $numberOfComments;
        return $this;
    }

    public function getNumberOfComments(): int
    {
        return $this->numberOfComments;
    }

    public function setCharactersLinks(array $charactersLinks): Movie
    {
        $this->charactersLinks = $charactersLinks;
        return $this;
    }

    public function getCharactersLinks(): array
    {
        return $this->charactersLinks;
    }

}
