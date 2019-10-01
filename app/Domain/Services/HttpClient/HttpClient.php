<?php

namespace App\Domain\Services\HttpClient;

interface HttpClient
{
    public function get(string $url): HttpResponse;
    public function getAsync(array $urls): HttpResponse;
}
