<?php

use Mikron\HubBack\Domain\Value\Text;

class TextTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider correctTextDataProvider
     * @param $texts
     * @param $defaultLanguage
     * @param $expectedLanguage
     * @param $expectedReturn
     */
    public function getTextReturnsProperText($texts, $defaultLanguage, $expectedLanguage, $expectedReturn)
    {
        $text = new Text($texts, $defaultLanguage);

        $this->assertEquals($expectedReturn, $text->getText($expectedLanguage));
    }

    public function correctTextDataProvider()
    {
        return [
            [
                [
                    'de' => "Versuchstext",
                    'en' => "Test text",
                    'pl' => "Tekst testowy"
                ],
                'en',
                'en',
                'Test text'
            ],
            [
                [
                    'de' => "Versuchstext",
                    'en' => "Test text",
                    'pl' => "Tekst testowy"
                ],
                'en',
                'de',
                'Versuchstext'
            ],
            [
                [
                    'de' => "Versuchstext",
                    'en' => "Test text",
                    'pl' => "Tekst testowy"
                ],
                'en',
                'ru',
                'Test text'
            ],
        ];
    }

    public function brokenDefaultTextDataProvider()
    {
        return [
            [
                [
                    'de' => "Versuchstext",
                    'en' => "Test text",
                    'pl' => "Tekst testowy"
                ],
                'ru'
            ],
        ];
    }
}