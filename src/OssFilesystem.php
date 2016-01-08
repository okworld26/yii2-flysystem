<?php
/**
 * @link https://github.com/okworld26/yii2-flysystem
 * @copyright Copyright (c) 2015 Alexander Kochetov
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace okworld26\flysystem;

use Aliyun\Common\Models\ServiceOptions;
use okworld26\AliyunOss\AliyunOssAdapter;
use Yii;
use yii\base\InvalidConfigException;
use Aliyun\OSS\OSSClient;

/**
 * OssFilesystem
 *
 * @author Tom <okworld26@gmail.com>
 */
class OssFilesystem extends Filesystem
{
    /**
     *
     * @var string
     */
    public $client_key;
    /**
     * @var integer
     */
    public $client_secret;
    /**
     * @var string
     */
    public $endpoint;
    /**
     * @var string bucket name
     */
    public $bucket;




    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->client_key === null) {
            throw new InvalidConfigException('The "client_key" property must be set.');
        }
        if ($this->client_secret === null) {
            throw new InvalidConfigException('The "client_secret" property must be set.');
        }

        parent::init();
    }

    /**
     * @return Oss
     */
    protected function prepareAdapter()
    {
        $config = [];

        /**
         * 获取OSSClient实例用以访问OSS服务
         *
         * @param array $config Client的配置信息，可以包含下列Key：
         * <li> Endpoint(必选) - OSS服务的Endpoint。必须以"http://"开头。
         * <li> AccessKeyId(必选) - 访问OSS的Access Key ID。 </li>
         * <li> AccessKeySecret(必选) -  访问OSS的Access Key Secret。</li>
         *
         * @return OSSClient
         */

        $config[ServiceOptions::ACCESS_KEY_ID] = $this->client_key;
        $config[ServiceOptions::ACCESS_KEY_SECRET] = $this->client_secret;
        $config[ServiceOptions::ENDPOINT] = $this->endpoint;

        $ossClient = OSSClient::factory($config);

        return new AliyunOssAdapter($ossClient,$this->bucket);
    }
}