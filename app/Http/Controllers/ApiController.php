<?php

namespace App\Http\Controllers;

use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Manager;
use League\Fractal\TransformerAbstract;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

/**
     * @OA\Info(
     *   title="StarWars API",
     *   version="1.0",
     *   @OA\Contact(
     *     email="samolabams@gmail.com",
     *     name="Sam Olabamiji"
     *   )
     * )
     * @OA\Server(
     *  url="/api/"
     * )
*/

/**
 * @OA\Schema(
 *     schema="Error500",
 *     required={"http_code", "message"},
 *     @OA\Property(
 *         property="http_code",
 *         type="integer",
 *         format="int32",
 *         example="500"
 *     ),
 *     @OA\Property(
 *         property="message",
 *         type="string",
 *         example="Internal Server Error"
 *     )
 * )
 */

/**
 * @OA\Schema(
 *     schema="Error404",
 *     required={"http_code", "message"},
 *     @OA\Property(
 *         property="http_code",
 *         type="integer",
 *         format="int32",
 *         example="404"
 *     ),
 *     @OA\Property(
 *         property="message",
 *         type="string",
 *         example="The requested resource is not available"
 *     )
 * )
 */

 /**
 * @OA\Schema(
 *     schema="Error422",
 *     required={"http_code", "message", "errors"},
 *     @OA\Property(
 *         property="http_code",
 *         type="integer",
 *         format="int32",
 *         example="404"
 *     ),
 *     @OA\Property(
 *         property="message",
 *         type="string",
 *         example="Your request data is invalid"
 *     ),
 *     @OA\Property(
 *         property="errors",
 *         type="array",
 *         example="The content field is required",
 *         @OA\Items()
 *     )
 * )
 */

class ApiController extends Controller
{
    protected $statusCode = 200;
    protected $fractal;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    protected function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    protected function getStatusCode()
    {
        return $this->statusCode;
    }

    protected function respondWithError(string $message, array $errors = [])
    {
        $error = [
            'error' => [
                'http_code' => $this->getStatusCode(),
                'message' => $message,
                'errors' => $errors
            ]
        ];

        return response()->json($error, $this->statusCode);
    }

    protected function respondWithItem($data, TransformerAbstract $transformer, array $headers = [], array $meta = [])
    {
        $resource = new Item($data, $transformer);
        if (!empty($meta)) {
            $resource->setMeta($meta);
        }

        return response()->json($this->fractal->createData($resource)->toArray(), $this->statusCode, $headers);
    }

    protected function respondWithCollection($data, TransformerAbstract $transformer, $withPagination = false, array $headers = [], array $meta = [])
    {
        $collection = $withPagination ? $data->getCollection() : $data;

        $resource = new Collection($collection, $transformer);
        if ($withPagination) {
            $resource->setPaginator(new IlluminatePaginatorAdapter($data));
        }
        if (!empty($meta)) {
            $resource->setMeta($meta);
        }


        return response()->json($this->fractal->createData($resource)->toArray(), $this->statusCode, $headers);
    }

    protected function respondWithString(string $string, array $headers = [])
    {
        return response()->json($string, $this->statusCode, $headers);
    }
}
