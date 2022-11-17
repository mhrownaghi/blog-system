<?php $cal = new \App\Libraries\Calendar() ?>
<?= $this->extend('admin/default') ?>
<?= $this->section('content') ?>
<div class="content-header">
    <h1>مقاله‌ها</h1>
    <a href="/admin/articles/new">
        <i class="nf nf-cod-add"></i>
        مقاله جدید
    </a>
</div>
<?php $message = session()->getFlashdata('message') ?>
<?php if ($message) : ?>
    <div class="message <?= $message['type'] ?>">
        <?= $message['content'] ?>
        <i class="nf nf-mdi-close"></i>
    </div>
<?php endif ?>
<div class="toolbar">
    <div class="search">
        <form action="<?= current_url() ?>" method="get">
            <input type="text" name="search" placeholder="جستجو">
            <button class="btn" type="submit">
                <i class="nf nf-fa-search"></i>
                جستجو
            </button>
            <a class="btn" href="/admin/articles">حذف فیلتر</a>
        </form>
    </div>
    <div class="sort select-container">
        <form action="<?= current_url() ?>" method="get">
            <?php if ($search) : ?>
                <input type="hidden" name="search" value="<?= $search ?>">
            <?php endif ?>
            <?php if ($order) : ?>
                <input type="hidden" name="order" value="<?= $order ?>">
            <?php endif ?>
            <?php if ($dir) : ?>
                <input type="hidden" name="dir" value="<?= $dir ?>">
            <?php endif ?>
            <label for="limit">تعداد در هر صفحه</label>
            <select name="limit" id="limit">
                <option value="5" <?= $limit == 5 ? 'selected' : '' ?>>5</option>
                <option value="10" <?= $limit == 10 ? 'selected' : '' ?>>10</option>
                <option value="15" <?= $limit == 15 ? 'selected' : '' ?>>15</option>
                <option value="20" <?= $limit == 20 ? 'selected' : '' ?>>20</option>
                <option value="25" <?= $limit == 25 ? 'selected' : '' ?>>25</option>
                <option value="30" <?= $limit == 30 ? 'selected' : '' ?>>30</option>
            </select>
            <i class="nf nf-fa-caret_down"></i>
        </form>
    </div>
</div>
<div class="responsive-table">
    <table class="table">
        <thead>
            <tr>
                <th class="w-40">
                    <a href="<?= current_url() . '?' . ($search ? 'search=' . $search . '&' : '') . 'order=title' . ($dir === 'ASC' && $order === 'title' ? '&dir=DESC' : '&dir=ASC') ?>">
                        عنوان
                    </a>
                    <?php if ($order === 'title') : ?>
                        <?php if ($dir === 'ASC') : ?>
                            <i class="nf nf-fa-caret_up"></i>
                        <?php else : ?>
                            <i class="nf nf-fa-caret_down"></i>
                        <?php endif ?>
                    <?php endif ?>
                </th>
                <th class="w-20">
                    <a href="<?= current_url() . '?' . ($search ? 'search=' . $search . '&' : '') . 'order=author' . ($dir === 'ASC' && $order === 'author' ? '&dir=DESC' : '&dir=ASC') ?>">
                        نویسنده
                    </a>
                    <?php if ($order === 'author') : ?>
                        <?php if ($dir === 'ASC') : ?>
                            <i class="nf nf-fa-caret_up"></i>
                        <?php else : ?>
                            <i class="nf nf-fa-caret_down"></i>
                        <?php endif ?>
                    <?php endif ?>
                </th>
                <th class="w-20">
                    <a href="<?= current_url() . '?' . ($search ? 'search=' . $search . '&' : '') . 'order=category' . ($dir === 'ASC' && $order === 'category' ? '&dir=DESC' : '&dir=ASC') ?>">
                        دسته‌بندی
                    </a>
                    <?php if ($order === 'category') : ?>
                        <?php if ($dir === 'ASC') : ?>
                            <i class="nf nf-fa-caret_up"></i>
                        <?php else : ?>
                            <i class="nf nf-fa-caret_down"></i>
                        <?php endif ?>
                    <?php endif ?>
                </th>
                <th class="w-20">
                    <a href="<?= current_url() . '?' . ($search ? 'search=' . $search . '&' : '') . 'order=created_at' . ($dir === 'ASC' && $order === 'created_at' ? '&dir=DESC' : '&dir=ASC') ?>">
                        تاریخ ایجاد
                    </a>
                    <?php if ($order === 'created_at') : ?>
                        <?php if ($dir === 'ASC') : ?>
                            <i class="nf nf-fa-caret_up"></i>
                        <?php else : ?>
                            <i class="nf nf-fa-caret_down"></i>
                        <?php endif ?>
                    <?php endif ?>

                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article) : ?>
                <tr class="data">
                    <td><?= $article->title ?></td>
                    <td><?= $article->author ?></td>
                    <td><?= $article->category ?></td>
                    <td>
                        <?php $date_array = date_parse($article->created_at) ?>
                        <?= $cal->gregorianToJalali($date_array['year'], $date_array['month'], $date_array['day'], true) ?>
                    </td>
                </tr>
                <tr class="actions">
                    <td colspan="4">
                        <a href="/admin/articles/edit/<?= $article->id ?>"><i class="nf nf-cod-edit"></i>ویرایش</a>
                        <a href="/admin/articles/remove/<?= $article->id ?>"><i class="nf nf-mdi-delete_forever"></i>حذف</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
<?= $pager->links() ?>
<script>
    document.querySelectorAll('tr.data').forEach((node) => {
        node.addEventListener('click', (event) => {
            event.currentTarget.nextSibling.nextSibling.classList.toggle('active');
        })
    });
    document.querySelector('#limit').addEventListener('change', (event) => {
        event.currentTarget.parentNode.submit();
    });
</script>
<?= $this->endSection() ?>