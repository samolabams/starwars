<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Domain\Entity\Character;

class CharacterTransformer extends TransformerAbstract
{
    public function transform(Character $character)
    {
        return [
            'id' => (int) $character->id,
            'name' => $character->name,
            'gender' => $character->gender,
            'height' => $character->height,

            'links' => [
                [
                    'rel' => 'self',
                    'uri' => '/movies/'.$character->movie->id.'/characters/'.$character->id
                ]
            ]
        ];
    }
}
