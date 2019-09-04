<?php
declare(strict_types=1);

namespace App\Services\HttpClient;

class HttpResponse
{
    private $statusCode;
    private $body;

    public function setStatusCode(int $statusCode): HttpResponse
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setBodyAsString(string $body): HttpResponse
    {
        $this->body = $body;
        return $this;
    }

    public function setBodyAsArray(array $body): HttpResponse
    {
        $this->body = $body;
        return $this;
    }

    public function getBodyAsString(): string
    {
        return $this->body;
    }

    public function getBodyAsArray(): array
    {
        return $this->body;
    }
}
