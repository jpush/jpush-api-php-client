<?php
/**
 * Audience builder
 */

namespace JPush\Model;

use InvalidArgumentException;

function audience(/* args */) {
    $audience = array();

    foreach(func_get_args() as $arr) {
        if (!is_array($arr)) {
            throw new InvalidArgumentException("audience's args must be a array");
        }
        $audience = array_merge($audience, $arr);
    }

    return $audience;
}

function tag($tags)
{
    if (!is_array($tags)) {
        throw new InvalidArgumentException("tags must be a array");
    }
    $num = count($tags);
    if ($num < 1) {
        throw new InvalidArgumentException("Length of the tags(Array) must be greater than 0");
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
    $num = count($tags_and);
    if ($num < 1) {
        throw new InvalidArgumentException("Length of the tags_and(Array) must be greater than 0");
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
    $num = count($alias);
    if ($num < 1) {
        throw new InvalidArgumentException("Length of the alias(Array) must be greater than 0");
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
    $num = count($registration_id);
    if ($num < 1) {
        throw new InvalidArgumentException("Length of the registration_id(Array) must be greater than 0");
    }
    for ($i=0; $i<count($registration_id); $i++) {
        if (!is_string($registration_id[$i])) {
            throw new InvalidArgumentException("Invalid registration_id[" . $i . "], registration_id[" . $i . "] must be a string");
        }
    }
    return array("registration_id" => $registration_id);
}

