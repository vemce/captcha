<?php

/**
 * Created by PhpStorm.
 * User: vemce
 * Date: 2018/8/1
 * Time: 14:23
 */

namespace vemce\captcha;
class Captcha
{
    public $im;
    public $length;
    public $fontSize;
    public $width;
    public $height;
    public $captcha = '';
    public $content = '';
    public $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    /**
     * 生成验证码图片
     * @param int $length
     * @param int $fontSize
     * @param int $pixel
     * @param int $line
     * @param null $file
     */
    public function make($length = 4, $fontSize = 25, $pixel = 5, $line = 3, $file = null)
    {
        $this->length = $length;
        $this->fontSize = $fontSize;
        $this->width = ceil($fontSize * $length * 1.5);
        $this->height = $fontSize * 2;
        $this->im = imagecreatetruecolor($this->width, $this->height);
        $this->captcha = '';
        //为画布定义(背景)颜色
        $bg_color = imagecolorallocate($this->im, mt_rand(170, 250), mt_rand(170, 250), mt_rand(170, 250));
        //填充颜色
        imagefill($this->im, 0, 0, $bg_color);
        $this->writeWords();
        $this->drawPixel($pixel);
        $this->drawLine($line);
        if ($file) {
            imagepng($this->im, $file);
        } else {
            ob_start();
            // 输出图像
            imagepng($this->im);
            $this->content = ob_get_clean();
        }
        imagedestroy($this->im);
    }

    /**
     * 打印文字
     */
    public function writeWords()
    {
        $fontFile = __DIR__ . '/ttfs/' . mt_rand(1, 6) . '.ttf';
        for ($i = 0; $i < $this->length; $i++) {
            // 字体颜色
            $fontColor = imagecolorallocate($this->im, mt_rand(0, 150), mt_rand(0, 150), mt_rand(0, 150));
            // 设置字体内容
            $length = strlen($this->string) - 1;
            $fontContent = substr($this->string, mt_rand(0, $length), 1);
            $this->captcha .= $fontContent;
            $x = ($i * 1.5 * $this->fontSize) + mt_rand(0, floor($this->fontSize / 2));
            $y = $this->fontSize + mt_rand(5, $this->fontSize - 5);
            $fontSize = $this->fontSize + mt_rand(-2, 2);
            // 填充内容到画布中
            imagettftext($this->im, $fontSize, mt_rand(-30, 30), $x, $y, $fontColor, $fontFile, $fontContent);
        }
    }

    /**
     * 画点
     * @param int $pixel
     */
    public function drawPixel($pixel = 5)
    {
        $number = $this->width * $pixel;
        for ($i = 0; $i < $number; $i++) {
            $color = imagecolorallocate($this->im, mt_rand(50, 200), mt_rand(50, 200), mt_rand(50, 200));
            imagesetpixel($this->im, mt_rand(1, $this->width), mt_rand(1, $this->height), $color);
        }
    }

    /**
     * 画干扰线
     * @param int $line
     */
    public function drawLine($line = 3)
    {
        $middle = ceil($this->width / 2);
        $middleH = ceil($this->height / 2);
        for ($i = 0; $i < $line; $i++) {
            $color = imagecolorallocate($this->im, mt_rand(50, 200), mt_rand(50, 200), mt_rand(50, 200));
            imageline($this->im, mt_rand(1, $middle), mt_rand(1, $middleH), mt_rand($middle, $this->width), mt_rand($middleH, $this->height), $color);
        }
    }
}