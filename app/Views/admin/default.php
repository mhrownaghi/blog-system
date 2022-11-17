<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog System</title>
  <link rel="stylesheet" href="/admin/css/reset.css">
  <link rel="stylesheet" href="/admin/css/samim.css">
  <link rel="stylesheet" href="/admin/css/nerd-fonts-generated.css">
  <link rel="stylesheet" href="/admin/css/style.css">
  <?php if (($section === 'categories' || $section === 'articles') && ($target === 'new' || $target === 'edit')) : ?>
    <link rel="stylesheet" href="/admin/css/katex.min.css">
    <link rel="stylesheet" href="/admin/css/monokai-sublime.min.css">
    <link rel="stylesheet" href="/admin/css/quill.snow.css">
    <script src="/admin/js/katex.min.js"></script>
    <script src="/admin/js/highlight.min.js"></script>
    <script src="/admin/js/quill.min.js"></script>
  <?php endif ?>
  <script src="/admin/js/main.js" defer="defer"></script>
</head>

<body>
  <div class="sidebar">
    <img class="logo" src="/admin/images/Blog-Category-Icon.png" alt="logo">
    <ul class="navigation">
      <li<?= $section === 'dashboard' ? ' class="active"' : '' ?>>
        <a href="/admin/dashboard">
          <i class="nf nf-fa-home"></i>
          داشبورد
        </a>
        </li>
        <li <?= $section === 'users' ? 'class="active"' : '' ?>>
          <a href="/admin/users">
            <i class="nf nf-fa-users"></i>
            کاربران
          </a>
        </li>
        <li <?= $section === 'articles' ? 'class="active"' : '' ?>>
          <a href="/admin/articles">
            <i class="nf nf-fa-newspaper_o"></i>
            مقالات
          </a>
        </li>
        <li <?= $section === 'categories' ? 'class="active"' : '' ?>>
          <a href="/admin/categories">
            <i class="nf nf-fae-layers"></i>
            دسته‌بندی‌ها
          </a>
        </li>
    </ul>
  </div>
  <div class="main">
    <div class="header">
      <button class="menu" type="button">
        <i class="nf nf-mdi-menu"></i>
      </button>
      <button class="profile" type="button">
        <?= session()->get('user_username') ?>
        <i class="nf nf-fa-angle_down"></i>
      </button>
      <div class="profile-menu hide">
        <ul>
          <li>
            <a href="/logout">
              <i class="nf nf-mdi-exit_to_app"></i>
              خروج
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="content">
      <?= $this->renderSection('content') ?>
    </div>
  </div>
</body>

</html>