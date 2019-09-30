<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use \DateTime;

/**
 * @OA\Schema(schema="Comment", required={"id", "content", "commenterIpAddress", "commentedAt"})
 */
class Comment
{
    use Entity;

    public function __construct(array $data)
    {
        $this->loadData($data);
    }

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
}
