<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Domain\Entity\Movie;

class MovieTransformer extends TransformerAbstract
{
    public function transform(Movie $movie)
    {
        return [
            'id' => (int) $movie->id,
            'title' => $movie->title,
            'opening_crawl' => $movie->opening_crawl,
            'release_date' => $movie->release_date,
            'count_of_comments' => $movie->number_of_comments,

            'links' => [
                [
                    'rel' => 'self',
                    'uri' => '/movies/'.$movie->id
                ],
                [
                    'rel' => 'movie.comments',
                    'uri' => '/movies/'.$movie->id.'/comments',
                ],
                [
                    'rel' => 'movie.characters',
                    'uri' => '/movies/'.$movie->id.'/characters',
                ]
            ]
        ];
    }
}
