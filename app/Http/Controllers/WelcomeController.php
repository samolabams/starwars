<?php

namespace App\Http\Controllers;

class WelcomeController extends ApiController
{
    public function index()
    {
    	$message = 'Welcome to StarWars API Service. Navigate to ' . '<a href="'.url('api/documentation').'">' . url('api/documentation') . '</a>' . ' to check the docs.';

        return $this->respondWithString($message);
    }
}
