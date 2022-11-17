<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/site/css/reset.css">
    <link rel="stylesheet" href="/site/css/style.css">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="/categories">دسته‌بندی‌ها</a>
                </li>
            </ul>
        </nav>
        <a href="/">وبلاگ من</a>
    </header>
    <main>
        <?= $this->renderSection('content') ?>
    </main>
</body>

</html>