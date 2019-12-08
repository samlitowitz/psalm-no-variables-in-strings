<?php

namespace SamLitowitz\Psalm\Plugin\Tests;

use SamLitowitz\Psalm\Plugin\NoVariablesInStrings;
use SimpleXMLElement;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Psalm\Plugin\RegistrationInterface;

class NoVariablesInStringsTest extends TestCase
{
    /**
     * @var ObjectProphecy
     */
    private $registration;

    /**
     * @return void
     */
    public function setUp()
    {
        $this->registration = $this->prophesize(RegistrationInterface::class);
    }

    /**
     * @test
     * @return void
     */
    public function hasEntryPoint()
    {
        $this->expectNotToPerformAssertions();
        $plugin = new NoVariablesInStrings();
        $plugin($this->registration->reveal(), null);
    }

    /**
     * @test
     * @return void
     */
    public function acceptsConfig()
    {
        $this->expectNotToPerformAssertions();
        $plugin = new NoVariablesInStrings();
        $plugin($this->registration->reveal(), new SimpleXMLElement('<myConfig></myConfig>'));
    }

    /**
     * @return void
     */
    public function detectsVariablesInString()
    {
        $intValue = 1;
        $intValueInString = "Hello $intValue";
        $this->assertNotEmpty($intValueInString);

        $stringValue = "World";
        $stringValueInString = "Hello $stringValue";
        $this->assertNotEmpty($stringValueInString);
    }
}
