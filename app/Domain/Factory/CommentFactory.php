<?php

namespace App\Domain\Factory;

use App\Domain\Entity\Comment;

class CommentFactory
{
    /**
     * Create comment entity from data
     * @param array $data
     * @return Comment
     */
    public function createFromData(array $data): Comment
    {
        $comment = new Comment([
            'movie' => $data['movie'],
            'content' => $data['content'],
            'commenterIpAddress' => $data['ip_address'],
            'commentedAt' => new \DateTime()
        ]);

        return $comment;
    }
}
