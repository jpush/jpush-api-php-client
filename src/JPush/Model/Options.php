<?php

namespace JPush\Model;

use InvalidArgumentException;


const MIN_SENDNO = 100000;
const MAX_SENDNO = 4294967294;

function generateSendno() {
    return rand(MIN_SENDNO, MAX_SENDNO);
}

function options($sendno=null, $time_to_live=null, $override_msg_id=null, $apns_production=null, $big_push_duration=null)
{
    if ($sendno == null && $time_to_live == null && $override_msg_id == null && $apns_production == null && $big_push_duration == null) {
        throw new InvalidArgumentException("Not all options args is null");
    }
    $payload = array();

    if (!is_null($sendno)) {
        if (is_int($sendno)) {
            $payload['sendno'] = $sendno;
        } else {
            throw new InvalidArgumentException("options.sendno must be a int");
        }
    } else {
        $payload['sendno'] = generateSendno();
    }

    if (!is_null($time_to_live)) {
        if (is_int($time_to_live) && $time_to_live >=0 && $time_to_live <= 864000) {
            $payload['time_to_live'] = $time_to_live;
        } else {
            throw new InvalidArgumentException("options.time_to_live must be a int and in [0, 864000]");
        }

    }

    if (!is_null($override_msg_id)) {
        if (is_long($override_msg_id)) {
            $payload['override_msg_id'] = $override_msg_id;
        } else {
            throw new InvalidArgumentException("options.override_msg_id must be a long");
        }
    }

    if (!is_null($apns_production)) {
        if (is_bool($apns_production)) {
            $payload['apns_production'] = $apns_production;
        } else {
            throw new InvalidArgumentException("options.apns_production must be a bool");
        }
    } else {
        $payload['apns_production'] = false;
    }

    if (!is_null($big_push_duration)) {
        if (is_int($big_push_duration) && $big_push_duration >= 0 && $big_push_duration <= 1440) {
            $payload['big_push_duration'] = $big_push_duration;
        } else {
            throw new InvalidArgumentException("options.big_push_duration must be a int and between 0 and 1440");
        }
    }
    return $payload;
}

