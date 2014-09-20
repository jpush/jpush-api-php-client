<?php

namespace JPush\Model;

use InvalidArgumentException;

CONST disableSound = "disableSound";
CONST disableBadge = -1;

function notification($alert /* platform notification params */)
{
    $payload = array();
    if (!is_null($alert)) {
         if (!is_string($alert)) {
             throw new InvalidArgumentException("Invalid notification.alert string");
         }
        $payload['alert'] = $alert;
    }
    static $VALID_DEVICE_TYPES = array("ios", "android", "winphone");
    $args = func_get_args();
    for ($i=1; $i<count($args); $i++) {
        $arg = $args[$i];
        $platform = $arg['platform'];
        if (is_array($arg) && in_array($platform, $VALID_DEVICE_TYPES)) {
            unset($arg['platform']);
            $payload[$platform] = $arg;
        }
    }
    if (count($payload) === 0) {
        throw new InvalidArgumentException("Invalid notification");
    }

    return $payload;
}

function ios($alert, $sound=null, $badge=null, $contentAvailable=null, $extras=null)
{
    if (is_null($alert) || !is_string($alert) || strlen($alert) < 1) {
        throw new InvalidArgumentException("Invalid ios.alert string");
    }
    $payload = array();
    // $payload['platform'] = 'ios';
    $payload['alert'] = $alert;

    if (!is_null($sound)) {
        if (!is_string($sound)) {
            throw new InvalidArgumentException("Invalid ios.sound string");
        }
        if ($sound !== disableSound) {
            $payload['sound'] = $sound;
        }
    } else {
        $payload['sound'] = '';
    }

    if (!is_null($badge)) {
        if (is_string($badge) && !preg_match("/^[+-]{1}[0-9]{1,3}$/", $badge)) {
            if (!is_int($badge)) {
                throw new InvalidArgumentException("Invalid ios.badge");
            }
        }
        if ($badge != disableBadge) {
            $payload['badge'] = $badge;
        }
    } else {
        $payload['badge'] = 1;
    }

    if (!is_null($contentAvailable)) {
        if (!is_bool($contentAvailable)) {
            throw new InvalidArgumentException("Invalid ios.contentAvailable bool");
        }
        if ($contentAvailable) {
            $payload['content-available'] = 1;
        }

    }

    if(!is_null($extras)) {
        if (!is_array($extras)) {
            throw new InvalidArgumentException("Invalid ios.extras array");
        }
        if (count($extras) > 0) {
            $payload['extras'] = $extras;
        }
    }

    return array('ios' => $payload);
}

function android($alert, $title=null, $builder_id=null, $extras=null)
{
    if (is_null($alert) || !is_string($alert) || strlen($alert) < 1) {
        throw new InvalidArgumentException("Invalid android.alert string");
    }
    $payload = array();
    // $payload['platform'] = 'android';
    $payload['alert'] = $alert;

    if (!is_null($title)) {
        if (!is_string($title)) {
            throw new InvalidArgumentException("Invalid android.title string");
        }
        if (strlen($title) > 0) {
            $payload['title'] = $title;
        }
    }

    if (!is_null($builder_id)) {
        if (!is_int($builder_id)) {
            throw new InvalidArgumentException("Invalid android.builder_id int");
        }
        $payload['builder_id'] = $builder_id;
    }

    if (!is_null($extras)) {
        if (!is_array($extras)) {
            throw new InvalidArgumentException("Invalid android.extras array");
        }
        if (count($extras) > 0) {
            $payload['extras'] = $extras;
        }
    }
    return array('android' => $payload);
}

function winphone($alert, $title=null, $_open_page=null, $extras=null)
{
    if (is_null($alert) || !is_string($alert) || strlen($alert) < 1) {
        throw new InvalidArgumentException("Invalid winphone.alert string");
    }

    $payload = array();
    // $payload['platform'] = 'winphone';
    $payload['alert'] = $alert;

    if (!is_null($title)) {
        if (!is_string($title)) {
            throw new InvalidArgumentException("Invalid winphone.title string");
        }
        if (strlen($title) > 0) {
            $payload['title'] = $title;
        }
    }

    if (!is_null($_open_page)) {
        if (!is_string($_open_page)) {
            throw new InvalidArgumentException("Invalid winphone._open_page string");
        }
        if (strlen($_open_page) > 0) {
            $payload['_open_page'] = $_open_page;
        }
    }

    if (!is_null($extras)) {
        if (!is_array($extras)) {
            throw new InvalidArgumentException("Invalid winphone.extras array");
        }
        if (count($extras) > 0) {
            $payload['extras'] = $extras;
        }
    }

    return array('winphone' => $payload);
}