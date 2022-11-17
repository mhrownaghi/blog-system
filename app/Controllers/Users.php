<?php

namespace App\Controllers;

class Users extends BaseController
{
    protected $helpers = ['url', 'form'];
    public function index()
    {
        $model = model('App\Models\UserModel');
        $search = $this->request->getGet('search');
        $order = $this->request->getGet('order');
        $dir = $this->request->getGet('dir');
        $limit = $this->request->getGet('limit') ?? 9;
        
        if (!empty($search)) {
            $model = $model
                ->like('name', $search)
                ->orLike('email', $search)
                ->orLike('username', $search);
        }

        if (!empty($order) && !empty($dir)) {
            $model = $model
                ->orderBy($order, $dir);
        }

        $data = [
            'section' => 'users',
            'users' => $model->paginate($limit),
            'pager' => $model->pager,
            'limit' => $limit,
            'search' => $search,
            'order' => $order,
            'dir' => $dir,
        ];
        return view('admin/users/list', $data);
    }

    public function new()
    {
        return view('admin/users/form', [
            'section' => 'users',
            'target' => 'new',
            'method' => 'get'
        ]);
    }

    public function create()
    {
        if (!$this->validate('user')) {
            return view('admin/users/form', [
                'section' => 'users',
                'target' => 'new',
                'method' => 'post'
            ]);
        }
        $model = model('App\Models\UserModel');
        $model->insert([
            'name' => $this->request->getPost('name'),
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ]);
        session()->setFlashdata('message', [
            'type' => 'success',
            'content' => 'کاربر جدید ایجاد شد.',
        ]);
        return redirect()->to('/admin/users');
    }

    public function edit($id)
    {
        $model = model('App\Models\UserModel');
        $user = $model->where('id', $id)->first();
        return view('admin/users/form', [
            'section' => 'users',
            'target' => 'edit',
            'method' => 'get',
            'user' => $user,
        ]);
    }

    public function update($id)
    {
        if (!$this->validate('user')) {
            return view('admin/users/form', [
                'section' => 'users',
                'target' => 'edit',
                'method' => 'post',  
            ]);
        }
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),            
        ];
        $password =$this->request->getPost('password'); 
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        $model = model('App\Models\UserModel');
        $model->update($id, $data);
        session()->setFlashdata('message', [
            'type' => 'success',
            'content' => 'ویرایش کاربر انجام شد'
        ]);
        return redirect()->to('/admin/users');
        
    }

    public function remove($id)
    {
        $model = model('App\Models\UserModel');
        $model->delete($id);
        session()->setFlashdata('message', [
            'type' => 'success',
            'content' => 'حذف کاربر انجام شد'
        ]);
        return redirect()->to('/admin/users');
    }

}
