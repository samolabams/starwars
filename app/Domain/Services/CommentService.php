<?php
declare(strict_types=1);

namespace App\Domain\Services;

use App\Models\Comment;
use App\Domain\Repository\CommentRepository;

class CommentService extends AbstractService
{
    /**
     *  Instance of movie service
     *  @var MovieService
     */
    private $movieService;

    /**
     *  Instance of comment repository
     *  @var CommentRepository
     */
    private $commentRepository;

    public function __construct(MovieService $movieService, CommentRepository $commentRepository)
    {
        $this->movieService = $movieService;
        $this->commentRepository = $commentRepository;
    }

    /**
     * Create new movie comment
     * @param int $movieId
     * @param array $data
     * @return int
     */
    public function create(int $movieId, array $data): Comment
    {
        $data['movie'] = $this->movieService->getOne($movieId, false);
        $data['ip_address'] = $_SERVER['REMOTE_ADDR'];
        $data['commented_at'] = new \DateTime();

        $comment = $this->commentRepository->persist($data);

        return $comment;
    }

    /**
     * Get Comment from from the database by id
     * @param int $movieId
     * @param int $commentId
     * @return Comment
     */
    public function getOne(int $movieId, int $commentId): Comment
    {
        $movie = $this->movieService->getOne($movieId, false);
        $comment = $this->commentRepository->getById($commentId);

        if ($comment->movie_id !== $movieId) abort(404);

        return $comment;
    }

    /**
     * Get Comments from from the database by id
     * @param int $id
     * @param int $recordsPerPage
     * @return array
     */
    public function getAllByMovieId(int $id, int $recordsPerPage)
    {
        $movie = $this->movieService->getOne($id, false);
        $comments = $this->commentRepository->getAllByMovieId($id, $recordsPerPage);

        return $comments;
    }
}
