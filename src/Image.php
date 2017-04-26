<?php
namespace AprSoft\QiNiu\OSS;

use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
use Yii;
use yii\base\Component;
use yii\log\Logger;

class Image extends Component
{
    public $accessKeyId;

    public $accessKeySecret;

    public $bucket;

    private $_bucketManager;
    private $_uploadManager;
    private $_token;

    public function getBucketManager()
    {
        if ($this->_bucketManager === null) {
            $this->setBucketManager(new Auth($this->accessKeyId, $this->accessKeySecret));
        }
        return $this->_bucketManager;
    }

    public function setBucketManager(Auth $auth)
    {
        $this->_bucketManager = new BucketManager($auth);
    }

    public function getToken()
    {
        if ($this->_token === null) {
            $this->setToken(new Auth($this->accessKeyId, $this->accessKeySecret));
        }
        return $this->_token;
    }

    public function setToken(Auth $auth)
    {
        $this->_token = $auth->uploadToken($this->bucket);
    }

    public function getUploadManager()
    {
        if ($this->_uploadManager === null) {
            $this->setUploadManager();
        }
        return $this->_uploadManager;
    }

    public function setUploadManager()
    {
        $this->_uploadManager = new UploadManager();
    }

    public function upload(string $name, string $path, array $params = null, string $mime = 'application/octet-stream', bool $checkCrc = false)
    {
        try {
            $this->uploadManager->putFile($this->token, $name, $path, $params, $mime, $checkCrc);
        } catch (Exception $e) {
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR, 'qiniu-oss');
            return false;
        }
        return true;
    }

    public function files(string $prefix = null, string $marker = null, int $limit = 1000, string $delimiter = null)
    {
        try {
            $list = $this->bucketManager->listFiles($this->bucket, $prefix = null, $marker = null, $limit = 1000, $delimiter = null);
        } catch (Exception $e) {
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR, 'qiniu-oss');
            return false;
        }
        list($files) = $list;
        return $files;
    }

    public function delete(string $name)
    {
        try {
            $this->bucketManager->delete($this->bucket, $name);
        } catch (Exception $e) {
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR, 'qiniu-oss');
            return false;
        }
        return true;
    }

    public function copy(string $name, string $toName, bool $force = false)
    {
        try {
            $this->bucketManager->copy($this->bucket, $name, $this->bucket, $toName, $force);
        } catch (Exception $e) {
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR, 'qiniu-oss');
            return false;
        }
        return true;
    }

    public function rename(string $name, string $toName)
    {
        try {
            $this->bucketManager->rename($this->bucket, $name, $toName);
        } catch (Exception $e) {
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR, 'qiniu-oss');
            return false;
        }
        return true;
    }

}
