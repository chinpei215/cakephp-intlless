<?php
namespace Intlless\Test\TestCase;

class FunctionsTest extends \PHPUnit_Framework_TestCase
{
    public function testFunction() {
        $this->assertEquals('100%', __('100%'));
        $this->assertEquals('100%', __('{0}%', 100));
        $this->assertEquals('A', __('{0}', 'A'));
        $this->assertEquals('B of A', __('{1} of {0}', 'A', 'B'));
        $this->assertEquals('B of A', __('{1} of {0}', ['A', 'B']));
    }

    public function testFunctionD() {
        $this->assertEquals('B of A', __d('cake', '{1} of {0}', 'A', 'B'));
        $this->assertEquals('B of A', __d('cake', '{1} of {0}', ['A', 'B']));
    }

    public function testFunctionDX() {
        $this->assertEquals('B of A', __dx('cake', 'something', '{1} of {0}', 'A', 'B'));
        $this->assertEquals('B of A', __dx('cake', 'something', '{1} of {0}', ['A', 'B']));
    }

    public function testFunctionN() {
        $this->assertEquals('There are a cat', __n('There are {0} cat', 'There are {0} cats', 1, 'a'));
        $this->assertEquals('There are two cats', __n('There are {0} cat', 'There are {0} cats', 2, 'two'));
        $this->assertEquals('There are a cat', __n('There are {0} cat', 'There are {0} cats', 1, ['a']));
        $this->assertEquals('There are two cats', __n('There are {0} cat', 'There are {0} cats', 2, ['two']));
    }

    public function testFunctionDN() {
        $this->assertEquals('There are a cat', __dn('cake', 'There are {0} cat', 'There are {0} cats', 1, 'a'));
        $this->assertEquals('There are two cats', __dn('cake', 'There are {0} cat', 'There are {0} cats', 2, 'two'));
        $this->assertEquals('There are a cat', __dn('cake', 'There are {0} cat', 'There are {0} cats', 1, ['a']));
        $this->assertEquals('There are two cats', __dn('cake', 'There are {0} cat', 'There are {0} cats', 2, ['two']));
    }

    public function testFunctionXN() {
        $this->assertEquals('There are a cat', __dn('some', 'There are {0} cat', 'There are {0} cats', 1, 'a'));
        $this->assertEquals('There are two cats', __dn('some', 'There are {0} cat', 'There are {0} cats', 2, 'two'));
        $this->assertEquals('There are a cat', __dn('some', 'There are {0} cat', 'There are {0} cats', 1, ['a']));
        $this->assertEquals('There are two cats', __dn('some', 'There are {0} cat', 'There are {0} cats', 2, ['two']));
    }

    public function testFunctionDXN() {
        $this->assertEquals('There are a cat', __dxn('cake', 'some', 'There are {0} cat', 'There are {0} cats', 1, 'a'));
        $this->assertEquals('There are two cats', __dxn('cake', 'some', 'There are {0} cat', 'There are {0} cats', 2, 'two'));
        $this->assertEquals('There are a cat', __dxn('cake', 'some', 'There are {0} cat', 'There are {0} cats', 1, ['a']));
        $this->assertEquals('There are two cats', __dxn('cake', 'some', 'There are {0} cat', 'There are {0} cats', 2, ['two']));
    }
}
