<?php

namespace JPush;

use Httpful\Request;
use Httpful\Exception\ConnectionErrorException;
use JPush\Exception\APIConnectionException;
use JPush\Model\PushPayload;
use JPush\Model\ReportResponse;
use JPush\Model\MessageResponse;
use JPush\Model\UserResponse;
use JPush\Model\DeviceResponse;

use InvalidArgumentException;

class JPushClient {
    const PUSH_URL = 'https://api.jpush.cn/v3/push';
    const REPORT_URL = 'https://report.jpush.cn/v2/received';
    const VALIDATE_URL = 'https://api.jpush.cn/v3/push/validate';
    const MESSAGES_URL = 'https://report.jpush.cn/v3/messages';
    const USERS_URL = 'https://report.jpush.cn/v3/users';
    const DEVICES_URL = 'https://device.jpush.cn/v3/devices/{registration_id}';
    const ALL_TAGS_URL = 'https://device.jpush.cn/v3/tags/';
    const IS_IN_TAG_URL = 'https://device.jpush.cn/v3/tags/{tag}/registration_ids/{registration_id}';
    const TAG_URL = 'https://device.jpush.cn/v3/tags/{tag}';
    const ALIAS_URL = 'https://device.jpush.cn/v3/aliases/{alias}';

    const USER_AGENT = 'JPush-API-PHP-Client';
    const CONNECT_TIMEOUT = 5;
    const READ_TIMEOUT = 30;
    const DEFAULT_MAX_RETRY_TIMES = 3;

    public $appKey;
    public $masterSecret;
    public $retryTimes;

    public function __construct($appKey, $masterSecret, $retryTimes=self::DEFAULT_MAX_RETRY_TIMES)
    {
        if (is_null($appKey) || is_null($masterSecret)) {
            throw new InvalidArgumentException("appKey and masterSecret must be set.");
        }

        if (!is_string($appKey) || !is_string($masterSecret)) {
            throw new InvalidArgumentException("Invalid appKey or masterSecret");
        }
        $this->appKey = $appKey;
        $this->masterSecret = $masterSecret;
        $this->retryTimes = $retryTimes;
    }

    public function push() {
        return new PushPayload($this);
    }


    /*----Report API start----*/
    public function report($msg_id) {
        $header = array('User-Agent' => self::USER_AGENT,
            'Connection' => 'Keep-Alive',
            'Charset' => 'UTF-8',
            'Content-Type' => 'application/json');
        $url = self::REPORT_URL . '?msg_ids=' . $msg_id;
        $response = $this->request($url, null, $header, 'GET');
        return new ReportResponse($response);
    }

    public function messages($msg_id) {
        $header = array('User-Agent' => self::USER_AGENT,
            'Connection' => 'Keep-Alive',
            'Charset' => 'UTF-8',
            'Content-Type' => 'application/json');
        $url = self::MESSAGES_URL . '?msg_ids=' . $msg_id;
        $response = $this->request($url, null, $header, 'GET');
        return new MessageResponse($response);
    }

    public function users($time_unit, $start, $duration) {
        $header = array('User-Agent' => self::USER_AGENT,
            'Connection' => 'Keep-Alive',
            'Charset' => 'UTF-8',
            'Content-Type' => 'application/json');
        $url = self::USERS_URL . '?time_unit=' . $time_unit . '&start=' . $start . '&duration=' . $duration;
        $response = $this->request($url, null, $header, 'GET');
        return new UserResponse($response);
    }
    /*----Report API end----*/


    /*----Device API start----*/
    /**
     * 获取指定RegistrationId的所有属性，包含tags, alias。
     * @param $registrationId
     * @return DeviceResponse
     */
    public function getDeviceTagAlias($registrationId) {
        $header = array('User-Agent' => self::USER_AGENT,
            'Connection' => 'Keep-Alive',
            'Charset' => 'UTF-8',
            'Content-Type' => 'application/json');
        $url = str_replace('{registration_id}' , $registrationId, self::DEVICES_URL);
        $response = $this->request($url, null, $header, 'GET');
        return new DeviceResponse($response);
    }

    /**
     * 移除指定RegistrationId的所有tag
     * @param $registrationId
     * @return DeviceResponse
     * @throws \InvalidArgumentException
     */
    public function removeDeviceTag($registrationId) {
        if (is_null($registrationId) || !is_string($registrationId)) {
            throw new InvalidArgumentException("Invalid registrationId string");
        }
        $payload = array('tags'=>'');
        $header = array('User-Agent' => self::USER_AGENT,
            'Connection' => 'Keep-Alive',
            'Charset' => 'UTF-8',
            'Content-Type' => 'application/json');
        $url = str_replace('{registration_id}' , $registrationId, self::DEVICES_URL);
        $response = $this->request($url, json_encode($payload), $header, 'POST');
        return new DeviceResponse($response);
    }

