<?php
namespace Intless\Test\TestCase;

use Intlless\FrozenTime;

class FrozenTimeTest extends \PHPUnit_Framework_TestCase
{
    public function test__Construct()
    {
        $this->assertInstanceOf('DateTimeImmutable', new FrozenTime);

        // Without @ mark
        $time = new FrozenTime('1234567890');
        $this->assertEquals('1234567890', $time->format('U'));

        // DateTime interface
        $time = new FrozenTime( new \DateTime('yesterday') );
        $this->assertTrue($time->isYesterday());
    }
}

