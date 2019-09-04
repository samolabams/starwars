<?php

namespace App\Http\Controllers;

use League\Fractal\Resource\Collection;
use App\Domain\Services\MovieService;
use App\Http\Transformers\MovieTransformer;

class MovieController extends ApiController
{
    /**
     * @OA\Get(
     *      path="/movies",
     *      operationId="getAllMovies",
     *      tags={"Movie"},
     *      summary="Get All Movies",
     *      @OA\Response(
     *          response=200,
     *          description="Movies response",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Movie")
     *          )
     *      ),
     *      @OA\Response(
     *          response=503,
     *          description="Service Unavailable: If the service is not available to process request",
     *          @OA\JsonContent(ref="#/components/schemas/Error503")
     *      )
     *   )
     */
    public function index(MovieService $movieService)
    {
        $movies = $movieService->getAll();

        return $this->respondWithCollection($movies, new MovieTransformer);
    }

    /**
     * @OA\Get(
     *      path="/movies/{id}",
     *      operationId="getMovieById",
     *      tags={"Movie"},
     *      summary="Get Movie By Id",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The movie id parameter in path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Movie",
     *          @OA\JsonContent(
     *              @OA\Items(ref="#/components/schemas/Movie")
     *          )
     *      ),
     *      @OA\Response(
     *          response=503,
     *          description="Service Unavailable: If the service is not available to process request",
     *          @OA\JsonContent(ref="#/components/schemas/Error503")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found: If the requested movie is not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error404")
     *      )
     *    )
     */
    public function show(MovieService $movieService, $id)
    {
        $movie = $movieService->getOne($id);

        return $this->respondWithItem($movie, new MovieTransformer);
    }
}
