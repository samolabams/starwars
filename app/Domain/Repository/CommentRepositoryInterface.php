<?php
declare(strict_types=1);

namespace App\Domain\Repository;

interface CommentRepositoryInterface extends RepositoryInterface
{
    public function getCountByMovieId(int $movieId): int;
    public function getAllByMovieId(int $movieId, int $offset, int $limit): array;
}