    /**
     * 移除指定RegistrationId的所有alias
     * @param $registrationId
     * @return DeviceResponse
     * @throws \InvalidArgumentException
     */
    public function removeDeviceAlias($registrationId) {
        if (is_null($registrationId) || !is_string($registrationId)) {
            throw new InvalidArgumentException("Invalid registrationId string");
        }
        $payload = array('alias'=>'');
        $header = array('User-Agent' => self::USER_AGENT,
            'Connection' => 'Keep-Alive',
            'Charset' => 'UTF-8',
            'Content-Type' => 'application/json');
        $url = str_replace('{registration_id}' , $registrationId, self::DEVICES_URL);
        $response = $this->request($url, json_encode($payload), $header, 'POST');
        return new DeviceResponse($response);
    }

    /**
     * 更新指定RegistrationId的指定属性，当前支持tags, alias
     * @param $registrationId
     * @param null $alias
     * @param null $addTags
     * @param null $removeTags
     * @return DeviceResponse
     * @throws \InvalidArgumentException
     */
    public function updateDeviceTagAlias($registrationId, $alias = null, $addTags = null, $removeTags = null) {
        $payload = array();

        if (is_null($registrationId) || !is_string($registrationId)) {
            throw new InvalidArgumentException("Invalid registrationId string");
        }

        $aliasIsNull = is_null($alias);
        $addTagsIsNull = is_null($addTags);
        $removeTagsIsNull = is_null($removeTags);

        if ($aliasIsNull && $addTagsIsNull && $removeTagsIsNull) {
            throw new InvalidArgumentException("alias, addTags, removeTags not all null");
        }

        if (!$aliasIsNull) {
            if (is_string($alias)) {
                $payload['alias'] = $alias;
            } else {
                throw new InvalidArgumentException("Invalid alias string");
            }
        }

        $tags = array();

        if (!$addTagsIsNull) {
           if (is_array($addTags)) {
               $tags['add'] = $addTags;
           } else {
               throw new InvalidArgumentException("Invalid addTags array");
           }
        }

        if (!$removeTagsIsNull) {
            if (is_array($removeTags)) {
                $tags['remove'] = $removeTags;
            } else {
                throw new InvalidArgumentException("Invalid removeTags array");
            }
        }

        if (count($tags) > 0) {
            $payload['tags'] = $tags;
        }

        $header = array('User-Agent' => self::USER_AGENT,
            'Connection' => 'Keep-Alive',
            'Charset' => 'UTF-8',
            'Content-Type' => 'application/json');
        $url = str_replace('{registration_id}' , $registrationId, self::DEVICES_URL);
        $response = $this->request($url, json_encode($payload), $header, 'POST');
        return new DeviceResponse($response);
    }

    /**
     * 获取当前应用的所有标签列表
     * @return DeviceResponse
     */
    public function getTags() {
        $header = array('User-Agent' => self::USER_AGENT,
            'Connection' => 'Keep-Alive',
            'Charset' => 'UTF-8',
            'Content-Type' => 'application/json');
        $response = $this->request(self::ALL_TAGS_URL, null, $header, 'GET');
        return new DeviceResponse($response);
    }

    /**
     * 查询某个用户是否在tag下
     * @param $registrationId
     * @param $tag
     * @return DeviceResponse
     * @throws \InvalidArgumentException
     */
    public function isDeviceInTag($registrationId, $tag) {
        if (is_null($registrationId) || !is_string($registrationId)) {
            throw new InvalidArgumentException("Invalid registrationId string");
        }

        if (is_null($tag) || !is_string($tag)) {
            throw new InvalidArgumentException("Invalid tag string");
        }

        $header = array('User-Agent' => self::USER_AGENT,
            'Connection' => 'Keep-Alive',
            'Charset' => 'UTF-8',
            'Content-Type' => 'application/json');

        $url = str_replace('{tag}', $tag, self::IS_IN_TAG_URL);
        $url = str_replace('{registration_id}', $registrationId, $url);
        $response = $this->request($url, null, $header, 'GET');
        return new DeviceResponse($response);
    }

    /**
     * 对指定tag添加或者删除registrationId
     * @param $tag
     * @param null $addDevices
     * @param null $removeDevices
     * @return \Httpful\associative|null|string
     * @throws \InvalidArgumentException
     */
    public function updateTagDevices($tag, $addDevices = null, $removeDevices = null) {
        if (is_null($tag) || !is_string($tag)) {
            throw new InvalidArgumentException("Invalid tag string");
        }

        $addDevicesIsNull = is_null($addDevices);
        $removeDevicesIsNull = is_null($removeDevices);

        if ($addDevicesIsNull && $removeDevicesIsNull) {
            throw new InvalidArgumentException("Either or both addDevices and removeDevices must be set.");
        }

        $registrationId = array();

        if (!$addDevicesIsNull) {
            if (is_array($addDevices)) {
                $registrationId['add'] = $addDevices;
            } else {
                throw new InvalidArgumentException("Invalid addDevices array");
            }
        }

        if (!$removeDevicesIsNull) {
            if (is_array($removeDevices)) {
                $registrationId['remove'] = $removeDevices;
            } else {
                throw new InvalidArgumentException("Invalid removeDevices array");
            }
        }

        $payload = array('registration_ids'=>$registrationId);
        $header = array('User-Agent' => self::USER_AGENT,
            'Connection' => 'Keep-Alive',
            'Charset' => 'UTF-8',
            'Content-Type' => 'application/json');
        $url = str_replace('{tag}', $tag, self::TAG_URL);
        $response = $this->request($url, json_encode($payload), $header, 'POST');
        return new DeviceResponse($response);
    }

