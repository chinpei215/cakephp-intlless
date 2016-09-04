<?php
use Cake\Core\Configure;

if (class_exists('Cake\Chronos\Chronos')) {
    class_alias('Cake\Chronos\Date', 'Cake\I18n\FrozenDate');
    class_alias('Cake\Chronos\MutableDate', 'Cake\I18n\Date');

    class_alias('Intlless\FrozenTime', 'Cake\I18n\FrozenTime');
} else {
    class_alias('Carbon\Carbon', 'Cake\Chronos\MutableDateTime');
}

class_alias('Intlless\I18n', 'Cake\I18n\I18n');
class_alias('Intlless\Number', 'Cake\I18n\Number');
class_alias('Intlless\Time', 'Cake\I18n\Time');
