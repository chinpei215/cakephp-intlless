<?php
use Cake\Core\Configure;

class_alias('Intlless\I18n', 'Cake\I18n\I18n');
class_alias('Intlless\Number', 'Cake\I18n\Number');

if (class_exists('Cake\Chronos\Chronos')) {
    class_alias('Cake\Chronos\Chronos', 'Cake\I18n\FrozenTime');
    class_alias('Cake\Chronos\Date', 'Cake\I18n\FrozenDate');
    class_alias('Cake\Chronos\MutableDateTime', 'Cake\I18n\Time');
    class_alias('Cake\Chronos\MutableDate', 'Cake\I18n\Date');
} else {
    class_alias('Carbon\Carbon', 'Cake\I18n\Time');
}
