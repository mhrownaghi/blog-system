<?php

namespace App\Controllers;

use App\Entities\Category;

class Categories extends BaseController
{
    protected $helpers = ['url', 'form'];

    public function index()
    {
        $model = model('App\Models\CategoryModel');

        $search = $this->request->getGet('search');
        $order = $this->request->getGet('order');
        $dir = $this->request->getGet('dir');
        $limit = $this->request->getGet('limit') ?? 9;

        if (!empty($search)) {
            $model = $model
                ->like('name', $search)
                ->orLike('note', $search);
        }

        if (!empty($order) && !empty($dir)) {
            $model = $model->orderBy($order, $dir);
        }

        $data = [
            'section' => 'categories',
            'target' => 'list',
            'categories' => $model->paginate($limit),
            'pager' => $model->pager,
            'search' => $search,
            'order' => $order,
            'dir' => $dir,
            'limit' => $limit,
        ];

        return view('admin/categories/list', $data);
    }

    public function new()
    {
        helper('filesystem');
        return view('admin/categories/form', [
            'section' => 'categories',
            'target' => 'new',
            'method' => 'get',
            'files' => get_filenames(WRITEPATH . 'uploads/categories')
        ]);
    }

    public function create()
    {
        $file = $this->request->getFile('file');
        if ($file->isValid() && ! $file->hasMoved()) {
            $file->move(WRITEPATH . 'uploads/categories');
        }
        if (!$this->validate('category')) {
            return view('admin/categories/form', [
                'section' => 'categories',
                'target' => 'new',
                'method' => 'post',
            ]);
        }
        $model = model('App\Models\CategoryModel');
        $model->insert([
            'name' => $this->request->getPost('name'),
            'note' => $this->request->getPost('note'),
            'description' => $this->request->getPost('description'),
            'published' => $this->request->getPost('published') ? 1 : 0,
            'image' => $this->request->getPost('image'),
            'alt' => $this->request->getPost('alt'),
            'seo_title' => $this->request->getPost('seo_title'),
            'seo_description' => $this->request->getPost('seo_description'),
        ]);
        session()->setFlashdata('message', [
            'type' => 'success',
            'content' => 'دسته‌بندی جدید ایجاد شد',
        ]);
        return redirect()->to('/admin/categories');
    }

    public function edit($id)
    {
        helper('filesystem');
        $model = model('App\Models\CategoryModel');
        $category = $model->where('id', $id)->first();
        return view('admin/categories/form', [
            'section' => 'categories',
            'target' => 'edit',
            'method' => 'get',
            'category' => $category,
            'files' => get_filenames(WRITEPATH . 'uploads/categories'),
        ]);
    }

    public function update($id)
    {
        $file = $this->request->getFile('file');
        if ($file->isValid() && ! $file->hasMoved()) {
            $file->move(WRITEPATH . 'uploads/categories');
        }
        if (!$this->validate('category')) {
            return view('admin/categories/form', [
                'section' => 'categories',
                'target' => 'edit',
                'method' => 'get',
            ]);
        }
        $data = [
            'name' => $this->request->getPost('name'),
            'note' => $this->request->getPost('note'),
            'published' => $this->request->getPost('published') ? 1 : 0,
            'image' => $this->request->getPost('image'),
            'alt' => $this->request->getPost('alt'),
            'seo_title' => $this->request->getPost('seo_title'),
            'seo_description' => $this->request->getPost('seo_description'),
            'description' => $this->request->getPost('description'),
        ];
        error_log(print_r($data['image'],true));
        $model = model('App\Models\CategoryModel');
        $model->update($id, $data);        
        session()->setFlashdata('message', [
            'type' => 'success',
            'content' => 'ویرایش دسته‌بندی انجام شد',
        ]);
        return redirect()->to('/admin/categories');
    }

    public function delete($id)
    {
        $model = model('App\Models\CategoryModel');
        $model->delete($id);
        session()->setFlashdata('message', [
            'type' => 'success',
            'content' => 'دسته‌بندی مورد نظر حذف شد',
        ]);
        return redirect()->to('/admin/categories');
    }
}
