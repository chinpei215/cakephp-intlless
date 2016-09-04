<?php
namespace Intlless;

class Translator
{
    public function translate($msg, array $args = []) {
        if (isset($args['_count'], $args['_singular']) && $args['_count'] == 1) {
            $msg = $args['_singular'];
        }

        unset($args['_count'], $args['_singular'], $args['_context']);

        $n = 0;
        $replace = [];
        $replace['%'] = '%%';
        foreach ($args as $key => $val) {
            $replace['{' . $key .'}'] = '%' . (++$n) . '$s';
        }

        $msg = strtr($msg, $replace);
        return vsprintf($msg, $args);
    }
}
