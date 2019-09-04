<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Services\CharacterService;
use App\Http\Transformers\CharacterTransformer;

class MovieCharacterController extends ApiController
{
    
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

    public function show(Request $request, CharacterService $characterService, $id, $characterId)
    {
        $character = $characterService->getOne($id, $characterId);

        return $this->respondWithItem($character, new CharacterTransformer);
    }
}
