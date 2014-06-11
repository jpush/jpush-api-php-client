<?php
/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-6-9
 * Time: 下午2:06
 */

namespace JPush\Model;

use InvalidArgumentException;

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
        if (!is_array($message)) {
            throw new InvalidArgumentException("Invalid Message");
        }
        $this->message = $message;
        return $this;
    }

    public function setNotification($notification)
    {
        if (!is_array($notification)) {
            throw new InvalidArgumentException("Invalid Notification");
        }
        $this->notification = $notification;
        return $this;
    }

    public function setOptions($options)
    {
        if (!is_array($options)) {
            throw new InvalidArgumentException("Invalid Options");
        }
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
        if (is_null($this->platform) || is_null($this->audience)) {
            throw new InvalidArgumentException("platform and audience must be set");
        }

        if (is_null($this->notification) && is_null($this->message)) {
            throw new InvalidArgumentException("Either or both notification and message must be set.");
        }

        $payload = array(
            'platform' => $this->platform,
            'audience' => $this->audience,
        );

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

    public function send() {
        echo $this->getJSON() . '<br/>';
        $response = $this->client->sendPush($this->getJSON());
        return new PushResponse($response);
    }




} 