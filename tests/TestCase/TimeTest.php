<?php
namespace Intless\Test\TestCase;

use Intlless\Time;

class TimeTest extends \PHPUnit_Framework_TestCase
{
    public function test__Construct()
    {
        $this->assertInstanceOf('DateTime', new Time);

        // Without @ mark
        $time = new Time('1234567890');
        $this->assertEquals('1234567890', $time->format('U'));

        // DateTime interface
        $time = new Time( new \DateTime('yesterday') );
        $this->assertTrue($time->isYesterday());
    }
}
