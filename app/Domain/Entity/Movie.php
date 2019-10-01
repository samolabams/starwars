<?php
declare(strict_types=1);

namespace App\Domain\Entity;

/**
 * @OA\Schema(schema="Movie", required={"id", "title", "opening_crawl", "release_date", "number_of_comments"})
 */
class Movie
{
    use Entity;

    public function __construct(array $data)
    {
        $this->loadData($data);
    }

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
    private $opening_crawl;

    /**
     * @OA\Property(type="string", example="1977-05-25")
     * @var string
     */
    private $release_date;

    /**
     * @OA\Property(type="integer", format="int64", example="2")
     */
    private $number_of_comments;

    private $characters_links = array();
}
