<?php
declare(strict_types=1);

namespace App\Domain\Entity;

class Movie extends AbstractEntity
{
    private $id;
    private $title;
    private $openingCrawl;
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
