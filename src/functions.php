<?php
function __($msg, $args = null) {
    $args = func_num_args() === 2 ? (array)$args : array_slice(func_get_args(), 1);

    $n = 0;
    $replace = [];
    $replace['%'] = '%%';
    foreach ($args as $key => $val) {
        $replace['{' . $key .'}'] = '%' . (++$n) . '$s';
    }

    $msg = strtr($msg, $replace);

    return vsprintf($msg, $args);
}

function __n($singular, $plural, $count, $args = null) {
    $count = (int)$count;
    $args = func_num_args() === 4 ? (array)$args : array_slice(func_get_args(), 3);
    $msg = $count === 1 ? $singular : $plural;
    return __($msg, $args);
}

function __d($domain, $msg, $args = null) {
    $args = func_num_args() === 3 ? (array)$args : array_slice(func_get_args(), 2);
    return __($msg, $args);
}

function __x($context, $msg, $args = null) {
    $args = func_num_args() === 3 ? (array)$args : array_slice(func_get_args(), 2);
    return __($msg, $args);
}

function __dx($domain, $context, $msg, $args = null) {
    $args = func_num_args() === 4 ? (array)$args : array_slice(func_get_args(), 3);
    return __($msg, $args);
}

function __dn($domain, $singular, $plural, $count, $args = null) {
    $args = func_num_args() === 5 ? (array)$args : array_slice(func_get_args(), 4);
    return __n($singular, $plural, $count, $args);
}

function __xn($context, $singular, $plural, $count, $args = null) {
    $args = func_num_args() === 5 ? (array)$args : array_slice(func_get_args(), 4);
    return __n($singular, $plural, $count, $args);
}

function __dxn($domain, $context, $singular, $plural, $count, $args = null) {
    $args = func_num_args() === 6 ? (array)$args : array_slice(func_get_args(), 5);
    return __n($singular, $plural, $count, $args);
}
