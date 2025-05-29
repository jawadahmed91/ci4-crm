<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if (!session()->has('logged_user')) {
            return redirect()->to('/login');
        }

        return view('dashboard');
    }
}