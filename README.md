# php验证码生成程序

## 安装

```shell
$ composer require vemce/captcha
```

## 用法

```php
<?php
use vemce\captcha\Captcha;
require 'vendor/autoload.php';

$captcha = new Captcha();
$captcha->make();
session_start();
$_SESSION['captcha'] = [
    'code' => $captcha->captcha,
    'expire' => time() + 300,
];
header('Content-Length:' . strlen($captcha->content));
header('Content-Type:image/png; charset=utf-8');
echo $captcha->content;
```