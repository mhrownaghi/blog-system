<?= $this->extend('admin/default') ?>
<?= $this->section('content') ?>
<div class="content-header">
    <h1>کاربران - <?= $target === 'new' ? 'جدید' : 'ویرایش' ?></h1>
</div>
<?php $message = session()->getFlashdata('message') ?>
<?php if ($message) : ?>
    <div class="message <?= $message['type'] ?>">
        <?= $message['content'] ?>
        <i class="nf nf-mdi-close"></i>
    </div>
<?php endif ?>
<?= service('validation')->listErrors() ?>
<?= form_open(current_url()) ?>
<?= csrf_field() ?>
<?php $condition = isset($user) && $method === 'get' ?>
<fieldset>
    <div class="form-group">
        <label for="name">نام</label>
        <input type="text" name="name" id="name" value="<?= $condition ? $user->name : set_value('name') ?>">
    </div>
    <div class="form-group">
        <label for="email">ایمیل</label>
        <input type="text" name="email" id="email" value="<?= $condition ? $user->email : set_value('email') ?>">
    </div>
    <div class="form-group">
        <label for="username">نام کاربری</label>
        <input type="text" name="username" id="username" value="<?= $condition ? $user->username : set_value('username') ?>">
    </div>
    <div class="form-group">
        <label for="password">گذرواژه</label>
        <input type="password" name="password" id="password" value="<?= set_value('password') ?>">
    </div>
    <div class="form-group">
        <label for="passconf">تکرار گذرواژه</label>
        <input type="password" name="passconf" id="passconf" value="<?= set_value('passconf') ?>">
    </div>
</fieldset>
<button class="submit" type="submit">
    <i class="nf nf-cod-save"></i>
    ذخیره
</button>
<?php if ($target === 'edit') : ?>
    <input type="hidden" name="id" value="<?= $user->id ?? set_value('id') ?>">
<?php endif ?>
<?= form_close() ?>
<?= $this->endSection() ?>