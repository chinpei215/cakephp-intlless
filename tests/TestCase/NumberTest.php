<?php
namespace Intless\Test\TestCase;

use Intlless\Number;

class NumberTest extends \PHPUnit_Framework_TestCase
{
    public function testFormat()
    {
        $value = '100100100';

        $result = Number::format($value);
        $expected = '100,100,100';
        $this->assertEquals($expected, $result);

        $result = Number::format($value, ['before' => '#']);
        $expected = '#100,100,100';
        $this->assertEquals($expected, $result);

        $result = Number::format($value, ['places' => 3]);
        $expected = '100,100,100.000';
        $this->assertEquals($expected, $result);

        $value = 0.00001;
        $result = Number::format($value, ['places' => 1, 'before' => '$']);
        $expected = '$0.0';
        $this->assertEquals($expected, $result);

        $value = -0.00001;
        $result = Number::format($value, ['places' => 1, 'before' => '$']);
        $expected = '$-0.0';
        $this->assertEquals($expected, $result);
    }

    public function testPrecision() {
        $result = Number::precision(1);
        $expected = '1.000';
        $this->assertEquals($expected, $result);

        $result = Number::precision(-1);
        $expected = '-1.000';
        $this->assertEquals($expected, $result);

        $result = Number::precision(1.234);
        $expected = '1.234';
        $this->assertEquals($expected, $result);

        $result = Number::precision(1.2345);
        $expected = '1.234';
        $this->assertEquals($expected, $result);

        $result = Number::precision(1, 0);
        $expected = '1';
        $this->assertEquals($expected, $result);

        $result = Number::precision(0.75, 1);
        $expected = '0.8';
        $this->assertEquals($expected, $result);

        $result = Number::precision(0.85, 1);
        $expected = '0.8';
        $this->assertEquals($expected, $result);
    }

    public function testToReadableSize()
    {
        $result = Number::toReadableSize(0);
        $expected = '0 Bytes';
        $this->assertEquals($expected, $result);

        $result = Number::toReadableSize(1);
        $expected = '1 Byte';
        $this->assertEquals($expected, $result);

        $result = Number::toReadableSize(45);
        $expected = '45 Bytes';
        $this->assertEquals($expected, $result);

        $result = Number::toReadableSize(1023);
        $expected = '1,023 Bytes';
        $this->assertEquals($expected, $result);

        $result = Number::toReadableSize(1024);
        $expected = '1 KB';
        $this->assertEquals($expected, $result);

        $result = Number::toReadableSize(1024 + 123);
        $expected = '1.12 KB';
        $this->assertEquals($expected, $result);

        $result = Number::toReadableSize(1024 * 512);
        $expected = '512 KB';
        $this->assertEquals($expected, $result);

        $result = Number::toReadableSize(1024 * 1024 - 1);
        $expected = '1 MB';
        $this->assertEquals($expected, $result);

        $result = Number::toReadableSize(512.05 * 1024 * 1024);
        $expected = '512.05 MB';
        $this->assertEquals($expected, $result);

        $result = Number::toReadableSize(1024 * 1024 * 1024 - 1);
        $expected = '1 GB';
        $this->assertEquals($expected, $result);

        $result = Number::toReadableSize(1024 * 1024 * 1024 * 512);
        $expected = '512 GB';
        $this->assertEquals($expected, $result);

        $result = Number::toReadableSize(1024 * 1024 * 1024 * 1024 - 1);
        $expected = '1 TB';
        $this->assertEquals($expected, $result);

        $result = Number::toReadableSize(1024 * 1024 * 1024 * 1024 * 512);
        $expected = '512 TB';
        $this->assertEquals($expected, $result);

        $result = Number::toReadableSize(1024 * 1024 * 1024 * 1024 * 1024 - 1);
        $expected = '1,024 TB';
        $this->assertEquals($expected, $result);

        $result = Number::toReadableSize(1024 * 1024 * 1024 * 1024 * 1024 * 1024);
        $expected = '1,048,576 TB';
        $this->assertEquals($expected, $result);
    }

    public function testToPercentage()
    {
        $result = Number::toPercentage(45, 0);
        $expected = '45%';
        $this->assertEquals($expected, $result);

        $result = Number::toPercentage(45, 2);
        $expected = '45.00%';
        $this->assertEquals($expected, $result);

        $result = Number::toPercentage(0, 0);
        $expected = '0%';
        $this->assertEquals($expected, $result);

        $result = Number::toPercentage(0, 4);
        $expected = '0.0000%';
        $this->assertEquals($expected, $result);

        $result = Number::toPercentage(45, 0, ['multiply' => false]);
        $expected = '45%';
        $this->assertEquals($expected, $result);

        $result = Number::toPercentage(45, 2, ['multiply' => false]);
        $expected = '45.00%';
        $this->assertEquals($expected, $result);

        $result = Number::toPercentage(0, 0, ['multiply' => false]);
        $expected = '0%';
        $this->assertEquals($expected, $result);

        $result = Number::toPercentage(0, 4, ['multiply' => false]);
        $expected = '0.0000%';
        $this->assertEquals($expected, $result);

        $result = Number::toPercentage(0.456, 0, ['multiply' => true]);
        $expected = '46%';
        $this->assertEquals($expected, $result);

        $result = Number::toPercentage(0.456, 2, ['multiply' => true]);
        $expected = '45.60%';
        $this->assertEquals($expected, $result);
    }
}