    /**
     * 删除指定Tag，以及与其关联的用户之间的关联关系
     * @param $tag
     * @return DeviceResponse
     * @throws \InvalidArgumentException
     */
    public function deleteTag($tag) {
        if (is_null($tag) || !is_string($tag)) {
            throw new InvalidArgumentException("Invalid tag string");
        }

        $header = array('User-Agent' => self::USER_AGENT,
            'Connection' => 'Keep-Alive',
            'Charset' => 'UTF-8',
            'Content-Type' => 'application/json');
        $url = str_replace('{tag}', $tag, self::TAG_URL);
        $response = $this->request($url, null, $header, 'DELETE');
        return new DeviceResponse($response);
    }

    /**
     * 获取指定alias下的用户，最多输出10个
     * @param $alias
     * @param null $platform
     * @return DeviceResponse
     * @throws \InvalidArgumentException
     */
    public function getAliasDevices($alias, $platform = null) {
        if (is_null($alias) || !is_string($alias)) {
            throw new InvalidArgumentException("Invalid alias string");
        }

        $url = str_replace('{alias}', $alias, self::ALIAS_URL);

        if (!is_null($platform)) {
            if (is_array($platform)) {
                $isFirst = true;
                foreach($platform as $item) {
                    if ($isFirst) {
                        $url = $url . '?platform=' . $item;
                        $isFirst = false;
                    } else {
                        $url = $url . ',' . $item;
                    }
                }
            } else {
                throw new InvalidArgumentException("Invalid platform array");
            }
        }

        $header = array('User-Agent' => self::USER_AGENT,
            'Connection' => 'Keep-Alive',
            'Charset' => 'UTF-8',
            'Content-Type' => 'application/json');
        $response = $this->request($url, null, $header, 'GET');
        return new DeviceResponse($response);
    }

    /**
     * 删除指定alias，以及该alias与用户的绑定关系
     * @param $alias
     * @return DeviceResponse
     * @throws \InvalidArgumentException
     */
    public function deleteAlias($alias) {
        if (is_null($alias) || !is_string($alias)) {
            throw new InvalidArgumentException("Invalid alias string");
        }
        $header = array('User-Agent' => self::USER_AGENT,
            'Connection' => 'Keep-Alive',
            'Charset' => 'UTF-8',
            'Content-Type' => 'application/json');
        $url = str_replace('{alias}', $alias, self::ALIAS_URL);
        $response = $this->request($url, null, $header, 'DELETE');
        return new DeviceResponse($response);
    }

    /*----Device API end----*/


    /*----Push API start----*/
    public function sendPush($data) {
        $header = array('User-Agent' => self::USER_AGENT,
            'Connection' => 'Keep-Alive',
            'Charset' => 'UTF-8',
            'Content-Type' => 'application/json');
        return $this->request(self::PUSH_URL, $data, $header, 'POST');
    }

    public function sendValidate($data) {
        $header = array('User-Agent' => self::USER_AGENT,
            'Connection' => 'Keep-Alive',
            'Charset' => 'UTF-8',
            'Content-Type' => 'application/json');
        return $this->request(self::VALIDATE_URL, $data, $header, 'POST');
    }
    /*----Push API end----*/

    public function request($url, $data, $header, $method='POST') {
        $logger = JPushLog::getLogger();
        $logger->debug("Send " . $method, array(
            "method" => $method,
            "uri" => $url,
            "headers" => $header,
            "body" => $data));

        $request = null;
        if ($method === 'POST') {
            $request = Request::post($url);
        } else if ($method == 'DELETE') {
            $request = Request::delete($url);
        } else {
            $request = Request::get($url);
        }

        if (!is_null($data)) {
            $request->body($data);
        }

        $request->addHeaders($header)
            ->authenticateWith($this->appKey, $this->masterSecret)
            ->timeout(self::READ_TIMEOUT);

        $response = null;
        for ($retryTimes=0;;$retryTimes++) {
            try {
                $response = $request->send();
                break;
            } catch (ConnectionErrorException $e) {
                if (strpos($e->getMessage(),'28')) {
                    throw new APIConnectionException("Response timeout. Your request has probably be received by JPUsh Server,please check that whether need to be pushed again.", true);
                }
                if ($retryTimes >= $this->retryTimes) {
                    throw new APIConnectionException("Connect timeout. Please retry later.");
                } else {
                    $logger->debug("Retry again send " . $method, array(
                        "method" => $method,
                        "uri" => $url,
                        "headers" => $header,
                        "body" => $data,
                        "retryTimes" => $retryTimes + 1));
                }
            }
        }
        return $response;

    }







} 