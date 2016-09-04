<?php
namespace Intlless\Test\TestCase;

use Intlless\Translator;


class TranslatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProviderForTestTranslate
     */
    public function testTranslate($msg, $args, $expected) {
        $translator = new Translator();

        $this->assertEquals($expected, $translator->translate($msg, $args));
    }

    public function dataProviderForTestTranslate() {
        return [
            [
                'The letters {0} and {1}',
                ['A', 'B'],
                'The letters A and B',
            ],
            [
                'The letters {1} and {0}',
                ['A', 'B'],
                'The letters B and A',
            ],
            [
                'The letters {1} and {0}',
                ['A', '_singular' => 'The letter {0}', '_count' => 1],
                'The letter A',
            ],
            [
                'The letters {1} and {0}',
                ['A', 'B', '_singular' => 'The letter {0}', '_count' => 2],
                'The letters B and A',
            ],
        ];
    }
}
