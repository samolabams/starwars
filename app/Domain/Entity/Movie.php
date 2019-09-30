<?php
declare(strict_types=1);

namespace App\Domain\Entity;

/**
 * @OA\Schema(schema="Movie", required={"id", "title", "openingCrawl", "numberOfComments"})
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
    private $openingCrawl;

    /**
     * @OA\Property(type="integer", format="int64", example="2")
     */
    private $numberOfComments;

    private $charactersLinks = array();
}
