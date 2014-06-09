<?php

namespace JPush\Model;

use InvalidArgumentException;

function message($msg_content, $title=null, $content_type=null, $extras=null)
{
    $payload = array();
    if (is_null($msg_content) || !is_string($msg_content)) {
        throw new InvalidArgumentException("message.msg_content must be a string");
    }
    $payload['msg_content'] = $msg_content;

    if (!is_null($title)) {
        if (!is_string($title)) {
            throw new InvalidArgumentException("message.title must be a string");
        }
        $payload['title'] = $title;
    }

    if (!is_null($content_type)) {
        if (!is_string($content_type)) {
            throw new InvalidArgumentException("message.content_type must be a string");
        }
        $payload['content_type'] = $content_type;
    }

    if (!is_null($extras)) {
        if (!is_array($extras)) {
            throw new InvalidArgumentException("message.extras must be a array");
        }
        $payload['extras'] = $extras;
    }

    return $payload;
}