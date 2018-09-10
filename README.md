## Requirement
1. gd2 拓展

## Installation

```shell
$ composer require vemce/captcha
```

## Usage

```php
use vemce\captcha\Captcha;

$captcha = new Captcha();
$captcha->make();
session_start();
$_SESSION['captcha'] = $captcha->captcha;
header('Content-Length:'. strlen($captcha->content));
header('Content-Type:image/png; charset=utf-8');
echo $captcha->content;
```