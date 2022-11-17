<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public $install = [
        'username' => "required|min_length[3]|max_length[100]|is_unique[users.username]",
        'password' => "required|min_length[8]|max_length[200]",
    ];

    public $install_errors = [
        'username' => [
            'required' => 'باید نام کاربری را وارد کنید',
            'min_length' => 'طول نام کاربری نباید کمتر از ۳ نویسه باشد',
            'max_length' => 'طول نام کاربری نباید بیش از ۱۰۰ نویسه باشد',
            'is_unique' => 'نام کاربری تکراری است',
        ],
        'password' => [
            'required' => 'باید گذرواژه را وارد کنید',
            'min_length' => 'طول گذرواژه نباید کمتر از ۸ نویسه باشد',
            'max_length' => 'طول گذرواژه نباید بیشتر از ۲۰۰ نویسه باشد',
        ]
    ];

    public $user = [
        'name' => 'permit_empty|min_length[3]|max_length[400]',
        'username' => "required|min_length[3]|max_length[150]|is_unique[users.username,id,{id}]",
        'email' => 'permit_empty|valid_email|max_length[100]',
        'password' => "required_without[id]|permit_empty|min_length[8]|max_length[100]",
        'passconf' => "matches[password]"
    ];

    public $user_errors = [
        'name' => [
            'min_length' => 'طول نام نباید کمتر از 3 نویسه باشد',
            'max_length' => 'طول نام نباید بیشتر از 400 نویسه باشد',
        ],
        'email' => [
            'valid_email' => 'ایمیل معتبر نیست',
            'max_length' => 'طول ایمیل نباید بیشتر از 100 نویسه باشد'
        ],
        'username' => [
            'required' => 'باید نام کاربری را وارد کنید',
            'min_length' => 'طول نام کاربری نباید کمتر از 3 نویسه باشد',
            'max_length' => 'طول نام کاربری نباید بیشتر از 150 نویسه باشد',
            'is_unique' => 'نام کاربری تکراری است',
        ],
        'password' => [
            'required_without' => 'باید گذرواژه را وارد کنید',
            'min_length' => 'طول گذرواژه نباید کمتر از 8 نویسه باشد',
            'max_length' => 'طول گذرواژه نباید بیشتر از 100 نویسه باشد',
        ],
        'passconf' => [
            'matches' => 'تکرار گذرواژه با گذرواژه باید یکسان باشد.'
        ]
    ];

    public $category = [
        'name' => 'required|max_length[255]|is_unique[categories.name,id,{id}]',
        'note' => 'permit_empty|min_length[3]|max_length[255]',        
        'alt' => 'required_with[image]|permit_empty|max_length[255]',
        'seo_title' => 'required|min_length[3]|max_length[255]',
        'seo_description' => 'required',        
    ];

    public $category_errors = [
        'name' => [
            'required' => 'باید نام دسته‌بندی را وارد کنید',            
            'max_length' => 'طول نام نباید بیشتر از 255 نویسه باشد',
            'is_unique' => 'نام دسته‌بندی تکراری است',
        ],
        'note' => [
            'min_length' => 'طول یادداشت نباید کمتر از 3 نویسه باشد',
            'max_length' => 'طول یادداشت نباید بیشتر از 255 نویسه باشد',
        ],
        'alt' => [
            'required_with' => 'برای عکس متن جایگزینی وارد نشده است',
            'max_length' => 'متن جایگزین عکس بیشتر از 255 نویسه است',
        ],
        'seo_title' => [
            'required' => 'برای نتایج موتورهای جستجو عنوانی وارد نشده است',
            'min_length' => 'عنوانی که برای نتایج موتورهای جستجو وارد شده کمتر از سه نویسه است',
            'max_length' => 'عنوانی که برای نتایج موتورهای جستجو وارد شده بیشتر از 255 نویسه است',
        ],
        'seo_description' => [
            'required' => 'برای نتایج موتورهای جستجو توضیحات وارد نشده است',
        ],
    ];

    public $article = [
        'title' => 'required|max_length[255]|is_unique[articles.title,id,{id}]',        
        'alt' => 'required_with[image]|permit_empty|max_length[255]',
        'seo_title' => 'required|min_length[3]|max_length[255]',
        'seo_description' => 'required',
    ];

    public $article_errors = [
        'title' => [
            'required' => 'باید عنوان مقاله را وارد کنید',            
            'max_length' => 'طول نام نباید بیشتر از 255 نویسه باشد',
            'is_unique' => 'عنوان مقاله تکراری است',
        ],
        'alt' => [
            'required_with' => 'برای عکس متن جایگزینی وارد نشده است',
            'max_length' => 'متن جایگزین عکس بیشتر از 255 نویسه است',
        ],
        'seo_title' => [
            'required' => 'برای نتایج موتورهای جستجو عنوانی وارد نشده است',
            'min_length' => 'عنوانی که برای نتایج موتورهای جستجو وارد شده کمتر از سه نویسه است',
            'max_length' => 'عنوانی که برای نتایج موتورهای جستجو وارد شده بیشتر از 255 نویسه است',
        ],
        'seo_description' => [
            'required' => 'برای نتایج موتورهای جستجو توضیحات وارد نشده است',
        ],
    ];

}
