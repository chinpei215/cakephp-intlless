<?php
namespace Intlless;

class I18n
{
    public static function translator() {
        static $translator;
        if ($translator === null) {
            $translator = new Translator;
        }
        return $translator;
    }
}
