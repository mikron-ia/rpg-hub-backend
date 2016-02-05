<?php

namespace Mikron\HubBack\Tests;

use Mikron\HubBack\Infrastructure\Security\AuthenticationTokenSimple;
use PHPUnit_Framework_TestCase;

class AuthenticationTokenSimpleTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function emptyTokenNotAllowed()
    {
        $this->setExpectedException('\Mikron\HubBack\Domain\Exception\AuthenticationException');
        AuthenticationTokenSimple::isValid("", "test");
    }

    /**
     * @test
     */
    public function shortTokenNotAllowed()
    {
        $this->setExpectedException('\Mikron\HubBack\Domain\Exception\AuthenticationException');
        AuthenticationTokenSimple::isValid("SHORTY", "test");
    }

    /**
     * @test
     */
    public function noConfigNotAllowed()
    {
        $config = [];

        $this->setExpectedException('\Mikron\HubBack\Domain\Exception\AuthenticationException');
        new AuthenticationTokenSimple($config);
    }

    /**
     * @test
     */
    public function incompleteConfigNotAllowed()
    {
        $config = [
            'simple' => [],
        ];

        $this->setExpectedException('\Mikron\HubBack\Domain\Exception\AuthenticationException');
        new AuthenticationTokenSimple($config);
    }

    /**
     * @test
     */
    public function emptyKeyNotAllowed()
    {
        $config = [
            'simple' => [
                'authenticationKey' => '',
            ],
        ];

        $this->setExpectedException('\Mikron\HubBack\Domain\Exception\AuthenticationException');
        new AuthenticationTokenSimple($config);
    }

    /**
     * @test
     */
    public function shortKeyNotAllowed()
    {
        $config = [
            'simple' => [
                'authenticationKey' => 'SHORTY',
            ],
        ];

        $this->setExpectedException('\Mikron\HubBack\Domain\Exception\AuthenticationException');
        new AuthenticationTokenSimple($config);
    }

    /**
     * @test
     */
    public function checksOutTrue()
    {
        $config = [
            'simple' => [
                'authenticationKey' => '0000000000000000000000000000000000000000',
            ],
        ];

        $token = new AuthenticationTokenSimple($config);
        $this->assertTrue($token->checksOut("0000000000000000000000000000000000000000"));
    }

    /**
     * @test
     */
    public function checksOutFalse()
    {
        $config = [
            'simple' => [
                'authenticationKey' => '0000000000000000000000000000000000000000',
            ],
        ];

        $token = new AuthenticationTokenSimple($config);
        $this->assertFalse($token->checksOut("0000000000000000000000000000000000000001"));
    }

    /**
     * @test
     */
    public function receivedKeyInvalid()
    {
        $config = [
            'simple' => [
                'authenticationKey' => '0000000000000000000000000000000000000000',
            ],
        ];

        $this->setExpectedException('\Mikron\HubBack\Domain\Exception\AuthenticationException');

        $token = new AuthenticationTokenSimple($config);
        $token->checksOut("");
    }

    /**
     * @test
     */
    public function keyIsProvided()
    {
        $config = [
            'simple' => [
                'authenticationKey' => '0000000000000000000000000000000000000000',
            ],
        ];

        $token = new AuthenticationTokenSimple($config);
        $this->assertEquals("0000000000000000000000000000000000000000", $token->provideKey());
    }

    /**
     * @test
     */
    public function methodIsProvided()
    {
        $config = [
            'simple' => [
                'authenticationKey' => '0000000000000000000000000000000000000000',
            ],
        ];

        $token = new AuthenticationTokenSimple($config);
        $this->assertEquals("simple", $token->provideMethod());
    }
}
