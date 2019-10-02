<?php

namespace App\Http\Controllers;

class WelcomeController extends ApiController
{
    public function index()
    {
    	$message = 'Welcome to StarWars API Service. Navigate to ' . url('api/documentation') . ' to check the docs.';

        return $this->respondWithString($message);
    }
}
