<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    private const VIEWS_DIRECTORY = 'Home/';

    public function index(): string
    {
        $data = [
            'title' => 'Home'
        ];
        
        return view(self::VIEWS_DIRECTORY . 'index', $data);
    }
}
