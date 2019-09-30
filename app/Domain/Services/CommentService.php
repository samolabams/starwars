<?php
declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entity\Comment;
use App\Domain\Repository\CommentRepositoryInterface;
use App\Domain\Factory\CommentFactory;

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

    public function __construct(MovieService $movieService, CommentRepositoryInterface $commentRepository)
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
    public function create(int $movieId, array $data): int
    {
        $data['movie'] = $this->movieService->getOne($movieId, false);

        $comment = CommentFactory::createFromData($data);
        $commentId = $this->commentRepository->persist($comment);

        return $commentId;
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
        $commentResult = $this->commentRepository->getById($commentId);

        if (is_null($commentResult)) {
            abort(404);
        }

        $comment = new Comment([
            'movie' => $movie,
            'id' => intval($commentResult->id),
            'content' => $commentResult->content,
            'commenterIpAddress' => $commentResult->commenter_ip_address,
            'commentedAt' => new \DateTime($commentResult->commented_at),
        ]);

        return $comment;
    }

    /**
     * Get Comments from from the database by id
     * @param int $id
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function getAllByMovieId(int $id, int $offset, int $limit): array
    {
        $comments = [];
        $movie = $this->movieService->getOne($id, false);
        $commentsResult = $this->commentRepository->getAllByMovieId($id, $offset, $limit);

        foreach ($commentsResult as $result) {
            $comment = new Comment([
                'movie' => $movie,
                'id' => intval($result->id),
                'content' => $result->content,
                'commenterIpAddress' => $result->commenter_ip_address,
                'commentedAt' => new \DateTime($result->commented_at),
            ]);

            array_push($comments, $comment);
        }

        return $comments;
    }
}
