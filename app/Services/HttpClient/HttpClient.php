<?php

namespace App\Services\HttpClient;

interface HttpClient
{
    public function get(string $url): HttpResponse;
    public function getAsync(array $urls): HttpResponse;
}
