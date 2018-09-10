# php验证码

## 依赖
1. gd2 拓展

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
$_SESSION['captcha'] = $captcha->captcha;
header('Content-Length:'. strlen($captcha->content));
header('Content-Type:image/png; charset=utf-8');
echo $captcha->content;
```