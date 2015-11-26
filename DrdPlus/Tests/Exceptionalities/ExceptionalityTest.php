<?php
namespace DrdPlus\Tests\Exceptionalities;

use DrdPlus\Exceptionalities\Choices\ExceptionalityChoice;
use DrdPlus\Exceptionalities\Exceptionality;
use DrdPlus\Exceptionalities\ExceptionalityProperties;
use DrdPlus\Exceptionalities\Fates\ExceptionalityFate;
use DrdPlus\Tools\Tests\TestWithMockery;

class ExceptionalityTest extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_use_it()
    {
        $exceptionality = new Exceptionality(
            $choice = $this->createExceptionalityChoice(),
            $fate = $this->createExceptionalityFate(),
            $properties = $this->createExceptionalityProperties()
        );

        $this->assertSame($choice, $exceptionality->getExceptionalityChoice());
        $this->assertSame($fate, $exceptionality->getExceptionalityFate());
        $this->assertSame($properties, $exceptionality->getExceptionalityProperties());
        $this->assertSame(null, $exceptionality->getId());
    }

    /**
     * @return ExceptionalityChoice
     */
    private function createExceptionalityChoice()
    {
        $choice = \Mockery::mock(ExceptionalityChoice::class);

        return $choice;
    }

    /**
     * @return ExceptionalityFate
     */
    private function createExceptionalityFate()
    {
        $choice = \Mockery::mock(ExceptionalityFate::class);

        return $choice;
    }

    /**
     * @return ExceptionalityProperties
     */
    private function createExceptionalityProperties()
    {
        $properties = \Mockery::mock(ExceptionalityProperties::class);

        return $properties;
    }

}
