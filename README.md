yii2-qiniu-oss
==============
yii2-qiniu-oss

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require --prefer-dist aprsoft/yii2-qiniu-oss "*"
```

or add

```
"aprsoft/yii2-qiniu-oss": "*"
```

to the require section of your `composer.json` file.


Usage
-----

web.php
```php
'qiniuOssImage' => [
    "class" => 'AprSoft\Aliyun\OSS\Image',
    "accessKeyId" => 'xxxxxxxxxxxxxx',
    "accessKeySecret" => 'xxxxxxxx',
    "bucket" => 'xxxxx',
],
'qiniuOssBucket' => [
    "class" => 'AprSoft\Aliyun\OSS\Bucket',
    "accessKeyId" => 'xxxxxxx',
    "accessKeySecret" => 'xxxxxx',
],
```
代码中使用
```php
$bucket = Yii::$app->qiniuOssImage;
$back = $bucket->list();
```
