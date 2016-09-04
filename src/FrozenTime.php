<?php
namespace Intlless;

use Cake\Chronos\Chronos;
use DateTimeInterface;

class FrozenTime extends Chronos
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
