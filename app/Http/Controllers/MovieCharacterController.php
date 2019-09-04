<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Services\CharacterService;
use App\Http\Transformers\CharacterTransformer;

class MovieCharacterController extends ApiController
{
    
    /**
     * @OA\Get(
     *      path="/movies/{movieId}/characters",
     *      operationId="getMovieCharacters",
     *      tags={"Character"},
     *      summary="Get Movie Characters",
     *      @OA\Parameter(
     *         name="movieId",
     *         in="path",
     *         description="The movie id parameter in path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *         name="filter",
     *         in="query",
     *         description="The filter query: to filter by gender (male / female)",
     *         @OA\Schema(type="string"),
     *         example="female"
     *      ),
     *      @OA\Parameter(
     *         name="sort",
     *         in="query",
     *         description="The sort query: to sort by name, gender or height (add -sort to sort in descending order. Example: -name)",
     *         @OA\Schema(type="string"),
     *         example="-height"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Characters",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Character")
     *          )
     *      ),
     *      @OA\Response(
     *          response=503,
     *          description="Service Unavailable: If the service is not available to process request",
     *          @OA\JsonContent(ref="#/components/schemas/Error503")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found: If the movie is not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error404")
     *      )
     *    )
     */   
    public function index(Request $request, CharacterService $characterService, $id)
    {
        $params = [];
        $metadata = [];

        if ($request->has('filter')) {
            $params['filter'] = $request->filter;
        }
        if ($request->has('sort')) {
            $params['sort'] = $request->sort;
        }

        $characters = $characterService->getAll($id, $params);
        $metadata['total_characters'] = count($characters);
        $metadata['total_height_in_cm'] = $totalHeightInCm = $characterService->getTotalHeightInCentimeter($characters);
        $metadata['total_height_in_ft_inches'] = $characterService->convertFromCentimeterToFeetPerInches($totalHeightInCm);

        return $this->respondWithCollection($characters, new CharacterTransformer, $metadata);
    }

    /**
     * @OA\Get(
     *      path="/movies/{movieId}/characters/{characterId}",
     *      operationId="getMovieCharacterByCharacterId",
     *      tags={"Character"},
     *      summary="Get Movie Comments By Comment Id",
     *      @OA\Parameter(
     *         name="movieId",
     *         in="path",
     *         description="The movie id parameter in path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *         name="characterId",
     *         in="path",
     *         description="The character id parameter in path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Character",
     *          @OA\JsonContent(
     *              @OA\Items(ref="#/components/schemas/Character")
     *          )
     *      ),
     *      @OA\Response(
     *          response=503,
     *          description="Service Unavailable: If the service is not available to process request",
     *          @OA\JsonContent(ref="#/components/schemas/Error503")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found: If the movie and/or comment is not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error404")
     *      )
     *    )
     */
    public function show(Request $request, CharacterService $characterService, $id, $characterId)
    {
        $character = $characterService->getOne($id, $characterId);

        return $this->respondWithItem($character, new CharacterTransformer);
    }
}
