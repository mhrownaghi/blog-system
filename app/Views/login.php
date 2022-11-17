<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود به سیستم</title>
</head>

<body>
    <h1>ورود به سیستم</h1>
    <?php if (session()->getFlashdata('message')) : ?>
        <div>
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif ?>
    <?= form_open('login') ?>
    <?= csrf_field() ?>
    <label for="username">نام کاربری</label>
    <input type="text" name="username" id="username" value="<?= set_value('username') ?>">
    <label for="password">گذرواژه</label>
    <input type="password" name="password" value="<?= set_value('password') ?>">
    <button>ورود</button>
    <?= form_close() ?>
</body>

</html>