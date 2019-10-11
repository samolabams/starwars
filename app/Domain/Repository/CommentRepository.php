<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Models\Comment;

class CommentRepository
{
    public function persist(array $data): Comment
    {
        return Comment::create([
            'movie_id' => $data['movie']->id,
            'content' => $data['content'],
            'commenter_ip_address' => $data['ip_address'],
            'commented_at' => $data['commented_at']
        ]);
    }

    public function getCountByMovieId(int $movieId): int
    {
        return Comment::where('movie_id', $movieId)
                        ->count();
    }

    public function getById(int $commentId): Comment
    {
        return Comment::where('id', $commentId)
                        ->firstOrFail();
    }

    public function getAllByMovieId(int $movieId, int $recordsPerPage = 20)
    {
        return Comment::where('movie_id', $movieId)
                        ->orderBy('commented_at', 'DESC')
                        ->paginate($recordsPerPage);
    }
}
