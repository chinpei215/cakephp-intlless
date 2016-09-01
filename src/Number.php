<?php
namespace Intlless;

class Number
{
    public static function precision($value, $precision = 3, array $options = []) {
        $options = ['precision' => $precision, 'places' => $precision];
        return static::format($value, $options);
    }

    public static function toReadableSize($size) {
        switch (true) {
            case $size < 1024:
                return __dn('cake', '{0} Byte', '{0} Bytes', $size, static::format($size, ['precision' => 0]));
            case round($size / 1024) < 1024:
                return __d('cake', '{0} KB', static::format($size / 1024, ['precision' => 2]));
            case round($size / 1024 / 1024, 2) < 1024:
                return __d('cake', '{0} MB', static::format($size / 1024 / 1024, ['precision' => 2]));
            case round($size / 1024 / 1024 / 1024, 2) < 1024:
                return __d('cake', '{0} GB', static::format($size / 1024 / 1024 / 1024, ['precision' => 2]));
            default:
                return __d('cake', '{0} TB', static::format($size / 1024 / 1024 / 1024 / 1024, ['precision' => 2]));
        }
    }

    public static function toPercentage($value, $precision = 2, array $options = []) {
        $options += ['multiply' => false];
        if ($options['multiply']) {
            $value *= 100;
        }
        return static::precision($value, $precision, $options) . '%';
    }

    public static function format($value, array $options = []) {
        $options += ['before' => '', 'after' => '', 'precision' => null, 'places' => null];

        $p = 0;

        if ($options['precision'] !== null) {
            $value = round($value, $options['precision'], PHP_ROUND_HALF_EVEN);
        }

        if ($options['places'] !== null) {
            $p = $options['places'];
        } else {
            $s = strstr($value, '.');
            $p = ($s === false ? 0 : strlen($s) - 1);
        }

        return $options['before'] . number_format($value, $p) . $options['after'];
    }
}
