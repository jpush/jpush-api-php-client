<?php
/**
 * Platform builder
 */

namespace JPush\Push;

use InvalidArgumentException;


/**
 * Device Type specifier.
 *
 * @param args a list of strings as arguments, for each platform.
 * @return array
 * @throws InvalidArgumentException
 */
function deviceTypes()
{
    static $VALID_DEVICE_TYPES = array("ios", "android", "winphone");
    foreach(func_get_args() as $type) {
        if (!in_array($type, $VALID_DEVICE_TYPES)) {
            throw new InvalidArgumentException("Invalid device type: " . $type);
        }
    }
    return func_get_args();
}