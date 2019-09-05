<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use \DateTime;

/**
 * @OA\Schema(schema="Comment", required={"id", "content", "commenterIpAddress", "commentedAt"})
 */
class Comment extends AbstractEntity
{
    private $movie;

    /**
     * @OA\Property(type="integer", format="int64", example="1")
     */
    private $id;

    /**
     * @OA\Property(type="string", example="It's a hilarious movie")
     * @var string
     */
    private $content;

    /**
     * @OA\Property(type="string", example="172.16.1.10")
     */
    private $commenterIpAddress;

    /**
     * @OA\Property(type="date-time", example="2019-05-04 09:01:20")
     */
    private $commentedAt;

    /**
     * @param Movie $movie
     * @return Comment
     */
    public function setMovie(Movie $movie): Comment
    {
        $this->movie = $movie;
        return $this;
    }

    /**
     * Get the comment movie
     * @return Movie
     */
    public function getMovie(): Movie
    {
        return $this->movie;
    }

    /**
     * @param int $id
     * @return Comment
     */
    public function setId(int $id): Comment
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
     * @param string $content
     * @return Comment
     */
    public function setContent(string $content): Comment
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get the comment content
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $commenterIpAddress
     * @return Comment
     */
    public function setCommenterIpAddress(string $commenterIpAddress): Comment
    {
        $this->commenterIpAddress = $commenterIpAddress;
        return $this;
    }

    /**
     * Get the commenter ip address
     * @return string
     */
    public function getCommenterIpAddress(): string
    {
        return $this->commenterIpAddress;
    }

    /**
     * @param DateTime $commentedAt
     * @return Comment
     */
    public function setCommentedAt(DateTime $commentedAt): Comment
    {
        $this->commentedAt = $commentedAt;
        return $this;
    }

    /**
     * Get the comment date
     * @return DateTime
     */
    public function getCommentedAt(): DateTime
    {
        return $this->commentedAt;
    }

}
