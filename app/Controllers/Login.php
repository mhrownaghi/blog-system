<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class Login extends BaseController
{
    protected $helpers = ['form'];

    public function index(): string | RedirectResponse
    {
        if (strtolower($this->request->getMethod()) !== "post") {
            if (session()->get('logged_in')) {
                return redirect()->to('/admin/dashboard');
            }
            return view('login');
        }
        $session = session();
        $model = model('App\Models\UserModel');
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $data = $model->where('username', $username)->first();
        if (!$data) {
            $session->setFlashdata('message', 'نام کاربری یافت نشد.');
            return view('login');
        }
        if (!password_verify($password, $data->password)) {
            $session->setFlashdata('message', 'گذرواژه اشتباه است.');
            return view('login');
        }
        $ses_data = [
            'user_id' => $data->id,
            'user_username' => $data->username,
            'logged_in' => true,
        ];
        $session->set($ses_data);
        $destination_uri = $session->get('destination_uri');
        if ($destination_uri === null) {
            return redirect()->to('/admin/dashboard');
        }
        $session->remove('destination_uri');
        return redirect()->to($destination_uri);
    }    

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
