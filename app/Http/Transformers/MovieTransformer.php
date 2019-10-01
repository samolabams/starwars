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
            'opening_crawl' => $movie->openingCrawl,
            'release_date' => $movie->releaseDate,
            'count_of_comments' => $movie->numberOfComments,

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
