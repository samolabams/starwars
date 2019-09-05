<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use Illuminate\Support\Facades\DB;
use App\Domain\Repository\CommentRepositoryInterface;
use App\Domain\Entity\Comment;

class CommentRepository implements CommentRepositoryInterface
{
    public function persist($comment): int
    {
        $response = DB::insert('INSERT INTO comments(movie_id, content, commenter_ip_address, commented_at) VALUES (?, ?, ?, ?)', [$comment->movie->id, $comment->content, $comment->commenterIpAddress, $comment->commentedAt]);
        $id = (int) DB::getPdo()->lastInsertId();

        return $id;
    }

    public function getCountByMovieId(int $movieId): int
    {
        $number_of_comments = DB::select('SELECT COUNT(id) AS num_comments FROM comments WHERE movie_id = ?', [$movieId]);

        return $number_of_comments[0]->num_comments;
    }

    public function getById(int $id): ?\stdClass
    {
        $comment = DB::select('SELECT * FROM comments WHERE id = ?', [$id]);

        return !empty($comment) ? $comment[0] : null;
    }

    public function getAllByMovieId(int $movieId, int $offset, int $limit): array
    {
        $comments = DB::select('SELECT * FROM comments WHERE movie_id = ? ORDER BY content DESC LIMIT ? OFFSET ?', [$movieId, $limit, $offset]);

        return $comments;
    }
}
