<?php
declare(strict_types=1);

namespace App\Domain\Entity;

/**
 * @OA\Schema(schema="Character", required={"id", "name", "gender", "height"})
 */
class Character
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
}
