<?php

CONST disableSound = "disableSound";
CONST disableBadge = -1;

class PushPayload {

    static $EFFECTIVE_DEVICE_TYPES = array("ios", "android", "winphone");

    private $client;
    private $platform;

    private $audience;
    private $tags;
    private $tagAnds;
    private $alias;
    private $registrationIds;

    private $notificationAlert;
    private $iosNotification;
    private $androidNotification;
    private $winPhoneNotification;
    private $message;
    private $options;

    function __construct($client)
    {
        $this->client = $client;
    }

    public function setPlatform($platform)
    {
        if (is_string($platform) && strcasecmp("all", $platform) === 0) {
            $this->platform = "all";
        } else {
            $args = func_get_args();
            if (count($args) <= 0) {
                throw new InvalidArgumentException("Missing argument for PushPayload::setPlatform()");
            }
            $platform = array();
            foreach($args as $type) {
                $type = strtolower($type);
                if (!in_array($type, PushPayload::$EFFECTIVE_DEVICE_TYPES)) {
                    throw new InvalidArgumentException("Invalid device type: " . $type);
                }
                if (!in_array($type, $platform)) {
                    array_push($platform, $type);
                }
            }
            $this->platform = $platform;
        }
        return $this;
    }

    public function addAllAudience() {
        $this->audience = "all";
        return $this;
    }

    public function addTag($tag) {
        if (is_null($this->tags)) {
            $this->tags = array();
        }

        if (is_array($tag)) {
            foreach($tag as $_tag) {
                if (!is_string($_tag)) {
                    throw new InvalidArgumentException("Invalid tag value");
                }
                if (!in_array($_tag, $this->tags)) {
                    array_push($this->tags, $_tag);
                }
            }
        } else if (is_string($tag)) {
            if (!in_array($tag, $this->tags)) {
                array_push($this->tags, $tag);
            }
        } else {
            throw new InvalidArgumentException("Invalid tag value");
        }

        return $this;

    }

    public function addTagAnd($tag) {
        if (is_null($this->tagAnds)) {
            $this->tagAnds = array();
        }

        if (is_array($tag)) {
            foreach($tag as $_tag) {
                if (!is_string($_tag)) {
                    throw new InvalidArgumentException("Invalid tag_and value");
                }
                if (!in_array($_tag, $this->tagAnds)) {
                    array_push($this->tagAnds, $_tag);
                }
            }
        } else if (is_string($tag)) {
            if (!in_array($tag, $this->tagAnds)) {
                array_push($this->tagAnds, $tag);
            }
        } else {
            throw new InvalidArgumentException("Invalid tag_and value");
        }

        return $this;
    }

    public function addAlias($alias) {
        if (is_null($this->alias)) {
            $this->alias = array();
        }

        if (is_array($alias)) {
            foreach($alias as $_alias) {
                if (!is_string($_alias)) {
                    throw new InvalidArgumentException("Invalid alias value");
                }
                if (!in_array($_alias, $this->alias)) {
                    array_push($this->alias, $_alias);
                }
            }
        } else if (is_string($alias)) {
            if (!in_array($alias, $this->alias)) {
                array_push($this->alias, $alias);
            }
        } else {
            throw new InvalidArgumentException("Invalid alias value");
        }

        return $this;
    }

    public function addRegistrationId($registrationId) {
        if (is_null($this->registrationIds)) {
            $this->registrationIds = array();
        }

        if (is_array($registrationId)) {
            foreach($registrationId as $_registrationId) {
                if (!is_string($_registrationId)) {
                    throw new InvalidArgumentException("Invalid registration_id value");
                }
                if (!in_array($_registrationId, $this->registrationIds)) {
                    array_push($this->registrationIds, $_registrationId);
                }
            }
        } else if (is_string($registrationId)) {
            if (!in_array($registrationId, $this->registrationIds)) {
                array_push($this->registrationIds, $registrationId);
            }
        } else {
            throw new InvalidArgumentException("Invalid registration_id value");
        }

        return $this;
    }

    public function setNotificationAlert($alert) {
        if (!is_string($alert)) {
            throw new InvalidArgumentException("Invalid alert value");
        }
        $this->notificationAlert = $alert;
        return $this;
    }

    public function addIosNotification($alert=null, $sound=null, $badge=null, $content_available=null, $category=null, $extras=null) {
        $ios = array();

        if (!is_null($alert)) {
            if (!is_string($alert)) {
                throw new InvalidArgumentException("Invalid ios alert value");
            }
            $ios['alert'] = $alert;
        }

        if (!is_null($sound)) {
            if (!is_string($sound)) {
                throw new InvalidArgumentException("Invalid ios sound value");
            }
            if ($sound !== disableSound) {
                $ios['sound'] = $sound;
            }
        } else {
            // 默认sound为''
            $ios['sound'] = '';
        }

        if (!is_null($badge)) {
            if (is_string($badge) && !preg_match("/^[+-]{1}[0-9]{1,3}$/", $badge)) {
                if (!is_int($badge)) {
                    throw new InvalidArgumentException("Invalid ios badge value");
                }
            }
            if ($badge != disableBadge) {
                $ios['badge'] = $badge;
            }
        } else {
            // 默认badge为'+1'
            $ios['badge'] = '+1';
        }

        if (!is_null($content_available)) {
            if (!is_bool($content_available)) {
                throw new InvalidArgumentException("Invalid ios content-available value");
            }
            $ios['content-available'] = $content_available;
        }

        if (!is_null($category)) {
            if (!is_string($category)) {
                throw new InvalidArgumentException("Invalid ios category value");
            }
            if (strlen($category)) {
                $ios['category'] = $category;
            }
        }

        if (!is_null($extras)) {
            if (!is_array($extras)) {
                throw new InvalidArgumentException("Invalid ios extras value");
            }
            if (count($extras) <= 0) {
                throw new InvalidArgumentException("Invalid ios extras value");
            }
            $ios['extras'] = $extras;
        }

        $this->iosNotification = $ios;
        return $this;
    }

