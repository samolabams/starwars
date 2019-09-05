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

    /**
     * @param int $id
     * @return Movie
     */
    public function setId(int $id): Movie
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the movie id
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $title
     * @return Movie
     */
    public function setTitle(string $title): Movie
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get the movie title
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $openingCrawl
     * @return Movie
     */
    public function setOpeningCrawl(string $openingCrawl): Movie
    {
        $this->openingCrawl = $openingCrawl;
        return $this;
    }

    /**
     * Get the movie opening crawl
     * @return string
     */
    public function getOpeningCrawl(): string
    {
        return $this->openingCrawl;
    }

    /**
     * @param int $numberOfComments
     * @return Movie
     */
    public function setNumberOfComments(int $numberOfComments): Movie
    {
        $this->numberOfComments = $numberOfComments;
        return $this;
    }

    /**
     * Get number of comments
     * @return int
     */
    public function getNumberOfComments(): int
    {
        return $this->numberOfComments;
    }

    /**
     * @param array $characterLinks
     * @return Movie
     */
    public function setCharactersLinks(array $charactersLinks): Movie
    {
        $this->charactersLinks = $charactersLinks;
        return $this;
    }

    /**
     * Get the movie character links
     * @return array
     */
    public function getCharactersLinks(): array
    {
        return $this->charactersLinks;
    }

}
