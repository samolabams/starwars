<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Services\CommentService;
use App\Domain\Repository\CommentRepository;
use App\Http\Transformers\CommentTransformer;
use App\Services\Paginator\Paginator;
use Validator;

class MovieCommentController extends ApiController
{
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

    public function show(CommentService $commentService, $id, $commentId)
    {
        $comments = $commentService->getOne($id, $commentId);

        return $this->respondWithItem($comments, new CommentTransformer);
    }
}
