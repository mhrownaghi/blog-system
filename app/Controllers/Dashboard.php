<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index(): string
    {
        return view('admin/dashboard', [
            'section' => 'dashboard',
        ]);
    }
}
