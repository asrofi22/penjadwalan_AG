<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('pages/home');
    }

    public function user()
    {
        return view('user/index');
    }
}
