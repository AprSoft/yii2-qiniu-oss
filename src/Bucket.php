<?php
namespace AprSoft\QiNiu\OSS;

use Qiniu\Storage\BucketManager;
use Qiniu\Auth;
use Yii;
use yii\base\Component;
use yii\log\Logger;


class Bucket extends Component
{

    public $accessKeyId;

    public $accessKeySecret;

    private $_manager;

    public function getManager()
    {
        if($this->_manager === null){
            $this->setManager(new Auth($this->accessKeyId, $this->accessKeySecret));
        }
        return $this->_manager;
    }

    public function setManager(Auth $auth)
    {
        $this->_manager = new BucketManager($auth);
    }

    public function list()
    {
        try {
             $buckets = $this->manager->buckets();
        } catch (OssException $e) {
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR, 'qiniu-oss');
            return false;
        }
        return $buckets;

    }
}
