<?php
namespace Intlless;

use Cake\Chronos\MutableDateTime;
use DateTimeInterface;

class Time extends MutableDateTime
{
    public function __construct($time = null, $tz = null)
    {
        if ($time instanceof DateTimeInterface) {
            $tz = $time->getTimeZone();
            $time = $time->format('Y-m-d H:i:s');
        }

        if (is_numeric($time)) {
            $time = '@' . $time;
        }

        parent::__construct($time, $tz);
    }
}
