<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(schema="Comment", required={"id", "content", "commenter_ip_address", "commented_at"})
 */
class Comment extends Model
{
    /**
     * @OA\Property(property="id", type="integer", format="int64", example="1")
    */

    /**
     * @OA\Property(property="content", type="string", example="It's a hilarious movie")
    */

    /**
     * @OA\Property(property="commenter_ip_address", type="string", example="172.16.1.10")
    */

    /**
     * @OA\Property(property="commented_at", type="date-time", example="2019-05-04 09:01:20")
    */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'movie_id', 'content', 'commenter_ip_address', 'commented_at',
    ];

    protected $dates = [
        'commented_at',
    ];

    public $timestamps = false;
}
