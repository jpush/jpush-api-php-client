<?php

namespace JPush\Model;

use InvalidArgumentException;



function notification($alert=null, $android=null, $ios=null, $winphone=null)
{
    if ($alert == null && $android == null && $ios == null && $winphone == null) {
        throw new InvalidArgumentException("Not all notification args is null");
    }
    $payload = array();
    if (!is_null($alert)) {
         if (!is_string($alert)) {
             throw new InvalidArgumentException("Invalid notification.alert string");
         }
        $payload['alert'] = $alert;
    }

    if (!is_null($android)){
        if (!is_array($android)) {
            throw new InvalidArgumentException("Invalid notification.android");
        }
        $payload['android'] = $android;
    }

    if (!is_null($ios)) {
        if (!is_array($ios)) {
            throw new InvalidArgumentException("Invalid notification.ios");
        }
        $payload['ios'] = $ios;
    }

    if (!is_null($winphone)) {
        if (!is_array($winphone)) {
            throw new InvalidArgumentException("Invalid notification.winphone");
        }
        $payload['winphone'] = $winphone;
    }

    return $payload;
}

function ios($alert, $sound=null, $badge=null, $contentAvailable=null, $extras=null)
{
    if (is_null($alert) || !is_string($alert) || strlen($alert) < 1) {
        throw new InvalidArgumentException("Invalid ios.alert string");
    }
    $payload = array();
    $payload['alert'] = $alert;

    if (!is_null($sound)) {
        if (!is_string($sound)) {
            throw new InvalidArgumentException("Invalid ios.sound string");
        }
        if (strlen($sound) > 0) {
            $payload['sound'] = $sound;
        }
    }

    if (!is_null($badge)) {
        if (!is_int($badge)) {
            throw new InvalidArgumentException("Invalid ios.badge int");
        }
        $payload['badge'] = $badge;
    }

    if (!is_null($contentAvailable)) {
        if (!is_bool($contentAvailable)) {
            throw new InvalidArgumentException("Invalid ios.contentAvailable bool");
        }
        $payload['content-available'] = $contentAvailable;
    }

    if(!is_null($extras)) {
        if (!is_array($extras)) {
            throw new InvalidArgumentException("Invalid ios.extras array");
        }
        if (count($extras) > 0) {
            $payload['extras'] = $extras;
        }
    }

    return $payload;
}

function android($alert, $title=null, $builder_id=null, $extras=null)
{
    if (is_null($alert) || !is_string($alert) || strlen($alert) < 1) {
        throw new InvalidArgumentException("Invalid android.alert string");
    }
    $payload = array();
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
    return $payload;
}

function winphone($alert, $title=null, $_open_page=null, $extras=null)
{
    if (is_null($alert) || !is_string($alert) || strlen($alert) < 1) {
        throw new InvalidArgumentException("Invalid winphone.alert string");
    }

    $payload = array();
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

    return $payload;
}