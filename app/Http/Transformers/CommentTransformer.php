<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Comment;

class CommentTransformer extends TransformerAbstract
{
    public function transform(Comment $comment)
    {
        return [
            'id' => (int) $comment->id,
            'content' => $comment->content,
            'commenter_ip_address' => $comment->commenter_ip_address,
            'commented_at' => $comment->commented_at->format('Y-m-d H:i:s'),

            'links' => [
                [
                    'rel' => 'self',
                    'uri' => '/movies/'.$comment->movie_id.'/comments/'.$comment->id
                ]
            ]
        ];
    }
}
