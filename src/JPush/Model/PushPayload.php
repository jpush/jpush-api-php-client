<?php
/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-6-9
 * Time: 下午2:06
 */

namespace JPush\Model;


class PushPayload {
    private $client;
    private $platform;
    private $audience;
    private $notification;
    private $message;
    private $options;

    function __construct($client)
    {
        $this->client = $client;
    }

    public function setAudience($audience)
    {
        $this->audience = $audience;
        return $this;
    }

    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    public function setNotification($notification)
    {
        $this->notification = $notification;
        return $this;
    }

    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    public function setPlatform($platform)
    {
        $this->platform = $platform;
        return $this;
    }

    public function getJSON()
    {
        $payload = array(
            'platform' => $this->platform,
            'audience' => $this->audience,
        );

        //TODO validate params legal

        if (!is_null($this->notification))
        {
            $payload['notification'] = $this->notification;
        }
        if (!is_null($this->message))
        {
            $payload['message'] = $this->message;
        }

        if (!is_null($this->options))
        {
            $payload['options'] = $this->options;
        }

        return json_encode($payload);
    }




} 