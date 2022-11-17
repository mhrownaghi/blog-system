<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class Install extends BaseController
{
    protected $helpers = ['form'];
    public function index(): string | RedirectResponse
    {
        if (strtolower($this->request->getMethod()) !== "post") {
            return view('install');            
        }

        if (!$this->validate('install')) {
            return view('install');            
        }
        $model = model('App\Models\UserModel');
        $data = [
            'username' => $this->request->getVar('username'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ];
        $model->save($data);
        return redirect()->to('/dashboard');
    }

    public function dashboard(): string
    {
        return view('dashboard');
    }
}
