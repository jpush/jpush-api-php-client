<?php
/**
 * Audience builder
 */

namespace JPush\Push;

use InvalidArgumentException;

function audience(/* args */) {
    $audience = array();

    foreach(func_get_args() as $arr) {
        $audience = array_merge($audience, $arr);
    }

    return $audience;
}

function tag($tags)
{
    if (!is_array($tags)) {
        throw new InvalidArgumentException("tags must be a array");
    }
    for ($i=0; $i<count($tags); $i++) {
        if (!is_string($tags[$i])) {
            throw new InvalidArgumentException("Invalid tags[" . $i . "], tags[" . $i . "] must be a string");
        }
    }
    return array("tag" => $tags);
}

function tag_and($tags_and)
{
    if (!is_array($tags_and)) {
        throw new InvalidArgumentException("tags_and must be a array");
    }
    for ($i=0; $i<count($tags_and); $i++) {
        if (!is_string($tags_and[$i])) {
            throw new InvalidArgumentException("Invalid tags_and[" . $i . "], tags_and[" . $i . "] must be a string");
        }
    }
    return array("tag_and" => $tags_and);
}

function alias($alias)
{
    if (!is_array($alias)) {
        throw new InvalidArgumentException("alias must be a array");
    }
    for ($i=0; $i<count($alias); $i++) {
        if (!is_string($alias[$i])) {
            throw new InvalidArgumentException("Invalid alias[" . $i . "], alias[" . $i . "] must be a string");
        }
    }
    return array("alias" => $alias);
}

function registration_id($registration_id)
{
    if (!is_array($registration_id)) {
        throw new InvalidArgumentException("registration_id must be a array");
    }
    for ($i=0; $i<count($registration_id); $i++) {
        if (!is_string($registration_id[$i])) {
            throw new InvalidArgumentException("Invalid registration_id[" . $i . "], registration_id[" . $i . "] must be a string");
        }
    }
    return array("registration_id" => $registration_id);
}

