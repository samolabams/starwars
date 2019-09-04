<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Domain\Entity\Comment;

class CommentTransformer extends TransformerAbstract
{
    public function transform(Comment $comment)
    {
        return [
            'id' => (int) $comment->id,
            'content' => $comment->content,
            'commenter_ip_address' => $comment->commenterIpAddress,
            'commented_at' => $comment->commentedAt->format('Y-m-d H:i:s'),

            'links' => [
                [
                    'rel' => 'self',
                    'uri' => '/movies/'.$comment->movie->id.'/comments/'.$comment->id
                ]
            ]
        ];
    }
}
