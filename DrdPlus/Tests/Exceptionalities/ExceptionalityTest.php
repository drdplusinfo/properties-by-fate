<?php
namespace DrdPlus\Tests\Exceptionalities;

use DrdPlus\Exceptionalities\Choices\ExceptionalityChoice;
use DrdPlus\Exceptionalities\Exceptionality;
use DrdPlus\Exceptionalities\Properties\ExceptionalityProperties;
use DrdPlus\Exceptionalities\Fates\ExceptionalityFate;
use Granam\Tests\Tools\TestWithMockery;

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

        self::assertSame($choice, $exceptionality->getExceptionalityChoice());
        self::assertSame($fate, $exceptionality->getExceptionalityFate());
        self::assertSame($properties, $exceptionality->getExceptionalityProperties());
        self::assertNull($exceptionality->getId());
    }

    /**
     * @return ExceptionalityChoice
     */
    private function createExceptionalityChoice()
    {
        return \Mockery::mock(ExceptionalityChoice::class);
    }

    /**
     * @return ExceptionalityFate
     */
    private function createExceptionalityFate()
    {
        return \Mockery::mock(ExceptionalityFate::class);
    }

    /**
     * @return ExceptionalityProperties
     */
    private function createExceptionalityProperties()
    {
        return \Mockery::mock(ExceptionalityProperties::class);
    }

}
