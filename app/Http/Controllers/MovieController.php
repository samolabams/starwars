<?php

namespace App\Http\Controllers;

use League\Fractal\Resource\Collection;
use App\Domain\Services\MovieService;
use App\Http\Transformers\MovieTransformer;

class MovieController extends ApiController
{
    public function index(MovieService $movieService)
    {
        $movies = $movieService->getAll();

        return $this->respondWithCollection($movies, new MovieTransformer);
    }

    public function show(MovieService $movieService, $id)
    {
        $movie = $movieService->getOne($id);

        return $this->respondWithItem($movie, new MovieTransformer);
    }
}
