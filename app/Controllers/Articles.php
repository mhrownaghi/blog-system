<?php

namespace App\Controllers;

class Articles extends BaseController
{
    protected $helpers = ['form', 'url'];

    public function index()
    {
        $model = model('App\Models\ArticleModel');

        $search = $this->request->getGet('search');
        $order = $this->request->getGet('order');
        $dir = $this->request->getGet('dir');
        $limit = $this->request->getGet('limit') ?? 9;
        
        $model = $model
            ->select('articles.id, articles.title, users.name as author, categories.name as category, articles.created_at')
            ->join('users', 'users.id = articles.author')
            ->join('categories', 'categories.id = articles.category');
        if (!empty($search)) {
            $model = $model->like('title', $search);
        }

        if (!empty($order) && !empty($dir)) {
            $model = $model->orderBy($order, $dir);
        }

        $data = [
            'section' => 'articles',
            'target' => 'list',
            'articles' => $model->paginate($limit),
            'pager' => $model->pager,
            'search' => $search,
            'order' => $order,
            'dir' => $dir,
            'limit' => $limit,
        ];

        return view('admin/articles/list', $data);

    }

    public function create()
    {
        $file = $this->request->getFile('file');
        if ($file->isValid() && ! $file->hasMoved()) {
            $file->move(WRITEPATH . 'uploads/articles');
        }
        if (!$this->validate('article')) {
            return view('admin/articles/form', [
                'section' => 'articles',
                'target' => 'new',
                'method' => 'post'
            ]);
        }

        $model = model('App\Models\ArticleModel');
        $model->insert([
            'title' => $this->request->getPost('title'),
            'slug' => $this->request->getPost('slug'),
            'content' => $this->request->getPost('content'),
            'published' => $this->request->getPost('published') ? 1 : 0,
            'image' => $this->request->getPost('image'),
            'alt' => $this->request->getPost('alt'),
            'seo_title' => $this->request->getPost('seo_title'),
            'seo_description' => $this->request->getPost('seo_description'),
            'author' => session()->get('user_id'),
            'category' => $this->request->getPost('category'),
        ]);
        session()->setFlashdata('message', [
            'type' => 'success',
            'content' => 'مقاله جدید ایجاد شد',
        ]);
        return redirect()->to('/admin/articles');
    }

    public function new()
    {
        helper('filesystem');
        $model = model('App\Models\CategoryModel');
        $categories = $model->select('id , name')->findAll();
        return view('admin/articles/form', [
            'section' => 'articles',
            'categories' => $categories,
            'target' => 'new',
            'method' => 'get',
            'files' => get_filenames(WRITEPATH . 'uploads/articles'),
        ]);
    }

    public function update($id)
    {
        $file = $this->request->getFile('file');
        if ($file->isValid() && ! $file->hasMoved()) {
            $file->move(WRITEPATH . 'uploads/articles');
        }
        if (!$this->validate('article')) {
            return view('admin/articles/form', [
                'section' => 'articles',
                'target' => 'edit',
                'method' => 'post',
            ]);
        }

        $model = model('App\Models\ArticleModel');
        $model->update($id, [
            'title' => $this->request->getPost('title'),
            'slug' => $this->request->getPost('slug'),
            'content' => $this->request->getPost('content'),
            'published' => $this->request->getPost('published') ? 1 : 0,
            'image' => $this->request->getPost('image'),
            'alt' => $this->request->getPost('alt'),
            'seo_title' => $this->request->getPost('seo_title'),
            'seo_description' => $this->request->getPost('seo_description'),
            'author' => session()->get('user_id'),
            'category' => $this->request->getPost('category'),
        ]);

        session()->setFlashdata('message', [
            'type' => 'success',
            'content' => 'ویرایش مقاله انجام شد',
        ]);
        return redirect()->to('/admin/articles');
    }

    public function edit($id)
    {
        helper('filesystem');
        $model = model('App\Models\ArticleModel');
        $article = $model->where('id', $id)->first();
        $model = model('App\Models\CategoryModel');
        $categories = $model->select('id , name')->findAll();
        return view('admin/articles/form', [
            'section' => 'articles',
            'article' => $article,
            'categories' => $categories,
            'target' => 'edit',
            'method' => 'get',
            'files' => get_filenames(WRITEPATH . 'uploads/articles'),
        ]);
    }

    public function delete($id)
    {
        $model = model('App\Models\ArticleModel');
        $model->delete($id);
        session()->setFlashdata('message', [
            'type' => 'success',
            'content' => 'مقاله مورد نظر حذف شد',
        ]);
        return redirect()->to('/admin/articles');
    }

    public function siteIndex()
    {
        return view('site/home');
    }
}
