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
        $comment = new Comment();
        $comment->setMovie($data['movie']);
        $comment->setContent($data['content']);
        $comment->setCommenterIpAddress($data['ip_address']);
        $comment->setCommentedAt(new \DateTime());

        return $comment;
    }
}
