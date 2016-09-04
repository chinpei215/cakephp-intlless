<?php
namespace Intlless\Test\TestCase;

use Cake\Core\Configure;
use Cake\View\View;
use Cake\View\Helper\TimeHelper;
use Cake\View\Helper\NumberHelper;

use Cake\I18n\I18n;
use Cake\I18n\Number;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\I18n\FrozenTime;
use Cake\I18n\FrozenDate;

class IntegrationTest extends \PHPUnit_Framework_TestCase
{
    public function testClassAlias() {
        $this->assertInstanceOf('Intlless\I18n', new I18n);
        $this->assertInstanceOf('Intlless\Number', new Number);

        if (version_compare(Configure::version(), '3.2.0', '>=')) {
            $this->assertInstanceOf('Cake\Chronos\Chronos', new FrozenTime);
            $this->assertInstanceOf('Cake\Chronos\Date', new FrozenDate);
            $this->assertInstanceOf('Cake\Chronos\MutableDateTime', new Time);
            $this->assertInstanceOf('Cake\Chronos\MutableDate', new Date);
        } else {
            $this->assertInstanceOf('Carbon\Carbon', new Time);
        }
    }

    public function testTimeHelper() {
        $Time = new TimeHelper(new View());
        $this->assertTrue( $Time->wasYesterday('yesterday') );
    }

    public function testNumberHelper() {
        $Number = new NumberHelper(new View());
        $this->assertEquals('1.23', $Number->precision('1.234', 2));
    }

    public function test__() {
        $this->assertEquals('The letter A', __('The letter {0}', ['A']));
    }

    public function test__d() {
        $this->assertEquals('The letter A', __d('domain', 'The letter {0}', ['A']));
    }

    public function test__x() {
        $this->assertEquals('The letter A', __x('context', 'The letter {0}', ['A']));
    }

    public function test__dx() {
        $this->assertEquals('The letter A', __dx('domain', 'context', 'The letter {0}', ['A']));
    }

    public function test__n() {
        $this->assertEquals('The letter A', __n('The letter {0}', 'The letters {0} and {1}', 1, ['A']));
        $this->assertEquals('The letters A and B', __n('The letter {0}', 'The letters {0} and {1}', 2, ['A', 'B']));
    }

    public function test__dn() {
        $this->assertEquals('The letter A', __dn('domain', 'The letter {0}', 'The letters {0} and {1}', 1, ['A']));
        $this->assertEquals('The letters A and B', __dn('domain', 'The letter {0}', 'The letters {0} and {1}', 2, ['A', 'B']));
    }

    public function test__xn() {
        $this->assertEquals('The letter A', __xn('context', 'The letter {0}', 'The letters {0} and {1}', 1, ['A']));
        $this->assertEquals('The letters A and B', __xn('context', 'The letter {0}', 'The letters {0} and {1}', 2, ['A', 'B']));
    }

    public function test__dxn() {
        $this->assertEquals('The letter A', __dxn('domain', 'context', 'The letter {0}', 'The letters {0} and {1}', 1, ['A']));
        $this->assertEquals('The letters A and B', __dxn('domain', 'context', 'The letter {0}', 'The letters {0} and {1}', 2, ['A', 'B']));
    }
}
