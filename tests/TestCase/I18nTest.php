<?php
namespace Intlless\Test\TestCase;

use Intlless\I18n;

class I18nTest extends \PHPUnit_Framework_TestCase
{
    public function testFakeTranslator() {
        $translator = I18n::translator();
        $this->assertInstanceOf('Intlless\Translator', $translator);
        $this->assertSame(I18n::translator(), $translator);
    }
}
