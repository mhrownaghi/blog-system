<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/js/install.js" defer="defer"></script>
    <title>نصب سیستم بلاگ</title>
</head>

<body>
    <h1>نصب سیستم بلاگ</h1>
    <?= session()->getFlashdata('error') ?>
    <?= service('validation')->listErrors() ?>
    <?= form_open('install') ?>
    <?= csrf_field() ?>
    <label for="username">نام کاربری</label>
    <input id="username" type="text" name="username" value="<?= set_value('username') ?>">

    <label for="password">گذرواژه</label>
    <input id="password" type="password" name="password" value="<?= set_value('password') ?>">
    <button id="show-password" type="button">نمایش گذرواژه</button>
    <button type="submit">ثبت کاربر ادمین</button>
    <?= form_close() ?>

</body>

</html>