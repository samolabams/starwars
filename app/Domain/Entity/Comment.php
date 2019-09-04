<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use \DateTime;

class Comment extends AbstractEntity
{
    private $movie;
    private $id;
    private $content;
    private $commenterIpAddress;
    private $commentedAt;

    public function setMovie(Movie $movie): Comment
    {
        $this->movie = $movie;
        return $this;
    }

    public function getMovie(): Movie
    {
        return $this->movie;
    }

    public function setId(int $id): Comment
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setContent(string $content): Comment
    {
        $this->content = $content;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setCommenterIpAddress(string $commenterIpAddress): Comment
    {
        $this->commenterIpAddress = $commenterIpAddress;
        return $this;
    }

    public function getCommenterIpAddress(): string
    {
        return $this->commenterIpAddress;
    }

    public function setCommentedAt(DateTime $commentedAt): Comment
    {
        $this->commentedAt = $commentedAt;
        return $this;
    }

    public function getCommentedAt(): DateTime
    {
        return $this->commentedAt;
    }

}