    public function addAndroidNotification($alert, $title, $builderId, $extras) {
        $android = array();

        if (!is_null($alert) && !is_string($alert)) {
            throw new InvalidArgumentException("Invalid android alert value");
        } else {
            $android['alert'] = $alert;
        }

        if (!is_null($title) && !is_string($title)) {
            throw new InvalidArgumentException("Invalid android title value");
        } else {
            $android['title'] = $title;
        }

        if (!is_null($builderId) && !is_int($builderId)) {
            throw new InvalidArgumentException("Invalid android builder_id value");
        } else {
            $android['builder_id'] = $builderId;
        }

        if (!is_null($extras) && !is_array($extras)) {
            throw new InvalidArgumentException("Invalid android extras value");
        } else {
            $android['extras'] = $extras;
        }

        if (count($android) <= 0) {
            throw new InvalidArgumentException("Invalid android notification");
        }

        $this->androidNotification = $android;
        return $this;
    }

    public function addWinPhoneNotification($alert, $title, $_open_page, $extras) {
        $winPhone = array();

        if (!is_null($alert) && !is_string($alert)) {
            throw new InvalidArgumentException("Invalid winphone notification");
        } else {
            $winPhone['alert'] = $alert;
        }

        if (!is_null($title) && !is_string($title)) {
            throw new InvalidArgumentException("Invalid winphone title notification");
        } else {
            $winPhone['title'] = $title;
        }

        if (!is_null($_open_page) && !is_string($_open_page)) {
            throw new InvalidArgumentException("Invalid winphone _open_page notification");
        } else {
            $winPhone['_open_page'] = $_open_page;
        }

        if (!is_null($extras) && !is_array($extras)) {
            throw new InvalidArgumentException("Invalid winphone extras notification");
        }

        if (count($winPhone) <= 0) {
            throw new InvalidArgumentException("Invalid winphone notification");
        }

        $this->winPhoneNotification = $winPhone;
        return $this;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @param mixed $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }


    public function getJSON() {
        $payload = array();

        // validate platform
        if (is_null($this->platform)) {
            throw new InvalidArgumentException("Platform must be set");
        }
        $payload["platform"] = $this->platform;

        // validate audience
        if (is_null($this->audience)) {
            $audience = array();
            if (!is_null($this->tags)) {
                $audience["tag"] = $this->tags;
            }
            if (!is_null($this->tagAnds)) {
                $audience["tag_and"] = $this->tagAnds;
            }
            if (!is_null($this->alias)) {
                $audience["alias"] = $this->alias;
            }
            if (!is_null($this->registrationIds)) {
                $audience["registration_id"] = $this->registrationIds;
            }
            if (count($audience) <= 0) {
                throw new InvalidArgumentException("Audience must be set");
            }
            $payload["audience"] = $audience;
        } else {
            $payload["audience"] = $this->audience;
        }

        // validate notification
        $notification = array();

        if (!is_null($this->notificationAlert)) {
            $notification['alert'] = $this->notificationAlert;
        }

        if (!is_null($this->androidNotification)) {
            $notification['android'] = $this->androidNotification;
            if (is_null($this->androidNotification['alert'])) {
                if (is_null($this->notificationAlert)) {
                    throw new InvalidArgumentException("Android alert can not be null");
                } else {
                    $notification['android']['alert'] = $this->notificationAlert;
                }
            }
        }

        if (!is_null($this->iosNotification)) {
            $notification['ios'] = $this->iosNotification;
            if (is_null($this->iosNotification['alert'])) {
                if (is_null($this->notificationAlert)) {
                    throw new InvalidArgumentException("Ios alert can not be null");
                } else {
                    $notification['ios']['alert'] = $this->notificationAlert;
                }
            }
        }

        if (!is_null($this->winPhoneNotification)) {
            $notification['winphone'] = $this->winPhoneNotification;
            if (is_null($this->winPhoneNotification['alert'])) {
                if (is_null($this->winPhoneNotification)) {
                    throw new InvalidArgumentException("WinPhone alert can not be null");
                } else {
                    $notification['winphone']['alert'] = $this->winPhoneNotification;
                }
            }
        }

        if (count($notification) > 0) {
            $payload['notification'] = $notification;
        }



        return json_encode($payload);
    }

    public function printJSON() {
        echo $this->getJSON();
        return $this;
    }

    public function send() {

    }

    public function validate() {

    }




}