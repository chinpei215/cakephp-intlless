<?php
namespace Intlless;

class I18n
{
    public static function translator() {
        return static::getTranslator();
    }

    public static function getTranslator() {
        static $translator;
        if ($translator === null) {
            $translator = new Translator;
        }
        return $translator;
    }
}
