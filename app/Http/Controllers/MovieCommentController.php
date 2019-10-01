<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Services\CommentService;
use App\Domain\Repository\CommentRepository;
use App\Http\Transformers\CommentTransformer;
use App\Domain\Services\Paginator\Paginator;
use Validator;

class MovieCommentController extends ApiController
{
    /**
     * @OA\Get(
     *      path="/movies/{movieId}/comments",
     *      operationId="getMovieComments",
     *      tags={"Comment"},
     *      summary="Get Movie Comments",
     *      @OA\Parameter(
     *         name="movieId",
     *         in="path",
     *         description="The movie id parameter in path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="The comments page to retrieve",
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="The number of records to retrieve",
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Comments",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Comment")
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
    public function index(Request $request, CommentService $commentService, CommentRepository $commentRepository, $id)
    {
        $metadata = [];
        $recordsPerPage = (int) $request->limit ?: 10;
        $currentPage = (int) $request->page ?: 1;
        $totalRecords = $commentRepository->getCountByMovieId($id);

        $paginator = (new Paginator)->setRecordsPerPage($recordsPerPage)
                  ->setTotalRecords($totalRecords)
                  ->setCurrentPage($currentPage);

        $totalPages = $paginator->getTotalPages();
        $offset = $paginator->getOffset();

        $comments = $commentService->getAllByMovieId($id, $offset, $recordsPerPage);

        $metadata['page'] = [
            'current' => $currentPage,
            'per_page' => $recordsPerPage,
            'total' => $totalRecords,
            'last' => $totalPages
        ];

        return $this->respondWithCollection($comments, new CommentTransformer, $metadata);
    }

    /**
     * @OA\Post(
     *      path="/movies/{movieId}/comments",
     *      operationId="storeMovieComment",
     *      tags={"Comment"},
     *      summary="Store Movie Comment",
     *      @OA\Parameter(
     *         name="movieId",
     *         in="path",
     *         description="The movie id parameter in path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  required={"content"},
     *                  @OA\Property(property="content", description="The comment", type="string", maximum=500, example="It's a hilarious movie"),
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=201,
     *          description="Null response",
     *          @OA\Header(header="Location", @OA\Schema(type="string"), description="A link to the stored comment")
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation Error (Unprocessable entity)",
     *          @OA\JsonContent(ref="#/components/schemas/Error422")
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
    public function store(Request $request, CommentService $commentService, $id)
    {
        $validator = Validator::make($request->all(), [
            'content' => ['required', 'string', 'max:500']
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('Your request data is invalid', $validator->errors()->all());
        }

        $data = $request->only('content');
        $data['ip_address'] = $_SERVER['REMOTE_ADDR'];

        $commentId = $commentService->create($id, $data);

        return $this->setStatusCode(201)->respondWithString('', ['Location' => url('/movies/'.$id.'/comments/'.$commentId)]);
    }

    /**
     * @OA\Get(
     *      path="/movies/{movieId}/comments/{commentId}",
     *      operationId="getMovieCommentByCommentId",
     *      tags={"Comment"},
     *      summary="Get Movie Comments By Comment Id",
     *      @OA\Parameter(
     *         name="movieId",
     *         in="path",
     *         description="The movie id parameter in path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *         name="commentId",
     *         in="path",
     *         description="The comment id parameter in path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Comment",
     *          @OA\JsonContent(
     *              @OA\Items(ref="#/components/schemas/Comment")
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
    public function show(CommentService $commentService, $id, $commentId)
    {
        $comments = $commentService->getOne($id, $commentId);

        return $this->respondWithItem($comments, new CommentTransformer);
    }
}
