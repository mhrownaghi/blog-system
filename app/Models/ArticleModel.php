<?php

namespace App\Models;

use CodeIgniter\Model;

class ArticleModel extends Model
{
    protected $table = 'articles';
    protected $allowedFields = [
        'title',
        'slug',
        'content',
        'published',
        'image',
        'alt',
        'seo_title',
        'seo_description',
        'author',
        'category',
    ];
    protected $returnType = \App\Entities\Article::class;
}
