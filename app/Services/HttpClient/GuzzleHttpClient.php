<?php
declare(strict_types=1);

namespace App\Services\HttpClient;

use Exception;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;

class GuzzleHttpClient implements HttpClient
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('SWAPI_BASE_URI'),
            'verify' => false,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
		]);
    }

    public function get(string $url): HttpResponse
    {
        try {
            $response = $this->client->request('GET', $url);

            return (new HttpResponse)->setStatusCode($response->getStatusCode())
                                    ->setBodyAsString($response->getBody()->getContents());
		} catch (RequestException $e) {
            if ($e->getCode() === 404) {
                abort(404);
            }
            $message = $e->hasResponse() ? Psr7\str($e->getResponse()) : $e->getMessage();
            throw new HttpClientException($message);
		} catch (Exception $e) {
			throw new HttpClientException($e->getMessage());
		}
    }

    public function getAsync(array $urls): HttpResponse
    {
        $promises = array_map(function($url) {
            return $this->client->getAsync($url);
        }, $urls);

        try {
            $results = Promise\settle($promises)->wait();
            return (new HttpResponse)->setBodyAsArray($results);
        } catch (RequestException $e) {
            $message = $e->hasResponse() ? Psr7\str($e->getResponse()) : $e->getMessage();
            throw new HttpClientException($message);
        } catch (Exception $e) {
            throw new HttpClientException;
        }
    }
}
