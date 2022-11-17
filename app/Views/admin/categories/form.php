<?= $this->extend('admin/default') ?>
<?= $this->section('content') ?>
<div class="content-header">
    <h1>دسته‌بندی‌ها - <?= $target === 'new' ? 'جدید' : 'ویرایش' ?></h1>
</div>
<?php $message = session()->getFlashdata('message') ?>
<?php if ($message) : ?>
    <div class="message <?= $message['type'] ?>">
        <?= $message['content'] ?>
        <i class="nf nf-mdi-close"></i>
    </div>
<?php endif ?>
<?= service('validation')->listErrors() ?>
<?= form_open_multipart(current_url()) ?>
<?= csrf_field() ?>
<?php $condition = isset($category) && $method === 'get' ?>
<fieldset>
    <div class="form-group">
        <label for="name">نام</label>
        <input type="text" name="name" id="name" value="<?= $condition ? $category->name : set_value('name') ?>">
    </div>
    <div class="form-group checkbox-form-group">
        <label for="published">منتشر شود</label>
        <input type="checkbox" name="published" id="published" <?= ($condition && $category->published) || (!$condition && set_value('published')) ? 'checked' :  '' ?> />
    </div>
    <div class="form-group editor-form-group">
        <label>توضیحات</label>
        <div id="description" class="editor">
            <div id="toolbar-container">
                <span class="ql-formats">
                    <select class="ql-font"></select>
                    <select class="ql-size"></select>
                </span>
                <span class="ql-formats">
                    <button class="ql-bold"></button>
                    <button class="ql-italic"></button>
                    <button class="ql-underline"></button>
                    <button class="ql-strike"></button>
                </span>
                <span class="ql-formats">
                    <select class="ql-color"></select>
                    <select class="ql-background"></select>
                </span>
                <span class="ql-formats">
                    <button class="ql-script" value="sub"></button>
                    <button class="ql-script" value="super"></button>
                </span>
                <span class="ql-formats">
                    <button class="ql-header" value="1"></button>
                    <button class="ql-header" value="2"></button>
                    <button class="ql-blockquote"></button>
                    <button class="ql-code-block"></button>
                </span>
                <span class="ql-formats">
                    <button class="ql-list" value="ordered"></button>
                    <button class="ql-list" value="bullet"></button>
                    <button class="ql-indent" value="-1"></button>
                    <button class="ql-indent" value="+1"></button>
                </span>
                <span class="ql-formats">
                    <button class="ql-direction" value="rtl"></button>
                    <select class="ql-align"></select>
                </span>
                <span class="ql-formats">
                    <button class="ql-link"></button>
                    <button class="ql-image"></button>
                    <button class="ql-video"></button>
                    <button class="ql-formula"></button>
                </span>
                <span class="ql-formats">
                    <button class="ql-clean"></button>
                </span>
            </div>
            <div id="editor-container" class="editor-main"></div>
            <input type="hidden" name="description" id="description-value">
        </div>
    </div>
    <div class="form-group">
        <label for="note">یادداشت</label>
        <input type="text" name="note" id="note" value="<?= $condition ? $category->note : set_value('note') ?>">
    </div>
    <div class="form-group select-container">
        <label for="image">عکس</label>
        <select name="image" id="image" value="<?= $condition ? $category->image : set_value('image') ?>">
            <?php foreach ($files as $file) : ?>
                <option <?= ($condition && $category->image === $file) || (!$condition && set_value('image') === $file) ? 'selected' :  '' ?>><?= $file ?></option>
            <?php endforeach ?>
        </select>
        <i class="nf nf-fa-caret_down"></i>
    </div>
    <div class="form-group">
        <label for="alt">متن جایگزین عکس</label>
        <input type="text" name="alt" id="alt" value="<?= $condition ? $category->alt : set_value('alt') ?>">
    </div>
    <div class="form-group">
        <label for="seo-title">عنوان جستجو</label>
        <input type="text" name="seo_title" id="seo-title" value="<?= $condition ? $category->seo_title : set_value('seo_title') ?>">
    </div>
    <div class="form-group">
        <label for="seo-description">توضیحات جستجو</label>
        <input type="text" name="seo_description" id="seo-description" value="<?= $condition ? $category->seo_description : set_value('seo_description') ?>">
    </div>
</fieldset>
<button class="submit" type="submit">
    <i class="nf nf-cod-save"></i>
    ذخیره
</button>
<div class="form-group upload-form-group">
    <label for="file">آپلود عکس دسته‌بندی</label>
    <input type="file" name="file" id="file" accept="image/png, image/jpeg, image/webp">
</div>
<?php if ($target === 'edit') : ?>
    <input type="hidden" name="id" value="<?= $category->id ?? set_value('id') ?>">
<?php endif ?>
<?= form_close() ?>
<script>
    var quill = new Quill('#editor-container', {
        modules: {
            formula: true,
            syntax: true,
            toolbar: '#toolbar-container'
        },
        placeholder: 'Compose an epic...',
        theme: 'snow'
    });
    let des = '<?= addslashes($condition ? $category->description : set_value('description', '', false)) ?>';
    if (des != "") {
        quill.setContents(JSON.parse(des));
        document.querySelector('#description-value').value = des;
    }
    quill.on('text-change', (delta, oldDelta, source) => {
        document.querySelector('#description-value').value = JSON.stringify(quill.getContents());
    });
    document.querySelector('#file').addEventListener('change', () => {
        files = document.querySelector('#file').files;
        if (files.length !== 0) {
            let option = document.createElement('option');
            option.textContent = document.querySelector('#file').files[0].name;
            document.querySelector('#image').add(option);
            document.querySelector('#image').value = document.querySelector('#file').files[0].name;
        }
    });
</script>
<?= $this->endSection() ?>