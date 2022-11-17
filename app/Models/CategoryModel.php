<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $allowedFields = [
        'name',
        'slug',
        'description',
        'published',
        'image',
        'alt',
        'seo_title',
        'seo_description',
        'note',
    ];
    protected $returnType = \App\Entities\Category::class;
}
